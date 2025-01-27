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

    // 得到所有信息
    public function get_all_messages(){

    	// 实例化数据表
    	$Message = M('Message');

    	// 设置查询条件

    	// 获取所有树洞并按时间倒序
    	$all_messages = $Message->order('id desc')->select();
    	
    	// 将所有的时间戳转换为yyyy-mm-dd hh:ii:ss
    	foreach ($all_messages as $key => $message) {
    		
    		$all_messages[$key]['send_timestamp'] = date('Y-m-d H:i:s', $message['send_timestamp']);
    	}

    	$return_data = array();
    	$return_data['error_code'] = 0;
    	$return_data['msg'] = '数据获取成功';
    	$return_data['data'] = $all_messages;

    	$this->ajaxReturn($return_data);

    	// dump($all_messages);
    }

    // 得到用户所有信息
    public function get_one_user_all_messages(){

    	// 1.检查参数是否存在
        if (!$_POST['user_id']) {
        	
        	$return_data = array();
        	$return_data['error_code'] = 1;
        	$return_data['msg'] = '参数不足：user_id';

        	$this->ajaxReturn($return_data);
        }
        
        // 2.获取所有消息：

        // 实例化数据表
    	$Message = M('Message');

    	// 设置查询条件
    	$where = array();
    	$where['user_id'] = $_POST['user_id'];

    	// 查询数据并按时间倒序
    	$user_all_messages = $Message->where($where)->order('id desc')->select();

    	// 将所有的时间戳转换为yyyy-mm-dd hh:ii:ss
    	foreach ($user_all_messages as $key => $message) {
    		
    		$user_all_messages[$key]['send_timestamp'] = date('Y-m-d H:i:s', $message['send_timestamp']);
    	}

    	// 3.组装返回数据
    	$return_data = array();
    	$return_data['error_code'] = 0;
    	$return_data['msg'] = '用户消息获取成功';
    	$return_data['data'] = $user_all_messages;

    	$this->ajaxReturn($return_data);

    	// dump($user_all_message);

    	// dump($Message->getLastSql());
        
    }

    // 点赞接口
    public function do_like(){

    	// 1.校验参数
    	if (!$_POST['message_id']) {
    		
    		$return_data = array();
    		$return_data['error_code'] = 1;
    		$return_data['msg'] = '参数不足：message_id';

    		$this->ajaxReturn($return_data);
    	}

    	if (!$_POST['user_id']) {
    		
    		$return_data = array();
    		$return_data['error_code'] = 1;
    		$return_data['msg'] = '参数不足：user_id';

    		$this->ajaxReturn($return_data);
    	}


    	// 2.判断是否有该用户发送的这条消息：

		// 实例化数据表
    	$Message = M('Message');

    	// 查询条件
    	$where = array();
    	$where['id'] = $_POST['message_id'];

    	$message = $Message->where($where)->find();

    	// 判断是否存在该消息
    	if (!$message) {
    		
    		$return_data = array();
    		$return_data['error_code'] = 2;
    		$return_data['msg'] = '该消息不存在';

    		$this->ajaxReturn($return_data);
    	}

    	// 3.检查结束，执行点赞操作：

    	// 构造要保存的点赞数据
    	$data = array();
    	$data['total_likes'] = $message['total_likes'] + 1;

    	// 保存点赞数据
    	$where = array();
    	$where['id'] = $_POST['message_id'];

    	$result = $Message->where($where)->save($data);

    	if ($result) {
    		
    		$return_data = array();
    		$return_data['error_code'] = 0;
    		$return_data['msg'] = '点赞数据保存成功';
    		$return_data['data']['message_id'] = $_POST['message_id'];
    		$return_data['data']['total_likes'] = $data['total_likes']; 

    		$this->ajaxReturn($return_data);
    	}
    	else{

    		$return_data = array();
    		$return_data['error_code'] = 3;
    		$return_data['msg'] = '点赞数据保存失败';
    		$return_data['data']['message_id'] = $_POST['message_id'];

    		$this->ajaxReturn($return_data);
    	}

    }

    //消息删除接口
    public function delete_message(){

    	// 1.校验参数
    	if (!$_POST['message_id']) {
    		
    		$return_data = array();
    		$return_data['error_code'] = 1;
    		$return_data['msg'] = '参数不足：message_id';

    		$this->ajaxReturn($return_data);
    	}

    	if (!$_POST['user_id']) {
    		
    		$return_data = array();
    		$return_data['error_code'] = 1;
    		$return_data['msg'] = '参数不足：user_id';

    		$this->ajaxReturn($return_data);
    	}

    	// 2.判断是否存在这条消息：

		// 实例化数据表
    	$Message = M('Message');

    	// 查询条件
    	$where = array();
    	$where['id'] = $_POST['message_id'];

    	$message = $Message->where($where)->find();

    	// 判断是否存在该消息
    	if (!$message) {
    		
    		$return_data = array();
    		$return_data['error_code'] = 2;
    		$return_data['msg'] = '指定的消息数据查询不存在';

    		$this->ajaxReturn($return_data);
    	}

    	// 3.执行删除操作

    	// 删除数据
    	$where = array();
    	$where['id'] = $_POST['message_id'];

    	$result = $Message->where($where)->delete();

    	// 根据结果返回信息
    	if ($result) {
    		
    		$return_data = array();
    		$return_data['error_code'] = 0;
    		$return_data['msg'] = '消息删除成功';
    		$return_data['data']['message_id'] = $_POST['message_id'];

    		$this->ajaxReturn($return_data);
    	}
    	else{

    		$return_data = array();
    		$return_data['error_code'] = 3;
    		$return_data['msg'] = '消息删除失败';
    		$return_data['data']['message_id'] = $_POST['message_id'];

    		$this->ajaxReturn($return_data);
    	}
    }

}

