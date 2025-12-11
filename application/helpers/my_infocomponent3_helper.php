<?php

/**
 * MY_Infocomponent3_helper.php
 *
 * @package    CodeIgniter
 * @subpackage Helpers
 * @author     Ridwan Panji Akbar (Oneread), Darva Drasthya (Oneread)
 * @license    https://opensource.org/licenses/MIT MIT License
 * @version    1.0.0
 *
 * @description
 * File ini adalah helper kustom untuk komponen informasi dalam aplikasi CodeIgniter.
 * Helper ini digunakan untuk menampilkan informasi terkait debitur, pinjaman, dan simulasi pembiayaan kredit multiguna (KMG).
 * data, perhitungan logika tertentu, atau utilitas lainnya yang relevan dengan
 * "Infocomponent1".
 *
 */

// Info Profile Box
// Master Table Data Debitur (los_debitur)
if (!function_exists('infodebitur_profile_box')) {
    /**
     * Mengambil data debitur dan menampilkan box profil HTML.
     *
     * @param int $idDebitur ID_DEBITUR dari tabel los_debitur
     * @return string HTML yang bisa langsung ditampilkan di view
     */
    function infodebitur_profile_box($idDebitur)
    {
        $CI = &get_instance();

        // Ambil data debitur
        $query = $CI->db->get_where('los_debitur', ['ID_DEBITUR' => $idDebitur]);
        $data = $query->row();

        // Jika data tidak ditemukan, kembalikan teks kosong
        if (!$data) {
            return '<div class="text-danger">Data debitur tidak ditemukan.</div>';
        }

        // Build HTML output
        $html = '<div class="media media-sm">
                    <a class="media-left" href="javascript:;">
                        <img src="' . base_url('assets/assets/image/user-images-default.png') . '" class="media-object rounded" style="width: 73px;">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading m-b-5">' . htmlspecialchars($data->NAMA_DEBITUR) . ' (' . htmlspecialchars($data->NO_REGISTRASI) . ')</h4>
                        <ul class="list-unstyled m-b-0 f-s-11">
                            <li>' . htmlspecialchars($data->ALAMAT) . ' RT/RW ' . htmlspecialchars($data->RTRW) . '</li>
                            <li>KEL. ' . htmlspecialchars($data->KELURAHAN) . ', KEC. ' . htmlspecialchars($data->KECAMATAN) . ', KAB/KOTA. ' . htmlspecialchars($data->KABKOT) . '</li>
                            <li>' . htmlspecialchars($data->PROVINISI) . ', ' . htmlspecialchars($data->KODE_POS) . '</li>
                        </ul>
                    </div>
                </div>';

        return $html;
    }
}

// Info Data KTP Pemohon
// Master Table Data Debitur (los_debitur)
if (!function_exists('infodebitur_ktp_pemohon')) {
    function infodebitur_ktp_pemohon($debiturId, $style_table = 'table table-condensed')
    {
        // Initial
        $_CI = &get_instance();

        // query
        $_CI->db->select("*");
        $_CI->db->from("los_debitur");
        $_CI->db->where("ID_DEBITUR", $debiturId);

        // Output
        $row = $_CI->db->get()->row();

        $html  = '';
        $html .= '';

        $html .= '
        <div class="m-b-10">
            <div class="f-s-13"><b>Data Identitas Pemohon (KTP)</b></div>
        </div>

        <table class="' . $style_table . '">
            <tbody>
                <tr>
                    <td class="width-150">Nomor Identitas (NIK)</td>
                    <td>' . $row->NIK_KTP . '</td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>' . $row->NAMA_DEBITUR . '</td>
                </tr>
                <tr>
                    <td>Tempat, Tanggal Lahir</td>
                    <td>' . $row->TEMPAT_LAHIR . ', ' . format_date_indo_v2($row->TANGGAL_LAHIR) . '</td>
                </tr>
                <tr>
                    <td>Jenis Kelamin</td>
                    <td>' . jenis_kelamin($row->JENIS_KELAMIN) . '</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>' . $row->ALAMAT . '</td>
                </tr>
                <tr>
                    <td><span class="m-l-20">RT/RW</span></td>
                    <td>' . split_rtrw($row->RTRW, 'rt') . ' / ' . split_rtrw($row->RTRW, 'rw') . '</td>
                </tr>
                <tr>
                    <td><span class="m-l-20">Kel/Desa</span></td>
                    <td>' . $row->KELURAHAN . '</td>
                </tr>
                <tr>
                    <td><span class="m-l-20">Kecamatan</span></td>
                    <td>' . $row->KECAMATAN . '</td>
                </tr>
                <tr>
                    <td><span class="m-l-20">Kota/Kabupaten</span></td>
                    <td>' . $row->KABKOT . '</td>
                </tr>
                <tr>
                    <td><span class="m-l-20">Kode Pos</span></td>
                    <td>' . $row->KODE_POS . '</td>
                </tr>
                <tr>
                    <td><span class="m-l-20">Provinsi</span></td>
                    <td>' . $row->PROVINISI . '</td>
                </tr>
                <tr>
                    <td>Agama</td>
                    <td>' . $row->AGAMA . '</td>
                </tr>
                <tr>
                    <td>Status Perkawinan</td>
                    <td>' . $row->STATUS_KAWIN . '</td>
                </tr>
                <tr>
                    <td>Pekerjaan</td>
                    <td>' . $row->PEKERJAAN . '</td>
                </tr>
                <tr>
                    <td>Kewarganegaraan</td>
                    <td>WNI</td>
                </tr>
                <tr>
                    <td>Tanggal Terbit</td>
                    <td>' . is_ktp_exp($row->TANGGAL_TERBIT_KTP, 'd/m/Y') . '</td>
                </tr>
                <tr>
                    <td>Berlaku Hingga</td>
                    <td>' . is_ktp_exp($row->TANGGAL_EXP_KTP, 'd/m/Y') . '</td>
                </tr>
            </tbody>
        </table>';

        return $html;
    }
}

// Info Data KTP Pasangan
// Master Table Data Debitur (los_debitur)
if (!function_exists('infodebitur_ktp_pasangan')) {
    function infodebitur_ktp_pasangan($debiturId, $style_table = 'table table-condensed')
    {
        // Initial
        $_CI = &get_instance();

        // query
        $_CI->db->select("*");
        $_CI->db->from("los_debitur");
        $_CI->db->where("ID_DEBITUR", $debiturId);

        // Output
        $row = $_CI->db->get()->row();

        $html  = '';
        $html .= '';

        $html .= '
        <div class="m-b-10">
            <div class="f-s-13"><b>Data Identitas Pasangan (KTP)</b></div>
        </div>

        <table class="' . $style_table . '">
            <tbody>
                <tr>
                    <td class="width-150">Nomor Identitas (NIK)</td>
                    <td>' . $row->PSG_NIK_KTP . '</td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>' . $row->PSG_NAMA . '</td>
                </tr>
                <tr>
                    <td>Tempat, Tanggal Lahir</td>
                    <td>' . $row->PSG_TEMPAT_LAHIR . ', ' . format_date_indo_v2($row->PSG_TANGGAL_LAHIR) . '</td>
                </tr>
                <tr>
                    <td>Jenis Kelamin</td>
                    <td> -- </td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>' . $row->PSG_ALAMAT . '</td>
                </tr>
                <tr>
                    <td><span class="m-l-20">RT/RW</span></td>
                    <td>' . split_rtrw($row->PSG_RTRW, 'rt') . ' / ' . split_rtrw($row->PSG_RTRW, 'rw') . '</td>
                </tr>
                <tr>
                    <td><span class="m-l-20">Kel/Desa</span></td>
                    <td>' . $row->PSG_KELURAHAN . '</td>
                </tr>
                <tr>
                    <td><span class="m-l-20">Kecamatan</span></td>
                    <td>' . $row->PSG_KECAMATAN . '</td>
                </tr>
                <tr>
                    <td><span class="m-l-20">Kota/Kabupaten</span></td>
                    <td>' . $row->PSG_KABKOT . '</td>
                </tr>
                <tr>
                    <td><span class="m-l-20">Kode Pos</span></td>
                    <td>' . $row->PSG_KODE_POS . '</td>
                </tr>
                <tr>
                    <td><span class="m-l-20">Provinsi</span></td>
                    <td>' . $row->PSG_PROVINSI . '</td>
                </tr>
                <tr>
                    <td>Agama</td>
                    <td> -- </td>
                </tr>
                <tr>
                    <td>Status Perkawinan</td>
                    <td> ' . $row->STATUS_KAWIN . ' </td>
                </tr>
                <tr>
                    <td>Pekerjaan</td>
                    <td> -- </td>
                </tr>
                <tr>
                    <td>Kewarganegaraan</td>
                    <td> -- </td>
                </tr>
                <tr>
                    <td>Tanggal Terbit</td>
                    <td>' . is_ktp_exp($row->PSG_TANGGAL_TERBIT_KTP, 'd/m/Y') . '</td>
                </tr>
                <tr>
                    <td>Berlaku Hingga</td>
                    <td>' . is_ktp_exp($row->PSG_TANGGAL_EXP_KTP, 'd/m/Y') . '</td>
                </tr>
            </tbody>
        </table>';

        return $html;
    }
}

