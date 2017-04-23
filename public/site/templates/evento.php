<?php include('./_head.php'); 
    $field = $fields->get('category');
    $all_options = $field->type->getOptions($field);?>
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
      <h2><?php echo $page->category->title; ?> / Evento: <?php echo $page->title; ?></h2>
       <div class="grid">
        <?php $id=0; foreach ($page->images as $image) { 
                $id++;
                $img_2x = $image->width(1200, array('quality' => 90, 'upscaling' => true, 'cropping' => false)); ?> 
         <div class="unit one-quarter album-unit">
           <div class="image-album" <?php if($img) {?>style="background-image:url('<?php echo $img_2x->url; ?>'); <?php } ?>">
             <div class="image-album-overlay">
                <a href="<?php echo $img_2x->url; ?>" data-fancybox>
                  <p>Ver</p>
                </a>
                <?php if($user->hasRole('administrator') || $user->hasRole('superuser') || $user->hasRole('manager')){ ?> 
                  <a onclick="dFoto('<?php echo $id; ?>'); return false;" id="download-album" href="">
                    <input type="hidden" id="chk-<?php echo $id ?>" name="checksum" value="<?php echo k::encrypt($image.'<>'.$image->filename.':'.time()); ?>">
                    <p>Descargar</p>
                  </a>
                <?php } ?>
                <?php if($user->hasRole('administrator') || $user->hasRole('superuser') || $page->createdUser == $user){ ?> 
                  <a href="<?php echo $config->urls->admin ?>page/edit/?id=<?php echo $page->id; ?>">
                    <p>Modificar</p>
                  </a>
                <?php } ?>
             </div>
           </div>
           <a data-fancybox data-src="<?php echo $config->urls->root;?>foto?page=<?php echo $page->id.'&image='.$id;?>" href="javascript:;">
           <h3><?php $name=explode(".", $image->basename); echo $name[0]; ?></h3>
           </a>
         </div>
        <?php } ?> 
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
  function dFoto(idFoto){
    window.location="<?php echo $config->urls->root;?>"+"individual?checksum="+$("#chk-"+idFoto).val();;
  } 
$('[data-fancybox]').fancybox({
  image : {
    protect: true
  }
});
</script>