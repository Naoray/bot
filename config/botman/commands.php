<?php

return [
	'/card' => [
		'description' => 'Adds a travel card to the user account.',
		'entry_point' => BotManController::class.'@startRegisterCardConversation',
	],
	'/help' => [
		'description' => 'List all available commands',
	],
	'/link' => [
		'description' => 'Starts linking a telegram account to the app account.',
		'entry_point' => BotManController::class.'@checkIfAlreadyRegistered',
	],
];