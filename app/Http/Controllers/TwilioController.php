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
    public function generateVoiceTwiml($request)
    {   
        $recording = false;
        $recordingType = false;

        // Is recording required
        $recording = $this->requiresCallRecordings($request);

        if ($recording) {
            // Get recording type
            $recordingType = $this->getRecordingType($request);
        }
        
        // Get status callback Url
        $statusCallbackUrl = env('TWILIO_STATUS_CALLBACK_URL');

        // Get status Callback Events
        $statusCallbackEvents = $this->getStatusCallbackEvents();

        // Get status Callback Method
        $statusCallbackMethod = $this->getStatusCallbackMethod();

        // Answer on bridge 
        // https://www.twilio.com/docs/voice/twiml/dial#answeronbridge
        $answerOnBridge = $this->getAnswerOnBridgeOption();
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

    /**
     * Check if the called user requires recording feature
     * 
     * @param $request Request Object
     * @return bool
     */
    private function requiresCallRecordings($request)
    {
        $recording = true;

        return $recording;
    }

    /**
     * Return the recording type
     * 
     * Available options
     * - record-from-answer
     * - record-from-answer-dual
     * - record-from-ringing
     * - record-from-ringing-dual
     * 
     * https://www.twilio.com/docs/voice/twiml/dial
     */
    private function getRecordingType($request)
    {
        $recordingType = "record-from-answer-dual";

        return $recordingType;
    }

    /**
     * Get Status Callback Events
     * 
     * Available options
     * 
     * - initiated ringing answered completed
     */
    private function getStatusCallbackEvents()
    {
        $callbackEvents = 'initiated ringing answered completed';

        return $callbackEvents;
    }

    /**
     * Get Status Callback Method
     * 
     * Available option
     * - POST
     * - GET
     */
    private function getStatusCallbackMethod()
    {
        return "POST";
    }

    /**
     * Get the AnswerOnBridge option Flag
     * 
     * https://www.twilio.com/docs/voice/twiml/dial#answeronbridge
     */
    private function getAnswerOnBridgeOption()
    {
        $answerOnBridge = true;

        return $answerOnBridge;
    }
}
