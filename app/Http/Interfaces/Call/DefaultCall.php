<?php
namespace App\Http\Intefaces\Call;

/**
 * Implements the make call and hangup functionality
 * 
 */
Class DefaultCall implements VoiceTwimlInterface {

	/**
	 * {@inheritdoc}
	 */
	public function call(Request $request)
	{
		// Implement this when a call is started
	}

	/**
	 * {@inheritdoc}
	 */
	public function hangup(Request $request)
	{
		// Implement this when the call is ended
	}

}