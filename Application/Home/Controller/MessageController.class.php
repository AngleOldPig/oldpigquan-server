<?php
namespace Home\Controller;

use Think\Controller;
class MessageController extends BaseController {
	
    /**
     * 发布新树洞
     */
    public function publish_new_message(){
        
        //检查参数是否存在
        if (!$_POST['user_id']) {
        	
        	$return_data = array();
        	$return_data['error_code'] = 1;
        	$return_data['msg'] = '参数不足：user_id';

        	$this->ajaxReturn($return_data);
        }

        if (!$_POST['username']) {
        	
        	$return_data = array();
        	$return_data['error_code'] = 1;
        	$return_data['msg'] = '参数不足：username';

        	$this->ajaxReturn($return_data);
        }

        if (!$_POST['face_url']) {
        	
        	$return_data = array();
        	$return_data['error_code'] = 1;
        	$return_data['msg'] = '参数不足：face_url';

        	$this->ajaxReturn($return_data);
        }

        if (!$_POST['content']) {
        	
        	$return_data = array();
        	$return_data['error_code'] = 1;
        	$return_data['msg'] = '参数不足：content';

        	$this->ajaxReturn($return_data);
        }

        $Message = M('Message');


        // 设置要插入的数据
        $data = array();
        $data['user_id'] = $_POST['user_id'];	// 用户id
        $data['username'] = $_POST['username'];	// 用户名
        $data['face_url'] = $_POST['face_url'];	// 头像
        $data['content'] = $_POST['content'];	// 消息内容
        $data['total_likes'] = 0;	// 点赞数
        $data['send_timestamp'] = time();	// 当前时间戳

        // 执行插入数据
        $result = $Message->add($data);

        if ($result) {
        	
        	$return_data = array();
        	$return_data['error_code'] = 0;
        	$return_data['msg'] = '数据添加成功';

        	$this->ajaxReturn($return_data);
        }
        else{

        	$return_data = array();
        	$return_data['error_code'] = 2;
        	$return_data['msg'] = '数据添加失败';

        	$this->ajaxReturn($return_data);
        }

        //dump($_POST);
    }

    // 得到所有树洞
    public function get_all_messages(){

    	// 实例化数据表
    	$Message = M('Message');

    	// 设置查询条件

    	// 获取所有树洞
    	$all_messages = $Message->select();
    }

}

