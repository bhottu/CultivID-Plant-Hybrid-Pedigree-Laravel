<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ApiSetting;

class MembaraSettingController extends Controller
{
    public function edit()
    {
        $settings = ApiSetting::firstOrCreate(
            ['api_name' => 'envato'],
            ['api_key' => '', 'api_secret' => '', 'redirect_uri' => '']
        );

        return view('admin.membara-settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'api_key' => 'required|string',
            'api_secret' => 'required|string',
            'redirect_uri' => 'nullable|string',
        ]);

        $settings = ApiSetting::where('api_name', 'envato')->first();
        $settings->update($request->only('api_key', 'api_secret', 'redirect_uri'));

        return redirect()->route('admin.membara-settings.edit')->with('success', 'API settings updated successfully.');
    }

    public function verifyLicense(Request $request)
    {
        $request->validate([
            'purchase_code' => 'required|string',
        ]);

        $settings = ApiSetting::where('api_name', 'envato')->first();

        $client = new Client();
        $response = $client->request('GET', 'https://api.envato.com/v3/market/author/sale', [
            'headers' => [
                'Authorization' => 'Bearer ' . $settings->api_key,
                'User-Agent' => 'Laravel App',
            ],
            'query' => [
                'code' => $request->purchase_code,
            ]
        ]);

        $statusCode = $response->getStatusCode();
        $body = json_decode($response->getBody(), true);

        if ($statusCode == 200 && isset($body['item']['id'])) {
            // Save license info to database or perform further checks
            // Example: Check if this purchase code is already used
            // If not used, save it as used

            return response()->json(['status' => 'success', 'message' => 'License verified successfully.']);
        }

        return response()->json(['status' => 'error', 'message' => 'Invalid license code.']);
    }
}
