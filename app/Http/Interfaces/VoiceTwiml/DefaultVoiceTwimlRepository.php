<?php
namespace App\Http\Interfaces\VoiceTwiml;

use Twilio\TwiML\VoiceResponse;
/**
 * Implements the default mode of Voice Twiml
 * 
 * This will generate a basic Twiml instruction to make a call
 */
Class DefaultVoiceTwimlRepository implements VoiceTwimlRepository {

	/**
	 * {@inheritdoc}
	 */
	public function generateTwiml($request)
	{	
        $recording = false;
        $recordingType = false;
        $statusCallback = false;
        $dialOptions = array();
        $callBackOptions = array();
        $eventCallbackOptions = array(); //TODO
        $response = '';
        
        $calledId = env('TWILIO_CALLER_ID');
        $dialOptions["calledId"] = $calledId;
        $toPhoneNumber = ""; //The number to be called

		$response = new VoiceResponse();

        // Is recording required
        $recording = $this->requiresCallRecordings($request);

        if ($recording) {
            // Get recording type
            $recordingType = $this->getRecordingType($request);
            $dialOptions["record"] = $recordingType;
        }

        $statusCallback = $this->requiresStatusCallback();

        if ($statusCallback) {
            // Get status callback Url
            $statusCallbackUrl = env('TWILIO_STATUS_CALLBACK_URL');
            $callBackOptions["statusCallback"] = $statusCallbackUrl;

            // Get status Callback Events
            $statusCallbackEvents = $this->getStatusCallbackEvents();
            $callBackOptions["statusCallbackEvent"] = $statusCallbackEvents;

            // Get status Callback Method
            $statusCallbackMethod = $this->getStatusCallbackMethod();
            $callBackOptions["statusCallbackMethod"] = $statusCallbackMethod;
        }

        // Answer on bridge 
        // https://www.twilio.com/docs/voice/twiml/dial#answeronbridge
        $answerOnBridge = $this->getAnswerOnBridgeOption();
        if ($answerOnBridge) {
            $dialOptions["answerOnBridge"] = $answerOnBridge;
        }
        
        // Generate the Twiml
        $response = new VoiceResponse();
        $dial = $response->dial('', $dialOptions);
        $dial->number($toPhoneNumber, $callBackOptions);

        return $response;	
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
     * Check if it requires status callback
     * 
     * $return bool
     */
    private function requiresStatusCallback()
    {
        $requiresStatusCallback = true;

        return $requiresStatusCallback;
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