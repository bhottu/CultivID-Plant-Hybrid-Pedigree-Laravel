<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::first();
        return view('admin.settings.index', compact('settings'));
        
    }
    
    public function showTerms()
    {
        $settings = Setting::first();
        return view('admin.misc.terms', compact('settings'));
    }
    
    public function showPrivacyPolicy()
    {
        $settings = Setting::first();
        return view('admin.misc.privacy', compact('settings'));
    }

    public function showAbout()
    {
        $settings = Setting::first();
        return view('admin.misc.about', compact('settings'));
    }

    public function showContact()
    {
        $settings = Setting::first();
        return view('admin.misc.contact', compact('settings'));
    }

    public function showCurrencies()
    {
        $settings = Setting::first();
        return view('admin.misc.listcurrencies', compact('settings'));
    }

    

    public function store(Request $request)
    {
        $data = $request->validate([
            'social_media' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'about_us' => 'nullable|string',
            'terms_conditions' => 'nullable|string',
            'privacy_policy' => 'nullable|string',
            'contact_us' => 'nullable|string',
            'currency' => 'nullable|string',
            'web_description' => 'nullable|string',
            'fav_icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'website_name' => 'nullable|string',
        ]);

        $setting = Setting::first();
        if (!$setting) {
            $setting = new Setting;
        }

        $setting->fill($data);

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $setting->logo = $logoPath;
        }

        if ($request->hasFile('banner')) {
            $bannerPath = $request->file('banner')->store('banners', 'public');
            $setting->banner = $bannerPath;
        }

        if ($request->hasFile('fav_icon')) {
            $favIconPath = $request->file('fav_icon')->store('favicons', 'public');
            $setting->fav_icon = $favIconPath;
        }

        $setting->save();

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully.');
    }

    
}
