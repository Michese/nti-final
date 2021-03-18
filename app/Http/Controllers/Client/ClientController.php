<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\ClientOrderStart;
use App\Mail\DriverOrderStart;
use App\Mail\VerifyMail;
use App\Models\Card;
use App\Models\Cargo;
use App\Models\CargoOrder;
use App\Models\Nomenclature;
use App\Models\Order;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Mail;
use mysql_xdevapi\Collection;

class ClientController extends Controller
{

    public function orderPage(Nomenclature $nomenclature)
    {
        $nomenclatures = $nomenclature->getAllNomenclatures();
        return view('client.order')
            ->with([
                'nomenclatures' => $nomenclatures
            ]);
    }

    public function cardPage()
    {
        $cards = \Auth::user()->cards()->get();

        return view('client.card')
            ->with([
                'cards' => $cards
            ]);
    }

    public function orderStatus()
    {
        $clientOrders = CargoOrder::query()
            ->join('cargos', 'cargos.cargo_id', '=', 'cargo_orders.cargo_id')
            ->join('orders', 'orders.order_id', '=', 'cargo_orders.order_id')
            ->join('statuses', 'statuses.status_id', '=', 'orders.status_id')
            ->join('nomenclatures', 'nomenclatures.nomenclature_id', '=', 'cargos.nomenclature_id')
            ->join('users as drivers', 'drivers.id', '=', 'orders.driver_id')
            ->select(['nomenclatures.number as number', 'nomenclatures.body as body',
                'statuses.title as status', 'cargos.weight as weight', 'cargos.barcode as barcode',
                'orders.arrival_at as arrival_at', 'drivers.phone as driver_phone'])
            ->paginate(10);

//        $clientOrders = \Auth::user()->clientOrders()->paginate(1);
        return view('client.orderStatus')->with('clientOrders', $clientOrders);
    }

    public function addOrder(Request $request)
    {
        $nomenclature = Nomenclature::where('nomenclature_id', '=', $request->post('nomenclature_id'))->first();
        $quantity = $request->post('quantity');
        if ($nomenclature->cargos()->count() < $quantity) {
            return "Товара на складе не достаточно!";
        }

        $card = Card::where('user_id', '=', \Auth::user()->id)
            ->where('nomenclature_id', '=', $nomenclature->nomenclature_id)
            ->first();


        if ($card) {
            $card->quantity = $quantity;
            $card->save();
        } else {
            Card::create([
                'user_id' => \Auth::user()->id,
                'nomenclature_id' => $nomenclature->nomenclature_id,
                'quantity' => $quantity
            ]);
        }

        return "Товар добавлен в заказ!";
    }

    public function createOrder()
    {
        $amount = 0;
        $hasOrder = false;
        $cards = \Auth::user()->cards()->get();
        foreach ($cards as $card) {
            $quantity = $card->quantity;
            $amount += $quantity * $card->nomenclature()->first()->cargos()->avg('weight');
        }

        for ($countOrder = 0; $countOrder < ceil($amount / 10); $countOrder++) {
            $order = new Order();
            $drivers = User::where('role_id', '=', 4)->get();
            $currentDriver = new User();
            foreach ($drivers as $driver) {
                if (is_null($driver->driverOrders()->first())) {
                    $arrival_at = is_null(Order::latest('arrival_at')->first())? now() : new Carbon(Order::latest('arrival_at')->first()->arrival_at);

                    $arrival_at = $arrival_at->setMinutes($arrival_at->minute + 5);
                    $currentDriver = $driver;
                    $order->fill([
                        'document' => \Str::random(random_int(5, 15)),
                        'client_id' => \Auth::user()->id,
                        'driver_id' => $driver->id
                    ]);
                    $order->arrival_at = $arrival_at;
                    $order->save();
                    break;
                }
            }

            if (is_null($order->order_id)) {
                if ($hasOrder) {
                    Mail::send(new ClientOrderStart(\Auth::user()));
                }
                return "Нет свободных водителей!";
            }

            $summ = 0.0;

            foreach ($cards as $card) {
                $cargos = $card->nomenclature()->first()->cargos()->get();
                $quantity = $card->quantity;
                $flag = false;

                for ($count = 0; $count < $quantity && $summ <= 10.0; $count++) {
                    try {
                        if ($summ + $cargos[$count]->weight > 10.0) {
                            $flag = true;
                            break;
                        }
                        CargoOrder::create([
                            "order_id" => $order->order_id,
                            "cargo_id" => $cargos[$count]->cargo_id
                        ]);
                        $hasOrder = true;
                        $summ += $cargos[$count]->weight;
                        $card->quantity--;
                    } catch (\Exception $exp) {
                        $quantity++;
                    }
                }

                if ($card->quantity > 0) {
                    $card->save();
                } else {
                    $card->delete();
                }

                if ($flag) {
                    break;
                }
            }
            Mail::send(new DriverOrderStart($currentDriver, $order));

        }

        if ($hasOrder) {
            Mail::send(new ClientOrderStart(\Auth::user()));
            return "Ваш заказ успешно оформлен!";
        }

        return "Ваш заказ пуст!";
    }


}
