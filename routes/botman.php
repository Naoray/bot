<?php
use BotMan\BotMan\BotMan;
use App\Http\Controllers\BotManController;
use App\Http\Conversations\RegisterConversation;

$botman = resolve('botman');

$botman->hears('Hi', function ($bot) {
    $bot->reply('Hello!');
});

$botman->hears('/link', BotManController::class.'@checkIfAlreadyRegistered');
$botman->hears('/card', BotmanController::class.'@startRegisterCardConversation');