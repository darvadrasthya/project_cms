<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Load FPDF
require_once(APPPATH . 'third_party/fpdf/fpdf.php');

class PdfSpk extends FPDF
{
    /** ===== KONFIGURASI UMUM ===== */
    public $showHeader   = true;      // tampilkan header
    public $showFooter   = true;      // tampilkan footer
    public $showLine     = true;      // garis bawah di header/footer
    public $showLogo     = false;     // tampilkan logo
    public $logoPath     = '';        // path logo (relative path / absolute)
    public $logoWidth    = 20;        // lebar logo (mm)
    public $marginLeft   = 20;
    public $marginTop    = 25;
    public $marginRight  = 15;
    public $marginBottom = 20;
    public $titleText    = '';        // judul header tengah
    public $subText      = '';        // subjudul header bawah
    public $fontFamily   = 'Arial';   // font default
    public $fontSize     = 10;        // ukuran font default
    public $fontStyle    = '';        // '', 'B', 'I', 'BI'
    public $orientation  = 'P';       // P = Portrait, L = Landscape
    public $pageWidth    = 210;       // lebar A4 Portrait (mm)
    public $pageHeight   = 297;       // tinggi A4 Portrait (mm)

    public function __construct($params = [])
    {
        // Set default orientation dan ukuran halaman
        $orientation = 'P';
        $pageSize = 'A4';

        // Override orientation dari parameter
        if (!empty($params['orientation'])) {
            $orientation = $params['orientation'];
        }

        parent::__construct($orientation, 'mm', $pageSize);

        // Set ukuran halaman berdasarkan orientation
        $this->orientation = $orientation;
        $this->updatePageDimensions();

        // Override properti dari controller
        if (!empty($params)) {
            foreach ($params as $key => $val) {
                if (property_exists($this, $key)) {
                    $this->$key = $val;
                }
            }
        }

        // Set margin dan auto page break
        $this->SetMargins($this->marginLeft, $this->marginTop, $this->marginRight);
        $this->SetAutoPageBreak(true, $this->marginBottom);

        // Set default font global
        $this->SetFont($this->fontFamily, $this->fontStyle, $this->fontSize);
    }

    /** ===== METHOD UNTUK UPDATE DIMENSI HALAMAN ===== */
    private function updatePageDimensions()
    {
        if ($this->orientation === 'L') {
            $this->pageWidth = 297;  // A4 Landscape width
            $this->pageHeight = 210; // A4 Landscape height
        } else {
            $this->pageWidth = 210;  // A4 Portrait width
            $this->pageHeight = 297; // A4 Portrait height
        }
    }

    /** ===== METHOD UNTUK ADD PAGE DENGAN ORIENTASI BERBEDA ===== */
    public function AddPage($orientation = '', $size = '', $rotation = 0)
    {
        // Jika orientation tidak ditentukan, gunakan orientation default
        if (empty($orientation)) {
            $orientation = $this->orientation;
        }

        // Jika orientation berubah, update property
        if ($orientation !== $this->orientation) {
            $this->orientation = $orientation;
            $this->updatePageDimensions();
        }

        parent::AddPage($orientation, $size, $rotation);
    }

    /** ===== HEADER OTOMATIS ===== */
    public function Header()
    {
        if (!$this->showHeader) return;

        $pageWidth = $this->pageWidth;
        $centerX = $pageWidth / 2;

        // === Tampilkan Logo (kiri atas)
        if ($this->showLogo && !empty($this->logoPath) && file_exists($this->logoPath)) {
            $this->Image($this->logoPath, $this->marginLeft, 10, $this->logoWidth);
        }

        // === Reset posisi kursor agar teks tetap center
        $this->SetY($this->marginTop - 10);

        // === Tampilkan teks header (selalu center)
        if (!empty($this->titleText)) {
            $this->SetFont($this->fontFamily, 'B', $this->fontSize + 1);
            $this->Cell(0, 5, strtoupper($this->titleText), 0, 1, 'C');
        }

        if (!empty($this->subText)) {
            $this->SetFont($this->fontFamily, '', $this->fontSize - 1);
            $this->Cell(0, 5, $this->subText, 0, 1, 'C');
        }

        // === Garis pemisah bawah header
        if ($this->showLine) {
            $this->Ln(1);
            $this->Line($this->marginLeft, $this->GetY(), $pageWidth - $this->marginRight, $this->GetY());
        }

        $this->Ln(6);
    }

    /** ===== FOOTER OTOMATIS ===== */
    public function Footer()
    {
        if (!$this->showFooter) return;

        $this->SetY(-($this->marginBottom - 5));

        if ($this->showLine) {
            $this->Line($this->marginLeft, $this->GetY() - 2, $this->pageWidth - $this->marginRight, $this->GetY() - 2);
        }

        $this->SetFont($this->fontFamily, 'I', 8);
        $this->Cell(0, 8, 'Halaman ' . $this->PageNo(), 0, 0, 'C');
    }

    /** ===== METHOD UNTUK MENDAPATKAN LEBAR HALAMAN ===== */
    public function GetPageWidth()
    {
        return $this->pageWidth;
    }

    /** ===== METHOD UNTUK MENDAPATKAN TINGGI HALAMAN ===== */
    public function GetPageHeight()
    {
        return $this->pageHeight;
    }

    /** ===== METHOD UNTUK MENDAPATKAN ORIENTASI ===== */
    public function GetOrientation()
    {
        return $this->orientation;
    }

    /** ===== METHOD UNTUK MENGUBAH ORIENTASI ===== */
    public function SetOrientation($orientation)
    {
        $this->orientation = $orientation;
        $this->updatePageDimensions();
    }
}
