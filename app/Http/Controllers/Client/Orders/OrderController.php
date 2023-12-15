<?php

namespace App\Http\Controllers\Client\Orders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function viewOrder(Request $request)
    {
        $id = $request->order_id ?? 0;
        $order = Order::with(['detail'])->find($id);

        $counterCart = 0;
        $total = 0;
        $carts = Session::get('cart') ?? [];
        $collectCart = collect($carts);
        if ($collectCart->count() > 0) {
            $counterCart = $collectCart->sum('qty');
            $total = $collectCart->sum('total');
        }

        return view('client.order.view-order', [
            "order" => $order,
            'carts' => $counterCart,
            'total' => $total
        ]);
    }
}
