<?php  if($user->hasRole('coeditor') || $user->hasRole('adminvideos') || $user->hasRole('editor'))
          $session->redirect("/");
  include('./_head.php');
    $find_category=$input->urlSegment1;
    $field = $fields->get('category');
    $all_options = $field->type->getOptions($field);
    $option_url = $all_options->get("value=".$find_category);
    $pagination=50;
    $cur = $input->pageNum;
    if(!empty($find_category))
      $max = intval(($pages->find("template=docu, category=".$option_url)->getTotal()) / $pagination);
    else
      $max = intval(($pages->find("template=docu")->getTotal()) / $pagination);
    $next = $cur<$max ? $cur + 1 : false;
    $prev = $cur>1 ? $cur - 1 : false;
    $ini = $cur==1 ? 0 : ($cur-1)*$pagination;
    if($cur-1>$max) $session->redirect("/");
    ?>
  <div class="j-workspace">
     <?php include('./_nav-nosub.php'); ?>
   </div>
   <div class="j-workspace albums-grid">
     <div class="j-wrap">
      <h2><?=($find_category) ? $option_url->title:'Documentos recientes'; ?></h2>
       <div class="grid">
        <?php if(!empty($find_category))
                  $albumes=$pages->find("template=docu, sort=-published, category=".$option_url.", start=".$ini.", limit=".$pagination);
              else
                  $albumes=$pages->find("template=docu, sort=-published, start=".$ini.", limit=".$pagination);
               foreach ($albumes as $key=>$album) { 
                $doc=$album->documento->first();?>
          <div class="unit one-quarter album-unit">
           <div id="video-<?php echo $album->id; ?>" class="image-album" style="background-image:url('<?php echo $config->urls->templates; ?>assets/images/<?=$doc->ext?>.png');">
             <div class="image-album-overlay">
                <?php if($doc->ext=='pdf'){ ?> 
                  <a data-fancybox="gallery<?php echo $album->id.$key ?>" data-type="iframe" data-src="<?= 'https://docs.google.com/a/plataformadigital.heraldodemexico/viewer?url=https://plataformadigital.heraldodemexico.com.mx'.$doc->url.'&embedded=true'; ?>" href="javascript:;">
                     <p>Ver</p>
                  </a>
                <?php } ?>
                <?php if($user->hasRole('administrator') || $user->hasRole('superuser') || $user->hasRole('admindoctos') || $user->hasRole('fotografo') || $user->hasRole('admininfografista') || $user->hasRole('infografista') || $user->hasRole('admindisenador') || $user->hasRole('disenador')){ ?> 
                  <a onclick="dFoto('<?php echo $album->id; ?>'); return false;" id="download-album" href="">
                    <input type="hidden" id="chk-<?php echo $album->id ?>" name="checksum" value="<?php echo k::encrypt($album.'<>'.$doc->filename.':'.time()); ?>">
                    <p>Descargar</p>
                  </a>
                <?php } ?>
                <?php if($user->hasRole('administrator') || $user->hasRole('superuser') || $user->hasRole('admindoctos') || $page->createdUser == $user){ ?> 
                  <a href="<?php echo $config->urls->admin ?>page/edit/?id=<?php echo $album->id; ?>">
                    <p>Modificar</p>
                  </a>
                <?php } ?>
             </div>
           </div>
           <h3><?php echo $album->title; ?></h3>
           <p><?php echo strftime("%d %B %G", $album->created); ?></p>
           <?php $inc=0; 
            foreach ($album->documento as $doc) { 
              $inc++; 
              if($inc==1) continue;             
               ?>
                <?php if($doc->ext=='pdf'){ ?> 
                  <a data-fancybox="gallery<?php echo $album->id.$key ?>" data-type="iframe" data-src="<?= 'https://docs.google.com/a/plataformadigital.heraldodemexico/viewer?url=https://plataformadigital.heraldodemexico.com.mx'.$doc->url.'&embedded=true'; ?>" href="javascript:;">
                  </a>
                <?php } ?>
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
</script>