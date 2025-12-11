<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Load FPDF
require_once(APPPATH . 'third_party/fpdf/fpdf.php');

class PdfGenerate extends FPDF
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

    /** ===== KONFIGURASI PER HALAMAN ===== */
    private $pageConfigs = [];        // menyimpan konfigurasi per halaman
    private $currentPageConfig = [];  // konfigurasi halaman saat ini

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

        // Inisialisasi konfigurasi halaman pertama
        $this->initPageConfig(1);
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

    /** ===== METHOD UNTUK ADD PAGE DENGAN KONFIGURASI CUSTOM ===== */
    public function AddPage($orientation = '', $size = '', $rotation = 0, $pageConfig = [])
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

        // Simpan konfigurasi untuk halaman baru
        $pageNumber = $this->PageNo();
        $this->initPageConfig($pageNumber, $pageConfig);
    }

    /** ===== METHOD UNTUK INISIALISASI KONFIGURASI HALAMAN ===== */
    private function initPageConfig($pageNumber, $customConfig = [])
    {
        // Konfigurasi default untuk halaman
        $defaultConfig = [
            'showHeader' => $this->showHeader,
            'showFooter' => $this->showFooter,
            'showLine' => $this->showLine,
            'showLogo' => $this->showLogo,
            'logoPath' => $this->logoPath,
            'logoWidth' => $this->logoWidth,
            'titleText' => $this->titleText,
            'subText' => $this->subText,
            'marginTop' => $this->marginTop,
            'marginLeft' => $this->marginLeft,
            'marginRight' => $this->marginRight,
            'marginBottom' => $this->marginBottom,
            'fontFamily' => $this->fontFamily,
            'fontSize' => $this->fontSize,
            'headerCallback' => null,  // callback function untuk header custom
            'footerCallback' => null,  // callback function untuk footer custom
        ];

        // Gabungkan dengan konfigurasi custom
        $this->pageConfigs[$pageNumber] = array_merge($defaultConfig, $customConfig);
        $this->currentPageConfig = &$this->pageConfigs[$pageNumber];
    }

    /** ===== METHOD UNTUK MENDAPATKAN KONFIGURASI HALAMAN SAAT INI ===== */
    private function getCurrentPageConfig()
    {
        $pageNumber = $this->PageNo();
        if (!isset($this->pageConfigs[$pageNumber])) {
            $this->initPageConfig($pageNumber);
        }
        return $this->pageConfigs[$pageNumber];
    }

    /** ===== HEADER OTOMATIS DENGAN KONFIGURASI PER HALAMAN ===== */
    public function Header()
    {
        $config = $this->getCurrentPageConfig();

        if (!$config['showHeader']) return;

        // Jika ada callback custom, gunakan itu
        if (is_callable($config['headerCallback'])) {
            call_user_func($config['headerCallback'], $this);
            return;
        }

        $pageWidth = $this->pageWidth;
        $centerX = $pageWidth / 2;

        // === Tampilkan Logo (kiri atas)
        if ($config['showLogo'] && !empty($config['logoPath']) && file_exists($config['logoPath'])) {
            $this->Image($config['logoPath'], $config['marginLeft'], 10, $config['logoWidth']);
        }

        // === Reset posisi kursor agar teks tetap center
        $this->SetY($config['marginTop'] - 10);

        // === Tampilkan teks header (selalu center)
        if (!empty($config['titleText'])) {
            $this->SetFont($config['fontFamily'], 'B', $config['fontSize'] + 1);
            $this->Cell(0, 5, strtoupper($config['titleText']), 0, 1, 'C');
        }

        if (!empty($config['subText'])) {
            $this->SetFont($config['fontFamily'], '', $config['fontSize'] - 1);
            $this->Cell(0, 5, $config['subText'], 0, 1, 'C');
        }

        // === Garis pemisah bawah header
        if ($config['showLine']) {
            $this->Ln(1);
            $this->Line($config['marginLeft'], $this->GetY(), $pageWidth - $config['marginRight'], $this->GetY());
        }

        $this->Ln(6);
    }

    /** ===== FOOTER OTOMATIS DENGAN KONFIGURASI PER HALAMAN ===== */
    public function Footer()
    {
        $config = $this->getCurrentPageConfig();

        if (!$config['showFooter']) return;

        // Jika ada callback custom, gunakan itu
        if (is_callable($config['footerCallback'])) {
            call_user_func($config['footerCallback'], $this);
            return;
        }

        $this->SetY(-($config['marginBottom'] - 5));

        if ($config['showLine']) {
            $this->Line($config['marginLeft'], $this->GetY() - 2, $this->pageWidth - $config['marginRight'], $this->GetY() - 2);
        }

        $this->SetFont($config['fontFamily'], 'I', 8);
        $this->Cell(0, 8, 'Halaman ' . $this->PageNo(), 0, 0, 'C');
    }

    /** ===== METHOD UNTUK MENGUBAH KONFIGURASI HALAMAN SAAT INI ===== */
    public function setPageConfig($config = [])
    {
        $pageNumber = $this->PageNo();
        if (isset($this->pageConfigs[$pageNumber])) {
            $this->pageConfigs[$pageNumber] = array_merge($this->pageConfigs[$pageNumber], $config);
        } else {
            $this->initPageConfig($pageNumber, $config);
        }
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

    /** ===== METHOD UNTUK MENAMBAH HALAMAN DENGAN HEADER/FOOTER CUSTOM ===== */
    public function addCustomPage($orientation = '', $config = [])
    {
        $this->AddPage($orientation, '', 0, $config);
    }
}
