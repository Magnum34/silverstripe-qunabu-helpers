#!/usr/bin/env bash
cd /home/qunabu/webapps/PROJECTNAME
git pull
git fetch --all
git checkout --force "develop"
cp /home/qunabu/webapps/PROJECTNAME/mysite/live_config.php /home/qunabu/webapps/PROJECTNAME/mysite/_config.php
rm composer.lock
php56 /home/qunabu/bin/composer.phar update
php56 /home/qunabu/webapps/PROJECTNAME/framework/cli-script.php dev/build "?flush=1"
