<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use App\Handlers\BrainSlackHandler;
use Monolog\Logger;
use Monolog\Processor\WebProcessor;

class SlackLogServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $channel = env('SLACK_CHANNEL', '#brainsalvation_logs');
        $apiToken = env('SLACK_API', 'xoxp-30138857638-55767869137-57521367271-895ef8c27e');


        $monolog = Log::getMonolog();
        $monolog->pushProcessor(new WebProcessor);

        $slackHandler = new BrainSlackHandler($apiToken, $channel, 'NotifyBot');
        $slackHandler->setLevel(Logger::DEBUG);

        $monolog->pushHandler($slackHandler);
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
