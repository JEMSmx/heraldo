<div class="j-wrap sub-categories-container">
 <ul class="sub-categories">
   <a href="/">
     <li <?= ($page->path == "/") ? 'class="active"':''; ?>>Fotos</li>
   </a>
   <?php $home = $pages->get("/"); 
   $children = $home->children;
   foreach($children as $child) { 
        if($child->title=='Eventos') continue; 
        if($child->title=='Infografía'){
           if($user->hasRole('adminvideos') || $user->hasRole('editor'))
              continue;
        }
        if($child->title=='Documentos fuente'){
           if($user->hasRole('adminvideos') || $user->hasRole('editor') || $user->hasRole('coeditor'))
              continue;
        }  ?>
   <a href="<?= $child->url; ?>" title="<?= $child->title; ?>">
     <li <?= ($child->url==$page->url) ? 'class="active"':''; ?> ><?= $child->title; ?></li>
   </a>
   <?php } ?>
   <a href="/sugeridas">
     <li <?= ($page->path == "/sugeridas/") ? 'class="active"':''; ?> >Sugeridas</li>
   </a>
 </ul>
 <ul class="sub-sub-categories">
   <a href="<?= $page->url; ?>">
     <li <?= ($find_category) ? '':'class="active"'; ?>>Categorías</li>
   </a>
   <?php foreach ($all_options as $option) { ?>
   <a href="<?= ($page->path == '/') ? '/categoria/'.$option->value:$page->url.$option->value; ?>">
     <li <?= ($option->value==$find_category) ? 'class="active"':''; ?>><?php echo $option->title; ?></li>
   </a>
   <?php } ?>
 </ul>
 <select name="principalc" id="principalc">
   <option value="" <?php if($page->path == "/") echo 'selected';?>>Fotos</option>
   <?php foreach($children as $child) {
        if($child->title=='Eventos') continue; 
        if($child->title=='Infografía'){
           if($user->hasRole('adminvideos') || $user->hasRole('editor'))
              continue;
        }
        if($child->title=='Documentos fuente'){
           if($user->hasRole('adminvideos') || $user->hasRole('editor') || $user->hasRole('coeditor'))
              continue;
        } ?>
   <option value="<?= str_replace('/', '', $child->url); ?>" <?php if($child->url==$page->url) echo 'selected';?>><?= $child->title; ?></option>
   <?php } ?>
   <option value="sugeridas" <?php if($page->path == "/sugeridas/") echo 'selected';?>>Sugeridas</option>
 </select>
 <select name="subcategories" id="subcategories">
   <option value="Seleccionar">Categorías</option>
   <?php foreach ($all_options as $option) { ?>
   <option value="<?php echo $option->value; ?>" <?php if($input->urlSegment2==$option->value) echo 'selected';?>><?php echo $option->title; ?></option>
   <?php } ?>
 </select>
</div>