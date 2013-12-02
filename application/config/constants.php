<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');
 /*
  |--------------------------------------------------------------------------
  | File and Directory Modes
  |--------------------------------------------------------------------------
  |
  | These prefs are used when checking and setting modes when working
  | with the file system.  The defaults are fine on servers with proper
  | security, but you may wish (or even need) to change the values in
  | certain environments (Apache running a separate process for each
  | user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
  | always be used to set the mode correctly.
  |
 */
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);
define('VERSION', '2.2.92');

/*
  |--------------------------------------------------------------------------
  | File Stream Modes
  |--------------------------------------------------------------------------
  |
  | These modes are used when working with fopen()/popen()
  |
 */

define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');



define('EMAIL_GALATEA', 'contato@galateacasa.com.br');
define('CONTATO_GALATEA', 'Galatea Casa');
define('FACEBOOK_APP_ID', '431265863600958');
define('FACEBOOK_API_SECRET', '1a0c56e76037b5bdb55a527abc41ac0d');
define('PAGSEGURO_LOGIN', 'luiz@galateacasa.com.br');
define('PAGSEGURO_TOKEN', 'DD9F08C4D3454661938F32AC8B7B095D');

define('AMBIANCE_SELL_ROYALTIES', 1); //%
define('PRODUCT_SELL_ROYALTIES', 5); //%
/* End of file constants.php */
/* Location: ./application/config/constants.php */
