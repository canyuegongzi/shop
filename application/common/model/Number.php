<?php
namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class Number extends Model
{
    //软删除
    use SoftDelete;

	//添加库存
	public function add($data){
		/*dump($data);die();*/
		$validate = new \app\common\validate\Number();
    	if(!$validate -> scene('add') -> check($data)){
    		return $validate -> getError();
    	}
    	$result = $this->allowField(true)->save($data);
    	if($result) {
    		return 1;
    	}else {
    		return '添加成功';
    	}
	}

	//修改库存
	public function edit($data){
		$validate = new \app\common\validate\Number();
    	if(!$validate ->scene('edit') -> check($data)) {
    		return $validate -> getError();
    	}
    	$numberInfo = $this->where(['goods_attr_id' => $data['goods_attr_id'],'goods_id'=> $data['goods_id']])->find();
    	$numberInfo->goods_number = $data['goods_number'];
    	$result = $numberInfo -> save();
    	if($result == 1){
    		return 1;
    	}else {
    		return '编辑失败';
    	}
	}
	
}