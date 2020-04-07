<?php
/**
 * 进程通讯----无名管道
 */
function proc_pipe()
{
    $cmd = 'cat';

    $desc = [
        0 => ['pipe', 'r'],
        1 => ['pipe', 'w'],
        2 => ['file', '/tmp/proc_open.err', 'a'],
    ];

    $handles = [];

    for ($i = 0; $i < 3; $i++) {
        $handle = proc_open($cmd, $desc, $pipes);
        sleep(1);
        fwrite($pipes[0], date('Y-m-d H:i:s'));
//    $pipes[0] 读句柄
//    $pipes[1] 写句柄
        $handles[] = [
            'handle' => $handle,
            'output' => $pipes[1],
        ];

        fclose($pipes[0]);
    }

    foreach ($handles as $array) {
        echo fread($array['output'], 1024) . PHP_EOL;
        fclose($array['output']);
        proc_close($array['handle']);
    }
}


