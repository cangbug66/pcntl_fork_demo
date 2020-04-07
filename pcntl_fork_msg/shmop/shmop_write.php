<?php
/**
shmop_open		创建或打开共享内存块
shmop_size		取得共享内存块大小
shmop_write		写入数据到共享内存块
shmop_read		从共享内存块读取数据
shmop_close		关闭共享内存块
shmop_delete		删除共享内存块

 */
$key=ftok(__FILE__,"t");
echo $key . PHP_EOL;

$r = shmop_open($key, 'c', 0664, 200);
echo "Size shmop:" . shmop_size($r) . PHP_EOL;

$bytes = shmop_write($r, 'Hello world', 0);
echo "write content Bytes = " . $bytes . PHP_EOL;
echo shmop_read($r, 0, 200) . PHP_EOL;