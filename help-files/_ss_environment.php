<?php
/* What kind of environment is this: development, test, or live (ie, production)? */
define('SS_ENVIRONMENT_TYPE', 'dev');

/* Database connection */
define('SS_DATABASE_SERVER', 'localhost');
define('SS_DATABASE_USERNAME', 'root');
define('SS_DATABASE_NAME', 'stallan');
define('SS_DATABASE_PASSWORD', 'root');

/* Configure a default username and password to access the CMS on all sites in this environment. */
//define('SS_DEFAULT_ADMIN_USERNAME', 'username');
//define('SS_DEFAULT_ADMIN_PASSWORD', 'password');

global $_FILE_TO_URL_MAPPING ;

//$_FILE_TO_URL_MAPPING['/Users/qunabu/Desktop/localhost/stallan-brand'] = 'http://stallan-brand.loc/';