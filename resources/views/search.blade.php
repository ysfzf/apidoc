<html>
<head>
    <meta charset="utf-8">
    <title>{{$title}}</title>
    <base href="/{{$static}}" />
    <link href='/{{$static}}/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
    <link href='/{{$static}}/css/style.css' rel='stylesheet' type='text/css'>
    <script src="/{{$static}}/js/jquery-1.9.1.min.js" type="text/javascript"></script>
    <script src="/{{$static}}/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/{{$static}}/js/zTree_v3/js/jquery.ztree.core-3.5.min.js" type="text/javascript"></script>
    <link href="/{{$static}}/js//zTree_v3/css/zTreeStyle/zTreeStyle.css" rel="stylesheet" />
    <style type="text/css">
        .title{text-align: center;margin: 100px auto;}
        .module{text-align: center;margin: 20px auto;}
        .search {position: relative;}
        .search .typeahead{width: 80%;font-size: 18px;line-height: 1.3333333;}
        .search input{width: 80%;display: inline-block;}
        .search button{height: 48px;width: 18%; margin-top: -5px; text-transform: uppercase;font-weight: bold;font-size: 14px; }
    </style>
    <script src="/{{$static}}/js/bootstrap-typeahead.js" type="text/javascript"></script>
</head>
<body>
<div class="container">
    <div class="title">
        <h1>{{$title}}</h1>
    </div>

    <div class="module">
        <ul class="nav nav-pills">
            @foreach($module as $group)
                @isset($group['children'])
                    <li role="presentation" class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                            {{$group['title']}} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            @foreach($group['children'] as $val)
                            <li role="presentation"><a href="#" module>{{$val['title']}}</a></li>
                            @endforeach
                        </ul>
                    </li>
                @else
                    <li role="presentation"><a href="#" module>{{$group['title']}}</a></li>
                @endisset
            @endforeach
        </ul>
    </div>

    <div class="form-group search">
        <input  id="search_input" class="form-control input-lg  ng-pristine ng-empty ng-invalid ng-invalid-required" type="text" placeholder="接口名称/接口信息/作者/接口地址" data-provide="typeahead" autocomplete="off">
        <button class="btn btn-lg btn-success" id="search" data-loading-text="Loading..." autocomplete="off"><i class="glyphicon glyphicon-search"></i> 搜 素</button>
    </div>

    <div class="result">
        <div class="list-group"></div>
    </div>
</div>
<script type="text/javascript">
    $(function () {

        function request(query,callback){
            $.ajax({
                type: "GET",
                url: "{{$url}}/search?query="+query,
                method:'post',
                dataType:'json',
                success: callback,
                complete : function(XMLHttpRequest,status){
                    if(status == 'timeout'){
                        alert("网络超时");
                        $btn.button('reset');
                    }
                }
            });
        }
        $('#search_input').typeahead({
            source: function (query, process) {
                request(query,function(data){
                    console.log(data)
                    var items = [];
                    $.each(data, function(index, doc){
                        if(doc.title){
                            items.push(doc.title);
                        }
                    });
                    process(items);
                });
            }
        });
        $('#search').click(function(){
            var query = $('#search_input').val();
            var $btn = $(this).button('loading');
            request(query,function(data){
                $(".result .list-group").html('');
                $.each(data, function(index, doc){
                    var item = '<a href="javascript:void(0)" class="list-group-item" name="'+ doc.name +'" title="'+ doc.title +'" doc>' +
                        '<span class="badge">'+ doc.author +'</span>' +
                        ''+ doc.title + '<span class="text-primary">('+ doc.url +')</span>'+'</a>';
                    $(".result .list-group").append(item);
                });
                $btn.button('reset');
            });

        });

        $('a[module]').click(function(){
            if(window.parent)
            {
                var zTree = window.parent.zTree;
                var node = zTree.getNodeByParam("title", $(this).text());
                zTree.selectNode(node);
            }
        });

        $(".result .list-group").on('click', 'a[doc]', function(){
            if(window.parent)
            {
                var zTree = window.parent.zTree;
                var node = zTree.getNodeByParam("name", $(this).attr('name'));
                window.parent.loadText(node.tId, $(this).attr('title'), $(this).attr('name'));
                zTree.selectNode(node);
            }
        });
    });
</script>

</body>
</html>
