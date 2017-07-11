<?php

/**
 * Created by PhpStorm.
 * User: qunabu
 * Date: 06.02.2017
 * Time: 15:28
 */
class DateExtension extends DataExtension {
  public function UTF8FormatI18N($formattingString) {
    return utf8_encode($this->owner->FormatI18N($formattingString));
  }
}