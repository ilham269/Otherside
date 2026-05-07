<?php

namespace App\Services;

use App\Models\Order;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = config('midtrans.is_sanitized');
        Config::$is3ds        = config('midtrans.is_3ds');
    }

    /**
     * Buat Snap token untuk order
     */
    public function createSnapToken(Order $order): string
    {
        $params = [
            'transaction_details' => [
                'order_id'     => 'ORDER-' . $order->id . '-' . time(),
                'gross_amount' => (int) $order->total_price,
            ],
            'customer_details' => [
                'first_name' => $order->customer_name,
                'email'      => $order->customer_email,
                'phone'      => $order->customer_phone,
                'shipping_address' => [
                    'first_name'   => $order->customer_name,
                    'phone'        => $order->customer_phone,
                    'address'      => $order->shipping_address,
                    'city'         => $order->shipping_city,
                    'postal_code'  => $order->shipping_postal_code,
                    'country_code' => 'IDN',
                ],
            ],
            'item_details' => [
                [
                    'id'       => $order->product_id,
                    'price'    => (int) $order->product->price,
                    'quantity' => $order->qty,
                    'name'     => substr($order->product->name, 0, 50),
                ],
            ],
            'callbacks' => [
                'finish' => route('payment.finish'),
            ],
        ];

        return Snap::getSnapToken($params);
    }

    /**
     * Handle notifikasi webhook dari Midtrans
     */
    public function handleNotification(): array
    {
        $notification = new Notification();

        $orderId           = $notification->order_id;
        $transactionStatus = $notification->transaction_status;
        $fraudStatus       = $notification->fraud_status;
        $paymentType       = $notification->payment_type;

        // Ambil ID order asli (strip prefix ORDER- dan timestamp)
        $realOrderId = (int) explode('-', $orderId)[1];

        $status = match (true) {
            $transactionStatus === 'capture' && $fraudStatus === 'accept' => 'processing',
            $transactionStatus === 'settlement'                           => 'processing',
            in_array($transactionStatus, ['cancel', 'deny', 'expire'])   => 'cancelled',
            $transactionStatus === 'pending'                              => 'pending',
            default                                                       => 'pending',
        };

        return [
            'order_id'    => $realOrderId,
            'status'      => $status,
            'payment_type'=> $paymentType,
            'midtrans_id' => $orderId,
        ];
    }
}
