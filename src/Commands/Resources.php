<?php

namespace Wecode\Generator\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class Resources extends Command
{
    protected $signature = 'resources:create {name}';

    protected $description = 'Create controller, model, service and repository files';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $name = $this->getNameInput();

        $this->controller($name);
        $this->model($name);
        $this->service($name);
        $this->repository($name);
    }

    protected function controller($name)
    {
        $name = str_plural($name) . 'Controller';

        $controllerTemplate = str_replace(
            ['{{controllerName}}'],
            [$name],
            $this->getStub('Controller')
        );

        file_put_contents(app_path("/Http/Controllers/{$name}.php"), $controllerTemplate);
    }

    protected function model($name)
    {
        $path = $this->getPath($name, 'Models');

        if ($this->alreadyExists($path)) $this->error($name . ' already exists!');

        $this->makeDirectory($path);

        $modelTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Model')
        );

        file_put_contents(app_path("Models/{$name}.php"), $modelTemplate);
    }

    protected function service($name)
    {
        $name = $name . 'Service';
        $path = $this->getPath($name, 'Services');

        if ($this->alreadyExists($path)) $this->error($name . ' already exists!');

        $this->makeDirectory($path);

        $serviceTemplate = str_replace(
            ['{{serviceName}}'],
            [$name],
            $this->getStub('Service')
        );

        file_put_contents(app_path("Services/{$name}.php"), $serviceTemplate);
    }

    protected function repository($name)
    {
        $name = $name . 'Repository';
        $path = $this->getPath($name, 'Repositories');

        if ($this->alreadyExists($path)) $this->error($name . ' already exists!');

        $this->makeDirectory($path);

        $repositoryTemplate = str_replace(
            ['{{repositoryName}}'],
            [$name],
            $this->getStub('Repository')
        );

        file_put_contents(app_path("Repositories/{$name}.php"), $repositoryTemplate);
    }

    protected function getPath($name, $folder)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return $this->laravel['path'] . '/' . $folder . '/' . str_replace('\\', '/', $name) . '.php';
    }

    protected function getNameInput()
    {
        return trim($this->argument('name'));
    }

    protected function makeDirectory($path)
    {
        if (!is_dir(dirname($path))) {
            mkdir(dirname($path), 0777, true);
        }

        return $path;
    }

    protected function alreadyExists($path)
    {
        return file_exists($path);
    }

    protected function getStub($type)
    {
        return file_get_contents("./packages/wecode/generator/src/resources/$type.stub");
    }

    protected function rootNamespace()
    {
        return $this->laravel->getNamespace();
    }
}