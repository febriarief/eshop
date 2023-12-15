<?php

namespace App\Http\Controllers\Client\Cart;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
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

        return view('client.cart.cart', [
            'products' => $carts,
            'carts'    => $counterCart,
            'total'    => $total
        ]);
    }

    public function addToCart(Request $request)
    {
        $input = $request->only(['product_id', 'qty']);
        $carts = [];

        if (isset($input['product_id'])) {
            $input['qty'] = $input['qty'] ?? 1;

            $carts = Session::get('cart') ?? [];
            $findProductIndex = function ($productId) use ($carts) {
                return array_search($productId, array_column($carts, 'id'));
            };
            $productIndex = $findProductIndex($input['product_id']);
            if ($productIndex !== false) {
                $carts[$productIndex]['qty'] += $input['qty'];
                $carts[$productIndex]['total'] = $carts[$productIndex]['qty'] * $carts[$productIndex]['price'];
            } else {
                $product = Product::find($input['product_id']);
                $carts[] = [
                    'id'    => $product->id,
                    'name'  => $product->name,
                    'image' => $product->image,
                    'price' => $product->price,
                    'qty'   => $input['qty'],
                    'total' => $input['qty'] * $product->price
                ];
            }

            Session::put('cart', $carts);
            return redirect()->back()->with('message', 'Produk berhasil ditambahkan ke keranjang');
        }

        return redirect()->back();
    }

    public function deleteCart(Request $request)
    {
        $productId = $request->product_id ?? null;

        if (!$productId) {
            return redirect()->back();
        }

        $carts = Session::get('cart') ?? [];
        $findProductIndex = function ($productId) use ($carts) {
            return array_search($productId, array_column($carts, 'id'));
        };
        $productIndex = $findProductIndex($productId);

        if ($productIndex !== false) {
            array_splice($carts, $productIndex, 1);
            Session::put('cart', $carts);
            return redirect()->back()->with('message', 'Produk berhasil dihapus.');
        }
    }
}
