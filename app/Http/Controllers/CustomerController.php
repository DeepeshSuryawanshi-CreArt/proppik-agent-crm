<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::with('country', 'creator')->paginate(10);
        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::all();
        return view('customers.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile_no' => 'required|string|unique:customers',
            'base_mobile' => 'nullable|string',
            'country_id' => 'nullable|exists:countries,id',
            'dial_code' => 'nullable|string',
            'email' => 'required|email|unique:customers',
            'otp_code' => 'nullable|string',
            'company_name' => 'required|string|max:255',
            'package' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'payment_type' => 'required|string',
            'payed_at' => 'nullable|date',
            'payment_status' => 'required|in:pending,paid,failed',
            'gst_no' => 'nullable|string',
            'payment_screenshort' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'otp_verifed_at' => 'nullable|date',
            'otp_expired_at' => 'nullable|date',
        ]);

        $data = $request->all();
        $data['created_by'] = auth()->id();

        if ($request->hasFile('payment_screenshort')) {
            $data['payment_screenshort'] = $request->file('payment_screenshort')->store('payment_screenshots', 'public');
        }

        Customer::create($data);

        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return view('customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        $countries = Country::all();
        return view('customers.edit', compact('customer', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile_no' => 'required|string|unique:customers,mobile_no,' . $customer->id,
            'base_mobile' => 'nullable|string',
            'country_id' => 'nullable|exists:countries,id',
            'dial_code' => 'nullable|string',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'otp_code' => 'nullable|string',
            'company_name' => 'required|string|max:255',
            'package' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'payment_type' => 'required|string',
            'payed_at' => 'nullable|date',
            'payment_status' => 'required|in:pending,paid,failed',
            'gst_no' => 'nullable|string',
            'payment_screenshort' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'otp_verifed_at' => 'nullable|date',
            'otp_expired_at' => 'nullable|date',
        ]);

        $data = $request->all();
        $data['updated_by'] = auth()->id();

        if ($request->hasFile('payment_screenshort')) {
            $data['payment_screenshort'] = $request->file('payment_screenshort')->store('payment_screenshots', 'public');
        }

        $customer->update($data);

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
}
