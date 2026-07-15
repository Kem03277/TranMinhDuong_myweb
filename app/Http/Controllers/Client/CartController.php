<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += (int) $item['price'] * (int) $item['quantity'];
        }

        return view('client.cart.index', compact('cart', 'total'));
    }

    public function add(Request $request)
    {
        $product = Product::find($request->input('product_id'));
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Sản phẩm không tồn tại.']);
        }

        $cart = Session::get('cart', []);
        $id = $product->id;

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += 1;
        } else {
            $cart[$id] = [
                'productid' => $product->id,
                'proname' => $product->productname,
                'quantity' => 1,
                'price' => (int) $product->price,
            ];
        }

        Session::put('cart', $cart);
        $count = collect($cart)->sum('quantity');

        return response()->json([
            'success' => true,
            'message' => 'Đã thêm vào giỏ hàng.',
            'count' => $count,
        ]);
    }

    public function update(Request $request)
    {
        $cart = Session::get('cart', []);
        $id = $request->input('product_id');
        $quantity = max(1, (int) $request->input('quantity', 1));

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $quantity;
            Session::put('cart', $cart);
        }

        return redirect()->route('cart.index');
    }

    public function remove(Request $request)
    {
        $cart = Session::get('cart', []);
        $id = $request->input('product_id');

        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
        }

        return redirect()->route('cart.index');
    }

    public function clear()
    {
        Session::forget('cart');
        return redirect()->route('cart.index');
    }

    public function checkout()
    {
        $cart = Session::get('cart', []);
        return view('client.cart.checkout', compact('cart'));
    }

    public function storeOrder(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
        ]);

        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống.');
        }

        $customer = Customer::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        $total = 0;
        foreach ($cart as $item) {
            $total += (int) $item['price'] * (int) $item['quantity'];
        }

        $order = Order::create([
            'customer_id' => $customer->id,
            'total' => $total,
            'status' => 'pending',
        ]);

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['productid'],
                'product_name' => $item['proname'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        Session::forget('cart');

        return redirect()->route('cart.index')->with('success', 'Đặt hàng thành công!');
    }
}
