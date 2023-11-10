<?php

namespace app\job;

use think\facade\Log;
use think\queue\Job;

class Test
{
     public function fire(Job $job, $data){
    
            //....这里执行具体的任务 
            Log::info("任务 data:".json_encode($data)."job:".json_encode($job));
             if ($job->attempts() > 3) {
                  //通过这个方法可以检查这个任务已经重试了几次了
                   Log::info("任务已经重试了3次了 data:".json_encode($data));
                   $job->delete();
                   return ;
             }
            
            if ($this->exec($data)) {
               //如果任务执行成功后 记得删除任务，不然这个任务会重复执行，直到达到最大重试次数后失败后，执行failed方法
               Log::info("任务执行成功后 记得删除任务 data:".json_encode($data));
                $job->delete();
                return ;
            }
            
            
            // 也可以重新发布这个任务
            $delay = 10; //延迟10秒执行
            $job->release($delay); //$delay为延迟时间
          
    }
    
    public function failed($data){
    
        // ...任务达到最大重试次数后，失败了
          Log::info("任务达到最大重试次数后，失败了 data:".json_encode($data));
    }

    // 处理业务逻辑
    public function exec($data)
    {
        Log::info("处理业务逻辑 data:".json_encode($data));
        //随机一个次数
        $num = rand(1,10);
        return $num >5;
    }
}