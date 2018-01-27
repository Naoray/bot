<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $botman = resolve('botman');

        $botman->hears('/help', function ($bot) {
            $bot->reply('Available Commands:');

            foreach (config('botman.commands') as $command => $data) {
                $bot->reply("{$command} - {$data['description']}");
            }

            $bot->reply('Try one of those.');
        });

        foreach (config('botman.commands') as $command => $data) {
            if ($command !== '/help') {
                $botman->hears($command, $data['entry_point']);
            }
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
