<?php

namespace Wecode\Pattern\Commands;

use Illuminate\Console\Command;

class Resources extends Command
{
    protected $signature = 'resources:create {filename}';

    protected $description = 'Create controller, model, service and repository files';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        echo 'I WORRRK';
    }
}