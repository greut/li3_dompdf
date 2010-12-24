<?php

namespace li3_dompdf\controllers;

use li3_dompdf\writer\Pdfs;

abstract class PdfController extends \lithium\action\Controller
{
    public function render(array $options = array()) {
        parent::render($options);
        $html = $this->response->body[0]; 
    
        $dompdf = Pdfs::get('default');
        $dompdf->load_html($html);
        $dompdf->render();
        header('Content-type: application/pdf');
        echo $dompdf->output();
        exit();
    }
}