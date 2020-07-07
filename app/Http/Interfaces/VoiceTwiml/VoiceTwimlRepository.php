<?php
namespace App\Http\Intefaces\VoiceTwiml;

/**
 * Interface to generate the Voice Twiml XML response
 */
Interface VoiceTwimlRepository {

	/**
	 * Generates valid Twiml (Twilio Markup Language)
	 * The implemented function will be called by Twilio to fetch the instructions
	 * when a call is made.
	 * 
	 * @param $request Request object 
	 * 
	 * @return String Returns a valid Twilio Markup string. 
	 */
	public function generateTwiml(Request $request);

}