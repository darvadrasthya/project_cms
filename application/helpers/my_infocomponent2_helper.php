<?php

/**
 * MY_Infocomponent2_helper.php
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
if (!defined('BASEPATH')) exit('No direct script access allowed');

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
        } elseif ($data->STATUS_ANTRIAN_DEBITUR == 2 && $data->STATUS_ANTRIAN_OPS == 1 && $data->STATUS_VERIFIKASI == 'N' && $data->STATUS_KEMBALIKAN_VRF == 'N') {
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
        } elseif ($data->STATUS_ANTRIAN_DEBITUR == 4 && $data->STATUS_ANTRIAN_OPS == 1 && $data->STATUS_OPS == 'N') {
            $cekPos = '<span class="label label-purple f-w-600"> <i class="fa fa-chevron-circle-right fa-fw"></i> APP KREDIT</span>';
            $cekPos_nolabel = 'APP KREDIT';
            $cekStatus = '<i class="fas fa-user-tag fa-fw text-green"></i> PROSES UPLOAD AKAD';
            $cekStatus_nolabel = 'PROSES UPLOAD AKAD';
        } elseif ($data->STATUS_ANTRIAN_DEBITUR == 5 && $data->STATUS_ANTRIAN_OPS == 1 && $data->STATUS_VERIFIKASI == 'Y' && $data->STATUS_APPROVAL == 'Y' && $data->STATUS_CAIR == 'Y' && $data->STATUS_OPS == 'N' && $data->STATUS_DAFNOM == 'N') {
            $cekPos = '<span class="label label-purple f-w-600"> <i class="fa fa-chevron-circle-right fa-fw"></i> APP KREDIT</span>';
            $cekPos_nolabel = 'APP KREDIT';
            $cekStatus = '<i class="fas fa-user-tag fa-fw text-green"></i> PROSES VALIDASI AKAD';
            $cekStatus_nolabel = 'PROSES VALIDASI AKAD';
        } elseif ($data->STATUS_ANTRIAN_DEBITUR == 5 && $data->STATUS_ANTRIAN_OPS == 1 && $data->STATUS_VERIFIKASI == 'Y' && $data->STATUS_APPROVAL == 'Y' && $data->STATUS_CAIR == 'Y' && $data->STATUS_OPS == 'Y' && $data->STATUS_DAFNOM == 'N') {
            $cekPos = '<span class="label label-purple f-w-600"> <i class="fa fa-chevron-circle-right fa-fw"></i> APP KREDIT</span>';
            $cekPos_nolabel = 'APP KREDIT';
            $cekStatus = '<i class="fas fa-user-tag fa-fw text-green"></i> PROSES DAFNOM KE BANK';
            $cekStatus_nolabel = 'PROSES DAFNOM KE BANK';
        } elseif ($data->STATUS_ANTRIAN_DEBITUR == 5 && $data->STATUS_ANTRIAN_OPS == 1 && $data->STATUS_VERIFIKASI == 'Y' && $data->STATUS_APPROVAL == 'Y' && $data->STATUS_CAIR == 'Y' && $data->STATUS_OPS == 'Y' && $data->STATUS_DAFNOM == 'Y') {
            $cekPos = '<span class="label label-primary f-w-600"> <i class="fa fa-chevron-circle-right fa-fw"></i> APPROVAL BANK</span>';
            $cekPos_nolabel = 'APPROVAL BANK';
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
            $cekPos = '<span class="label label-danger f-w-600"> <i class="fa fa-chevron-circle-right fa-fw"></i>404 (BYPASS)</span>';
            $cekStatus = '<i class="fas fa-user-slash fa-fw text-danger"></i> TIDAK ADA DI ANTRIAN 404 (BYPASS)';
        }

        # array to object
        $return = (object)array(
            'cekAntrian' => $cekPos,
            'cekAntrian_nolabel' => $cekPos_nolabel,
            'cekStatus' => $cekStatus,
            'cekStatus_nolabel' => $cekStatus_nolabel,
        );

        # callback
        return $return;
    }
}

// (Mutasi Rekening) Detail transaksi droping pencairan
if (!function_exists('detail_transaksi_pencairan')) {
    function detailTransaksiPencairan($account, $mutasi_saldo_pencairan)
    {
        $CI = &get_instance();
        $CI->load->helper('number'); // Load number helper if not already loaded

        // Initialize variables
        $no = 2;
        $terimakotorPencairan = $account['plafond'] - $account['jmlterimakotor'];
        $saldoPencairan = $terimakotorPencairan;

        // Start building the table
        $output = '<div class="m-b-10">
                    <b class="text-inverse f-s-16"><i class="fa fa-book"></i> Data Transaksi Pencairan Debitur</b> <br>
                    <span class="f-s-11">Detail Data Transaksi Pencairan Debitur</span>
                </div>

                <div class="table-responsive m-b-10">
                    <table class="table table-condensed table-striped table-bordered f-s-11">
                        <thead>
                            <tr>
                                <th class="text-center width-10">No</th>
                                <th class="text-center width-100">Tanggal</th>
                                <th class="text-left">Keterangan</th>
                                <th class="text-right width-120">(Db) Debet</th>
                                <th class="text-right width-120">(Cr) Kredit</th>
                                <th class="text-right width-120">Sisa Pencairan Debitur</th>
                            </tr>
                        </thead>
                        <tbody>';

        // Add the initial row
        $output .= '<tr>
                        <td class="text-center">1</td>
                        <td class="text-center">' . format_date_indo_v2($account['tglpengajuan']) . '</td>
                        <td class="text-left">
                            <div><b>Pembiayaan Pinjaman (Terima Kotor)</b></div>
                            <div>Uraian : Jumlah Terima Kotor Pembiayaan Debitur</i></div>
                        </td>
                        <td class="text-right">' . number_format($saldoPencairan) . '</td>
                        <td class="text-right">' . number_format(0) . '</td>
                        <td class="text-right">' . number_format($saldoPencairan) . '</td>
                    </tr>';

        // Add rows for mutasi saldo
        foreach ($mutasi_saldo_pencairan as $val) {
            $saldoPencairan += ($val['debet'] - $val['kredit']);
            $output .= '<tr>
                            <td class="text-center">' . $no++ . '</td>
                            <td class="text-center">' . format_date_indo_v2($val['tgltransaksi']) . '</td>
                            <td class="text-left">
                                <div><b>' . $val['keterangan'] . '</b></div>
                                <span>Uraian : ' . (!empty($val['uraian']) ? $val['uraian'] : "Tidak ada keterangan") . '</span>
                            </td>
                            <td class="text-right">' . number_format($val['debet']) . '</td>
                            <td class="text-right">' . number_format($val['kredit']) . '</td>
                            <td class="text-right">' . number_format($saldoPencairan) . '</td>
                        </tr>';
        }

        // Close the table
        $output .= '</tbody>
                    </table>
                </div>';

        return $output;
    }
}

// (Mutasi Rekening) Detail transaksi droping keuangan
if (!function_exists('detail_transaksi_droping')) {
    function detail_transaksi_droping($account, $mutasi_saldo_droping)
    {
        $CI = &get_instance();
        $CI->load->helper('number'); // Load number helper if not already loaded

        // Initialize variables
        $no = 2;
        $terimaKotor = $account['plafond'] - $account['jmlpotongan'];
        $saldoDroping = $terimaKotor;

        // Start building the table
        $output = '<div class="m-b-10">
                    <b class="text-inverse f-s-16"><i class="fa fa-book"></i> Data Transaksi Droping</b> <br>
                    <span class="f-s-11">Detail Data Transaksi Droping Keuangan</span>
                </div>

                <div class="table-responsive m-b-10">
                    <table class="table table-condensed table-striped table-bordered f-s-11">
                        <thead>
                            <tr>
                                <th class="text-center width-10">No</th>
                                <th class="text-center width-100">Tanggal</th>
                                <th class="text-left">Keterangan</th>
                                <th class="text-right width-120">(Db) Debet</th>
                                <th class="text-right width-120">(Cr) Kredit</th>
                                <th class="text-right width-120">Sisa Droping</th>
                            </tr>
                        </thead>
                        <tbody>';

        // Add the initial row
        $output .= '<tr>
                        <td class="text-center">1</td>
                        <td class="text-center">' . format_date_indo_v2($account['tglpengajuan']) . '</td>
                        <td class="text-left">
                            <div><b>Pembiayaan Pinjaman</b></div>
                            <div>Uraian : Jumlah biaya potongan tanpa (BPP, Mutasi, Fee Marketing Agent 3%)</i></div>
                        </td>
                        <td class="text-right">' . number_format($saldoDroping) . '</td>
                        <td class="text-right">' . number_format(0) . '</td>
                        <td class="text-right">' . number_format($saldoDroping) . '</td>
                    </tr>';

        // Add rows for mutasi saldo
        foreach ($mutasi_saldo_droping as $val) {
            $saldoDroping += ($val['debet'] - $val['kredit']);
            $output .= '<tr>
                            <td class="text-center">' . $no++ . '</td>
                            <td class="text-center">' . format_date_indo_v2($val['tgltransaksi']) . '</td>
                            <td class="text-left">
                                <div><b>' . $val['keterangan'] . '</b></div>
                                <span>Uraian : ' . (!empty($val['uraian']) ? $val['uraian'] : "Tidak ada keterangan") . '</span>
                            </td>
                            <td class="text-right">' . number_format($val['debet']) . '</td>
                            <td class="text-right">' . number_format($val['kredit']) . '</td>
                            <td class="text-right">' . number_format($saldoDroping) . '</td>
                        </tr>';
        }

        // Close the table
        $output .= '</tbody>
                    </table>
                </div>';

        return $output;
    }
}

// Get Data transaksi droping
if (!function_exists('get_transaksi_droping')) {
    function get_transaksi_droping($transaksi)
    {
        $CI = &get_instance();
        $CI->load->helper('number'); // Load number helper if not already loaded

        // Initialize variables
        $no = 1;
        $sumofnominal = 0;

        // Start building the table
        $output = '<div class="m-b-10">
                <b class="text-inverse f-s-16"><i class="fa fa-book"></i> Data Transaksi</b> <br>
                <span class="f-s-11">Detail Data Transaksi</span>
            </div>

            <div class="table-responsive m-b-10">
                <table class="table table-condensed table-striped table-bordered text-nowrap f-s-11">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-left">UniqId</th>
                            <th class="text-left">Jenis</th>
                            <th class="text-left">Keterangan</th>
                            <th class="text-left">User Input</th>
                            <th class="text-right">Nominal</th>
                        </tr>
                    </thead>
                    <tbody>';

        if (empty($transaksi)) {
            $output .= '<tr>
                        <td class="text-center" colspan="7">No data available in table</td>
                    </tr>';
        } else {
            // Add rows for each transaction
            foreach ($transaksi as $trx) {
                $sumofnominal += $trx['nominal'];
                $output .= '<tr>
                            <td class="text-center">' . $no++ . '</td>
                            <td class="text-center">' . format_date_indo_v2($trx['tgltransaksi']) . '</td>
                            <td class="text-left">' . $trx['uniqid'] . '</td>
                            <td class="text-left">' . ($trx['dk'] == 'D' ? '<span class="label label-success f-s-9">D</span> Pemasukan' : '<span class="label label-danger f-s-9">K</span> Pengeluaran') . '</td>
                            <td class="text-left">' . (!empty($trx['keterangan']) ? $trx['keterangan'] : "--") . '</td>
                            <td class="text-left">' . str_replace(' ', '', strtolower($trx['is_username'])) . '</td>
                            <td class="text-right">' . number_format($trx['nominal']) . '</td>
                        </tr>';
            }
        }

        // Close the table
        $output .= '</tbody>
                </table>
            </div>';

        return $output;
    }
}

// Data transaksi droping kantor layanan
// Daftar transaksi yang diterima oleh kantor layanan
// 2024-06-04 01:08:16
if (!function_exists('get_transaksidroping_kantorlayanan')) {
    function get_transaksidroping_kantorlayanan($accnumber = NULL)
    {
        // insialiasi
        $_ci = &get_instance();

        // Get info data marketing
        $getMarketing = $_ci->db->select("ID_PINJAMAN, NAMA_MARKETING, DESKRIPSI_CABANG, IS_FEE")->where(['ID_PINJAMAN' => $accnumber])->get("vw_pinjaman")->row_array();

        // get pad accnumber by id pinjaman
        $accnumber = str_pad($accnumber, 8, "0", STR_PAD_LEFT);

        // get data account droping
        $getacc = $_ci->db->query("SELECT accnumber, noreg, tglpengajuan, namaktp, plafond, nom_bpp, nom_mutasi, nom_feemarketing, jmlpotongan, jmlterimakotor  FROM vw_droping_account WHERE accnumber = '{$accnumber}'")->row_array();

        // get data transaksi droping pencairan
        $_ci->db->where("accnumber", $accnumber);
        $_ci->db->order_by("tgltransaksi", "ASC");
        $trx_droping = $_ci->db->get('vw_droping_transaksi_pencairan_layanan')->result_array();

        $saldo = $getacc['nom_bpp'] + $getacc['nom_mutasi'] + $getacc['nom_feemarketing'];

        // Transaksi Mutasi Rekening Droping Pencairan ke Debitur
        // 2024-06-01 00:55:10
        $output = '	<div class="m-b-10">
						<b class="text-inverse f-s-16"><i class="fa fa-book"></i> Transaksi Droping Pencairan Kantor Layanan</b> <br>
						<span class="f-s-11">Data Transaksi Droping Kantor Layanan</span>
					</div>';

        $output .= '<div>';
        $output .= '<table class="table table-condensed table-bordered">';
        $output .= '	<tr class="bg-silver">
							<th class="text-center width-100">Tanggal</th>
							<th class="text-left">Keterangan</th>
							<th class="text-right width-150">(Db) Debet</th>
							<th class="text-right width-150">(Cr) Kredit</th>
							<th class="text-right width-150">Sisa Pencairan Kantor Layanan</th>
						</tr>';
        $output .= '	<tr>
							<td class="text-center">' . format_date_indo_v2($getacc['tglpengajuan']) . '</td>
							<td class="text-left">
								<span class="text-primary">' . $getacc['accnumber'] . '</span> <br>
								<b>Saldo Awal Kantor Layanan</b> <br>
								Uraian : BPP + Fee (3%) + Biaya Mutasi
							</td>
							<td class="text-right">' . number_format($saldo) . '</td>
							<td class="text-right">0</td>
							<td class="text-right">' . number_format($saldo) . '</td>
						</tr>';

        foreach ($trx_droping as $val) {
            $saldo = $saldo + ($val['debet'] - $val['kredit']);

            $output .= '	<tr>
								<td class="text-center">' . format_date_indo_v2($val['tgltransaksi']) . '</td>
								<td class="text-left">
									<span class="text-primary">' . $val['accnumber'] . '|' . $val['accvirtual'] . '</span><br>
									<b>' . $val['keterangan'] . '</b> <br>
									Uraian : ' . $val['keterangan'] . '; ' . $val['uraian'] . '
								</td>
								<td class="text-right">' . number_format($val['debet']) . '</td>
								<td class="text-right">' . number_format($val['kredit']) . '</td>
								<td class="text-right">' . number_format($saldo) . '</td>
							</tr>';
        }

        $output .= '</table>';
        $output .= '</div>';

        // Cek apakah sudah di droping atau belum ke table transaksi dengan status droping-bpp
        $cekTransaksiDropBpp = $_ci->db->query("SELECT idtransaksi, accnumber, nominal FROM los_transaksi_droping WHERE accnumber = '{$accnumber}' AND keterangan = 'Droping BPP'")->row_array();
        if (!empty($cekTransaksiDropBpp)) {
            $statusBpp = '<span class="text-green">Droping BPP Sudah di proses oleh pusat</span>';
            $nominalBpp = 0;
        } else {
            $statusBpp = '<span class="text-red">Droping BPP masih dalam proses</span>';
            $nominalBpp = $getacc['nom_bpp'];
        }

        // Cek apakah sudah di droping atau belum ke table transaksi dengan status droping-mutasi
        $cekTransaksiDropMutasi = $_ci->db->query("SELECT idtransaksi, accnumber, nominal FROM los_transaksi_droping WHERE accnumber = '{$accnumber}' AND keterangan = 'Droping Mutasi'")->row_array();
        if (!empty($cekTransaksiDropMutasi)) {
            $statusMutasi = '<span class="text-green">Droping Mutasi Sudah di proses oleh pusat</span>';
            $nominalMutasi = 0;
        } else {
            $statusMutasi = '<span class="text-red">Droping Mutasi masih dalam proses</span>';
            $nominalMutasi = $getacc['nom_mutasi'];
        }

        // Cek apakah sudah di droping atau belum ke table transaksi dengan status droping fee agent (3%)
        $cekTransaksiDropFeeAgent = $_ci->db->query("SELECT idtransaksi, accnumber, nominal FROM los_transaksi_droping WHERE accnumber = '{$accnumber}' AND keterangan = 'Droping Fee Agent'")->row_array();
        if (!empty($cekTransaksiDropFeeAgent)) {
            $statusFeeAgent = '<span class="text-green">Droping Mutasi Sudah di proses oleh pusat</span>';
            $nominalFeeAgent = 0;
        } else {
            $statusFeeAgent = '<span class="text-red">Droping Mutasi masih dalam proses</span>';
            $nominalFeeAgent = $getacc['nom_feemarketing'];
        }

        $output .= '<div class="m-b-10">
						<b class="text-inverse f-s-16"><i class="fa fa-book"></i> Rincian Transaksi Droping Pencairan Kantor Layanan</b> <br>
						<span class="f-s-11">Status Transaksi Droping Rincian Kantor Layanan</span>
					</div>';

        $output .= '<table class="table table-condensed table-bordered">
						<tbody>
							<tr class="bg-silver">
								<th class="text-center width-100">Tanggal</th>
								<th class="text-left" colspan="3">Keterangan</th>
								<th class="text-right width-150">Nominal</th>
							</tr>
							<tr>
								<td class="text-center">' . format_date_indo_v2($getacc['tglpengajuan']) . '</td>
								<td class="text-left" colspan="3">
									<span class="text-primary">' . $getacc['accnumber'] . '</span> <br>
									<div><b>Nominal BPP</b></div>
									<div>Status Droping : ' . $statusBpp . '</div>
								</td>
								<td class="text-right">' . number_format($nominalBpp) . '</td>
							</tr>
							<tr>
								<td class="text-center">' . format_date_indo_v2($getacc['tglpengajuan']) . '</td>
								<td class="text-left" colspan="3">
									<span class="text-primary">' . $getacc['accnumber'] . '</span> <br>
									<div><b>Fee Marketing Agent</b></div>
									<div>Status Droping : ' . $statusFeeAgent . '</div>
									<div>Uraian : Nominal Fee Agent Marketing (' . decimal_to_percentage($getMarketing['IS_FEE']) . '%)</div>
									<div>' . $getMarketing['NAMA_MARKETING'] . '</div>
									<div>' . $getMarketing['DESKRIPSI_CABANG'] . '</div>
								</td>
								<td class="text-right">' . number_format($nominalFeeAgent) . '</td>
							</tr>
							<tr>
								<td class="text-center">' . format_date_indo_v2($getacc['tglpengajuan']) . '</td>
								<td class="text-left" colspan="3">
									<span class="text-primary">' . $getacc['accnumber'] . '</span> <br>
									<div><b>Nominal Mutasi (Jika Pengajuan Mutasi)</b></div>
									<div>Status Droping : ' . $statusMutasi . '</div>
								</td>
								<td class="text-right">' . number_format($nominalMutasi) . '</td>
							</tr>

							<tr class="bg-silver">
								<td class="text-left" colspan="4"><b>Jumlah</b></td>
								<td class="text-right"><b>' . number_format($nominalBpp + $nominalMutasi + $nominalFeeAgent) . '</b></td>
							</tr>
						</tbody>
					</table>';

        return $output;
    }
}

// Info detail simulasi pembiayaan
if (!function_exists('detail_simulasi_pembiayaan')) {
    function detail_simulasi_pembiayaan($pinjamanId)
    {
        // Initial
        $_CI = &get_instance();

        // query
        $_CI->db->select("*");
        $_CI->db->from("vw_pinjaman");
        $_CI->db->where("ID_PINJAMAN", $pinjamanId);

        // Output
        $row = $_CI->db->get()->row_array();

        // estmasi usia saat pengajuan
        $usia_pengajuan = usia_saat_pengajuan($row['TANGGAL_LAHIR'], $row['TANGGAL_PENGAJUAN']);

        // estimasi tanggal jatuh tempo
        $tgl_jatuh_tempo = tgl_jatuh_tempo($row['TANGGAL_PENGAJUAN'], $row['TENOR']);

        // estimasi usia saat jatuh tempo
        $usia_jatuh_tempo = usia_jatuh_tempo($row['TANGGAL_LAHIR'], $tgl_jatuh_tempo);

        // Cek Jenis Rate
        // Untuk kantor layanan dan kantor pusat
        if ($_CI->session->userdata('sess_id_group_cabang') == 1) {
            if ($row['JENIS_BUNGA'] == 'EFFEKTIF') {
                $jenis_rate = $row['JENIS_BUNGA'] . ' | ' . $row['BUNGA_EFF_KOP'] . '% | ' . $row['BUNGA_EFF_BANK'] . '%';
            } else {
                $jenis_rate = $row['JENIS_BUNGA'] . ' | ' . (number_format($row['BUNGA_FLAT'] * 100, 2)) . '% | ' . (number_format($row['BUNGA_FLAT_BANK'] * 100, 2)) . '%';
            }
        } else {
            if ($row['JENIS_BUNGA'] == 'EFFEKTIF') {
                $jenis_rate = $row['JENIS_BUNGA'] . ' | ' . $row['BUNGA_EFF_KOP'] . '%';
            } else {
                $jenis_rate = $row['JENIS_BUNGA'] . ' | ' . (number_format($row['BUNGA_FLAT'] * 100, 2)) . '%';
            }
        }

        // Cek tanggal cair
        if ($row['TANGGAL_CAIR'] !== NULL) {
            $tglCairEnduser = format_date_indo_v2($row['TANGGAL_CAIR']);
            $tglJatuhTemp = format_date_indo_v2($row['TANGGAL_JATUH_TEMPO']);
            $usiaJatuhTempo = $usia_jatuh_tempo;
        } else {
            $tglCairEnduser = 'PROSES';
            $tglJatuhTemp = 'PROSES';
            $usiaJatuhTempo = 'PROSES';
        }

        // Cek Fee Marketing
        $nomFeeMarketing = $row['PLAFOND'] * $row['IS_FEE'];

        // Hitung Asuransi
        $nomAssEnduser = $row['NOMINAL_BY_ASS_KOP'] - $nomFeeMarketing;
        $nomFlaging = $row['NOMINAL_BY_FLAG'];
        $nomLainnya = $row['NOMINAL_BY_LAINNYA'];
        $injectAsuransi = $nomAssEnduser + $nomFlaging + $nomLainnya;

        // Hitung Jumlah Biaya Potongan
        $byPotongan = $injectAsuransi + $nomFeeMarketing + $row['NOMINAL_BPP'] + $row['NOMINAL_BY_ADM'] + $row['NOMINAL_BY_TATALAKASAN'] + $row['NOMINAL_BY_PROVISI'] + $row['NOMINAL_BY_MUTASI'] + $row['NOMINAL_BY_BUKA_REKENING'] + $row['NOMINAL_POT_UM'];

        // Hitung terima kotor
        $terimaKotor = $row['PLAFOND'] - $byPotongan;

        // Hitung terima bersih
        $terimaBersih = $terimaKotor - $row['NOMINAL_PELUNASAN'];

        $html  = '';
        $html .= '
		<div class="m-b-10">
			<b class="text-inverse f-s-16"><i class="fa fa-book"></i> Informasi Pengajuan</b> <br>
			<span class="f-s-11">Detail Informasi Pengajuan</span>
		</div>

		<div class="row">
			<div class="col-md-4">
				<table class="table table-condensed">
					<tbody>
						<tr class="bg-grey-transparent-1">
							<td class="text-left" colspan="3"><b>Data Pengajuan</b></td>
						</tr>
						<tr>
							<td class="text-left" colspan="3">
								<div><b>Bank Sumberdana</b></div>
								<div>(' . $row['KODE_CABANG_SUMBERDANA'] . ') ' . $row['NAMA_SUMBERDANA'] . '</div>
							</td>
						</tr>
						<tr>
							<td class="text-left" colspan="3">
								<div><b>Kantor Layanan</b></div>
								<div>(' . $row['KODE_CABANG'] . ') ' . $row['NAMA_CABANG'] . '</div>
							</td>
						</tr>
						<tr>
							<td class="text-left" colspan="3">
								<div><b>Tanggal Input</b></div>
								<div>' . $row['TANGGAL_PENGAJUAN_DT'] . '</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="col-md-4">
				<table class="table table-condensed">
					<tbody>
						<tr class="bg-grey-transparent-1">
							<td class="text-left" colspan="3"><b>Data Pengajuan dan Jatuh Tempo</b></td>
						</tr>
						<tr>
							<td class="text-left" colspan="3">
								<div><b>Tanggal Perhitungan Simulasi</b></div>
								<div>' . format_date_indo_v2($row['TANGGAL_PENGAJUAN']) . ' <span class="pull-right">' . $usia_pengajuan . '</span></div>
							</td>
						</tr>
						<tr>
							<td class="text-left" colspan="3">
								<div><b>Tanggal Cair</b></div>
								<div>' . $tglCairEnduser . '</div>
							</td>
						</tr>
						<tr>
							<td class="text-left" colspan="3">
								<div><b>Tanggal Jatuh Tempo</b></div>
								<div>' . $tglJatuhTemp . ' <span class="pull-right">' . $usiaJatuhTempo . '</span></div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

		<div class="m-b-10">
			<b class="text-inverse f-s-16"><i class="fa fa-book"></i> Informasi Pembiayaan</b> <br>
			<span class="f-s-11">Detail Informasi Pembiayaan</span>
		</div>

		<div class="row">
			<div class="col-md-4">
				<table class="table table-condensed">
					<tbody>
						<tr class="bg-grey-transparent-1">
							<td class="text-left" colspan="3"><b>Informasi pembiayaan</b></td>
						</tr>
						<tr>
							<td class="text-left">Gaji Bersih</td>
							<td class="text-center">:</td>
							<td class="text-right">
								<div class="pull-right">' . number_format($row['PO_TOTALBERSIH']) . '</div>
							</td>
						</tr>
						<tr>
							<td class="text-left">Plafond</td>
							<td class="text-center">:</td>
							<td class="text-right">' . number_format($row['PLAFOND']) . '</td>
						</tr>
						<tr>
							<td class="text-left">Tenor</td>
							<td class="text-center">:</td>
							<td class="text-right">' . number_format($row['TENOR']) . ' Bulan </td>
						</tr>
						<tr>
							<td class="text-left">Angsuran</td>
							<td class="text-center">:</td>
							<td class="text-right">' . number_format($row['ANGSURAN_KOP']) . '</td>
						</tr>
						<tr>
							<td class="text-left">Rate</td>
							<td class="text-center">:</td>
							<td class="text-right">' . $jenis_rate . '</td>
						</tr>

						<tr class="bg-grey-transparent-1">
							<td class="text-left" colspan="3"><b>Informasi Produk</b></td>
						</tr>
						<tr>
							<td class="text-left">Instansi</td>
							<td class="text-center">:</td>
							<td class="text-right">
								<div class="pull-right">(' . $row['KODE_INSTANSI'] . ') ' . strtoupper($row['NAMA_INSTANSI']) . '</div>
							</td>
						</tr>
						<tr>
							<td class="text-left">Jenis Kredit</td>
							<td class="text-center">:</td>
							<td class="text-right">
								<div class="pull-right"> - </div>
							</td>
						</tr>
						<tr>
							<td class="text-left">Produk</td>
							<td class="text-center">:</td>
							<td class="text-right">
								<div class="pull-right">' . str_replace('_', ' ', $row['PRODUK']) . '</div>
							</td>
						</tr>
						<tr>
							<td class="text-left">Jenis Biaya</td>
							<td class="text-center">:</td>
							<td class="text-right">
								<div class="pull-right">' . $row['NAMA_JENIS_BIAYA'] . '</div>
							</td>
						</tr>
						<tr>
							<td class="text-left bg-grey-transparent-1" colspan="3">
								<div class="small"><b>Mitra Take Over</b></div>
								<div>' . $row['NAMA_MITRA'] . '</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="col-md-4">
				<table class="table table-condensed">
					<tbody>
						<tr class="bg-grey-transparent-1">
							<td class="text-left" colspan="3"><b>Rincian biaya potongan</b></td>
						</tr>
						<tr>
							<td class="text-left" style="width: 170px;">Nominal BPP</td>
							<td class="text-center" style="width: 10px;">:</td>
							<td class="text-right">' . number_format($row['NOMINAL_BPP']) . '</td>
						</tr>
						<tr>
							<td class="text-left" style="width: 170px;">Fee Marketing (3%)</td>
							<td class="text-center" style="width: 10px;">:</td>
							<td class="text-right">' . number_format($row['PLAFOND'] * $row['IS_FEE']) . '</td>
						</tr>
						<tr>
							<td class="text-left">Biaya Asuransi</td>
							<td class="text-center">:</td>
							<td class="text-right">' . number_format($injectAsuransi) . '</td>
						</tr>
						<tr>
							<td class="text-left">Biaya Administrasi</td>
							<td class="text-center">:</td>
							<td class="text-right">' . number_format($row['NOMINAL_BY_ADM']) . '</td>
						</tr>
						<tr>
							<td class="text-left">Biaya Tatalaksana</td>
							<td class="text-center">:</td>
							<td class="text-right">' . number_format($row['NOMINAL_BY_TATALAKASAN']) . '</td>
						</tr>
						<tr>
							<td class="text-left">Biaya Provisi</td>
							<td class="text-center">:</td>
							<td class="text-right">' . number_format($row['NOMINAL_BY_PROVISI']) . '</td>
						</tr>
						<tr>
							<td class="text-left">Biaya Mutasi</td>
							<td class="text-center">:</td>
							<td class="text-right">' . number_format($row['NOMINAL_BY_MUTASI']) . '</td>
						</tr>
						<tr>
							<td class="text-left">Biaya Buka Rekening</td>
							<td class="text-center">:</td>
							<td class="text-right">' . number_format($row['NOMINAL_BY_BUKA_REKENING']) . '</td>
						</tr>
						<tr>
							<td class="text-left">Retensi Angsuran</td>
							<td class="text-center">:</td>
							<td class="text-right"> <span class="pull-left">(0)</span> 0</td>
						</tr>
						<tr>
							<td class="text-left">Blokir Angsuran</td>
							<td class="text-center">:</td>
							<td class="text-right"> <span class="pull-left">(' . $row['POT_UM'] . ')</span> ' . number_format($row['NOMINAL_POT_UM']) . '</td>
						</tr>
						<tr class="bg-grey-transparent-1">
							<td class="text-left"><b>Jumlah Biaya</b></td>
							<td class="text-center">:</td>
							<td class="text-right"><b>' . number_format($byPotongan) . '</b></td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="col-md-4">
				<table class="table table-condensed">
					<tbody>
						<tr class="bg-grey-transparent-1">
							<td class="text-left" colspan="3"><b>Rincian penerimaan</b></td>
						</tr>
						<tr>
							<td class="text-left" style="width: 180px;">(A) Plafond</td>
							<td class="text-center" style="width: 10px;">:</td>
							<td class="text-right">' . number_format($row['PLAFOND']) . '</td>
						</tr>
						<tr>
							<td class="text-left">(B) Jumlah biaya potongan</td>
							<td class="text-center">:</td>
							<td class="text-right">' . number_format($byPotongan) . '</td>
						</tr>
						<tr class="bg-grey-transparent-1">
							<td class="text-left"><b>Terima kotor</b> <small>(A-B)</small></td>
							<td class="text-center">:</td>
							<td class="text-right"><b>' . number_format($terimaKotor) . '</b></td>
						</tr>
						<tr>
							<td class="text-left">(C) Nominal Pelunasan</td>
							<td class="text-center">:</td>
							<td class="text-right">' . number_format($row['NOMINAL_PELUNASAN']) . '</td>
						</tr>
						<tr class="bg-grey-transparent-1">
							<td class="text-left"><b>Terima bersih</b> <small>(A-B) - (C)</small></td>
							<td class="text-center">:</td>
							<td class="text-right"><b>' . number_format($terimaBersih) . '</b></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>';

        return $html;
    }
}

// Mutasi Account Droping
if (!function_exists('helpinfo_mutasi_accdroping')) {
    function helpinfo_mutasi_accdroping($accnumber = NULL)
    {
        // insialiasi
        $_ci = &get_instance();

        // Get info data marketing
        $getMarketing = $_ci->db->select("ID_PINJAMAN, NAMA_MARKETING, DESKRIPSI_CABANG, IS_FEE")->where(['ID_PINJAMAN' => $accnumber])->get("vw_pinjaman")->row_array();

        // get pad accnumber by id pinjaman
        $accnumber = str_pad($accnumber, 8, "0", STR_PAD_LEFT);

        // get data account droping
        $getacc = $_ci->db->query("SELECT accnumber, noreg, tglpengajuan, namaktp, plafond, nom_bpp, nom_mutasi, nom_feemarketing, jmlpotongan, jmlterimakotor  FROM vw_droping_account WHERE accnumber = '{$accnumber}'")->row_array();

        // get data transaksi droping pencairan
        $_ci->db->where("accnumber", $accnumber);
        $_ci->db->order_by("tgltransaksi", "ASC");
        $trx_droping = $_ci->db->get('vw_droping_transaksi_pencairan')->result_array();

        $saldoAwalTerimaKotor = $getacc['plafond'] - $getacc['jmlterimakotor'];

        // Transaksi Mutasi Rekening Droping Pencairan ke Debitur
        // 2024-06-01 00:55:10
        $output = '	<div class="m-b-10">
						<b class="text-inverse f-s-16"><i class="fa fa-book"></i> Transaksi Droping Pencairan Debitur</b> <br>
						<span class="f-s-11">Data Transaksi Droping Pencairan ke Debitur</span>
					</div>';

        $output .= '<div>';
        $output .= '<table class="table table-condensed table-bordered">';
        $output .= '	<tr class="bg-silver">
							<th class="text-center width-100">Tanggal</th>
							<th class="text-left">Keterangan</th>
							<th class="text-right width-150">(Db) Debet</th>
							<th class="text-right width-150">(Cr) Kredit</th>
							<th class="text-right width-150">Sisa Pencairan Debitur</th>
						</tr>';
        $output .= '	<tr>
							<td class="text-center">' . format_date_indo_v2($getacc['tglpengajuan']) . '</td>
							<td class="text-left">
								<span class="text-primary">' . $getacc['accnumber'] . '</span> <br>
								<b>Saldo Awal Terima Kotor Debitur</b> <br>
								Uraian : Plafond - Jumlah Terima Kotor
							</td>
							<td class="text-right">' . number_format($saldoAwalTerimaKotor) . '</td>
							<td class="text-right">0</td>
							<td class="text-right">' . number_format($saldoAwalTerimaKotor) . '</td>
						</tr>';

        foreach ($trx_droping as $val) {
            $saldoAwalTerimaKotor = $saldoAwalTerimaKotor + ($val['debet'] - $val['kredit']);

            $output .= '	<tr>
								<td class="text-center">' . format_date_indo_v2($val['tgltransaksi']) . '</td>
								<td class="text-left">
									<span class="text-primary">' . $val['accnumber'] . '|' . $val['accvirtual'] . '</span><br>
									<b>' . $val['keterangan'] . '</b> <br>
									Uraian : ' . $val['uraian'] . '
								</td>
								<td class="text-right">' . number_format($val['debet']) . '</td>
								<td class="text-right">' . number_format($val['kredit']) . '</td>
								<td class="text-right">' . number_format($saldoAwalTerimaKotor) . '</td>
							</tr>';
        }

        $output .= '</table>';
        $output .= '</div>';
        return $output;
    }
}

# cek status antrian dan posisi antrian
# 2023-02-07 14:25:11
if (!function_exists('statuscek_validasibank')) {

    function statuscek_validasibank($id = NULL)
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

        if ($data->STATUS_DAFNOM == 'Y') {
            # cek status reject
            if ($data->STATUS_REJECT == 'Y') {
                $status_validasi_bank = '<i class="fas fa-times-circle fa-fw text-red"></i> DI REJECT OLEH BANK';
            } else {
                if ($data->STATUS_APPROVAL == 'Y' && $data->STATUS_REJECT == 'N') {
                    $status_validasi_bank = '<i class="fas fa-check-circle fa-fw text-green"></i> DISETUJUI OLEH BANK';
                } else {
                    $status_validasi_bank = '<i class="fas fa-question-circle fa-fw text-warning"></i> PROSES PEMERIKSAAN BANK';
                }
            }
        } else {
            $status_validasi_bank = '<i class="fas fa-exclamation-circle fa-fw text-red"></i> <span class="text-red">BELUM DAFNOM</span>';
        }

        # callback
        return $status_validasi_bank;
    }
}
