<?php include('./_head.php');
    $field = $fields->get('category');
    $all_options = $field->type->getOptions($field); ?>
  <div class="j-workspace">
     <div class="j-wrap sub-categories-container">
       <ul class="sub-categories">
       <a href="#">
           <li>Recientes</li>
         </a>
       <?php foreach ($all_options as $option) { ?>
        <a href="#">
           <li><?php echo $option->title; ?></li>
         </a>
        <?php } ?>
       </ul>
       <select name="categories" id="">
         <option value="Seleccionar">Categorias</option>
         <option value="recientes">Recientes</option>
         <?php foreach ($all_options as $option) { ?>
         <option value="<?php echo $option->title; ?>"><?php echo $option->title; ?></option>
         <?php } ?>
       </select>
     </div>
   </div>
   <div class="j-workspace albums-grid">
     <div class="j-wrap">
      <h2>Álbumes recientes</h2>
       <div class="grid">
         <!--  Album numero uno-->
         <div class="unit one-quarter album-unit">
           <div class="image-album">
             <div class="image-album-overlay">
                <a href="#">
                  <p>Ver</p>
                </a>
                <a href="#">
                  <p>Descargar</p>
                </a>
                <a href="#">
                  <p>Modificar</p>
                </a>
             </div>
           </div>
           <h3>Titulo del album</h3>
           <p>2 de marzo del 2017</p>
         </div>
         <!--  Album numero uno-->
         <div class="unit one-quarter album-unit">
           <div class="image-album">
             <div class="image-album-overlay">
                <a href="#">
                  <p>Ver</p>
                </a>
                <a href="#">
                  <p>Descargar</p>
                </a>
                <a href="#">
                  <p>Modificar</p>
                </a>
             </div>
           </div>
           <h3>Titulo del album</h3>
           <p>2 de marzo del 2017</p>
         </div>
         <!--  Album numero uno-->
         <div class="unit one-quarter album-unit">
           <div class="image-album">
             <div class="image-album-overlay">
                <a href="#">
                  <p>Ver</p>
                </a>
                <a href="#">
                  <p>Descargar</p>
                </a>
                <a href="#">
                  <p>Modificar</p>
                </a>
             </div>
           </div>
           <h3>Titulo del album</h3>
           <p>2 de marzo del 2017</p>
         </div>
         <!--  Album numero uno-->
         <div class="unit one-quarter album-unit">
           <div class="image-album">
             <div class="image-album-overlay">
                <a href="#">
                  <p>Ver</p>
                </a>
                <a href="#">
                  <p>Descargar</p>
                </a>
                <a href="#">
                  <p>Modificar</p>
                </a>
             </div>
           </div>
           <h3>Titulo del album</h3>
           <p>2 de marzo del 2017</p>
         </div>
         <!--  Album numero uno-->
         <div class="unit one-quarter album-unit">
           <div class="image-album">
             <div class="image-album-overlay">
                <a href="#">
                  <p>Ver</p>
                </a>
                <a href="#">
                  <p>Descargar</p>
                </a>
                <a href="#">
                  <p>Modificar</p>
                </a>
             </div>
           </div>
           <h3>Titulo del album</h3>
           <p>2 de marzo del 2017</p>
         </div>
         <!--  Album numero uno-->
         <div class="unit one-quarter album-unit">
           <div class="image-album">
             <div class="image-album-overlay">
                <a href="#">
                  <p>Ver</p>
                </a>
                <a href="#">
                  <p>Descargar</p>
                </a>
                <a href="#">
                  <p>Modificar</p>
                </a>
             </div>
           </div>
           <h3>Titulo del album</h3>
           <p>2 de marzo del 2017</p>
         </div>
       </div>
     </div>
   </div>

<?php include('./_foot.php'); ?>
