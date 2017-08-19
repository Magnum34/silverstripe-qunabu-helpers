<?php
/**
 * Created by PhpStorm.
 * User: qunabu
 * Date: 11.08.17
 * Time: 18:09
 */

if (PHP_SAPI === 'cli') {

} else {
  die('nope');
}

if (is_file(__DIR__ . '/../vendor/autoload.php')) {
  include(__DIR__ . '/../vendor/autoload.php');
} else if (is_file(__DIR__ . '/vendor/autoload.php')) {
  include(__DIR__ . '/vendor/autoload.php');
}




  function console_log($msg) {
  echo $msg."\n";
}

function eoltrim($string) {
  return  trim(str_replace(array("\n","\r"), '', $string));
}

function generateRandomPassword() {
  //Initialize the random password
  $password = '';

  //Initialize a random desired length
  $desired_length = rand(8, 12);

  for($length = 0; $length < $desired_length; $length++) {
    //Append a random ASCII character (including symbols)
    $password .= chr(rand(32, 126));
  }

  return $password;
}

use FortyTwoStudio\WebFactionPHP\WebFactionClient;
use FortyTwoStudio\WebFactionPHP\WebFactionException;
use phpseclib\Net;


    try
    {


      $login = readline("login: ");
      readline_add_history($login);

      $password = readline("password: ");
      readline_add_history($password);

      $projectname = readline("project name: ");
      readline_add_history($projectname);


      if ($login && $password && $projectname) {
        console_log("logging in.... please wait");
      } else {
        console_log('must provide  $login && $password && $projectname');
      }

      //** loggin with SSH and trying to clone repo */

      $ssh = new  Net\SSH2('qunabu.webfactional.com');
      if (!$ssh->login($login, $password)) {
        console_log('Login Failed');
      }

      // create a connection to the API, use your own credentials here, obvs
      $wf = new WebFactionClient($login, $password);

      $ip = '185.119.174.181';

      //$db_pass = WebFactionClient::generatePassword(21); //only in php7
      $db_pass = generateRandomPassword();


      $exists = array(
        'app'=>false,
        'db_user'=>false,
        'db'=>false,
        'website'=>false,
        'domain'=>false,
      );

      $apps = $wf->listApps();

      foreach($apps as $app) {
        if ($app['name'] == $projectname) {
          $exists['app'] = true;
        }
      }

      $websites = $wf->listWebsites();
      foreach($websites as $website) {
        if ($website['name'] == $projectname) {
          $exists['website'] = true;
        }
      }

      $domains = $wf->listDomains();
      foreach($domains as $domain) {
        if ($domain['domain'] == 'qunabu.com') {
          $exists['domain'] = in_array($projectname, $domain['subdomains']);
        }
      }

      $db_users = $wf->listDbUsers();
      foreach($db_users as $db_user) {
        if ($db_user['username'] == $projectname) {
          $exists['db_user'] =  true;
        }
      }

      $dbs = $wf->listDbs();
      foreach($dbs as $db) {
        if ($db['name'] == $projectname) {
          $exists['db'] =  true;
        }
      }


      //DB USER
      if (!$exists['db_user']) {
        console_log('user doesn`t $exists, creating one....');
        $user = $wf->createDbUser($projectname,$db_pass,'mysql');
      } else {
        console_log('user exists, setting up new password one....');
        $user = $wf->changeDbUserPassword($projectname,$db_pass,'mysql');
      }


      //DB
      if (!$exists['db']) {
        console_log('db doesn`t $exists, creating one....');
        $database = $wf->createDb($projectname, 'mysql', '', $projectname);
      } else {
        $user = $wf->grantDbPermissions($projectname,$projectname,'mysql');
        console_log('db exists, Grant full database permissions to a user' );
      }


      //APP
      if (!$exists['app']) {
        console_log('app doesn`t $exists, creating one....');
        $app = $wf->createApp($projectname,'static_php56');
      } else {
        console_log('app exists, nothing to do' );
      }

      //DOMAIN
      if (!$exists['domain']) {
        console_log('domain doesn`t $exists, creating qunabu subdomain....');
        $domain = $wf->createDomain('qunabu.com', [$projectname]);
      } else {
        console_log('domain exists, nothing to do' );
      }


      //WEBSITE
      if (!$exists['website']) {
        console_log('website doesn`t $exists, creating one....');
        $website = $wf->createWebsite($projectname, $ip, FALSE, [$projectname . '.qunabu.com'], [
          $projectname,
          '/'
        ]);
      } else {
        /*
        console_log('website  $exists, updating one....');
        $website = $wf->updateWebsite($projectname, $ip, FALSE, [$projectname . '.qunabu.com'], [
          [$projectname, '/'],
          [$projectname, '/']
        ])
        */;
        console_log('website  $exists, nothing to do ');
      }

      $isGit = eoltrim($ssh->exec("[ -d /home/qunabu/webapps/$projectname/.git ] && echo GIT || echo SHIT"));
      $isIndex = eoltrim($ssh->exec("[ -e /home/qunabu/webapps/$projectname/index.html ] && echo GIT || echo SHIT"));

      if ($isIndex == 'GIT') {
        echo $ssh->exec("rm /home/qunabu/webapps/$projectname/index.html");
      }

      if ($isGit == 'SHIT') {
        echo $ssh->exec("git clone -b develop git@git.qunabu.com:qunabuinteractive/$projectname.git /home/qunabu/webapps/$projectname");
      }

      echo $ssh->exec("cd /home/qunabu/webapps/$projectname && /usr/local/bin/php56 /home/qunabu/composer.phar update");



      echo "PROJECT DETAILS:\n";
      echo "projectname: $projectname \n";
      echo "application static_php56 name : $projectname \n";
      echo "domain : $projectname.qunabu.com \n";
      echo "mysql host : localhost \n";
      echo "mysql username : $projectname \n";
      echo "mysql database : $projectname \n";
      echo "mysql passwrod : $db_pass \n";
      echo "ip: $ip \n";
      echo "path: /home/qunabu/webapps/$projectname \n";
      echo "visit http://$projectname.qunabu.com/install.php to install Silverstripe \n";
      echo "once installation is ready visit to set up _env file \n";
      echo "visit http://$projectname.qunabu.com/dev/tasks/SetEnvironmentTask \n";


    } catch (WebFactionException $e)
    {
      // Something went wrong, find out what with $e->getMessage() but be warned, WebFaction exception messages are often
      // vague and unhelpful!
      echo "rut roh, this went wrong: " . $e->getMessage() . "\n\n";
    }





