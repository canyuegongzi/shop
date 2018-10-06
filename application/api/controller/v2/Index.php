<?php

namespace app\api\controller\v2;

use think\Controller;

class Index extends Controller
{
    public function index() {
    	
        $s = input('version');
        $data = [
                'username' => 'Marvin',
                'age' => 50,
                'version' => $s,
	            'data' => [
                	'desc' => 'sssss',
                	'class' => '初中',
                    'version' => '2'
                ]
            ];
        return json($data,200);
    }
}
