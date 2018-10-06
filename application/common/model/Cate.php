<?php
namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class Cate extends Model
{
    //软删除
    use SoftDelete;

    /*图书栏目添加*/
    public function add($data) {
    	$validate = new \app\common\validate\Cate();
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
    	$validate = new \app\common\validate\Cate();
    	if(!$validate ->scene('edit') -> check($data)) {
    		return $validate -> getError();
    	}
    	$catenameInfo = $this->find($data['id']);
    	$catenameInfo->catename = $data['catename'];
    	$catenameInfo->sort = $data['sort'];
    	$result = $catenameInfo -> save();
    	if($result == 1){
    		return 1;
    	}else {
    		return '编辑失败';
    	}
    }
    /*图书首页的栏目的删除*/
    public function del($data) {
    	$catenameInfo = $this->find($data['id']);
    	$result = $catenameInfo->delete();
    	if($result){
    		return 1;
    	}else{
    		return '删除失败';
    	}
    }
}