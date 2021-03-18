<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function orderStatusPage()
    {
        $driverOrders = \Auth::user()->driverOrders()->paginate(5);
        return view('driver.orderStatus')
            ->with('driverOrders', $driverOrders);
    }

    public function orderStatus()
    {
        return view('driver.orderStatus')
            ->with('success', 'success');
    }
}
