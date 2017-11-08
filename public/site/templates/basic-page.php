<?php include("./_head.php"); ?>

  <!-- Section: More info -->
  <section class="k-section wrap wider">
    <div class="grid">
      <div class="unit half">
        <article class="k-article">
          <h2 class="k-heading"><?php echo $page->get("headline|title"); ?></h2>

          <p>
            <?php echo $page->summary; ?>
          </p>

          <?php echo $page->body; ?>
        </article>
      </div>

      
    </div>
  </section>


<?php include("./_foot.php"); ?>
