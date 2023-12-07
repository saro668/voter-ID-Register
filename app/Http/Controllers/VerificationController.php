<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Models\ActivityLog;


class VerificationController extends Controller
{
    /**
     * Instantiate a new VerificationController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Display an email verification notice.
     *
     * @return \Illuminate\Http\Response
     */
    public function notice(Request $request)
    {
        return $request->user()->hasVerifiedEmail() 
            ? redirect()->route('dashboard') : view('verification.verify');
    }

    /**
     * User's email verificaiton.
     *
     * @param  \Illuminate\Http\EmailVerificationRequest $request
     * @return \Illuminate\Http\Response
     */
    public function verify(EmailVerificationRequest $request)
    {

        $request->fulfill();
        $modelActivity = new ActivityLog();
        $modelActivity->log('User email verified sucessfully', $request);
        return redirect()->route('dashboard')->with('success', 'Your account has been successfully verified.');
    }

    /**
     * Resent verificaiton email to user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return back()->withSuccess('A fresh verification link has been sent to your email address.');
    }

}