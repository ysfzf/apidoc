<?php
namespace Ycpfzf\Apidoc;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;

class DocController extends Controller
{
    const PWD_KEY='apidoc_password';

    protected $doc;

    protected $assign=[];
    protected $mimeType = [
        'xml'  => 'application/xml,text/xml,application/x-xml',
        'json' => 'application/json,text/x-json,application/jsonrequest,text/json',
        'js'   => 'text/javascript,application/javascript,application/x-javascript',
        'css'  => 'text/css',
        'rss'  => 'application/rss+xml',
        'yaml' => 'application/x-yaml,text/yaml',
        'atom' => 'application/atom+xml',
        'pdf'  => 'application/pdf',
        'text' => 'text/plain',
        'png'  => 'image/png',
        'jpg'  => 'image/jpg,image/jpeg,image/pjpeg',
        'gif'  => 'image/gif',
        'csv'  => 'text/csv',
        'html' => 'text/html,application/xhtml+xml,*/*',
    ];

    public function __construct(Request $request = null)
    {
        $config=config('doc');
        $this->doc=new Doc($config);
        $root=url('');
        $this->assign=[
            'title'=>$this->doc->title,
            'version'=>$this->doc->version,
            'copyright'=>$this->doc->copyright,
            'static'=>$this->doc->static_path.'/assets',
            'root'=>$root,
            'url'=>$root.'/'.$this->doc->prefix,
            'api'=>$this->doc->api_prefix

        ];
    }

    /**
     * 验证密码
     * @return bool
     */
    protected function checkLogin()
    {
        $pass = $this->doc->__get("password");
        if($pass){
            if(session(self::PWD_KEY) === md5($pass)){
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
    }

    /**
     * 显示模板
     * @param $name
     * @param array $vars
     * @param array $replace
     * @param array $config
     * @return string
     */
    protected function show($name, $vars = [])
    {
        $this->assign=array_merge($this->assign,$vars);
        $view_path="{$this->doc->static_path}/views/{$name}.blade.php";
        return view('doc::'.$name,$this->assign);
    }

    /**
     * 登录
     * @return string
     */
    public function login(Request $request)
    {
        if($request->isMethod('post')){
            $pass = $this->doc->__get("password");
            if($pass && $request->post('pass') === $pass){
               session([self::PWD_KEY=>md5($pass)]);

                return ['status' => '200', 'message' => '登录成功'];
            }else if(!$pass){
                return ['status' => '200', 'message' => '登录成功'];
            }else{
                return ['status' => '300', 'message' => '密码错误'];
            }
            return ['status' => '500', 'message' => '未知错误'];
        }


        return $this->show('pass');

    }

    /**
     * 文档首页
     * @return mixed
     */
    public function index(Request $request)
    {

        if($this->checkLogin()){
            return $this->show('index', ['doc' => $request->input('doc')]);
        }else{
            return redirect('doc/login');
        }
    }

    /**
     * 文档搜素
     * @return mixed|\think\Response
     */
    public function search(Request $request)
    {

        if($request->isMethod('post'))
        {
            return $this->doc->searchList($request->input('query'));
        }
        else
        {
            $module = $this->doc->getModuleList();
            return $this->show('search', ['module' => $module]);
        }
    }

    /**
     * 设置目录树及图标
     * @param $actions
     * @return mixed
     */
    protected function setIcon($actions, $num = 1)
    {
        $assets_path='/'.$this->doc->static_path.'/assets';
        foreach ($actions as $key=>$moudel){
            if(isset($moudel['actions'])){
                $actions[$key]['iconClose'] = $assets_path."/js/zTree_v3/img/zt-folder.png";
                $actions[$key]['iconOpen'] = $assets_path."/js/zTree_v3/img/zt-folder-o.png";
                $actions[$key]['open'] = true;
                $actions[$key]['isParent'] = true;
                $actions[$key]['actions'] = $this->setIcon($moudel['actions'], $num = 1);
            }else{
                $actions[$key]['icon'] = $assets_path."/js/zTree_v3/img/zt-file.png";
                $actions[$key]['isParent'] = false;
                $actions[$key]['isText'] = true;
            }
        }
        return $actions;
    }

    /**
     * 接口列表
     * @return \think\Response
     */
    public function getList()
    {
        $list = $this->doc->getList();
        $list = $this->setIcon($list);
        return ['firstId'=>'', 'list'=>$list];
    }

    /**
     * 接口详情
     * @param string $name
     * @return mixed
     */
    public function getInfo(Request $request)
    {
        $name=$request->get('name','');
        list($class, $action) = explode("::", $name);
        //dd($class ,$action);
        $action_doc = $this->doc->getInfo($class, $action);
        if($action_doc)
        {
            $return = $this->doc->formatReturn($action_doc);
            $action_doc['header'] = isset($action_doc['header']) ? array_merge($this->doc->__get('public_header'), $action_doc['header']) : [];
            $action_doc['param'] = isset($action_doc['param']) ? array_merge($this->doc->__get('public_param'), $action_doc['param']) : [];
            return $this->show('info', ['doc'=>$action_doc, 'return'=>$return]);
        }
    }


    /**
     * 接口访问测试
     * @return \think\Response
     */
    public function debug()
    {
        $data = $this->request->param();
        $api_url = $this->request->param('url');
        $res['status'] = '404';
        $res['meaasge'] = '接口地址无法访问！';
        $res['result'] = '';
        $method =  $this->request->param('method_type', 'GET');
        $cookie = $this->request->param('cookie');
        $headers = $this->request->param('header/a', array());
        unset($data['method_type']);
        unset($data['url']);
        unset($data['cookie']);
        unset($data['header']);
        $res['result'] = http_request($api_url, $cookie, $data, $method, $headers);
        if($res['result']){
            $res['status'] = '200';
            $res['meaasge'] = 'success';
        }
        return response($res, 200, [], 'json');
    }
}
