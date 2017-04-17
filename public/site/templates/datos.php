<?php 
$find_category=$input->get->category;
$field = $fields->get('category');
$all_options = $field->type->getOptions($field);
$option_url = $all_options->get("value=".$find_category);
$pagination=20;
$cur = $input->get->pagina;
if(!empty($find_category))
  $max = intval(($pages->find("template=album, category=".$option_url)->getTotal()) / $pagination);
else
  $max = intval(($pages->find("template=album")->getTotal()) / $pagination);
$next = $cur<$max ? $cur + 1 : false;
$prev = $cur>1 ? $cur - 1 : false;
$ini = $cur==1 ? 0 : ($cur-1)*$pagination;
if($cur-1>$max) exit;

if(!empty($find_category))
  $albumes=$pages->find("template=album, sort=-published, category=".$option_url.", start=".$ini.", limit=".$pagination);
else
  $albumes=$pages->find("template=album, sort=-published, start=".$ini.", limit=".$pagination);
foreach ($albumes as $key=>$album) { 
  $image_album = $album->images->first();
  if($image_album){
    $img_album = $image_album->size(480, 480, array('quality' => 90, 'upscaling' => true, 'cropping' => false));
    $img_album_2x = $image_album->size(1200, 1200, array('quality' => 90, 'upscaling' => true, 'cropping' => false));
  }
  ?>           
  <div class="unit one-quarter album-unit">
   <div class="image-album" <?php if($image_album) {?>style="background-image:url('<?php echo $img_album->url; ?>'); <?php } ?>">
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
  <h3><?php echo $album->title; ?></h3>
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
  $img = $image->size(1200, 1200, array('quality' => 90, 'upscaling' => true, 'cropping' => false));                  
  ?>
  <a data-fancybox="gallery<?php echo $cur.$key ?>" href="<?php echo $img->url; ?>"></a>
  <?php } ?>
  <?php } ?>