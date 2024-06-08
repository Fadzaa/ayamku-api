<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendOtpRequest;
use App\Mail\VerifyEmail;
use App\Models\Otp;
use Illuminate\Support\Facades\Mail;

class OtpController extends Controller
{
    public function sendOtp(SendOtpRequest $request)
    {
        $data = $request->validated();

        $otpEmail = Otp::all()->where('email', $data['email'])->first();

        if ($otpEmail) {
            $otpEmail->delete();
        }

        $otpNumber = rand(1000, 9999);

        Mail::to($data['email'])->send(new VerifyEmail($otpNumber));

        $otp = new Otp();
        $otp->fill([
            'email' => $data['email'],
            'otp' => $otpNumber,
        ]);
        $otp->save();

        return response([
            'message' => 'Otp has been sent to your email',
        ], 200);
    }
}
