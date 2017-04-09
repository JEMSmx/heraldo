<?php
$redirect = $sanitizer->name(wire('input')->get->redirect);

$url = $pages->get($redirect)->url;

if($user->isLoggedin()) {
  $session->logout();
}

$session->redirect($url);

?>