// Info Data Alamat Lengkap
// Master Table Data Debitur (los_debitur)
if (!function_exists('infodebitur_alamat_lengkap')) {
    /**
     * Menampilkan HTML alamat lengkap debitur (KTP & domisili) dalam format tabel.
     *
     * @param int $debiturId ID debitur dari tabel los_debitur
     * @param string $style_table Kelas CSS tabel (opsional)
     * @return string HTML blok alamat lengkap
     */
    function infodebitur_alamat_lengkap($debiturId, $style_table = 'table table-condensed')
    {
        // Init instance CI
        $_CI = &get_instance();

        // SELECT hanya kolom yang diperlukan
        $_CI->db->select('
            ALAMAT, RTRW, KELURAHAN, KECAMATAN, KABKOT, KODE_POS, PROVINISI, URL_MAPS,
            DOMISILI_ALAMAT, DOMISILI_RTRW, DOMISILI_KELURAHAN, DOMISILI_KECAMATAN,
            DOMISILI_KABKOT, DOMISILI_KODE_POS, DOMISILI_URL_MAPS, LATITUDE,
            LONGITUDE, DOMISILI_LATITUDE, DOMISILI_LONGITUDE
        ');
        $_CI->db->from("los_debitur");
        $_CI->db->where("ID_DEBITUR", $debiturId);

        $row = $_CI->db->get()->row();

        if (!$row) {
            return '<div class="text-danger">Data debitur tidak ditemukan.</div>';
        }

        // ========================
        // FORMAT ALAMAT KTP
        // ========================
        $alamat_ktp = $row->ALAMAT . ' RT/RW ' . $row->RTRW . ' KEL/Desa ' . $row->KELURAHAN . ' KEC. ' . $row->KECAMATAN . ' Kab/Kota ' . $row->KABKOT . ', ' . $row->KODE_POS . ', ' . $row->PROVINISI;

        // Validasi: URL_MAPS KTP tidak valid jika salah satu NULL/kosong
        if (empty($row->URL_MAPS) || empty($row->LATITUDE) || empty($row->LONGITUDE)) {
            $link_ktp = '<a href="javascript:;" onclick="alert(\'Lokasi belum diisi.\')" style="text-decoration: none;"><i class="fas fa-globe"></i> Visit Link</a>';
        } else {
            $link_ktp = anchor_popup($row->URL_MAPS, '<i class="fas fa-globe"></i> Visit Link', ['style' => 'text-decoration: none;']);
        }

        // ========================
        // FORMAT ALAMAT DOMISILI
        // ========================
        $alamat_domisili = $row->DOMISILI_ALAMAT . ' RT/RW ' . $row->DOMISILI_RTRW . ' KEL/Desa ' . $row->DOMISILI_KELURAHAN . ' KEC. ' . $row->DOMISILI_KECAMATAN . ' Kab/Kota ' . $row->DOMISILI_KABKOT . ', ' . $row->DOMISILI_KODE_POS;

        // Validasi: URL_MAPS DOMISILI tidak valid jika salah satu NULL/kosong
        if (empty($row->DOMISILI_URL_MAPS) || empty($row->DOMISILI_LATITUDE) || empty($row->DOMISILI_LONGITUDE)) {
            $link_domisili = '<a href="javascript:;" onclick="alert(\'Lokasi belum diisi.\')" style="text-decoration: none;"><i class="fas fa-globe"></i> Visit Link</a>';
        } else {
            $link_domisili = anchor_popup($row->DOMISILI_URL_MAPS, '<i class="fas fa-globe"></i> Visit Link', ['style' => 'text-decoration: none;']);
        }

        // Output HTML
        $html = '
        <div class="m-b-5">
            <div class="f-s-13"><b>Data Alamat Lengkap</b></div>
        </div>
        <table class="' . $style_table . '">
            <tbody>
                <tr>
                    <td class="width-150">Alamat Pemohon</td>
                    <td>
                        <div>' . $alamat_ktp . '</div>
                        <div>' . $link_ktp . '</div>
                    </td>
                </tr>
                <tr>
                    <td>Alamat Domisili</td>
                    <td>
                        <div>' . $alamat_domisili . '</div>
                        <div>' . $link_domisili . '</div>
                    </td>
                </tr>
            </tbody>
        </table>';

        return $html;
    }
}

// Info Data Lainnya
// Master Table Data Debitur (los_debitur)
if (!function_exists('infodebitur_lainnya')) {
    function infodebitur_lainnya($debiturId, $style_table = 'table table-condensed')
    {
        // Initial
        $_CI = &get_instance();

        // query
        $_CI->db->select("ID_DEBITUR, NO_REGISTRASI,PENDIDIKAN,NO_NPWP,NAMA_IBU,LAMA_TINGGAL,JUMLAH_TANGGUNGAN,JUMLAH_ANAK,NAMA_AHLIWARIS,NO_TLP,NO_TLP_RUMAH");
        $_CI->db->from("los_debitur");
        $_CI->db->where("ID_DEBITUR", $debiturId);

        // Output
        $row = $_CI->db->get()->row();

        $html  = '';
        $html .= '
        <div class="m-b-5">
            <div class="f-s-13"><b>Data Debitur Lainnya</b></div>
        </div>

        <table class="' . $style_table . '">
            <tbody>
                <tr>
                    <td class="width-150">Pendidikan Terakhir</td>
                    <td>' . $row->PENDIDIKAN . '</td>
                </tr>
                <tr>
                    <td>Nomor NPWP</td>
                    <td>' . $row->NO_NPWP . '</td>
                </tr>
                <tr>
                    <td>Nama Ibu Kandung</td>
                    <td>' . $row->NAMA_IBU . '</td>
                </tr>
                <tr>
                    <td>Lama Tinggal</td>
                    <td>' . $row->LAMA_TINGGAL . ' Tahun</td>
                </tr>
                <tr>
                    <td>Tanggungan Keluarga</td>
                    <td>' . $row->JUMLAH_TANGGUNGAN . ' Orang</td>
                </tr>
                <tr>
                    <td>Tanggungan Anak</td>
                    <td>' . $row->JUMLAH_ANAK . ' Orang</td>
                </tr>
                <tr>
                    <td>Nama Ahli Waris</td>
                    <td>' . $row->NAMA_AHLIWARIS . '</td>
                </tr>
                <tr>
                    <td>Nomor Telepon</td>
                    <td>' . $row->NO_TLP . ' / ' . $row->NO_TLP_RUMAH . '</td>
                </tr>
            </tbody>
        </table>';

        return $html;
    }
}

// Info Data Pegawai
// Master Table Data Debitur (los_debitur)
if (!function_exists('infodebitur_kepegawaian')) {
    function infodebitur_kepegawaian($debiturId, $style_table = 'table table-condensed')
    {
        // Initial
        $_CI = &get_instance();

        // query
        $_CI->db->select("*");
        $_CI->db->from("los_debitur");
        $_CI->db->where("ID_DEBITUR", $debiturId);

        // Output
        $row = $_CI->db->get()->row();

        //
        if ($row->JENIS_PERUSAHAAN == 1) {
            $jp = 'NEGERI';
        } elseif ($row->JENIS_PERUSAHAAN == 2) {
            $jp = 'SWASTA';
        } else {
            $jp = '--';
        }

        $html  = '';
        $html .= '';

        $html .= '
        <div class="row">
            <div class="col-md-4">
                <div class="m-b-5">
                    <div class="f-s-13"><b>Data Instansi Perusahaan</b></div>
                </div>

                <table class="' . $style_table . '">
                    <tbody>
                        <tr>
                            <td class="width-150">Nama Perusahaan</td>
							<td>' . $row->NAMA_PERUSAHAAN . '</td>
							</tr>
                        <tr>
                            <td class="width-150">Jenis Perusahaan</td>
                            <td>' . $jp . '</td>
                        </tr>
                        <tr>
                            <td class="width-150">Status Pegawai</td>
                            <td>' . info_status_pegawai($row->STATUS_PEGAWAI) . '</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="col-md-4">
                <div class="m-b-5">
                    <div class="f-s-13"><b>Data Kepegawaian</b></div>
                </div>

                <table class="' . $style_table . '">
                    <tbody>
                        <tr>
                            <td class="width-150">No Identitas Lainnya</td>
                            <td>' . $row->NO_NIK_NIP_KPN . '</td>
                        </tr>
                        <tr>
                            <td class="width-150">No Surat Keterangan</td>
                            <td>' . $row->NO_SURAT . '</td>
                        </tr>
                        <tr>
                            <td class="width-150">Tanggal Surat Keterangan</td>
                            <td>' . format_date_indo_v2($row->TANGGAL_SURAT) . '</td>
                        </tr>
                    </tbody>
                </table>
			</div>

			<div class="col-md-4">
                <div class="m-b-5">
                    <div class="f-s-13"><b>Data Lainnya</b></div>
                </div>

                <table class="' . $style_table . '">
                    <tbody>
                        <tr>
                            <td class="width-150">No BPJS</td>
                            <td>' . $row->NO_BPJS . '</td>
                        </tr>
                        <tr>
                            <td class="width-150">No Rekening Bank</td>
                            <td>' . $row->NO_REKENING_BANK . '</td>
                        </tr>
                        <tr>
                            <td class="width-150">No ATM</td>
                            <td>' . $row->NO_ATM . '</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        ';

        return $html;
    }
}

// Infor Data Pinjaman
// Master Table Data Debitur (los_debitur)
if (!function_exists('infodebitur_daftarpinjaman')) {
    function infodebitur_daftarpinjaman($where_id = [], $style_table = 'table table-condensed table-bordered')
    {
        // Jika tidak ada data, tampilkan pesan
        if (empty($where_id)) {
            return '<div class="alert alert-warning">Tidak ada data pinjaman yang tersedia.</div>';
        }

        $_CI = &get_instance();

        // Query data pinjaman
        $_CI->db->select("ID_PINJAMAN, ID_DEBITUR, NAMA_DEBITUR,TANGGAL_PENGAJUAN, TANGGAL_PENGAJUAN_DT, TANGGAL_CAIR, NO_AKAD, NO_KREDIT, NO_REGISTRASI, PRODUK, PLAFOND, TENOR, ANGSURAN_KOP, STATUS_CAIR, STATUS_PINJAMAN");
        $_CI->db->from("vw_pinjaman");
        $_CI->db->where('STATUS_CAIR', 'Y');
        $_CI->db->where($where_id);
        $_CI->db->order_by('TANGGAL_CAIR', 'asc');

        // Output
        $result = $_CI->db->get()->result();

        // Awal tabel
        $html = '
        <div class="table-responsive">
            <table class="' . $style_table . '">
                <thead>
                    <tr class="bg-silver">
                        <th class="text-left">Option</th>
                        <th class="text-left">Tgl Pengajuan</th>
                        <th class="text-left">Tgl Cair</th>
                        <th class="text-left">No Pinjaman</th>
                        <th class="text-left">No SPK</th>
                        <th class="text-left">Produk</th>
                        <th class="text-right">Plafond</th>
                        <th class="text-left">Tenor</th>
                        <th class="text-left">Last Payment</th>
                        <th class="text-left">Status Pengajuan</th>
                        <th class="text-left">Status Pinjaman</th>
                    </tr>
                </thead>
                <tbody>';

        // Iterasi data pinjaman
        foreach ($result as $data) {
            // Ambil data pembayaran terakhir
            $_CI->db->select("TANGGAL_BAYAR, JUMLAH_BAYAR");
            $_CI->db->from("los_debitur_pinjaman_bayar");
            $_CI->db->where("ID_PINJAMAN", $data->ID_PINJAMAN);
            $_CI->db->order_by('TANGGAL_BAYAR', 'asc');
            $_CI->db->order_by('ID_BAYAR', 'desc');
            $_CI->db->limit(1);
            $last_payment = $_CI->db->get()->row();

            // Handle jika tidak ada data pembayaran
            $tanggal_bayar = isset($last_payment->TANGGAL_BAYAR) ? format_date($last_payment->TANGGAL_BAYAR) : '-';
            $jumlah_bayar = isset($last_payment->JUMLAH_BAYAR) ? number_format($last_payment->JUMLAH_BAYAR) : '-';

            $detailUrl = site_url('pinjaman/detail/' . enkrip($data->ID_PINJAMAN));
            $actionLinks = '
                <a href="' . $detailUrl . '" class="btn btn-xs btn-primary"><i class="fa fa-info-circle fa-fw"></i> Detail</a>
            ';

            $html .= '
            <tr>
                <td class="text-left">' . $actionLinks . '</td>
                <td class="text-left">' . format_date($data->TANGGAL_PENGAJUAN_DT) . '</td>
                <td class="text-left">' . format_date($data->TANGGAL_CAIR) . '</td>
                <td class="text-left">' . $data->NO_KREDIT . '</td>
                <td class="text-left">' . $data->NO_AKAD . '</td>
                <td class="text-left">' . info_desc_produk($data->PRODUK) . '</td>
                <td class="text-right">' . number_format($data->PLAFOND) . '</td>
                <td class="text-left">' . number_format($data->TENOR) . ' Bulan</td>
                <td class="text-right">
                    <div><b>' . $tanggal_bayar . '</b></div>
                    <div><b>' . $jumlah_bayar . '</b></div>
                </td>
                <td class="text-left">' . is_status_cair($data->STATUS_CAIR, 'icon') . '</td>
                <td class="text-left">' . is_status_pinjaman($data->STATUS_PINJAMAN, 'icon') . '</td>
            </tr>';
        }

        // Akhiri tabel
        $html .= '
                </tbody>
            </table>
        </div>';

        return $html;
    }
}

// Infor Data Pinjaman Header Info
// Master Table Data Debitur (los_debitur)
if (!function_exists('infopinjaman_detail_id')) {
    function infopinjaman_detail_id($where_id = [], $style_table = 'table table-condensed table-bordered')
    {
        // Jika tidak ada data, tampilkan pesan
        if (empty($where_id)) {
            return '<div class="alert alert-warning">Tidak ada data pinjaman yang tersedia.</div>';
        }

        $_CI = &get_instance();

        // Query data pinjaman
        $_CI->db->select("ID_PINJAMAN, ID_DEBITUR, TANGGAL_PENGAJUAN, TANGGAL_CAIR, TANGGAL_JATUH_TEMPO, NO_AKAD, NO_KREDIT, NO_REGISTRASI, PRODUK, PLAFOND, TENOR, ANGSURAN_KOP, STATUS_CAIR, STATUS_PINJAMAN, JENIS_BUNGA, BUNGA_EFF_KOP, BUNGA_EFF_BANK, BUNGA_FLAT, OSP_bakidebet, STATUS_LUNAS");
        $_CI->db->from("los_debitur_pinjaman");
        $_CI->db->where('STATUS_CAIR', 'Y');
        $_CI->db->where($where_id);

        // Output
        $result = $_CI->db->get()->result();

        // Awal tabel
        $html = '
        <div class="table-responsive">
            <table class="' . $style_table . '">
                <thead>
                    <tr style="background-color: #D1F9FF; font-size:9px;">
                        <th>#</th>
                        <th>Tgl Cair</th>
                        <th>Tgl Tempo</th>
                        <th>Pokok</th>
                        <th>Rate</th>
                        <th>Total Bunga</th>
                        <th>Total Angsuran</th>
                        <th>Total Bayar</th>
                        <th>Sisa OS</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>';

        // Iterasi data pinjaman
        foreach ($result as $data) {

            // Informasi Rate
            if ($data->JENIS_BUNGA == 'EFFEKTIF') {
                $info_rate = $data->BUNGA_EFF_KOP . ' (%) <div>Anuitas/Thn</div>';
            } elseif ($data->JENIS_BUNGA == 'BULLET') {
                $info_rate = (number_format($data->BUNGA_FLAT * 100, 2)) . ' (%) <div>Bullet/Bln</div>';
            } else {
                $info_rate = (number_format($data->BUNGA_FLAT * 100, 2)) . ' (%) <div>Flat/Bln</div>';
            }

            // Informasi Total Pokok Bunga
            $select_schedule = "SELECT SUM(ANGSURAN_POKOK) AS total_pokok, SUM(ANGSURAN_BUNGA) AS total_bunga, SUM(ANGSURAN) AS total_angsuran, SUM(BAYAR_ANGSURAN_POKOK) AS total_bayar_pokok, SUM(BAYAR_ANGSURAN_BUNGA) AS total_bayar_bunga, SUM(BAYAR_ANGSURAN) AS total_bayar_angsuran FROM los_pinjaman_kpa_kop WHERE ID_PINJAMAN = {$data->ID_PINJAMAN} GROUP BY ID_PINJAMAN";
            $info_schedule = $_CI->db->query($select_schedule)->row();

            $html .= '
            <tr>
                <td>' . $data->NO_KREDIT . '<i class="fa fa-file-alt fa-fw"></i> </td>
                <td>' . format_date($data->TANGGAL_CAIR) . '</td>
                <td>' . format_date($data->TANGGAL_JATUH_TEMPO) . '</td>
                <td>' . number_format($data->PLAFOND, 2, ',', '.') . '</td>
                <td>' . $info_rate . '</td>
                <td>' . number_format($info_schedule->total_bunga, 2, ',', '.') . '</td>
                <td>' . number_format($info_schedule->total_angsuran, 2, ',', '.') . '</td>
                <td>' . number_format($info_schedule->total_bayar_angsuran, 2,  ',', '.') . '</td>
                <td>' . number_format($data->OSP_bakidebet, 2, ',', '.') . '</td>
                <td>' . is_status_lunas($data->STATUS_LUNAS, 'icon') . '</td>
            </tr>';
        }

        // Akhiri tabel
        $html .= '
                </tbody>
            </table>
        </div>';

        return $html;
    }
}

// Info Profile Box
// Master Table Data Debitur (los_debitur)
if (!function_exists('infopinjaman_debitur_info1')) {
    /**
     * Mengambil data debitur dan menampilkan box profil HTML.
     *
     * @param int $idPinjaman ID_DEBITUR dari tabel los_debitur
     * @return string HTML yang bisa langsung ditampilkan di view
     */
    function infopinjaman_debitur_info1($idPinjaman, $style_table = 'table table-condensed')
    {
        $CI = &get_instance();

        // Ambil data debitur
        $query = $CI->db->get_where('vw_pinjaman', ['ID_PINJAMAN' => $idPinjaman]);
        $row = $query->row();

        // Jika data tidak ditemukan, kembalikan teks kosong
        if (!$row) {
            return '<div class="text-danger">Data tidak ditemukan.</div>';
        }

        $html  = '';
        $html .= '
        <div class="row">
            <div class="col-md-4">
                <div class="m-b-5">
                    <div class="f-s-13"><b>Data Debitur</b></div>
                </div>

                <table class="' . $style_table . '">
                    <tbody>
                        <tr>
                            <td class="width-150">Kode Debitur</td>
							<td>' . format_kode_prefix('KD', $row->ID_DEBITUR, 8) . '</td>
						</tr>
                        <tr>
                            <td class="width-150">No Registrasi</td>
                            <td>' . $row->NO_REGISTRASI . '</td>
                        </tr>
                        <tr>
                            <td class="width-150">No Identitas</td>
                            <td>' . $row->NIK_KTP . '</td>
                        </tr>
                        <tr>
                            <td class="width-150">Nama Debitur</td>
							<td>' . $row->NAMA_DEBITUR . '</td>
						</tr>
                        <tr>
                            <td class="width-150">No Telepon</td>
							<td>' . $row->NO_TLP .  '</td>
						</tr>
                        <tr>
                            <td class="width-150">Nama Perusahaan</td>
							<td>' . $row->NAMA_PERUSAHAAN .  '</td>
						</tr>
                    </tbody>
                </table>
            </div>

            <div class="col-md-4">
                <div class="m-b-5">
                    <div class="f-s-13"><b>Data Pengajuan</b></div>
                </div>

                <table class="' . $style_table . '">
                    <tbody>
                        <tr>
                            <td class="width-150">Kode Pengajuan</td>
							<td>' . format_kode_prefix('KP', $row->ID_PINJAMAN, 8) . '</td>
						</tr>
                        <tr>
                            <td class="width-150">Tanggal Pengajuan</td>
                            <td>' . format_date($row->TANGGAL_PENGAJUAN_DT) . '</td>
                        </tr>
                        <tr>
                            <td class="width-150">Produk</td>
                            <td>' . info_desc_produk($row->PRODUK) . '</td>
                        </tr>
                        <tr>
                            <td class="width-150">Plafond</td>
							<td>' . number_format($row->PLAFOND) . '</td>
						</tr>
                        <tr>
                            <td class="width-150">Tenor</td>
							<td>' . $row->TENOR . ' Bulan' . '</td>
						</tr>
                        <tr>
                            <td class="width-150">Rate Angsuran</td>
							<td> -- </td>
						</tr>
                    </tbody>
                </table>
            </div>

            <div class="col-md-4">
                <div class="m-b-5">
                    <div class="f-s-13"><b>Data Persetujuan</b></div>
                </div>

                <table class="' . $style_table . '">
                    <tbody>
                        <tr>
                            <td class="width-150">Nomor Kredit</td>
							<td>' . $row->NO_KREDIT . '</td>
						</tr>
                        <tr>
                            <td class="width-150">Kantor Layanan</td>
							<td>' . $row->KODE_CABANG . ' - ' . $row->NAMA_CABANG . '</td>
						</tr>
                        <tr>
                            <td class="width-150">Mitra Sumberdana</td>
                            <td>' . $row->KODE_CABANG_SUMBERDANA . ' - ' . $row->NAMA_SUMBERDANA . '</td>
                        </tr>
                        <tr>
                            <td class="width-150">Nomor SPK</td>
                            <td>' . ($row->NO_AKAD) . '</td>
                        </tr>
                        <tr>
                            <td class="width-150">Tanggal Cair</td>
                            <td>' . format_date($row->TANGGAL_CAIR) . '</td>
                        </tr>
                        <tr>
                            <td class="width-150">Tanggal Jatuh Tempo</td>
                            <td>' . format_date($row->TANGGAL_JATUH_TEMPO) . '</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        ';

        return $html;
    }
}

// Info Kartu Pembayaran atau kartu angsuran pembayaran
if (!function_exists('__infopinjaman_kartupembayaran')) {
    function __infopinjaman_kartupembayaran($id_pinjaman, $style_table = 'table table-condensed')
    {
        $CI = &get_instance();

        // Data informasi pinjaman debitur
        $CI->db->select('
            ID_PINJAMAN,
            NO_KREDIT,
            PRODUK,
            PLAFOND,
            TENOR,
            ANGSURAN_KOP,
            TANGGAL_CAIR,
            TANGGAL_JATUH_TEMPO,
            JENIS_BUNGA,
            BUNGA_EFF_KOP,
            BUNGA_FLAT,
            OSP_bakidebet
        ');
        $CI->db->from('los_debitur_pinjaman');
        $CI->db->where('ID_PINJAMAN', $id_pinjaman);
        $dataId_pinjaman = $CI->db->get()->row_array();

        // Info data kartu pinjaman
        $CI->db->select('
            ID_KPA_KOP,
            ID_PINJAMAN,
            KODE_BAYAR, 
            ANGSURAN_KE, 
            ANGSURAN_PERIODE, 
            ANGSURAN_BUNGA, 
            ANGSURAN_POKOK, 
            ANGSURAN,
            STATUS_BAYAR,
            TANGGAL_BAYAR_ANGSURAN,
            BAYAR_ANGSURAN_POKOK,
            BAYAR_ANGSURAN_BUNGA,
            SISA_BAKIDEBET,
            JENIS_BAYAR
        ');
        $CI->db->from('los_pinjaman_kpa_kop');
        $CI->db->where('ANGSURAN_KE >', 0);
        $CI->db->where('ID_PINJAMAN', $dataId_pinjaman['ID_PINJAMAN']);
        $CI->db->order_by('ANGSURAN_KE', 'ASC');
        $dataSchedule = $CI->db->get()->result_array();

        if (empty($dataId_pinjaman)) {
            return '<p>Tidak ada data angsuran untuk ID_PINJAMAN: ' . htmlentities($id_pinjaman) . '</p>';
        }

        // Proses tampilan tabel
        $html = '';
        $html .= '
        <div class="m-b-10">
            <div class="f-s-13"><b>Kartu Pembayaran Angsuran</b></div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <table class="table sp7-table-xs table-condensed table-striped">
                    <tbody>
                        <tr>
                            <td class="width-150"><b>No Kredit</b></td>
                            <td>' . $dataId_pinjaman['NO_KREDIT'] . '</td>
                        </tr>
                        <tr>
                            <td class="width-150"><b>Tanggal Cair</b></td>
                            <td>' . format_date($dataId_pinjaman['TANGGAL_CAIR']) . '</td>
                        </tr>
                        <tr>
                            <td class="width-150"><b>Tanggal Jatuh Tempo</b></td>
                            <td>' . format_date($dataId_pinjaman['TANGGAL_JATUH_TEMPO']) . '</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="col-md-4">
                <table class="table sp7-table-xs table-condensed table-striped">
                    <tbody>
                        <tr>
                            <td class="width-150"><b>Plafond</b></td>
                            <td>' . number_format($dataId_pinjaman['PLAFOND']) . '</td>
                        </tr>
                        <tr>
                            <td class="width-150"><b>Tenor/JW</b></td>
                            <td>' . $dataId_pinjaman['TENOR'] . ' Bulan</td>
                        </tr>
                        <tr>
                            <td class="width-150"><b>Sisa Pinjaman (OS)</b></td>
                            <td>' . number_format($dataId_pinjaman['OSP_bakidebet']) . '</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
        </div>

        <table class="' . $style_table . '">
            <thead>
                <tr style="font-weight:bold;background:#f2f2f2">
                    <th class="text-left">Kode Bayar</th>
                    <th class="text-center">Periode</th>
                    <th class="text-center">Jatuh Tempo</th>
                    <th class="text-right">Tagihan Bunga</th>
                    <th class="text-right">Tagihan Pokok</th>
                    <th class="text-right">Angsuran</th>
                    <th class="text-right">Bayar Pokok</th>
                    <th class="text-right">Bayar Bunga</th>
                    <th class="text-right">Sisa Pokok</th>
                    <th class="text-right">Sisa Bunga</th>
                    <th class="text-right">Sisa Bakidebet</th>
                    <th class="text-left">Tanggal Bayar</th>
                    <th class="text-left">Status</th>
                    <th class="text-left">Jenis</th>
                </tr>
            </thead>
            <tbody>';

        $total_pokok = $total_bunga = $total_angsuran = 0;
        $total_bayar_pokok = $total_bayar_bunga = 0;
        $total_sisa_pokok = $total_sisa_bunga = 0;

        // Looping data pembayaran
        foreach ($dataSchedule as $row) {
            $sisa_pokok = $row['ANGSURAN_POKOK'] - $row['BAYAR_ANGSURAN_POKOK'];
            $sisa_bunga = $row['ANGSURAN_BUNGA'] - $row['BAYAR_ANGSURAN_BUNGA'];

            $html .= '<tr>';
            $html .= '<td class="text-left text-primary">' . $row['KODE_BAYAR'] . '</td>';
            $html .= '<td class="text-center">' . $row['ANGSURAN_KE'] . '</td>';
            $html .= '<td class="text-center">' . format_date($row['ANGSURAN_PERIODE']) . '</td>';
            $html .= '<td class="text-right">' . number_format($row['ANGSURAN_BUNGA'], 2) . '</td>';
            $html .= '<td class="text-right">' . number_format($row['ANGSURAN_POKOK'], 2) . '</td>';
            $html .= '<td class="text-right">' . number_format($row['ANGSURAN'], 2) . '</td>';
            $html .= '<td class="text-right">' . number_format($row['BAYAR_ANGSURAN_POKOK'], 2) . '</td>';
            $html .= '<td class="text-right">' . number_format($row['BAYAR_ANGSURAN_BUNGA'], 2) . '</td>';
            $html .= '<td class="text-right">' . number_format($sisa_pokok, 2) . '</td>';
            $html .= '<td class="text-right">' . number_format($sisa_bunga, 2) . '</td>';
            $html .= '<td class="text-right">' . number_format($row['SISA_BAKIDEBET'], 2) . '</td>';
            $html .= '<td class="text-left">' . (($row['TANGGAL_BAYAR_ANGSURAN'] != NULL) ? format_date_custom($row['TANGGAL_BAYAR_ANGSURAN'], 'd/m/Y') : '-') . '</td>';
            $html .= '<td class="text-left">' . ($row['STATUS_BAYAR'] == 1 ? '<span class="label label-green">Lunas</span>' : '<span class="label label-danger">Belum</span>') . '</td>';
            $html .= '<td class="text-center">' . $row['JENIS_BAYAR'] . '</td>';
            $html .= '</tr>';

            $total_pokok += $row['ANGSURAN_POKOK'];
            $total_bunga += $row['ANGSURAN_BUNGA'];
            $total_angsuran += $row['ANGSURAN'];

            $total_bayar_pokok += $row['BAYAR_ANGSURAN_POKOK'];
            $total_bayar_bunga += $row['BAYAR_ANGSURAN_BUNGA'];

            $total_sisa_pokok += $sisa_pokok;
            $total_sisa_bunga += $sisa_bunga;
        }

        $html .= '<tr style="font-weight:bold;background:#f2f2f2">';
        $html .= '<td colspan="3" style="text-align:left;">TOTAL</td>';
        $html .= '<td class="text-right">' . number_format($total_bunga, 2) . '</td>';
        $html .= '<td class="text-right">' . number_format($total_pokok, 2) . '</td>';
        $html .= '<td class="text-right">' . number_format($total_angsuran, 2) . '</td>';

        $html .= '<td class="text-right">' . number_format($total_bayar_pokok, 2) . '</td>';
        $html .= '<td class="text-right">' . number_format($total_bayar_bunga, 2) . '</td>';

        $html .= '<td class="text-right">' . number_format($total_sisa_pokok, 2) . '</td>';
        $html .= '<td class="text-right">' . number_format($total_sisa_bunga, 2) . '</td>';
        $html .= '<td colspan="4"></td>';
        $html .= '</tr>';

        $html .= '</tbody>';
        $html .= '</table>';

        return $html;
    }
}

// Info Kartu Pembayaran atau kartu angsuran pembayaran
if (!function_exists('infopinjaman_kartupembayaran')) {
    function infopinjaman_kartupembayaran($id_pinjaman, $style_table = 'table table-condensed')
    {
        $CI = &get_instance();

        // Data informasi pinjaman debitur
        $CI->db->select('
            ID_PINJAMAN,
            NO_KREDIT,
            PRODUK,
            PLAFOND,
            TENOR,
            ANGSURAN_KOP,
            TANGGAL_CAIR,
            TANGGAL_JATUH_TEMPO,
            JENIS_BUNGA,
            BUNGA_EFF_KOP,
            BUNGA_FLAT,
            OSP_bakidebet
        ');
        $CI->db->from('los_debitur_pinjaman');
        $CI->db->where('ID_PINJAMAN', $id_pinjaman);
        $dataId_pinjaman = $CI->db->get()->row_array();

        // Info data kartu pinjaman
        $CI->db->select('
            ID_KPA_KOP,
            ID_PINJAMAN,
            KODE_BAYAR, 
            ANGSURAN_KE, 
            ANGSURAN_PERIODE, 
            ANGSURAN_BUNGA, 
            ANGSURAN_POKOK, 
            ANGSURAN,
            STATUS_BAYAR,
            TANGGAL_BAYAR_ANGSURAN,
            BAYAR_ANGSURAN_POKOK,
            BAYAR_ANGSURAN_BUNGA,
            SISA_BAKIDEBET,
            JENIS_BAYAR
        ');
        $CI->db->from('los_pinjaman_kpa_kop');
        $CI->db->where('ANGSURAN_KE >', 0);
        $CI->db->where('ID_PINJAMAN', $dataId_pinjaman['ID_PINJAMAN']);
        $CI->db->order_by('ANGSURAN_KE', 'ASC');
        $dataSchedule = $CI->db->get()->result_array();

        // Data Status Dafnom
        $CI->db->select('
            ID_PINJAMAN,
            NO_KREDIT,
            NO_BATCH,
            NO_SURAT_SI
        ');
        $CI->db->from('los_dafnom_bank_detail');
        $CI->db->where('ID_PINJAMAN', $id_pinjaman);
        $dataId_dafnom = $CI->db->get()->row_array();

        if (empty($dataId_pinjaman)) {
            return '<p>Tidak ada data angsuran untuk ID_PINJAMAN: ' . htmlentities($id_pinjaman) . '</p>';
        }

        // Proses tampilan tabel
        $html = '';
        $html .= '
        <div class="m-b-10">
            <div class="f-s-13"><b>Kartu Pembayaran Angsuran</b></div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <table class="table sp7-table-xs table-condensed table-striped">
                    <tbody>
                        <tr>
                            <td class="width-150"><b>No Kredit</b></td>
                            <td>' . $dataId_pinjaman['NO_KREDIT'] . '</td>
                        </tr>
                        <tr>
                            <td class="width-150"><b>Tanggal Cair</b></td>
                            <td>' . format_date($dataId_pinjaman['TANGGAL_CAIR']) . '</td>
                        </tr>
                        <tr>
                            <td class="width-150"><b>Tanggal Jatuh Tempo</b></td>
                            <td>' . format_date($dataId_pinjaman['TANGGAL_JATUH_TEMPO']) . '</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="col-md-4">
                <table class="table sp7-table-xs table-condensed table-striped">
                    <tbody>
                        <tr>
                            <td class="width-150"><b>Plafond</b></td>
                            <td>' . number_format($dataId_pinjaman['PLAFOND']) . '</td>
                        </tr>
                        <tr>
                            <td class="width-150"><b>Tenor/JW</b></td>
                            <td>' . $dataId_pinjaman['TENOR'] . ' Bulan</td>
                        </tr>
                        <tr>
                            <td class="width-150"><b>Sisa Pinjaman (OS)</b></td>
                            <td>' . number_format($dataId_pinjaman['OSP_bakidebet']) . '</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-4">
                <table class="table sp7-table-xs table-condensed table-striped">
                    <tbody>
                        <tr>
                            <td class="width-150"><b>No Batch</b></td>
                            <td>' . $dataId_dafnom['NO_BATCH'] . '</td>
                        </tr>
                        <tr>
                            <td class="width-150"><b>No Surat Droping</b></td>
                            <td>' . $dataId_dafnom['NO_SURAT_SI'] . '</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
        </div>

        <div class="table-responsive">
        <table class="' . $style_table . '">
            <thead>
                <tr style="font-weight:bold;background:#f2f2f2">
                    <th class="text-left">Kode Bayar</th>
                    <th class="text-center">Ke-</th>
                    <th class="text-center">Tempo</th>
                    <th class="text-right">Tag. Bunga</th>
                    <th class="text-right">Tag. Pokok</th>
                    <th class="text-right">Angsuran</th>
                    <th class="text-right">By. Pokok</th>
                    <th class="text-right">By. Bunga</th>
                    <th class="text-right">Sisa Pokok</th>
                    <th class="text-right">Sisa Bunga</th>
                    <th class="text-right">Sisa Saldo</th>
                    <th class="text-left">Tanggal Bayar</th>
                    <th class="text-left">Status</th>
                    <th class="text-left">Jenis</th>
                </tr>
            </thead>
            <tbody>';

        $total_pokok = $total_bunga = $total_angsuran = 0;
        $total_bayar_pokok = $total_bayar_bunga = 0;
        $total_sisa_pokok = $total_sisa_bunga = 0;

        // Looping data pembayaran
        foreach ($dataSchedule as $row) {
            // FIX: Prevent negative values for remaining balance
            $sisa_pokok = max(0, $row['ANGSURAN_POKOK'] - $row['BAYAR_ANGSURAN_POKOK']);
            $sisa_bunga = max(0, $row['ANGSURAN_BUNGA'] - $row['BAYAR_ANGSURAN_BUNGA']);

            $html .= '<tr>';
            $html .= '<td class="text-left text-primary">' . $row['KODE_BAYAR'] . '</td>';
            $html .= '<td class="text-center">' . $row['ANGSURAN_KE'] . '</td>';
            $html .= '<td class="text-center">' . format_date($row['ANGSURAN_PERIODE']) . '</td>';
            $html .= '<td class="text-right">' . number_format($row['ANGSURAN_BUNGA'], 2) . '</td>';
            $html .= '<td class="text-right">' . number_format($row['ANGSURAN_POKOK'], 2) . '</td>';
            $html .= '<td class="text-right">' . number_format($row['ANGSURAN'], 2) . '</td>';
            $html .= '<td class="text-right">' . number_format($row['BAYAR_ANGSURAN_POKOK'], 2) . '</td>';
            $html .= '<td class="text-right">' . number_format($row['BAYAR_ANGSURAN_BUNGA'], 2) . '</td>';
            $html .= '<td class="text-right">' . number_format($sisa_pokok, 2) . '</td>';
            $html .= '<td class="text-right">' . number_format($sisa_bunga, 2) . '</td>';
            $html .= '<td class="text-right">' . number_format($row['SISA_BAKIDEBET'], 2) . '</td>';
            $html .= '<td class="text-left">' . (($row['TANGGAL_BAYAR_ANGSURAN'] != NULL) ? format_date_custom($row['TANGGAL_BAYAR_ANGSURAN'], 'd/m/Y') : '-') . '</td>';
            $html .= '<td class="text-left">' . ($row['STATUS_BAYAR'] == 1 ? '<span class="label label-green">Lunas</span>' : '<span class="label label-danger">Belum</span>') . '</td>';
            $html .= '<td class="text-center">' . $row['JENIS_BAYAR'] . '</td>';
            $html .= '</tr>';

            $total_pokok += $row['ANGSURAN_POKOK'];
            $total_bunga += $row['ANGSURAN_BUNGA'];
            $total_angsuran += $row['ANGSURAN'];

            $total_bayar_pokok += $row['BAYAR_ANGSURAN_POKOK'];
            $total_bayar_bunga += $row['BAYAR_ANGSURAN_BUNGA'];

            $total_sisa_pokok += $sisa_pokok;
            $total_sisa_bunga += $sisa_bunga;
        }

        $html .= '<tr style="font-weight:bold;background:#f2f2f2">';
        $html .= '<td colspan="3" style="text-align:left;">TOTAL</td>';
        $html .= '<td class="text-right">' . number_format($total_bunga, 2) . '</td>';
        $html .= '<td class="text-right">' . number_format($total_pokok, 2) . '</td>';
        $html .= '<td class="text-right">' . number_format($total_angsuran, 2) . '</td>';

        $html .= '<td class="text-right">' . number_format($total_bayar_pokok, 2) . '</td>';
        $html .= '<td class="text-right">' . number_format($total_bayar_bunga, 2) . '</td>';

        $html .= '<td class="text-right">' . number_format($total_sisa_pokok, 2) . '</td>';
        $html .= '<td class="text-right">' . number_format($total_sisa_bunga, 2) . '</td>';
        $html .= '<td colspan="4"></td>';
        $html .= '</tr>';

        $html .= '</tbody>';
        $html .= '</table>';
        $html .= '</div>';

        return $html;
    }
}

// Infor Data Pinjaman Header Info
// Master Table Data Debitur (los_debitur)
if (!function_exists('infotransaksi_pembayaran')) {
    function infotransaksi_pembayaran($where_id = [], $style_table = 'table table-condensed')
    {
        // Jika tidak ada data, tampilkan pesan
        if (empty($where_id)) {
            return '<div class="alert alert-warning">Tidak ada data pinjaman yang tersedia.</div>';
        }

        $_CI = &get_instance();

        // Query data pinjaman
        $_CI->db->select("*");
        $_CI->db->from("los_debitur_pinjaman_bayar");
        $_CI->db->where($where_id);

        // Output
        $result = $_CI->db->get()->result();

        // Awal tabel
        $html = '
        <div class="m-b-10">
            <div class="f-s-13"><b>Transaksi Pembayaran</b></div>
        </div>

        <div class="table-responsive">
            <table class="' . $style_table . '">
                <thead>
                    <tr style="font-weight:bold;background:#f2f2f2">
                        <th>#</th>
                        <th class="text-left">Tgl Bayar</th>
                        <th class="text-right">Bayar Pokok</th>
                        <th class="text-right">Bayar Bunga</th>
                        <th class="text-right">Total Bayar</th>
                        <th class="text-right">Bakidebet</th>
                        <th>Jenis</th>
                        <th>Print</th>
                    </tr>
                </thead>
                <tbody>';

        // Iterasi data pinjaman
        foreach ($result as $data) {

            $url_print = site_url('' . enkrip($data->ID_PINJAMAN));
            $actionLinks_print = '
                <a href="' . $url_print . '" ><i class="fa fa-print fa-fw text-black"></i></a>
            ';

            $url_pdf = site_url('' . enkrip($data->ID_PINJAMAN));
            $actionLinks_pdf = '
                <a href="' . $url_pdf . '" ><i class="fa fa-file-pdf fa-fw text-black"></i></a>
            ';

            $html .= '
            <tr>
                <td>' . $data->NO_KREDIT . '</td>
                <td class="text-left">' . format_date($data->TANGGAL_BAYAR) . '</td>
                <td class="text-right">' . number_format($data->JUMLAH_BAYAR_POKOK, 2, ',', '.') . '</td>
                <td class="text-right">' . number_format($data->JUMLAH_BAYAR_BUNGA, 2, ',', '.') . '</td>
                <td class="text-right">' . number_format($data->JUMLAH_BAYAR, 2, ',', '.') . '</td>
                <td class="text-right">' . number_format($data->SISA_BAKIDEBET, 2, ',', '.') . '</td>
                <td>' . $data->JENIS_BAYAR . '</td>
                <td>' . $actionLinks_print . $actionLinks_pdf . '</td>
            </tr>';
        }

        // Akhiri tabel
        $html .= '
                </tbody>
            </table>
        </div>';

        return $html;
    }
}

// Component info Data Lainnya
if (!function_exists('info_pegawai')) {
    function info_pegawai($pinjamanId, $style_table = 'table table-condensed')
    {
        // Initial
        $_CI = &get_instance();

        // query
        $_CI->db->select("*");
        $_CI->db->from("vw_pinjaman");
        $_CI->db->where("ID_PINJAMAN", $pinjamanId);

        // Output
        $row = $_CI->db->get()->row();

        if ($row->JENIS_PERUSAHAAN == 1) {
            $jp = 'NEGERI';
        } elseif ($row->JENIS_PERUSAHAAN == 2) {
            $jp = 'SWASTA';
        } else {
            $jp = '--';
        }

        $html  = '';
        $html .= '';

        $html .= '
        <div class="row">
            <div class="col-md-4">
                <div class="m-b-5">
                    <div class="f-s-13"><b>Data Instansi Perusahaan</b></div>
                </div>

                <table class="' . $style_table . '">
                    <tbody>
                        <tr>
                            <td class="width-150">Nama Perusahaan</td>
							<td>' . $row->NAMA_PERUSAHAAN . '</td>
							</tr>
                        <tr>
                            <td class="width-150">Jenis Perusahaan</td>
                            <td>' . $jp . '</td>
                        </tr>
                        <tr>
                            <td class="width-150">Status Pegawai</td>
                            <td>' . info_status_pegawai($row->STATUS_PEGAWAI) . '</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="col-md-4">
                <div class="m-b-5">
                    <div class="f-s-13"><b>Data Skep Pegawai</b></div>
                </div>

                <table class="' . $style_table . '">
                    <tbody>
                        <tr>
                            <td class="width-150">No NOPEN/NIK/NIP</td>
                            <td>' . $row->NO_NIK_NIP_KPN . '</td>
                        </tr>
                        <tr>
                            <td class="width-150">No Skep/No Jaminan/No Surat Lainnya</td>
                            <td>' . $row->NO_SURAT . '</td>
                        </tr>
                        <tr>
                            <td class="width-150">Tanggal Surat Keterangan</td>
                            <td>' . format_date_indo_v2($row->TANGGAL_SURAT) . '</td>
                        </tr>
                    </tbody>
                </table>
			</div>

			<div class="col-md-4">
                <div class="m-b-5">
                    <div class="f-s-13"><b>Data Lainnya</b></div>
                </div>

                <table class="' . $style_table . '">
                    <tbody>
                        <tr>
                            <td class="width-150">No BPJS</td>
                            <td>' . $row->NO_BPJS . '</td>
                        </tr>
                        <tr>
                            <td class="width-150">No Rekening Bank</td>
                            <td>' . $row->NO_REKENING_BANK . '</td>
                        </tr>
                        <tr>
                            <td class="width-150">No ATM</td>
                            <td>' . $row->NO_ATM . '</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    

        <div class="m-b-10">
            <div class="f-s-13"><b>Data Gaji Pegawai Bulanan</b></div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <table class="' . $style_table . '">
                    <tbody>
                        <tr class="bg-grey-transparent-1">
                            <td class="text-left" colspan="2"><b>Rincian Pendapatan</b></td>
                        </tr>
                        <tr>
                            <td class="text-left">Pokok Pegawai</td>
                            <td class="text-right" style="width: 150px;">' . number_format($row->GAJI_PENDAPATAN) . '</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="col-md-4">
                <table class="' . $style_table . '">
                    <tbody>
                        <tr class="bg-grey-transparent-1">
                            <td class="text-left" colspan="2"><b>Rincian Potongan</b></td>
                        </tr>
                        <tr>
                            <td class="text-left">Potongan Pegawai</td>
                            <td class="text-right" style="width: 150px;">' . number_format($row->GAJI_POTONGAN) . '</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="col-md-4">
                <table class="' . $style_table . '">
                    <tbody>
                        <tr>
                            <td class="text-left" colspan="2"><b>Terima Besih</b></td>
                        </tr>
                        <tr>
                            <td class="text-left">Pendapatan</td>
                            <td class="text-right" style="width: 150px;">' . number_format($row->GAJI_PENDAPATAN) . '</td>
                        </tr>
                        <tr>
                            <td class="text-left">Potongan</td>
                            <td class="text-right" style="width: 150px;">' . number_format($row->GAJI_POTONGAN) . '</td>
                        </tr>
                        <tr>
                            <td class="text-left"><b>Jumlah Bersih <small>(A) - (B)</small></b></td>
                            <td class="text-right" style="width: 150px;"><b>' . number_format($row->GAJI_BERSIH) . '</b></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        ';

        return $html;
    }
}

// Component info simulasi pembiaayaan
if (!function_exists('info_simulasi')) {
    function info_simulasi($pinjamanId, $style_table = 'table table-condensed')
    {
        // Initial
        $_CI = &get_instance();

        // query
        $_CI->db->select("*");
        $_CI->db->from("vw_pinjaman");
        $_CI->db->where("ID_PINJAMAN", $pinjamanId);

        // Output
        $row = $_CI->db->get()->row_array();

        // Cek Jenis Biaya
        $notaris = $row['NOMINAL_BY_NOTARIS'] != is_null($row['NOMINAL_BY_NOTARIS']) ? 100000 : 0;
        $by_pemasaran = $row['PLAFOND'] * (1 / 100);

        // Hitung Jumlah Biaya Potongan
        if ($row['ID_SUMBERDANA'] == 7) {
            $byPotongan = ($row['NOMINAL_BY_ASS_KOP'] + $row['NOMINAL_BY_ADM'] + $row['NOMINAL_BY_PROVISI'] + $row['NOMINAL_BY_MUTASI'] + $row['NOMINAL_BY_TABUNGANWAJIB'] + $row['NOMINAL_BY_BUKA_REKENING'] + $row['NOMINAL_BY_NOTARIS'] + $row['NOMINAL_BY_LAINNYA'] + pembulatan_angsuran_sip($row['NOMINAL_POT_UM']) + pembulatan_angsuran_sip($row['NOMINAL_RETENSI']));
        } else if ($row['ID_SUMBERDANA'] == 2) {
            $byPotongan = $row['NOMINAL_BY_ASS_KOP'] + $row['NOMINAL_BY_ADM'] + $row['NOMINAL_BY_TATALAKASAN'] + $row['NOMINAL_BY_PROVISI'] + $row['NOMINAL_BY_MUTASI'] + $row['NOMINAL_BY_BUKA_REKENING'] + pembulatan_angsuran($row['NOMINAL_POT_UM']) + pembulatan_angsuran($row['NOMINAL_RETENSI']) + $row['NOMINAL_BY_NOTARIS'] + $row['NOMINAL_BY_TABUNGANWAJIB'] + $row['NOMINAL_BY_LAINNYA'];
        } else {
            $byPotongan = $row['NOMINAL_BY_ASS_KOP'] + $row['NOMINAL_BY_ADM'] + $row['NOMINAL_BY_TATALAKASAN'] + $row['NOMINAL_BY_PROVISI'] + $row['NOMINAL_BY_MUTASI'] + $row['NOMINAL_BY_BUKA_REKENING'] + $row['NOMINAL_POT_UM'] + $row['NOMINAL_RETENSI'] + $row['NOMINAL_BY_NOTARIS'] + $row['NOMINAL_BY_TABUNGANWAJIB'] + $row['NOMINAL_BY_LAINNYA'];
        }

        // Hitung terima kotor
        $terimaKotor = $row['PLAFOND'] - $byPotongan;

        // Hitung terima bersih
        $terimaBersih = $terimaKotor - $row['NOMINAL_PELUNASAN'];

        if ($row['JENIS_BUNGA'] == 'EFFEKTIF') {
            $jenis_rate = $row['BUNGA_EFF_KOP'] . ' (%) Anuitas/Tahun';
        } elseif ($row['JENIS_BUNGA'] == 'BULLET') {
            $jenis_rate = (number_format($row['BUNGA_FLAT'] * 100, 2)) . ' (%) Bullet/Bulan';
        } else {
            $jenis_rate = (number_format($row['BUNGA_FLAT'] * 100, 2)) . ' (%) Flat/Bulan';
        }

        $isSumberDana7 = ($row['ID_SUMBERDANA'] == 7);
        $isSumberDana2 = ($row['ID_SUMBERDANA'] == 2);

        $html  = '';
        $html .= '
        <div class="m-b-5">
            <div class="f-s-13"><b>Data Simulasi Pembiayaan</b></div>
        </div>

		<div class="row">
			<div class="col-md-4">
				<table class="' . $style_table . '">
					<tbody>
						<tr class="bg-grey-transparent-1">
							<td class="text-left" colspan="3"><b>Informasi Pembiayaan</b></td>
						</tr>
						<tr>
                            <td class="text-left" style="width: 200px;">Produk</td>
                            <td class="text-center" style="width: 10px;">:</td>
                            <td class="text-right">' . info_desc_produk($row['PRODUK']) . ' / ' . $row['NAMA_JENIS_BIAYA'] . '</td>
                        </tr>
						<tr>
                            <td class="text-left" style="width: 200px;">Rate</td>
                            <td class="text-center" style="width: 10px;">:</td>
                            <td class="text-right">' . $jenis_rate . '</td>
                        </tr>
                        <tr>
                            <td class="text-left" style="width: 200px;">Plafond</td>
                            <td class="text-center" style="width: 10px;">:</td>
                            <td class="text-right">' . number_format($row['PLAFOND']) . '</td>
                        </tr>
                        <tr>
                            <td class="text-left" style="width: 200px;">Tenor</td>
                            <td class="text-center" style="width: 10px;">:</td>
                            <td class="text-right">' . $row['TENOR'] . ' Bulan </td>
                        </tr>
                        <tr>
                            <td class="text-left" style="width: 200px;">Angsuran</td>
                            <td class="text-center" style="width: 10px;">:</td>
                            <td class="text-right">' . number_format($row['ANGSURAN_KOP']) . '</td>
                        </tr>
                        ';

        if ($isSumberDana2) {
            $html .= '
                        <tr>
                            <td class="text-left" style="width: 200px;">Angsuran Pembulatan Mulya</td>
                            <td class="text-center" style="width: 10px;">:</td>
                            <td class="text-right">' . number_format(pembulatan_angsuran($row['ANGSURAN_KOP'])) . '</td>
                        </tr>
                        ';
        } elseif ($isSumberDana7) {
            $html .= '
                        <tr>
                            <td class="text-left" style="width: 200px;">Angsuran Pembulatan SIP</td>
                            <td class="text-center" style="width: 10px;">:</td>
                            <td class="text-right">' . number_format(pembulatan_angsuran_sip($row['ANGSURAN_KOP'])) . '</td>
                        </tr>
                        ';
        }
        $html .= '
						<tr class="bg-grey-transparent-1">
                            <td class="text-left" colspan="3"><b>Informasi Jumlah Angsuran</b></td>
                        </tr>
                        <tr>
                            <td class="text-left" style="width: 200px;">Gaji Bersih</td>
                            <td class="text-center" style="width: 10px;">:</td>
                            <td class="text-right">
                                <div class="pull-left"><small>' . calculate_ratio_angsuran($row['GAJI_BERSIH'], $row['GAJI_BERSIH'], 0)  . '</small></div>
                                <div class="pull-right">' . number_format($row['GAJI_BERSIH']) . '</div>
                            </td>
                        </tr>
						<tr>
                            <td class="text-left" style="width: 200px;">Angsuran</td>
                            <td class="text-center" style="width: 10px;">:</td>
                            <td class="text-right">
                                <div class="pull-left"><small>' . calculate_ratio_angsuran($row['ANGSURAN_KOP'], $row['GAJI_BERSIH'], 0)  . '</small></div>
                                <div class="pull-right">' . number_format($row['ANGSURAN_KOP']) . '</div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left" style="width: 200px;">Sisa Gaji</td>
                            <td class="text-center" style="width: 10px;">:</td>
                            <td class="text-right">
                                <div class="pull-left"><small>' . calculate_ratio_angsuran(($row['GAJI_BERSIH'] - $row['ANGSURAN_KOP']), $row['GAJI_BERSIH'], 0)  . '</small></div>
                                <div class="pull-right">' . number_format($row['GAJI_BERSIH'] - $row['ANGSURAN_KOP']) . '</div>
                            </td>
                        </tr>
						<tr class="bg-grey-transparent-1">
							<td class="text-left" colspan="3"><b>Analisa Usia</b></td>
						</tr>
						<tr>
							<td class="text-left" style="width: 150px;">Tanggal Simulasi</td>
							<td class="text-center" style="width: 10px;">:</td>
							<td class="text-right">' . format_date_indo_v2($row['TANGGAL_PENGAJUAN']) . '</td>
						</tr>
						<tr>
							<td class="text-left" style="width: 150px;">Usia Saat Masuk</td>
							<td class="text-center" style="width: 10px;">:</td>
							<td class="text-right">' . calculate_age_details($row['TANGGAL_PENGAJUAN'], $row['TANGGAL_LAHIR'])['age_detail'] . '</td>
						</tr>
						<tr>
							<td class="text-left">Usia Saat Jatuh Tempo</td>
							<td class="text-center">:</td>
							<td class="text-right">' . calculate_age_details_jatuhtempo($row['TANGGAL_PENGAJUAN'], $row['TANGGAL_LAHIR'], $row['TENOR'])['age_detail'] . '</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="col-md-4">
				<table class="' . $style_table . '">
					<tbody>
						<tr class="bg-grey-transparent-1">
							<td class="text-left" colspan="3"><b>Rincian biaya potongan</b></td>
						</tr>
						<tr>
							<td class="text-left">Biaya Asuransi</td>
							<td class="text-center">:</td>
							<td class="text-right">' . number_format($row['NOMINAL_BY_ASS_KOP']) . '</td>
						</tr>
						<tr>
							<td class="text-left">Biaya Administrasi</td>
							<td class="text-center">:</td>
							<td class="text-right">' . number_format($row['NOMINAL_BY_ADM']) . '</td>
						</tr>
						<tr>
							<td class="text-left">Biaya Provisi</td>
							<td class="text-center">:</td>
							<td class="text-right">' . number_format($row['NOMINAL_BY_PROVISI']) . '</td>
						</tr>
						<tr>
							<td class="text-left">Tabungan Wajib</td>
							<td class="text-center">:</td>
							<td class="text-right">' . number_format($row['NOMINAL_BY_TABUNGANWAJIB']) . '</td>
						</tr>
						<tr>
							<td class="text-left">Biaya Buka Rekening</td>
							<td class="text-center">:</td>
							<td class="text-right">' . number_format($row['NOMINAL_BY_BUKA_REKENING']) . '</td>
						</tr>
						<tr>
							<td class="text-left">Biaya Notaris</td>
							<td class="text-center">:</td>
							<td class="text-right">' . number_format($row['NOMINAL_BY_NOTARIS']) . '</td>
						</tr>
						<tr>
							<td class="text-left">Biaya Lainnya</td>
							<td class="text-center">:</td>
							<td class="text-right">' . number_format($row['NOMINAL_BY_LAINNYA']) . '</td>
						</tr>
                        ';

        if ($isSumberDana7) {
            $html .= '
						<tr>
                            <td class="text-left">Retensi Angsuran</td>
                            <td class="text-center">:</td>
                            <td class="text-right">
                                <span class="pull-left">
                                    (' . (($row['NOMINAL_RETENSI'] == 0 || $row['ANGSURAN_KOP'] == 0) ? '0' : round($row['NOMINAL_RETENSI'] / $row['ANGSURAN_KOP']) . '') . ')
                                </span>
                                ' . number_format(pembulatan_angsuran_sip($row['NOMINAL_RETENSI']), 0, ',', '.') . '
                            </td>
                        </tr>
						<tr>
							<td class="text-left">Blokir Angsuran</td>
							<td class="text-center">:</td>
							<td class="text-right"> <span class="pull-left">(' . $row['POT_UM'] . ')</span> ' . number_format(pembulatan_angsuran_sip($row['NOMINAL_POT_UM'])) . '</td>
						</tr>';
        } else if ($isSumberDana2) {
            $html .= '
                        <tr>
                            <td class="text-left">Retensi Angsuran</td>
                            <td class="text-center">:</td>
                            <td class="text-right">
                                <span class="pull-left">
                                    (' . (($row['NOMINAL_RETENSI'] == 0 || $row['ANGSURAN_KOP'] == 0) ? '0' : round($row['NOMINAL_RETENSI'] / $row['ANGSURAN_KOP']) . '') . ')
                                </span>
                                ' . number_format(pembulatan_angsuran($row['NOMINAL_RETENSI']), 0, ',', '.') . '
                            </td>
                        </tr>
						<tr>
							<td class="text-left">Blokir Angsuran</td>
							<td class="text-center">:</td>
							<td class="text-right"> <span class="pull-left">(' . $row['POT_UM'] . ')</span> ' . number_format(pembulatan_angsuran($row['NOMINAL_POT_UM'])) . '</td>
						</tr>';
        } else {
            $html .= '
                        <tr>
                            <td class="text-left">Retensi Angsuran</td>
                            <td class="text-center">:</td>
                            <td class="text-right">
                                <span class="pull-left">
                                    (' . (($row['NOMINAL_RETENSI'] == 0 || $row['ANGSURAN_KOP'] == 0) ? '0' : round($row['NOMINAL_RETENSI'] / $row['ANGSURAN_KOP']) . '') . ')
                                </span>
                                ' . number_format(($row['NOMINAL_RETENSI']), 0, ',', '.') . '
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left">Blokir Angsuran</td>
                            <td class="text-center">:</td>
                            <td class="text-right"> <span class="pull-left">(' . $row['POT_UM'] . ')</span> ' . number_format($row['NOMINAL_POT_UM']) . '</td>
                        </tr>';
        }
        $html .= '
						<tr class="bg-grey-transparent-1">
							<td class="text-left"><b>Jumlah Biaya</b></td>
							<td class="text-center">:</td>
							<td class="text-right"><b>' . number_format($byPotongan) . '</b></td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="col-md-4">
				<table class="' . $style_table . '">
					<tbody>
						<tr class="bg-grey-transparent-1">
							<td class="text-left" colspan="3"><b>Rincian penerimaan</b></td>
						</tr>
						<tr>
							<td class="text-left" style="width: 150px;">(A) Plafond</td>
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
		</div>
        ';

        return $html;
    }
}

// Component info simulasi pembiaayaan
if (!function_exists('info_simulasi_bank')) {
    function info_simulasi_bank($pinjamanId, $style_table = 'table table-condensed')
    {
        // Initial
        $_CI = &get_instance();

        // query
        $_CI->db->select("*");
        $_CI->db->from("vw_pinjaman");
        $_CI->db->where("ID_PINJAMAN", $pinjamanId);

        // Output
        $row = $_CI->db->get()->row_array();

        // Cek Jenis Biaya
        $notaris = $row['NOMINAL_BY_NOTARIS'] != is_null($row['NOMINAL_BY_NOTARIS']) ? 100000 : 0;
        $by_pemasaran = $row['PLAFOND'] * (1 / 100);

        // Hitung Jumlah Biaya Potongan
        if ($row['ID_SUMBERDANA'] == 7) {
            $byPotongan = $row['NOMINAL_BY_ASS_KOP'] + $row['NOMINAL_BY_ADM'] + $row['NOMINAL_BY_TATALAKASAN'] + $row['NOMINAL_BY_PROVISI'] + $row['NOMINAL_BY_MUTASI'] + $row['NOMINAL_BY_BUKA_REKENING'] + pembulatan_angsuran_sip($row['NOMINAL_POT_UM']) + pembulatan_angsuran_sip($row['NOMINAL_RETENSI']) + $notaris + $row['NOMINAL_BY_TABUNGANWAJIB'] + $by_pemasaran + $row['NOMINAL_BY_LAINNYA'];
        } else if ($row['ID_SUMBERDANA'] == 2 || $row['ID_SUMBERDANA'] == 8) {
            $byPotongan = $row['NOMINAL_BY_ASS_KOP'] + $row['NOMINAL_BY_ADM'] + $row['NOMINAL_BY_TATALAKASAN'] + $row['NOMINAL_BY_PROVISI'] + $row['NOMINAL_BY_MUTASI'] + $row['NOMINAL_BY_BUKA_REKENING'] + pembulatan_angsuran($row['NOMINAL_POT_UM']) + pembulatan_angsuran($row['NOMINAL_RETENSI']) + $row['NOMINAL_BY_NOTARIS'] + $row['NOMINAL_BY_TABUNGANWAJIB'] + $row['NOMINAL_BY_LAINNYA'];
        } else {
            $byPotongan = $row['NOMINAL_BY_ASS_KOP'] + $row['NOMINAL_BY_ADM'] + $row['NOMINAL_BY_TATALAKASAN'] + $row['NOMINAL_BY_PROVISI'] + $row['NOMINAL_BY_MUTASI'] + $row['NOMINAL_BY_BUKA_REKENING'] + $row['NOMINAL_POT_UM'] + $row['NOMINAL_RETENSI'] + $row['NOMINAL_BY_NOTARIS'] + $row['NOMINAL_BY_TABUNGANWAJIB'] + $row['NOMINAL_BY_LAINNYA'];
        }

        // Hitung terima kotor
        $terimaKotor = $row['PLAFOND'] - $byPotongan;

        // Hitung terima bersih
        $terimaBersih = $terimaKotor - $row['NOMINAL_PELUNASAN'];

        if ($row['JENIS_BUNGA'] == 'EFFEKTIF') {
            $jenis_rate = $row['BUNGA_EFF_KOP'] . ' (%) Anuitas/Tahun';
        } elseif ($row['JENIS_BUNGA'] == 'BULLET') {
            $jenis_rate = (number_format($row['BUNGA_FLAT'] * 100, 2)) . ' (%) Bullet/Bulan';
        } else {
            $jenis_rate = (number_format($row['BUNGA_FLAT'] * 100, 2)) . ' (%) Flat/Bulan';
        }

        $isSumberDana7 = ($row['ID_SUMBERDANA'] == 7);

        $html  = '';
        $html .= '
        <div class="m-b-5">
            <div class="f-s-13"><b>Data Simulasi Pembiayaan</b></div>
        </div>

		<div class="row">
			<div class="col-md-4">
				<table class="' . $style_table . '">
					<tbody>
						<tr class="bg-grey-transparent-1">
							<td class="text-left" colspan="3"><b>Informasi Pembiayaan</b></td>
						</tr>
						<tr>
                            <td class="text-left" style="width: 200px;">Produk</td>
                            <td class="text-center" style="width: 10px;">:</td>
                            <td class="text-right">' . info_desc_produk($row['PRODUK']) . ' / ' . $row['NAMA_JENIS_BIAYA'] . '</td>
                        </tr>
						<tr>
                            <td class="text-left" style="width: 200px;">Rate</td>
                            <td class="text-center" style="width: 10px;">:</td>
                            <td class="text-right">' . $jenis_rate . '</td>
                        </tr>
                        <tr>
                            <td class="text-left" style="width: 200px;">Plafond</td>
                            <td class="text-center" style="width: 10px;">:</td>
                            <td class="text-right">' . number_format($row['PLAFOND']) . '</td>
                        </tr>
                        <tr>
                            <td class="text-left" style="width: 200px;">Tenor</td>
                            <td class="text-center" style="width: 10px;">:</td>
                            <td class="text-right">' . $row['TENOR'] . ' Bulan </td>
                        </tr>
                        <tr>
                            <td class="text-left" style="width: 200px;">Angsuran</td>
                            <td class="text-center" style="width: 10px;">:</td>
                            <td class="text-right">' . number_format($row['ANGSURAN_KOP']) . '</td>
                        </tr>
                        ';

        if ($isSumberDana7) {
            $html .= '
                            <tr>
                            <td class="text-left" style="width: 200px;">Angsuran Pembulatan</td>
                            <td class="text-center" style="width: 10px;">:</td>
                            <td class="text-right">' . number_format(pembulatan_angsuran_sip($row['ANGSURAN_KOP'])) . '</td>
                        </tr>';
        }

        $html .= '
      
						<tr class="bg-grey-transparent-1">  
                            <td class="text-left" colspan="3"><b>Informasi Jumlah Angsuran</b></td>
                        </tr>
                        <tr>
                            <td class="text-left" style="width: 200px;">Gaji Bersih</td>
                            <td class="text-center" style="width: 10px;">:</td>
                            <td class="text-right">
                                <div class="pull-left"><small>' . calculate_ratio_angsuran($row['GAJI_BERSIH'], $row['GAJI_BERSIH'], 0)  . '</small></div>
                                <div class="pull-right">' . number_format($row['GAJI_BERSIH']) . '</div>
                            </td>
                        </tr>
						<tr>
                            <td class="text-left" style="width: 200px;">Angsuran</td>
                            <td class="text-center" style="width: 10px;">:</td>
                            <td class="text-right">
                                <div class="pull-left"><small>' . calculate_ratio_angsuran($row['ANGSURAN_KOP'], $row['GAJI_BERSIH'], 0)  . '</small></div>
                                <div class="pull-right">' . number_format($row['ANGSURAN_KOP']) . '</div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left" style="width: 200px;">Sisa Gaji</td>
                            <td class="text-center" style="width: 10px;">:</td>
                            <td class="text-right">
                                <div class="pull-left"><small>' . calculate_ratio_angsuran(($row['GAJI_BERSIH'] - $row['ANGSURAN_KOP']), $row['GAJI_BERSIH'], 0)  . '</small></div>
                                <div class="pull-right">' . number_format($row['GAJI_BERSIH'] - $row['ANGSURAN_KOP']) . '</div>
                            </td>
                        </tr>
						<tr class="bg-grey-transparent-1">
							<td class="text-left" colspan="3"><b>Analisa Usia</b></td>
						</tr>
						<tr>
							<td class="text-left" style="width: 150px;">Tanggal Simulasi</td>
							<td class="text-center" style="width: 10px;">:</td>
							<td class="text-right">' . format_date_indo_v2($row['TANGGAL_PENGAJUAN']) . '</td>
						</tr>
						<tr>
							<td class="text-left" style="width: 150px;">Usia Saat Masuk</td>
							<td class="text-center" style="width: 10px;">:</td>
							<td class="text-right">' . calculate_age_details($row['TANGGAL_PENGAJUAN'], $row['TANGGAL_LAHIR'])['age_detail'] . '</td>
						</tr>
						<tr>
							<td class="text-left">Usia Saat Jatuh Tempo</td>
							<td class="text-center">:</td>
							<td class="text-right">' . calculate_age_details_jatuhtempo($row['TANGGAL_PENGAJUAN'], $row['TANGGAL_LAHIR'], $row['TENOR'])['age_detail'] . '</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="col-md-4">
				<table class="' . $style_table . '">
					<tbody>
						<tr class="bg-grey-transparent-1">
							<td class="text-left" colspan="3"><b>Rincian biaya potongan</b></td>
						</tr>
						<tr>
							<td class="text-left">Biaya Asuransi</td>
							<td class="text-center">:</td>
							<td class="text-right">' . number_format($row['NOMINAL_BY_ASS_KOP']) . '</td>
						</tr>
						<tr>
							<td class="text-left">Biaya Administrasi</td>
							<td class="text-center">:</td>
							<td class="text-right">' . number_format($row['NOMINAL_BY_ADM']) . '</td>
						</tr>
						<tr>
                            <td class="text-left">' . ($isSumberDana7 ? 'Biaya Tatalaksana' : 'Biaya Provisi') . '</td>
                            <td class="text-center">:</td>
                            <td class="text-right">' . number_format($row['NOMINAL_BY_PROVISI']) . '</td>
                        </tr>
						<tr>
							<td class="text-left">Tabungan Wajib</td>
							<td class="text-center">:</td>
							<td class="text-right">' . number_format($row['NOMINAL_BY_TABUNGANWAJIB']) . '</td>
						</tr>
						<tr>
							<td class="text-left">Biaya Buka Rekening</td>
							<td class="text-center">:</td>
							<td class="text-right">' . number_format($row['NOMINAL_BY_BUKA_REKENING']) . '</td>
						</tr>
						<tr>
                            <td class="text-left">Biaya Notaris</td>
                            <td class="text-center">:</td>
                            <td class="text-right">' . number_format($notaris) . '</td>
                        </tr>
						';

        if ($isSumberDana7) {
            $html .= '
                            <tr>
                                <td class="text-left">Biaya Pemasaran</td>
                                <td class="text-center">:</td>
                                <td class="text-right">' . number_format($by_pemasaran) . '</td>
                            </tr>';
        }

        $html .= '
						<tr>
							<td class="text-left">Biaya Lainnya</td>
							<td class="text-center">:</td>
							<td class="text-right">' . number_format($row['NOMINAL_BY_LAINNYA']) . '</td>
						</tr>
						<tr>
                            <td class="text-left">Retensi Angsuran</td>
                            <td class="text-center">:</td>
                            <td class="text-right">
                                <span class="pull-left">
                                    (' . (($row['NOMINAL_RETENSI'] == 0 || $row['ANGSURAN_KOP'] == 0) ? '0' : round($row['NOMINAL_RETENSI'] / $row['ANGSURAN_KOP']) . '') . ')
                                </span>
                                ' . number_format(pembulatan_angsuran_sip($row['NOMINAL_RETENSI']), 0, ',', '.') . '
                            </td>
                        </tr>
						<tr>
							<td class="text-left">Blokir Angsuran</td>
							<td class="text-center">:</td>
							<td class="text-right"> <span class="pull-left">(' . $row['POT_UM'] . ')</span> ' . number_format(pembulatan_angsuran_sip($row['NOMINAL_POT_UM'])) . '</td>
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
				<table class="' . $style_table . '">
					<tbody>
						<tr class="bg-grey-transparent-1">
							<td class="text-left" colspan="3"><b>Rincian penerimaan</b></td>
						</tr>
						<tr>
							<td class="text-left" style="width: 150px;">(A) Plafond</td>
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
		</div>
        ';

        return $html;
    }
}

// Component info status pegawai
if (!function_exists('info_status_pegawai')) {
    function info_status_pegawai($kode = "")
    {
        $status = [
            "1"  => "(01) KONTRAK",
            "2"  => "(02) PEGAWAI TETAP",
            "3"  => "(03) OUTSOURCING",
            "4"  => "(04) HONORER",
            "5"  => "(05) PEGAWAI NEGERI SIPIL (PNS)",
            "6"  => "(06) PEGAWAI PPPK",
            "7"  => "(07) TENAGA HARIAN LEPAS (THL)",
            "8"  => "(08) FREELANCER / PEKERJA LEPAS",
            "9"  => "(09) MAGANG / INTERNSHIP",
            "10" => "(10) PEGAWAI PENSIUN"
        ];

        return isset($status[$kode]) ? $status[$kode] : "-";
    }
}

// Component info status pegawai
if (!function_exists('info_desc_produk')) {
    function info_desc_produk($kode = "")
    {
        $status = [
            "KPENPOS" => "KPENPOS",
        ];

        return isset($status[$kode]) ? $status[$kode] : "-";
    }
}

// Menghitung nominal terima bersih pinjaman
if (!function_exists('hitung_terima_bersih')) {
    /**
     * Menghitung nominal terima bersih pinjaman
     * Formula: Plafond - Total Biaya Potongan - Nominal Pelunasan
     * 
     * @param int $id_pinjaman ID pinjaman yang akan dihitung
     * @return float Nominal terima bersih
     */
    function hitung_terima_bersih($id_pinjaman)
    {
        $CI = &get_instance();

        // Validasi input
        if (empty($id_pinjaman)) {
            return 0;
        }

        // Query menggunakan Query Builder CodeIgniter 3
        $data = $CI->db->select([
            'PLAFOND',
            'NOMINAL_PELUNASAN',
            'NOMINAL_POT_UM',
            'NOMINAL_RETENSI',
            'NOMINAL_RETENSI_TMP',
            'NOMINAL_BY_ADM',
            'NOMINAL_BY_PROVISI',
            'NOMINAL_BY_ASS_KOP',
            'NOMINAL_BY_LAINNYA',
            'NOMINAL_BY_MUTASI',
            'NOMINAL_BY_TATALAKASAN',
            'NOMINAL_BY_BUKA_REKENING',
            'NOMINAL_BY_FLAG',
            'NOMINAL_BPP'
        ])->from('vw_pinjaman')->where('ID_PINJAMAN', $id_pinjaman)->get()->row_array();

        // Jika data tidak ditemukan
        if (empty($data)) {
            return 0;
        }

        // Ambil nilai utama
        $plafond = floatval($data['PLAFOND'] ?? 0);
        $nominal_pelunasan = floatval($data['NOMINAL_PELUNASAN'] ?? 0);

        // Daftar semua biaya potongan
        $biaya_fields = [
            'NOMINAL_POT_UM',           // Potongan UM
            'NOMINAL_RETENSI',          // Retensi
            'NOMINAL_RETENSI_TMP',      // Retensi Temporary
            'NOMINAL_BY_ADM',           // Biaya Administrasi
            'NOMINAL_BY_PROVISI',       // Biaya Provisi
            'NOMINAL_BY_ASS_KOP',       // Biaya Asuransi Koperasi
            'NOMINAL_BY_LAINNYA',       // Biaya Lainnya
            'NOMINAL_BY_MUTASI',        // Biaya Mutasi
            'NOMINAL_BY_TATALAKASAN',   // Biaya Tata Laksana
            'NOMINAL_BY_BUKA_REKENING', // Biaya Buka Rekening
            'NOMINAL_BY_FLAG',          // Biaya Flag
            'NOMINAL_BPP'               // Biaya BPP
        ];

        // Hitung total semua biaya potongan
        $total_biaya = 0;
        foreach ($biaya_fields as $field) {
            $total_biaya += floatval($data[$field] ?? 0);
        }

        // Formula: Plafond - Total Biaya - Nominal Pelunasan
        $terima_bersih = $plafond - $total_biaya - $nominal_pelunasan;

        return $terima_bersih;
    }
}

// Pembulatan angsuran
// Untuk BPR Mulya Artha
if (!function_exists('pembulatan_angsuran')) {
    function pembulatan_angsuran($angsuran)
    {
        // Jika 0 atau sudah kelipatan 500, langsung kembalikan
        if ($angsuran == 0 || $angsuran % 500 === 0) {
            return $angsuran;
        }

        // Bulatkan ke atas ke kelipatan 500
        return ceil($angsuran / 500) * 500;
    }
}

// Pembulatan angsuran
// Untuk BPR SIP
if (!function_exists('pembulatan_angsuran_sip')) {
    function pembulatan_angsuran_sip($angsuran)
    {
        // Jika sudah bulat ke 5000, tidak usah dibulatkan lagi
        if ($angsuran % 5000 === 0) {
            return $angsuran;
        }

        // Bulatkan ke atas ke kelipatan 5000 terdekat
        return ceil($angsuran / 5000) * 5000;
    }
}
