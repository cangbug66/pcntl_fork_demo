<?php
/**
 * 进程通讯----有名管道
 */

function posix_mkfifo_pipe()
{
    $file = '/tmp/mkfifo_pipe';
    if (! file_exists($file)) {
        if (! posix_mkfifo($file, 0664)) {//创建管道文件
            die("Create fifo file failed.\n");
        }
    }
    $i = 0;
    while (true) {
        $i++;
        $handle = fopen($file, 'w');
        fwrite($handle, "({$i})");
        sleep(1);
        if ($i == 10) break;
    }

}
posix_mkfifo_pipe();


/***
 * 1、执行php pcntl_fork_pipe_fifo
 *2、新开终端窗口，执行cat /tmp/mkfifo_pipe  即可收到消息
 */
