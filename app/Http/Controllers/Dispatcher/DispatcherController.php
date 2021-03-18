<?php

namespace App\Http\Controllers\Dispatcher;

use App\Http\Controllers\Controller;
use App\Mail\ClientOrderStart;
use App\Models\Cargo;
use App\Models\CargoOrder;
use App\Models\CellCargo;
use App\Models\Order;
use App\Models\QueueWarehouse;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Mail;

class DispatcherController extends Controller
{

    public function mapPage()
    {

        return view('dispatcher.map');
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

        if ($status_id === 9) {
            Mail::send(new ClientOrderStart(\Auth::user()));
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

    public function getAllOrders()
    {

        $allOrders = [];
        $startOrders = Order::query()
            ->join('users as driver', 'driver.id', '=', 'orders.driver_id')
            ->select(['orders.order_id as order_id', 'driver.phone as driver_phone', 'orders.document', 'orders.arrival_at'])
            ->where('status_id', '=', 1)
            ->get()->toArray();

        foreach($startOrders as $key => $order) {
            $startOrders[$key]['cargos'] = CargoOrder::query()
                ->join('cargos', 'cargos.cargo_id', '=', 'cargo_orders.cargo_id')
                ->join('cell_cargos', 'cell_cargos.cargo_id', '=', 'cargos.cargo_id')
                ->join('cells', 'cells.cell_id', '=', 'cell_cargos.cell_id')
                ->join('warehouses', 'warehouses.warehouse_id', '=', 'cells.warehouse_id')
                ->select(['cargo_orders.cargo_id', 'cargos.barcode', 'cargos.weight', 'cells.warehouse_id', 'warehouses.title as warehouse_title', 'cargo_orders.hasShip'])
                ->where('order_id', '=', $order['order_id'])
                ->get()->toArray();
            $startOrders[$key]['progress'] = 0;
        }

        $allOrders['startOrders'] = $startOrders;
        $allOrders['checkpointOrder'] = $this->getCheckpointOrder();
        $allOrders['endOrders'] = $this->getEndOrders();
        $allOrders['betweenOrders'] = $this->getBetweenOrders();
        $allOrders['craneOrders'] = $this->getCraneOrders();

        return $allOrders;
    }

    private function getCheckpointOrder()
    {
        $order = Order::query()
            ->join('users as driver', 'driver.id', '=', 'orders.driver_id')
            ->select(['orders.order_id as order_id', 'driver.phone as driver_phone', 'orders.document', 'orders.arrival_at', 'orders.status_id'])
            ->whereIn('status_id', [2, 8])
            ->first();
        if (!is_null($order)) {
            $order['cargos'] = CargoOrder::query()
                ->join('cargos', 'cargos.cargo_id', '=', 'cargo_orders.cargo_id')
                ->join('cell_cargos', 'cell_cargos.cargo_id', '=', 'cargos.cargo_id')
                ->join('cells', 'cells.cell_id', '=', 'cell_cargos.cell_id')
                ->join('warehouses', 'warehouses.warehouse_id', '=', 'cells.warehouse_id')
                ->select(['cargo_orders.cargo_id', 'cargos.barcode', 'cargos.weight', 'cells.warehouse_id', 'warehouses.title as warehouse_title', 'cargo_orders.hasShip'])
                ->where('order_id', '=', $order['order_id'])
                ->get()->toArray();

            $order['progress'] = 0;
        }

        return $order;
    }

    private function getEndOrders()
    {
        $orders = Order::query()
            ->join('users as driver', 'driver.id', '=', 'orders.driver_id')
            ->select(['orders.order_id as order_id', 'driver.phone as driver_phone', 'orders.document', 'orders.arrival_at'])
            ->where('status_id', '=', 7)
            ->get()->toArray();

        foreach($orders as $key => $order) {
            $orders[$key]['cargos'] = CargoOrder::query()
                ->join('cargos', 'cargos.cargo_id', '=', 'cargo_orders.cargo_id')
                ->join('cell_cargos', 'cell_cargos.cargo_id', '=', 'cargos.cargo_id')
                ->join('cells', 'cells.cell_id', '=', 'cell_cargos.cell_id')
                ->join('warehouses', 'warehouses.warehouse_id', '=', 'cells.warehouse_id')
                ->select(['cargo_orders.cargo_id', 'cargos.barcode', 'cargos.weight', 'cells.warehouse_id', 'warehouses.title as warehouse_title', 'cargo_orders.hasShip'])
                ->where('order_id', '=', $order['order_id'])
                ->get()->toArray();
            $orders[$key]['progress'] = 0;
        }

        return $orders;
    }

    private function getBetweenOrders()
    {

        $orders = Order::query()
            ->join('users as driver', 'driver.id', '=', 'orders.driver_id')
            ->select(['orders.order_id as order_id', 'driver.phone as driver_phone', 'orders.document', 'orders.arrival_at', 'orders.status_id'])
            ->whereIn('status_id', [3, 6])
            ->get()->toArray();

        foreach($orders as $key => $order) {
            $orders[$key]['cargos'] = CargoOrder::query()
                ->join('cargos', 'cargos.cargo_id', '=', 'cargo_orders.cargo_id')
                ->join('cell_cargos', 'cell_cargos.cargo_id', '=', 'cargos.cargo_id')
                ->join('cells', 'cells.cell_id', '=', 'cell_cargos.cell_id')
                ->join('warehouses', 'warehouses.warehouse_id', '=', 'cells.warehouse_id')
                ->select(['cargo_orders.cargo_id', 'cargos.barcode', 'cargos.weight', 'cells.warehouse_id', 'warehouses.title as warehouse_title', 'cargo_orders.hasShip'])
                ->where('order_id', '=', $order['order_id'])
                ->get()->toArray();
            $orders[$key]['progress'] = 0;
        }

        return $orders;
    }

    private function getCraneOrders()
    {
        $warehouses = Warehouse::join('employee_warehouses', 'warehouses.warehouse_id', '=', 'employee_warehouses.warehouse_id')
            ->join('users', 'users.id', '=', 'employee_warehouses.user_id')
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
                        ->select(['cargo_orders.cargo_id', 'cargos.weight', 'cells.warehouse_id', 'cargos.barcode', 'warehouses.title as warehouse_title', 'cargo_orders.hasShip'])
                        ->get()->toArray();
            }
        }

        return $craneOrders;
    }
}
