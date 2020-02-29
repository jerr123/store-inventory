<?php

namespace App\Console\Commands;

use \Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\Msgboard\Message;

class FixMessagesDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'messages:fixDate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return mixed
     */
    public function handle()
    {
        $messages = Message::all();
        foreach ($messages as $message) {
            $message->created_at = Carbon::parse($message->created_at)->addHours(8);
            $message->save();
        }
    }
}
