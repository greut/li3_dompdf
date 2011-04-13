<?php

use lithium\net\http\Media;
use li3_dompdf\writer\Pdfs;

Media::type('pdf', 'application/pdf', array('encode' => function($data) {
	$dompdf = Pdfs::get('default');
	$dompdf->load_html($data[0]);
	$dompdf->render();
	return $dompdf->output();
}));