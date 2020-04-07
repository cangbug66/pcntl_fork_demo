<?php
/**
Generator::current		返回当前产生的值
Generator::key		返回当前产生的键
Generator::next		生成器继续执行
Generator::rewind		重置迭代器，如果迭代已经开始了会抛出一个异常
Generator::send	 向生成器中传入值，并当做yield 的结果，继续执行生成器
Generator::valid		检查迭代器是否被关闭
Generator::__wakeup	序列化回调
Generator::throw		向生成器中抛入一个异常

 */
function serven()
{
    yield 7;
}

/**
 * 基础用法
 */
function y()
{
    yield 1;

    yield 123 => 2;

    yield;

    yield from [4, 5, 6];

    yield from serven();

    yield from new ArrayIterator([8, 9]);
}

$gen = y();

foreach ($gen as $value) {
    echo $value . PHP_EOL;
}