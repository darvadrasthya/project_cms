<?php

/**
 * MY_Apps2_helper.php
 *
 * Helper ini berisi berbagai fungsi utilitas yang digunakan dalam aplikasi
 * untuk mendukung fungsionalitas umum. Fungsi-fungsi ini dirancang untuk
 * meningkatkan efisiensi dan keterbacaan kode dalam pengembangan aplikasi.
 *
 * Cara Menggunakan:
 * 1. Pastikan helper ini dimuat dalam aplikasi Anda.
 *    Anda dapat memuatnya di controller atau mengatur autoload di config.
 * 2. Panggil fungsi yang diinginkan dengan parameter yang sesuai.
 *
 * Contoh Penggunaan:
 * // Memanggil fungsi dari helper
 * some_helper_function($param1, $param2);
 *
 * Catatan:
 * - Pastikan untuk merujuk ke dokumentasi CodeIgniter untuk informasi lebih lanjut
 *   tentang penggunaan helper dan autoloading.
 */

/**
 * Mengubah nomor bulan menjadi representasi string dua digit.
 *
 * @param int $bln Nomor bulan (1-12).
 * @return string Representasi string dua digit dari bulan.
 */
if (!function_exists('short_bulan')) {
    function short_bulan($bln)
    {
        switch ($bln) {
            case 1:
                return "01";
                break;
            case 2:
                return "02";
                break;
            case 3:
                return "03";
                break;
            case 4:
                return "04";
                break;
            case 5:
                return "05";
                break;
            case 6:
                return "06";
                break;
            case 7:
                return "07";
                break;
            case 8:
                return "08";
                break;
            case 9:
                return "09";
                break;
            case 10:
                return "10";
                break;
            case 11:
                return "11";
                break;
            case 12:
                return "12";
                break;
        }
    }
}

/**
 * Mengubah nomor bulan menjadi representasi string tiga huruf.
 *
 * @param int $bln Nomor bulan (1-12).
 * @return string Representasi string tiga huruf dari bulan.
 */
if (!function_exists('middle_bulan')) {
    function middle_bulan($bln)
    {
        switch ($bln) {
            case 1:
                return "Jan";
                break;
            case 2:
                return "Feb";
                break;
            case 3:
                return "Mar";
                break;
            case 4:
                return "Apr";
                break;
            case 5:
                return "Mei";
                break;
            case 6:
                return "Jun";
                break;
            case 7:
                return "Jul";
                break;
            case 8:
                return "Ags";
                break;
            case 9:
                return "Sep";
                break;
            case 10:
                return "Okt";
                break;
            case 11:
                return "Nov";
                break;
            case 12:
                return "Des";
                break;
        }
    }
}

if (!function_exists('bulan')) {
    function bulan($bln)
    {
        switch ($bln) {
            case 1:
                return "Januari";
                break;
            case 2:
                return "Februari";
                break;
            case 3:
                return "Maret";
                break;
            case 4:
                return "April";
                break;
            case 5:
                return "Mei";
                break;
            case 6:
                return "Juni";
                break;
            case 7:
                return "Juli";
                break;
            case 8:
                return "Agustus";
                break;
            case 9:
                return "September";
                break;
            case 10:
                return "Oktober";
                break;
            case 11:
                return "November";
                break;
            case 12:
                return "Desember";
                break;
        }
    }
}

/** Longdate Indo Format */
if (!function_exists('longdate_indo')) {
    function longdate_indo($tanggal)
    {
        $ubah = gmdate($tanggal, time() + 60 * 60 * 8);
        $pecah = explode("-", $ubah);
        $tgl = $pecah[2];
        $bln = $pecah[1];
        $thn = $pecah[0];
        $bulan = bulan($pecah[1]);

        $nama = date("l", mktime(0, 0, 0, $bln, $tgl, $thn));
        $nama_hari = "";
        if ($nama == "Sunday") {
            $nama_hari = "Minggu";
        } else if ($nama == "Monday") {
            $nama_hari = "Senin";
        } else if ($nama == "Tuesday") {
            $nama_hari = "Selasa";
        } else if ($nama == "Wednesday") {
            $nama_hari = "Rabu";
        } else if ($nama == "Thursday") {
            $nama_hari = "Kamis";
        } else if ($nama == "Friday") {
            $nama_hari = "Jumat";
        } else if ($nama == "Saturday") {
            $nama_hari = "Sabtu";
        }
        return $nama_hari . ', Tanggal ' . $tgl . ' ' . $bulan . ' ' . $thn;
    }
}

// Passed
if (!function_exists('mediumdate_indo')) {
    function mediumdate_indo($tgl)
    {
        // Validasi awal: pastikan input tidak kosong dan berbentuk tanggal
        if (!$tgl || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $tgl)) {
            return '-'; // Atau return $tgl, atau teks lain
        }

        $pecah = explode("-", $tgl);
        $tanggal = $pecah[2];
        $bulan = bulan($pecah[1]); // pastikan fungsi `bulan()` ada dan benar
        $tahun = $pecah[0];

        return $tanggal . ' ' . $bulan . ' ' . $tahun;
    }
}

/** Format Shortdata indo */
if (!function_exists('shortdate_indo')) {
    function shortdate_indo($tgl)
    {
        if ($tgl == NULL) {
            echo "";
            return false;
        }
        $ubah = gmdate($tgl, time() + 60 * 60 * 8);
        $pecah = explode("-", $ubah);
        $tanggal = $pecah[2];
        $bulan = short_bulan($pecah[1]);
        $tahun = $pecah[0];
        // return $tanggal.'/'.$bulan.'/'.$tahun;
        return $tanggal . '-' . $bulan . '-' . $tahun;
    }
}

//
if (!function_exists('shortdate_indo_3')) {
    function shortdate_indo_3($tgl)
    {
        if ($tgl == NULL) {
            echo "";
            return false;
        }
        $ubah = gmdate($tgl, time() + 60 * 60 * 8);
        $pecah = explode("-", $ubah);
        $tanggal = $pecah[2];
        $bulan = bulan($pecah[1]);
        $tahun = $pecah[0];
        return $tanggal . ' ' . $bulan . ' ' . $tahun;
    }
}

// Format Short Date Indo V4
if (!function_exists('shortdate_indo_4')) {
    function shortdate_indo_4($tgl)
    {
        if ($tgl == NULL) {
            echo "";
            return false;
        }

        $ubah = gmdate($tgl, time() + 60 * 60 * 8);
        $pecah = explode("-", $ubah);
        $tanggal = $pecah[2];
        $bulan = middle_bulan($pecah[1]);
        $tahun = $pecah[0];
        return $tanggal . ' ' . $bulan . ' ' . $tahun;
    }
}

// Format Short Date Indo V5
if (!function_exists('shortdate_indo_5_blank')) {
    function shortdate_indo_5_blank($tgl)
    {
        if ($tgl == NULL) {
            echo "";
            return false;
        }
        $ubah = gmdate($tgl, time() + 60 * 60 * 8);
        $pecah = explode("-", $ubah);
        $tanggal = $pecah[2];
        $bulan = bulan($pecah[1]);
        $tahun = $pecah[0];
        return '   ' . $bulan . ' ' . $tahun;
    }
}

// Function Cek Sumberdana
if (!function_exists('cek_sumberdana')) {
    function cek_sumberdana($id)
    {
        $CI = &get_instance();

        $row = $CI->db->query("SELECT * FROM los_sumberdana WHERE ID_SUMBERDANA = '{$id}'")->row_array();
        return $row['NAMA_SUMBERDANA'];
    }
}

if (!function_exists('cek_sumberdana_3')) {
    function cek_sumberdana_3($id)
    {
        $CI = &get_instance();

        $row = $CI->db->query("SELECT * FROM los_sumberdana_group WHERE ID_SUMBERDANA = '{$id}'")->row_array();
        return $row['NAMA_GROUP_SUMBERDANA'];
    }
}

// Jenis Kredit (Makro / Mikro)
if (!function_exists('cek_jenis_kredit')) {
    function cek_jenis_kredit($jenisKredit)
    {
        switch ($jenisKredit) {
            case 'makro':
                $html = "<div class='p-2 m-b-5 m-t-5 with-rounded-4 sp7-bg-blue-light sp7-border-blue-light'><b><i class='fa fa-chevron-circle-right fa-fw'></i> PEMBIAYAAN MAKRO</b></div>";
                break;
            case 'mikro':
                $html = "<div class='p-2 m-b-5 m-t-5 with-rounded-4 sp7-bg-green-light sp7-border-green-light'><b><i class='fa fa-chevron-circle-right fa-fw'></i> PEMBIAYAAN MIKRO</b></div>";
                break;
            default:
                $html = "<div class='p-2 m-b-5 m-t-5 with-rounded-4 sp7-bg-red-light sp7-border-red-light'><b><i class='fa fa-chevron-circle-right fa-fw'></i> ERROR 404</b> (Hubungi IT)</div>";
                break;
        }

        return $html;
    }
}

/**
 * hitung bunga effektif bank dan koperasi (per tahun)
 * besar_pinjaman 	= plafond pinjaman
 * jangka 			= tenor pinjaman
 * bunga 			= bunga pinjaman (per tahun)
 * */
if (!function_exists('hitung_eff')) {
    function hitung_eff($besar_pinjaman, $jangka, $bunga)
    {
        $bunga_bulan      = ($bunga / 12) / 100;
        $pembagi          = 1 - (1 / pow(1 + $bunga_bulan, $jangka));
        $hasil            = $besar_pinjaman / ($pembagi / $bunga_bulan);
        return $hasil;
    }
}

if (!function_exists('hitung_flat')) {
    function hitung_flat($plafond, $tenor, $rate)
    {
        $rate_bulan = $rate * 100;
        $angsuran_bunga = $plafond * $rate_bulan / 100;
        $angsuran_pokok = $plafond / $tenor;
        $angsuran_bulan = $angsuran_bunga + $angsuran_pokok;

        return $angsuran_bulan;
    }
}

if (!function_exists('idr_format')) {
    function idr_format($angka)
    {
        $jadi     = "Rp. " . number_format($angka, 0, ',', '.');
        return $jadi;
    }
}

