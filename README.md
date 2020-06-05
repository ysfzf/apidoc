## 使用方法
这是一个轻量级的在laravel上使用的接口文档自动生成工具包。这个项目来源于[ThinkPHP5的相同工具](https://github.com/skywalkerwei/yapi)，感谢原作者的付出。

#### 安装

1  使用composer安装依赖
```
composer require ycpfzf/apidoc
```
2  在config/app.php中添加服务项
````
 'providers' => [
        ...

     Ycpfzf\Apidoc\DocServiceProvider::class,

 ]
````
3  发布资源
````
php artisan vendor:publish
````
在列表中选择 Ycpfzf\Apidoc\DocServiceProvider，运行完毕会在config文件夹生成配置文件doc.php
,在public目录生成apidoc/assets目录，这里面是需要用到的css和js文件。


#### 使用

1 在配置文件中添加需要生成文档的控制器类名
````
 'controller' => [
        //需要生成文档的类
        'App\Http\Controllers\Api\Index'
    ],
````

2 在控制器类中添加注释，例如：
````
<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

/**
 * @title 用户
 * @description 用户信息
 * @group 公共分组
 * @header name:Authorization require:1 default: desc:Token
 *
 */
class Index extends Controller
{

    /**
     * @title 用户信息
     * @description 获取用户的基本信息
     * @author fzf
     * @url /api/user
     * @method get
     * @param name:page type:string require:0 default:1 other: desc:当前页
     * @param name:num type:string require:0 default:10 other: desc:每页记录数
     * @return token:名称
     */
    function index(){
        return [
            'status_code'=>200,
            'message'=>'success',
            'data'=>null,
            'time'=>time(),
        ];
    }
}
````
3 在浏览器打开 你的域名/doc 就可以看到接口文档了


