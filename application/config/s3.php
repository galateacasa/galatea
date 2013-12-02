<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Use SSL
|--------------------------------------------------------------------------
|
| Run this over HTTP or HTTPS. HTTPS (SSL) is more secure but can cause problems
| on incorrectly configured servers.
|
*/

$config['use_ssl'] = FALSE;

/*
|--------------------------------------------------------------------------
| Verify Peer
|--------------------------------------------------------------------------
|
| Enable verification of the HTTPS (SSL) certificate against the local CA
| certificate store.
|
*/

$config['verify_peer'] = TRUE;

/*
|--------------------------------------------------------------------------
| Access Key
|--------------------------------------------------------------------------
|
| Your Amazon S3 access key.
|
*/

$config['access_key'] = 'AKIAITUKP5YZVMD4FRIQ';

/*
|--------------------------------------------------------------------------
| Parser Enabled
|--------------------------------------------------------------------------
|
| Your Amazon S3 Secret Key.
|
*/

$config['secret_key'] = '/L8/TH5SGOqNX+znaxv3L1DHuzKgN10iOcc+10dv';

$config['s3_ambient'] = (ENVIRONMENT == 'testing' || ENVIRONMENT == "development") ? 'new' : ENVIRONMENT;
// $config['s3_ambient'] = (ENVIRONMENT == 'testing' || ENVIRONMENT == "development") ? 'production' : ENVIRONMENT;

$config['s3_bucket'] = "galatea-sp";
