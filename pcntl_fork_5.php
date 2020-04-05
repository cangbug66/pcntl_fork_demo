<?php
/**
 * pcntl_waitpid让主进程不阻塞，但child 进程依然成功孤儿进程被init进程收留,
 * 原因是child进程在结束前，主进程就提前调用了pcntl_waitpid方法，导致进程回收没起左右
 */

$pid = pcntl_fork();
if( $pid > 0 ){
    cli_set_process_title("father_php");
    // 显示父进程ID
    echo "父亲 process_id:".getmypid().PHP_EOL;

//    $wait_res = pcntl_wait($status);//主进程阻塞，直至子进程退出
    $wait_res = pcntl_waitpid( $pid, $status ,WNOHANG);//主进程不阻塞
    sleep( 10 );
    echo "father 执行完成".PHP_EOL;
} else if( $pid == 0 ) {
    cli_set_process_title("son_php");
    echo "儿子的父进程process_id:".posix_getppid().PHP_EOL;
    sleep( 15 );
    echo "儿子的父进程process_id:".posix_getppid().PHP_EOL;//父进程process_id 变成了 1
    echo "son 执行完成".PHP_EOL;
} else {
    echo "fork error.".PHP_EOL;
}

