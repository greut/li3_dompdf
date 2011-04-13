<?php

use \lithium\core\Libraries;

if (!defined('DOMPDF_LIBRARY_PATH')) {
	define('DOMPDF_LIBRARY_PATH', LITHIUM_LIBRARY_PATH . '/dompdf/dompdf');
}

define('DOMPDF_INC_DIR', DOMPDF_LIBRARY_PATH . '/include', true);
define('DOMPDF_LIB_DIR', DOMPDF_LIBRARY_PATH . '/lib', true);

require DOMPDF_INC_DIR . '/functions.inc.php';
mb_internal_encoding('UTF-8');


$name = 'dompdf';
$library = Libraries::get($name);

if (empty($library)) {
	Libraries::add($name, array(
		'bootstrap' => false,
		'path' => DOMPDF_LIBRARY_PATH
	));
}

include __DIR__ . '/bootstrap/media.php';

?>