<?php
namespace app\common\validate;

use think\Validate;

class Attrnum extends Validate
{
	protected $rule = [
        'attr_name|属性名称' => 'require',
        'attr_type|属性的特性' => 'require',
        'type_id|分类id' => 'require'
    ];
    /*添加固有属性验证场景*/
    public function sceneAdd() {
    	return $this->only(['attr_name', 'attr_type', 'type_id']);
    }
    /*编辑固有属性验证场景*/
    public function sceneEdit() {
    	return $this->only(['attr_name', 'attr_type', 'type_id']);
    }
}