<?php

/**
 * MY_Loanfinancial_helper.php
 *
 * @package    CodeIgniter
 * @subpackage Helpers
 * @author     Ridwan Panji Akbar (Oneread), Darva Drasthya (Oneread)
 * @license    https://opensource.org/licenses/MIT MIT License
 * @version    1.0.0
 *
 * Helper ini berisi berbagai fungsi utilitas yang digunakan dalam aplikasi
 * untuk mendukung fungsionalitas umum. Fungsi-fungsi ini dirancang untuk
 * meningkatkan efisiensi dan keterbacaan kode dalam pengembangan aplikasi.
 */

// Menghitung Angsuran Anuitas
if (!function_exists('calculate_angsuran_anuitas')) {
    function calculate_angsuran_anuitas($rate = 0, $nper = 0, $pv = 0, $fv = 0, $type = 0)
    {
        // Memastikan bahwa library PHPExcel hanya di-load jika fungsi ini dipanggil
        include APPPATH . 'third_party/PHPExcel/PHPExcel/Calculation/Financial.php';

        // Membuat objek untuk perhitungan finansial
        $obj_PHPExcel = new PHPExcel_Calculation_Financial();

        // Menghitung angsuran menggunakan metode PMT
        $angsuran = $obj_PHPExcel->PMT($rate, $nper, $pv, $fv, $type);

        // Mengembalikan nilai absolut dari angsuran
        return abs($angsuran);
    }
}

// Menghitung Angsuran Flat
if (!function_exists('calculate_angsuran_flat')) {
    function calculate_angsuran_flat($rate = 0, $nper = 0, $pv = 0)
    {
        // Validasi input untuk memastikan nilai tidak negatif
        if ($nper <= 0 || $pv < 0 || $rate < 0) {
            return 0; // Mengembalikan 0 jika input tidak valid
        }

        // Menghitung pokok angsuran
        $calPokok = floatval($pv / $nper);

        // Menghitung bunga angsuran
        $calBunga = floatval($pv * $rate);

        // Menghitung total angsuran (pokok + bunga)
        $calPokokBunga = floatval($calPokok + $calBunga);

        // Mengembalikan nilai absolut dari total angsuran
        return abs($calPokokBunga);
    }
}

// Menghitung usia dalam format desimal dan detail (tahun, bulan, hari).
if (!function_exists('calculate_age_details')) {
    /**
     * Menghitung usia dalam format desimal dan detail (tahun, bulan, hari).
     *
     * @param string $tgl_pengajuan Format: YYYY-MM-DD
     * @param string $tgl_lahir Format: YYYY-MM-DD
     * @return array [
     *     'age_decimal' => float Usia dalam desimal (1 angka di belakang koma),
     *     'age_detail' => string Usia dalam format "XX Tahun, XX Bulan, XX Hari"
     * ]
     */
    function calculate_age_details($tgl_pengajuan, $tgl_lahir)
    {
        // Validasi format tanggal
        if (!$tgl_pengajuan || !$tgl_lahir) {
            return [
                'age_decimal' => 0.0,
                'age_detail' => '0 Tahun, 0 Bulan, 0 Hari'
            ];
        }

        // Konversi string tanggal menjadi objek DateTime
        try {
            $date_pengajuan = new DateTime($tgl_pengajuan);
            $date_lahir = new DateTime($tgl_lahir);
        } catch (Exception $e) {
            return [
                'age_decimal' => 0.0,
                'age_detail' => '0 Tahun, 0 Bulan, 0 Hari'
            ];
        }

        // Hitung selisih tahun, bulan, dan hari
        $year_diff = $date_pengajuan->format('Y') - $date_lahir->format('Y');
        $month_diff = $date_pengajuan->format('m') - $date_lahir->format('m');
        $day_diff = $date_pengajuan->format('d') - $date_lahir->format('d');

        // Penyesuaian jika bulan atau hari lebih kecil
        if ($day_diff < 0) {
            $month_diff--;
            $day_diff += (int)$date_pengajuan->format('t'); // Jumlah hari dalam bulan
        }

        if ($month_diff < 0) {
            $year_diff--;
            $month_diff += 12;
        }

        // Hitung usia desimal
        $age_decimal = $year_diff + ($month_diff / 12) + ($day_diff / 365.25);

        // Format usia detail
        $age_detail = sprintf('%d Tahun, %d Bulan, %d Hari', $year_diff, $month_diff, $day_diff);

        return [
            'age_decimal' => round($age_decimal, 1),
            'age_detail' => $age_detail
        ];
    }
}

