<?php
use BotMan\BotMan\BotMan;
use App\Http\Controllers\BotManController;
use App\Http\Conversations\RegisterConversation;

$botman = resolve('botman');

$botman->hears('Hi', function ($bot) {
	$bot->reply('Hello!');
});

$botman->hears('/start', function ($bot) {
	$bot->reply(
		'Before you use this service you have to link this messenger with the finn app! Use /link to get started or /help to see all available commands.');
});