<?php
namespace app\common\validate;

use think\Validate;

class Number extends Validate
{
	protected $rule = [
        'goods_id|商品id' => 'require',
        'goods_number|库存量' => 'require',
        'goods_attr_id|组合形式' => 'require'
    ];
    /*添加图书栏目验证场景*/
    public function sceneAdd(){
    	return $this -> only(['goods_id', 'goods_number','goods_attr_id']);
    }
    /*图书栏目编辑验证场景*/
    public function sceneEdit(){
    	return $this -> only(['goods_number']);
    }
}