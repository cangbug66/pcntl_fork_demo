<?php
// 继承 Thread 的类具有创建线程的能力
class simple extends Thread
{
    private $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function run()
    {

        $this->synchronized(function ($thread){
            if(!$thread->done){
                $thread->wait();
            }
            $c = file_get_contents($this->file);
            echo "before c = {$c}\n";
            $c = $c + 1;
            echo "after c = {$c}\n";
            file_put_contents($this->file, $c);
        },$this);
    }
}

$arr = [];
$file = '/tmp/data.txt';
$thread_num = 8;
for ($i = 0; $i <= $thread_num; $i++) {
    $simple = new simple($file);
    $arr[$i] = $simple;
    // 创建新线程，随后线程会执行 run 方法
    if (! $simple->start()) {
        die("Start thread failed\n");
    }
    echo "Thread({$i}) started\n";
    $simple->synchronized(function ($thread){
        $thread->done = true;
        $thread->notify();
    },$simple);
}


for ($i = 0; $i <= $thread_num; $i++) {
    // join 是阻塞的，所以脚本运行时间取决于耗时最长的线程
    if (! $arr[$i]->join()) {
        die("Join failed\n");
    }
    echo $arr[$i]->str . PHP_EOL;
}