<?php include('./_head.php');
    $find_category=$input->urlSegment1;
    $field = $fields->get('category');
    $all_options = $field->type->getOptions($field);
    $option_url = $all_options->get("value=".$find_category);
    if(!empty($find_category))
      $pagesWithImages = $pages->find("template=evento, sort=-published, category=".$option_url.", images.count>0, (images.fav=1), sort=-published");
    else
      $pagesWithImages = $pages->find("template=evento, images.count>0, (images.fav=1), sort=-published");
        $allImages = array();
        foreach($pagesWithImages as $p) {
            if(count($allImages)>50) break;
            foreach($p->images as $image){
              if($image->fav==1){
                $allImages[] = $image; 
                $allPages[] = $p->id;
              }
            } 
        } ?>
  <div class="j-workspace">
    <?php include('./_nav.php'); ?>
   </div>
   <div class="j-workspace albums-grid">
     <div class="j-wrap">
      <h2><?=($find_category) ? $option_url->title:'Fotografías Sugeridas'; ?></h2>
       <div class="grid">
        <?php $id=0; 
          foreach ($allImages as $image) { 
                $pageid=$allPages[$id];
                $id++;
                $img_2x = $image->width(1200, array('quality' => 90, 'upscaling' => true, 'cropping' => false)); ?> 
         <div id="dv-<?=$id;?>" class="unit one-quarter album-unit">
           <div class="image-album" <?php if($img_2x) {?>style="background-image:url('<?php echo $img_2x->url; ?>'); <?php } ?>">
             <div class="image-album-overlay">
                <a href="<?php echo $img_2x->url; ?>" data-fancybox="gallery" <?php if(!$detect->isMobile() || $detect->isTablet()) { ?>  data-caption="<?php echo ($image->description) ? 'Descripción: '.$image->description:''; echo ($image->autor) ? '<br>Autor: '.$image:''; echo ($image->dateoriginal) ? '<br>Fecha: '.$image->dateoriginal:''; if($image->city || $image->pais || $image->lugar) echo '<br>'; echo ($image->city) ? '  Ciudad: '.$image->city:''; echo ($image->pais) ? '  País: '.$image->pais:''; echo ($image->lugar) ? ' Lugar: '.$image->lugar:''; echo (str_replace(" ", "", k::quitaracentos($image->tags))) ? '$'.str_replace(" ", "", k::quitaracentos($image->tags)):''; ?>" <?php } ?>>
                  <p>Ver</p>
                </a>
                <?php if($user->hasRole('administrator') || $user->hasRole('superuser') || $user->hasRole('admindoctos') || $user->hasRole('adminfotografo') || $user->hasRole('fotografo') || $user->hasRole('admindisenador') || $user->hasRole('disenador') || $user->hasRole('coeditor') || $user->hasRole('adminvideos') || $user->hasRole('editor')){ ?> 
                  <a onclick="dFoto('<?php echo $id; ?>'); return false;" id="download-album" href="">
                    <input type="hidden" id="chk-<?php echo $id ?>" name="checksum" value="<?php echo k::encrypt($image.'<>'.$image->filename.':'.time()); ?>">
                    <p>Descargar</p>
                  </a>
                <?php } ?>
                <?php if($user->hasRole('administrator') || $user->hasRole('superuser') || $user->hasRole('adminfotografo') || $page->createdUser == $user){ ?> 
                  <a href="<?php echo $config->urls->admin ?>page/edit/?id=<?php echo $pageid; ?>">
                    <p>Modificar</p>
                  </a>
                <?php } ?>
             </div>
           </div>
           <?php if($user->hasRole('administrator') || $user->hasRole('superuser') || $user->hasRole('adminfotografo') || $user->hasRole('editor')){ ?> 
           <div class="title-album">
             <?php $name=explode(".", $image->basename); if($image->fav==1) $type='quit'; ?>
           <a id="a-<?=$id;?>" href="" onclick="addFav('<?php echo $id; ?>','<?php echo $pageid; ?>','<?php echo $type; ?>','<?php echo $image; ?>'); return false;">
               <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                 viewBox="0 0 53.867 53.867" style="enable-background:new 0 0 53.867 53.867;" xml:space="preserve">
               <polygon id="p-<?=$id;?>" <?php if($image->fav==1) { ?> style="fill: #ffcd04;" <?php } ?> points="26.934,1.318 35.256,18.182 53.867,20.887 40.4,34.013 43.579,52.549 26.934,43.798
                10.288,52.549 13.467,34.013 0,20.887 18.611,18.182 "/>
               </svg>
               </a>
             <a data-fancybox data-src="<?php echo $config->urls->root;?>foto?page=<?php echo $pageid.'&image='.$name[0].'&ext='.$name[1]; ?>" href="javascript:;">
             <h3><?php echo $name[0]; ?></h3>
             </a>
           </div>
           <?php } else { ?>
             <?php $name=explode(".", $image->basename); ?>
             <a data-fancybox data-src="<?php echo $config->urls->root;?>foto?page=<?php echo $pageid.'&image='.$name[0].'&ext='.$name[1]; ?>" href="javascript:;">
             <h3><?php echo $name[0]; ?></h3>
             </a>
           <?php } ?> 
         </div>
        <?php } ?> 
       </div>
     </div>
   </div>
<?php include('./_foot.php'); ?>
<script type="text/javascript">
function dFoto(idFoto){
    window.location="<?php echo $config->urls->root;?>"+"individual?checksum="+$("#chk-"+idFoto).val();;
  } 
function updateStar(idFoto,type,page){
    if(type=='quit'){
                  $('svg polygon[id=p-'+idFoto+']').css({ fill: "" });
                  $("#a-"+idFoto).attr("onclick","addFav('"+idFoto+"','"+page+"',''); return false;");
                  $("#dv-"+idFoto).hide();
                }
                else{
                 $('svg polygon[id=p-'+idFoto+']').css({ fill: "#ffcd04" });
                  $("#a-"+idFoto).attr("onclick","addFav('"+idFoto+"','"+page+"','quit'); return false;");
                }
  }
  function addFav(idFoto,page,type,image){
    if(type=='quit'){
      text='¿Quieres quitar la foto de sugeridas?';
      text1='Esta foto se ha quitado de sugeridas';
    }else{
      text='¿Quieres agregar la foto a sugeridas?';
      text1='Esta foto se ha agregado a sugeridas';
    }
     swal({   
    title: ""+text,   
    text: "",   
    type: "info",   
    showCancelButton: true,   
    confirmButtonColor: "#19b359",
    cancelButtonColor: "#000c37",   
    confirmButtonText: "Si",   
    cancelButtonText: "No" }, 
    function(isConfirm){   
      if(isConfirm){
        $.ajax({
          url: "/addFav",
          type: "post",
          data: {page:page,idFoto:image,sug:"true"},
          dataType: "html",
        }).done(function(msg){
            updateStar(idFoto,type,page);
            swal({
              title: 'Listo',
              text: text1,
              type: 'success',
              timer: 1300,
              showConfirmButton: false
              })
        }).fail(function (jqXHR, textStatus) {
            console.log(textStatus);
        });
      }
    });
  } 
$('[data-fancybox]').fancybox({
  image : {
    protect: true
  },
<?php if($user->hasRole('administrator') || $user->hasRole('superuser') || $user->hasRole('admindoctos') || $user->hasRole('adminfotografo') || $user->hasRole('fotografo') || $user->hasRole('admindisenador') || $user->hasRole('disenador') || $user->hasRole('coeditor') || $user->hasRole('adminvideos') || $user->hasRole('editor')){  ?>  
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