<?php
namespace app\api\controller\v1;

use think\Controller;
use think\Request;
use think\File;
use think\Image;
class Good extends Controller
{
    /*添加商品*/
    public function add() {
        if(request()->isPost()){
            //$image = input('file.logo');
            //$logoPath = uploadFile('logo','goods');
            $data = [
                'goods_name' => input('post.name'),
                'market_price' => input('post.marketPrice'),
                'shop_price' => input('post.shopPrice'),
                'goods_desc' => input('post.desc'),
                'is_on_sale' => input('post.isSale'),
                'brand_id' => input('post.brand'),
                'cat_id' => input('post.cat'),
                'type_id' => input('post.type'),
                'sort_num' => input('post.sortNum'),
                'is_new' => input('post.isNew'),
                'is_floor' => input('post.isFloor'),
                'is_best' => input('post.isBest'),
                'is_hot' => input('post.isHot'),
                'promote_price' => input('post.promotePrice'),
                'promote_start_date' => input('post.promotePrice'),
                'promote_end_date' => input('post.promoteEndDate'),
            ];
           
            $result = model('Good') -> add($data);
            if($result == 1) {
                return json(['msg' => 'success', 'code' => 200]);
            }else {
                return json(['msg' => $result, 'code' => 404]);
            }
        }
        return json(['msg' => 'fail', 'code' => 304]);
    }
    /*商品的删除*/
    public function del() {
        if(request()->isPost()) {
            $data = [
                'id' => input('post.id')
            ];
            
            $result = model('Good')->del($data);
            if($result == 1 ){
                return json(['msg' => 'success', 'code' => 200]);
            }else{
                return json(['msg' => 'fail', 'code' => 304]);
            }
        }else {
            return json(['msg' => 'fail', 'code' => 404]);
        }
    }
    //获取商品的具体的详情
    public function info(){
        
        $goodInfo = model('Good')->with('type,brand')->find(input('id'));
        $attrInfo = model('Goodsattr')->with('attr')->where('goods_id' , input('id'))->field('id, attr_value, attr_id')->select();
        $numberInfo = model('Number')->where(['goods_id' => input('id')])->field('goods_number, goods_attr_id')->select();
        $data = [
            'info' => $goodInfo,
            'attr' => $attrInfo,
            'number' => $numberInfo
        ];
        if($goodInfo && $attrInfo){
            return json(['msg'=>'success', 'code'=>200,'data'=>$data/*$goodInfo,'attr'=>$attrInfo*/]);
        }else {
            return json(['msg'=>'fail', 'code'=>404,'data'=>$goodInfo]);
        }    
    }
    /*商品的编辑*/
    public function edit(){
        if(request()->isPost()){
            $data = [
                'id' => input('post.id'),
                'goods_name' => input('post.name'),
                'market_price' => input('post.marketPrice'),
                'shop_price' => input('post.shopPrice'),
                'goods_desc' => input('post.desc'),
                'is_on_sale' => input('post.isSale'),
                'brand_id' => input('post.brand'),
                'cat_id' => input('post.cat'),
                'type_id' => input('post.type'),
                'sort_num' => input('post.sortNum'),
                'is_new' => input('post.isNew'),
                'is_floor' => input('post.isFloor'),
                'is_best' => input('post.isBest'),
                'is_hot' => input('post.isHot'),
                'promote_price' => input('post.promotePrice'),
                'promote_start_date' => input('post.promoteStartData'),
                'promote_end_date' => input('post.promoteEndDate'),
            ];

            $result = model('Good')->edit($data);
            if($result == 1) {
                return json(['msg' => 'success', 'code' => 200]);
            }else {
                return json(['msg' => $result, 'code' => 404]);
            }
        }else {
            return json(['msg' => 'fail', 'code' => 304]);     
        }       
        
    }
    /*获取商品的列表*/
    public function all(){
        $page = 1;
        input('page')? $page = input('page') : $page = 1;       
        $goodList = model('Good')->with('type,brand')->order(['create_time' => 'desc'])->paginate(10,false,['query' => $page]);
        if($goodList){
            return json(['msg' => 'success', 'code' => 200,'data' => $goodList]);
        }else{
            return json(['msg' => 'fail', 'code' => 404,'data' => $goodList]);
        }
    }
    /*搜索商品*/
    public function poll() {       
        $data = [
            'id' => input('id'),
            'goods_name' => input('name'),
            'type_name' => input('type'),
            'cat_name' => input('cat'),
            'brand_name' => input('brand'),
            'is_new' => input('new'),
            'is_hot' => input('hot'),
            'is_best' => input('best'),
            'is_floor' => input('floor'),
            'is_on_sale' => input('sale'),
            'page' => input('page')
        ];
        input('page')? $page = input('page') : $page = 1;
        if($data['goods_name']){
            $result = model('Good')->where('goods_name|goods_desc', 'like', '%' . $data['goods_name'] . '%')->with('type,brand')->paginate(10,false,['query' => $page]);
            return json(['msg' => 'success', 'code' => 200,'data' => $result]);
        }else if($data['type_name']/* || $data['cat_name']*/){

            $typeName = model('Type')->where('type_name',$data['type_name'])->field('id,level')->select();
            $result = model('Good')->where('type_id', $typeName[0]['id'])->with('type,brand')->paginate(10,false,['query' => $page]);
            return json(['msg' => 'success', 'code' => 200,'data' => $result]);
        }else if ($data['brand_name']) {
            $brandName = model('Brand')->where('brand_name',$data['brand_name'])->field('id,level')->select();
            $result = model('Good')->where('brand_id',$brandName[0][id])->with('type,brand')->paginate(10,false,['query' => $page]);
            return json(['msg' => 'success', 'code' => 200,'data' => $result]);
        }else if($data['is_new']){
            $result = model('Good')->where('is_new',$data['is_new'])->with('type,brand')->paginate(10,false,['query' => $page]);
            return json(['msg' => 'success', 'code' => 200,'data' => $result]);
        }else if($data['is_hot']){
            $result = model('Good')->where('is_hot',$data['is_hot'])->with('type,brand')->paginate(10,false,['query' => $page]);
            return json(['msg' => 'success', 'code' => 200,'data' => $result]);
        }else if($data['is_best']){
            $result = model('Good')->where('is_best',$data['is_best'])->with('type,brand')->paginate(10,false,['query' => $page]);
            return json(['msg' => 'success', 'code' => 200,'data' => $result]);
        }else if($data['is_floor']){
            $result = model('Good')->where('is_floor',$data['is_floor'])->with('type,brand')->paginate(10,false,['query' => $page]);
            return json(['msg' => 'success', 'code' => 200,'data' => $result]);
        }else if($data['is_on_sale']){
            $result = model('Good')->where('is_on_sale',$data['is_floor'])->with('type,brand')->paginate(10,false,['query' => $page]);
            return json(['msg' => 'success', 'code' => 200,'data' => $result]);
        }else {
            $result = model('Good')->with('type,brand')->order(['create_time' => 'desc'])->paginate(10,false,['query' => $page]);
            return json(['msg' => 'success', 'code' => 200,'data' => $result]);
        }      
       
    }
    /*是否最新品的设置*/
    public function new(){
        $data = [
            'id' => input('post.id'),
            'is_new' => input('post.new')
        ];
        $result = model('Good')->new($data);
        if($result){
            return json(['msg' => 'success', 'code' => 200, 'data' => $result]);
        }
        return json(['msg' => 'fail', 'code' => 404, 'data' => $result]);
    }
    /*是否最热销的设置*/
    public function hot(){
        $data = [
            'id' => input('post.id'),
            'is_hot' => input('post.hot')
        ];
        
        $result = model('Good')->hot($data);
        if($result){
            return json(['msg' => 'success', 'code' => 200, 'data' => $result]);
        }
        return json(['msg' => 'fail', 'code' => 404, 'data' => $result]);
    }
    /*是否精品的设置*/
    public function best(){
        $data = [
            'id' => input('post.id'),
            'is_best' => input('post.best')
        ];
        $result = model('Good')->best($data);
        if($result){
            return json(['msg' => 'success', 'code' => 200, 'data' => $result]);
        }
        return json(['msg' => 'fail', 'code' => 404, 'data' => $result]);
    }
    /*是否推荐的设置*/
    public function floor(){
        $data = [
            'id' => input('post.id'),
            'is_floor' => input('post.floor')
        ];
        $result = model('Good')->floor($data);
        if($result){
            return json(['msg' => 'success', 'code' => 200, 'data' => $result]);
        }
        return json(['msg' => 'fail', 'code' => 404, 'data' => $result]);
    }
    /*是否上架*/
    public function sale(){
        $data = [
            'id' => input('post.id'),
            'is_on_sale' => input('post.sale')
        ];
        $result = model('Good')->sale($data);
        if($result){
            return json(['msg' => 'success', 'code' => 200, 'data' => $result]);
        }
        return json(['msg' => 'fail', 'code' => 404, 'data' => $result]);
    }
}