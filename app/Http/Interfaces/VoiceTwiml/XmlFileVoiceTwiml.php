<?php
namespace App\Http\Intefaces\VoiceTwiml;

/**
 * Implements the XML File mode of Voice Twiml
 * 
 * This will generate a Twiml instruction from an XML file
 */
Class XmlFileVoiceTwiml implements VoiceTwimlInterface {

	/**
	 * {@inheritdoc}
	 */
	public function generateTwiml(Request $request)
	{
		// Get the twiml from an xml file
	}

}