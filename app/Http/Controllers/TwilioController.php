<?php

/**
 * @author Joel Fernandes
 * @create date 2020-06-28 13:44:43
 * @modify date 2020-06-28 13:44:43
 * @desc Twilio Controller - Used to handle various Twilio related calls
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;
use Twilio\Jwt\ClientToken;
use Twilio\TwiML\VoiceResponse;
use Twilio\Security\RequestValidator;

class TwilioController extends Controller
{   
    /**
     * Twilio App Id
     */
    private $id;

    /**
     * Twilio App Token
     */
    private $token;

    /**
     * Twilio Twiml Id
     */
    private $twimlId;

    /**
     * Set the Twilio parameters
     * 
     * These parameters are set in .env file
     * Get these parameters by creating an account on https://twilio.com
     */
    public function __construct()
    {
        $this->id = env('TWILIO_APP_ID');
        $this->token = env('TWILIO_APP_TOKEN');
        $this->twimlId = env('TWILIO_APP_TWIML');
    }

    /**
     * Generates Twilio token
     * 
     * @return Json Returns a Json object with token or returns false otherwise
     */
    public function getToken()
    {   
        if ((isset($this->id) && !empty($this->id))
            && (isset($this->token) && !empty($this->token))
            && (isset($this->twimlId) && !empty($this->twimlId))
        ) {
            try {
                $clientToken = new ClientToken($this->id, $this->token);
                $clientToken->allowClientOutgoing($this->twimlId);
                $token = $clientToken->generateToken();
                return response()->json([
                    'token' => $token
                ]);
            }
            catch (\Exception $e) {
                echo $e->errorMessage();
            }
        }

		return false;
    }
    
    /**
     * Generates Voice Twiml Instructions
     *
     * @return void
     */
    public function generateVoiceTwiml()
    {   
        //var_dump($_REQUEST);exit;
        $twimlResponse = '';
        //TODO remove the request object
        $request = array("From" => "32523585", "To" => "35252");
        $voiceTwiml = new \App\Http\Interfaces\VoiceTwiml\DefaultVoiceTwimlRepository();
        $twimlResponse = $voiceTwiml->generateTwiml($request);

        // Call the implemented class

        header('Content-Type: text/xml');
		echo $twimlResponse;
		exit;
    }
    
    /**
     * statusCallBackHandler
     *
     * @return void
     */
    public function statusCallBackHandler()
    {

    }
    
    /**
     * voicemailHandler
     *
     * @return void
     */
    public function voicemailHandler()
    {

    }
}
