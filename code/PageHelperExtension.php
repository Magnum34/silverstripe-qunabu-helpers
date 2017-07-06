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
} 