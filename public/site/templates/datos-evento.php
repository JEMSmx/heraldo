<?php require_once ('./_mobile-detect.php'); $detect = new Mobile_Detect;
    $page=$pages->get($input->get->current);
    $pagination=24;
    $cur = $input->get->pagina;
    $max = (count($page->images)) / $pagination;
    $next = $cur<$max ? $cur + 1 : false;
    $prev = $cur>1 ? $cur - 1 : false;
    $ini = $cur==1 ? 0 : ($cur-1)*$pagination;
    if($cur-1>$max) exit;
   $id=$pagination*($cur-1); 
        $images=$page->images->find("start=$ini, limit=$pagination");
          foreach ($images as $image) { 
                $id++;
                $img_2x = $image->width(1200, array('quality' => 90, 'upscaling' => true, 'cropping' => false)); ?> 
         <div class="unit one-quarter album-unit">
           <div class="image-album" <?php if($img_2x) {?>style="background-image:url('<?php echo $img_2x->url; ?>'); <?php } ?>">
             <div class="image-album-overlay">
                <a href="<?php echo $img_2x->url; ?>" data-fancybox="gallery" <?php if(!$detect->isMobile() || $detect->isTablet()) { ?>  data-caption="<?php echo ($image->description) ? 'Descripción: '.$image->description:''; echo ($image->autor) ? '<br>Autor: '.$image->autor:''; echo ($image->dateoriginal) ? '<br>Fecha: '.$image->dateoriginal:''; if($image->city || $image->pais || $image->lugar) echo '<br>'; echo ($image->city) ? '  Ciudad: '.$image->city:''; echo ($image->pais) ? '  País: '.$image->pais:''; echo ($image->lugar) ? ' Lugar: '.$image->lugar:''; echo (str_replace(" ", "", k::quitaracentos($image->tags))) ? '$'.str_replace(" ", "", k::quitaracentos($image->tags)):''; ?>" <?php } ?>>
                  <p>Ver</p>
                </a>
                <?php if($user->hasRole('administrator') || $user->hasRole('superuser') || $user->hasRole('admindoctos') || $user->hasRole('adminfotografo') || $user->hasRole('fotografo') || $user->hasRole('admindisenador') || $user->hasRole('disenador') || $user->hasRole('coeditor') || $user->hasRole('adminvideos') || $user->hasRole('editor')){ ?> 
                  <a onclick="dFoto('<?php echo $id; ?>'); return false;" id="download-album" href="">
                    <input type="hidden" id="chk-<?php echo $id ?>" name="checksum" value="<?php echo k::encrypt($image.'<>'.$image->filename.':'.time()); ?>">
                    <p>Descargar</p>
                  </a>
                <?php } ?>
                <?php if($user->hasRole('administrator') || $user->hasRole('superuser') || $user->hasRole('adminfotografo') || $page->createdUser == $user){ ?> 
                  <a href="<?php echo $config->urls->admin ?>page/edit/?id=<?php echo $page->id; ?>">
                    <p>Modificar</p>
                  </a>
                <?php } ?>
             </div>
           </div>
           <?php if($user->hasRole('administrator') || $user->hasRole('superuser') || $user->hasRole('adminfotografo') || $user->hasRole('editor')){ ?> 
           <div class="title-album">
             <?php $name=explode(".", $image->basename); if($image->fav==1) $type='quit'; ?>
           <a id="a-<?=$id;?>" href="" onclick="addFav('<?php echo $id; ?>','<?php echo $page->id; ?>','<?php echo $type; ?>'); return false;">
               <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                 viewBox="0 0 53.867 53.867" style="enable-background:new 0 0 53.867 53.867;" xml:space="preserve">
               <polygon id="p-<?=$id;?>" <?php if($image->fav==1) { ?> style="fill: #ffcd04;" <?php } ?> points="26.934,1.318 35.256,18.182 53.867,20.887 40.4,34.013 43.579,52.549 26.934,43.798
                10.288,52.549 13.467,34.013 0,20.887 18.611,18.182 "/>
               </svg>
               </a>
             <a data-fancybox data-src="<?php echo $config->urls->root;?>foto?page=<?php echo $page->id.'&image='.$name[0].'&ext='.$name[1]; ?>" href="javascript:;">
             <h3><?php echo $name[0]; ?></h3>
             </a>
           </div>
           <?php } else { ?>
             <?php $name=explode(".", $image->basename); ?>
             <a data-fancybox data-src="<?php echo $config->urls->root;?>foto?page=<?php echo $page->id.'&image='.$name[0].'&ext='.$name[1]; ?>" href="javascript:;">
             <h3><?php echo $name[0]; ?></h3>
             </a>
           <?php } ?> 
         </div>
        <?php } ?>  
<script type="text/javascript">
$('[data-fancybox]').fancybox({
  image : {
    protect: true
  },
  iframe:{
    scrolling: 'yes'
  },
<?php if($user->hasRole('administrator') || $user->hasRole('superuser') || $user->hasRole('manager')){  ?>  
  onInit : function(instance) {
    instance.$refs.downloadButton = $('<a download class="fancybox-button fancybox-download"></a>')
      .appendTo( instance.$refs.buttons );
  },
  beforeMove: function(instance, current) {
    var image_original=current.src.replace(".1200x0","");
    instance.$refs.downloadButton.attr('href', image_original);
  },
  <?php } 
  if(!$detect->isMobile() || $detect->isTablet()) { ?> 
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