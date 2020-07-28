<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DefaultVoiceTwimlRepositoryTest extends TestCase
{
    /**
     * Test it can generate default voice Twiml
     *
     * @return void
     */
    public function testItCanGenerateDefaultTwiml()
    {
        $request = array("From" => "32523585", "To" => "35252");
        $voiceTwiml = new \App\Http\Interfaces\VoiceTwiml\DefaultVoiceTwimlRepository();
        $twimlResponse = $voiceTwiml->generateTwiml($request);

        $this->assertInstanceOf('Twilio\TwiML\VoiceResponse', $twimlResponse);
        
    }
}
