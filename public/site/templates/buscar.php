<?php
    $q=$input->post->palabra;
    $cq=strlen($q);
    if($cq<3) exit;
?>          
<div class="morphsearch-content">
    <div class="dummy-column">
    <h2>Imágenes</h2>
    <?php $pagesWithImages = $pages->find("template=evento, images.count>0, (images.description~=$q), (images.tags%=$q), (images.autor|images.Dateoriginal%=$q)");
        $allImages = array();
        foreach($pagesWithImages as $p) {
            if(count($allImages)>30) break;
            foreach($p->images as $image) $allImages[] = $image; 
        } 
        foreach ($allImages as $img) { 
            $img_ind = $img->width(100, array('quality' => 90, 'upscaling' => false, 'cropping' => true)); ?>
            <a class="dummy-media-object" href="#">
                <img src="<?php echo $img_ind->url; ?>"/>
                <h3><?php $name=explode(".", $img->basename); echo $name[0]; ?></h3>
            </a>
        <?php } ?>
</div>
<div class="dummy-column">
  <h2>Eventos</h2>
  <?php $albumes=$pages->find("template=evento, (title%=$q), (images.description|images.tags~=$q), (category.title%=$q), (images.autor|images.Dateoriginal%=$q), limit=20, sort=-published");
  foreach ($albumes as $album) { 
     $image_album = $album->images->first();
     if($image_album){
        $img_album = $image_album->width(100, array('quality' => 90, 'upscaling' => false, 'cropping' => true));
    } ?>
    <a class="dummy-media-object" href="#">
      <img src="<?php echo $img_album->url; ?>" alt="<?php echo $image_album->title; ?>"/>
      <h3><?php echo $album->title; ?></h3>
  </a>
  <?php } ?>
</div>
<div class="dummy-column">
  <h2>Etiquetas</h2>
    <?php 
          $alltags = array(); 
          $extratags = array(); 
          $use_urlsegments = false;
          $parray = $pages->find("template=evento, images.tags%=$q");
          foreach($parray as $p) {
            if(count($alltags)>30) break;
            $images = $p->images->find("tags%=$q");
            foreach($images as $im) {
                $tags = $im->tags;
                $tags = explode(',', $tags);
                foreach($tags as $tag) {
                    if(strpos($tag, $q) === false)
                        $extratags[$sanitizer->pageName($tag, Sanitizer::translate)] = $tag;
                    else
                        $alltags[$sanitizer->pageName($tag, Sanitizer::translate)] = $tag;
                }
            }
        } 
        foreach(array_slice(array_unique($alltags), 0, 20) as $key => $tag) { ?>
        <a class="dummy-media-object" href="<?php echo $config->urls->root; ?>etiquetas/<?php echo (strpos($tag, " ") === false) ? $tag:str_replace(" ", "-", $tag); ?>">
          <img src="<?php echo $config->urls->templates; ?>static/455375-147357/images/tag.png" alt="<?php echo $tag ?>"/>
          <h3><?php echo $tag; ?></h3>
        </a>
        <?php } 

        if(count($alltags<=20)){
            $extratags=array_unique($extratags);
            foreach(array_slice($extratags, 0, (20-count($alltags))) as $tag) { ?>
            <a class="dummy-media-object" href="<?php echo $config->urls->root; ?>etiquetas<?php echo (strpos($tag, " ") === false) ? $tag:str_replace(" ", "-", $tag); ?>">
              <img src="<?php echo $config->urls->templates; ?>static/455375-147357/images/tag.png" alt="<?php echo $tag ?>"/>
              <h3><?php echo $tag ?></h3>
          </a>
   <?php    } 
        } ?>
</div>
</div>