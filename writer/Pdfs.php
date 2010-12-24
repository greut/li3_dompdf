<?php

namespace li3_dompdf\writer;

class Pdfs extends \lithium\core\Adaptable {
	/**
	 * A Collection of the configurations you add through DomPdf::config().
	 *
	 * @var Collection
	 */
	protected static $_configurations = array();

	protected static $_default = array(
		'backend' => 'CPDF',
		//'pdflib' => 'your license key', // config that into bootstrap.php
		'unicode' => true,
		'media' => 'screen',
		'paper' => 'letter',
		'orientation' => 'portrait',
		'dpi' => 96,
		'font' => 'serif',
		'php' => false,
		'javascript' => true,
		'remote' => false,
		'warnings' => false,
		'debug' => false
	);

	protected static $_dompdf;

	public static function auto_load($class) {
		$filename = DOMPDF_INC_DIR.'/'.strtolower($class).'.cls.php';
		if (is_file($filename)) {
			require_once($filename);
		}
	}

	public static function get($name) {
		if (!isset(static::$_dompdf)) {
			$config = static::config($name) + static::$_default;
			// boiler plate
			define('DOMPDF_FONT_DIR', DOMPDF_LIB_DIR . '/fonts/', true);
			define('DOMPDF_FONT_CACHE', DOMPDF_FONT_DIR, true);
			define('DOMPDF_TEMP_DIR', sys_get_temp_dir(), true);
			define('DOMPDF_CHROOT', dirname(LITHIUM_APP_PATH), true);
			define('DOMPDF_UNICODE_ENABLED', $config['unicode'], true);

			define('DOMPDF_PDF_BACKEND', $config['backend'], true);
			if (isset($config['pdflib'])) {
				define('DOMPDF_PDFLIB_LICENSE', $config['pdflib'], true);
			}
			define('DOMPDF_DEFAULT_MEDIA_TYPE', $config['media'], true);
			define('DOMPDF_DEFAULT_PAPER_SIZE', $config['paper'], true);
			define('DOMPDF_DEFAULT_FONT', $config['font'], true);
			define('DOMPDF_DPI', $config['dpi'], true);
			define('DOMPDF_ENABLE_PHP', $config['php'], true);
			define('DOMPDF_ENABLE_JAVASCRIPT', $config['javascript'], true);
			define('DOMPDF_ENABLE_REMOTE', $config['remote'], true);

			spl_autoload_register(__NAMESPACE__.'\Pdfs::auto_load');

			global $_dompdf_warnings;
			$_dompdf_warnings = array();
			global $_dompdf_show_warnings;
			$_dompdf_show_warnings = $config['warnings'];
			global $_dompdf_debug;
			$_dompdf_debug = $config['debug'];
			global $_DOMPDF_DEBUG_TYPES;
			$_DOMPDF_DEBUG_TYPES = array();

			define('DEBUGPPNG', $config['debug'], true);
			define('DEBUGKEEPTEMP', $config['debug'], true);
			define('DEBUGCSS', $config['debug'], true);
			define('DEBUG_LAYOUT', $config['debug'], true);
			define('DEBUG_LAYOUT_LINES', $config['debug'], true);
			define('DEBUG_LAYOUT_BLOCKS', $config['debug'], true);
			define('DEBUG_LAYOUT_INLINE', $config['debug'], true);
			define('DEBUG_LAYOUT_PADDINGBOX', $config['debug'], true);
			
			$dompdf = new \DOMPDF();
			
			static::$_dompdf = $dompdf;
		}
		
		return static::$_dompdf;
	}
}
# vim: noet ts=4 nobinary
?>
