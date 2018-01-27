<?php

namespace App\Http\Conversations;

use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;

class RegisterCard extends Conversation
{
    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $this->askForType();
    }

    public function askForType()
    {
    	$question = Question::create("Was für eine Karte möchtest du hinzufügen?")
            ->callbackId('ask_for_card_type')
    		->addButtons([
                Button::create('Einzelfahrkarte')->value('Einzelfahrkarte'),
                Button::create('RMVsmart')->value('RMVsmart'),
                Button::create('Kurzstreckenfahrkarte')->value('Kurzstreckenfahrkarte'),
                Button::create('Tageskarte')->value('Tageskarte'),
                Button::create('Monatskarte')->value('Monatskarte'),
                Button::create('Jahreskarte')->value('Jahreskarte'),
            ]);

    	$this->ask($question, function (Answer $response) {
    		$answer = $response->isInteractiveMessageReply() 
                            ? $response->getValue() 
                            : $response->getText();

            $this->bot->userStorage()->save([
            	'type' => $answer
            ], 'card');

        	$this->askForGroup();
    	});
    }

    /**
     * [askForGroup description]
     * @return [type] [description]
     */
    public function askForGroup()
    {
    	$question = Question::create("Zu welcher Kundengruppe gehörst du?")
            ->callbackId('ask_for_group')
    		->addButtons([
                Button::create('Erwachsene')->value('Erwachsene'),
                Button::create('Schüler, Auszubildende')->value('Schüler, Auszubildende'),
            ]);

        $this->ask($question, function (Answer $response) {
    		$answer = $response->isInteractiveMessageReply() 
                            ? $response->getValue() 
                            : $response->getText();

            $this->bot->userStorage()->save([
            	'group' => $answer
            ], 'card');

            $this->askForPeriod();
    	});
    }

    /**
     * [askForPeriod description]
     * @return [type] [description]
     */
    public function askForPeriod()
    {
    	$question = Question::create("Was für eine Fahrkarte hast du genau?")
            ->callbackId('ask_for_period_type')
    		->addButtons([
                Button::create('Jahreskarte')->value('Jahreskarte'),
                Button::create('9-Uhr-Jahreskarte')->value('9-Uhr-Jahreskarte'),
                Button::create('65-plus-Jahreskarte')->value('65-plus-Jahreskarte'),
                Button::create('65-Jahreskarte Frankfurt')->value('65-Jahreskarte Frankfurt'),
            ]);

        $this->ask($question, function (Answer $response) {
    		$answer = $response->isInteractiveMessageReply() 
                            ? $response->getValue() 
                            : $response->getText();

            $this->bot->userStorage()->save([
            	'period_type' => $answer
            ], 'card');


        	$this->askForPriceCategory();
    	});
    }

    /**
     * [askForPriceCategory description]
     * @return [type] [description]
     */
    public function askForPriceCategory()
    {
    	$question = Question::create("Welche Preisstufe hat deine Karte?")
            ->callbackId('ask_for_price_category')
    		->addButtons([
                Button::create('1')->value('1'),
                Button::create('1 (Sonderstatusstadt)')->value('1 (Sonderstatusstadt)'),
                Button::create('1 (Stadt Darmstadt)')->value('1 (Stadt Darmstadt)'),
                Button::create('2')->value('2'),
                Button::create('2 (Stadt Offenbach)')->value('2 (Stadt Offenbach)'),
                Button::create('3')->value('3'),
                Button::create('3 (Stadt Frankfurt)')->value('3 (Stadt Frankfurt)'),
                Button::create('4')->value('4'),
                Button::create('5')->value('5'),
                Button::create('6')->value('6'),
                Button::create('7 (17)')->value('7 (17)'),
                Button::create('13')->value('13'),
                Button::create('45')->value('45'),
            ]);

        $this->ask($question, function (Answer $response) {
    		$answer = $response->isInteractiveMessageReply() 
                            ? $response->getValue() 
                            : $response->getText();

            $this->bot->userStorage()->save([
            	'price_category' => $answer
            ], 'card');

        	$this->askForValidDate();
    	});
    }

    /**
     * [askForValidDate description]
     * @return [type] [description]
     */
    public function askForValidDate()
    {
        $this->ask("Bis zu einschließlich welchem Datum ist die Karte gültig? [dd.mm.yyyy]", function (Answer $response) {
            $this->bot->userStorage()->save([
            	'valid_until' => \Carbon\Carbon::parse($response->getText())->format('d.m.Y')
            ], 'card');

            $this->displayInformation();
    	});
    }

    public function displayInformation()
    {
    	$storage = $this->bot->userStorage()->find('card');

    	$this->say('Here we go:');
    	$this->say('Kartentyp: '.$storage->get('type'));
    	$this->say('Kundengruppe: '.$storage->get('group'));
    	$this->say('Karten Zeitraum: '.$storage->get('period_type'));
    	$this->say('Preisstufe: '.$storage->get('price_category'));
    	$this->say('Gültig bis: '.$storage->get('valid_until'));

    	return;
    }
}
