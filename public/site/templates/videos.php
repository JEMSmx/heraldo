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
                $video=$album->videos->first();
                     ?>           
         <div class="unit one-quarter album-unit">
           <div class="video-album" style="background-image:url('<?php echo $video->poster; ?>');">
             <div class="video-album-overlay">
                <a href="<?php echo $config->urls->root.'player?video='.$video->url ?>" data-fancybox>
                  <p>Ver</p>
                </a>
                <a href="#">
                  <p>Descargar</p>
                </a>
             </div>
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
$('#categories').change(function() {
  if($(this).val()=='recientes')
    window.location = "<?php echo $config->urls->root; ?>";
  else
    window.location = "<?php echo $config->urls->root; ?>categoria/"+$(this).val();
});
</script>