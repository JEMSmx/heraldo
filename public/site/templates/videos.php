<?php include('./_head.php');
    $find_category=$input->urlSegment2;
    $field = $fields->get('category');
    $all_options = $field->type->getOptions($field);
    $option_url = $all_options->get("value=".$find_category);
    $pagination=20;
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
      <h2>Videos</h2>
       <div class="grid">
        <div class="contenedor">
        <?php if(!empty($find_category))
                  $albumes=$pages->find("template=video, sort=-published, category=".$option_url.", start=".$ini.", limit=".$pagination);
              else
                  $albumes=$pages->find("template=video, sort=-published, start=".$ini.", limit=".$pagination);
               foreach ($albumes as $key=>$album) { 
                $video=$album->videos->first(); ?>   
               
         <div class="unit one-quarter album-unit">
           <div id="video-<?php echo $album->id; ?>" class="video-album" style="background-image: none;">
             <div class="video-album-overlay">
                <a href="<?php echo $config->urls->root.'player?video='.$album->id?>" data-fancybox>
                  <p>Ver</p>
                </a>
                <a href="#">
                  <p>Descargar</p>
                </a>
             </div>
             <video id="<?php echo $album->id; ?>" style="display: none">
             <source src="<?php echo $video->url; ?>" />
             </video> 
           </div>

           <h3><?php echo $album->title; ?></h3>
           <p><?php echo strftime("%d %B %G", $album->created); ?></p>
         </div>
         <?php } ?>
         </div>
       </div>
     </div>
   </div>
<?php include('./_foot.php'); ?>
<script type="text/javascript">
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
   }
$(document).ready(function(){
    setTimeout(function() {
    <?php foreach ($albumes as $key=>$album) { ?>
    getThumb('<?php echo $album->id; ?>');
  <?php } ?>  
    }, 250);
});
</script>