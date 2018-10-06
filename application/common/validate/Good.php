<?php
namespace app\common\validate;

use think\Validate;

class Good extends Validate
{
	protected $rule = [
        'goods_name|商品名称' => 'require',       
		'market_price|市场价格' => 'require',
		'shop_price|本店价格' => 'require', 
		'goods_desc|商品描述' => 'require', 
		'is_on_sale|是否上架' => 'require', 
		'brand_id|商品品牌' => 'require', 
		'cat_id|商品主分类' => 'require', 
		'type_id|分类id' => 'require', 
		'sort_num|排序的数字' => 'require', 
		'is_new|是否是新品' => 'require', 
		'is_floor|是否推荐' => 'require', 
		'is_best|是否精品' => 'require', 
		'is_hot|是否最热' => 'require', 
		'promote_pric|促销的价格' => 'require', 
		'promote_start_date|促销开始的时间' => 'require', 
		'promote_end_date|促销结束的时间' => 'require', 
		'logo|商品的logo' => 'require', 
		'sm_logo|小logo' => 'require', 
		'mid_logo|中等的logo' => 'require', 
		'big_logo|大logo' => 'require', 
		'mbig_logo|超大图的logo' => 'require', 
		'id|商品id' => 'require'
    ];

    /*商品添加的场景的验证*/
    public function sceneAdd() {
    	return $this->only(['goods_name','market_price','shop_price','is_on_sale','brand_id','cat_id','type_id','is_new','is_floor','is_best','is_hot']);
    }
    /*商品的编辑的验证场景*/
    public function sceneEdit(){
    	return $this->only(['goods_name','market_price','shop_price','is_on_sale','brand_id','cat_id','type_id','is_new','is_floor','is_best','is_hot']);
    }
    /*new*/
    public function sceneNew(){
    	return $this->only(['id','is_new']);
    }
    /*hot*/
    public function sceneHot(){
    	return $this->only(['id','is_hot']);
    }
    /*best*/
    public function sceneBest(){
    	return $this->only(['id','is_best']);
    }
    /*floor*/
    public function sceneFloor(){
    	return $this->only(['id','is_floor']);
    }
     /*上架*/
    public function sceneSale(){
    	return $this->only(['id','is_on_sale']);
    }
}	