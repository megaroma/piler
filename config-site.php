<?php

$config['SITE_NAME'] = 'localhost';
$config['SITE_URL'] = 'http://' . $config['SITE_NAME'] . '/';
$config['DIR_BASE'] = '/var/www/piler/';

$config['ENABLE_SYSLOG'] = 1;

$config['SMTP_DOMAIN'] = 'localhost';
$config['SMTP_FROMADDR'] = 'no-reply@localhost';
$config['ADMIN_EMAIL'] = 'admin@localhost';

$config['DB_DRIVER'] = 'mysql';
$config['DB_PREFIX'] = '';
$config['DB_HOSTNAME'] = 'localhost';
$config['DB_USERNAME'] = 'root';
$config['DB_PASSWORD'] = 'treadmill';
$config['DB_DATABASE'] = 'piler';

$config['SMARTHOST'] = '';
$config['SMARTHOST_PORT'] = 25;

?>
