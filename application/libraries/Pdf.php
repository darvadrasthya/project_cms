<?php

defined('BASEPATH') or exit('No direct script access allowed');

// Load FPDF
include_once APPPATH . '/third_party/fpdf/fpdf.php';

class Pdf extends FPDF
{
	public $angle = 0;

	/**
	 * Constructor
	 * 
	 * @param string $orientation Page orientation (P|L)
	 * @param string $unit Unit of measurement
	 * @param string $size Page size
	 */
	public function __construct($orientation = 'P', $unit = 'mm', $size = 'A4')
	{
		parent::__construct($orientation, $unit, $size);
	}

	/**
	 * Footer for every page
	 */
	public function Footer()
	{
		$this->SetY(-15);
		$lebar = $this->w;

		$this->SetFont('Arial', 'I', 7);

		// Draw line
		$this->line(
			$this->GetX(),
			$this->GetY(),
			$this->GetX() + $lebar - 20,
			$this->GetY()
		);

		$this->SetY(-15);
		$this->SetX(0);
		$this->Ln(1);

		// Page number
		$hal = 'Halaman : ' . $this->PageNo() . '';
		$this->Cell($this->GetStringWidth($hal), 5, $hal);

		// Print date
		$tanggal = 'Tanggal Cetak : ' . date('d-m-Y  h:i') . ' ';
		$this->Cell($lebar - $this->GetStringWidth($hal) - $this->GetStringWidth($tanggal) - 20);
		$this->Cell($this->GetStringWidth($tanggal), 5, $tanggal);
	}

	/**
	 * Set dash pattern for lines
	 * 
	 * @param float|null $black Black dash length
	 * @param float|null $white White dash length
	 */
	public function SetDash($black = null, $white = null)
	{
		if ($black !== null) {
			$s = sprintf('[%.3F %.3F] 0 d', $black * $this->k, $white * $this->k);
		} else {
			$s = '[] 0 d';
		}

		$this->_out($s);
	}

	/**
	 * Rotate the coordinate system
	 * 
	 * @param float $angle Rotation angle in degrees
	 * @param float $x X coordinate of rotation center
	 * @param float $y Y coordinate of rotation center
	 */
	public function Rotate($angle, $x = -1, $y = -1)
	{
		if ($x == -1) {
			$x = $this->x;
		}
		if ($y == -1) {
			$y = $this->y;
		}

		if ($this->angle != 0) {
			$this->_out('Q');
		}

		$this->angle = $angle;

		if ($angle != 0) {
			$angle *= M_PI / 180;
			$c = cos($angle);
			$s = sin($angle);
			$cx = $x * $this->k;
			$cy = ($this->h - $y) * $this->k;

			$this->_out(sprintf(
				'q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',
				$c,
				$s,
				-$s,
				$c,
				$cx,
				$cy,
				-$cx,
				-$cy
			));
		}
	}

	/**
	 * Draw rotated text
	 * 
	 * @param float $x X coordinate
	 * @param float $y Y coordinate
	 * @param string $txt Text to display
	 * @param float $angle Rotation angle in degrees
	 */
	public function RotatedText($x, $y, $txt, $angle)
	{
		// Text rotated around its origin
		$this->Rotate($angle, $x, $y);
		$this->Text($x, $y, $txt);
		$this->Rotate(0);
	}
}
