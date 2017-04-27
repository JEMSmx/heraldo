<?php include('./_head.php');
$alltags = array(); 
$use_urlsegments = false;
$parray = $pages->find("template=evento, images.tags!=''");
foreach($parray as $p) {
    $images = $p->images->find("tags!=''");
    foreach($images as $im) {
        $tags = $im->tags;
        $tags = explode(',', $tags);
        foreach($tags as $tag) {
            $tag=strtolower($tag);
            $alltags[$sanitizer->pageName($tag, Sanitizer::translate)] = $tag;
        }
    }
} 
$cur = $input->pageNum;
if(empty($input->urlSegment1) && empty($input->get->tag)) exit; 
              if($input->urlSegment1) {
                  $tagvalue = strtolower($input->urlSegment1);
                  if(!in_array(str_replace("-", " ", $tagvalue), $alltags)) $session->redirect("/"); 
                  $tagvalue = $alltags[$tagvalue];
              }
              if($input->get->tag) {
                  $tagvalue = $sanitizer->selectorValue(strtolower($input->get->tag));
              }  ?>
   <div class="j-workspace albums-grid">
     <div class="j-wrap">
      <h2>Álbumes etiqueta: <strong><?php echo $tagvalue; ?></strong></h2>
       <div class="grid">
        <div class="contenedor">
        <?php 
              $albumes = $pages->find("images.tags~='$tagvalue'");
              if(count($albumes)) {
               foreach ($albumes as $key=>$album) { 
                $image_album = $album->images->first();
                if($image_album){
                  $img_album_2x = $image_album->width(1200, array('quality' => 90, 'upscaling' => true, 'cropping' => false));
                }
                     ?>           
         <div class="unit one-quarter album-unit">
           <div class="image-album" <?php if($image_album) {?>style="background-image:url('<?php echo $img_album_2x->url; ?>'); <?php } ?>">
             <div class="image-album-overlay">
                <a data-fancybox="gallery<?php echo $cur.$key ?>" href="<?php echo $img_album_2x->url; ?>" data-caption="<?php echo ($image_album->description) ? 'Descripción: '.$image_album->description:''; echo ($image_album->autor) ? '<br>Autor: '.$image_album->autor:''; echo ($image_album->dateoriginal) ? '<br>Fecha: '.$image_album->dateoriginal:''; if($image_album->city || $image_album->pais || $image_album->lugar) echo '<br>'; echo ($image_album->city) ? '  Ciudad: '.$image_album->city:''; echo ($image_album->pais) ? '  País: '.$image_album->pais:''; echo ($image_album->lugar) ? ' Lugar: '.$image_album->lugar:''; echo ($image_album->tags) ? '$'.$image_album->tags:''; ?>">
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
              <a data-fancybox="gallery<?php echo $cur.$key ?>" href="<?php echo $img->url; ?>" data-caption="<?php echo ($image->description) ? 'Descripción: '.$image->description:''; echo ($image->autor) ? '<br>Autor: '.$image->autor:''; echo ($image->dateoriginal) ? '<br>Fecha: '.$image->dateoriginal:''; if($image->city || $image->pais || $image->lugar) echo '<br>'; echo ($image->city) ? '  Ciudad: '.$image->city:''; echo ($image->pais) ? '  País: '.$image->pais:''; echo ($image->lugar) ? '  Lugar: '.$image->lugar:''; echo ($image->tags) ? '$'.$image->tags:'$'; ?>"></a>
           <?php } ?>
         <?php } }?>
         </div>
       </div>
     </div>
   </div>
<?php include('./_foot.php'); ?>
<script type="text/javascript">
  function dAlbum(idAlbum){
    window.location="<?php echo $config->urls->root;?>"+"descarga?checksum="+$("#chk-"+idAlbum).val();;
  }
$('[data-fancybox]').fancybox({
  image : {
    protect: true
  },
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
});
</script>