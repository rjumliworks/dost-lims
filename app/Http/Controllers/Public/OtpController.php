<?php

namespace App\Http\Controllers\Public;

use App\Mail\CodeMail;
use App\Models\Customer;
use App\Models\CustomerContact;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

class OtpController extends Controller
{
    public function mail(Request $request){
        $request->validate(['email' => 'required|email']);
        $email = hash('sha256', $request->email);
     
        $customer = CustomerContact::where('kradworkz', $email)->first();
        if (!$customer) {
            return response()->json(['success' => false]);
        }
        $key = 'otp-request:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'email' => "Too many attempts. Try again in {$seconds} seconds."
            ]);
        }
        RateLimiter::hit($key, 300);

        if ($customer->otp_expires_at && $customer->otp_expires_at->gt(now()->subSeconds(60))) {
            return back()->withErrors([
                'email' => 'Please wait at least 1 minute before requesting another code.'
            ]);
        }

        $code = rand(100000, 999999);
        $customer->otp = $code; // store hashed
        $customer->otp_expires_at = Carbon::now()->addMinutes(5);
        $customer->save();

        Mail::to($request->email)->send(new CodeMail($code));
        return response()->json(['success' => true]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|digits:6'
        ]);

        // Hash the email to match stored value
        $hashedEmail = hash('sha256', $request->email);

        // Lookup the contact
        $contact = CustomerContact::where('kradworkz', $hashedEmail)->first();

        if (!$contact) {
            return back()->withErrors(['email' => 'Contact not found.']);
        }

        // Check if OTP exists and is not expired
        if (!$contact->otp) {
            return back()->withErrors(['code' => 'Invalid or expired code.']);
        }

       if ($request->code !== $contact->otp) {
            return back()->withErrors(['code' => 'Invalid code.']);
        }

        // OTP is valid → log in
        \Auth::guard('customer')->login($contact->customer); // login the associated customer

        // Clear OTP
        $contact->otp = null;
        $contact->otp_expires_at = null;
        $contact->save();

        return redirect()->route('customer.dashboard')->with([
            'data' => $contact->customer
        ]);
    }
}
