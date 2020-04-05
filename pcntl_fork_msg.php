<?php
//fork

$queue_key = ftok(__DIR__,"q");
$queue = msg_get_queue($queue_key,0666);


$pid = pcntl_fork();
if ($pid > 0){
    echo "我是父亲".PHP_EOL;

    //阻塞，直到收到消息
    msg_receive($queue,0,$msgType,1024,$msg);
    echo "收到消息：".$msg.PHP_EOL;
    msg_remove_queue( $queue );
    pcntl_wait( $status );
}elseif($pid == 0){
    echo "我是儿子".PHP_EOL;
    msg_send( $queue, 1, "i am son" );
}else{
    echo "fork error".PHP_EOL;
}