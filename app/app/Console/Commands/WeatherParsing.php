<?php

namespace App\Console\Commands;

use App\Models\WeatherEvents;
use App\Services\WeatherParsingService;
use Illuminate\Console\Command;

class WeatherParsing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Saving events data from nasa api';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $events = (new WeatherParsingService)->callApi()['events'];
        $databaseEvents = array();
        foreach ($events as $event) {
            foreach ($event['geometries'] as $geometries) {
                $databaseEvents['type'] = $event['categories'][0]['title'];
                $databaseEvents['title'] = $event['title'];
                $databaseEvents['date_time'] = substr($geometries['date'], 0, 10) . ' ' . substr($geometries['date'], 11, 8);
                $databaseEvents['latitude'] = $geometries['coordinates'][1];
                $databaseEvents['longitude'] = $geometries['coordinates'][0];
                $newOne = new WeatherEvents($databaseEvents);
                $newOne->save();
            }
        }
        return 0;
    }
}
