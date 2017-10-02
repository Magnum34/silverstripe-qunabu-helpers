#!/usr/bin/env bash
cd /home/qunabu/webapps/PROJECTNAME

# remove all untracked files
git clear -f

# pull latest repos
git pull

# fetch all branches
git fetch --all

# checkoutr branch develop 
git checkout --force "develop"

#copy live settings to _config.pgp
cp /home/qunabu/webapps/PROJECTNAME/mysite/live_config.php /home/qunabu/webapps/PROJECTNAME/mysite/_config.php

#remove composer lock 
rm composer.lock
# run composer non-interactive mode
php56 /home/qunabu/bin/composer.phar update -n 

#build manifest and clear cache
php56 /home/qunabu/webapps/PROJECTNAME/framework/cli-script.php dev/build "?flush=1"
