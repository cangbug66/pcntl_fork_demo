<?php
/**
 * child进程退出被父进程回收后，父进程依然不断while，没法停止
 */

$pid = pcntl_fork();
if( $pid > 0 ){
    cli_set_process_title("father_php");
    // 显示父进程ID
    echo "父亲 process_id:".getmypid().PHP_EOL;

//    $wait_res = pcntl_wait($status);//主进程阻塞，直至子进程退出
    while (true){
        $wait_res = pcntl_waitpid( $pid, $status ,WNOHANG);//主进程不阻塞
        echo "wait_res:";var_dump($wait_res);
        echo "wexitstatus:";var_dump(pcntl_wexitstatus($status));
        sleep( 1 );
    }
    echo "father 执行完成".PHP_EOL;
} else if( $pid == 0 ) {
    cli_set_process_title("son_php");
    echo "儿子的父进程process_id:".posix_getppid().PHP_EOL;
    sleep( 5 );
    echo "儿子的父进程process_id:".posix_getppid().PHP_EOL;//父进程process_id 不变
    echo "son 执行完成".PHP_EOL;
} else {
    echo "fork error.".PHP_EOL;
}

