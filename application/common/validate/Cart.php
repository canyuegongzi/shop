<?php
namespace app\common\validate;

use think\Validate;

class Cart extends Validate
{
	protected $rule = [
        'goods_id|商品id' => 'require',
        'goods_attr_id|商品属性id' => 'require',
        'goods_number|商品数量' => 'require',
        'member_id|会员id' => 'require',

    ];
    /*添加固有属性验证场景*/
    public function sceneAdd() {
    	return $this->only(['goods_id', 'goods_attr_id', 'goods_number','member_id']);
    }
    /*编辑固有属性验证场景*/
    /*public function sceneEdit() {
    	return $this->only(['attr_name', 'attr_type', 'type_id']);
    }*/
}