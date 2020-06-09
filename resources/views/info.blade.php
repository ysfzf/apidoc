<html>
<head>
    <meta charset="utf-8">
    <title>{{$title??'api文档'}}</title>
    <base href="/{{$static}}" />
    <link href='/{{$static}}/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
    <link href='/{{$static}}/css/style.css' rel='stylesheet' type='text/css'>
    <script src="/{{$static}}/js/jquery-1.9.1.min.js" type="text/javascript"></script>
    <script src="/{{$static}}/js/bootstrap.min.js" type="text/javascript"></script>
    <link href='/{{$static}}/css/json.css' rel='stylesheet' type='text/css'>
    <script src="/{{$static}}/js/json.js" type="text/javascript"></script>
</head>

<body>
<div class="container">
    <div class="jumbotron">

        <h2>{{$doc['title']??'未知'}}</h2>
        <p>地址：{{$api}}{{$doc['url']??''}} <span class="label label-success">{{$doc['method']??''}}</span></p>

        <p class="bg-success">{{$doc['description']??''}}</p>

        <ul id="myTab" class="nav nav-tabs">
            <li class="active"><a href="#info" data-toggle="tab">接口信息</a></li>
            <li><a href="#test" data-toggle="tab">在线测试</a></li>
        </ul>
        <div class="tab-content">
            <!--info-->
            <div class="tab-pane fade in active" id="info">
            <br>

                @if(!empty($doc['header']))
                <div class="panel panel-primary" style="border-color: #00A881;">
                    <div class="panel-heading" style="border-color: #00A881;background-color: #00A881">
                        <h3>请求Headers</h3>
                    </div>
                    <div class="panel-body" id="span_result">
                        <table class="table table-striped" > <!-- style="table-layout: fixed" -->
                            <tr><th style="min-width: 100px">名称</th><th style="min-width: 100px">是否必填</th><th style="min-width: 100px">默认值</th><th>说明</th></tr>
                            @foreach($doc['header'] as $head)
                            <tr>
                                <td>{{$head['name']??''}}</td>
                                <td>@if($head['require']==1) 必填 @else 非必填 @endif</td>
                                <td>{{$head['default']??''}}</td>
                                <td>{{$head['desc']??''}}</td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>

                @endif

                @if(!empty($doc['param']))
                <div class="panel panel-primary" style="border-color: #00A881;">
                    <div class="panel-heading" style="border-color: #00A881;background-color: #00A881">
                        <h3>接口参数</h3>
                    </div>
                    <div class="panel-body" id="span_result">
                        <table class="table table-striped" >
                            <tr><th>参数名字</th><th>类型</th><th>是否必须</th><th>默认值</th><th>其他</th><th>说明</th></tr>
                            @foreach($doc['param'] as $param)

                            <tr>
                                <td>{{$param['name']??''}}</td>
                                <td>{{$param['type']??''}}</td>
                                <td>@if($param['require']==1)必填 @else 非必填 @endif</td>
                                <td>{{$param['default']??''}}</td>
                                <td>{{$param['other']??''}}</td>
                                <td>{{$param['desc']??''}}</td>
                            </tr>
                           @endforeach
                        </table>
                    </div>
                </div>
                @endif

                @if(!empty($doc['remark']))
                <div class="panel panel-primary" style="border-color: #00A881;">
                    <div class="panel-heading" style="border-color: #00A881;background-color: #00A881">
                        <h3>备注说明</h3>
                    </div>
                    <div class="panel-body" id="span_result">
                        <div role="alert" class="alert alert-info">
                            {{$doc['remark']}}
                        </div>
                    </div>
                </div>
               @endif
                <div class="panel panel-primary" style="border-color: #00A881;">
                    <div class="panel-heading" style="border-color: #00A881;background-color: #00A881">
                        <h3>返回结果</h3>
                    </div>
                    <div class="panel-body" id="span_result">
                        <p><code id="json_text">{!! $return??'' !!}</code></p>
                    </div>
                </div>
                <!-- <h3>返回结果</h3>
                <p><code>de id="json_text">{$return}</code></p> -->
            </div>
            <!--info-->
            <!--test-->
            <div class="tab-pane fade in" id="test">
                <br>
                <!--head-->
                <div class="panel panel-primary" style="border-color: #00A881">
                    <div class="panel-heading" style="border-color: #00A881;background-color: #00A881">
                        <h3 class="panel-title">接口参数</h3>
                    </div>
                    <div class="panel-body" style="overflow-x: hidden;">
                        <form id="apiform" class="form-horizontal" role="form">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">接口地址</label>
                                <div class="col-sm-6">
                                    <input class="form-control" type="text"  id="xmurl" name="url" value='{{$root}}{{$api}}{{$doc['url']}}'>
                                </div>
                                <!-- <div class="col-sm-4"><button type="button" id="send" class="btn btn-success" data-loading-text="Loading..." autocomplete="off">发送测试</button></div> -->
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">提交方式</label>
                                <div class="col-sm-6">
                                    <select class="form-control"  id="xmmethod_type" name="method_type">
                                        <option value="GET" @if(isset($doc['method']) && strtoupper($doc['method']) == 'GET') selected @endif>GET</option>
                                        <option value="POST"  @if(isset($doc['method']) && strtoupper($doc['method']) == 'POST') selected @endif>POST</option>
                                        <option value="PUT"  @if(isset($doc['method']) && strtoupper($doc['method']) == 'PUT') selected @endif>PUT</option>
                                        <option value="DELETE"  @if(isset($doc['method']) && strtoupper($doc['method']) == 'DELETE') selected @endif>DELETE</option>
                                    </select>
                                </div>
                                <div class="col-sm-4"></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Cookie</label>
                                <div class="col-sm-6">
                                    <textarea class="form-control" type="text" name="cookie">{{http_build_query($_COOKIE,'',';')}}</textarea>
                                </div>
                                <div class="col-sm-4"></div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12 gray-line"></div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2 control-label"></div>
                                <div class="col-sm-6"><h4>header</h4></div>
                                <div class="col-sm-4"></div>
                            </div>
                            @if(!empty($doc['header']))

                                @foreach($doc['header'] as $head)
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"> {{$head['name']}}</label>
                                    <div class="col-sm-6">
                                        <input class="form-control classHeaderInput" type="text" id="id{{$loop->index}}" name="{{$head['name']}}" value="{{$head['default']??''}}">
                                    </div>
                                    <div class="col-sm-4"><label class="control-label text-warning"></label></div>
                                </div>
                                @endforeach
                            @endif
                            <div class="form-group">
                                <div class="col-sm-12 gray-line"></div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2 control-label"></div>
                                <div class="col-sm-6"><h4>参数</h4></div>
                                <div class="col-sm-4"></div>
                            </div>


                            @if(!empty($doc['param']))

                            @foreach($doc['param'] as $param)
                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{$param['name']}}</label>
                                <div class="col-sm-6">
                                    <input class="form-control  classParamInput" type="text" name="{{$param['name']}}" value="{{$param['default']??''}}">
                                </div>
                                <div class="col-sm-4"><label class="control-label text-warning"></label></div>
                            </div>
                            @endforeach
                            @endif
                        </form>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">&nbsp;&nbsp;&nbsp;</label>
                            <div class="col-sm-6 flexBox">
                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#addParamModal">
                                    <span class="glyphicon glyphicon-plus"></span> 增加参数</button>
                                <button type="button" id="send" class="btn btn-success" data-loading-text="Loading..." autocomplete="off">发送测试</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--head-->

                <div class="panel panel-primary" style="border-color: #00A881;">
                    <div class="panel-heading" style="border-color: #00A881;background-color: #00A881">
                        <h3 class="panel-title">返回结果</h3>
                    </div>
                    <div class="panel-body" id="span_result">
                        <div class="form-inline result_body">
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addJosnTextmModal">自定义解析数据</button>
                            <label>缩进量:</label>
                            <select class="form-control" id="TabSize"  onchange="TabSizeChanged()">
                                <option value="1">1</option>
                                <option value="2" selected="true">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                            </select>
                            <input type="checkbox" id="QuoteKeys" onclick="QuoteKeysClicked()" checked="true"/> <label>引号</label>
                            <a href="javascript:void(0);" onclick="SelectAllClicked()">全选</a>
                            <a href="javascript:void(0);" onclick="ExpandAllClicked()">展开</a>
                            <a href="javascript:void(0);" onclick="CollapseAllClicked()">叠起</a>
                            <a href="javascript:void(0);" onclick="CollapseLevel(3)">2级</a>
                            <a href="javascript:void(0);" onclick="CollapseLevel(4)">3级</a>
                            <a href="javascript:void(0);" onclick="CollapseLevel(5)">4级</a>
                            <a href="javascript:void(0);" onclick="CollapseLevel(6)">5级</a>
                            <a href="javascript:void(0);" onclick="CollapseLevel(7)">6级</a>
                            <a href="javascript:void(0);" onclick="CollapseLevel(8)">7级</a>
                            <a href="javascript:void(0);" onclick="CollapseLevel(9)">8级</a>
                        </div>

                        <div id="Canvas" class="Canvas"></div>

                    </div>

                </div>

            </div>
            <!--test-->
        </div>


        <br/>
        <div role="alert" class="alert alert-info">
            {{$doc['name']??'未知'}}

        </div>
    </div>

    <p>&copy; {{$copyright}} <p>
