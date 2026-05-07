<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CustomOrder;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CustomOrderFormController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $products = Product::where('is_available', true)->orderBy('name')->get();
        return view('store.custom-order', compact('products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'subject'        => ['required', 'string', 'max:200'],
            'product_id'     => ['nullable', 'exists:products,id'],
            'qty'            => ['required', 'integer', 'min:1'],
            'type'           => ['required', 'in:bulk,personal,event'],
            'notes'          => ['required', 'string', 'max:1000'],
            'reference_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ]);

        $path = null;
        if ($request->hasFile('reference_file')) {
            $path = $request->file('reference_file')->store('references', 'public');
        }

        $trackId = 'STR-' . strtoupper(Str::random(8));

        CustomOrder::create([
            'user_id'         => Auth::id(),
            'product_id'      => $data['product_id'] ?? null,
            'track_id_store'  => $trackId,
            'customer_email'  => Auth::user()->email,
            'qty'             => $data['qty'],
            'subject'         => $data['subject'],
            'notes'           => $data['notes'],
            'reference_file'  => $path,
            'type'            => $data['type'],
            'status'          => 'pending',
        ]);

        return redirect()->route('orders.index')
            ->with('success', 'Custom order berhasil dikirim! Tim kami akan menghubungimu segera.');
    }
}
