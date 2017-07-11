<?php
/**
 * Created by PhpStorm.
 * User: qunabu
 * Date: 06.07.17
 * Time: 10:35
 */

class PageHelperExtension extends DataExtension {
  public function isDev() {
    return Director::get_environment_type() == 'dev';
  }
  public function isLive() {
    return Director::get_environment_type() == 'live';
  }
  public function getJavaScriptLibFiles() {
    $files = glob( BASE_PATH.'/'.$this->owner->ThemeDir().'/javascript/lib/*.js' );
    usort($files, function($a, $b) {
      return strcmp($b, $a);
    });
    $result = new ArrayList();
    foreach($files as $file) {
      $result->push(array(
        'File'=>basename($file)
      ));
    }
    return $result;
  }
}