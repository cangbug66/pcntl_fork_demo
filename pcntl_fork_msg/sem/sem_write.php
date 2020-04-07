<?php
/**
 *信号量又称为信号灯、旗语
 * 用来解决进程（线程同步的问题），
 * 类似于一把锁，访问前获取锁（获取不到则等待），
 * 访问后释放锁。
sem_get			得到一个信号量 id
sem_acquire		获取一个信号量
sem_release		释放一个信号量
sem_remove		移除一个信号量

 *
 */
$key = 666666;

$resource = sem_get($key);

if ( false === $resource ) {
    die("Get sem failed\n");
}

// 获取信号量
if (sem_acquire($resource)) {
    echo "Sem acquire success\n";
    echo "Doing something ...\n";
    // 释放信号量, 使其它程序可以获取该信号量
//    sem_release($resource);
    sleep(20);
}

echo "Done\n";