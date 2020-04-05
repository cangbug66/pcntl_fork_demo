<?php
//说明子进程拥有父进程的数据副本，而并不是共享
$number = 1;
$pid = pcntl_fork();
if( $pid > 0 ){
    $number += 1;
    echo "我是父亲，number+1: { $number }".PHP_EOL;
} else if( 0 == $pid ) {
    $number += 2;
    echo "我是儿子，number+2 : { $number }".PHP_EOL;
} else {
    echo "fork失败".PHP_EOL;
}