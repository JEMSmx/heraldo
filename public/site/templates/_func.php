<?php

/**
 * Shared functions used by the beginner profile
 *
 * This file is included by the _init.php file, and is here just as an example.
 * You could place these functions in the _init.php file if you prefer, but keeping
 * them in this separate file is a better practice.
 *
 */

class k {

  public static function page_name() {
    return (wire('input')->urlSegment1) ? wire('input')->urlSegment1 : wire('page')->name;
  }

  public static function embedded_svg() {
    return "";
  }

  public static function quitaracentos($String){
    $String = str_replace(array('á','à','â','ã','ª','ä'),"a",$String);
    $String = str_replace(array('Á','À','Â','Ã','Ä'),"A",$String);
    $String = str_replace(array('Í','Ì','Î','Ï'),"I",$String);
    $String = str_replace(array('í','ì','î','ï'),"i",$String);
    $String = str_replace(array('é','è','ê','ë'),"e",$String);
    $String = str_replace(array('É','È','Ê','Ë'),"E",$String);
    $String = str_replace(array('ó','ò','ô','õ','ö','º'),"o",$String);
    $String = str_replace(array('Ó','Ò','Ô','Õ','Ö'),"O",$String);
    $String = str_replace(array('ú','ù','û','ü'),"u",$String);
    $String = str_replace(array('Ú','Ù','Û','Ü'),"U",$String);
    $String = str_replace(array('[','^','´','`','¨','~',']'),"",$String);
    $String = str_replace("ç","c",$String);
    $String = str_replace("Ç","C",$String);
    $String = str_replace("Ý","Y",$String);
    $String = str_replace("ý","y",$String);
    $String = str_replace("&aacute;","a",$String);
    $String = str_replace("&Aacute;","A",$String);
    $String = str_replace("&eacute;","e",$String);
    $String = str_replace("&Eacute;","E",$String);
    $String = str_replace("&iacute;","i",$String);
    $String = str_replace("&Iacute;","I",$String);
    $String = str_replace("&oacute;","o",$String);
    $String = str_replace("&Oacute;","O",$String);
    $String = str_replace("&uacute;","u",$String);
    $String = str_replace("&Uacute;","U",$String);
    return $String;
  }

  public static function encrypt($q) {
    $cryptKey  = 'z6!Qg2y<\2;bZ,HEN}y[t!$6}!64E';
    $qEncoded      = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
    return( $qEncoded );
  }

  public static function decrypt($q) {
      $cryptKey  = 'z6!Qg2y<\2;bZ,HEN}y[t!$6}!64E';
      $qDecoded      = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
      return( $qDecoded );
  }

  public static function add_attributes($idpage){
    $page=wire('pages')->get($idpage);
    $page->setOutputFormatting(false);
    foreach ($page->images as $image) {
          $datos = exif_read_data($image->httpUrl);
          $image_path=$image->httpUrl;
          $size = getimagesize ($image_path, $info);
          $iptc = isset($info['APP13']) ? iptcparse($info["APP13"]):null;
        $image->description = $data['ImageDescription'];
        if(!empty($iptc) && isset($iptc['2#025']))
          $image->tags=implode(",", $iptc['2#025']);  
        $image->copyright = isset($data['Copyright']) ? $data['Copyright']:'';
        $image->make = isset($data['Model']) ? $data['Model']:'';
        $fecha= isset($data['DateTimeOriginal']) ? $data['DateTimeOriginal']:null;
        if($fecha==NULL){
          $fecha=date('Y:m:d');
        }
        $fecha=str_replace(' ',':',$fecha);
        $separarfecha=explode(":", $fecha);
        $dia=$separarfecha[2];
        $num=$separarfecha[1]-1;
        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $anio=$separarfecha[0]; 
        $image->dateoriginal = $dia.' '.$meses[$num].' '.$anio;
        $image->autor = isset($iptc['2#110'][0]) ? $iptc['2#110'][0]:'';
        $image->city = isset($iptc['2#090'][0]) ? $iptc['2#090'][0]:'';
        $image->lugar = isset($iptc['2#092'][0]) ? $iptc['2#092'][0]:'';
        $image->pais = isset($iptc['2#101'][0]) ? $iptc['2#101'][0]:'';
      }
    $page->metadata=1;
    $page->save();
    $page->setOutputFormatting(true);
  }

  /**
   * Given a group of pages render a tree of navigation
   *
   * @param Page|PageArray $items Page to start the navigation tree from or pages to render
   * @param int $maxDepth How many levels of navigation below current should it go?
   *
   */
  public static function render_nav_tree($items, $maxDepth = 0) {
    if ($items instanceof Page) $items = array($items);
    if (!count($items)) return;

    echo "\n<ul>";

    foreach ($items as $item) {
      $is_current = ($item->id == wire("page")->id) ? "current" : "";
      echo "\n<li class='$is_current'>";

      echo "<a href='$item->url'>$item->title</a>";

      if ($item->hasChildren() && $maxDepth) {
        self::render_nav_tree($item->children, $maxDepth-1);
      }

      echo "</li>";
    }

    echo "\n</ul>";
  }

}
