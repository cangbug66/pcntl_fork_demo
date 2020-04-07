<?php
//fork
$pid = pcntl_fork();
if ($pid > 0){
    echo "我是父亲".PHP_EOL;
}elseif($pid == 0){
    echo "我是儿子".PHP_EOL;
}else{
    echo "fork error".PHP_EOL;
}