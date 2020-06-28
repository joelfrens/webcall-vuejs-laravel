<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\TwilioController;
use Config;

class TwilioControllerTest extends TestCase
{   
    protected $twilioController;

    /**
     * Test to check if Twilio Credentials are set
     * 
     * The credentials are set in the .env file as follows:
     * TWILIO_APP_ID
     * TWILIO_APP_TOKEN
     * TWILIO_APP_TWIML
     */
    public function testTwilioCredentialsAreSet()
    {
        $id = env('TWILIO_APP_ID');
        $token = env('TWILIO_APP_TOKEN');
        $twimlId = env('TWILIO_APP_TWIML');

        $this->assertNotEmpty($id);
        $this->assertNotEmpty($token);
        $this->assertNotEmpty($twimlId);
    }

    /**
     * Test to check if the token can be generated
     *
     * Checks if we get a JSON output 
     * Checks if the JSON response has a token key
     */
    public function testGetToken()
    {
        $response = $this->get('/get-token');

        $response
            ->assertStatus(200)
            ->assertJson([
                'token' => true,
            ]);
    }


    
}
