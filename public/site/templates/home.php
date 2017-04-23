<?php include('./_head.php');
    $find_category=$input->urlSegment2;
    $field = $fields->get('category');
    $all_options = $field->type->getOptions($field);
    $option_url = $all_options->get("value=".$find_category);
    $pagination=20;
    $cur = $input->pageNum;
    if(!empty($find_category))
      $max = intval(($pages->find("template=template=evento, category=".$option_url)->getTotal()) / $pagination);
    else
      $max = intval(($pages->find("template=evento")->getTotal()) / $pagination);
    $next = $cur<$max ? $cur + 1 : false;
    $prev = $cur>1 ? $cur - 1 : false;
    $ini = $cur==1 ? 0 : ($cur-1)*$pagination;
    if($cur-1>$max) $session->redirect("/");
    ?>
  <div class="j-workspace">
     <div class="j-wrap sub-categories-container">
       <ul class="sub-categories">
       <a href="<?php echo $config->urls->root; ?>">
           <li>Recientes</li>
         </a>
       <?php foreach ($all_options as $option) { ?>
        <a href="<?php echo $config->urls->root; ?>categoria/<?php echo $option->value; ?>">
           <li><?php echo $option->title; ?></li>
         </a>
        <?php } ?>
       </ul>
       <select name="categories" id="categories">
         <option value="Seleccionar">Categorias</option>
         <option value="recientes">Recientes</option>
         <?php foreach ($all_options as $option) { ?>
         <option value="<?php echo $option->value; ?>"><?php echo $option->title; ?></option>
         <?php } ?>
       </select>
     </div>
   </div>
   <div class="j-workspace albums-grid">
     <div class="j-wrap">
      <h2>Álbumes recientes</h2>
       <div class="grid">
        <div class="contenedor">
        <?php if(!empty($find_category))
                  $albumes=$pages->find("template=evento, sort=-published, category=".$option_url.", start=".$ini.", limit=".$pagination);
              else
                  $albumes=$pages->find("template=evento, sort=-published, start=".$ini.", limit=".$pagination);
               foreach ($albumes as $key=>$album) { 
                $image_album = $album->images->first();
                if($image_album){
                  $img_album_2x = $image_album->width(1200, array('quality' => 90, 'upscaling' => true, 'cropping' => false));
                }
                     ?>           
         <div class="unit one-quarter album-unit">
           <div class="image-album" <?php if($image_album) {?>style="background-image:url('<?php echo $img_album_2x->url; ?>'); <?php } ?>">
             <div class="image-album-overlay">
                <a data-fancybox="gallery<?php echo $cur.$key ?>" href="<?php echo $img_album_2x->url; ?>">
                  <p>Ver</p>
                </a>
                <?php if($user->hasRole('administrator') || $user->hasRole('superuser') || $user->hasRole('manager')){ ?> 
                  <a onclick="dAlbum('<?php echo $album->id; ?>'); return false;" id="download-album" href="">
                    <input type="hidden" id="chk-<?php echo $album->id ?>" name="checksum" value="<?php echo k::encrypt($album->id.'/'.$album->title.':'.time()); ?>">
                    <p>Descargar</p>
                  </a>
                <?php } ?> 
                <?php if($user->hasRole('administrator') || $user->hasRole('superuser') || $album->createdUser == $user){ ?> 
                  <a href="<?php echo $config->urls->admin ?>page/edit/?id=<?php echo $album->id; ?>">
                    <p>Modificar</p>
                  </a>
                <?php } ?>
             </div>
           </div>
           <a href="<?php echo $album->url; ?>">
            <h3><?php echo $album->title; ?></h3>
           </a>
           <?php $datos = exif_read_data($image_album->httpUrl);
                 $image_path=$image_album->httpUrl;
                 $size = getimagesize ($image_path, $info);
                 $iptc = isset($info['APP13']) ? iptcparse($info["APP13"]):null;
                 if($album->metadata==0)
                    k::add_attributes($album->id,$iptc,$datos); ?>               
           <p><?php echo $image_album->dateoriginal; ?></p>    
         </div>
         <?php $inc=0; 
            foreach ($album->images as $image) { 
              $inc++; 
              if($inc==1) continue;
              $img = $image->width(1200, array('quality' => 90, 'upscaling' => true, 'cropping' => false));                  
               ?>
              <a data-fancybox="gallery<?php echo $cur.$key ?>" href="<?php echo $img->url; ?>"></a>
           <?php } ?>
         <?php } ?>
         </div>
       </div>
     </div>
   </div>
<?php include('./_foot.php'); ?>
<script type="text/javascript">
$('#categories').change(function() {
  if($(this).val()=='recientes')
    window.location = "<?php echo $config->urls->root; ?>";
  else
    window.location = "<?php echo $config->urls->root; ?>categoria/"+$(this).val();
});
var pagina=1;
  $(window).scroll(function(){
    if ($(window).scrollTop() == $(document).height() - $(window).height()){
      pagina++;
      cargardatos();
    }                                       
  });
  function cargardatos(){ 
    $.get("datos?pagina="+pagina+"&categoria="<?php echo $find_category; ?>,
      function(data){
        if (data != "") {
          $(".contenedor:last").after(data); 
        }
      });                              
  }
  function dAlbum(idAlbum){
    window.location="descarga?checksum="+$("#chk-"+idAlbum).val();;
  }
$('[data-fancybox]').fancybox({
  image : {
    protect: true
  }
});
</script>