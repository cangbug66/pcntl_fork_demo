<?php
/**
 * daemon化
 */

function daemon()
{
    $pid = pcntl_fork();
    switch ($pid) {
        case -1:
            die('create fork failed');
            break;
        case 0:
            if ( ($sid = posix_setsid()) <= 0 ) {
                die("setsid failed.\n");
            }
            if (chdir('/') === false) {
                die("Change dir failed.\n");
            }

            umask(0);
            cli_set_process_title("php pcntl_master");
            break;
        default:
            exit;
            break;
    }
}


function fork($i)
{
    global $childs_pid;
    $pid = pcntl_fork();
    if ($pid > 0){
        $childs_pid[] = $pid;
    }elseif($pid < 0 ){
        die();
    }elseif($pid == 0){
        cli_set_process_title('php pcntl_worker_num:'.$i);
        pcntl_signal(SIGTERM, SIG_IGN, false);
        while (true) {
            sleep(5);
        }
    }
}

function exist_master_pid_file()
{
    global $master_pid_file;
    if(file_exists($master_pid_file)) return $master_pid_file;
    return '';
}

function kill_childs()
{
    global $master_pid_file;
    if(!exist_master_pid_file()) die("pid file not exist \n");
    $master_pid = file_get_contents($master_pid_file);
//    echo "master_pid:".$master_pid.PHP_EOL;
    if(empty($master_pid)) die("master_pid error\n");
    exec("ps --ppid {$master_pid} | awk '/[0-9]/{print $1}'",$output,$status);
    if ($status == 0){
        if ($output){
            foreach ($output as $pid){
                posix_kill($pid,SIGKILL);
            }
        }
    }
    return $master_pid;
}

function kill_all()
{
    $master_pid = kill_childs();
    posix_kill($master_pid,SIGKILL);
    if($master_pid_file = exist_master_pid_file()) {
        @unlink($master_pid_file);
    }

}


$master_pid_file = "/tmp/master_pid_file.pid";

$args = isset($_SERVER["argv"][1])?$_SERVER["argv"][1]:"";
switch ($args)
{
    case "start";
        if(exist_master_pid_file()){
            die("Already running...\n");
        }
    break;
    case "reload";
        kill_all();
        break;
    case "stop";
        kill_all();
        die("stoped\n");
        break;
    default:
        die("请输入-option:[start|reload|stop]\n");
        break;
}

daemon();

$master_pid = posix_getpid();
file_put_contents($master_pid_file,$master_pid);

$work_num = 3;
$master_stop = false;
$childs_pid = [];

for ($i=0;$i<$work_num;$i++){
    fork($i);
}
//var_dump($childs_pid);

// 监控子进程
while ( count($childs_pid) ) {
    if ( ($exit_id = pcntl_wait($status)) > 0 ) {
        unset($childs_pid[$exit_id]);
    }

    if ( count($childs_pid) < $work_num ) {
        fork();
    }
}

