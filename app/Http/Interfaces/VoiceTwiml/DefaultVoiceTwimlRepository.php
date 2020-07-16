<?php
namespace App\Http\Intefaces\VoiceTwiml;

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
	public function generateTwiml(Request $request)
	{	
		$toPhone ;
		$recording = false;
        $recordingType = false;
		$statusCallback = false;
		$response = '';

		$response = new VoiceResponse();

        // Is recording required
        $recording = $this->requiresCallRecordings($request);

        if ($recording) {
            // Get recording type
            $recordingType = $this->getRecordingType($request);
        }

        $statusCallback = $this->requiresStatusCallback();

        if ($statusCallback) {
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