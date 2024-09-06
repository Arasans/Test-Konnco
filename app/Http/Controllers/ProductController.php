<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        $products = Product::where('isActive',true)->paginate(6);
        return view('pages.main', compact('products'));
    }
    
    public function payment(Request $request)
    {
        // Validasi input
        $request->validate([
            'product_price' => 'required|numeric|min:1',
            'quantity' => 'required|integer|min:1',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        $product = Product::find($request->input('product_id'));

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $quantity = (int) $request->input('quantity');
        if ($quantity > $product->stock) {
            return response()->json(['error' => 'Quantity exceeds available stock'], 400);
        }

        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        // Generate a unique order ID
        $orderId = 'ORD-' . strtoupper(uniqid());

        // Calculate total amount
        $totalAmount = $product->price * $quantity;

        $params = array(
            'transaction_details' => array(
                'order_id' => $orderId,
                'gross_amount' => $totalAmount,
            ),
            'customer_details' => array(
                'first_name' => $request->input('name'),
                'email' => $request->input('email'),
            ),
        );

        Transaction::create([
            'order_id' => $orderId,
            'status' => 'Pending',
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'quantity' => $quantity,
            'product_id' => $product->id,
        ]);

        $product->decrement('stock', $quantity);

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return response()->json(['snapToken' => $snapToken, 'orderId' => $orderId]);
    }

    

}
