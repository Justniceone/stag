<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Builder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'c:make
    {name : Class for example User}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '生成控制器模型：php artisan c:make 控制器名称';

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
        $name = $this->argument('name');
        if (!$name) exit('controller name required!');
        if (file_exists(app_path('Http\\Controllers\\Admin\\' . $name . 'Controller.php'))) exit($name . 'Controller already exists!');
        $this->createController($name);
        if (!file_exists(app_path('\Http\\Models\\' . $name . '.php'))) $this->createModel($name);
        if (!file_exists(app_path('Repositories\\' . $name . 'Repository.php'))) {
            if ($this->confirm('Do you wish to create Repo? [y|n]')) $this->createRepository($name);
        }
        //\File::append(base_path('routes/api.php'), 'Route::resource(\'' . str_plural(strtolower($name)) . "', '{$name}Controller');");
        \File::append(base_path('routes/api.php'), 'Route::get(\'' . strtolower($name) . "', '{$name}Controller@index');");
        \File::append(base_path('routes/api.php'), 'Route::post(\'' . 'create_' . strtolower($name) . "', '{$name}Controller@store');");
        \File::append(base_path('routes/api.php'), 'Route::get(\'' . 'detail_' . strtolower($name) . "', '{$name}Controller@show');");
        \File::append(base_path('routes/api.php'), 'Route::post(\'' . 'edit_' . strtolower($name) . "', '{$name}Controller@update');");
        \File::append(base_path('routes/api.php'), 'Route::post(\'' . 'delete_' . strtolower($name) . "', '{$name}Controller@destory');");
        echo 'Success';
    }

    protected function getStub($type)
    {
        return file_get_contents(resource_path("stubs\\$type.stub"));
    }

    protected function createModel($name)
    {
        $modelTemplate = str_replace(
            ['{{modelName}}', '{{modelNameSingularLowerCase}}'],
            [$name, strtolower($name)],
            $this->getStub('Model')
        );
        file_put_contents(app_path("Models/{$name}.php"), $modelTemplate);
    }

    protected function createController($name)
    {
        $controllerTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePluralLowerCase}}',
                '{{modelNameSingularLowerCase}}'
            ],
            [
                $name,
                strtolower(str_plural($name)),
                strtolower($name)
            ],
            $this->getStub('Controller')
        );
        file_put_contents(app_path("/Http/Controllers/Admin/{$name}Controller.php"), $controllerTemplate);
    }

    protected function createRepository($name)
    {
        $repositoryTemplate = str_replace(
            [
                '{{respisitoryName}}',
                '{{modelName}}'
            ],
            [
                $name . 'Repository',
                $name
            ],
            $this->getStub('Repository')
        );
        file_put_contents(app_path("/Repositories/{$name}Repository.php"), $repositoryTemplate);
    }
}