<?php
namespace app\common\validate;

use think\Validate;

class Ordergoods extends Validate
{
	protected $rule = [
        'goods_id|商品id' => 'require',
        'goods_attr_id|商品属性' => 'require',
        'goods_number|商品数量' => 'require',
        'price|商品价格' => 'require',

    ];
    /*添加固有属性验证场景*/
    public function sceneAdd() {
    	return $this->only(['goods_id', 'goods_attr_id', 'goods_number','price']);
    }
    /*编辑固有属性验证场景*/
    public function sceneEdit() {
    	return $this->only(['attr_name', 'attr_type', 'type_id']);
    }
}