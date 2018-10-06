<?php
namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class Comment extends Model
{
    //软删除
    use SoftDelete;
  
  	//关联会员的信息
  	public function memberInfo()
  	{
  		return $this->belongsTo('Member', 'member_id', 'id')->field('id,username,face,jifen');
  	}
  	//关联商品的信息
  	public function goodInfo()
  	{
  		return $this->belongsTo('Good', 'goods_id', 'id')->field('id,goods_name,sm_logo,market_price');
  	}
    public function add($data) 
    {
    	$validate = new \app\common\validate\Comment();
    	if(!$validate -> scene('add') -> check($data)){
    		return $validate -> getError();
    	};
    	$result = $this->allowField(true)->save($data);
    	if($result) {
    		return 1;
    	}else {
    		return '添加成功';
    	}
    }
     /*属性的编辑*/
    public function edit($data) 
    {

    	$validate = new \app\common\validate\Comment();
    	if(!$validate ->scene('edit') -> check($data)) {
    		return $validate -> getError();
    	}
    	$commentInfo = $this->find($data['id']);
    	$commentInfo->member_id = $data['member_id'];
    	$commentInfo->content = $data['content'];
    	$commentInfo->star = $data['star'];
    	$result = $commentInfo -> save();
    	if($result == 1){
    		return 1;
    	}else {
    		return '未做任何修改';
    	}
    }
    /*属性的删除*/
    public function del($data) 
    {
    	
    	$commentInfo = $this->find($data['id']);
    	//dump($commentInfo);
    	$result = $commentInfo->delete();
    	if($result){
    		return '删除成功';
    	}
    	return '删除失败';
    }

}