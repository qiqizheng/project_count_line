<?php

header("Content-Type: text/html;charset=utf-8");
set_time_limit(0);
project_line("E:/work/debug/phar/vendor/laravel");

function project_line($closure_file)
{
    $start = microtime(true);
    $total_line = 0;
    //如果是目录，则遍历
    if(is_dir($closure_file)){
        if($handle = opendir($closure_file)) {
            while(false !== ($file = readdir($handle))){
                if($file = '.' || $file = '..') {
                    continue;
                }
                echo $file;
                //如果是目录继续递归
                if(is_dir($file)){
                    project_line($file);
                }else{
                    //检测代码行数
                    $temp_line = count_line($file);
                    $total_line +=$temp_line;
                }
            }
        }
    }else{
        //检测代码行数
        $temp_line = count_line($closure_file);
        $total_line +=$temp_line;
    }
//    echo "总行数为:".$total_line;
    echo "xx:".$total_line;
    PHP_EOL;
    echo "qq：".(microtime(true)-$start);
//    echo "执行时间为：".(microtime(true)-$start);

}

//计算文件行数
function count_line($file)
{
    if(is_file($file)){
        $fp = fopen($file,'r');
        $line = 0;
        if($fp){
            while(stream_get_line($fp, 8192, "\n")){
                $line++;
            }
        }
        fclose($file);
        return $line;
    }
    return 0;
}

?>