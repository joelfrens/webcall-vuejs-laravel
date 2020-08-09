<?php
namespace App\Http\Interfaces\ImportContacts;

/**
 * Interface to import user contacts.
 * 
 * This will be importing the users name and contact number and an email?
 */
interface ImportContactsInterface {

	/**
	 * @param $request Request object 
	 * 
	 */
	public function import(\Illuminate\Http\Request $request);

}