<?php

class ImageHelperExtension extends DataExtension {
  private static $db = array(
    'DominantColor'=>'Varchar(7)'
  );
  public function getDColor() {
    //return '#000000';
    if (!isset($this->owner->DominantColor) || empty($this->owner->DominantColor)) {
      return $this->calculateDominantColor();
    }
    return isset($this->owner->DominantColor) && !empty($this->owner->DominantColor) ? $this->owner->DominantColor : '#002200';
  }
  protected function calculateDominantColor() {
    $file = $this->owner;
    $filepath = $file->getFullPath();

    if (is_file($filepath)) {
      $color = ColorThief\ColorThief::getColor($filepath);
      $hex = sprintf("#%02x%02x%02x", $color[0], $color[1], $color[2]);
      //die($hex);
      $this->owner->DominantColor = $hex;
    } else {
      $this->owner->DominantColor = '#000000';
    }
    $this->owner->write();
    return $this->owner->DominantColor;
  }
  /*
  public function onBeforeWrite() {
    $this->owner->DominantColor='';
  }
  */
}
