<?php
require_once('vendor/autoload.php');

use Compactor\Compressor;
use Compactor\Compressor\Options;
use Compactor\Common\Json;

Phar::interceptFileFuncs();

$json = Json::decodeToArray('./compressor.json');
$options = new Options((array)$json['options']);
$compressor = new Compressor($options);

foreach ($json['files'] as $file) { 
	$compressor->addFile($file);
}

$compressor->compress();