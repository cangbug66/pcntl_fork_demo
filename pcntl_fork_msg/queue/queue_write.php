<?php
/**
 * 进程通讯----消息队列
 *
ftok					把路径和项目名转为一个给进程通信使用的 key
msg_queue_exists		检查一个消息队列是否存在
msg_get_queue		创建或获取一个消息队列
msg_stat_queue		返回消息队列数据结构的信息
msg_set_queue		设置消息队列数据结构的信息
msg_send			发送一条消息到消息队列
msg_receive			从消息队列中接收一条消息
msg_remove_queue	销毁一个消息队列

 */
$queue_key = ftok(__DIR__,"q");
if (msg_queue_exists($key)) {
    echo "Queue exists\n";
}
$queue = msg_get_queue($queue_key,0666);
$queueInfo = msg_stat_queue($queue);
var_dump($queueInfo);

if (! msg_send($queue,1,"hello wrold queue msg")) {
    echo "Send failed\n";
}
echo "end\n";
