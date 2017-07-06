<?php

global $project;
$project = 'mysite';

global $database;
$database = '';

if (!defined('SS_MWM_DIR')) {
  define('SS_MWM_DIR', basename(rtrim(dirname(__FILE__), DIRECTORY_SEPARATOR)));
}

require_once('conf/ConfigureFromEnv.php');