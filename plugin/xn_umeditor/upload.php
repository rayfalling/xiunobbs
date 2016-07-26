<?php

define('DEBUG', 1);

chdir('../../');

define('SKIP_ROUTE', TRUE); // 跳过路由处理，否则 index.php 中会中断流程

include './index.php';

$width = param('width', 0);
$height = param('height', 0);
$filename = param('filename');
$data = param('data', '', FALSE);

empty($data) AND message(-1, 'upfile 数据为空');
$data = base64_decode_image_data($data);
$size = strlen($data);
$size > 2048000 AND message(-1, '文件尺寸太大，不能超过 2M，当前大小：'.$size);

$ext = file_ext($filename, 3);
in_array($ext, array('jpg', 'png', 'gif', 'bmp')) AND message(-1, '不允许的格式。');
$tmpanme = $uid.'_'.$time.'_'.xn_rand(32).$ext;
$tmpfile = $conf['upload_path'].'tmp/'.$tmpanme;
$tmpurl = $conf['upload_url'].'tmp/'.$tmpanme;

file_put_contents($tmpfile, $data) OR message(-1, '写入文件失败');

message(0, array('url'=>$tmpurl));

?>