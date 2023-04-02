<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Managers\Provider\IProviderManager;
use Illuminate\Contracts\Container\BindingResolutionException;

class GetTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     * @throws BindingResolutionException
     */
    public function handle(): void
    {
        $factory = app(IProviderManager::class);

        $first_provider = $factory->make('first');
        $first_provider->getTasks();

        $second_provider = $factory->make('second');
        $second_provider->getTasks();
    }
}
