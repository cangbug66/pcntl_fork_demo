<?php

$key="1954714891";//key 为 pcntl_fork_pipe_shmop_write.php 文件生成的key

$r = shmop_open($key, 'c', 0664, 200);
echo shmop_read($r, 0, 200) . PHP_EOL;