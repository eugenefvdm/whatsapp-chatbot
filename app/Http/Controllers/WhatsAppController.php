<?php

namespace App\Http\Controllers;

use App\BotManDrivers\TwilioWhatsAppDriver;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use Illuminate\Support\Facades\Log;
use BotMan\BotMan\Drivers\DriverManager;

class WhatsAppController extends Controller
{
    public function incoming()
    {
        $config = [
            "whatsapp" => [
                "sid"        => env('TWILIO_SID'),
                "auth_token" => env('TWILIO_AUTH_TOKEN'),
                "number"     => env('TWILIO_WHATSAPP_NUMBER', '+14155238886'),
            ]
        ];
            
        DriverManager::loadDriver(TwilioWhatsAppDriver::class);

        // Create an instance
        $botman = BotManFactory::create($config);
        
        $botman->hears('hi', function (BotMan $bot) {            
            $first_name = $bot->getUser()->getFirstName();            
            $bot->reply("Hello there {$first_name}! :-) Thank you for contacting Hosting Support. How may we help you today?");
        });
        
        $botman->hears('Start conversation', BotManController::class.'@startConversation');
        
        $botman->listen();
    }
}
