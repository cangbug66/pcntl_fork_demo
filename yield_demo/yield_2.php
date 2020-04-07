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
class Scheduler
{
    protected $list = [];

    public function addTask(Generator $gen)
    {
        array_push($this->list, $gen);
    }

    public function run()
    {
        // 队列出队和进队来交替执行任务
        while (!empty($this->list)) {
            //执行一次
            $gen = array_shift($this->list);

            // 让生成器再继续执行一次
//            $gen->send(null);

            /**
             * 第一个task执行2次后，接着第二个task执行2次
             */

            if ($gen->valid()) {
                array_push($this->list, $gen);
            }
        }
    }
}


function task1()
{
    for ($i = 1; $i <= 5; $i++) {
        echo "Task(1) {$i}\n";
        yield;
    }
}

function task2()
{
    for ($i = 1; $i <= 10; $i++) {
        echo "Task(2) {$i}\n";
        yield;
    }
}

$sc = new Scheduler();

$sc->addTask(task1());
$sc->addTask(task2());

$sc->run();