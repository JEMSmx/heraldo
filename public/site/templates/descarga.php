<?php
if(!$user->isLoggedin()) $session->redirect("/"); 

if($user->hasRole('administrator') || $user->hasRole('superuser') || $user->hasRole('manager')){ 
	$checksum=k::decrypt(str_replace(" ", "+", $input->get->checksum));

	if(strpos($checksum, ":") === false) $session->redirect("/"); 

	if(strpos($checksum, "/") === false) $session->redirect("/"); 

	$values=explode(":", $checksum);

	$difference=time()-$values[1];

	if($difference>10000) $session->redirect("/"); 

	$id_album=explode("/", $values[0]);

	$album=$pages->get($id_album[0]);

	$zip = new ZipArchive();

	$filename = $album->name.'.zip';

	if($zip->open($filename,ZIPARCHIVE::CREATE)===true) {

	  foreach ($album->images as $image) {
	    $zip->addFile($image->filename, basename($image->filename));
	  }

	  $zip->close();

	  if(!$filename) die("download not found");

	  wireSendFile($filename, array('exit' => false));
	  unlink($filename);
	  exit;
	}

}else{
	$session->redirect("/"); 
}




