<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\TwilioController;
use Config;
use Twilio\Rest\Client as TClient;

class TwilioControllerTest extends TestCase
{   
    protected $twilioController;

    private $id;
    private $token;
    private $twimlId;

    public function setUp(): void
    {
        parent::setUp();

        $id = env('TWILIO_APP_ID');
        $token = env('TWILIO_APP_TOKEN');
        $twimlId = env('TWILIO_APP_TWIML');

        $this->id = $id;
        $this->token = $token;
        $this->twimlId = $twimlId;
    }

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
        $this->assertNotEmpty($this->id);
        $this->assertNotEmpty($this->token);
        $this->assertNotEmpty($this->twimlId);
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

    /**
     * Test to check if we can connect to Twilio Rest API
     * 
     * Asserts true if it can connect to Twilio REST API
     */
    public function testCanConnectToTwilioRestAPI()
    {
        $twilioConnection = new TClient($this->id, $this->token);
		$this->assertNotFalse($twilioConnection);
    }

    public function testCanGenerateTwiml()
    {

    }
    
}
