<?php
namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class Attrnum extends Model
{
    //软删除
    use SoftDelete;
    //属性的添加
    public function type(){
    	return $this->belongsTo('Type', 'type_id', 'id')->field('type_name,id');
    }
    //关联商品的属性
    public function goodsattr(){
        return $this->hasMany('Goodsattr', 'attr_id', 'id');
    }
    public function add($data) {
    	if($data['type_id']){
    		$id = model('Type')->where(['type_name'=>$data['type_id'],'level'=>1])->value('id');
    		$data['type_id'] = $id;
    	}else {
    		return '添加失败';
    	}   	
    	$validate = new \app\common\validate\Attrnum();
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

    	if($data['type_id']){
    		$id = model('Type')->where(['type_name'=>$data['type_id'],'level'=>1])->value('id');
    		$data['type_id'] = $id;
    	}else {
    		return '添加失败';
    	}
    	$validate = new \app\common\validate\Attrnum();
    	if(!$validate ->scene('edit') -> check($data)) {
    		return $validate -> getError();
    	}
    	$attrInfo = $this->find($data['id']);
    	$attrInfo->attr_name = $data['attr_name'];
    	$attrInfo->attr_type = $data['attr_type'];
    	$attrInfo->attr_option_values = $data['attr_option_values'];
    	$attrInfo->type_id = $data['type_id'];
    	$result = $attrInfo -> save();
    	if($result == 1){
    		return 1;
    	}else {
    		return '编辑失败';
    	}
    }
    /*属性的删除*/
    public function del($data) {
    	$attrInfo = $this->with('goodsattr')->find($data['id']);
    	$result = $attrInfo->together('goodsattr')->delete();
    	if($result){
    		return 1;
    	}else{
    		return '删除失败';
    	}
    }
}