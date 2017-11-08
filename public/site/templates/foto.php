<?php $page=$pages->get($input->get->page);
          $im=$input->get->image.'.'.$input->get->ext;
          $image = $page->images->get("name=$im");
          $img = $image->size(600, 400, array('quality' => 90, 'upscaling' => true, 'cropping' => false));
      ?>
<!DOCTYPE html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Archivo digital</title>
  <link href="https://fonts.googleapis.com/css?family=Raleway:300,500,700" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/normalize/4.2.0/normalize.min.css" integrity="sha256-K3Njjl2oe0gjRteXwX01fQD5fkk9JFFBdUHy/h38ggY=" crossorigin="anonymous" rel="stylesheet">
  <link href="https://cdn.rawgit.com/cobyism/gridism/0.2.2/gridism.css" rel="stylesheet">
  <link href="<?php echo $config->urls->templates; ?>assets/styles/_main.css" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.0.47/jquery.fancybox.min.css" />
  <link rel="apple-touch-icon" href="https://dummyimage.com/50x50/000/fff">
  <link rel="shortcut icon" href="https://dummyimage.com/50x50/000/fff">
</head>
<body>
  <!--  Categorias  -->
  <div class="j-workspace photo">
     <div class="j-wrap grid">
      <div class="unit half" style="text-align: center;">
        <img src="<?php echo $img->url; ?>" alt="<?php $name=explode(".", $image->basename); echo $name[0]; ?>">
      </div>
      <div class="unit half">
        <h1><?php echo $name[0]; ?></h1>
        <h2>Categoria: <a href="<?php echo $config->urls->root.'categoria/'.$page->category->value; ?>" target="_top"><span><?php echo $page->category->title; ?></span></a></h2>
        <h3>Album: <a href="<?php echo $page->url; ?>"><span><?php echo $page->title; ?></span></a></h3>
        <p><?php echo $image->description; ?></p>
        <?php if($image->autor){ ?> 
          <p><span>Autor: </span><?php echo $image->autor; ?></p>
        <?php } 
        if($image->dateoriginal){ ?> 
          <p><span>Fecha: </span><?php echo $image->dateoriginal; ?></p>
        <?php } 
        if($image->city){ ?>
          <p><span>Ciudad: </span><?php echo $image->city; ?></p>
        <?php } 
        if($image->pais){ ?>
          <p><span>País: </span><?php echo $image->pais; ?></p>
        <?php } 
        if($image->lugar){ ?>
          <p><span>Lugar: </span><?php echo $image->lugar; ?></p>
        <?php } 

        if($image->tags){ ?>
          <p><span>Etiquetas: </span>
          <?php $tags_wi = str_replace(" ", "", k::quitaracentos($image->tags));
                $etiquetas=explode(",", $tags_wi);
                foreach ($etiquetas as $number=>$etiqueta) {  
                  $number++;
                  $etiqueta_url=(strpos($etiqueta, " ") === false) ? $etiqueta:str_replace(" ", "-", $etiqueta);
                  echo (count($etiquetas)==$number) ? '<a target="_top" href="'.$config->urls->root.'etiquetas/'.strtolower($etiqueta_url).'">'.$etiqueta.'</a>':'<a target="_top" href="'.$config->urls->root.'etiquetas/'.strtolower($etiqueta_url).'">'.$etiqueta.'</a>, '; 
                } ?>
          </p>
        <?php } ?>
        <?php if($user->hasRole('administrator') || $user->hasRole('superuser') || $user->hasRole('admindoctos') || $user->hasRole('adminfotografo') || $user->hasRole('fotografo') || $user->hasRole('admindisenador') || $user->hasRole('disenador') || $user->hasRole('coeditor') || $user->hasRole('adminvideos') || $user->hasRole('editor')){ ?> 
        <button onclick="dFoto();"class="btn">Descargar</button>
       <input type="hidden" id="chk" name="checksum" value="<?php echo k::encrypt($image.'<>'.$image->filename.':'.time()); ?>">
         <?php } ?>           
      </div>
     </div>
   </div>
 <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script type="text/javascript">
  function dFoto(){
    window.location="<?php echo $config->urls->root;?>"+"individual?checksum="+$("#chk").val();;
  } 
</script>