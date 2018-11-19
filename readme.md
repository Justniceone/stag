![](https://laravel.com/assets/img/components/logo-laravel.svg)

### About Stag for Laravel

一键生成控制器crud操作和路由

### 基本使用
- composer require gyf/stag [dev-master]
- 如果laravel < 5.5 添加服务提供者 Gyf\Stag\StagServiceProvider::class
- 发布文件 php artisan vendor:publish --provider="Gyf\Stag\StagServiceProvider"

会生成如下文件:
````
Copied File [\vendor\gyf\stag\src\config\config.php] To [\config\stag.php]
Copied File [\vendor\gyf\stag\src\stubs\Controller.stub] To [\resources\stubs\Controller.stub]
Copied File [\vendor\gyf\stag\src\stubs\Model.stub] To [\resources\stubs\Model.stub]
Copied File [\vendor\gyf\stag\src\stubs\BasicModel.stub] To [\resources\stubs\BasicModel.stub]
Copied File [\vendor\gyf\stag\src\commands\Builder.php] To [\app\Console\Commands\Builder.php]
Copied File [\vendor\gyf\stag\src\traits\SearchForm.php] To [\app\Traits\SearchForm.php]
Copied File [\vendor\gyf\stag\src\controllers\BasicController.php] To [\app\Http\Controllers\BasicController.php]
````

- 修改app\Console\Commands\Builder的命名空间为App\Console\Commands\Builder
app\config\stag.php中controller_dir为生成控制器的目录例：Api

- 执行命令php artisan c:make 控制器名称例:Article
修改app\Traits\SearchForm的命名空间为App\Traits\SearchForm
拷贝app\resources\stubs\BasicModel到Models所在目录下改后缀名.php,
修改app\Http\Controllers\BasicController的命名空间以App开头
添加路由前缀和命名空间前缀

### about stag
详情请见:
[gyf/stag](https://packagist.org/packages/gyf/stag)
### Version
dev-master

### License

[MIT license](https://opensource.org/licenses/MIT).

### end
> 一盏灯， 一片昏黄； 一简书， 一杯淡茶。 守着那一份淡定， 品读属于自己的寂寞。 保持淡定， 才能欣赏到最美丽的风景！ 保持淡定， 人生从此不再寂寞。