</div>
<!-- 模态框（Modal） -->
<div class="modal fade" id="addParamModal" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close"
                        data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">增加参数</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">参数名</label>
                        <div class="col-sm-6">
                            <input class="form-control" type="text" name="addparam" value="">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary" id="addParam">提交</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<!-- 模态框（Modal） -->
<div class="modal fade" id="addJosnTextmModal" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close"
                        data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">输入需要解析的json文本...</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">JSON文本</label>
                        <div class="col-sm-10">
                            <textarea class="form-control"  name="jsonText" style="width:450px;height: 200px;"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" id="addJson">解析</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->

</div>
<script type="text/javascript">
    $(function () {
       

        $("#send").click(function(){
            var $btn = $(this).button('loading');

            var classInputFields = $(".classHeaderInput").serializeArray();
            var classParamFields = $(".classParamInput").serialize();


            $.ajax({
                type: $("#xmmethod_type").val(),
                url:  $("#xmurl").val(),
                data: classParamFields,
                headers: getFormJson(classInputFields),
                dataType:'json',
                success: function (data) {
                    window.json =JSON.stringify(data);
                    Process();
                    $btn.button('reset');
                },
                error:function(data){
                    if(data.responseText){
                        window.json =data.responseText;
                    }else{
                        window.json =JSON.stringify(data);
                    }
                    Process();
                    $btn.button('reset');
                },
                complete : function(XMLHttpRequest,status){
                    if(status == 'timeout'){
                        alert("网络超时");
                        $btn.button('reset');
                    }
                }
            });
        });

       
        window.ImgCollapsed = "/{{$static}}/img/Collapsed.gif";
        window.ImgExpanded = "/{{$static}}/img/Expanded.gif";
    });

    // function init(){

        $("#addParam").click(function(){
            var name = $('input[name="addparam"]').val();
            if(name.length > 0){
                var group = $("#apiform").find('.form-group').last().clone(true);
                $(group).find('.col-sm-2').text(name);
                $(group).find('.form-control').attr('name',name);
                $(group).find('.form-control').attr('value','');
                $(group).find('.text-warning').text('');
                $("#apiform").append(group);
            }
            $('#addParamModal').modal('hide');
        });

        $("#addJson").click(function(){
            window.json = $('textarea[name="jsonText"]').val();
            Process();
            $('#addJosnTextmModal').modal('hide');
        });
    // }


    function getFormJson(a) {
      var o = {};
      // var a = $(form).serializeArray();
      $.each(a, function () {
      if (o[this.name] !== undefined) {
      if (!o[this.name].push) {
      o[this.name] = [o[this.name]];
      }
      o[this.name].push(this.value || '');
      } else {
      o[this.name] = this.value || '';
      }
      });
      return o;
    }

</script>
</body>
</html>
