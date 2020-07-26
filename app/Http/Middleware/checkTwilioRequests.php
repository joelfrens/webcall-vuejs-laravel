<?php

namespace App\Http\Middleware;

use Twilio\Security\RequestValidator;
use Closure;

class checkTwilioRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        // Bypass validation
        return $next($request);
        // Basic request validation
        // This will just check if the request is coming from Twilio but the headers can be spoofed.
        if (!isset($_SERVER['HTTP_X_TWILIO_SIGNATURE'])
            && !($_SERVER['HTTP_I_TWILIO_IDEMPOTENCY_TOKEN'])) {
                return false;
        }

        // Proper Validation
        // $this->validateTwilioRequest($request)

        return $next($request);
    }

    /**
     * Check if the request came from Twilio based on the signature Twilio sends
     * 
     * The signature is sent in the $_SERVER global variable
     * 
     * We compare the Twilio signature with the signature we generate. If both are equal then it is a valid request.
     */
    private function validateTwilioRequest()
    {
        $token = env('TWILIO_APP_TOKEN');

        // The X-Twilio-Signature header
        $signature = $_SERVER["HTTP_X_TWILIO_SIGNATURE"];

        // Initialize the validator
        $validator = new RequestValidator($token);

        // The Twilio request URL. You may be able to retrieve this from
        $url = $_SERVER['REQUEST_URI'];

        // The post variables in the Twilio request. You may be able to use
        $postVars = $request->post();

        if ($validator->validate($signature, $url, $postVars)) {
            return true;
        } else {
            return false;
        }
    }
}
