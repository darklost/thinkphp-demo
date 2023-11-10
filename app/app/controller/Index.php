<?php
namespace app\controller;

use app\BaseController;
use think\facade\Queue;

class Index extends BaseController
{
    public function index()
    {
        Queue::push('Test', 'test'.rand(1,1000));
        return '11111';
    }

    public function hello($name = 'ThinkPHP6')
    {
        return 'hello,' . $name;
    }
}
