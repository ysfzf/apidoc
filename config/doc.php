<?php
return [
    'directory'=>'Doc',
    'prefix'=>'doc', //访问前缀
    'title' => "APi接口文档",  //文档title
    'version'=>'1.0.0', //文档版本
    'copyright'=>'Powered By ypai', //版权信息
    'password' => '', //访问密码，为空不需要密码
    'static_path' => 'apidoc', //视图，css,js文件路径
    'controller' => [
        //需要生成文档的类
        'App\Http\Controllers\Api\Auth',
        'App\Http\Controllers\Api\Index'
    ],
    'filter_method' => [
        //过滤 不解析的方法名称
        '_empty'
    ],
    'return_format' => [
        //数据格式
        'code' => "1/200/300/301/302",
        'msg' => "提示信息",
        "time"=> '时间戳',
    ],
    'public_header' => [
        //全局公共头部参数
        //如：['name'=>'version', 'require'=>1, 'default'=>'', 'desc'=>'版本号(全局)']
    ],
    'public_param' => [
        //全局公共请求参数，设置了所以的接口会自动增加次参数
        //如：['name'=>'token', 'type'=>'string', 'require'=>1, 'default'=>'', 'other'=>'' ,'desc'=>'验证（全局）')']
    ],
];
