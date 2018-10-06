<?php
namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class Brand extends Model
{
    //软删除
    use SoftDelete;
    /*图书栏目添加*/
    public function add($data) {
    	$validate = new \app\common\validate\Brand();
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
    /*图书栏目编辑*/
    public function edit($data) {
    	$validate = new \app\common\validate\Brand();
    	if(!$validate ->scene('edit') -> check($data)) {
    		return $validate -> getError();
    	}
    	$brandInfo = $this->find($data['id']);
    	$brandInfo->brand_name = $data['brand_name'];
    	$brandInfo->desc = $data['desc'];
    	$result = $brandInfo -> save();
    	if($result == 1){
    		return 1;
    	}else {
    		return '编辑失败';
    	}
    }
    /*图书首页的栏目的删除*/
    public function del($data) {
    	$brandInfo = $this->find($data['id']);
    	$result = $brandInfo->delete();
    	if($result){
    		return 1;
    	}else{
    		return '删除失败';
    	}
    }
}