<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GoogleAdsense;

class GoogleAdsenseClientController extends Controller
{
    public function edit()
    {
        $adsense = GoogleAdsense::first();
        return view('admin.ads.GoogleAdsense', compact('adsense'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'publisher_id' => 'required|string',
            'display_ads' => 'nullable|string',
            'in_feed_ads' => 'nullable|string',
            'multiplex_ads' => 'nullable|string',
        ]);

        $adsense = GoogleAdsense::first();
        if ($adsense) {
            $adsense->update($request->all());
        } else {
            GoogleAdsense::create($request->all());
        }

        return redirect()->route('google.adsense.edit')->with('success', 'Settings updated successfully.');
    }
}
