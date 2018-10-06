<?php
namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class Type extends Model
{
	//软删除
    use SoftDelete;
    //商品分类的添加
    protected  $deleteTime = 'delete_time';
    public function add($data) {

    	if($data['pid'] == 0) {
    		$data['path'] = '0';
    		$data['level'] = 1;
    	}
    	$validate = new \app\common\validate\Type();
        if (!$validate->scene('add')->check($data)) {
            return $validate->getError();
        }
        //获取新插入的分类数据的额id的数据
        $insertId = $this->allowField(true)->insertGetId($data);
        if(!$insertId) {
        	return '插入失败';
        }
        //获取父级的path
        $parentPathInfo = $this->where('id',$data['pid'])->value('path');
        $path = $parentPathInfo.','.$insertId;
        //进行数据的二次的数据的验证，如果数据合法进行数据的再次更新
        //$validateSecond = new \app\common\validate\Type();
        
        //数据的再次的查询和更新。主要是更新分类的path数据
        $pathInfo=$this->find($insertId);
        $pathInfo->path = $path;
		$result = $pathInfo->save();
        if($result) {
        	return 1;
        }else{
        	return '添加失败';
        }
    }
    //商品分类的列表
    public function all() {
    	$arr = [];
    	$detail = $this->column('type_name','id');
    	$newarr = [];
    	if(input('get.level')){
                //获取原生数据库中的数据
    			$types = $this->where('level', input('get.level'))->select();

    			//将原数据中的path转换为数组
                $arr = explodeArray($types);
                //替换完成
                $newarr = replaceArray($arr,$detail);
    			foreach ($types as $key => $value) {
                    $types[$key]['path'] = $newarr[$key];
    			}
    			return ['detail' => $detail, 'types' => $types,'arr' => $arr,'path' => $newarr];
    		}else {
    			//获取原生数据库中的数据
                $types = $this->select();

                //将原数据中的path转换为数组
                $arr = explodeArray($types);
                //替换完成
                $newarr = replaceArray($arr,$detail);
                foreach ($types as $key => $value) {
                    $types[$key]['path'] = $newarr[$key];
                }
                return ['detail' => $detail, 'types' => $types,'arr' => $arr,'path' => $newarr];
    		}
    }
    //商品分类的额编辑
    public function edit($data) {
        $validate = new \app\common\validate\Type();
        if (!$validate->scene('edit')->check($data)) {
            return $validate->getError();
        }

        //父级路径
        $parentPathInfo = $this->where('id',$data['pid'])->value('path');
        $path = $parentPathInfo.','.$data['id'];
        $typeInfo = $this->find($data['id']);
        $typeInfo ->type_name = $data['type_name'];
        $typeInfo ->pid = $data['pid'];
        $typeInfo ->level = $data['level'];
        $typeInfo ->path = $path;
        $result = $typeInfo->save();
        if($result){
            return 1;
        }else {
            return '修改失败';
        }
    }
    //商品分类的删除
    public function del($data){
        $result = false;
        $validate = new \app\common\validate\Type();
        if (!$validate->scene('del')->check($data)) {
            return $validate->getError();
        }
        $typeInfo = $this->where('path','like','%'.$data['id'].'%')->select();        
        foreach ($typeInfo as $key => $value) {
            $result = $typeInfo[$key]->delete();
        }        
        if($result) {
            return 1;
        }else {
            return '修改失败';
        }
    }
}