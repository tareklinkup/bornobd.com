<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InvoiceController extends Controller
{

    public function invoice($id)
    {
        $order = Order::where('id', $id)->first();
        return view('admin.order.invoice', compact('order'));
    }
}
