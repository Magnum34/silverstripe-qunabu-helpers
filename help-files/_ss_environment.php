<?php
/* What kind of environment is this: development, test, or live (ie, production)? */
define('SS_ENVIRONMENT_TYPE', 'dev');

/* Database connection */
define('SS_DATABASE_SERVER', '||SS_DATABASE_SERVER||');
define('SS_DATABASE_USERNAME', '||SS_DATABASE_USERNAME||');
define('SS_DATABASE_NAME', '||SS_DATABASE_NAME||');
define('SS_DATABASE_PASSWORD', '||SS_DATABASE_NAME||');

/* Configure a default username and password to access the CMS on all sites in this environment. */
//define('SS_DEFAULT_ADMIN_USERNAME', 'username');
//define('SS_DEFAULT_ADMIN_PASSWORD', 'password');

global $_FILE_TO_URL_MAPPING ;

/* If you want to keep a single manifest file then you can hard code this in your _config or _ss_environment.
Qunabu. This is requir */
//define('MANIFEST_FILE', TEMP_FOLDER . "/manifest-main");

//$_FILE_TO_URL_MAPPING['/Users/qunabu/Desktop/localhost/stallan-brand'] = 'http://stallan-brand.loc/';