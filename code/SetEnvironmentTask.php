<?php
/**
 * Created by PhpStorm.
 * User: qunabu
 * Date: 06.07.17
 * Time: 11:04
 */

class SetEnvironmentTask extends BuildTask {
  public function run($request) {

    $file_config = BASE_PATH.DIRECTORY_SEPARATOR.'mysite/_config.php';
    $livefile_config = BASE_PATH.DIRECTORY_SEPARATOR.'mysite/live_config.php';
    $env_file = BASE_PATH.DIRECTORY_SEPARATOR.'/_ss_environment.php';

    if (is_file($env_file)) {
      die('is_file($env_file)');
    }

    global $databaseConfig;

    $helpfiles = BASE_PATH.DIRECTORY_SEPARATOR.SS_QUNABU_DIR.DIRECTORY_SEPARATOR.'help-files'.DIRECTORY_SEPARATOR;

    $fcontent = file_get_contents($helpfiles.'_ss_environment.php');

    $fcontent = str_replace('||SS_DATABASE_SERVER||', $databaseConfig['server'], $fcontent);
    $fcontent = str_replace('||SS_DATABASE_USERNAME||', $databaseConfig['username'], $fcontent);
    $fcontent = str_replace('||SS_DATABASE_NAME||', $databaseConfig['database'], $fcontent);
    $fcontent = str_replace('||SS_DATABASE_PASSWORD||', $databaseConfig['password'], $fcontent);

    file_put_contents($env_file, $fcontent);
    file_put_contents($file_config, file_get_contents($helpfiles.'_config.php'));
    file_put_contents($livefile_config, file_get_contents($helpfiles.'_config.php'));

    echo 'SetEnvironmentTask done';

  }
} 