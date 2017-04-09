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
