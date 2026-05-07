<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CustomOrderPriceRequest;
use App\Http\Requests\Admin\CustomOrderStatusRequest;
use App\Models\CustomOrder;
use App\Services\CustomOrderService;
use Illuminate\Http\Request;

class CustomOrderController extends Controller
{
    public function __construct(private CustomOrderService $service) {}

    public function index(Request $request)
    {
        $customOrders = $this->service->getAll($request->only('search', 'status', 'type'));
        return view('admin.custom-orders.index', compact('customOrders'));
    }

    public function show(CustomOrder $customOrder)
    {
        $customOrder->load(['user', 'product']);
        return view('admin.custom-orders.show', compact('customOrder'));
    }

    public function updateStatus(CustomOrderStatusRequest $request, CustomOrder $customOrder)
    {
        $this->service->updateStatus($customOrder, $request->validated('status'));
        return back()->with('success', 'Status berhasil diupdate.');
    }

    public function setPrice(CustomOrderPriceRequest $request, CustomOrder $customOrder)
    {
        $this->service->setEstimatedPrice($customOrder, $request->validated('estimated_price'));
        return back()->with('success', 'Estimasi harga berhasil disimpan.');
    }

    public function destroy(CustomOrder $customOrder)
    {
        $this->service->delete($customOrder);
        return redirect()->route('admin.custom-orders.index')->with('success', 'Custom order berhasil dihapus.');
    }
}
