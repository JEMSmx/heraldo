<?php include('./_head.php');
    $find_category=$input->urlSegment1;
    $field = $fields->get('category');
    $all_options = $field->type->getOptions($field);
    $option_url = $all_options->get("value=".$find_category);
    $pagination=50;
    $cur = $input->pageNum;
    if(!empty($find_category))
      $max = intval(($pages->find("template=video, category=".$option_url)->getTotal()) / $pagination);
    else
      $max = intval(($pages->find("template=video")->getTotal()) / $pagination);
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
      <h2><?=($find_category) ? $option_url->title:'Videos recientes'; ?></h2>
       <div class="grid">
        <?php if(!empty($find_category))
                  $albumes=$pages->find("template=video, sort=-published, category=".$option_url.", start=".$ini.", limit=".$pagination);
              else
                  $albumes=$pages->find("template=video, sort=-published, start=".$ini.", limit=".$pagination);
               foreach ($albumes as $key=>$album) { 
                $video=$album->videos->first();
                $thumb=$album->images->first();
                if($thumb)
                  $thumb_video=$thumb->width(240, array('quality' => 90, 'upscaling' => true, 'cropping' => false)); ?>
          <div class="unit one-quarter album-unit">
           <div id="video-<?php echo $album->id; ?>" class="image-album" <?php if($thumb){ ?> style="background-image:url('<?php echo $thumb_video->url; ?>');" <?php }else{ ?> style="background-image: none;" <?php } ?>>
             <div class="image-album-overlay">
                <a href="<?php echo $config->urls->root.'player?video='.$album->id?>" data-fancybox>
                  <p>Ver</p>
                </a>
                <?php if($user->hasRole('administrator') || $user->hasRole('superuser') || $user->hasRole('adminfotografo') || $user->hasRole('admindisenador') || $user->hasRole('disenador') || $user->hasRole('coeditor') || $user->hasRole('adminvideos') || $user->hasRole('editor') || $user->hasRole('admindoctos')){ ?> 
                  <a onclick="dVideo('<?php echo $album->id; ?>'); return false;" id="download-video" href="">
                    <input type="hidden" id="chk-<?php echo $album->id ?>" name="checksum" value="<?php echo k::encrypt($video.'<>'.$video->filename.':'.time()); ?>">
                    <p>Descargar</p>
                  </a>
                <?php } ?>
                <?php if($user->hasRole('administrator') || $user->hasRole('superuser') || $user->hasRole('adminfotografo') || $user->hasRole('adminvideos') || $page->createdUser == $user){ ?> 
                  <a href="<?php echo $config->urls->admin ?>page/edit/?id=<?php echo $album->id; ?>">
                    <p>Modificar</p>
                  </a>
                <?php } ?>
             </div>

             <?php if(!$thumb){ ?>
              <video id="<?php echo $album->id; ?>" style="display: none">
             <source src="<?php echo $video->url; ?>" />
             </video> 
             <?php } ?>
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
function dVideo(idVideo){
    window.location="<?php echo $config->urls->root;?>"+"individual?checksum="+$("#chk-"+idVideo).val();;
  } 
function getThumb(IdVideo){
      var canvas = document.createElement('canvas');
      var video = document.getElementById(IdVideo);
      var w, h, ratio;
      ratio = video.videoWidth / video.videoHeight;
      w = video.videoWidth - 100;
      h = parseInt(w / ratio, 10);
      canvas.width = w;
      canvas.height = h;  
      var context = canvas.getContext('2d');
      context.drawImage(video, 0, 0, w, h);
      var dataURI = canvas.toDataURL('image/jpeg');
      $('#video-'+IdVideo).css('background-image', 'url(' + dataURI + ')');
      $.post("/load-foto",
      {data: dataURI,video: IdVideo},
      function(data, status){
          //console.log(data);
      });
   }
$(document).ready(function(){
    setTimeout(function() {
    <?php foreach ($albumes as $key=>$album) {
      if($album->images->first()) continue; ?>
    getThumb('<?php echo $album->id; ?>');
  <?php } ?>  
    }, 1000);
});
</script>