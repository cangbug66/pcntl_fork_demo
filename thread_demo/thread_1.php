<?php

class simple extends Thread
{
    public $str;
    public function run()
    {
        $this->str = "hello world";
    }
}

$simple = new simple();
if(!$simple->start()){
    die("start error");
}

if(!$simple->join()){//等待线程执行完成
    die("join error");
}

echo $simple->str.PHP_EOL;