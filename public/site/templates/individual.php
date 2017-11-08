<?php
if(!$user->isLoggedin()) $session->redirect("/"); 

if(true){ 

	$checksum=k::decrypt(str_replace(" ", "+", $input->get->checksum));

	if(strpos($checksum, ":") === false) $session->redirect("/"); 

	if(strpos($checksum, "<>") === false) $session->redirect("/"); 

	$values=explode(":", $checksum);

	$difference=time()-$values[1];

	if($difference>10000) $session->redirect("/"); 

	$getFoto=explode("<>", $values[0]);

	$filename=$getFoto[1];


	if(!$filename) die("download not found");
	$download_options = array(
		'exit' => false,
		'forceDownload' => true,
		'downloadFilename' => '',
		);
	wireSendFile($filename, $download_options);
	exit;
} else{
	$session->redirect("/"); 
}


