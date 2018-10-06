<?php
namespace app\common\validate;

use think\Validate;

class Brand extends Validate
{
	protected $rule = [
        'brand_name|品牌名称' => 'require|unique:brand',
        'id|商品id' => 'require|number',
        'desc|品牌描述' => 'require'
    ];
    /*添加图书栏目验证场景*/
    public function sceneAdd(){
    	return $this -> only(['brand_name', 'desc']);
    }
    /*图书栏目编辑验证场景*/
    public function sceneEdit(){
    	return $this -> only(['brand_name', 'desc']);
    }
}