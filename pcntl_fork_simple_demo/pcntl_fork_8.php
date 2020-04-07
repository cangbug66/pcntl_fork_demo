<?php
/**
 * daemon化
 */
echo "create_pid:".getmygid().PHP_EOL;

umask( 0 );
$pid = pcntl_fork();
if( $pid < 0 ){
    exit('fork error.');
} else if( $pid > 0 ) {
    // 主进程退出
    echo "create exit".PHP_EOL;
    exit;
}

// 子进程继续执行
echo "worker start run...".PHP_EOL;
cli_set_process_title('php master_daemon process');
echo "create_pid:".getmygid().PHP_EOL;

if( !posix_setsid() ){
    exit('setsid error.');
}
echo "worker setsid success...".PHP_EOL;
//改变工作目录
if (!chdir("/")) exit('chdir error.');
echo "chdir success...".PHP_EOL;
//重设文件创建掩码
umask(0);

//fclose(STDIN);
//fclose(STDOUT);
//fclose(STDERR);




$master_stop = false;
$child_pid = [];

pcntl_signal(SIGCHLD,function() use ($pid,&$master_stop,&$child_pid){
    echo "收到子进程退出信号".PHP_EOL;
    $wait_result = pcntl_waitpid( $pid, $status, WNOHANG );

    $child_pid_num = count( $child_pid )-1;
    if ($child_pid_num ==0)   {
        echo "子进程全部退出".PHP_EOL;
        $master_stop=true;
        return;
    }else{
        echo "子进程剩余数目：".$child_pid_num.PHP_EOL;
    }
    array_pop($child_pid) ;
});

$worker_num=5;
for ($i=1;$i<=$worker_num;$i++){
    $pid = pcntl_fork();
    if ($pid > 0){
        $child_pid[] = $pid;
    }elseif($pid < 0 ){
        echo "worker fork error num:".$i.PHP_EOL;
        exit;
    }elseif($pid == 0){
        cli_set_process_title('php worker process num:'.$i);
        echo "work fork num:".$i.PHP_EOL;
        sleep(8);
        exit();
    }


}

while (true){
    if ($master_stop) break;
    pcntl_signal_dispatch();
    sleep( 1 );
}


