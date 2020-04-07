<?php
//父进程执行完退出后，儿子们进程变成孤儿进程，被init进程（进程号：1）收留
$pid = pcntl_fork();
if( $pid > 0 ){
    // 显示父进程ID
    echo "父亲 process_id:".getmypid().PHP_EOL;
    cli_set_process_title("father_php");
    sleep( 3 );
} else if( $pid == 0 ) {
    cli_set_process_title("son_php");
    for( $i = 1; $i <= 10; $i++ ){
        sleep( 1 );
        echo "儿子的父进程process_id:".posix_getppid().PHP_EOL;
    }
} else {
    echo "fork error.".PHP_EOL;
}

