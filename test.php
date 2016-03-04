<?php
/*function read_all_file($dir){
    $arr=array();
    $fp=opendir($dir);
  while(false!==($file=readdir($fp))){
      if($file!='.'&&$file!='..') {
          if (is_file($dir . '/' . $file)) $arr['file'][] = $file;
          if (is_dir($dir . '/' . $file))  $arr['dir'][] = $file;
      }
  }
    closedir($fp);
    return  $arr;
}
print_r(read_all_file('D:\wnmp\php'));*/
/*set_time_limit(0);
$time=time();
$num=0;
for($i=1;$i<1000000000;$i++){
    $num=$num+$i;
}
echo $num;
echo "<br/>";
echo time()-$time;*/
//echo '例子：';
//fastcgi_finish_request(); /* 响应完成, 关闭连接 */

/* 记录日志 */
//file_put_contents('log.txt', '生存还是毁灭,这是个问题.');
$str='abcdefghigklmn';
preg_match_all("/./u", $str, $matches);
print_r($matches);




