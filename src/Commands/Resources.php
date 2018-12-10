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
//
//        $this->controller($name);
//        $this->request($name);
//        $this->resource($name);
        $this->model($name);
        $this->service($name);
        $this->repository($name);
    }

    protected function controller($origName)
    {
        $name = str_plural($origName) . 'Controller';

        $path = $this->getPath($name, 'Http/Controllers');

        if ($this->alreadyExists($path)) $this->error($name . ' already exists!');

        $controllerTemplate = str_replace(
            [
                '{{controllerName}}',
                '{{requestName}}',
                '{{serviceName}}',
                '{{serviceVarName}}'
            ],
            [
                $name,
                $origName . "\\" . $origName . 'CreateRequest',
                $origName . 'Service',
                strtolower($origName) . 'Service'
            ],
            $this->getStub('Controller')
        );

        file_put_contents($path, $controllerTemplate);
    }

    protected function request($originName)
    {
        $name = $originName . 'CreateRequest';
        $folder = $originName . '/' . $name;

        $path = $this->getPath($folder, 'Http/Requests');

        if ($this->alreadyExists($path)) $this->error($name . ' already exists!');

        $this->makeDirectory($path);

        $requestTemplate = str_replace(
            ['{{requestName}}', '{{folder}}'],
            [$name, $originName],
            $this->getStub('Request')
        );

        file_put_contents($path, $requestTemplate);
    }

    protected function resource($originName)
    {
        $name = $originName . 'CreateResource';
        $folder = $originName . '/' . $name;

        $path = $this->getPath($folder, 'Http/Resources');

        if ($this->alreadyExists($path)) $this->error($name . ' already exists!');

        $this->makeDirectory($path);

        $requestTemplate = str_replace(
            ['{{resourceName}}', '{{folder}}'],
            [$name, $originName],
            $this->getStub('Resource')
        );

        file_put_contents($path, $requestTemplate);
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

        file_put_contents($path, $modelTemplate);
    }

    protected function service($origName)
    {
        $name = $origName . 'Service';
        $path = $this->getPath($name, 'Services');

        if ($this->alreadyExists($path)) $this->error($name . ' already exists!');

        $this->makeDirectory($path);

        $serviceTemplate = str_replace(
            ['{{serviceName}}', '{{repositoryName}}', '{{repositoryVar}}', '{{var}}'],
            [$name, $origName . 'Repository', strtolower($origName) . 'Repository', strtolower($origName)],
            $this->getStub('Service')
        );

        file_put_contents($path, $serviceTemplate);
    }

    protected function repository($originName)
    {
        $name = $originName . 'Repository';
        $path = $this->getPath($name, 'Repositories');

        if ($this->alreadyExists($path)) $this->error($name . ' already exists!');

        $this->makeDirectory($path);

        $repositoryTemplate = str_replace(
            ['{{repositoryName}}', '{{modelName}}', '{{modelVar}}'],
            [$name, $originName, strtolower($originName)],
            $this->getStub('Repository')
        );

        file_put_contents($path, $repositoryTemplate);
    }

    protected function formatNames($name, $resource)
    {
        return $name . $resource;
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
        return file_get_contents("./packages/wecode/generator/src/stubs/$type.stub");
    }

    protected function rootNamespace()
    {
        return $this->laravel->getNamespace();
    }
}