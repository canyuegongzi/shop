<?php
namespace app\common\validate;

use think\Validate;

class Type extends Validate
{
	protected $rule = [
		'type_name|分类名称' => 'require|unique:type',
        'pid|父级分类' => 'require|number',
        'path|分类路' => 'require',
        'level|分类等级' => 'require|number' ,
        'id|分类id' => 'require'
	];

	//添加分类的场景验证
	public function sceneAdd(){
		return $this->only(['type_name', 'pid','level']);
	}
	//更新路径
	public function sceneSecond() {
		return $this->only(['path']);
	}
	//分类编辑场景验证
	public function sceneEdit(){
		return $this->only(['type_name', 'pid','level'])->append('id', 'unique:admin');
	}
	//分类的删除场景验证
	public function sceneDel(){
		return $this->only(['id']);
	}
}	