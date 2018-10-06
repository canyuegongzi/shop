<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------


Route::rule('/', 'index/index/index', 'get');

Route::group('admin', function (){
    Route::rule('/', 'admin/index/login', 'get|post');
});

Route::group('api', function (){
	/*管理员*/
    Route::rule('/:version/index', 'api/v:version.Index/index', 'get|post');
    Route::rule('/:version/admin/login', 'api/v:version.Admin/login', 'post');
    Route::rule('/:version/admin/register', 'api/v:version.Admin/register', 'post');
    Route::rule('/:version/admin/del', 'api/v:version.Admin/del', 'post');
    Route::rule('/:version/admin/edit', 'api/v:version.Admin/edit', 'post');
    Route::rule('/:version/admin/reset', 'api/v:version.Admin/reset', 'post');
    Route::rule('/:version/admin/all', 'api/v:version.Admin/all', 'get');
    Route::rule('/:version/admin/query', 'api/v:version.Admin/query', 'post');
    Route::rule('/:version/admin/bar', 'api/v:version.Admin/bar', 'post');
    Route::rule('/:version/admin/root', 'api/v:version.Admin/root', 'post');

    /*首页栏目设置*/
    Route::rule('/:version/cate/add', 'api/v:version.Cate/add', 'post');
    Route::rule('/:version/cate/edit', 'api/v:version.Cate/edit', 'post');
    Route::rule('/:version/cate/all', 'api/v:version.Cate/all', 'get');
    Route::rule('/:version/cate/del', 'api/v:version.Cate/del', 'post');
    
    /*商品*/
    Route::rule('/:version/good/add', 'api/v:version.Good/add', 'post');
    Route::rule('/:version/good/del', 'api/v:version.Good/del', 'post');
    Route::rule('/:version/good/info', 'api/v:version.Good/info', 'get|post');
    Route::rule('/:version/good/edit', 'api/v:version.Good/edit', 'post');
    Route::rule('/:version/good/all', 'api/v:version.Good/all', 'get|post');
    Route::rule('/:version/good/query', 'api/v:version.Good/poll', 'get');
    Route::rule('/:version/good/best', 'api/v:version.Good/best', 'get|post');
    Route::rule('/:version/good/floor', 'api/v:version.Good/floor', 'get|post');
    Route::rule('/:version/good/new', 'api/v:version.Good/new', 'get|post');
    Route::rule('/:version/good/sale', 'api/v:version.Good/sale', 'get|post');
    Route::rule('/:version/good/hot', 'api/v:version.Good/hot', 'get|post');

    /*品牌设置*/
    Route::rule('/:version/brand/add', 'api/v:version.Brand/add', 'post');
    Route::rule('/:version/brand/edit','api/v:version.Brand/edit', 'post');
    Route::rule('/:version/brand/del', 'api/v:version.Brand/del', 'post');
    Route::rule('/:version/brand/all', 'api/v:version.Brand/all', 'get|post');
    
    /*商品分类*/
    Route::rule('/:version/type/add', 'api/v:version.Type/add', 'post');
    Route::rule('/:version/type/edit', 'api/v:version.Type/edit', 'post');
    Route::rule('/:version/type/del', 'api/v:version.Type/del', 'post');
    Route::rule('/:version/type/all', 'api/v:version.Type/all', 'get');

    /*固有属性*/
    Route::rule('/:version/attr/add', 'api/v:version.Attrnum/add', 'post');
    Route::rule('/:version/attr/edit', 'api/v:version.Attrnum/edit', 'post');
    Route::rule('/:version/attr/del', 'api/v:version.Attrnum/del', 'post');
    Route::rule('/:version/attr/all', 'api/v:version.Attrnum/all', 'get');
    Route::rule('/:version/attr/query', 'api/v:version.Attrnum/query', 'get');


    /*商品属性*/
    Route::rule('/:version/godatr/add', 'api/v:version.Goodsattr/add', 'post');
    Route::rule('/:version/godatr/edit', 'api/v:version.Goodsattr/edit', 'post');
    Route::rule('/:version/godatr/del', 'api/v:version.Goodsattr/del', 'post');
    Route::rule('/:version/godatr/info', 'api/v:version.Goodsattr/info', 'get');
    
    /*商品的库存*/
    Route::rule('/:version/number/add', 'api/v:version.Number/add', 'post');
    Route::rule('/:version/number/edit', 'api/v:version.Number/edit', 'post');
    Route::rule('/:version/number/del', 'api/v:version.Number/del', 'post');
    Route::rule('/:version/number/info', 'api/v:version.Number/info', 'get');

    /*会员管理*/
    Route::rule('/:version/member/login', 'api/v:version.Member/login', 'post');
    Route::rule('/:version/member/register', 'api/v:version.Member/register', 'post');
    Route::rule('/:version/member/del', 'api/v:version.Member/del', 'get|post');
    Route::rule('/:version/member/edit', 'api/v:version.Member/edit', 'post');
    Route::rule('/:version/member/reset', 'api/v:version.Member/reset', 'get|post');
    Route::rule('/:version/member/all', 'api/v:version.Member/all', 'get|post');
    Route::rule('/:version/member/query', 'api/v:version.Member/query', 'get|post');
    Route::rule('/:version/member/bar', 'api/v:version.Member/bar', 'get|post');
    Route::rule('/:version/member/info', 'api/v:version.Member/info', 'post|get');

    /*评论管理*/
    Route::rule('/:version/comment/add', 'api/v:version.Comment/add', 'post');
    Route::rule('/:version/comment/edit', 'api/v:version.Comment/edit', 'post');
    Route::rule('/:version/comment/del', 'api/v:version.Comment/del', 'post');
    Route::rule('/:version/comment/query', 'api/v:version.Comment/query', 'post|get');
    Route::rule('/:version/comment/all', 'api/v:version.Comment/all', 'post|get');

    /*购物车管理*/
    Route::rule('/:version/cart/add', 'api/v:version.Cart/add', 'post');
    Route::rule('/:version/cart/edit', 'api/v:version.Cart/edit', 'post');
    Route::rule('/:version/cart/del', 'api/v:version.Cart/del', 'post');
    Route::rule('/:version/cart/all', 'api/v:version.Cart/all', 'get');
    Route::rule('/:version/cart/query', 'api/v:version.Cart/query', 'get');

    /*订单管理*/
    Route::rule('/:version/order/add', 'api/v:version.Order/add', 'post');
    Route::rule('/:version/order/del', 'api/v:version.Order/del', 'get|post');
    Route::rule('/:version/order/post', 'api/v:version.Order/post', 'get|post');
    Route::rule('/:version/order/pay', 'api/v:version.Order/pay', 'get|post');
    Route::rule('/:version/order/deal', 'api/v:version.Order/deal', 'get|post');


    /*Route::rule('/:version/order/edit', 'api/v:version.Order/edit', 'post');   
    
    Route::rule('/:version/order/query', 'api/v:version.Order/query', 'get');*/

    /*商品订单管理*/
    /*Route::rule('/:version/ordergoods/add', 'api/v:version.Ordergoods/add', 'post');
    Route::rule('/:version/ordergoods/edit', 'api/v:version.Ordergoods/edit', 'post');
    Route::rule('/:version/ordergoods/del', 'api/v:version.Ordergoods/del', 'post');
    Route::rule('/:version/ordergoods/info', 'api/v:version.Ordergoods/all', 'get');*/
    Route::rule('/:version/ordergoods/query', 'api/v:version.Ordergoods/query', 'get|post');

});
