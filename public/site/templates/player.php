<!DOCTYPE html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Reproductor</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/normalize/4.2.0/normalize.min.css" integrity="sha256-K3Njjl2oe0gjRteXwX01fQD5fkk9JFFBdUHy/h38ggY=" crossorigin="anonymous" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mediaelement/4.0.6/mediaelementplayer.min.css">
  <link rel="apple-touch-icon" href="https://dummyimage.com/50x50/000/fff">
  <link rel="shortcut icon" href="https://dummyimage.com/50x50/000/fff">
</head>
<?php $page=$pages->get($input->get->video);
      $video=$page->videos->first(); ?>
<video id="playerId" src='<?php echo $video->url ?>' width='100%' height='100%' controls autoplay></video> 
 <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/mediaelement/4.0.6/mediaelementplayer.min.js"></script>
<script type="text/javascript">
    var player = new MediaElementPlayer('playerId', {
      features: ['playpause','progress'],
    });
</script>