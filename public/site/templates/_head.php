<?php if(!$user->isLoggedin()) $session->redirect("/iniciar-sesion"); 
require_once ('./_mobile-detect.php'); $detect = new Mobile_Detect; ?>
<!DOCTYPE html>
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Archivo digital</title>
  <link href="https://fonts.googleapis.com/css?family=Raleway:300,500,700" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/normalize/4.2.0/normalize.min.css" integrity="sha256-K3Njjl2oe0gjRteXwX01fQD5fkk9JFFBdUHy/h38ggY=" crossorigin="anonymous" rel="stylesheet">
  <link href="https://cdn.rawgit.com/cobyism/gridism/0.2.2/gridism.css" rel="stylesheet">
  <link href="<?php echo $config->urls->templates; ?>assets/styles/_main.css" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.0.47/jquery.fancybox.min.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
  <link rel="apple-touch-icon" href="<?php echo $config->urls->templates; ?>assets/images/heraldo.png">
  <link rel="shortcut icon" href="<?php echo $config->urls->templates; ?>assets/images/heraldo.png">
  <meta name="robots" content="noindex">
<meta name="googlebot" content="noindex">
</head>
<style type="text/css">
.fancybox-download:before {
  top: 14px;
  left: 22px;
  border-left: 2px solid #fff;
  height: 12px;
}

.fancybox-download:after {
  bottom: 18px;
  left: 23px;
  height: 8px;
  border-bottom: 2px solid #fff;
  border-right: 2px solid #fff;
  width: 8px;
  background: transparent;
  transform: rotate(45deg);
  transform-origin: 0 0;
}</style>
<body>
  <div class="container">
   <aside class="sidebar clearfix">
      <nav>
        <div class="dropdown">
          <a href="<?php echo $config->urls->admin ?>profile/"><?php echo $user->namefull ?><img src="<?php echo $config->urls->templates; ?>static/455375-1493372430/images/down-chevron.svg" alt=""></a>
          <ul>
            <?php if($user->hasRole('administrator') || $user->hasRole('superuser') || $user->hasRole('adminfotografo') || $user->hasRole('fotografo')){ ?> 
            <a href="<?php echo $config->urls->admin ?>page/add/?parent_id=1014"><li>Subir Evento</li></a><?php } ?> 
            <?php if($user->hasRole('administrator') || $user->hasRole('superuser') || $user->hasRole('adminfotografo') || $user->hasRole('adminvideos')){ ?> 
            <a href="<?php echo $config->urls->admin ?>page/add/?parent_id=1030"><li>Subir Video</li></a><?php } ?> 
            <?php if($user->hasRole('administrator') || $user->hasRole('superuser') || $user->hasRole('admininfografista') || $user->hasRole('infografista')){ ?> 
            <a href="<?php echo $config->urls->admin ?>page/add/?parent_id=1038"><li>Subir Infografía</li></a><?php } ?> 
            <?php if($user->hasRole('administrator') || $user->hasRole('superuser') || $user->hasRole('admindoctos') || $user->hasRole('adminfotografo') || $user->hasRole('fotografo') || $user->hasRole('admininfografista') || $user->hasRole('infografista') || $user->hasRole('admindisenador') || $user->hasRole('disenador')){ ?> 
            <a href="<?php echo $config->urls->admin ?>page/add/?parent_id=1040"><li>Subir Documento</li></a><?php } ?> 
            <?php if($user->hasRole('administrator') || $user->hasRole('superuser') || $user->hasRole('admindoctos') || $user->hasRole('adminfotografo') || $user->hasRole('admininfografista') || $user->hasRole('admindisenador') || $user->hasRole('adminvideos')){ ?> 
            <a href="<?php echo $config->urls->admin ?>page/"><li>Administrar</li></a>
            <?php } ?> 
            <?php if($user->hasRole('administrator') || $user->hasRole('superuser')){ ?> 
              <a href="<?php echo $config->urls->admin ?>access/users/add/"><li>Usuario nuevo</li></a>
            <?php } ?>
            <a href="<?php echo $config->urls->root."logout?redirect=".$page->id; ?>"><li>Cerrar sesión</li></a>
          </ul>
        </div>
      </nav>
    </aside>
    <div id="morphsearch" class="morphsearch">
        <form class="morphsearch-form">
          <input class="morphsearch-input" type="search" placeholder="Buscar..."/>
          <button class="morphsearch-submit" type="submit"></button>
        </form>
        <div id="display">
          <div class="morphsearch-content">
            <div class="dummy-column">
              <h2>Fotógrafos</h2>
              <?php $users=$pages->find("template=user, roles=photographer");
                foreach ($users as $user_b) { ?> 
                  <a class="dummy-media-object">
                    <img src="<?php echo ($user_b->photoProfile) ? $user_b->photoProfile->url:$config->urls->templates.'static/455375-1493372430/images/profile.png'; ?>" alt="Sara Soueidan"/>
                    <h3><?php echo $user_b->namefull; ?></h3>
                  </a>
              <?php } ?>
            </div>
            <div class="dummy-column">
              <h2>Eventos</h2>
              <?php $albumes=$pages->find("template=evento, sort=random");
                foreach ($albumes as $album) { 
                   $image_album = $album->images->first();
                  if($image_album){
                    $img_album = $image_album->width(100, array('quality' => 90, 'upscaling' => false, 'cropping' => true));
                  } ?>
                  <a class="dummy-media-object" href="<?php echo $album->url; ?>">
                  <img src="<?php echo $img_album->url; ?>" alt="<?php echo $image_album->title; ?>"/>
                  <h3><?php echo $album->title; ?></h3>
                </a>
                <?php } ?>
            </div>
            <div class="dummy-column">
              <h2>Eventos Recientes</h2>
              <?php $albumes=$pages->find("template=evento, sort=-published");
                foreach ($albumes as $album) { 
                   $image_album = $album->images->first();
                  if($image_album){
                    $img_album = $image_album->width(100, array('quality' => 90, 'upscaling' => false, 'cropping' => true));
                  } ?>
                  <a class="dummy-media-object" href="<?php echo $album->url; ?>">
                  <img src="<?php echo $img_album->url; ?>" alt="<?php echo $image_album->title; ?>"/>
                  <h3><?php echo $album->title; ?></h3>
                </a>
                <?php } ?>
            </div>
          </div><!-- /morphsearch-content -->
        </div>
        <span class="morphsearch-close"></span>
      </div><!-- /morphsearch -->
    <div class="overlay"></div>
  </div><!-- /container -->
   <div class="j-workspace">
     <div class="j-wrap">
     <a href="<?php echo $config->urls->root; ?>">
       <header>
          <img src="<?php echo $config->urls->templates; ?>assets/images/heraldo.png" alt="">
         <h1>Archivo digital</h1>
       </header>
      </a>
     </div>
   </div>