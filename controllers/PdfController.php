<?php

namespace li3_dompdf\controllers;

use li3_dompdf\writer\Pdfs;

/**
 * FIXME: Use Lithium's Media
 */
abstract class PdfController extends \lithium\action\Controller
{
	public function render(array $options = array())
	{
		parent::render($options);
		$html = $this->response->body[0];

		$dompdf = Pdfs::get('default');
		$dompdf->load_html($html);
		$dompdf->render();
		header('Content-type: application/pdf');
		echo $dompdf->output();
		$this->_stop();
	}
}