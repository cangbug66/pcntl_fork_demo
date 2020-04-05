<?php
//儿子显示了7次
for( $i = 1; $i <= 3 ; $i++ ){
    $pid = pcntl_fork();
    if( $pid > 0 ){
        echo "父亲".PHP_EOL;
    } else if( $pid == 0 ){
        echo "儿子".PHP_EOL;
    }else{
        echo "fork error".PHP_EOL;
    }
}

