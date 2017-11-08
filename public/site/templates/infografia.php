<?php  if($user->hasRole('adminvideos') || $user->hasRole('editor'))
          $session->redirect("/");
    include('./_head.php');
    $find_category=$input->urlSegment1;
    $field = $fields->get('category');
    $all_options = $field->type->getOptions($field);
    $option_url = $all_options->get("value=".$find_category);
    $pagination=50;
    $cur = $input->pageNum;
    if(!empty($find_category))
      $max = intval(($pages->find("template=infogra, category=".$option_url)->getTotal()) / $pagination);
    else
      $max = intval(($pages->find("template=infogra")->getTotal()) / $pagination);
    $next = $cur<$max ? $cur + 1 : false;
    $prev = $cur>1 ? $cur - 1 : false;
    $ini = $cur==1 ? 0 : ($cur-1)*$pagination;
    if($cur-1>$max) $session->redirect("/");
    ?>
  <div class="j-workspace">
     <?php include('./_nav.php'); ?>
   </div>
   <div class="j-workspace albums-grid">
     <div class="j-wrap">
      <h2><?=($find_category) ? $option_url->title:'Infografia reciente'; ?></h2>
       <div class="grid">
        <?php if(!empty($find_category))
                  $albumes=$pages->find("template=infogra, sort=-published, category=".$option_url.", start=".$ini.", limit=".$pagination);
              else
                  $albumes=$pages->find("template=infogra, sort=-published, start=".$ini.", limit=".$pagination);
               foreach ($albumes as $key=>$album) { 
                $thumb=$album->image;
                if($thumb)
                  $thumb_video=$thumb->width(240, array('quality' => 90, 'upscaling' => true, 'cropping' => false)); 
                  $img_2x = $thumb->width(1200, array('quality' => 90, 'upscaling' => true, 'cropping' => false)); ?> 
          <div class="unit one-quarter album-unit">
           <div id="video-<?php echo $album->id; ?>" class="image-album" <?php if($thumb){ ?> style="background-image:url('<?php echo $thumb_video->url; ?>');" <?php }else{ ?> style="background-image: none;" <?php } ?>>
             <div class="image-album-overlay">
                <a href="<?= $img_2x->url; ?>" data-caption="<?= $album->desc; ?>" data-fancybox>
                  <p>Ver</p>
                </a>
                <?php if($user->hasRole('administrator') || $user->hasRole('superuser') || $user->hasRole('admindoctos') || $user->hasRole('admininfografista') || $user->hasRole('infografista') || $user->hasRole('admindisenador') || $user->hasRole('disenador') || $user->hasRole('coeditor')){ ?> 
                  <a onclick="dFoto('<?php echo $album->id; ?>'); return false;" id="download-album" href="">
                    <input type="hidden" id="chk-<?php echo $album->id ?>" name="checksum" value="<?php echo k::encrypt($album.'<>'.$thumb->filename.':'.time()); ?>">
                    <p>Descargar</p>
                  </a>
                <?php } ?>
                <?php if($user->hasRole('administrator') || $user->hasRole('superuser') || $user->hasRole('admininfografista') || $page->createdUser == $user){ ?> 
                  <a href="<?php echo $config->urls->admin ?>page/edit/?id=<?php echo $album->id; ?>">
                    <p>Modificar</p>
                  </a>
                <?php } ?>
             </div>
           </div>
           <h3><?php echo $album->title; ?></h3>
           <p><?php echo strftime("%d %B %G", $album->created); ?></p>
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
</script>