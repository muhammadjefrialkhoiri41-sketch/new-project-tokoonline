<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('backend.v_customer.index', compact('customers'));
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->back()->with('success', 'Customer berhasil dihapus');
    }

    public function blokir($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->status = 'blocked';
        $customer->save();

        return back()->with('success', 'Customer diblokir');
    }

    public function aktifkan($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->status = 'active';
        $customer->save();

        return back()->with('success', 'Customer diaktifkan');
    }
}