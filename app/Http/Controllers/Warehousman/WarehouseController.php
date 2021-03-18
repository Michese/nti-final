<?php

namespace App\Http\Controllers\Warehousman;

use App\Http\Controllers\Controller;
use App\Mail\ClientOrderStart;
use App\Models\CargoOrder;
use App\Models\CellCargo;
use App\Models\Order;
use App\Models\QueueWarehouse;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Mail;

class WarehouseController extends Controller
{

    public function map()
    {
        return view('warehousman.map');
    }

    public function getAllOrders()
    {

        $warehouses = Warehouse::join('employee_warehouses', 'warehouses.warehouse_id', '=', 'employee_warehouses.warehouse_id')
            ->join('users', 'users.id', '=', 'employee_warehouses.user_id')
            ->where('employee_warehouses.user_id', '=', \Auth::user()->id)
            ->select(['warehouses.warehouse_id', 'users.phone', 'warehouses.title'])->get();
        $craneOrders = [];
        foreach ($warehouses as $warehouse) {
            $craneOrders[$warehouse->warehouse_id] = [
                'title' => $warehouse->title,
                'employee_phone' => $warehouse->phone,
                'orders' => Warehouse::query()
                    ->where('warehouses.warehouse_id', '=', $warehouse->warehouse_id)
                    ->whereIn('status_id', [4, 5])
                    ->join('queue_warehouses as queue', 'warehouses.warehouse_id', '=', 'queue.warehouse_id')
                    ->join('orders', 'queue.order_id', '=', 'orders.order_id')
                    ->join('users', 'users.id', '=', 'orders.driver_id')
                    ->select(['orders.document as document', 'orders.arrival_at as arrival_at', 'orders.order_id', 'orders.status_id', 'users.phone as driver_phone'])
                    ->get()->toArray()
            ];

            foreach ($craneOrders[$warehouse->warehouse_id]['orders'] as $key => $order) {
                $craneOrders[$warehouse->warehouse_id]['orders'][$key]["cargos"] =
                    CargoOrder::query()
                        ->join('cargos', 'cargos.cargo_id', '=', 'cargo_orders.cargo_id')
                        ->join('cell_cargos', 'cell_cargos.cargo_id', '=', 'cargos.cargo_id')
                        ->join('cells', 'cells.cell_id', '=', 'cell_cargos.cell_id')
                        ->join('warehouses', 'warehouses.warehouse_id', '=', 'cells.warehouse_id')
                        ->where('order_id', '=', $order['order_id'])
                        ->select(['cargo_orders.cargo_id', 'cargos.weight', 'cells.warehouse_id', 'cargos.barcode', 'warehouses.title as warehouse_title'])
                        ->get()->toArray();
            }
        }

        return $craneOrders;
    }

    public function changeStatus(Request $request)
    {

        $order_id = (int)$request->get('order_id');
        $status_id = (int)$request->get('status_id');
        $order = Order::where('order_id', '=', $order_id)->first();
        $order->status_id = $status_id;
        $order->save();

        if ($status_id === 6) {
            $queueWarehouse = QueueWarehouse::where('order_id', '=', $order_id)->first();
            $queueWarehouse->delete();
        }
    }

    public function moveToWarehouse(Request $request)
    {
        $order_id = (int)$request->get('order_id');
        $warehouse_id = (int)$request->get('warehouse_id');

        $order = Order::where('order_id', '=', $order_id)->first();
        $order->status_id = 4;
        $order->save();

        QueueWarehouse::create([
            'order_id' => $order_id,
            'warehouse_id' => $warehouse_id
        ]);
    }

    public function shiped(Request $request)
    {
        $cargo_id = (int)$request->get('cargo_id');
        $cargo = CargoOrder::where('cargo_id', '=', $cargo_id)->first();
        $cargo->hasShip = 1;
        $cargo->save();

        $cellCargo = CellCargo::where('cargo_id', '=', $cargo_id)->first();
        $cellCargo->delete();

    }

}
