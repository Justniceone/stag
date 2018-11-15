<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

## About Stag for Laravel

一键生成控制器crud操作和路由

##基本使用
<p>1.composer require gyf/stag</p>
<p>2.如果laravel < 5.5 添加服务提供者 Gyf\Stag\StagServiceProvider::class</p>
<p>3.发布文件 php artisan vendor:publish --provider="Gyf\Stag\StagServiceProvider"</p>
<p>会生成如下文件:</p>
Copied File [\vendor\gyf\stag\src\config\config.php] To [\config\stag.php]
Copied File [\vendor\gyf\stag\src\stubs\Controller.stub] To [\resources\stubs\Controller.stub]
Copied File [\vendor\gyf\stag\src\stubs\Model.stub] To [\resources\stubs\Model.stub]
Copied File [\vendor\gyf\stag\src\stubs\BasicModel.stub] To [\resources\stubs\BasicModel.stub]
Copied File [\vendor\gyf\stag\src\commands\Builder.php] To [\app\Console\Commands\Builder.php]
Copied File [\vendor\gyf\stag\src\traits\SearchForm.php] To [\app\Traits\SearchForm.php]
Copied File [\vendor\gyf\stag\src\controllers\BasicController.php] To [\app\Http\Controllers\BasicController.php]
</p>

<p>4.修改app\Console\Commands\Builder的命名空间为App\Console\Commands\Builder
修改app\config\stag.php中controller_dir控制器目录例：Api
</p>
<p>5.执行命令php artisan c:make 控制器名称例:Article
修改app\Traits\SearchForm的命名空间为App\Traits\SearchForm
拷贝app\resources\stubs\BasicModel到Models所在目录下改后缀名.php,
修改app\Http\Controllers\BasicController的命名空间以App开头
添加路由前缀和命名空间前缀
</p>

## about me

Thank you for using Stag
@me at https://packagist.org/packages/gyf/stag
## Version
v1.0

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
