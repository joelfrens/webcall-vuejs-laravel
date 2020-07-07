<?php
namespace App\Http\Intefaces\VoiceTwiml;

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
		
	}

}