<?php
namespace app\api\controller\v1;

use think\Controller;
use think\Request;
class Comment extends Controller
{
	// 添加固有的属性和属性值
	public function add(){
		if(request()->isPost()){
			$data = [
				'member_id' => input('post.memberId'),
				'goods_id' => input('post.goodId'),
				'content' => input('post.content'),
				'star' => input('post.star')
			];
			$result = model('Comment')->add($data);
			if($result == 1){
				return json(['msg'=>'success','code'=>200,'data'=>$result]);
			}
			return json(['msg'=>'fail','code'=>304,'data'=>$result]);
		}
	}
	/*属性编辑*/
	public function edit() {
		if(request()->isPost()) {
			$data = [
				'id' => input('post.id'),
				'member_id' => input('post.memberId'),
				'content' => input('post.content'),
				'star' => input('post.star')
			];
			$result = model('Comment')->edit($data);
			if($result == 1) {
				return json(['msg' => 'success', 'code' => '200','data'=>$result]);
			}else {
				return json(['msg' => $result, 'code' => '404','data'=>$result]);
			}
		}else {
			return json(['msg' => 'error', 'code' => '304','data'=>null]);
		}		
	}
	/*属性删除*/
	public function del() {
		if(request()->isPost()){
			$data = [
				'id' => input('post.id')
			];
			$result = model('Comment')->del($data);
    		if ($result == 1) {
            	return json(['msg' => 'success', 'code' => '200' ]);
        	}else {
            	return json(['msg' => $result, 'code' => '404']);
        	}
		}else {
			return json(['msg' => 'error', 'code' => '304']);
		}
	}
	/*属性列表*/
	public function all(){
		
		if(request()) {
			input('page')? $page = input('page') : $page = 1;
			//dump($page);die();
            $result = model('Comment')->with('memberInfo,goodInfo')->field('id,goods_id,member_id,content,star,create_time,update_time')->order(['create_time' => 'desc'])->paginate(10,false,['query' => $page]);
            if($result) {
            	return json(['msg' => 'success', 'code' => 200, 'data' => $result]);
            }
			return json(['msg' => 'fail', 'code' => 404, 'data' => null]);        
		}
		return json(['msg' => 'fail', 'code' => 304, 'data' => null]);  
	}

/*//*->field()*/
	/*属性搜索*/
	public function query(){
		input('page')? $page = input('page'): $page = 1;
		input('good')? $good = input('good'): $good = null;
		input('member')? $member = input('member'): $member = null;
		//dump($good);die();
		if($good){
			$id = model('Good')->where('goods_name', 'like', '%' . $good . '%')->value('id');
			$memberInfo = model('Comment')->where('goods_id',$id)->with('memberInfo,goodInfo')->field('id,goods_id,member_id,content,star,create_time,update_time')->order(['create_time' => 'desc'])->paginate(10,false,['query' => $page]);
			if($memberInfo) {
				return json(['msg'=>'success','code'=>200,'data'=>$memberInfo]);				
			}
			return json(['msg' => 'fail', 'code' => 404, 'data' => null]); 
		}else if($member){
			$id = model('Member')->where('username', 'like', '%' . $member . '%')->value('id');
			$memberInfo = model('Comment')->where('member_id',$id)->with('memberInfo,goodInfo')->field('id,goods_id,member_id,content,star,create_time,update_time')->order(['create_time' => 'desc'])->paginate(10,false,['query' => $page]);
			if($memberInfo) {
				return json(['msg'=>'success','code'=>200,'data'=>$memberInfo]);				
			}
			return json(['msg' => 'fail', 'code' => 404, 'data' => null]); 
		}else{
			$memberInfo = model('Comment')->with('memberInfo,goodInfo')->field('id,goods_id,member_id,content,star,create_time,update_time')->order(['create_time' => 'desc'])->paginate(10,false,['query' => $page]);
			if($memberInfo) {
				return json(['msg'=>'success','code'=>200,'data'=>$memberInfo]);				
			}
			return json(['msg' => 'fail', 'code' => 404, 'data' => null]); 
		}
	}      
}
