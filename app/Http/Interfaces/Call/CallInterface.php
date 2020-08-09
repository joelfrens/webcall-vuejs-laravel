<?php
namespace App\Http\Interfaces\Call;

/**
 * Interface to make a call and Hangup a call
 */
interface CallInterface {

	/**
	 * Make a call
	 * 
	 * @param $request Request object 
	 */
	public function call(\Illuminate\Http\Request $request);

	/**
	 * Hang up a call
	 * 
	 * @param $request Request object 
	 */
	public function hangup(\Illuminate\Http\Request $request);

}