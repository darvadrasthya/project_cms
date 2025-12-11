<?php

defined('BASEPATH') or exit('No direct script access allowed');

# call class libraries fpdf
include_once APPPATH . '/third_party/fpdf/fpdf.php';

class My_PdfGenerate extends FPDF
{
    function __construct($orientation = 'P', $unit = 'mm', $size = 'A4')
    {
        parent::__construct($orientation, $unit, $size);
    }
}