// Menghitung usia pada saat jatuh tempo.
if (!function_exists('calculate_age_details_jatuhtempo')) {
    /**
     * Menghitung usia pada saat jatuh tempo.
     *
     * @param string $tgl_pengajuan Format: YYYY-MM-DD
     * @param string $tgl_lahir Format: YYYY-MM-DD
     * @param int $jangka_waktu Jumlah bulan jangka waktu pinjaman
     * @return array [
     *     'age_decimal' => float Usia dalam desimal (1 angka di belakang koma),
     *     'age_detail' => string Usia dalam format "XX Tahun, XX Bulan, XX Hari"
     * ]
     */
    function calculate_age_details_jatuhtempo($tgl_pengajuan, $tgl_lahir, $jangka_waktu)
    {
        // Validasi format tanggal
        if (!$tgl_pengajuan || !$tgl_lahir || !$jangka_waktu) {
            return [
                'age_decimal' => 0.0,
                'age_detail' => '0 Tahun, 0 Bulan, 0 Hari'
            ];
        }

        // Konversi string tanggal menjadi objek DateTime
        try {
            $date_pengajuan = new DateTime($tgl_pengajuan);
            $date_lahir = new DateTime($tgl_lahir);
        } catch (Exception $e) {
            return [
                'age_decimal' => 0.0,
                'age_detail' => '0 Tahun, 0 Bulan, 0 Hari'
            ];
        }

        // Hitung tanggal jatuh tempo
        $date_due = clone $date_pengajuan;
        $date_due->modify("+$jangka_waktu months");

        // Hitung selisih tahun, bulan, dan hari
        $year_diff = $date_due->format('Y') - $date_lahir->format('Y');
        $month_diff = $date_due->format('m') - $date_lahir->format('m');
        $day_diff = $date_due->format('d') - $date_lahir->format('d');

        // Penyesuaian jika bulan atau hari lebih kecil
        if ($day_diff < 0) {
            $month_diff--;
            $day_diff += (int)$date_due->format('t'); // Jumlah hari dalam bulan
        }

        if ($month_diff < 0) {
            $year_diff--;
            $month_diff += 12;
        }

        // Hitung usia desimal
        $age_decimal = $year_diff + ($month_diff / 12) + ($day_diff / 365.25);

        // Format usia detail
        $age_detail = sprintf('%d Tahun, %d Bulan, %d Hari', $year_diff, $month_diff, $day_diff);

        return [
            'age_decimal' => round($age_decimal, 1),
            'age_detail' => $age_detail
        ];
    }
}

// Fungsi untuk menghitung rasio pinjaman
if (!function_exists('calculate_ratio_angsuran')) {
    /**
     * Menghitung rasio pinjaman berdasarkan angsuran bulanan dan gaji.
     * @param float $angsuranBulanan - Jumlah angsuran bulanan
     * @param float $gaji - Gaji bulanan peminjam
     * @return float - Rasio pinjaman dalam persentase (%)
     */
    function calculate_ratio_angsuran($angsuranBulanan, $gaji)
    {
        if ($gaji == 0) {
            return 0; // Menghindari pembagian dengan nol
        }

        $rasio = ($angsuranBulanan / $gaji) * 100; // Hitung rasio dalam persen
        return round($rasio, 0) . '%'; // Bulatkan ke dua desimal
    }
}

// Menghitung tanggal jatuh tempo berdasarkan tanggal pengajuan dan jangka waktu pinjaman
if (!function_exists('calculate_tgl_jatuhtempo')) {
    /**
     * Menghitung tanggal jatuh tempo berdasarkan tanggal pengajuan dan jangka waktu pinjaman.
     *
     * @param string $tgl_pengajuan Format: YYYY-MM-DD
     * @param int $jangka_waktu Jumlah bulan jangka waktu pinjaman
     * @return string Tanggal jatuh tempo dalam format YYYY-MM-DD
     */
    function calculate_tgl_jatuhtempo($tgl_pengajuan, $jangka_waktu, $format = 'Y-m-d')
    {
        // Validasi input
        if (!$tgl_pengajuan || !$jangka_waktu) {
            return null;
        }

        // Konversi string tanggal menjadi objek DateTime
        try {
            $date_pengajuan = new DateTime($tgl_pengajuan);
        } catch (Exception $e) {
            return null; // Kembalikan null jika tanggal pengajuan tidak valid
        }

        // Tambahkan jangka waktu dalam bulan
        $date_pengajuan->modify("+$jangka_waktu months");

        // Kembalikan tanggal dalam format YYYY-MM-DD
        return $date_pengajuan->format($format);
    }
}

// Menghitung tanggal mulai angsuran berdasarkan tanggal pencairan
if (!function_exists('calculate_tgl_mulaiangsuran')) {
    /**
     * Menghitung tanggal mulai angsuran berdasarkan tanggal pencairan.
     *
     * @param string $tgl_cair Format: YYYY-MM-DD
     * @param string $format Format output tanggal, default: Y-m-d
     * @return string|null Tanggal mulai angsuran dalam format YYYY-MM-DD, atau null jika input tidak valid
     */
    function calculate_tgl_mulaiangsuran($tgl_cair, $format = 'Y-m-d')
    {
        // Validasi input
        if (!$tgl_cair) {
            return null;
        }

        // Konversi string tanggal menjadi objek DateTime
        try {
            $date_cair = new DateTime($tgl_cair);
        } catch (Exception $e) {
            return null; // Kembalikan null jika tanggal pencairan tidak valid
        }

        // Tambahkan 1 bulan untuk mendapatkan tanggal mulai angsuran
        $date_cair->modify('+1 month');

        // Kembalikan tanggal dalam format yang diminta
        return $date_cair->format($format);
    }
}
