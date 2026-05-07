<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OrderProofRequest;
use App\Http\Requests\Admin\OrderStatusRequest;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(private OrderService $service) {}

    public function index(Request $request)
    {
        $orders = $this->service->getAll($request->only('search', 'status'));
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'product']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(OrderStatusRequest $request, Order $order)
    {
        $this->service->updateStatus($order, $request->validated('status'));
        return back()->with('success', 'Status order berhasil diupdate.');
    }

    public function uploadProof(OrderProofRequest $request, Order $order)
    {
        $this->service->uploadPaymentProof($order, $request->file('payment_proof'));
        return back()->with('success', 'Bukti pembayaran berhasil diupload.');
    }

    public function destroy(Order $order)
    {
        $this->service->delete($order);
        return redirect()->route('admin.orders.index')->with('success', 'Order berhasil dihapus.');
    }
}
