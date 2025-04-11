<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Devrabiul\ToastMagic\Facades\ToastMagic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display cart contents.
     */
    public function index()
    {
        $cart = Auth::user()->cart()->first();

        if (!$cart || !$cart->products) {
            return view('cart', ['products' => collect()]);
        }

        $productIds = json_decode($cart->products, true);
        $products = Product::whereIn('id', $productIds)->get();

        return view('cart', compact('products', 'cart'));
    }

    /**
     * Store a new product in the cart or update existing cart.
     */
    public function store(Request $request)
    {
        if (!Auth::user()) {
            ToastMagic::error('Please login to add products to your cart.');
            return redirect()->route('login');
        } else {
            $user = Auth::user();
            $productId = $request->input('product_id');
            $product = Product::findOrFail($productId);

            // Fetch or create the cart for the user
            $cart = $user->cart()->first();

            if (!$cart) {
                $cart = new Cart();
                $cart->user_id = $user->id;
                $cart->products = json_encode([$productId]);
                $cart->quantity = 1;
                $cart->total = $product->price;
            } else {
                $productIds = json_decode($cart->products, true);

                // Avoid duplicate entries unless allowed
                $productIds[] = $productId;

                $cart->products = json_encode($productIds);
                $cart->quantity = count($productIds);

                $total = 0;
                foreach ($productIds as $id) {
                    $p = Product::find($id);
                    if ($p) {
                        $total += $p->price;
                    }
                }
                $cart->total = $total;
            }

            $cart->save();

            ToastMagic::success('Product added to cart successfully!');
            return redirect()->route('home');
        }
    }

    /**
     * (Optional) Remove a specific product from cart.
     */
    public function destroy($productId)
    {
        $user = Auth::user();
        $cart = $user->cart()->first();

        if (!$cart)
            return back();

        $productIds = json_decode($cart->products, true);
        $productIds = array_filter($productIds, fn($id) => $id != $productId);

        $cart->products = json_encode(array_values($productIds));
        $cart->quantity = count($productIds);

        // Recalculate total
        $total = 0;
        foreach ($productIds as $id) {
            $product = Product::find($id);
            if ($product) {
                $total += $product->price;
            }
        }
        $cart->total = $total;

        $cart->save();

        ToastMagic::success('Product removed from cart.');
        return back();
    }
}
