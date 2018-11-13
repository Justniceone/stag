<?php

namespace Gyf\Stag;

use Illuminate\Support\ServiceProvider;

class StagServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/config.php' => config_path('stag.php'), // 发布配置文件到 laravel 的config 下
            __DIR__ . '/stubs/Controller.stub' => resource_path('stubs/Controller.stub'),
            __DIR__ . '/stubs/Model.stub' => resource_path('stubs/Model.stub'),
            __DIR__ . '/stubs/BasicModel.stub' => resource_path('stubs/BasicModel.stub'),
            __DIR__ . '/commands/Builder.php' => app_path('Console/Commands/Builder.php'),
        ]);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // 单例绑定服务
        $this->app->singleton('stag', function ($app) {
            return new Stag($app['session'], $app['config']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        // 因为延迟加载 所以要定义 provides 函数 具体参考laravel 文档
        return ['stag'];
    }
}
