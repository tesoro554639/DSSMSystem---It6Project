<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paymentMethods = PaymentMethod::orderBy('method_name')->get();
        
        return view('payment_methods.index', compact('paymentMethods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('payment_methods.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'method_name' => 'required|string|max:255|unique:payment_methods,method_name',
            'description' => 'nullable|string|max:500',
        ]);

        PaymentMethod::create($validated);

        return redirect()->route('payment_methods.index')
            ->with('success', 'Payment method created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentMethod $paymentMethod)
    {
        $paymentMethod->load(['transactions.user']); 
        
        return view('payment_methods.show', compact('paymentMethod'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentMethod $paymentMethod)
    {
        return view('payment_methods.edit', compact('paymentMethod'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $validated = $request->validate([
            'method_name' => 'required|string|max:255|unique:payment_methods,method_name,' . $paymentMethod->id,
            'description' => 'nullable|string|max:500',
        ]);

        $paymentMethod->update($validated);

        return redirect()->route('payment_methods.index')
            ->with('success', 'Payment method updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentMethod $paymentMethod)
    {
        if ($paymentMethod->transactions()->exists()) {
            return redirect()->route('payment_methods.index')
                ->with('error', 'Cannot delete "' . $paymentMethod->method_name . '" because it is linked to past transactions.');
        }

        $paymentMethod->delete();

        return redirect()->route('payment_methods.index')
            ->with('success', 'Payment method deleted successfully.');
    }
}