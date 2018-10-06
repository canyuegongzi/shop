<?php
namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;
use	think\Image; 
class Good extends Model
{
    //软删除
    use SoftDelete;
    //关联栏目表
    public function type()
    {
        return $this->belongsTo('Type', 'type_id', 'id')->field('type_name,level,id,path');
    }
    //品牌的关联
    public function brand(){
        return $this->belongsTo('Brand', 'brand_id', 'id')->field('brand_name,id');
    }
    //商品属性
    public function attr(){
        return $this->hasMany('Goodsattr', 'id','goods_id');
    }
    /*//关联固有的属性
    public function attrnum(){
        return $this->belongsTo('Attrnum', 'attr_id', 'id');
    }*/
    //关联库存量
    public function number(){
        return $this->hasMany('Number', 'goods_id','id');
    }

    /*商品添加*/
    public function add($data) {
    	$validate = new \app\common\validate\Good();

    	if(!$validate -> scene('add') -> check($data)){
    		return $validate -> getError();
    	}
    	
    	/*处理缩略图*/
    	$logoPath = uploadFile('logo','goods');
    	$data['logo'] = $logoPath['logo'];
    	$data['sm_logo'] = $logoPath['sm_logo'];
    	$data['mid_logo'] = $logoPath['mid_logo'];
    	$data['big_logo'] = $logoPath['big_logo'];
    	$data['mbig_logo'] = $logoPath['mbig_logo'];
    	$result = $this->allowField(true)->save($data);
    	if($result) {
    		return 1;
    	}else {
    		return '添加成功';
    	}
    }
    /*商品的删除*/
    public function del($data) {
    	$goodInfo = $this->with('attr')->find($data['id']);
        //$resultTwo = 0;
    	$resultOne = $goodInfo->together('attr')->delete();
        //$numberInfo = model('Number')->where('goods_id',$data['id'])->select();
        
        /*foreach ($numberInfo as $key => $value) {
            //dump($value);
            $value->delete(true);
        }  */ 
        //dump($resultTwo);
    	if($resultOne){
    		return 1;
    	}else {
    		return '删除失败';
    	}
    }
   
    /*商品的编辑*/
    public function edit($data){
    
    	//获得缩略图的所有地址
    	$logoPath = uploadFile('logo','goods');
    	$data['logo'] = $logoPath['logo'];
    	$data['sm_logo'] = $logoPath['sm_logo'];
    	$data['mid_logo'] = $logoPath['mid_logo'];
    	$data['big_logo'] = $logoPath['big_logo'];
    	$data['mbig_logo'] = $logoPath['mbig_logo'];
    	
    	$validate = new \app\common\validate\Good();
    	if(!$validate -> scene('edit')->check($data)){
    		return $validate->getError();
    	}
    	$result = $this->isUpdate(true)->save($data);
    	
    	if($result) {
    		return 1;
    	}else {
    		return '修改失败';
    	}
    }
    /*最新商品*/
    public function new($data){
        $validate = new \app\common\validate\Good();
        if(!$validate -> scene('new')->check($data)){
            return $validate->getError();
        }
        $goodInfo = model('Good')->find($data['id']);
        $goodInfo->is_new = $data['is_new'];
        $result = $goodInfo->save();
        if($result){
            return 1;
        }else {
            return '修改失败';
        }
    }
    /*最re商品*/
    public function hot($data){
        $validate = new \app\common\validate\Good();
        if(!$validate -> scene('hot')->check($data)){
            return $validate->getError();
        }
        $goodInfo = model('Good')->find($data['id']);
        $goodInfo->is_hot = $data['is_hot'];
        $result = $goodInfo->save();
        if($result){
            return 1;
        }else {
            return '修改失败';
        }
    }
    /*精品商品*/
    public function best($data){
        $validate = new \app\common\validate\Good();
        if(!$validate -> scene('best')->check($data)){
            return $validate->getError();
        }
        $goodInfo = model('Good')->find($data['id']);
        $goodInfo->is_best = $data['is_best'];
        $result = $goodInfo->save();
        if($result){
            return 1;
        }else {
            return '修改失败';
        }
    }
    /*推荐商品*/
    public function floor($data){
        $validate = new \app\common\validate\Good();
        if(!$validate -> scene('floor')->check($data)){
            return $validate->getError();
        }
        $goodInfo = model('Good')->find($data['id']);
        $goodInfo->is_floor = $data['is_floor'];
        $result = $goodInfo->save();
        if($result){
            return 1;
        }else {
            return '修改失败';
        }
    }
    /*是否上架*/
    public function sale($data){
        $validate = new \app\common\validate\Good();
        if(!$validate -> scene('sale')->check($data)){
            return $validate->getError();
        }
        $goodInfo = model('Good')->find($data['id']);
        $goodInfo->is_on_sale = $data['is_on_sale'];
        $result = $goodInfo->save();
        if($result){
            return 1;
        }else {
            return '修改失败';
        }
    }
}