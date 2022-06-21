## About
This is an automatic API interface document generation tool based on laravel.

## Requirements
* PHP >= 7.0.0
* Laravel >= 5.5.0
* Fileinfo PHP Extension

## Installation
 
First
```
composer require ycpfzf/apidoc
```

Then run these commands to publish assets and config：
 
````
php artisan vendor:publish --provider="Ycpfzf\Apidoc\DocServiceProvider"
````

## Config

The file config/admin.php contains an array of configurations, you can find the default configurations in there.

 
````
 'controller' => [
      
        'App\Http\Controllers\Api\Index'
    ],
````

## Use

Add comments to the controller class, for example:
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
Open the http://your-url/doc to view the API documentation
 
## Security Vulnerabilities

 If you discover a security vulnerability, please send an email [ysfzf@hotmail.com](mailto:ysfzf@hotmail.com). All security vulnerabilities will be promptly addressed.

## License

The APIDOC is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).


