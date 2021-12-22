<?php

/* env配置示例
    DOC_PREFIX=doc
    DOC_API_PREFIX=
    DOC_TITLE=API文档
    DOC_VERSION=1.0
    DOC_COPYRIGHT='Powered By XXX'
    DOC_PASSWORD=

 */
return [
    'prefix'=>env('DOC_PREFIX','doc'), //访问前缀
    'api_prefix'=>env('DOC_API_PREFIX',''), //api请求前缀
    'title' => env('DOC_TITLE','API文档'),  //文档title
    'version'=>env('DOC_VERSION','1.0.0'), //文档版本
    'copyright'=>env('DOC_COPYRIGHT','Powered By XXX'), //版权信息
    'password' => env('DOC_PASSWORD',''), //访问密码，为空不需要密码

    'static_path' => 'apidoc', //视图，css,js文件路径
    'controller' => [
        //需要生成文档的类
        'App\Http\Controllers\Api\Auth',
        'App\Http\Controllers\Api\Index',
    ],
    'filter_method' => [
        //过滤 不解析的方法名称
    ],
    'return_format' => [
        //返回数据格式
        ['name'=>'code','type'=>'int','desc'=>'返回码'],
        ['name'=>'msg','type'=>'string','desc'=>'信息'],
        ['name'=>'time','type'=>'int','desc'=>'时间戳']
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
