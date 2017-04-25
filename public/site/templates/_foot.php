  <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.0.47/jquery.fancybox.min.js"></script>
  <script src="<?php echo $config->urls->templates; ?>static/455375-147357/scripts/main.min.js"></script>
  <script>
  $(document).ready(function(){
  $(".morphsearch-input").keyup(function() {
    var texto = $(this).val();
    var dataString = 'palabra='+ texto;
      $.ajax({
      type: "POST",
      url: "<?php echo $config->urls->root.'buscar'; ?>",
      data: dataString,
      cache: false,
        success: function(data){
          if(data){
            $("#display").html(data).show();
          }
        }
      });
    return false;    
  });
});
    (function() {
        var morphSearch = document.getElementById( 'morphsearch' ),
          input = morphSearch.querySelector( 'input.morphsearch-input' ),
          ctrlClose = morphSearch.querySelector( 'span.morphsearch-close' ),
          isOpen = isAnimating = false,
          // show/hide search area
          toggleSearch = function(evt) {
            // return if open and the input gets focused
            if( evt.type.toLowerCase() === 'focus' && isOpen ) return false;

            var offsets = morphsearch.getBoundingClientRect();
            if( isOpen ) {
              classie.remove( morphSearch, 'open' );

              // trick to hide input text once the search overlay closes 
              // todo: hardcoded times, should be done after transition ends
              if( input.value !== '' ) {
                setTimeout(function() {
                  classie.add( morphSearch, 'hideInput' );
                  setTimeout(function() {
                    classie.remove( morphSearch, 'hideInput' );
                    input.value = '';
                  }, 300 );
                }, 500);
              }
              
              input.blur();
            }
            else {
              classie.add( morphSearch, 'open' );
            }
            isOpen = !isOpen;
          };

        // events
        input.addEventListener( 'focus', toggleSearch );
        ctrlClose.addEventListener( 'click', toggleSearch );
        // esc key closes search overlay
        // keyboard navigation events
        document.addEventListener( 'keydown', function( ev ) {
          var keyCode = ev.keyCode || ev.which;
          if( keyCode === 27 && isOpen ) {
            toggleSearch(ev);
          }
        } );
        /***** for demo purposes only: don't allow to submit the form *****/
        morphSearch.querySelector( 'button[type="submit"]' ).addEventListener( 'click', function(ev) { ev.preventDefault(); } );
      })();
    $('#categories').change(function() {
      if($(this).val()=='recientes')
        window.location = "<?php echo $config->urls->root; ?>";
      else if($(this).val()=='videos')
        window.location = "<?php echo $config->urls->root; ?>videos";
      else
        window.location = "<?php echo $config->urls->root; ?>categoria/"+$(this).val();
    });
  </script>
</body>
</html>