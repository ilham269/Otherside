<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Order;
use App\Models\Product;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function __construct(private MidtransService $midtrans)
    {
        $this->middleware('auth')->except('notification');
    }

    public function checkout(Product $product)
    {
        abort_if(!$product->is_available || $product->stock < 1, 404);
        $product->load(['primaryImage', 'category']);
        return view('payment.checkout', compact('product'));
    }

    public function createOrder(CheckoutRequest $request, Product $product)
    {
        $data       = $request->validated();
        $totalPrice = $product->price * $data['qty'];

        $order = Order::create([
            'user_id'              => Auth::id(),
            'product_id'           => $product->id,
            'customer_name'        => $data['customer_name'],
            'customer_phone'       => $data['customer_phone'],
            'customer_email'       => $data['customer_email'],
            'qty'                  => $data['qty'],
            'total_price'          => $totalPrice,
            'status'               => 'pending',
            'shipping_address'     => $data['shipping_address'],
            'shipping_city'        => $data['shipping_city'],
            'shipping_province'    => $data['shipping_province'],
            'shipping_postal_code' => $data['shipping_postal_code'],
            'shipping_notes'       => $data['shipping_notes'] ?? null,
        ]);

        $order->load('product');

        try {
            $snapToken = $this->midtrans->createSnapToken($order);
            $order->update(['snap_token' => $snapToken]);

            return response()->json([
                'snap_token' => $snapToken,
                'order_id'   => $order->id,
            ]);
        } catch (\Exception $e) {
            $order->delete();
            return response()->json(['error' => 'Gagal membuat transaksi: ' . $e->getMessage()], 500);
        }
    }

    public function finish(Request $request)
    {
        $orderId = $request->query('order_id');
        $realId  = isset(explode('-', $orderId)[1]) ? explode('-', $orderId)[1] : null;
        $order   = $realId ? Order::with('product')->find($realId) : null;

        return view('payment.finish', compact('order'));
    }

    public function notification(Request $request)
    {
        try {
            $result = $this->midtrans->handleNotification();
            $order  = Order::find($result['order_id']);

            if ($order) {
                $order->update([
                    'status'            => $result['status'],
                    'payment_type'      => $result['payment_type'],
                    'midtrans_order_id' => $result['midtrans_id'],
                ]);
            }

            return response()->json(['message' => 'OK']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
