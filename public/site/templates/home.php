<?php include('./_head.php');
    $find_category=$input->urlSegment2;
    $field = $fields->get('category');
    $all_options = $field->type->getOptions($field);
    $option_url = $all_options->get("value=".$find_category);
    $pagination=20;
    $cur = $input->pageNum;
    if(!empty($find_category))
      $max = intval(($pages->find("template=evento, category=".$option_url)->getTotal()) / $pagination);
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
        <a href="<?php echo $config->urls->root; ?>videos">
           <li>Videos</li>
         </a>
       </ul>
       <select name="categories" id="categories">
         <option value="Seleccionar">Categorias</option>
         <option value="recientes">Recientes</option>
         <?php foreach ($all_options as $option) { ?>
         <option value="<?php echo $option->value; ?>"><?php echo $option->title; ?></option>
         <?php } ?>
         <option value="videos">Videos</option>
       </select>
     </div>
   </div>
   <div class="j-workspace albums-grid">
     <div class="j-wrap">
      <h2>Álbumes recientes</h2>
       <div class="grid">
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
                <a data-fancybox="gallery<?php echo $cur.$key ?>" href="<?php echo $img_album_2x->url; ?>" <?php if(!$detect->isMobile() || $detect->isTablet()) { ?>  data-caption="<?php echo ($image_album->description) ? 'Descripción: '.$image_album->description:''; echo ($image_album->autor) ? '<br>Autor: '.$image_album->autor:''; echo ($image_album->dateoriginal) ? '<br>Fecha: '.$image_album->dateoriginal:''; if($image_album->city || $image_album->pais || $image_album->lugar) echo '<br>'; echo ($image_album->city) ? '  Ciudad: '.$image_album->city:''; echo ($image_album->pais) ? '  País: '.$image_album->pais:''; echo ($image_album->lugar) ? ' Lugar: '.$image_album->lugar:''; echo ($image_album->tags) ? '$'.$image_album->tags:''; ?>"" <?php } ?>>
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
           <?php  if($album->metadata==0)
                    k::add_attributes($album->id); ?>               
           <p><?php echo $image_album->dateoriginal; ?></p>    
         </div>
         <?php $inc=0; 
            foreach ($album->images as $image) { 
              $inc++; 
              if($inc==1) continue;
              $img = $image->width(1200, array('quality' => 90, 'upscaling' => true, 'cropping' => false));                  
               ?>
              <a data-fancybox="gallery<?php echo $cur.$key ?>" href="<?php echo $img->url; ?>" <?php if(!$detect->isMobile() || $detect->isTablet()) { ?> data-caption="<?php echo ($image->description) ? 'Descripción: '.$image->description:''; echo ($image->autor) ? '<br>Autor: '.$image->autor:''; echo ($image->dateoriginal) ? '<br>Fecha: '.$image->dateoriginal:''; if($image->city || $image->pais || $image->lugar) echo '<br>'; echo ($image->city) ? '  Ciudad: '.$image->city:''; echo ($image->pais) ? '  País: '.$image->pais:''; echo ($image->lugar) ? '  Lugar: '.$image->lugar:''; echo ($image->tags) ? '$'.$image->tags:'$'; ?>" <?php } ?>></a>
           <?php } ?>
         <?php } ?>
       </div>
     </div>
   </div>
<?php include('./_foot.php'); ?>
<script type="text/javascript">
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
          $(".album-unit:last").after(data); 
        }
      });                              
  }
  function dAlbum(idAlbum){
    window.location="descarga?checksum="+$("#chk-"+idAlbum).val();;
  }
$('[data-fancybox]').fancybox({
  image : {
    protect: true
  },
 <?php if(!$detect->isMobile() || $detect->isTablet()) { ?> 
  caption : function( instance, item ) {
    var originalCaption, caption, link="Etiquetas: ", tags;
    if (item.type === 'image') {
      originalCaption=$(this).data('caption').split('$');
      caption = originalCaption[0];
      if(originalCaption[1]){
        tags=originalCaption[1].split(',');
        $.each(tags, function(key,value) {
          if(key==(tags.length-1))
            link+='<a href="/etiquetas/' + value.replace(" ","-") + '">'+value+'</a>';
          else
            link+='<a href="/etiquetas/' + value.replace(" ","-") + '">'+value+'</a>, ';
        });
        return (caption ? caption + '<br />' : '') + link;
      }else{
        return caption;
      }
    }
  }
 <?php } ?> 
});
</script>
