<?php

header("Content-Type: text/html;charset=utf-8");
set_time_limit(0);
$url = "D:/work/debug/phar/vendor/facade/";
$total_line = new total_line();
$total_line->project_line($url, $url);

class total_line{

    protected $_line = 0;

    function  project_line($closure_file,$dir)
    {
        $start = microtime(true);
        //如果是目录，则遍历
        if(is_dir($closure_file)){
            if($handle = opendir($closure_file)) {
                while(false !== ($file = readdir($handle))){
                    if($file == '.' || $file == '..') {
                        continue;
                    }

//                如果是目录继续递归
                    if(is_dir($dir.$file)){
                        $this->project_line($dir.$file, $dir.$file."/");
                    }else{
                        if(trim(strstr($file, "."),".") != 'php'){
                            continue;
                        }
                        //检测代码行数
                        $temp_line = $this->file_line($dir.$file);
                        $this->_line +=$temp_line;
                    }
                }
            }
        }else{
            //检测代码行数
            $temp_line = $this->file_line($closure_file);
            $this->_line +=$temp_line;
        }
        echo "总行数为:".$this->_line;
        echo PHP_EOL;
        echo "执行时间为：".(microtime(true)-$start);

    }

//计算文件行数
    function file_line($file)
    {
        if(is_file($file)){
            $fp = fopen($file,'r');
            $line = 0;
            if($fp){
//                while(stream_get_line($fp, 8192)){
//                    $line++;
//                }

                  while (fgets($fp, 4096) !== false){
                      $line ++;
                  }
            }


            fclose($fp);
            return $line;
        }
        return 0;
    }



}


?>