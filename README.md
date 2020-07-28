### A web app using Twilio Vuejs and Laravel

## This is an experimental package and should be used at your own risk!!!

# Setup

The app is built using the following Frameworks
- Laravel 7
- VueJs 
- Twilio PHP SDK https://github.com/twilio/twilio-php

Set the following environment variables in your Laravel .env file (Rename .env.example to .env and make the necessary changes)

The test credentials (TWILIO_TEST_SID & TWILIO_TEST_AUTHTOKEN) can be found here https://www.twilio.com/console/project/settings
```
TWILIO_APP_ID=YOUR TWILIO APP ID
TWILIO_APP_TOKEN=YOUR TWILIO TOKEN
TWILIO_APP_TWIML=YOUR TWILIO TWIML ID
TWILIO_STATUS_CALLBACK_URL STATUS CALLBACK URL

TWILIO_TEST_SID
TWILIO_TEST_AUTHTOKEN
```

To get your Twilio Id and Twilio token, create a Twilio account and go here https://www.twilio.com/console

To get your Twiml Id, Create a Twiml app here https://www.twilio.com/console/voice/twiml/apps

# Unit Testing

```
php artisan test
```
