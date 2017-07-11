<?php
class Greyscaled extends DataExtension {
  public function GreyscaleImage($R = '76', $G = '147', $B = '29') {
    return $this->owner->getFormattedImage('GreyscaleImage', $R, $G, $B);
  }
  public function generateGreyscaleImage(Image_Backend $gd, $R, $G, $B) {
    return $gd->greyscale($R, $G, $B);
  }
}