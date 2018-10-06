<?php
namespace app\common\validate;

use think\Validate;

class Goodsattr extends Validate
{
	protected $rule = [
        'attr_id|属性' => 'require',
        'attr_value|属性值' => 'require',
        'goods_id|商品id' => 'require',
        'id|属性id' => 'require'
    ];
    /*添加固有属性验证场景*/
    public function sceneAdd() {
    	return $this->only(['attr_id', 'attr_value', 'goods_id']);
    }
    public function sceneEdit() {
    	return $this->only(['attr_id', 'attr_value','id','goods_id']);
    }
}