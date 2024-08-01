<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function __construct()
    {
        $this->middleware('guest');
    }

    // Override showLinkRequestForm method to show custom view
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    // Override sendResetLinkEmail method to customize email sending logic if needed
    public function sendResetLinkEmail(Request $request)
    {
        // Your logic for sending email with password reset link
    }

    // Override showResetForm method to show custom view
    public function showResetForm(Request $request, $token)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }

    // Override reset method to handle password reset logic
    public function reset(Request $request)
    {
        // Your logic for resetting password
    }
}
