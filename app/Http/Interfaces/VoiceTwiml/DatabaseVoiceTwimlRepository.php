<?php
namespace App\Http\Intefaces\VoiceTwiml;

/**
 * Implements the database mode of Voice Twiml
 * 
 * This will generate a Twiml instruction from the database tables
 */
Class DatabaseVoiceTwimlRepository implements VoiceTwimlRepository {

	/**
	 * {@inheritdoc}
	 */
	public function generateTwiml(Request $request)
	{
		
	}

}