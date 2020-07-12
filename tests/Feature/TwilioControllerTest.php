<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\TwilioController;
use Config;
use Twilio\Rest\Client as TClient;
use Mockery;

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
    public function testItGetToken()
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
    public function testItCanConnectToTwilioRestAPI()
    {
        $connction = new TClient($this->id, $this->token);
		$this->assertNotFalse($connction);
    }

    public function testItCanGenerateTwiml()
    {
        $mock_search = Mockery::mock(\App\Http\Controllers\TwilioController::class);
        $mock_search->shouldReceive('requiresCallRecordings')->once()->andReturn(true);
    }

    /**
     * Test to check if we can make a dummy call
     * Not a very useful test but can make cure that we can connect to the API
     * 
     * This test requires test Account Sid and Token. It will not work with the live Account Sid and Token
     * 
     * Also, it only works with magic numbers provided by Twilio
     */
    public function testItCanMakeADummyCall()
    {
        // Setup test credentials
		$testAccountSid = "xxx";
		$testAccountToken = "xxx";
		$connction = new TClient($testAccountSid, $testAccountToken);

		$call = $connction->calls
			->create(
                "+441234567889", // to Magic Phone Number
				"+15005550006", // from Magic Phone Number
				array("url" => "http://demo.twilio.com/docs/voice.xml")
			);

		$this->assertNotFalse($call->sid);
		$this->stringContains($call->sid, $call->subresourceUris["recordings"]);

		// Test if the response contains a recording location
		$expectedRecordingLocation = "/2010-04-01/Accounts/".$testAccountSid."/Calls/".$call->sid."/Recordings.json";
		$actualRecordingLocation = $call->subresourceUris["recordings"];
		$this->assertEquals($expectedRecordingLocation, $actualRecordingLocation);
    }
    
}
