<?php

namespace Wecode\Generator\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class Resources extends Command
{
    protected $signature = 'resources:create {filename}';

    protected $description = 'Create controller, model, service and repository files';

    protected $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    public function handle()
    {
        echo 'I WORRRK';
    }
}