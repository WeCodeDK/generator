<?php

namespace Wecode\ServiceRepository\Commands;

use Illuminate\Console\Command;

class CreateCommand extends Command
{
    protected $signature = 'create:resources';

    protected $description = 'Create controller, model, service and repository files';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

    }
}