/** Fungsi Penyebut Terbilang */
if (!function_exists('penyebut')) {

    function penyebut($nilai)
    {
        $nilai = abs($nilai);
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " " . $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = penyebut($nilai - 10) . " belas";
        } else if ($nilai < 100) {
            $temp = penyebut($nilai / 10) . " puluh" . penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = penyebut($nilai / 100) . " ratus" . penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = penyebut($nilai / 1000) . " ribu" . penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = penyebut($nilai / 1000000) . " juta" . penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = penyebut($nilai / 1000000000) . " milyar" . penyebut(fmod($nilai, 1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = penyebut($nilai / 1000000000000) . " trilyun" . penyebut(fmod($nilai, 1000000000000));
        }
        return $temp;
    }
}

/** Fungsi Terbilang */
if (!function_exists('terbilang')) {

    function terbilang($nilai)
    {
        if ($nilai < 0) {
            $hasil = "minus " . trim(penyebut($nilai));
        } else {
            $hasil = trim(penyebut($nilai));
        }
        return $hasil;
    }
}

// helper informasi status antrian
if (!function_exists('depcreated_status_antrian_pengajuan')) {
    function depcreated_status_antrian_pengajuan($id_pinjaman = NULL)
    {
        $_ci = &get_instance();

        $_ci->db->select("ID_PINJAMAN, ID_DEBITUR, NO_REGISTRASI, NAMA_DEBITUR, STATUS_ANTRIAN_DEBITUR, STATUS_ANTRIAN_OPS, STATUS_VERIFIKASI,STATUS_KEMBALIKAN_VRF, STATUS_APPROVAL, STATUS_ANTRIAN_PENDING, STATUS_CAIR, STATUS_OPS, STATUS_DAFNOM, STATUS_REJECT");
        $_ci->db->from("vw_pinjaman");
        $_ci->db->where("ID_PINJAMAN", $id_pinjaman);
        $row = $_ci->db->get()->row_array();

        if ($row['STATUS_ANTRIAN_DEBITUR'] == 1 && $row['STATUS_ANTRIAN_OPS'] == 1 && $row['STATUS_KEMBALIKAN_VRF'] == 'Y') {
            $cekPos = '<span class="label label-danger f-w-600"> <i class="fa fa-chevron-circle-right fa-fw"></i> KANTOR LAYANAN</span>';
            $cekStatus = '<i class="fas fa-reply-all fa-fw text-danger"></i> DIKEMBALIKAN VERIFIKASI';
        } elseif ($row['STATUS_ANTRIAN_DEBITUR'] == 2 && $row['STATUS_ANTRIAN_OPS'] == 1 && $row['STATUS_VERIFIKASI'] == 'N' && $row['STATUS_KEMBALIKAN_VRF'] == 'N') {
            $cekPos = '<span class="label label-green f-w-600"> <i class="fa fa-chevron-circle-right fa-fw"></i> VERIFIKASI</span>';
            if ($row['STATUS_ANTRIAN_PENDING'] == 1) {
                $cekStatus = '<i class="fas fa-road fa-fw text-info"></i> ON BOARDING';
            } else {
                $cekStatus = '<i class="fas fa-user-check fa-fw text-blue"></i> PROSES VERIFIKASI (CHECKING)';
            }
        } elseif ($row['STATUS_ANTRIAN_DEBITUR'] == 6 && $row['STATUS_ANTRIAN_OPS'] == 1 && $row['STATUS_KEMBALIKAN_VRF'] == 'N') {
            $cekPos = '<span class="label label-green f-w-600"> <i class="fa fa-chevron-circle-right fa-fw"></i> VERIFIKASI</span>';
            if ($row['STATUS_ANTRIAN_PENDING'] == 1) {
                $cekStatus = '<i class="fas fa-question-circle fa-fw text-warning"></i> ON BOARDING';
            } else {
                $cekStatus = '<i class="fas fa-user-clock fa-fw text-warning"></i> PROSES VERIFIKASI (PENDING)';
            }
        } elseif ($row['STATUS_ANTRIAN_DEBITUR'] == 4 && $row['STATUS_ANTRIAN_OPS'] == 1) {
            $cekPos = '<span class="label label-purple f-w-600"> <i class="fa fa-chevron-circle-right fa-fw"></i> APP KREDIT</span>';
            $cekStatus = '<i class="fas fa-user-tag fa-fw text-warning"></i> PROSES TAKE OVER';
        } elseif ($row['STATUS_ANTRIAN_DEBITUR'] == 5 && $row['STATUS_ANTRIAN_OPS'] == 1 && $row['STATUS_VERIFIKASI'] == 'Y' && $row['STATUS_APPROVAL'] == 'Y' && $row['STATUS_CAIR'] == 'Y' && $row['STATUS_OPS'] == 'N' && $row['STATUS_DAFNOM'] == 'N') {
            $cekPos = '<span class="label label-purple f-w-600"> <i class="fa fa-chevron-circle-right fa-fw"></i> APP KREDIT </span>';
            $cekStatus = '<i class="fas fa-user-tag fa-fw text-green"></i> PROSES DAFNOM BANK';
        } elseif ($row['STATUS_ANTRIAN_DEBITUR'] == 5 && $row['STATUS_ANTRIAN_OPS'] == 1 && $row['STATUS_VERIFIKASI'] == 'Y' && $row['STATUS_APPROVAL'] == 'Y' && $row['STATUS_CAIR'] == 'Y' && $row['STATUS_OPS'] == 'N' && $row['STATUS_DAFNOM'] == 'Y') {
            $cekPos = '<span class="label label-purple f-w-600"> <i class="fa fa-chevron-circle-right fa-fw"></i> APP KREDIT </span>';
            $cekStatus = '<i class="fas fa-check-circle fa-fw text-warning"></i> PROSES VALIDASI AKAD';
        } elseif ($row['STATUS_ANTRIAN_DEBITUR'] == 5 && $row['STATUS_ANTRIAN_OPS'] == 1 && $row['STATUS_VERIFIKASI'] == 'Y' && $row['STATUS_APPROVAL'] == 'Y' && $row['STATUS_CAIR'] == 'Y' && $row['STATUS_OPS'] == 'Y' && $row['STATUS_DAFNOM'] == 'N') {
            $cekPos = '<span class="label label-purple f-w-600"> <i class="fa fa-chevron-circle-right fa-fw"></i> APP KREDIT </span>';
            $cekStatus = '<i class="fas fa-user-tag fa-fw text-green"></i> PROSES DAFNOM KE BANK';
        } elseif ($row['STATUS_ANTRIAN_DEBITUR'] == 5 && $row['STATUS_ANTRIAN_OPS'] == 1 && $row['STATUS_VERIFIKASI'] == 'Y' && $row['STATUS_APPROVAL'] == 'Y' && $row['STATUS_CAIR'] == 'Y' && $row['STATUS_OPS'] == 'Y' && $row['STATUS_DAFNOM'] == 'Y') {
            $cekPos = '<span class="label label-primary f-w-600"> <i class="fa fa-chevron-circle-right fa-fw"></i> APPROVAL BANK </span>';
            $cekStatus = '<i class="fas fa-check-circle fa-fw text-green"></i> DISETUJUI OLEH BANK';
        } elseif ($row['STATUS_ANTRIAN_DEBITUR'] == 3 && $row['STATUS_ANTRIAN_OPS'] == 1 && $row['STATUS_VERIFIKASI'] == 'Y' && $row['STATUS_DAFNOM'] == 'N') {
            $cekPos = '<span class="label label-primary f-w-600"> <i class="fa fa-chevron-circle-right fa-fw"></i> APPROVAL BANK </span>';
            $cekStatus = '<i class="fas fa-question-circle fa-fw text-warning"></i> PROSES APPROVAL BANK';
        } elseif ($row['STATUS_ANTRIAN_DEBITUR'] == 3 && $row['STATUS_ANTRIAN_OPS'] == 1 && $row['STATUS_OPS'] == 'Y' && $row['STATUS_CAIR'] == 'Y' && $row['STATUS_DAFNOM'] == 'N') {
            $cekPos = '<span class="label label-purple f-w-600"> <i class="fa fa-chevron-circle-right fa-fw"></i> APP KREDIT</span>';
            $cekStatus = '<i class="fas fa-user-ninja fa-fw text-red"></i> PROSES DAFNOM KE BANK';
        } elseif ($row['STATUS_ANTRIAN_DEBITUR'] == 3 && $row['STATUS_ANTRIAN_OPS'] == 1 && $row['STATUS_OPS'] == 'Y' && $row['STATUS_CAIR'] == 'Y' && $row['STATUS_DAFNOM'] == 'Y') {
            $cekPos = '<span class="label label-primary f-w-600"> <i class="fa fa-chevron-circle-right fa-fw"></i> APPROVAL BANK</span>';

            /// cek status reject bank atau pemeriksaan bank

            if ($row['STATUS_REJECT'] == 'Y') {
                $cekStatus = '<i class="fas fa-times-circle fa-fw text-red"></i> DI REJECT OLEH BANK';
            } else {
                if ($row['STATUS_APPROVAL'] == 'Y' && $row['STATUS_REJECT'] == 'N') {
                    $cekStatus = '<i class="fas fa-check-circle fa-fw text-green"></i> DISETUJUI OLEH BANK';
                } else {
                    $cekStatus = '<i class="fas fa-question-circle fa-fw text-warning"></i> PROSES PEMRIKSAAN BANK';
                }
            }
        } else {
            $cekPos = '<span class="label label-danger f-w-600"> <i class="fa fa-chevron-circle-right fa-fw"></i>404 (BYPASS)</span>';
            $cekStatus = '<i class="fas fa-user-slash fa-fw text-danger"></i> TIDAK ADA DI ANTRIAN 404 (BYPASS)';
        }

        $data = array(
            'cekpos' => $cekPos,
            'cekstatus' => $cekStatus,
        );
        return $data;
    }
}

// Helper informasi status antrian
if (!function_exists('status_antrian_pengajuan')) {
    function status_antrian_pengajuan($id_pinjaman = NULL)
    {
        $_ci = &get_instance();

        $_ci->db->select("ID_PINJAMAN, ID_DEBITUR, NO_REGISTRASI, NAMA_DEBITUR, STATUS_ANTRIAN_DEBITUR, STATUS_ANTRIAN_OPS, STATUS_VERIFIKASI, STATUS_KEMBALIKAN_VRF, STATUS_APPROVAL, STATUS_ANTRIAN_PENDING, STATUS_CAIR, STATUS_OPS, STATUS_DAFNOM, STATUS_REJECT");
        $_ci->db->from("vw_pinjaman");
        $_ci->db->where("ID_PINJAMAN", $id_pinjaman);
        $row = $_ci->db->get()->row_array();

        if (empty($row)) {
            return [
                'cekpos' => '<span class="label label-danger f-w-600"><i class="fa fa-chevron-circle-right fa-fw"></i> DATA TIDAK DITEMUKAN</span>',
                'cekstatus' => '<i class="fas fa-exclamation-triangle fa-fw text-danger"></i> DATA PINJAMAN TIDAK DITEMUKAN'
            ];
        }

        // Mapping status berdasarkan kondisi
        $statusMap = [
            // Dikembalikan verifikasi
            'dikembalikan_vrf' => [
                'condition' => $row['STATUS_ANTRIAN_DEBITUR'] == 1 && $row['STATUS_ANTRIAN_OPS'] == 1 && $row['STATUS_KEMBALIKAN_VRF'] == 'Y',
                'pos' => '<span class="label label-danger f-w-600"><i class="fa fa-chevron-circle-right fa-fw"></i> KANTOR LAYANAN</span>',
                'status' => '<i class="fas fa-reply-all fa-fw text-danger"></i> DIKEMBALIKAN VERIFIKASI'
            ],

            // Proses verifikasi (checking)
            'verifikasi_checking' => [
                'condition' => $row['STATUS_ANTRIAN_DEBITUR'] == 2 && $row['STATUS_ANTRIAN_OPS'] == 1 && $row['STATUS_VERIFIKASI'] == 'N' && $row['STATUS_KEMBALIKAN_VRF'] == 'N',
                'pos' => '<span class="label label-green f-w-600"><i class="fa fa-chevron-circle-right fa-fw"></i> VERIFIKASI</span>',
                'status' => $row['STATUS_ANTRIAN_PENDING'] == 1
                    ? '<i class="fas fa-road fa-fw text-info"></i> ON BOARDING'
                    : '<i class="fas fa-user-check fa-fw text-blue"></i> PROSES VERIFIKASI (CHECKING)'
            ],

            // Proses verifikasi (pending)
            'verifikasi_pending' => [
                'condition' => $row['STATUS_ANTRIAN_DEBITUR'] == 6 && $row['STATUS_ANTRIAN_OPS'] == 1 && $row['STATUS_KEMBALIKAN_VRF'] == 'N',
                'pos' => '<span class="label label-green f-w-600"><i class="fa fa-chevron-circle-right fa-fw"></i> VERIFIKASI</span>',
                'status' => $row['STATUS_ANTRIAN_PENDING'] == 1
                    ? '<i class="fas fa-question-circle fa-fw text-warning"></i> ON BOARDING'
                    : '<i class="fas fa-user-clock fa-fw text-warning"></i> PROSES VERIFIKASI (PENDING)'
            ],

            // Take over
            'take_over' => [
                'condition' => $row['STATUS_ANTRIAN_DEBITUR'] == 4 && $row['STATUS_ANTRIAN_OPS'] == 1,
                'pos' => '<span class="label label-purple f-w-600"><i class="fa fa-chevron-circle-right fa-fw"></i> APP KREDIT</span>',
                'status' => '<i class="fas fa-user-tag fa-fw text-warning"></i> PROSES TAKE OVER'
            ],

            // Dafnom Bank (belum dafnom)
            'dafnom_bank' => [
                'condition' => $row['STATUS_ANTRIAN_DEBITUR'] == 5 && $row['STATUS_ANTRIAN_OPS'] == 1 &&
                    $row['STATUS_VERIFIKASI'] == 'Y' && $row['STATUS_APPROVAL'] == 'Y' &&
                    $row['STATUS_CAIR'] == 'Y' && $row['STATUS_OPS'] == 'N' && $row['STATUS_DAFNOM'] == 'N',
                'pos' => '<span class="label label-purple f-w-600"><i class="fa fa-chevron-circle-right fa-fw"></i> APP KREDIT</span>',
                'status' => '<i class="fas fa-user-tag fa-fw text-green"></i> PROSES DAFNOM BANK'
            ],

            // Validasi akad
            'validasi_akad' => [
                'condition' => $row['STATUS_ANTRIAN_DEBITUR'] == 5 && $row['STATUS_ANTRIAN_OPS'] == 1 &&
                    $row['STATUS_VERIFIKASI'] == 'Y' && $row['STATUS_APPROVAL'] == 'Y' &&
                    $row['STATUS_CAIR'] == 'Y' && $row['STATUS_OPS'] == 'N' && $row['STATUS_DAFNOM'] == 'Y',
                'pos' => '<span class="label label-purple f-w-600"><i class="fa fa-chevron-circle-right fa-fw"></i> APP KREDIT</span>',
                'status' => '<i class="fas fa-check-circle fa-fw text-warning"></i> PROSES VALIDASI AKAD'
            ],

            // Dafnom ke bank (ops Y)
            'dafnom_ke_bank' => [
                'condition' => $row['STATUS_ANTRIAN_DEBITUR'] == 5 && $row['STATUS_ANTRIAN_OPS'] == 1 &&
                    $row['STATUS_VERIFIKASI'] == 'Y' && $row['STATUS_APPROVAL'] == 'Y' &&
                    $row['STATUS_CAIR'] == 'Y' && $row['STATUS_OPS'] == 'Y' && $row['STATUS_DAFNOM'] == 'N',
                'pos' => '<span class="label label-purple f-w-600"><i class="fa fa-chevron-circle-right fa-fw"></i> APP KREDIT</span>',
                'status' => '<i class="fas fa-user-tag fa-fw text-green"></i> PROSES DAFNOM KE BANK'
            ],

            // Disetujui bank (status 5)
            'disetujui_bank_5' => [
                'condition' => $row['STATUS_ANTRIAN_DEBITUR'] == 5 && $row['STATUS_ANTRIAN_OPS'] == 1 &&
                    $row['STATUS_VERIFIKASI'] == 'Y' && $row['STATUS_APPROVAL'] == 'Y' &&
                    $row['STATUS_CAIR'] == 'Y' && $row['STATUS_OPS'] == 'Y' && $row['STATUS_DAFNOM'] == 'Y',
                'pos' => '<span class="label label-primary f-w-600"><i class="fa fa-chevron-circle-right fa-fw"></i> APPROVAL BANK</span>',
                'status' => '<i class="fas fa-check-circle fa-fw text-green"></i> DISETUJUI OLEH BANK'
            ],

            // Approval bank (status 3, dafnom N)
            'approval_bank_3' => [
                'condition' => $row['STATUS_ANTRIAN_DEBITUR'] == 3 && $row['STATUS_ANTRIAN_OPS'] == 1 &&
                    $row['STATUS_VERIFIKASI'] == 'Y' && $row['STATUS_DAFNOM'] == 'N',
                'pos' => '<span class="label label-primary f-w-600"><i class="fa fa-chevron-circle-right fa-fw"></i> APPROVAL BANK</span>',
                'status' => '<i class="fas fa-question-circle fa-fw text-warning"></i> PROSES APPROVAL BANK'
            ],

            // Dafnom ke bank (status 3, ops Y, cair Y, dafnom N)
            'dafnom_bank_3' => [
                'condition' => $row['STATUS_ANTRIAN_DEBITUR'] == 3 && $row['STATUS_ANTRIAN_OPS'] == 1 &&
                    $row['STATUS_OPS'] == 'Y' && $row['STATUS_CAIR'] == 'Y' && $row['STATUS_DAFNOM'] == 'N',
                'pos' => '<span class="label label-purple f-w-600"><i class="fa fa-chevron-circle-right fa-fw"></i> APP KREDIT</span>',
                'status' => '<i class="fas fa-user-ninja fa-fw text-red"></i> PROSES DAFNOM KE BANK'
            ]
        ];

        // Cek kondisi khusus untuk status 3 dengan dafnom Y
        if ($row['STATUS_ANTRIAN_DEBITUR'] == 3 && $row['STATUS_ANTRIAN_OPS'] == 1 && $row['STATUS_OPS'] == 'Y' && $row['STATUS_CAIR'] == 'Y' && $row['STATUS_DAFNOM'] == 'Y') {

            $pos = '<span class="label label-primary f-w-600"><i class="fa fa-chevron-circle-right fa-fw"></i> APPROVAL BANK</span>';

            if ($row['STATUS_REJECT'] == 'Y') {
                $status = '<i class="fas fa-times-circle fa-fw text-red"></i> DI REJECT OLEH BANK';
            } elseif ($row['STATUS_APPROVAL'] == 'Y' && $row['STATUS_REJECT'] == 'N') {
                $status = '<i class="fas fa-check-circle fa-fw text-green"></i> DISETUJUI OLEH BANK';
            } else {
                $status = '<i class="fas fa-question-circle fa-fw text-warning"></i> PROSES PEMERIKSAAN BANK';
            }

            return [
                'cekpos' => $pos,
                'cekstatus' => $status
            ];
        }

        // Loop untuk mengecek kondisi dari mapping
        foreach ($statusMap as $statusData) {
            if ($statusData['condition']) {
                return [
                    'cekpos' => $statusData['pos'],
                    'cekstatus' => $statusData['status']
                ];
            }
        }

        // Default jika tidak ada kondisi yang cocok
        return [
            'cekpos' => '<span class="label label-danger f-w-600"><i class="fa fa-chevron-circle-right fa-fw"></i> 404 (BYPASS)</span>',
            'cekstatus' => '<i class="fas fa-user-slash fa-fw text-danger"></i> TIDAK ADA DI ANTRIAN 404 (BYPASS)'
        ];
    }
}

// get full url with parameters
if (!function_exists('get_fullURL')) {
    function get_fullURL()
    {
        $currentURL = current_url(); //for simple URL
        $params = $_SERVER['QUERY_STRING']; //for parameters
        $fullURL = $currentURL . '?' . $params; //full URL with parameter
        return $fullURL;
    }
}

if (!function_exists('kelengkapan_berkas')) {
    function kelengkapan_berkas($string)
    {
        if ($string == 0) {
            return '<span class="badge badge-warning width-100">PROSES</span>';
        } elseif ($string == 1) {
            return '<span class="badge badge-danger width-100">BELUM LENGKAP</span>';
        } elseif ($string == 2) {
            return '<span class="badge badge-green width-100">LENGKAP</span>';
        } else {
            return 'CALL ADMINISTRATOR !!';
        }
    }
}


if (!function_exists('redirect_alert_js')) {
    function redirect_alert_js($url, $message)
    {
        // Memastikan URL dan pesan tidak kosong
        if (empty($url) || empty($message)) {
            // Tampilkan pesan error atau lakukan tindakan yang sesuai
            echo "URL atau pesan tidak boleh kosong.";
            exit;
        }

        $message = str_replace("'", "\\'", $message); // Escape karakter ' dalam pesan
        $message = str_replace("\n", "\\n", $message); // Mengganti karakter baris baru dengan \n

        echo "<script>";
        echo "alert('" . $message . "');";
        echo "window.location.href = '" . $url . "';";
        echo "</script>";
        exit;
    }
}

if (!function_exists('formatBreakline')) {
    /**
     * Fungsi untuk memformat memo berdasarkan mode
     * 'html' akan menggunakan nl2br, sedangkan 'textarea' hanya htmlspecialchars
     *
     * @param array $memo_data Data memo dalam bentuk array
     * @param string $mode Mode tampilan: 'html' atau 'textarea'
     * @return string Memo yang diformat
     */
    function formatBreakline($memo_data, $mode = 'html')
    {
        $memo = implode("\n", $memo_data);
        return $mode === 'html' ? nl2br(htmlspecialchars($memo)) : htmlspecialchars($memo);
    }
}

if (!function_exists('create_log_proses_user')) {
    function create_log_proses_user($tipe = null, $url = null, $deskripsi = null)
    {
        $CI = &get_instance();

        if ($CI->agent->is_browser()) {
            $agent = $CI->agent->browser() . ' ' . $CI->agent->version();
        } elseif ($CI->agent->is_mobile()) {
            $agent = $CI->agent->mobile();
        } else {
            $agent = 'Undifined';
        }

        $param['ID_USER'] = strtoupper($CI->session->userdata('sess_id_user'));
        $param['TIPE'] = $tipe;
        $param['DESKRIPSI'] = $deskripsi;
        $param['GET_URL'] = $url;
        $param['DATE_AT'] = date('Y-m-d H:i:s');
        $param['BROWSER'] = $agent;
        $param['OS'] = $CI->agent->platform();
        $param['IP_ADDRESS'] = $CI->input->ip_address();

        $CI->db->insert('los_log_hisprosesuser', $param);
    }
}

// Remove Underscore
if (!function_exists('remove_underscore')) {
    function remove_underscore($text)
    {
        return str_replace('_', ' ', $text);
    }
}

// Function Cek File
if (!function_exists('cek_file')) {
    function cek_file($params, $id_pinjaman)
    {
        $CI = &get_instance();

        $CI->load->model('DokumenUploadModel');

        if ($params == 'file_permohonan') {
            $sql = $CI->DokumenUploadModel->get_by_id('ID_PINJAMAN', $id_pinjaman, 'los_upload_permohonan');
            $row = $sql->row_array();
            if ($sql->num_rows() > 0) {
                $icon = '<span class="label label-green">YES</span>';
            } else {
                $icon = '<span class="label label-danger">NO</span>';
            }
        } elseif ($params == 'file_permohonan_bic') {
            $sql = $CI->DokumenUploadModel->get_by_id('ID_PINJAMAN', $id_pinjaman, 'los_upload_permohonan_bic');
            $row = $sql->row_array();
            if ($sql->num_rows() > 0) {
                $icon = '<span class="label label-green">YES</span>';
            } else {
                $icon = '<span class="label label-danger">NO</span>';
            }
        } elseif ($params == 'file_akadbank') {
            $sql = $CI->DokumenUploadModel->get_by_id('ID_PINJAMAN', $id_pinjaman, 'los_upload_akad_bank');
            $row = $sql->row_array();
            if ($sql->num_rows() > 0) {
                $icon = '<span class="label label-green">YES</span>';
            } else {
                $icon = '<span class="label label-danger">NO</span>';
            }
        } elseif ($params == 'file_simulasi') {
            $sql = $CI->DokumenUploadModel->get_by_id('ID_PINJAMAN', $id_pinjaman, 'los_upload_simulasi');
            $row = $sql->row_array();
            if ($sql->num_rows() > 0) {
                $icon = '<span class="label label-green">YES</span>';
            } else {
                $icon = '<span class="label label-danger">NO</span>';
            }
        } elseif ($params == 'file_buktipelunasan') {
            $sql = $CI->DokumenUploadModel->get_by_id('ID_PINJAMAN', $id_pinjaman, 'los_upload_bukti_pelunasan');
            $row = $sql->row_array();
            if ($sql->num_rows() > 0) {
                $icon = '<span class="label label-green">YES</span>';
            } else {
                $icon = '<span class="label label-danger">NO</span>';
            }
        } elseif ($params == 'file_buktimutasi') {
            $sql = $CI->DokumenUploadModel->get_by_id('ID_PINJAMAN', $id_pinjaman, 'los_upload_bukti_mutasi');
            $row = $sql->row_array();
            if ($sql->num_rows() > 0) {
                $icon = '<span class="label label-green">YES</span>';
            } else {
                $icon = '<span class="label label-danger">NO</span>';
            }
        } elseif ($params == 'file_giropos') {
            $sql = $CI->DokumenUploadModel->get_by_id('ID_PINJAMAN', $id_pinjaman, 'los_upload_giropos');
            $row = $sql->row_array();
            if ($sql->num_rows() > 0) {
                $icon = '<span class="label label-green">YES</span>';
            } else {
                $icon = '<span class="label label-danger">NO</span>';
            }
        } elseif ($params == 'file_pencairan') {
            $sql = $CI->DokumenUploadModel->get_by_id('ID_PINJAMAN', $id_pinjaman, 'los_upload_pencairan_file');
            $row = $sql->row_array();
            if ($sql->num_rows() > 0) {
                $icon = '<span class="label label-green">YES</span>';
            } else {
                $icon = '<span class="label label-danger">NO</span>';
            }
        } elseif ($params == 'file_fotopencairan') {
            $sql = $CI->DokumenUploadModel->get_by_id('ID_PINJAMAN', $id_pinjaman, 'los_upload_pencairan_foto');
            $row = $sql->row_array();
            if ($sql->num_rows() > 0) {
                $icon = '<span class="label label-green">YES</span>';
            } else {
                $icon = '<span class="label label-danger">NO</span>';
            }
        } elseif ($params == 'file_skepasli') {
            $sql = $CI->DokumenUploadModel->get_by_id('ID_PINJAMAN', $id_pinjaman, 'los_upload_skep_asli');
            $row = $sql->row_array();
            if ($sql->num_rows() > 0) {
                $icon = '<span class="label label-green">YES</span>';
            } else {
                $icon = '<span class="label label-danger">NO</span>';
            }
        } elseif ($params == 'file_klaimasuransi') {
            $sql = $CI->DokumenUploadModel->get_by_id('ID_PINJAMAN', $id_pinjaman, 'los_upload_klaim_asuransi');
            $row = $sql->row_array();
            if ($sql->num_rows() > 0) {
                $icon = '<span class="label label-green">YES</span>';
            } else {
                $icon = '<span class="label label-danger">NO</span>';
            }
        } elseif ($params == 'file_memo_danatalang_panjar') {
            $sql = $CI->DokumenUploadModel->get_by_id('ID_PINJAMAN', $id_pinjaman, 'los_upload_memo_danatalang_panjar');
            $row = $sql->row_array();
            if ($sql->num_rows() > 0) {
                $icon = '<span class="label label-green">YES</span>';
            } else {
                $icon = '<span class="label label-danger">NO</span>';
            }
        } elseif ($params == 'file_memo_danatalang_pencairan') {
            $sql = $CI->DokumenUploadModel->get_by_id('ID_PINJAMAN', $id_pinjaman, 'los_upload_memo_danatalang_pencairan');
            $row = $sql->row_array();
            if ($sql->num_rows() > 0) {
                $icon = '<span class="label label-green">YES</span>';
            } else {
                $icon = '<span class="label label-danger">NO</span>';
            }
        } elseif ($params == 'file_memo_danatalang_takeover') {
            $sql = $CI->DokumenUploadModel->get_by_id('ID_PINJAMAN', $id_pinjaman, 'los_upload_memo_danatalang_takeover');
            $row = $sql->row_array();
            if ($sql->num_rows() > 0) {
                $icon = '<span class="label label-green">YES</span>';
            } else {
                $icon = '<span class="label label-danger">NO</span>';
            }
        } elseif ($params == 'file_memo_mutasi') {
            $sql = $CI->DokumenUploadModel->get_by_id('ID_PINJAMAN', $id_pinjaman, 'los_upload_memo_mutasi');
            $row = $sql->row_array();
            if ($sql->num_rows() > 0) {
                $icon = '<span class="label label-green">YES</span>';
            } else {
                $icon = '<span class="label label-danger">NO</span>';
            }
        } elseif ($params == 'file_memo_sisapencairan') {
            $sql = $CI->DokumenUploadModel->get_by_id('ID_PINJAMAN', $id_pinjaman, 'los_upload_memo_sisapencairan');
            $row = $sql->row_array();
            if ($sql->num_rows() > 0) {
                $icon = '<span class="label label-green">YES</span>';
            } else {
                $icon = '<span class="label label-danger">NO</span>';
            }
        } else {
            $icon = '<i class="fas fa-exclamation-triangle text-danger"></i>';
        }
        return $icon;
    }
}

if (!function_exists('convert_case')) {
    function convert_case($string)
    {
        return $string = ucwords(strtolower($string));
    }
}

/**
 * Fungsi ini digunakan untuk menyimpan tanggal ke dalam database
 * dengan format yyyy-mm-dd
 *
 * @param string $date Tanggal yang akan disimpan
 * @return string Tanggal dalam format yyyy-mm-dd
 */
if (!function_exists('saveDatetoDB')) {
    function saveDatetoDB($date)
    {
        if (empty($date)) {
            return NULL; // kembalikan NULL jika parameter tidak ada atau kosong
        }

        $date_array = explode('-', $date); // memecah tanggal dengan delimiter '-'
        if (count($date_array) == 3 && checkdate($date_array[1], $date_array[0], $date_array[2])) {
            // Pastikan tanggal valid menggunakan checkdate
            $new_date = $date_array[2] . '-' . $date_array[1] . '-' . $date_array[0]; // format baru yyyy-mm-dd
            return $new_date;
        } else {
            return NULL; // tanggal tidak valid, kembalikan NULL
        }
    }
}

/**
 * Parse Usia Masuk
 *
 * @param string $usiaMasuk String usia masuk dengan format "tahun.bulan"
 * @return array Array yang berisi tahun dan bulan dari usia masuk
 */
if (!function_exists('getParseUsia')) {
    function getParseUsia($usiaMasuk)
    {
        list($usiaTahun, $usiaBulan) = explode('.', $usiaMasuk);

        return array('tahun' => $usiaTahun, 'bulan' => $usiaBulan);
    }
}

/**
 * Get RT and RW from the address string.
 *
 * @param string $address The address string (e.g., '001/002').
 * @return array An associative array containing 'rt' and 'rw' keys.
 */
if (!function_exists('getRtRwFromAddress')) {
    function getRtRwFromAddress($address)
    {
        $result = [
            'rt' => '',
            'rw' => ''
        ];

        $explodedAddress = explode('/', $address);

        if (count($explodedAddress) === 2) {
            $result['rt'] = str_pad($explodedAddress[0], 3, '0', STR_PAD_LEFT);
            $result['rw'] = str_pad($explodedAddress[1], 3, '0', STR_PAD_LEFT);
        }

        return $result;
    }
}

if (!function_exists('remove_comma')) {
    function remove_comma($a)
    {
        $a = str_replace(',', '', $a);
        return $a;
    }
}

if (!function_exists('calculate_percentage')) {
    function calculate_percentage($parameter1, $parameter2, $precision = 0)
    {
        if ($parameter1 == 0) {
            return 0; // Menghindari pembagian oleh nol
        }

        $percentage = ($parameter2 / $parameter1) * 100;
        return round($percentage, $precision) . '%';
    }
}

// Remove prefix (,)
if (!function_exists('removeCurrencyDot')) {
    function removeCurrencyDot($string)
    {
        return str_replace(',', '', $string);
    }
}

// Calculate biaya New eDapem
if (!function_exists('calculateNED')) {
    function calculateNED($idInstansi)
    {
        if ($idInstansi == '1') {
            $nominalNED = 5550;
        } elseif ($idInstansi == '2') {
            $nominalNED = 4000;
        } else {
            $nominalNED = 0;
        }
        return $nominalNED;
    }
}

if (!function_exists('nama_user')) {
    function nama_user($id)
    {
        $CI = &get_instance();

        $row = $CI->db->query("SELECT * FROM vw_authentikasi WHERE ID_USER = '{$id}'")->row_array();
        return $row['NAMA_USER'];
    }
}

if (!function_exists('nama_user_login')) {
    function nama_user_login($id)
    {
        $CI = &get_instance();

        $row = $CI->db->query("SELECT * FROM vw_authentikasi WHERE ID_LOGIN = '{$id}'")->row_array();
        return ucwords(strtolower($row['NAMA_USER']));
    }
}

if (!function_exists('info_deb')) {
    function info_deb($id_pinjaman)
    {
        $CI = &get_instance();
        $CI->load->model('ApprovalBankModel');
        $q = $CI->ApprovalBankModel->get_info_deb($id_pinjaman);
        $html = '';
        $html .= '<i class="far fa-caret-square-right text-muted"></i> <b class="text-black">NO REGISTRASI : </b>' . $q['NO_REGISTRASI'] . '<br>';
        $html .= '<i class="far fa-caret-square-right text-muted"></i> <b class="text-black">NAMA DEBITUR : </b>' . $q['NAMA_DEBITUR'] . '<br>';
        $html .= '<i class="far fa-caret-square-right text-muted"></i> <b class="text-black">NIK KTP : </b>' . $q['NIK_KTP'] . '<br>';
        $html .= '<i class="far fa-caret-square-right text-muted"></i> <b class="text-black">NO PENSIUN : </b>' . $q['NO_PENSIUN'] . '<br>';
        $html .= '<i class="far fa-caret-square-right text-muted"></i> <b class="text-black">KANTOR LAYANAN  : </b>' . $q['NAMA_CABANG'] . '<br>';
        $html .= '<i class="far fa-caret-square-right text-muted"></i> <b class="text-black">PLAFOND  : </b>' . number_format($q['PLAFOND']) . '<br>';
        $html .= '<i class="far fa-caret-square-right text-muted"></i> <b class="text-black">PRODUK  : </b>' . $q['DESKRIPSI_PRODUK'];
        return $html;
    }
}

if (!function_exists('info_rincian_gaji')) {
    function info_rincian_gaji($id_pinjaman)
    {
        $CI = &get_instance();
        $CI->db->where('ID_PINJAMAN', $id_pinjaman);
        $q = $CI->db->get('vw_pinjaman')->row_array();

        $output = '';
        $output .= '
		<div class="row">
			<div class="col-md-4">
				<table class="table table-condensed bg-grey-transparent-1">
					<thead>
						<tr class="">
							<th><b class="f-w-700">RINCIAN PENDAPATAN GAJI</b></th>
							<th class="text-right f-s-9"><b class="f-w-400"> <i class="fa fa-calendar fa-fw"></i> ' . strtoupper(shortdate_indo_5_blank($q['TANGGAL_PENGAJUAN'])) . '</b></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class=""><i class="fa fa-chevron-circle-right text-success"></i> POKOK PENSIUN</td>
							<td class="text-right">' . number_format($q['PD_POKOK_PENSIUN']) . '</td>
						</tr>
						<tr>
							<td class=""><i class="fa fa-chevron-circle-right text-success"></i> TUNJANGAN ISTRI</td>
							<td class="text-right">' . number_format($q['PD_TUN_ISTRI']) . '</td>
						</tr>
						<tr>
							<td class=""><i class="fa fa-chevron-circle-right text-success"></i> TUNJANGAN ANAK</td>
							<td class="text-right">' . number_format($q['PD_TUN_ANAK']) . '</td>
						</tr>
						<tr>
							<td class=""><i class="fa fa-chevron-circle-right text-success"></i> TUNJANGAN DAHOR</td>
							<td class="text-right">' . number_format($q['PD_TUN_DAHOR']) . '</td>
						</tr>
						<tr>
							<td class=""><i class="fa fa-chevron-circle-right text-success"></i> TUNJANGAN BERAS</td>
							<td class="text-right">' . number_format($q['PD_TUN_BERAS']) . '</td>
						</tr>
						<tr>
							<td class=""><i class="fa fa-chevron-circle-right text-success"></i> TUNJANGAN CACAT</td>
							<td class="text-right">' . number_format($q['PD_TUN_CACAT']) . '</td>
						</tr>
						<tr>
							<td class=""><i class="fa fa-chevron-circle-right text-success"></i> TPP</td>
							<td class="text-right">' . number_format($q['PD_TPP']) . '</td>
						</tr>
						<tr>
							<td class=""><i class="fa fa-chevron-circle-right text-success"></i> TPM</td>
							<td class="text-right">' . number_format($q['PD_TPM']) . '</td>
						</tr>
						<tr>
							<td class=""><i class="fa fa-chevron-circle-right text-success"></i> TKD</td>
							<td class="text-right">' . number_format($q['PD_TKD']) . '</td>
						</tr>
						<tr>
							<td class=""><i class="fa fa-chevron-circle-right text-success"></i> PPH Pasal 21</td>
							<td class="text-right">' . number_format($q['PD_TUN_PPH21']) . '</td>
						</tr>
						<tr>
							<td class=""><i class="fa fa-chevron-circle-right text-success"></i> PEMBULATAN</td>
							<td class="text-right">' . number_format($q['PD_PEMBULATAN']) . '</td>
						</tr>
					</tbody>
					<tfoot>
						<tr class="">
							<th><b class="f-w-700">JUMLAH</b></th>
							<th class="text-right"><b class="f-w-700">' . number_format($q['PD_JUMLAH']) . '</b></th>
						</tr>
					</tfoot>
				</table>
			</div>
			<div class="col-md-4">
				<table class="table table-condensed bg-grey-transparent-1">
					<thead>
						<tr class="">
							<th><b class="f-w-700">RINCIAN POTONGAN GAJI</b></th>
							<th class="text-right"></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class=""><i class="fa fa-chevron-circle-right text-success"></i> PPH Pasal 21</td>
							<td class="text-right">' . number_format($q['PO_PPH21']) . '</td>
						</tr>
						<tr>
							<td class=""><i class="fa fa-chevron-circle-right text-success"></i> ASKES</td>
							<td class="text-right">' . number_format($q['PO_ASKSES']) . '</td>
						</tr>
						<tr>
							<td class=""><i class="fa fa-chevron-circle-right text-success"></i> ASSOS</td>
							<td class="text-right">' . number_format($q['PO_ASSOS']) . '</td>
						</tr>
						<tr>
							<td class=""><i class="fa fa-chevron-circle-right text-success"></i> KASDA</td>
							<td class="text-right">' . number_format($q['PO_KASDA']) . '</td>
						</tr>
						<tr>
							<td class=""><i class="fa fa-chevron-circle-right text-success"></i> KPKN</td>
							<td class="text-right">' . number_format($q['PO_KPKN']) . '</td>
						</tr>
						<tr>
							<td class=""><i class="fa fa-chevron-circle-right text-success"></i> ALIMENTASI</td>
							<td class="text-right">' . number_format($q['PO_ALIMENTASI']) . '</td>
						</tr>
						<tr>
							<td class=""><i class="fa fa-chevron-circle-right text-success"></i> SEWA RUMAH</td>
							<td class="text-right">' . number_format($q['PO_SEWARUMAH']) . '</td>
						</tr>
						<tr>
							<td class=""><i class="fa fa-chevron-circle-right text-success"></i> GANTI RUGI</td>
							<td class="text-right">' . number_format($q['PO_GANTIRUGI']) . '</td>
						</tr>
					</tbody>
					<tfoot>
						<tr class="">
							<th><b class="f-w-700">JUMLAH</b></th>
							<th class="text-right">' . number_format($q['PO_JUMLAH']) . '</th>
						</tr>
					</tfoot>
				</table>
			</div>
			<div class="col-md-4">
				<table class="table table-condensed bg-grey-transparent-1">
					<thead>
						<tr class="">
							<th><b class="f-w-700">RINCIAN GAJI BERSIH</b></th>
							<th class="text-right"></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class=""><i class="fa fa-chevron-circle-right text-success"></i> JUMLAH PENDAPATAN</td>
							<td class="text-right">' . number_format($q['PD_JUMLAH']) . '</td>
						</tr>
						<tr>
							<td class=""><i class="fa fa-chevron-circle-right text-success"></i> JUMLAH POTONGAN</td>
							<td class="text-right">' . number_format($q['PO_JUMLAH']) . '</td>
						</tr>
					</tbody>
					<tfoot>
						<tr class="">
							<th><b class="f-w-700">TOTAL GAJI BERSIH</b></th>
							<th class="text-right">' . number_format($q['PO_TOTALBERSIH']) . '</th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>';
        return $output;
    }
}

/**
 * jika input cabang lebih dari atau sama dengan jam 16.00,
 * simpan antrian ke onboarding dan ubah status antrian pending nya = 1
 * */
if (!function_exists('update_pending_by_id')) {
    function update_pending_by_id($id)
    {
        $ci = &get_instance();

        $currentTime = strtotime(date('H:i'));
        $startTime = strtotime('00.00');
        $endTime = strtotime('15.00');

        if ($currentTime >= $startTime && $currentTime <= $endTime) {
            $ci->db->where(['ID_PINJAMAN' => $id]);
            $ci->db->update('los_debitur_pinjaman', ['STATUS_ANTRIAN_PENDING' => 0]);
        } else {
            $ci->db->where(['ID_PINJAMAN' => $id]);
            $ci->db->update('los_debitur_pinjaman', ['STATUS_ANTRIAN_PENDING' => 1]);
        }
    }
}

// helper informasi upload
// 2023-02-11 12:41:42
if (!function_exists('helpinfo_upload')) {
    function helpinfo_upload()
    {
        $output     = '	<dl class="dl-horizontal">
                        <dt class="text-inverse">Jika file yang sudah di upload tidak berubah, bisa melakukan langkah di bawah</dt>
                        <dd>
                            <i class="fas fa-check-square"></i> <b class="text-red">[STEP 1]</b> Pastikan file yang akan di upload sudah benar <br>
                            <i class="fas fa-check-square"></i> <b class="text-red">[STEP 2]</b> Tekan <b>Ctrl + Shit + R</b> pada keyboard <br>
                            <i class="fas fa-check-square"></i> <b class="text-red">[STEP 3]</b> Bersihkan Cache browser yang tersimpan atau install extension browser, cek informasi dibawah
                        </dd>
                        <dt class="text-inverse">Extension Browser</dt>
                        <dd>
                            <i class="fab fa-chrome"></i> Pengguna Google Chrome (<a href="https://chrome.google.com/webstore/detail/clear-cache/cppjkneekbjaeellbfkmgnhonkkjfpdn?hl=en" target="_blank">Extension Clear Cache</a>) <br>
                            <i class="fab fa-firefox"></i> Pengguna Firefox (<a href="https://addons.mozilla.org/en-US/firefox/addon/clearcache/" target="_blank">Extension Clear Cache</a>)
                        </dd>
                    </dl>';
        return $output;
    }
}

// Helper Nama Cabang form KODE CABANG
if (!function_exists('nama_cabang')) {
    /* Role 1-99 */
    function nama_cabang($kode_cabang)
    {
        $ci = &get_instance();
        $ci->db->where('KODE_CABANG', $kode_cabang);
        $query = $ci->db->get('los_cabang');

        if ($query->num_rows() > 0) {
            $result = $query->row();
            return $result->NAMA_CABANG;
        } else {
            return null;
        }
    }
}

/** cari nama instansi berdasarkan id */
if (!function_exists('get_nama_cabang')) {

    function get_nama_cabang($kode_cabang)
    {
        $ci = get_instance();

        $ci->db->where('KODE_CABANG', $kode_cabang);
        $data = $ci->db->get('los_cabang')->row_array();

        $result = $data['DESKRIPSI_CABANG'];
        return $result;
    }
}

/** cari nama user berdasarkan id */
if (!function_exists('getname_user_id')) {

    function getname_user_id($id)
    {
        $ci = get_instance();
        $ci->db->where('ID_USER', $id);
        $data = $ci->db->get('los_users')->row_array();

        $result = $data['NAMA_USER'];
        return $result;
    }
}

// helper ambil nama jenis_biaya berdasarkan id
if (!function_exists('getname_jenisbiaya_id')) {

    function getname_jenisbiaya_id($id)
    {
        $ci = get_instance();
        $ci->db->where('ID_JENIS_BIAYA', $id);
        $data = $ci->db->get('los_jenis_biaya')->row_array();

        $result = $data['NAMA_JENIS_BIAYA'];
        return $result;
    }
}

// helper ambil nama marketing berdasarkan id
if (!function_exists('nama_marketing_by')) {
    function nama_marketing_by($id)
    {
        $ci = get_instance();
        $ci->db->where('ID_KARYAWAN', $id);
        $data = $ci->db->get('los_karyawan')->row_array();

        $result = $data['NAMA_KARYAWAN'];
        return $result;
    }
}

// helper ambil fee marketing berdasarkan id
if (!function_exists('fee_marketing')) {
    function fee_marketing($id)
    {
        $ci = get_instance();
        $ci->db->where('ID_KARYAWAN', $id);
        $data = $ci->db->get('los_karyawan')->row_array();

        $result = $data['is_fee'];
        return $result;
    }
}

if (!function_exists('cmb_role_refkaryawan')) {
    function cmb_role_refkaryawan($name, $id = null, $pk, $selected = null)
    {
        $ci = get_instance();
        $cmb = "<select name='$name' id='$id' class='select2 form-control form-control-sm custom-select'>";

        $sql = "SELECT * FROM los_karyawan_roles WHERE ID_ROLE IN ('1','2','3') ORDER BY ID_ROLE ASC";
        $data = $ci->db->query($sql)->result();

        $cmb .= "<option value=''> -- Pilih Role -- </option>";
        foreach ($data as $d) {
            $cmb .= "<option value='" . $d->$pk . "'";
            $cmb .= $selected == $d->$pk ? " selected='selected'" : '';
            $cmb .= ">" . strtoupper($d->NAMA_ROLE) . "</option>";
        }
        $cmb .= "</select>";
        return $cmb;
    }
}

if (!function_exists('cmb_cabang')) {
    function cmb_cabang($name, $id = null, $pk, $selected = null)
    {
        $ci = get_instance();
        $cmb = "<select name='$name' id='$id' class='select2 form-control form-control-sm custom-select'>";

        $sql = "SELECT * FROM los_cabang WHERE ID_GROUP_CABANG IN ('1','2') ORDER BY KODE_CABANG ASC";
        $data = $ci->db->query($sql)->result();

        $cmb .= "<option value=''> -- Pilih Cabang -- </option>";
        foreach ($data as $d) {
            $cmb .= "<option value='" . $d->$pk . "'";
            $cmb .= $selected == $d->$pk ? " selected='selected'" : '';
            $cmb .= ">" . strtoupper($d->DESKRIPSI_CABANG . ' (' . $d->KODE_CABANG . ')') . "</option>";
        }
        $cmb .= "</select>";
        return $cmb;
    }
}

if (!function_exists('cmb_refcabang')) {
    function cmb_refcabang($name, $id = null, $pk, $selected = null)
    {
        $ci = get_instance();
        $cmb = "<select name='$name' id='$id' class='select2 form-control form-control-sm custom-select'>";

        $sql = "SELECT * FROM los_cabang ORDER BY KODE_CABANG ASC";
        $data = $ci->db->query($sql)->result();

        $cmb .= "<option value=''> -- Pilih Cabang / Mitra -- </option>";
        foreach ($data as $d) {
            $cmb .= "<option value='" . $d->$pk . "'";
            $cmb .= $selected == $d->$pk ? " selected='selected'" : '';
            $cmb .= ">" . ' (' . $d->KODE_CABANG . ') ' . strtoupper($d->DESKRIPSI_CABANG) . "</option>";
        }
        $cmb .= "</select>";
        return $cmb;
    }
}

if (!function_exists('cmb_getUser')) {
    function cmb_getUser($name, $id = null, $pk, $selected = null)
    {
        $ci = get_instance();
        $cmb = "<select name='$name' id='$id' class='select2 form-control form-control-sm custom-select'>";

        $sql = "SELECT * FROM los_users WHERE STATUS_USER = 'Y' ORDER BY ID_USER DESC";
        $data = $ci->db->query($sql)->result();

        $cmb .= "<option value=''> -- Pilih User ID -- </option>";
        foreach ($data as $d) {
            $cmb .= "<option value='" . $d->$pk . "'";
            $cmb .= $selected == $d->$pk ? " selected='selected'" : '';
            $cmb .= ">" . ' (' . $d->ID_USER . ') ' . strtoupper($d->NAMA_USER) . "</option>";
        }
        $cmb .= "</select>";
        return $cmb;
    }
}


if (!function_exists('cmb_role_ref')) {
    function cmb_role_ref($name, $id = null, $pk, $selected = null)
    {
        $ci = get_instance();
        $cmb = "<select name='$name' id='$id' class='form-control form-control-sm custom-select'>";

        $sql = "SELECT * FROM los_roles ORDER BY ID_ROLE ASC";
        $data = $ci->db->query($sql)->result();

        $cmb .= "<option value=''> -- Pilih Role ID -- </option>";
        foreach ($data as $d) {
            $cmb .= "<option value='" . $d->$pk . "'";
            $cmb .= $selected == $d->$pk ? " selected='selected'" : '';
            $cmb .= ">" . strtoupper($d->NAMA_ROLE) . "</option>";
        }
        $cmb .= "</select>";
        return $cmb;
    }
}

//  Generate Id Karyawan
if (!function_exists('generate_karyawanID')) {
    function generate_karyawanID()
    {
        $ci = &get_instance();

        // Ambil 7 digit terakhir dari ID_KARYAWAN terbaru
        $ci->db->select('RIGHT(ID_KARYAWAN, 5) AS KODE', FALSE);
        $ci->db->order_by('ID_KARYAWAN', 'DESC');
        $ci->db->limit(1);
        $query = $ci->db->get('los_karyawan');  // Ganti dengan nama tabel karyawan kamu

        if ($query->num_rows() <> 0) {
            # Jika ada ID, ambil nomor terakhir dan tambah 1
            $data = $query->row();
            $kode = intval($data->KODE) + 1;
        } else {
            $kode = 1;  # Jika belum ada data, mulai dari 1
        }

        // Format ID dengan panjang 7 digit di belakang
        $auto_increment = str_pad($kode, 5, "0", STR_PAD_LEFT);

        // Gabungkan dengan angka 3 di depan
        $newID = '3' . $auto_increment;

        return $newID;
    }
}

// Generate UserId
if (!function_exists('generate_userID')) {
    function generate_userID()
    {
        $ci = &get_instance();

        // Ambil 7 digit terakhir dari ID_LOGIN terbaru
        $ci->db->select('RIGHT(ID_USER, 6) AS KODE', FALSE);
        $ci->db->order_by('ID_USER', 'DESC');
        $ci->db->limit(1);
        $query = $ci->db->get('los_users');

        if ($query->num_rows() <> 0) {
            # Jika ada ID, ambil nomor terakhir dan tambah 1
            $data = $query->row();
            $kode = intval($data->KODE) + 1;
        } else {
            $kode = 1;  # Jika belum ada data, mulai dari 1
        }

        // Format ID dengan panjang 7 digit di belakang
        $auto_increment = str_pad($kode, 6, "0", STR_PAD_LEFT);

        return $auto_increment;
    }
}

// generate login id
if (!function_exists('generate_loginID')) {
    function generate_loginID()
    {
        $ci = &get_instance();

        // Ambil 7 digit terakhir dari ID_USER terbaru
        $ci->db->select('RIGHT(ID_LOGIN, 5) AS KODE', FALSE);
        $ci->db->order_by('ID_LOGIN', 'DESC');
        $ci->db->limit(1);
        $query = $ci->db->get('los_login');

        if ($query->num_rows() <> 0) {
            # Jika ada ID, ambil nomor terakhir dan tambah 1
            $data = $query->row();
            $kode = intval($data->KODE) + 1;
        } else {
            $kode = 1;  # Jika belum ada data, mulai dari 1
        }

        // Format ID dengan panjang 7 digit di belakang
        $auto_increment = str_pad($kode, 5, "0", STR_PAD_LEFT);

        // Gabungkan dengan angka 2 di depan
        $newID = '2' . $auto_increment;

        return $newID;
    }
}

// helper nama user by id
if (!function_exists('get_name_iduser')) {
    function get_name_iduser($id_user)
    {
        $CI = &get_instance();

        $row = $CI->db->query("SELECT NAMA_USER FROM vw_authentikasi WHERE ID_USER = '{$id_user}' LIMIT 1 ")->row_array();
        return $row['NAMA_USER'];
    }
}

// helper nama karyawan by id
if (!function_exists('nama_karyawan')) {
    function nama_karyawan($id)
    {
        $CI = &get_instance();

        $row = $CI->db->query("SELECT NAMA_KARYAWAN FROM los_karyawan WHERE ID_KARYAWAN = '{$id}' LIMIT 1 ")->row_array();
        return $row['NAMA_KARYAWAN'];
    }
}

// helper operator cell
if (!function_exists('operator_cell')) {

    function operator_cell($params)
    {
        $var_str = substr($params, 0, 4);

        if ($var_str == '0812' || $var_str == '0813' || $var_str == '0821' || $var_str == '0822') {
            $operator = 'Telkomsel';
        } elseif ($var_str == '0811') {
            $operator = 'Kartu Halo';
        } elseif ($var_str == '0896') {
            $operator = 'Three';
        } else {
            $operator = 'Undefined';
        }
        return $operator;
    }
}

# cek status antrian dan posisi antrian
# 2023-02-07 14:25:11
if (!function_exists('statuscek_antrian')) {

    function statuscek_antrian($id = NULL)
    {
        $ci = get_instance();

        $sqlSelect = "ID_PINJAMAN,
					  NO_REGISTRASI,
					  NO_KREDIT,
					  NAMA_DEBITUR,
					  STATUS_ANTRIAN_DEBITUR,
					  STATUS_ANTRIAN_OPS,
					  STATUS_KEMBALIKAN_VRF,
					  STATUS_OPS,
					  STATUS_CAIR,
					  STATUS_DAFNOM,
					  STATUS_ANTRIAN_PENDING,
					  STATUS_REJECT,
					  STATUS_APPROVAL";
        $ci->db->select($sqlSelect);
        $ci->db->from("vw_pinjaman");
        $ci->db->where('ID_PINJAMAN', $id);
        $data = $ci->db->get()->row();

        if ($data->STATUS_ANTRIAN_DEBITUR == 1 && $data->STATUS_ANTRIAN_OPS == 1 && $data->STATUS_KEMBALIKAN_VRF == 'Y') {
            $cekPos = '<span class="label label-danger f-w-600"> <i class="fa fa-chevron-circle-right fa-fw"></i> KANTOR LAYANAN</span>';
            $cekPos_nolabel = 'KANTOR LAYANAN';

            $cekStatus = '<i class="fas fa-reply-all fa-fw text-danger"></i> DIKEMBALIKAN VERIFIKASI';
            $cekStatus_nolabel = 'DIKEMBALIKAN VERIFIKASI';
        } elseif ($data->STATUS_ANTRIAN_DEBITUR == 2 && $data->STATUS_ANTRIAN_OPS == 1 && $data->STATUS_KEMBALIKAN_VRF == 'N') {
            $cekPos = '<span class="label label-green f-w-600"> <i class="fa fa-chevron-circle-right fa-fw"></i> VERIFIKASI</span>';
            $cekPos_nolabel = 'VERIFIKASI';

            if ($data->STATUS_ANTRIAN_PENDING == 1) {
                $cekStatus = '<i class="fas fa-road fa-fw text-info"></i> ON BOARDING';
                $cekStatus_nolabel = 'ON BOARDING';
            } else {
                $cekStatus = '<i class="fas fa-user-check fa-fw text-blue"></i> PROSES VERIFIKASI (CHECKING)';
                $cekStatus_nolabel = 'PROSES VERIFIKASI (CHECKING)';
            }
        } elseif ($data->STATUS_ANTRIAN_DEBITUR == 6 && $data->STATUS_ANTRIAN_OPS == 1 && $data->STATUS_KEMBALIKAN_VRF == 'N') {
            $cekPos = '<span class="label label-green f-w-600"> <i class="fa fa-chevron-circle-right fa-fw"></i> VERIFIKASI</span>';
            $cekPos_nolabel = 'VERIFIKASI';

            if ($data->STATUS_ANTRIAN_PENDING == 1) {
                $cekStatus = '<i class="fas fa-question-circle fa-fw text-warning"></i> ON BOARDING';
                $cekStatus_nolabel = 'ON BOARDING';
            } else {
                $cekStatus = '<i class="fas fa-user-clock fa-fw text-warning"></i> PROSES VERIFIKASI (PENDING)';
                $cekStatus_nolabel = 'PROSES VERIFIKASI (PENDING)';
            }
        } elseif ($data->STATUS_ANTRIAN_DEBITUR == 4 && $data->STATUS_ANTRIAN_OPS == 1) {
            $cekPos = '<span class="label label-purple f-w-600"> <i class="fa fa-chevron-circle-right fa-fw"></i> APP KREDIT</span>';
            $cekPos_nolabel = 'APP KREDIT';

            $cekStatus = '<i class="fas fa-user-tag fa-fw text-warning"></i> PROSES TAKE OVER';
            $cekStatus_nolabel = 'PROSES TAKE OVER';
        } elseif ($data->STATUS_ANTRIAN_DEBITUR == 5 && $data->STATUS_ANTRIAN_OPS == 1 && $data->STATUS_OPS == 'N') {
            $cekPos = '<span class="label label-purple f-w-600"> <i class="fa fa-chevron-circle-right fa-fw"></i> APP KREDIT</span>';
            $cekPos_nolabel = 'APP KREDIT';

            $cekStatus = '<i class="fas fa-user-tag fa-fw text-green"></i> PROSES UPLOAD AKAD';
            $cekStatus_nolabel = 'PROSES UPLOAD AKAD';
        } elseif ($data->STATUS_ANTRIAN_DEBITUR == 5 && $data->STATUS_ANTRIAN_OPS == 5 && $data->STATUS_OPS == 'Y' && $data->STATUS_CAIR == 'Y' && $data->STATUS_DAFNOM == 'N') {
            $cekPos = '<span class="label label-purple f-w-600"> <i class="fa fa-chevron-circle-right fa-fw"></i> APP KREDIT</span>';
            $cekPos_nolabel = 'APP KREDIT';

            $cekStatus = '<i class="fas fa-user-ninja fa-fw text-red"></i> PROSES DAFNOM KE BANK';
            $cekStatus_nolabel = 'PROSES DAFNOM KE BANK';
        } elseif ($data->STATUS_ANTRIAN_DEBITUR == 5 && $data->STATUS_ANTRIAN_OPS == 5 && $data->STATUS_OPS == 'Y' && $data->STATUS_CAIR == 'Y' && $data->STATUS_DAFNOM == 'Y') {
            $cekPos = '<span class="label label-primary f-w-600"> <i class="fa fa-chevron-circle-right fa-fw"></i> APPROVAL BANK</span>';
            $cekPos_nolabel = 'APPROVAL BANK';

            /// cek status reject bank atau pemeriksaan bank
            /// 2023-01-26 18:11:35

            if ($data->STATUS_REJECT == 'Y') {
                $cekStatus = '<i class="fas fa-times-circle fa-fw text-red"></i> DI REJECT OLEH BANK';
                $cekStatus_nolabel = 'DI REJECT OLEH BANK';
            } else {
                if ($data->STATUS_APPROVAL == 'Y' && $data->STATUS_REJECT == 'N') {
                    $cekStatus = '<i class="fas fa-check-circle fa-fw text-green"></i> DISETUJUI OLEH BANK';
                    $cekStatus_nolabel = 'DISETUJUI OLEH BANK';
                } else {
                    $cekStatus = '<i class="fas fa-question-circle fa-fw text-warning"></i> PROSES PEMERIKSAAN BANK';
                    $cekStatus_nolabel = 'PROSES PEMERIKSAAN BANK';
                }
            }
        } else {
            $cekPos = '<i class="fas fa-user-slash fa-fw text-red"></i> TIDAK ADA DI ANTRIAN 404 (BYPASS)';
            $cekPos_nolabel = '<i class="fas fa-user-slash fa-fw text-red"></i> 404 (BYPASS)';

            $cekStatus = '<i class="fas fa-user-slash fa-fw text-red"></i> TIDAK ADA DI ANTRIAN 404 (BYPASS)';
            $cekStatus_nolabel = '<i class="fas fa-user-slash fa-fw text-red"></i> (BYPASS)';
        }

        # array to object
        # 2023-02-07 14:37:52
        $return = (object)array(
            'cekAntrian' => $cekPos,
            'cekAntrian_nolabel' => $cekPos_nolabel,
            'cekStatus' => $cekStatus,
            'cekStatus_nolabel' => $cekStatus_nolabel,
        );

        # callback
        #
        return $return;
    }
}

// Hitung usia saat pengajuan
if (!function_exists('usia_saat_pengajuan')) {
    function usia_saat_pengajuan($tgl_awal, $tgl_akhir)
    {
        $awal  = new DateTime($tgl_awal);
        $akhir = new DateTime($tgl_akhir);
        $diff  = $awal->diff($akhir);

        return $diff->y . ' Tahun, ' . $diff->m . ' Bulan, ' . $diff->d . ' Hari';
    }
}

# hitung tanggal jatuh tempo berdasarkan tenor yang di ajukan
# ---
if (!function_exists('tgl_jatuh_tempo')) {
    function tgl_jatuh_tempo($tanggal, $tenor)
    {
        return date('Y-m-d', strtotime(' +' . $tenor . ' month', strtotime($tanggal)));
    }
}

# hitung usia saat jatuh tempo
# hitung tanggal jatuh tempo berdasarkan tenor yang di ajukan
# ---
if (!function_exists('usia_jatuh_tempo')) {
    function usia_jatuh_tempo($tgl_awal, $tgl_akhir)
    {
        $awal  = new DateTime($tgl_awal);
        $akhir = new DateTime($tgl_akhir);
        $diff  = $awal->diff($akhir);

        return $diff->y . ' Tahun, ' . $diff->m . ' Bulan, ' . $diff->d . ' Hari';
    }
}

if (!function_exists('rename_datetime_isnull')) {
    function rename_datetime_isnull($date, $label = null)
    {
        if ($label == 'label') {
            return $date == null ? '<span class="label label-danger f-s-11">0000-00-00 00:00:00</span>' : '<span class="label label-primary f-s-11">' . $date . '</span>';
        } else {
            return $date == null ? '<span class="text-red">0000-00-00 00:00:00</span>' : $date;
        }
    }
}

if (!function_exists('rename_date_isnull')) {
    function rename_date_isnull($date, $label = null)
    {
        if ($label == 'label') {
            return $date == null ? '<span class="label label-danger f-s-11">0000-00-00</span>' : '<span class="label label-primary f-s-11">' . $date . '</span>';
        } else {
            return $date == null ? '<span class="text-red">0000-00-00</span>' : $date;
        }
    }
}

if (!function_exists('rename_string_is_aktif')) {
    function rename_string_is_aktif($string, $label = null)
    {
        if ($label == 'label') {
            return $string == 'Y' ? '<span class="label label-primary f-s-11">Aktif</span>' : '<span class="label label-danger f-s-11">Tidak Aktif</span>';
        } else {
            return $string == 'Y' ? 'Aktif' : 'Tidak Aktif';
        }
    }
}

/**
 * ----------------------------------------
 * helper link upload file
 * berupa link ,  untuk melihat hasil upload
 * ----------------------------------------
 */

if (!function_exists('link_file')) {
    # --
    function link_file($params, $id_pinjaman)
    {
        $CI = &get_instance();

        $CI->load->model('DokumenUploadModel');

        if ($params == 'file_permohonan') {
            $sql = $CI->DokumenUploadModel->get_by_id('ID_PINJAMAN', $id_pinjaman, 'los_upload_permohonan');
            $row = $sql->row_array();
            if ($sql->num_rows() > 0) {
                $get_link = array(
                    'file' => base_url('/upload/file_permohonan/' . $row['NAMA_FILE']),
                    'last_upload' => $row['TANGGAL_UPLOAD'],
                );
            } else {
                $get_link = array(
                    'file' => '/upload/file/404_page.pdf',
                    'last_upload' => ($row['TANGGAL_UPLOAD'] == '') ? '<span class="text-danger">0000-00-00 00:00:00</span>' : '',
                );
            }
        } elseif ($params == 'file_permohonan_bic') {
            $sql = $CI->DokumenUploadModel->get_by_id('ID_PINJAMAN', $id_pinjaman, 'los_upload_permohonan_bic');
            $row = $sql->row_array();
            if ($sql->num_rows() > 0) {
                $get_link = array(
                    'file' => base_url('/upload/file_permohonan/' . $row['NAMA_FILE']),
                    'last_upload' => $row['TANGGAL_UPLOAD'],
                );
            } else {
                $get_link = array(
                    'file' => '/upload/file/404_page.pdf',
                    'last_upload' => ($row['TANGGAL_UPLOAD'] == '') ? '<span class="text-danger">0000-00-00 00:00:00</span>' : '',
                );
            }
        } elseif ($params == 'file_akadbank') {
            $sql = $CI->DokumenUploadModel->get_by_id('ID_PINJAMAN', $id_pinjaman, 'los_upload_akad_bank');
            $row = $sql->row_array();
            if ($sql->num_rows() > 0) {
                $get_link = array(
                    'file' => base_url('/upload/akad_bank/' . $row['NAMA_FILE']),
                    'last_upload' => $row['TANGGAL_UPLOAD'],
                );
            } else {
                $get_link = array(
                    'file' => '/upload/file/404_page.pdf',
                    'last_upload' => ($row['TANGGAL_UPLOAD'] == '') ? '<span class="text-danger">0000-00-00 00:00:00</span>' : '',
                );
            }
        } elseif ($params == 'file_simulasi') {
            $sql = $CI->DokumenUploadModel->get_by_id('ID_PINJAMAN', $id_pinjaman, 'los_upload_simulasi');
            $row = $sql->row_array();
            if ($sql->num_rows() > 0) {
                $get_link = array(
                    'file' => base_url('/upload/file_simulasi/' . $row['NAMA_FILE']),
                    'last_upload' => $row['TANGGAL_UPLOAD'],
                );
            } else {
                $get_link = array(
                    'file' => '/upload/file/404_page.pdf',
                    'last_upload' => ($row['TANGGAL_UPLOAD'] == '') ? '<span class="text-danger">0000-00-00 00:00:00</span>' : '',
                );
            }
        } elseif ($params == 'file_buktipelunasan') {
            $sql = $CI->DokumenUploadModel->get_by_id('ID_PINJAMAN', $id_pinjaman, 'los_upload_bukti_pelunasan');
            $row = $sql->row_array();
            if ($sql->num_rows() > 0) {
                $get_link = array(
                    'file' => base_url('/upload/bukti_pelunasan/' . $row['NAMA_FILE']),
                    'last_upload' => $row['TANGGAL_UPLOAD'],
                );
            } else {
                $get_link = array(
                    'file' => '/upload/file/404_page.pdf',
                    'last_upload' => ($row['TANGGAL_UPLOAD'] == '') ? '<span class="text-danger">0000-00-00 00:00:00</span>' : '',
                );
            }
        } elseif ($params == 'file_buktimutasi') {
            $sql = $CI->DokumenUploadModel->get_by_id('ID_PINJAMAN', $id_pinjaman, 'los_upload_bukti_mutasi');
            $row = $sql->row_array();
            if ($sql->num_rows() > 0) {
                $get_link = array(
                    'file' => base_url('/upload/bukti_mutasi/' . $row['NAMA_FILE']),
                    'last_upload' => $row['TANGGAL_UPLOAD'],
                );
            } else {
                $get_link = array(
                    'file' => '/upload/file/404_page.pdf',
                    'last_upload' => ($row['TANGGAL_UPLOAD'] == '') ? '<span class="text-danger">0000-00-00 00:00:00</span>' : '',
                );
            }
        } elseif ($params == 'file_giropos') {
            $sql = $CI->DokumenUploadModel->get_by_id('ID_PINJAMAN', $id_pinjaman, 'los_upload_giropos');
            $row = $sql->row_array();
            if ($sql->num_rows() > 0) {
                $get_link = array(
                    'file' => base_url('/upload/file_giro_pos/' . $row['NAMA_FILE']),
                    'last_upload' => $row['TANGGAL_UPLOAD'],
                );
            } else {
                $get_link = array(
                    'file' => '/upload/file/404_page.pdf',
                    'last_upload' => ($row['TANGGAL_UPLOAD'] == '') ? '<span class="text-danger">0000-00-00 00:00:00</span>' : '',
                );
            }
        } elseif ($params == 'file_pencairan') {
            $sql = $CI->DokumenUploadModel->get_by_id('ID_PINJAMAN', $id_pinjaman, 'los_upload_pencairan_file');
            $row = $sql->row_array();
            if ($sql->num_rows() > 0) {
                $get_link = array(
                    'file' => base_url('/upload/file_pencairan/' . $row['NAMA_FILE']),
                    'last_upload' => $row['TANGGAL_UPLOAD'],
                );
            } else {
                $get_link = array(
                    'file' => '/upload/file/404_page.pdf',
                    'last_upload' => ($row['TANGGAL_UPLOAD'] == '') ? '<span class="text-danger">0000-00-00 00:00:00</span>' : '',
                );
            }
        } elseif ($params == 'file_fotopencairan') {
            $sql = $CI->DokumenUploadModel->get_by_id('ID_PINJAMAN', $id_pinjaman, 'los_upload_pencairan_foto');
            $row = $sql->row_array();
            if ($sql->num_rows() > 0) {
                $get_link = array(
                    'file' => base_url('/upload/file_pencairan_foto/' . $row['NAMA_FILE']),
                    'last_upload' => $row['TANGGAL_UPLOAD'],
                );
            } else {
                $get_link = array(
                    'file' => '/upload/file/404_page.pdf',
                    'last_upload' => ($row['TANGGAL_UPLOAD'] == '') ? '<span class="text-danger">0000-00-00 00:00:00</span>' : '',
                );
            }
        } elseif ($params == 'file_skepasli') {
            $sql = $CI->DokumenUploadModel->get_by_id('ID_PINJAMAN', $id_pinjaman, 'los_upload_skep_asli');
            $row = $sql->row_array();
            if ($sql->num_rows() > 0) {
                $get_link = array(
                    'file' => base_url('/upload/file_skep_asli/' . $row['NAMA_FILE']),
                    'last_upload' => $row['TANGGAL_UPLOAD'],
                );
            } else {
                $get_link = array(
                    'file' => '/upload/file/404_page.pdf',
                    'last_upload' => ($row['TANGGAL_UPLOAD'] == '') ? '<span class="text-danger">0000-00-00 00:00:00</span>' : '',
                );
            }
        } elseif ($params == 'file_klaimasuransi') {
            $sql = $CI->DokumenUploadModel->get_by_id('ID_PINJAMAN', $id_pinjaman, 'los_upload_klaim_asuransi');
            $row = $sql->row_array();
            if ($sql->num_rows() > 0) {
                $get_link = array(
                    'file' => base_url('/upload/file_klaim_asuransi/' . $row['NAMA_FILE']),
                    'last_upload' => $row['TANGGAL_UPLOAD'],
                );
            } else {
                $get_link = array(
                    'file' => '/upload/file/404_page.pdf',
                    'last_upload' => ($row['TANGGAL_UPLOAD'] == '') ? '<span class="text-danger">0000-00-00 00:00:00</span>' : '',
                );
            }
        } elseif ($params == 'file_memo_danatalang_panjar') {
            $sql = $CI->DokumenUploadModel->get_by_id('ID_PINJAMAN', $id_pinjaman, 'los_upload_memo_danatalang_panjar');
            $row = $sql->row_array();
            if ($sql->num_rows() > 0) {
                $get_link = array(
                    'file' => base_url('/upload/mi_dantal_panjar/' . $row['NAMA_FILE']),
                    'last_upload' => $row['TANGGAL_UPLOAD'],
                );
            } else {
                $get_link = array(
                    'file' => '/upload/file/404_page.pdf',
                    'last_upload' => ($row['TANGGAL_UPLOAD'] == '') ? '<span class="text-danger">0000-00-00 00:00:00</span>' : '',
                );
            }
        } elseif ($params == 'file_memo_danatalang_pencairan') {
            $sql = $CI->DokumenUploadModel->get_by_id('ID_PINJAMAN', $id_pinjaman, 'los_upload_memo_danatalang_pencairan');
            $row = $sql->row_array();
            if ($sql->num_rows() > 0) {
                $get_link = array(
                    'file' => base_url('/upload/mi_dantal_pencairan/' . $row['NAMA_FILE']),
                    'last_upload' => $row['TANGGAL_UPLOAD'],
                );
            } else {
                $get_link = array(
                    'file' => '/upload/file/404_page.pdf',
                    'last_upload' => ($row['TANGGAL_UPLOAD'] == '') ? '<span class="text-danger">0000-00-00 00:00:00</span>' : '',
                );
            }
        } elseif ($params == 'file_memo_danatalang_takeover') {
            $sql = $CI->DokumenUploadModel->get_by_id('ID_PINJAMAN', $id_pinjaman, 'los_upload_memo_danatalang_takeover');
            $row = $sql->row_array();
            if ($sql->num_rows() > 0) {
                $get_link = array(
                    'file' => base_url('/upload/mi_dantal_takeover/' . $row['NAMA_FILE']),
                    'last_upload' => $row['TANGGAL_UPLOAD'],
                );
            } else {
                $get_link = array(
                    'file' => '/upload/file/404_page.pdf',
                    'last_upload' => ($row['TANGGAL_UPLOAD'] == '') ? '<span class="text-danger">0000-00-00 00:00:00</span>' : '',
                );
            }
        } elseif ($params == 'file_memo_mutasi') {
            $sql = $CI->DokumenUploadModel->get_by_id('ID_PINJAMAN', $id_pinjaman, 'los_upload_memo_mutasi');
            $row = $sql->row_array();
            if ($sql->num_rows() > 0) {
                $get_link = array(
                    'file' => base_url('/upload/mi_mutasi/' . $row['NAMA_FILE']),
                    'last_upload' => $row['TANGGAL_UPLOAD'],
                );
            } else {
                $get_link = array(
                    'file' => '/upload/file/404_page.pdf',
                    'last_upload' => ($row['TANGGAL_UPLOAD'] == '') ? '<span class="text-danger">0000-00-00 00:00:00</span>' : '',
                );
            }
        } elseif ($params == 'file_memo_sisapencairan') {
            $sql = $CI->DokumenUploadModel->get_by_id('ID_PINJAMAN', $id_pinjaman, 'los_upload_memo_sisapencairan');
            $row = $sql->row_array();
            if ($sql->num_rows() > 0) {
                $get_link = array(
                    'file' => base_url('/upload/mi_sisa_pencairan/' . $row['NAMA_FILE']),
                    'last_upload' => $row['TANGGAL_UPLOAD'],
                );
            } else {
                $get_link = array(
                    'file' => '/upload/file/404_page.pdf',
                    'last_upload' => ($row['TANGGAL_UPLOAD'] == '') ? '<span class="text-danger">0000-00-00 00:00:00</span>' : '',
                );
            }
        } else {
            $get_link = array(
                'file' => '/upload/file/404_page.pdf',
                'last_upload' => '<span class="text-danger">DATA TIDAK DI TEMUKAN</span>',
            );
        }
        return $get_link;
    }
}

if (!function_exists('link_file_v2')) {
    /**
     * ----------------------------------------
     * Helper: link_file_v2
     * Menghasilkan link file hasil upload berdasarkan parameter dan ID pinjaman
     * ----------------------------------------
     *
     * @param string $params Jenis file yang diminta (misal: file_permohonan, file_akadbank, dll.)
     * @param int|string $id_pinjaman ID Pinjaman
     * @return array [
     *     'file' => string URL file (jika ditemukan) atau placeholder,
     *     'last_upload' => string Tanggal upload terakhir atau placeholder
     * ]
     */
    function link_file_v2($params, $id_pinjaman)
    {
        $CI = &get_instance();
        $CI->load->model('DokumenUploadModel');

        // Mapping jenis file ke tabel dan direktori upload
        $config = [
            'file_permohonan' => ['table' => 'los_upload_permohonan', 'path' => 'file_permohonan'],
            'file_permohonan_bic' => ['table' => 'los_upload_permohonan_bic', 'path' => 'file_permohonan'],
            'file_akadbank' => ['table' => 'los_upload_akad_bank', 'path' => 'akad_bank'],
            'file_simulasi' => ['table' => 'los_upload_simulasi', 'path' => 'file_simulasi'],
            'file_buktipelunasan' => ['table' => 'los_upload_bukti_pelunasan', 'path' => 'bukti_pelunasan'],
            'file_buktimutasi' => ['table' => 'los_upload_bukti_mutasi', 'path' => 'bukti_mutasi'],
            'file_giropos' => ['table' => 'los_upload_giropos', 'path' => 'file_giro_pos'],
            'file_pencairan' => ['table' => 'los_upload_pencairan_file', 'path' => 'file_pencairan'],
            'file_fotopencairan' => ['table' => 'los_upload_pencairan_foto', 'path' => 'file_pencairan_foto'],
            'file_skepasli' => ['table' => 'los_upload_skep_asli', 'path' => 'file_skep_asli'],
            'file_klaimasuransi' => ['table' => 'los_upload_klaim_asuransi', 'path' => 'file_klaim_asuransi'],
            'file_memo_danatalang_panjar' => ['table' => 'los_upload_memo_danatalang_panjar', 'path' => 'mi_dantal_panjar'],
            'file_memo_danatalang_pencairan' => ['table' => 'los_upload_memo_danatalang_pencairan', 'path' => 'mi_dantal_pencairan'],
            'file_memo_danatalang_takeover' => ['table' => 'los_upload_memo_danatalang_takeover', 'path' => 'mi_dantal_takeover'],
            'file_memo_mutasi' => ['table' => 'los_upload_memo_mutasi', 'path' => 'mi_mutasi'],
            'file_memo_sisapencairan' => ['table' => 'los_upload_memo_sisapencairan', 'path' => 'mi_sisa_pencairan'],
        ];

        // Jika parameter tidak dikenal, kembalikan default error
        if (!isset($config[$params])) {
            return [
                'file' => '/upload/file/404_page.pdf',
                'last_upload' => '<span class="text-danger">DATA TIDAK DI TEMUKAN</span>',
            ];
        }

        // Ambil konfigurasi tabel dan path
        $table = $config[$params]['table'];
        $path = $config[$params]['path'];

        // Query data dari tabel terkait
        $sql = $CI->DokumenUploadModel->get_by_id('ID_PINJAMAN', $id_pinjaman, $table);
        $row = $sql->row_array();

        // Jika file ditemukan
        if ($sql->num_rows() > 0 && !empty($row['NAMA_FILE'])) {
            return [
                'file' => base_url('/upload/' . $path . '/' . $row['NAMA_FILE']),
                'last_upload' => $row['TANGGAL_UPLOAD'],
            ];
        }

        // Jika file tidak ditemukan atau tidak ada nama file
        return [
            'file' => '/upload/file/404_page.pdf',
            'last_upload' => empty($row['TANGGAL_UPLOAD'])
                ? '<span class="text-danger">0000-00-00 00:00:00</span>'
                : $row['TANGGAL_UPLOAD'],
        ];
    }
}

// helper informasi data rincian gaji
// 2021-12-17 12:38:50
if (!function_exists('helpinfo_gaji_pensiun')) {
    function helpinfo_gaji_pensiun($id_pinjaman)
    {
        $_ci = &get_instance();

        $_ci->db->select('*');
        $_ci->db->from('vw_pinjaman');
        $_ci->db->where('ID_PINJAMAN', $id_pinjaman);
        $i = $_ci->db->get()->row_array();

        $output = '';
        $output .= '

			<div class="row">
				<div class="col-md-4">

					<table class="table table-condensed text-inverse table-td-valign-middle">

						<tr class="bg-green-transparent-1">
							<td class="text-left" colspan="2"><b>RINCIAN PENDAPATAN</b></td>
						</tr>

						<tr class="bg-grey-transparent-1">
							<td class="text-left">POKOK PENSIUN</td>
							<td class="text-right" style="width: 150px;">' . number_format($i['PD_POKOK_PENSIUN']) . '</td>
						</tr>

						<tr class="bg-grey-transparent-1">
							<td class="text-left">TUNJANGAN ISTRI</td>
							<td class="text-right" style="width: 150px;">' . number_format($i['PD_TUN_ISTRI']) . '</td>
						</tr>

						<tr class="bg-grey-transparent-1">
							<td class="text-left">TUNJANGAN ANAK</td>
							<td class="text-right" style="width: 150px;">' . number_format($i['PD_TUN_ANAK']) . '</td>
						</tr>

						<tr class="bg-grey-transparent-1">
							<td class="text-left">TUNJANGAN DAHOR</td>
							<td class="text-right" style="width: 150px;">' . number_format($i['PD_TUN_DAHOR']) . '</td>
						</tr>

						<tr class="bg-grey-transparent-1">
							<td class="text-left">TUNJANGAN BERAS</td>
							<td class="text-right" style="width: 150px;">' . number_format($i['PD_TUN_BERAS']) . '</td>
						</tr>

						<tr class="bg-grey-transparent-1">
							<td class="text-left">TUNJANGAN CACAT</td>
							<td class="text-right" style="width: 150px;">' . number_format($i['PD_TUN_CACAT']) . '</td>
						</tr>

						<tr class="bg-grey-transparent-1">
							<td class="text-left">PPH PASAL 21</td>
							<td class="text-right" style="width: 150px;">' . number_format($i['PD_TUN_PPH21']) . '</td>
						</tr>

						<tr class="bg-grey-transparent-1">
							<td class="text-left">TPP</td>
							<td class="text-right" style="width: 150px;">' . number_format($i['PD_TPP']) . '</td>
						</tr>

						<tr class="bg-grey-transparent-1">
							<td class="text-left">TPM</td>
							<td class="text-right" style="width: 150px;">' . number_format($i['PD_TPM']) . '</td>
						</tr>

						<tr class="bg-grey-transparent-1">
							<td class="text-left">TKD</td>
							<td class="text-right" style="width: 150px;">' . number_format($i['PD_TKD']) . '</td>
						</tr>

						<tr class="bg-grey-transparent-1">
							<td class="text-left">PEMBULATAN</td>
							<td class="text-right" style="width: 150px;">' . number_format($i['PD_PEMBULATAN']) . '</td>
						</tr>


						<tr class="bg-green-transparent-1">
							<td class="text-left"> <b>JUMLAH PENDAPATAN <small>(A)</small> </b></td>
							<td class="text-right" style="width: 150px;"><b>' . number_format($i['PD_JUMLAH']) . '</b></td>
						</tr>

					</table>

				</div>

				<div class="col-md-4">

					<table class="table table-condensed text-inverse table-td-valign-middle">

						<tr class="bg-green-transparent-1">
							<td class="text-left" colspan="2"><b>RINCIAN POTONGAN</b></td>
						</tr>

						<tr class="bg-grey-transparent-1">
							<td class="text-left">PPH PASAL 21</td>
							<td class="text-right" style="width: 150px;">' . number_format($i['PO_PPH21']) . '</td>
						</tr>

						<tr class="bg-grey-transparent-1">
							<td class="text-left">ASKES</td>
							<td class="text-right" style="width: 150px;">' . number_format($i['PO_ASKSES']) . '</td>
						</tr>

						<tr class="bg-grey-transparent-1">
							<td class="text-left">KPKN</td>
							<td class="text-right" style="width: 150px;">' . number_format($i['PO_KPKN']) . '</td>
						</tr>

						<tr class="bg-grey-transparent-1">
							<td class="text-left">ASSOS</td>
							<td class="text-right" style="width: 150px;">' . number_format($i['PO_ASSOS']) . '</td>
						</tr>

						<tr class="bg-grey-transparent-1">
							<td class="text-left">KASDA</td>
							<td class="text-right" style="width: 150px;">' . number_format($i['PO_KASDA']) . '</td>
						</tr>

						<tr class="bg-grey-transparent-1">
							<td class="text-left">ALIMENTASI</td>
							<td class="text-right" style="width: 150px;">' . number_format($i['PO_ALIMENTASI']) . '</td>
						</tr>

						<tr class="bg-grey-transparent-1">
							<td class="text-left">SEWA RUMAH</td>
							<td class="text-right" style="width: 150px;">' . number_format($i['PO_SEWARUMAH']) . '</td>
						</tr>

						<tr class="bg-grey-transparent-1">
							<td class="text-left">GANTI RUGI</td>
							<td class="text-right" style="width: 150px;">' . number_format($i['PO_GANTIRUGI']) . '</td>
						</tr>

						<tr class="bg-green-transparent-1">
							<td class="text-left"><b>JUMLAH POTONGAN <small>(B)</small></b></td>
							<td class="text-right" style="width: 150px;"><b>' . number_format($i['PO_JUMLAH']) . '</b></td>
						</tr>

					</table>

				</div>

				<div class="col-md-4">

					<table class="table table-condensed text-inverse table-td-valign-middle">

						<tr class="bg-green-transparent-1">
							<td class="text-left" colspan="2"><b>TERIMA BERSIH</b></td>
						</tr>

						<tr class="bg-grey-transparent-1">
							<td class="text-left">PENDAPATAN</td>
							<td class="text-right" style="width: 150px;">' . number_format($i['PD_JUMLAH']) . '</td>
						</tr>

						<tr class="bg-grey-transparent-1">
							<td class="text-left">POTONGAN</td>
							<td class="text-right" style="width: 150px;">' . number_format($i['PO_JUMLAH']) . '</td>
						</tr>

						<tr class="bg-green-transparent-1">
							<td class="text-left"><b>JUMLAH BERSIH <small>(A) - (B)</small> </b></td>
							<td class="text-right" style="width: 150px;"><b>' . number_format($i['PO_TOTALBERSIH']) . '</b></td>
						</tr>

					</table>

				</div>

			</div>
			';
        return $output;
    }
}

// Helper informasi pembiayaan
// 2021-12-16 11:56:39
if (!function_exists('helpinfo_pembiayaan')) {
    function helpinfo_pembiayaan($id_pinjaman)
    {
        $CI = &get_instance();
        $CI->db->where('ID_PINJAMAN', $id_pinjaman);
        $q = $CI->db->get('vw_pinjaman')->row_array();

        if ($CI->session->userdata('sess_id_group_cabang') == 1) {
            if ($q['JENIS_BUNGA'] == 'EFFEKTIF') {
                $jenis_rate = $q['JENIS_BUNGA'] . ' | ' . $q['BUNGA_EFF_KOP'] . '% | ' . $q['BUNGA_EFF_BANK'] . '%';
            } else {
                $jenis_rate = $q['JENIS_BUNGA'] . ' | ' . (number_format($q['BUNGA_FLAT'] * 100, 2)) . '% | ' . (number_format($q['BUNGA_FLAT_BANK'] * 100, 2)) . '%';
            }
        } else {
            if ($q['JENIS_BUNGA'] == 'EFFEKTIF') {
                $jenis_rate = $q['JENIS_BUNGA'] . ' | ' . $q['BUNGA_EFF_KOP'] . '<small>%</small>';
            } else {
                $jenis_rate = $q['JENIS_BUNGA'] . ' | ' . (number_format($q['BUNGA_FLAT'] * 100, 2)) . '<small>%</small>';
            }
        }

        if ($q['ID_MITRA'] == '99') {
            $mitra_takeover = '--';
            $tanggal_pelunasan = '--';
        } else {
            $mitra_takeover = $q['NAMA_MITRA'];
            $tanggal_pelunasan = format_date_indo_v2($q['TANGGAL_PELUNASAN']);
        }

        // Jenis instansi
        // 2021-12-23 11:26:22
        if ($q['ID_INSTANSI'] == 1) {
            $nama_instansi = '<b class="text-primary">TASPEN</b>';
        } elseif ($q['ID_INSTANSI'] == 2) {
            $nama_instansi = '<b class="text-red">ASABRI</b>';
        } elseif ($q['ID_INSTANSI'] == 3) {
            $nama_instansi = 'DAPENTEL';
        } elseif ($q['ID_INSTANSI'] == 4) {
            $nama_instansi = 'DAPENPOS';
        } else {
            $nama_instansi = '404';
        }

        date_default_timezone_set('Asia/Jakarta');

        # estimasi tanggal jatuh tempo
        $tgl_jatuh_tempo = tgl_jatuh_tempo($q['TANGGAL_PENGAJUAN'], $q['TENOR']);

        # estimasi usia saat jatuh tempo
        $usia_jatuh_tempo = usia_jatuh_tempo($q['TANGGAL_LAHIR'], $tgl_jatuh_tempo);

        # estmasi usia saat pengajuan
        $usia_pengajuan = usia_saat_pengajuan($q['TANGGAL_LAHIR'], $q['TANGGAL_PENGAJUAN']);

        $output = '';
        $output .= '
			<table class="table table-condensed f-s-11">
				<tr style="border-left: 6px solid green;">
					<td colspan="2">
						<b>INFO PEMBIAYAAN</b> <br>
						<small>' . $q['NAMA_DEBITUR'] . ' | ' . $q['NO_PENSIUN'] . ' | ' . $q['NAMA_CABANG'] . ' | ' . $nama_instansi . '</small>
					</td>
				</tr>
				<tr class="">
					<td class="text-left width-200">NOREG</td>
					<td class="text-left">' . $q['NO_REGISTRASI'] . '</td>
				</tr>
				<tr class="">
					<td class="text-left width-200">SUMBERDANA</td>
					<td class="text-left">' . $q['NAMA_SUMBERDANA'] . '</td>
				</tr>
				<tr class="">
					<td class="text-left width-200">RATE</td>
					<td class="text-left">' . $jenis_rate . '</td>
				</tr>
				<tr class="">
					<td class="text-left width-200">PRODUK</td>
					<td class="text-left">' . str_replace('_', ' ', $q['PRODUK']) . ' -  ' . getname_jenisbiaya_id($q['ID_JENIS_BIAYA']) . '</td>
				</tr>

				<tr class="">
					<td class="text-left width-200">MITRA TAKE OVER</td>
					<td class="text-left">' . $mitra_takeover . '</td>
				</tr>
				<tr class="">
					<td class="text-left width-200">TGL PELUNASAN</td>
					<td class="text-left">' . $tanggal_pelunasan . '</td>
				</tr>
				<tr class="">
					<td class="text-left width-200">USIA MASUK</td>
					<td class="text-left">' . $q['USIA_DETAIL'] . '</td>
				</tr>
				<tr class="">
					<td colspan="2" class="text-left width-200 bg-grey-transparent-1"><b>PENGAJUAN</b></td>
				</tr>
				<tr class="">
					<td class="text-left width-200 text-primary">PLAFOND</td>
					<td class="text-right">' . number_format($q['PLAFOND']) . '</td>
				</tr>
				<tr class="">
					<td class="text-left width-200 text-primary">TENOR</td>
					<td class="text-right">' . ($q['TENOR']) . ' BLN</td>
				</tr>
				<tr class="">
					<td class="text-left width-200 text-primary">ANGSURAN</td>
					<td class="text-right">' . number_format($q['ANGSURAN_KOP']) . '</td>
				</tr>
				<tr class="">
					<td colspan="2" class="text-left width-200 bg-grey-transparent-1"><b>REKOMENDASI</b></td>
				</tr>
				<tr class="">
					<td class="text-left width-200 text-red"> MAX PLAFOND</td>
					<td class="text-right">' . number_format($q['MAX_PLAFOND']) . '</td>
				</tr>
				<tr class="">
					<td class="text-left width-200 text-red"> MAX TENOR</td>
					<td class="text-right">' . number_format($q['MAX_TENOR']) . ' BLN</td>
				</tr>
				<tr class="">
					<td class="text-left width-200 text-red"> MAX ANGSURAN</td>
					<td class="text-right">' . number_format($q['MAX_ANGSURAN']) . '</td>
				</tr>

				<tr class="bg-grey-transparent-1" style="border-left: 6px solid green;">
					<td colspan="2" class="text-left width-200"><b>ESTIMASI JATUH TEMPO</b></td>
				</tr>

				<tr class="">
					<td class="text-left width-200">TANGGAL PENGAJUAN</td>
					<td class="text-left">' . format_date_indo_v2($q['TANGGAL_PENGAJUAN']) . '</td>
				</tr>
				<tr class="text-uppercase">
					<td class="text-left width-200">USIA SAAT PENGAJUAN</td>
					<td class="text-left">' . $usia_pengajuan . '</td>
				</tr>
				<tr class="">
					<td class="text-left width-200">TANGGAL JATUH TEMPO</td>
					<td class="text-left">' . format_date_indo_v2($tgl_jatuh_tempo) . '</td>
				</tr>
				<tr class="text-uppercase">
					<td class="text-left width-200">USIA JATUH TEMPO</td>
					<td class="text-left">' . $usia_jatuh_tempo . '</td>
				</tr>

			</table>';
        return $output;
    }
}

// Helper informasi rincian pembiayaan
// 2021-12-16 11:56:39
if (!function_exists('helpinfo_rincian_pembiayaan')) {
    function helpinfo_rincian_pembiayaan($id_pinjaman)
    {
        $CI = &get_instance();
        $CI->db->where('ID_PINJAMAN', $id_pinjaman);
        $q = $CI->db->get('vw_pinjaman')->row_array();

        if ($q['POT_UM'] != 0) {
            $countBlokir = "(" . $q['POT_UM'] . "<small>x</small>)";
        } else {
            $countBlokir = "(0<small>x</small>)";
        }

        // hitung komponen by asuransi
        $by_asuransi = $q['NOMINAL_BY_ASS_KOP'] + $q['NOMINAL_BY_LAINNYA'] + $q['NOMINAL_BY_FLAG'];

        // hitung jumlah potongan
        $jml_potongan = $by_asuransi + $q['NOMINAL_BPP'] + $q['NOMINAL_BY_ADM'] + $q['NOMINAL_BY_TATALAKASAN'] + $q['NOMINAL_BY_PROVISI'] + $q['NOMINAL_BY_BUKA_REKENING'] + $q['NOMINAL_BY_MUTASI'] + $q['NOMINAL_POT_UM'];

        // hitung terima kotor
        $jml_terima_kotor = $q['PLAFOND'] - $jml_potongan;

        // hitung terima bersih
        $jml_terima_bersih = $jml_terima_kotor - $q['NOMINAL_PELUNASAN'];

        // Jenis instansi
        // 2021-12-23 11:26:22

        if ($q['ID_INSTANSI'] == 1) {
            $nama_instansi = '<b class="text-primary">TASPEN</b>';
        } elseif ($q['ID_INSTANSI'] == 2) {
            $nama_instansi = '<b class="text-red">ASABRI</b>';
        } elseif ($q['ID_INSTANSI'] == 3) {
            $nama_instansi = 'DAPENTEL';
        } elseif ($q['ID_INSTANSI'] == 4) {
            $nama_instansi = 'DAPENPOS';
        } else {
            $nama_instansi = '-404-';
        }

        # marketing
        $marketing = nama_marketing_by($q['ID_KARYAWAN_MKT']);
        $feemarketing = fee_marketing($q['ID_KARYAWAN_MKT']) * $q['PLAFOND'];

        $output = '';
        $output .= '
			<table class="table table-condensed table-bordered">
				<tr class="bg-green-transparent-1">
					<td colspan="2">
						<b>RINCIAN PEMBIAYAAN</b> <br>
						<small>' . $q['NAMA_DEBITUR'] . ' | ' . $q['NO_PENSIUN'] . ' | ' . $q['NAMA_CABANG'] . ' | ' . $nama_instansi . '</small> <br>
						<b>' . $marketing . '</b>
					</td>
				</tr>
				<tr class="">
					<td class="text-left width-200">PRODUK</td>
					<td class="text-right">' . str_replace('_', ' ', $q['PRODUK']) . ' - ' . getname_jenisbiaya_id($q['ID_JENIS_BIAYA']) . '</td>
				</tr>
				<tr class="">
					<td class="text-left width-200">PLAFOND</td>
					<td class="text-right">' . number_format($q['PLAFOND']) . '</td>
				</tr>
				<tr class="bg-grey-transparent-1">
					<td colspan="2" class="text-left width-200"> <b>POTONGAN</b> </td>
				</tr>
				<tr class="">
					<td class="text-left width-200">BY BPP</td>
					<td class="text-right">' . number_format($q['NOMINAL_BPP']) . '</td>
				</tr>
				<tr class="">
					<td class="text-left width-200">BY ADMINISTRASI</td>
					<td class="text-right">' . number_format($q['NOMINAL_BY_ADM']) . '</td>
				</tr>
				<tr class="">
					<td class="text-left width-200">BY TATALAKSANA</td>
					<td class="text-right">' . number_format($q['NOMINAL_BY_TATALAKASAN']) . '</td>
				</tr>
				<tr class="">
					<td class="text-left width-200">BY PROVISI</td>
					<td class="text-right">' . number_format($q['NOMINAL_BY_PROVISI']) . '</td>
				</tr>
				<tr class="">
					<td class="text-left width-200">BY ASURANSI</td>
					<td class="text-right">' . number_format($by_asuransi) . '</td>
				</tr>
				<tr class="">
					<td class="text-left width-200">BY BUKA REKENING</td>
					<td class="text-right">' . number_format($q['NOMINAL_BY_BUKA_REKENING']) . '</td>
				</tr>
				<tr class="">
					<td class="text-left width-200">BY MUTASI</td>
					<td class="text-right">' . number_format($q['NOMINAL_BY_MUTASI']) . '</td>
				</tr>
				<tr class="">
					<td class="text-left width-200">BLOKIR ANGSURAN</td>
					<td class="text-right"><b class="pull-left"> ' . $countBlokir . ' </b> ' . number_format($q['NOMINAL_POT_UM']) . ' </td>
				</tr>
				<tr class="bg-grey-transparent-1">
					<td class="text-left width-200"> <b>JUMLAH POTONGAN</b> </td>
					<td class="text-right"><b>' . number_format($jml_potongan) . '</b></td>
				</tr>
				<tr class="">
					<td class="text-left width-200"> TERIMA KOTOR</td>
					<td class="text-right">' . number_format($jml_terima_kotor) . '</td>
				</tr>
				<tr class="">
					<td class="text-left width-200"> NOMINAL PELUNASAN</td>
					<td class="text-right">' . number_format($q['NOMINAL_PELUNASAN']) . '</td>
				</tr>
				<tr class="bg-grey-transparent-1">
					<td class="text-left width-200"> <b>TERIMA BERSIH</b> </td>
					<td class="text-right"><b>' . number_format($jml_terima_bersih) . '</b></td>
				</tr>
			</table>';
        return $output;
    }
}

// Helper informasi droping pencairan
// 2021-12-16 11:56:39
if (!function_exists('helpinfo_droping_pencairan')) {
    function helpinfo_droping_pencairan($id_pinjaman)
    {
        $_ci = &get_instance();

        $_ci->db->where('ID_PINJAMAN', $id_pinjaman);
        $q = $_ci->db->get('vw_pinjaman')->row_array();

        // hitung komponen by asuransi
        $by_asuransi = $q['NOMINAL_BY_ASS_KOP'] + $q['NOMINAL_BY_LAINNYA'] + $q['NOMINAL_BY_FLAG'];

        // hitung jumlah potongan
        $jml_potongan = $by_asuransi + $q['NOMINAL_BY_ADM'] + $q['NOMINAL_BY_TATALAKASAN'] + $q['NOMINAL_BY_PROVISI'] + $q['NOMINAL_BY_BUKA_REKENING'] + $q['NOMINAL_BY_MUTASI'] + $q['NOMINAL_POT_UM'];

        // hitung terima kotor tanpa BPP
        $jml_terima_kotor = $q['PLAFOND'] - $jml_potongan;

        // looping transaksi droping
        $_ci->db->select('NO_REGISTRASI AS NOREG, TANGGAL_TRANSFER_TAHAP1 AS TGL, "[TRX DROPING TAHAP 1]" AS KETERANGAN, NOMINAL_TRANSFER_TAHAP1 AS NOMINAL');
        $_ci->db->from('droping_pencairan');
        $_ci->db->where('ID_PINJAMAN', $q['ID_PINJAMAN']);
        $query1 = $_ci->db->get()->result_array();

        $_ci->db->select('NO_REGISTRASI AS NOREG, TANGGAL_TRANSFER_TAHAP2 AS TGL, "[TRX DROPING TAHAP 2]" AS KETERANGAN, NOMINAL_TRANSFER_TAHAP2 AS NOMINAL');
        $_ci->db->from('droping_pencairan');
        $_ci->db->where('ID_PINJAMAN', $q['ID_PINJAMAN']);
        $query2 = $_ci->db->get()->result_array();

        $_ci->db->select('NO_REGISTRASI AS NOREG, TANGGAL_TRANSFER_TAHAP3 AS TGL, "[TRX DROPING TAHAP 3]" AS KETERANGAN, NOMINAL_TRANSFER_TAHAP3 AS NOMINAL');
        $_ci->db->from('droping_pencairan');
        $_ci->db->where('ID_PINJAMAN', $q['ID_PINJAMAN']);
        $query3 = $_ci->db->get()->result_array();

        $_ci->db->select('NO_REGISTRASI AS NOREG,TANGGAL_TRANSFER_BPP AS TGL, "[TRX DROPING BPP]" AS KETERANGAN, NOMINAL_TRANSFER_BPP AS NOMINAL');
        $_ci->db->from('droping_pencairan');
        $_ci->db->where('ID_PINJAMAN', $q['ID_PINJAMAN']);
        $query4 = $_ci->db->get()->result_array();

        $query = array_merge($query1, $query2, $query3, $query4);

        // get keterngan droping
        $id_pinjaman = $q['ID_PINJAMAN'];
        $sql = "SELECT NAMA_USER, TANGGAL_UPDATE FROM droping_pencairan WHERE ID_PINJAMAN = $id_pinjaman ";
        $ket = $_ci->db->query($sql)->row_array();

        $output = '';
        $output .= '<table class="table table-condensed table-bordered text-inverse">';
        $output .= '
					<tr class="bg-green-transparent-1">
						<td colspan="3">
							<b>INFORMASI DROPING</b> <br>
							<small>' . $q['NAMA_DEBITUR'] . ' | ' . $q['NO_PENSIUN'] . ' | ' . $q['NAMA_CABANG'] . '</small>
						</td>
					</tr>
					<tr class="bg-grey-transparent-1">
						<td class="text-center width-50"><b>TANGGAL</b></td>
						<td class="text-left"><b>KETERANGAN</b></td>
						<td class="text-right" style="width: 120px;"><b>NOMINAL</b></td>
					</tr>
		';

        $jml_transaksi = 0;
        foreach ($query as $val) {

            $jml_transaksi += $val['NOMINAL'];

            $output .= '
						<tr class="">
							<td class="text-center width-50">' . format_date_indo_v2($val['TGL']) . '</td>
							<td class="text-left">' . $val['KETERANGAN'] . '</td>
							<td class="text-right" style="width: 120px;">' . number_format($val['NOMINAL']) . '</td>
						</tr>
						';
        }

        $output .= '
						<tr class="bg-grey-transparent-1">
							<td class="text-center width-50"></td>
							<td class="text-left"><b>JUMLAH</b></td>
							<td class="text-right" style="width: 120px;"><b>' . number_format($jml_transaksi) . '</b></td>
						</tr>
						';

        $sisa_droping = $jml_terima_kotor - $jml_transaksi;

        $output .= '
						<tr class="">
							<td class="text-center width-50"></td>
							<td class="text-left">SISA DROPING</td>
							<td class="text-right" style="width: 120px;">' . number_format($sisa_droping) . '</td>
						</tr>
						';
        $output .= '
						<tr class="bg-grey-transparent-1">
							<td class="text-left" colspan="3"> LAST UPDATE <br> ' . $ket['NAMA_USER'] . ' - ' . $ket['TANGGAL_UPDATE'] .  '</td>
						</tr>
						';


        $output .= '</table>';



        return $output;
    }
}

// helper informasi komentar hasil slik BI
if (!function_exists('helpinfo_slik')) {
    function helpinfo_slik($id_pinjaman)
    {
        $_ci = &get_instance();

        $_ci->db->select('*');
        $_ci->db->from('vw_pinjaman');
        $_ci->db->where('ID_PINJAMAN', $id_pinjaman);
        $i = $_ci->db->get()->row_array();

        // cek status SLIK
        if ($i['STATUS_BIC'] == 'Y') {
            $user_update = getname_user_id($i['BI_ID_USER']) . '<br>' . $i['BI_UPDATE_AT'];
            $hasil_slik = strtoupper($i['BI_KOMENTAR']);
        } else {
            $user_update = '== STATUS SLIK DALAM PROSES ==';
            $hasil_slik = ' == STATUS SLIK DALAM PROSES == ';
        }

        $output = '';
        $output .= '
			<table class="table table-condensed table-bordered text-inverse table-td-valign-middle">

				<tr class="bg-grey-transparent-1">
					<td colspan="2" class="text-left">
						<b>INFORMASI HASIL SLIK</b> <br>
						<small>' . $i['NAMA_DEBITUR'] . ' | ' . $i['NO_PENSIUN'] . ' | ' . $i['NAMA_CABANG'] . '</small>
					</td>
				</tr>

				<tr class="">
					<td class="text-left bg-grey-transparent-1" style="width: 150px;"><b>SUMBERDANA</b></td>
					<td class="text-left  small">' . $i['NAMA_GROUP_SUMBERDANA'] . '</td>
				</tr>

				<tr class="">
					<td class="text-left bg-grey-transparent-1" style="width: 150px;"><b>LAST UPDATE</b></td>
					<td class="text-left  small">' . $user_update . '</td>
				</tr>

				<tr class="">
					<td colspan="2" class="text-left">' . $hasil_slik . '</td>
				</tr>

				<tr class="">
					<td colspan="2" class="text-left" style="width: 150px;">' . anchor_popup(base_url('printout/hasil_bic/' . enkrip($i['ID_PINJAMAN'])), '<i class="fa fa-print fa-fw"></i> Print Hasil SLIK', array('class' => 'btn btn-xs btn-default')) . '</td>
				</tr>

			</table>';
        return $output;
    }
}

// helper informasi komentar hasil verifikasi
if (!function_exists('helpinfo_verifikasi')) {
    function helpinfo_verifikasi($id_pinjaman)
    {
        $_ci = &get_instance();

        $_ci->db->select('*');
        $_ci->db->from('vw_pinjaman');
        $_ci->db->where('ID_PINJAMAN', $id_pinjaman);
        $i = $_ci->db->get()->row_array();

        // cek status verifikasi
        if ($i['STATUS_VERIFIKASI'] == 'Y' || $i['STATUS_KEMBALIKAN_VRF'] == 'Y') {
            $user_update = getname_user_id($i['VRF_ID_USER']) . '<br>' . $i['VRF_UPDATE_AT'];
            $hasil_verifikasi = nl2br(strtoupper($i['VRF_KOMENTAR']));
        } else {
            $user_update = '== STATUS VERIFIKASI DALAM PROSES ==';
            $hasil_verifikasi = ' == STATUS VERIFIKASI DALAM PROSES == ';
        }

        // cek status dikembalikan
        if ($i['STATUS_KEMBALIKAN_VRF'] == 'Y') {
            $status_dikembalikan = '== DIKEMBALIKAN OLEH VERIFIKASI ==';
        } else {
            $status_dikembalikan = '== PROGRESS ==';
        }

        $output = '';
        $output .= '
			<table class="table table-condensed table-bordered text-inverse table-td-valign-middle">

				<tr class="bg-grey-transparent-1">
					<td colspan="2" class="text-left">
						<b>INFORMASI HASIL VERIFIKASI</b> <br>
						<small>' . $i['NAMA_DEBITUR'] . ' | ' . $i['NO_PENSIUN'] . ' | ' . $i['NAMA_CABANG'] . '</small>
					</td>
				</tr>

				<tr class="">
					<td class="text-left bg-grey-transparent-1" style="width: 150px;"><b>LAST UPDATE</b></td>
					<td class="text-left  small">' . $user_update . '</td>
				</tr>
				<tr class="">
					<td class="text-left bg-grey-transparent-1" style="width: 150px;"><b>STATUS</b></td>
					<td class="text-left  small">' . $status_dikembalikan . '</td>
				</tr>

				<tr class="">
					<td colspan="2" class="text-left">' . $hasil_verifikasi . '</td>
				</tr>

				<tr class="">
					<td colspan="2" class="text-left" style="width: 150px;">' . anchor_popup(base_url('printout/hasil_periksa_verifikasi/' . enkrip($i['ID_PINJAMAN'])), '<i class="fa fa-print fa-fw"></i> Print Hasil Verifikasi', array('class' => 'btn btn-xs btn-default')) . '</td>
				</tr>

			</table>';
        return $output;
    }
}
