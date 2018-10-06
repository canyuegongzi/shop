<?php
namespace app\common\validate;

use think\Validate;

class Comment extends Validate
{
	protected $rule = [
        'goods_id|商品id' => 'require',
        'member_id|会员id' => 'require',
        'content|评价内容' => 'require',
        'star|评价分值' => 'require'

    ];
    /*添加固有属性验证场景*/
    public function sceneAdd() {
    	return $this->only(['goods_id', 'member_id', 'content','star']);
    }
    /*编辑固有属性验证场景*/
    public function sceneEdit() {
    	return $this->only(['member_id', 'content','star']);
    }
}