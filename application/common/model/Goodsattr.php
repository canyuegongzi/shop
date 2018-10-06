<?php
namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class Goodsattr extends Model
{
    //软删除
    use SoftDelete;
    //关联属性 列表
    public function attr(){
    	return $this->belongsTo('Attrnum', 'attr_id', 'id','attr')->field('attr_name,id,attr_type,attr_option_values,type_id');
    }

    /*添加操作*/
    public function add($data) {

    	if($data['attr_id']){
    		$id = model('Attrnum')->where(['attr_name'=>$data['attr_id']])->value('id');
    		$data['attr_id'] = $id;
    	}else {
    		return '添加失败';
    	}   	
    	$validate = new \app\common\validate\Goodsattr();
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
    public function edit($data) {

    	if($data['attr_id']){
    		$id = model('Attrnum')->where(['attr_name'=>$data['attr_id']])->value('id');
    		$data['attr_id'] = $id;
    	}else {
    		return '修改失败';
    	}   	
    	//dump($data);die();
    	$validate = new \app\common\validate\Goodsattr();
    	if(!$validate -> scene('edit') -> check($data)){
    		return $validate -> getError();
    	};
    	$attrInfo = $this->where('goods_id', $data['goods_id'])->where('id' , $data['id'])->find();
    	
    	$attrInfo->attr_id = $data['attr_id'];
    	$attrInfo->attr_value = $data['attr_value'];
    	$result = $attrInfo -> save();
    	if($result == 1){
    		return 1;
    	}else {
    		return '未做任何修改';
    	}
    }
    
}