<?php
$data=$input->post->data;
$idVideo=$input->post->video;
$page=$pages->get($idVideo);

list($type, $data) = explode(';', $data);
list(, $data)      = explode(',', $data);
$data1 = base64_decode($data);

file_put_contents('/tmp/'.$page->title, $data1);

$page->of(false);

$page->images->add('/tmp/'.$page->title);

$page->save();

$page->of(true);