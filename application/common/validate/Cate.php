<?php
namespace app\common\validate;

use think\Validate;

class Cate extends Validate
{
	protected $rule = [
        'catename|栏目名称' => 'require|unique:cate',
        'sort|排序' => 'require|number'
    ];
    /*添加图书栏目验证场景*/
    public function sceneAdd(){
    	return $this -> only(['catename', 'sort']);
    }
    /*图书栏目编辑验证场景*/
    public function sceneEdit(){
    	return $this -> only(['catename', 'sort']);
    }
}