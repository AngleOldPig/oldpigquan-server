<?php
namespace Home\Controller;

use Think\Controller;
class TestController extends BaseController {
	
    public function test(){
    	echo 123;
    }

    public function insertTest(){

    	//实例化数据表
    	$Message = M('Message');

    	//组装插入的数据
    	$data = array();
    	$data['user_id'] = 1;
    	$data['username'] = 'AOP';
    	$data['face_url'] = '404.jpg';
    	$data['content'] = '前排就坐';
    	$data['total_likes'] = 0;
    	$data['send_timestamp'] = time();

    	//插入数据
    	$result = $Message->add($data);

    	var_dump($result);

    	var_dump($Message->getLastSql())
    }


    public function selectTest(){
    	//实例化数据表
    	$Message = M('message');

    	//设置查询条件
    	$where = array();
    	$where['user_id'] = 1;

    	//查询数据
    	$all_message = $Message->where($where)->select();

    	dump($all_message);

    	dump($Message->getLastSql());
    }

    public function findTest(){
    	//实例化数据库表
    	$Message = M('Message');

    	//设置查询条件
    	$where = array();
    	$where['user_id'] = 1;

    	//查询数据
    	$all_message = $Message->where($where)->find();

    	dump($all_message);

    	dump($Message->getLastSql());
    }

    public function saveTest(){
    	//实例化数据表
    	$Message = M('Message');

    	//设置修改条件
    	$where = array();
    	$where['id'] = 1;

    	//要保存的数据
    	$data = array();
    	$data['total_likes'] = 1;

    	//保存
    	$result = $Message->where($where)->save($data);

    	dump($result);
    }

    public function deleteTest(){
    	//实例化数据表
    	$Message = M('Message');

    	//设置条件
    	$where = array();
    	$where['id'] = 1;

    	//删除
    	$result = $Message->where($where)->delete();

    	dump($result);
    }

}