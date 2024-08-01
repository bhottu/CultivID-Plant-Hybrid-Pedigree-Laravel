<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function index()
    {
        $currencies = Currency::all();
        return view('admin.misc.listcurrencies', compact('currencies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:currencies|max:3',
            'name' => 'required',
            'symbol' => 'nullable',
        ]);

        Currency::create($request->all());

        return redirect()->route('currencies.index')->with('success', 'Currency added successfully.');
    }

    public function edit(Currency $currency)
    {
        return view('admin.misc.editcurrency', compact('currency'));
    }

    public function update(Request $request, Currency $currency)
    {
        $request->validate([
            'code' => 'required|max:3|unique:currencies,code,' . $currency->id,
            'name' => 'required',
            'symbol' => 'nullable',
        ]);
    
        // Update currency record
        $currency->update($request->only(['code', 'name', 'symbol']));
    
        // Redirect with success message
        return redirect()->route('currencies.index')->with('success', 'Currency updated successfully.');
    }
    
    public function destroy(Currency $currency)
    {
        // Delete the currency record
        $currency->delete();
    
        // Redirect with success message
        return redirect()->route('currencies.index')->with('success', 'Currency deleted successfully.');
    }
    
}
