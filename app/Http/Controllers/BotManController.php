<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;
use App\Http\Conversations\RegisterCard;
use App\Conversations\ExampleConversation;
use App\Http\Middleware\SpiesOnBotmanRequests;
use App\Http\Conversations\RegisterConversation;
use App\Http\Conversations\CheckIfUserIsRegistered;

class BotManController extends Controller
{
    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        $botman = app('botman');

        $botman->middleware->sending(new SpiesOnBotmanRequests());

        $botman->listen();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tinker()
    {
        return view('tinker');
    }

    /**
     * [checkIfAlreadyRegistered description]
     * @param  BotMan $bot [description]
     * @return [type]      [description]
     */
    public function checkIfAlreadyRegistered(BotMan $bot)
    {
        $bot->startConversation(new CheckIfUserIsRegistered());
    }

    /**
     * Loaded through routes/botman.php
     * @param  BotMan $bot
     */
    public function startRegisterCardConversation(BotMan $bot)
    {
        $bot->startConversation(new RegisterCard());
    }
}
