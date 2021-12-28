<?php

namespace App\Console\Commands;

use App\Models\EventTypes;
use App\Models\WeatherEvents;
use App\Services\TypesParsingService;
use App\Services\WeatherParsingService;
use Illuminate\Console\Command;

class EventTypesParsing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'types:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get events categories';

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
        $types = (new TypesParsingService())->callApi()['categories'];
        foreach ($types as $type) {
            $newOne = new EventTypes(['type' => $type['title']]);
            $newOne->save();
        }
        return 0;
    }
}
