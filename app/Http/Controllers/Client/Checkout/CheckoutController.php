<?php

namespace App\Http\Controllers\Client\Checkout;

use App\Http\Controllers\Controller;
use App\Mail\OrderPlacedMail;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $counterCart = 0;
        $total = 0;
        $carts = Session::get('cart') ?? [];
        $collectCart = collect($carts);
        if ($collectCart->count() > 0) {
            $counterCart = $collectCart->sum('qty');
            $total = $collectCart->sum('total');
        }

        return view('client.checkout.checkout', [
            'carts'     => $counterCart,
            'products'  => $carts,
            'total'     => $total
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $rules = [
            'customer_name'    => 'required',
            'customer_address' => 'required',
            'customer_email'   => 'required|email'
        ];
        $errorMessages = [
            'customer_name.required'    => 'Kolom isian nama tidak boleh kosong.',
            'customer_address.required' => 'Kolom isian alamat tidak boleh kosong.',
            'customer_email.required'   => 'Kolom isian email tidak boleh kosong.',
            'customer_email.email'      => 'Kolom isian email harus berupa email.',
        ];

        $validator = Validator::make($input, $rules, $errorMessages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors(['msg' => $validator->errors()->first()])->withInput($request->input());
        }

        try {
            DB::beginTransaction();

            $products = Session::get('cart') ?? [];
            $total = 0;
            $details = [];
            foreach ($products as $k => $v) {
                $product = Product::find($v['id']);

                $details[$k]['product_name']  = $product->name ?? null;
                $details[$k]['product_price'] = $product->price ?? null;
                $details[$k]['product_image'] = $product->image ?? null;
                $details[$k]['qty']           = $v['qty'] ?? 1;
                $details[$k]['total']         = $product->price * $v['qty'];

                $total += $details[$k]['total'];
            }

            $id = Order::generateId();
            $order = Order::create([
                'id'                => $id,
                'customer_name'     => $input['customer_name'],
                'customer_address'  => $input['customer_address'],
                'customer_email'    => $input['customer_email'],
                'status'            => 'PENDING',
                'total'             => $total
            ]);

            $order->detail()->createMany($details);

            DB::commit();

            Mail::to($order->customer_email)->send(new OrderPlacedMail($order));
            Session::remove('cart');

            return redirect('/')->with('message', 'Pesanan Anda kami terima. Silahkan cek email untuk melihat detail.');
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
