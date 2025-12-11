<?php

/**
 * MY_Infocomponent1_helper.php
 *
 * @package    CodeIgniter
 * @subpackage Helpers
 * @author     Ridwan Panji Akbar (Oneread), Darva Drasthya (Oneread)
 * @license    https://opensource.org/licenses/MIT MIT License
 * @version    1.0.0
 *
 * @description
 * File ini adalah helper kustom untuk komponen informasi dalam aplikasi CodeIgniter.
 * Helper ini menyediakan fungsi tambahan yang dapat digunakan untuk manipulasi
 * data, perhitungan logika tertentu, atau utilitas lainnya yang relevan dengan
 * "Infocomponent1".
 *
 */

// Component info Uniq Id
if (!function_exists('info_uniqid')) {
    function info_uniqid($pinjamanId, $style_table = 'table table-condensed')
    {
        // Initial
        $_CI = &get_instance();

        // query
        $_CI->db->select("*");
        $_CI->db->from("vw_pinjaman");
        $_CI->db->where("ID_PINJAMAN", $pinjamanId);

        // Output
        $row = $_CI->db->get()->row();

        $html  = '';
        $html .= '';

        $html .= '
        <div class="m-b-10">
            <div class="f-s-13"><b>Informasi Account ID</b></div>
            <div class="f-s-11">Detail Informasi AccountID</div>
        </div>

        <table class="' . $style_table . '">
            <tbody>
                <tr>
                    <td>
                        <div>CIF ID</div>
                        <div><b>' . str_pad($row->ID_DEBITUR, 8, "0", STR_PAD_LEFT) . '</b></div>
                    </td>
                    <td>
                        <div>Loan ID</div>
                        <div><b>' . str_pad($row->ID_PINJAMAN, 8, "0", STR_PAD_LEFT) . '</b></div>
                    </td>
                    <td>
                        <div>Account ID</div>
                        <div><b>' . str_pad($row->NO_TABUNGAN, 10, "0", STR_PAD_LEFT) . '</b></div>
                    </td>
                </tr>
            </tbody>
        </table>';

        return $html;
    }
}

// Component info kantor layanan
if (!function_exists('info_kantorlayanan')) {
    function info_kantorlayanan($pinjamanId, $style_table = 'table table-condensed')
    {
        // Initial
        $_CI = &get_instance();

        // query
        $_CI->db->select("*");
        $_CI->db->from("vw_pinjaman");
        $_CI->db->where("ID_PINJAMAN", $pinjamanId);

        // Output
        $row = $_CI->db->get()->row();

        $html  = '';
        $html .= '';

        $html .= '
        <div class="m-b-10">
            <div class="f-s-13"><b>Informasi Kantor</b></div>
            <div class="f-s-11">Detail Informasi Kantor Area dan Layanan </div>
        </div>

        <table class="' . $style_table . '">
            <tbody>
                <tr>
                    <td class="width-150">Kode Area</td>
                    <td>' . $row->KODE_AREA . '</td>
                </tr>
                <tr>
                    <td>Kantor Layanan</td>
                    <td>' . $row->KODE_CABANG . ' ' . $row->NAMA_CABANG . '</td>
                </tr>
                <tr>
                    <td>SPV / Manajer</td>
                    <td>' . $row->ID_KARYAWAN_SPV . ' ' . get_nama_karyawan($row->ID_KARYAWAN_SPV) . '</td>
                </tr>
                <tr>
                    <td>Admin Officer</td>
                    <td>' . $row->ID_KARYAWAN_AO . ' ' . get_nama_karyawan($row->ID_KARYAWAN_AO) . '</td>
                </tr>
                <tr>
                <td>' . ($row->IS_FEE == 0.03 ? "Marketing Agent" : "Marketing Officer") . '</td>
                <td>' . $row->ID_KARYAWAN_MKT . ' ' . get_nama_karyawan($row->ID_KARYAWAN_MKT) . '</td>
            </tr>
            </tbody>
        </table>';

        return $html;
    }
}

// Component info Data KTP Pemohon
if (!function_exists('info_ktp_pemohon')) {
    function info_ktp_pemohon($pinjamanId, $style_table = 'table table-condensed')
    {
        // Initial
        $_CI = &get_instance();

        // query
        $_CI->db->select("*");
        $_CI->db->from("vw_pinjaman");
        $_CI->db->where("ID_PINJAMAN", $pinjamanId);

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

// Component info Data KTP Pemohon
if (!function_exists('__info_ktp_pasangan')) {
    function __info_ktp_pasangan($pinjamanId, $style_table = 'table table-condensed')
    {
        // Initial
        $_CI = &get_instance();

        // query
        $_CI->db->select("*");
        $_CI->db->from("vw_pinjaman");
        $_CI->db->where("ID_PINJAMAN", $pinjamanId);

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

if (!function_exists('info_ktp_pasangan')) {
    function info_ktp_pasangan($pinjamanId, $style_table = 'table table-condensed')
    {
        $_CI = &get_instance();
        $_CI->db->select("*");
        $_CI->db->from("vw_pinjaman");
        $_CI->db->where("ID_PINJAMAN", $pinjamanId);
        $row = $_CI->db->get()->row();

        // Helper: tampilkan "-" jika null/empty
        $safe = function ($value) {
            return empty($value) ? '-' : $value;
        };

        // Helper khusus status kawin: hanya tampilkan jika "menikah"
        $status_kawin = '-';
        if ($row && !empty($row->STATUS_KAWIN)) {
            if (strtolower(trim($row->STATUS_KAWIN)) === 'KAWIN') {
                $status_kawin = $row->STATUS_KAWIN;
            }
        }

        // Helper untuk tanggal lahir (gabung tempat & tanggal)
        $tempat_tgl_lahir = '-';
        if ($row) {
            $tempat = !empty($row->PSG_TEMPAT_LAHIR) ? $row->PSG_TEMPAT_LAHIR : '';
            $tgl = !empty($row->PSG_TANGGAL_LAHIR) && $row->PSG_TANGGAL_LAHIR !== '0000-00-00'
                ? format_date_indo_v2($row->PSG_TANGGAL_LAHIR)
                : '';
            if ($tempat || $tgl) {
                $tempat_tgl_lahir = $tempat . ($tempat && $tgl ? ', ' : '') . $tgl;
            }
        }

        // Helper RT/RW
        $rtrw = '- / -';
        if ($row && !empty($row->PSG_RTRW)) {
            $rt = split_rtrw($row->PSG_RTRW, 'rt') ?: '-';
            $rw = split_rtrw($row->PSG_RTRW, 'rw') ?: '-';
            $rtrw = $rt . ' / ' . $rw;
        }

        $html = '
        <div class="m-b-10">
            <div class="f-s-13"><b>Data Identitas Pasangan (KTP)</b></div>
        </div>

        <table class="' . $style_table . '">
            <tbody>
                <tr>
                    <td class="width-150">Nomor Identitas (NIK)</td>
                    <td>' . ($row ? $safe($row->PSG_NIK_KTP) : '-') . '</td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>' . ($row ? $safe($row->PSG_NAMA) : '-') . '</td>
                </tr>
                <tr>
                    <td>Tempat, Tanggal Lahir</td>
                    <td>' . $tempat_tgl_lahir . '</td>
                </tr>
                <tr>
                    <td>Jenis Kelamin</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>' . ($row ? $safe($row->PSG_ALAMAT) : '-') . '</td>
                </tr>
                <tr>
                    <td><span class="m-l-20">RT/RW</span></td>
                    <td>' . $rtrw . '</td>
                </tr>
                <tr>
                    <td><span class="m-l-20">Kel/Desa</span></td>
                    <td>' . ($row ? $safe($row->PSG_KELURAHAN) : '-') . '</td>
                </tr>
                <tr>
                    <td><span class="m-l-20">Kecamatan</span></td>
                    <td>' . ($row ? $safe($row->PSG_KECAMATAN) : '-') . '</td>
                </tr>
                <tr>
                    <td><span class="m-l-20">Kota/Kabupaten</span></td>
                    <td>' . ($row ? $safe($row->PSG_KABKOT) : '-') . '</td>
                </tr>
                <tr>
                    <td><span class="m-l-20">Kode Pos</span></td>
                    <td>' . ($row ? $safe($row->PSG_KODE_POS) : '-') . '</td>
                </tr>
                <tr>
                    <td><span class="m-l-20">Provinsi</span></td>
                    <td>' . ($row ? $safe($row->PSG_PROVINSI) : '-') . '</td>
                </tr>
                <tr>
                    <td>Agama</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td>Status Perkawinan</td>
                    <td>' . $row->STATUS_KAWIN . '</td>
                </tr>
                <tr>
                    <td>Pekerjaan</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td>Kewarganegaraan</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td>Tanggal Terbit</td>
                    <td>' . ($row ? is_ktp_exp($row->PSG_TANGGAL_TERBIT_KTP, 'd/m/Y') : '-') . '</td>
                </tr>
                <tr>
                    <td>Berlaku Hingga</td>
                    <td>' . ($row ? is_ktp_exp($row->PSG_TANGGAL_EXP_KTP, 'd/m/Y') : '-') . '</td>
                </tr>
            </tbody>
        </table>';

        return $html;
    }
}

// Component info Data Alamat Lengkap
if (!function_exists('info_alamat_lengkap')) {
    function info_alamat_lengkap($pinjamanId, $style_table = 'table table-condensed')
    {
        // Initial
        $_CI = &get_instance();

        // query
        $_CI->db->select("*");
        $_CI->db->from("vw_pinjaman");
        $_CI->db->where("ID_PINJAMAN", $pinjamanId);

        // Output
        $row = $_CI->db->get()->row();

        // Alamat lengkap
        $alamat_lengkap_ktp_pemohon = $row->ALAMAT . ' RT/RW ' . $row->RTRW . ' KEL/Desa ' . $row->KELURAHAN . ' KEC. ' . $row->KECAMATAN . ' Kab/Kota ' . $row->KABKOT . ', ' . $row->KODE_POS . ', ' . $row->PROVINISI;
        $alamat_lengkap_ktp_pemohon_gmaps = anchor_popup($row->URL_MAPS, '<i class="fas fa-globe"></i> Visit Link', ['style' => 'text-decoration: none;']);

        $alamat_lengkap_domisili = $row->DOMISILI_ALAMAT . ' RT/RW ' . $row->DOMISILI_RTRW . ' KEL/Desa ' . $row->DOMISILI_KELURAHAN . ' KEC. ' . $row->DOMISILI_KECAMATAN . ' Kab/Kota ' . $row->DOMISILI_KABKOT . ', ' . $row->DOMISILI_KODE_POS;
        $alamat_lengkap_domisili_gmaps = anchor_popup($row->DOMISILI_URL_MAPS, '<i class="fas fa-globe"></i> Visit Link', ['style' => 'text-decoration: none;']);

        $html  = '';
        $html .= '';

        $html .= '
        <div class="m-b-5">
            <div class="f-s-13"><b>Data Alamat Lengkap</b></div>
        </div>

        <table class="' . $style_table . '">
            <tbody>
                <tr>
                    <td class="width-150">Alamat Pemohon</td>
                    <td>
                        <div>' . $alamat_lengkap_ktp_pemohon . '</div>
                        <div> ' . $alamat_lengkap_ktp_pemohon_gmaps . '</div>
                    </td>
                </tr>
                <tr>
                    <td>Alamat Domisili</td>
                    <td>
                        <div>' . $alamat_lengkap_domisili . '</div>
                        <div> ' . $alamat_lengkap_domisili_gmaps . '</div>
                    </td>
                </tr>
            </tbody>
        </table>';

        return $html;
    }
}

// Component Tampilkan dua peta Leaflet: Alamat KTP & Domisili (versi dengan tema dan animasi marker)
if (!function_exists('info_alamat_maps')) {
    /**
     * Tampilkan dua peta Leaflet: Alamat KTP & Domisili
     * dengan dukungan tema (default, light, dark)
     *
     * @param int $pinjamanId
     * @param int $height tinggi peta (px)
     * @param string $theme tema peta: default|light|dark
     * @return string HTML
     */
    function info_alamat_maps($pinjamanId, $height = 300, $theme = 'default')
    {
        $_CI = &get_instance();

        // Ambil data pinjaman
        $_CI->db->select("
            ID_PINJAMAN,
            LATITUDE, LONGITUDE, URL_MAPS,
            DOMISILI_LATITUDE, DOMISILI_LONGITUDE, DOMISILI_URL_MAPS,
            ALAMAT, DOMISILI_ALAMAT,
            RTRW, KELURAHAN, KECAMATAN, KABKOT, KODE_POS, PROVINISI,
            DOMISILI_RTRW, DOMISILI_KELURAHAN, DOMISILI_KECAMATAN, DOMISILI_KABKOT, DOMISILI_KODE_POS
        ");
        $_CI->db->from("vw_pinjaman");
        $_CI->db->where("ID_PINJAMAN", $pinjamanId);
        $row = $_CI->db->get()->row();

        if (!$row) {
            return '<div class="text-danger">Data alamat tidak ditemukan.</div>';
        }

        // Koordinat dari database
        $coordKtp = (!empty($row->LATITUDE) && !empty($row->LONGITUDE))
            ? ['lat' => $row->LATITUDE, 'lng' => $row->LONGITUDE]
            : null;

        $coordDomisili = (!empty($row->DOMISILI_LATITUDE) && !empty($row->DOMISILI_LONGITUDE))
            ? ['lat' => $row->DOMISILI_LATITUDE, 'lng' => $row->DOMISILI_LONGITUDE]
            : null;

        if (!$coordKtp && !$coordDomisili) {
            return '<div class="text-warning">Koordinat tidak ditemukan di database.</div>';
        }

        // ID unik untuk elemen map
        $mapIdKtp = 'map_ktp_' . uniqid();
        $mapIdDomisili = 'map_domisili_' . uniqid();

        // Tile layer berdasarkan tema
        $tileLayer = [
            'default' => 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            'light'   => 'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png',
            'dark'    => 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png'
        ];
        $tileUrl = $tileLayer[$theme] ?? $tileLayer['default'];

        // Format alamat lengkap
        $alamatKtp = trim("{$row->ALAMAT} RT/RW {$row->RTRW}, Kel. {$row->KELURAHAN}, Kec. {$row->KECAMATAN}, {$row->KABKOT}, {$row->KODE_POS}, {$row->PROVINISI}");
        $alamatDomisili = trim("{$row->DOMISILI_ALAMAT} RT/RW {$row->DOMISILI_RTRW}, Kel. {$row->DOMISILI_KELURAHAN}, Kec. {$row->DOMISILI_KECAMATAN}, {$row->DOMISILI_KABKOT}, {$row->DOMISILI_KODE_POS}");

        // HTML Output
        $html = '
        <div class="row">
            <div class="col-md-6">
                <div class="m-b-10">
                    <div class="f-s-13"><b>Lokasi Alamat KTP Pemohon</b></div>
                </div>
                <div id="' . $mapIdKtp . '" style="height:' . (int)$height . 'px; border-radius:8px; border:1px solid #ccc; overflow:hidden;"></div>
            </div>

            <div class="col-md-6">
                <div class="m-b-10">
                    <div class="f-s-13"><b>Lokasi Alamat Domisili</b></div>
                </div>
                <div id="' . $mapIdDomisili . '" style="height:' . (int)$height . 'px; border-radius:8px; border:1px solid #ccc; overflow:hidden;"></div>
            </div>
        </div>

        <!-- Leaflet CSS & JS -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

        <script>
        document.addEventListener("DOMContentLoaded", function() {
            // === MAP KTP ===
            ' . ($coordKtp ? "
                var mapKtp = L.map('$mapIdKtp').setView([{$coordKtp['lat']}, {$coordKtp['lng']}], 12);
                L.tileLayer('$tileUrl', {
                    maxZoom: 19,
                    attribution: '© OpenStreetMap contributors'
                }).addTo(mapKtp);
                L.marker([{$coordKtp['lat']}, {$coordKtp['lng']}])
                    .addTo(mapKtp)
                    .bindPopup('<b>Alamat KTP:</b><br><small>" . addslashes($alamatKtp) . "</small>');
            " : "") . '

            // === MAP DOMISILI ===
            ' . ($coordDomisili ? "
                var mapDom = L.map('$mapIdDomisili').setView([{$coordDomisili['lat']}, {$coordDomisili['lng']}], 12);
                L.tileLayer('$tileUrl', {
                    maxZoom: 19,
                    attribution: '© OpenStreetMap contributors'
                }).addTo(mapDom);
                L.marker([{$coordDomisili['lat']}, {$coordDomisili['lng']}])
                    .addTo(mapDom)
                    .bindPopup('<b>Alamat Domisili:</b><br><small>" . addslashes($alamatDomisili) . "</small>');
            " : "") . '
        });
        </script>';

        return $html;
    }
}

// Component Tampilkan dua peta Leaflet: Alamat KTP & Domisili (versi dengan tema dan animasi marker)
// v2.0
if (!function_exists('info_alamat_maps_with_validation')) {
    /**
     * Tampilkan peta KTP, peta Domisili, dan panel informasi validasi jarak (tabel compact)
     *
     * @param int $pinjamanId
     * @param int $height tinggi peta (px)
     * @param string $theme tema peta: default|light|dark
     * @param int $threshold_meters jarak maksimum (meter) untuk dianggap "sesuai"
     * @return string HTML
     */
    function info_alamat_maps_with_validation($pinjamanId, $height = 300, $theme = 'default', $threshold_meters = 500)
    {
        $_CI = &get_instance();

        $_CI->db->select("
            ID_PINJAMAN,
            LATITUDE, LONGITUDE, URL_MAPS,
            DOMISILI_LATITUDE, DOMISILI_LONGITUDE, DOMISILI_URL_MAPS,
            ALAMAT, DOMISILI_ALAMAT,
            RTRW, KELURAHAN, KECAMATAN, KABKOT, KODE_POS, PROVINISI,
            DOMISILI_RTRW, DOMISILI_KELURAHAN, DOMISILI_KECAMATAN, DOMISILI_KABKOT, DOMISILI_KODE_POS
        ");
        $_CI->db->from("vw_pinjaman");
        $_CI->db->where("ID_PINJAMAN", $pinjamanId);
        $row = $_CI->db->get()->row();

        if (!$row) {
            return '<div class="text-danger">Data alamat tidak ditemukan.</div>';
        }

        $ktpLat = $row->LATITUDE ? floatval($row->LATITUDE) : null;
        $ktpLng = $row->LONGITUDE ? floatval($row->LONGITUDE) : null;
        $domLat = $row->DOMISILI_LATITUDE ? floatval($row->DOMISILI_LATITUDE) : null;
        $domLng = $row->DOMISILI_LONGITUDE ? floatval($row->DOMISILI_LONGITUDE) : null;

        // --- Fungsi jarak Haversine ---
        $haversine = function ($lat1, $lng1, $lat2, $lng2) {
            if ($lat1 === null || $lng1 === null || $lat2 === null || $lng2 === null) return null;
            $R = 6371000;
            $dLat = deg2rad($lat2 - $lat1);
            $dLon = deg2rad($lng2 - $lng1);
            $a = sin($dLat / 2) ** 2 + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) ** 2;
            return $R * 2 * atan2(sqrt($a), sqrt(1 - $a));
        };

        // --- Fungsi arah (bearing) ---
        $bearing = function ($lat1, $lng1, $lat2, $lng2) {
            if ($lat1 === null || $lng1 === null || $lat2 === null || $lng2 === null) return null;
            $lat1 = deg2rad($lat1);
            $lat2 = deg2rad($lat2);
            $dLon = deg2rad($lng2 - $lng1);
            $y = sin($dLon) * cos($lat2);
            $x = cos($lat1) * sin($lat2) - sin($lat1) * cos($lat2) * cos($dLon);
            $brng = rad2deg(atan2($y, $x));
            $brng = fmod(($brng + 360), 360);
            $dirs = [
                [0, 22.5, 'Utara'], [22.5, 67.5, 'Timur Laut'], [67.5, 112.5, 'Timur'],
                [112.5, 157.5, 'Tenggara'], [157.5, 202.5, 'Selatan'], [202.5, 247.5, 'Barat Daya'],
                [247.5, 292.5, 'Barat'], [292.5, 337.5, 'Barat Laut'], [337.5, 360, 'Utara']
            ];
            $direction = 'N/A';
            $d = [];
            foreach ($dirs as $d) if ($brng >= $d[0] && $brng < $d[1]) $direction = $d[2];
            return ['bearing' => round($brng, 1), 'direction' => $direction];
        };

        $distance_m = $haversine($ktpLat, $ktpLng, $domLat, $domLng);
        $brng = $bearing($ktpLat, $ktpLng, $domLat, $domLng);

        $is_within = $distance_m !== null && $distance_m <= $threshold_meters;
        $verdict = $distance_m === null
            ? '<span class="text-warning fw-bold">Tidak dapat diverifikasi</span>'
            : ($is_within
                ? '<span class="text-success fw-bold">Sesuai (≤ ' . number_format($threshold_meters) . ' m)</span>'
                : '<span class="text-danger fw-bold">Tidak Sesuai (> ' . number_format($threshold_meters) . ' m)</span>');

        // Format alamat lengkap
        $alamatKtp = trim("{$row->ALAMAT} RT/RW {$row->RTRW}, Kel. {$row->KELURAHAN}, Kec. {$row->KECAMATAN}, {$row->KABKOT}, {$row->KODE_POS}, {$row->PROVINISI}");
        $alamatDomisili = trim("{$row->DOMISILI_ALAMAT} RT/RW {$row->DOMISILI_RTRW}, Kel. {$row->DOMISILI_KELURAHAN}, Kec. {$row->DOMISILI_KECAMATAN}, {$row->DOMISILI_KABKOT}, {$row->DOMISILI_KODE_POS}");

        $tile = [
            'default' => 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            'light' => 'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png',
            'dark' => 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png'
        ][$theme] ?? 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';

        $mapIdKtp = 'map_ktp_' . uniqid();
        $mapIdDom = 'map_dom_' . uniqid();

        // --- Informasi pakai tabel ---
        $infoHtml = '
        <div class="card" style="height:' . (int)$height . 'px; font-size:13px;">
            <div class="card-body p-2">
                <div class="m-b-10">
                    <div class="f-s-13"><b>Validasi Lokasi</b></div>
                </div>
                <table class="table sp7-table-xs table-condensed table-striped sp7-table-no-border">
                    <tbody>
                        <tr><th width="45%">Status</th><td>' . $verdict . '</td></tr>
                        <tr><th>Jarak</th><td>' . ($distance_m ? number_format($distance_m, 1, ',', '.') . ' m (' . number_format($distance_m / 1000, 3, ',', '.') . ' km)' : '-') . '</td></tr>
                        <tr><th>Arah</th><td>' . ($brng ? $brng['direction'] . ' (~' . $brng['bearing'] . '°)' : '-') . '</td></tr>
                        <tr><th>Koordinat KTP</th><td>' . ($ktpLat ? "{$ktpLat}, {$ktpLng}" : '-') . '</td></tr>
                        <tr><th>Koordinat Domisili</th><td>' . ($domLat ? "{$domLat}, {$domLng}" : '-') . '</td></tr>
                    </tbody>
                </table>
                <div class="small text-primary">
                    <ul class="mb-0 ps-3">
                        <li>Presisi validasi maksimal ' . intval($threshold_meters) . ' meter.</li>
                        <li>Perbedaan > ' . intval($threshold_meters) . ' m disarankan verifikasi lapangan.</li>
                    </ul>
                </div>
            </div>
        </div>';

        // --- Output HTML utama (3 kolom) ---
        $html = '
        <div class="row">
            <div class="col-md-4">
                <div class="m-b-10">
                    <div class="f-s-13"><b>Lokasi Alamat KTP Pemohon</b></div>
                </div>
                <div id="' . $mapIdKtp . '" style="height:' . (int)$height . 'px; border-radius:8px; border:1px solid #ccc;"></div>
            </div>
            <div class="col-md-4">
                <div class="m-b-10">
                    <div class="f-s-13"><b>Lokasi Alamat Domisili</b></div>
                </div>
                <div id="' . $mapIdDom . '" style="height:' . (int)$height . 'px; border-radius:8px; border:1px solid #ccc;"></div>
            </div>
            <div class="col-md-4">
                ' . $infoHtml . '
            </div>
        </div>

        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

        <script>
        document.addEventListener("DOMContentLoaded", function() {
            var tileUrl = "' . $tile . '";

            // Map KTP
            var mapKtp = L.map("' . $mapIdKtp . '").setView([' . ($ktpLat ?? 0) . ', ' . ($ktpLng ?? 0) . '], ' . ($ktpLat ? 15 : 2) . ');
            L.tileLayer(tileUrl, { maxZoom: 19, attribution: "© Oneread Security Labs" }).addTo(mapKtp);
            ' . ($ktpLat ? 'L.marker([' . $ktpLat . ', ' . $ktpLng . ']).addTo(mapKtp).bindPopup("<b>Alamat KTP</b><br><small>' . addslashes($alamatKtp) . '</small>");' : '') . '

            // Map Domisili
            var mapDom = L.map("' . $mapIdDom . '").setView([' . ($domLat ?? 0) . ', ' . ($domLng ?? 0) . '], ' . ($domLat ? 15 : 2) . ');
            L.tileLayer(tileUrl, { maxZoom: 19, attribution: "© Oneread Security Labs" }).addTo(mapDom);
            ' . ($domLat ? 'L.marker([' . $domLat . ', ' . $domLng . ']).addTo(mapDom).bindPopup("<b>Alamat Domisili</b><br><small>' . addslashes($alamatDomisili) . '</small>");' : '') . '
        });
        </script>';

        return $html;
    }
}

// Single Maps
if (!function_exists('info_alamat_single_maps_with_validation_v1')) {
    /**
     * Versi gabungan 1 peta dengan 2 titik (alamat KTP & domisili)
     */
    function info_alamat_single_maps_with_validation_v1($pinjamanId, $height = 400, $theme = 'default', $threshold_meters = 500)
    {
        $_CI = &get_instance();

        $_CI->db->select("
            ID_PINJAMAN,
            LATITUDE, LONGITUDE, URL_MAPS,
            DOMISILI_LATITUDE, DOMISILI_LONGITUDE, DOMISILI_URL_MAPS,
            ALAMAT, DOMISILI_ALAMAT,
            RTRW, KELURAHAN, KECAMATAN, KABKOT, KODE_POS, PROVINISI,
            DOMISILI_RTRW, DOMISILI_KELURAHAN, DOMISILI_KECAMATAN, DOMISILI_KABKOT, DOMISILI_KODE_POS
        ");
        $_CI->db->from("vw_pinjaman");
        $_CI->db->where("ID_PINJAMAN", $pinjamanId);
        $row = $_CI->db->get()->row();

        if (!$row) {
            return '<div class="text-danger">Data alamat tidak ditemukan.</div>';
        }

        $ktpLat = $row->LATITUDE ? floatval($row->LATITUDE) : null;
        $ktpLng = $row->LONGITUDE ? floatval($row->LONGITUDE) : null;
        $domLat = $row->DOMISILI_LATITUDE ? floatval($row->DOMISILI_LATITUDE) : null;
        $domLng = $row->DOMISILI_LONGITUDE ? floatval($row->DOMISILI_LONGITUDE) : null;

        // --- Haversine ---
        $haversine = function ($lat1, $lng1, $lat2, $lng2) {
            if ($lat1 === null || $lng1 === null || $lat2 === null || $lng2 === null) return null;
            $R = 6371000;
            $dLat = deg2rad($lat2 - $lat1);
            $dLon = deg2rad($lng2 - $lng1);
            $a = sin($dLat / 2) ** 2 + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) ** 2;
            return $R * 2 * atan2(sqrt($a), sqrt(1 - $a));
        };

        $bearing = function ($lat1, $lng1, $lat2, $lng2) {
            if ($lat1 === null || $lng1 === null || $lat2 === null || $lng2 === null) return null;

            $lat1 = deg2rad($lat1);
            $lat2 = deg2rad($lat2);
            $dLon = deg2rad($lng2 - $lng1);

            $y = sin($dLon) * cos($lat2);
            $x = cos($lat1) * sin($lat2) - sin($lat1) * cos($lat2) * cos($dLon);
            $brng = rad2deg(atan2($y, $x));
            $brng = fmod(($brng + 360), 360);

            $dirs = [
                [0, 22.5, 'Utara'], [22.5, 67.5, 'Timur Laut'], [67.5, 112.5, 'Timur'],
                [112.5, 157.5, 'Tenggara'], [157.5, 202.5, 'Selatan'], [202.5, 247.5, 'Barat Daya'],
                [247.5, 292.5, 'Barat'], [292.5, 337.5, 'Barat Laut'], [337.5, 360, 'Utara']
            ];

            $direction = 'N/A';
            $len = count($dirs);
            for ($i = 0; $i < $len; $i++) {
                $min = $dirs[$i][0];
                $max = $dirs[$i][1];
                $label = $dirs[$i][2];
                if ($brng >= $min && $brng < $max) {
                    $direction = $label;
                    break;
                }
            }

            return ['bearing' => round($brng, 1), 'direction' => $direction];
        };

        $distance_m = $haversine($ktpLat, $ktpLng, $domLat, $domLng);
        $brng = $bearing($ktpLat, $ktpLng, $domLat, $domLng);

        // --- Validasi & status ---
        if ($distance_m === null) {
            $verdict = '<span class="text-warning fw-bold">Tidak dapat diverifikasi</span>';
        } elseif ($distance_m == 0) {
            $verdict = '<span class="text-primary fw-bold">Lokasi Sama Persis</span>';
        } elseif ($distance_m <= $threshold_meters) {
            $verdict = '<span class="text-success fw-bold">Sesuai (≤ ' . number_format($threshold_meters) . ' m)</span>';
        } else {
            $verdict = '<span class="text-danger fw-bold">Tidak Sesuai (> ' . number_format($threshold_meters) . ' m)</span>';
        }

        $alamatKtp = trim("{$row->ALAMAT} RT/RW {$row->RTRW}, Kel. {$row->KELURAHAN}, Kec. {$row->KECAMATAN}, {$row->KABKOT}, {$row->KODE_POS}, {$row->PROVINISI}");
        $alamatDom = trim("{$row->DOMISILI_ALAMAT} RT/RW {$row->DOMISILI_RTRW}, Kel. {$row->DOMISILI_KELURAHAN}, Kec. {$row->DOMISILI_KECAMATAN}, {$row->DOMISILI_KABKOT}, {$row->DOMISILI_KODE_POS}");

        $tile = [
            'default' => 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            'light' => 'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png',
            'dark' => 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png'
        ][$theme] ?? 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';

        $mapId = 'map_' . uniqid();

        // --- Panel Informasi ---
        $infoHtml = '
        <div class="card" style="height:' . (int)$height . 'px; font-size:13px;">
            <div class="card-body p-2">
                <b>Validasi Lokasi</b>
                <table class="table sp7-table-xs table-condensed table-striped sp7-table-no-border">
                    <tr><th>Status</th><td>' . $verdict . '</td></tr>
                    <tr><th>Jarak</th><td>' . ($distance_m ? number_format($distance_m, 1, ',', '.') . ' m' : '-') . '</td></tr>
                    <tr><th>Arah</th><td>' . ($brng ? $brng['direction'] . ' (' . $brng['bearing'] . '°)' : '-') . '</td></tr>
                    <tr><th>KTP</th><td>' . ($ktpLat ? "{$ktpLat}, {$ktpLng}" : '-') . '</td></tr>
                    <tr><th>Domisili</th><td>' . ($domLat ? "{$domLat}, {$domLng}" : '-') . '</td></tr>
                </table>
            </div>
        </div>';

        // --- Output HTML ---
        $html = '
        <div class="row">
            <div class="col-md-8">
                <div id="' . $mapId . '" style="height:' . (int)$height . 'px; border-radius:8px; border:1px solid #ccc;"></div>
            </div>
            <div class="col-md-4">' . $infoHtml . '</div>
        </div>

        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

        <script>
        document.addEventListener("DOMContentLoaded", function() {
            var map = L.map("' . $mapId . '").setView([' . ($ktpLat ?: 0) . ', ' . ($ktpLng ?: 0) . '], 13);
            L.tileLayer("' . $tile . '", { maxZoom: 19, attribution: "© Oneread Security Labs" }).addTo(map);

            var blueIcon = new L.Icon({
                iconUrl: "https://cdn.jsdelivr.net/gh/pointhi/leaflet-color-markers@master/img/marker-icon-blue.png",
                shadowUrl: "https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png",
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });

            var redIcon = new L.Icon({
                iconUrl: "https://cdn.jsdelivr.net/gh/pointhi/leaflet-color-markers@master/img/marker-icon-red.png",
                shadowUrl: "https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png",
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });

            var markers = [];

            ' . ($ktpLat ? 'var markerKtp = L.marker([' . $ktpLat . ', ' . $ktpLng . '], {icon: blueIcon}).addTo(map)
                .bindPopup("<b>Alamat KTP</b><br><small>' . addslashes($alamatKtp) . '</small>");
                markers.push(markerKtp);' : '') . '

            ' . ($domLat ? 'var markerDom = L.marker([' . $domLat . ', ' . $domLng . '], {icon: redIcon}).addTo(map)
                .bindPopup("<b>Alamat Domisili</b><br><small>' . addslashes($alamatDom) . '</small>");
                markers.push(markerDom);' : '') . '

            if (markers.length === 2) {
                var group = L.featureGroup(markers);
                map.fitBounds(group.getBounds().pad(0.3));

                L.polyline([
                    [' . $ktpLat . ', ' . $ktpLng . '],
                    [' . $domLat . ', ' . $domLng . ']
                ], {color: "blue", dashArray: "5,5"}).addTo(map)
                .bindPopup("Jarak: ' . ($distance_m ? number_format($distance_m, 1, ',', '.') . ' m' : '-') . '");
            }
        });
        </script>';

        return $html;
    }
}

// Single Maps With Button Theme
if (!function_exists('info_alamat_single_maps_with_validation_v2')) {
    function info_alamat_single_maps_with_validation_v2($pinjamanId, $height = 400, $theme = 'default', $threshold_meters = 500)
    {
        $_CI = &get_instance();

        $_CI->db->select("
            ID_PINJAMAN,
            LATITUDE, LONGITUDE, URL_MAPS,
            DOMISILI_LATITUDE, DOMISILI_LONGITUDE, DOMISILI_URL_MAPS,
            ALAMAT, DOMISILI_ALAMAT,
            RTRW, KELURAHAN, KECAMATAN, KABKOT, KODE_POS, PROVINISI,
            DOMISILI_RTRW, DOMISILI_KELURAHAN, DOMISILI_KECAMATAN, DOMISILI_KABKOT, DOMISILI_KODE_POS
        ");
        $_CI->db->from("vw_pinjaman");
        $_CI->db->where("ID_PINJAMAN", $pinjamanId);
        $row = $_CI->db->get()->row();

        if (!$row) {
            return '<div class="text-danger">Data alamat tidak ditemukan.</div>';
        }

        $ktpLat = $row->LATITUDE ? floatval($row->LATITUDE) : null;
        $ktpLng = $row->LONGITUDE ? floatval($row->LONGITUDE) : null;
        $domLat = $row->DOMISILI_LATITUDE ? floatval($row->DOMISILI_LATITUDE) : null;
        $domLng = $row->DOMISILI_LONGITUDE ? floatval($row->DOMISILI_LONGITUDE) : null;

        // --- Haversine ---
        $haversine = function ($lat1, $lng1, $lat2, $lng2) {
            if ($lat1 === null || $lng1 === null || $lat2 === null || $lng2 === null) return null;
            $R = 6371000;
            $dLat = deg2rad($lat2 - $lat1);
            $dLon = deg2rad($lng2 - $lng1);
            $a = sin($dLat / 2) ** 2 + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) ** 2;
            return $R * 2 * atan2(sqrt($a), sqrt(1 - $a));
        };

        // --- Bearing (arah) ---
        $bearing = function ($lat1, $lng1, $lat2, $lng2) {
            if ($lat1 === null || $lng1 === null || $lat2 === null || $lng2 === null) return null;

            $lat1 = deg2rad($lat1);
            $lat2 = deg2rad($lat2);
            $dLon = deg2rad($lng2 - $lng1);

            $y = sin($dLon) * cos($lat2);
            $x = cos($lat1) * sin($lat2) - sin($lat1) * cos($lat2) * cos($dLon);
            $brng = rad2deg(atan2($y, $x));
            $brng = fmod(($brng + 360), 360);

            $dirs = [
                [0, 22.5, 'Utara'], [22.5, 67.5, 'Timur Laut'], [67.5, 112.5, 'Timur'],
                [112.5, 157.5, 'Tenggara'], [157.5, 202.5, 'Selatan'], [202.5, 247.5, 'Barat Daya'],
                [247.5, 292.5, 'Barat'], [292.5, 337.5, 'Barat Laut'], [337.5, 360, 'Utara']
            ];

            $direction = 'N/A';
            $len = count($dirs);
            for ($i = 0; $i < $len; $i++) {
                $min = $dirs[$i][0];
                $max = $dirs[$i][1];
                $label = $dirs[$i][2];
                if ($brng >= $min && $brng < $max) {
                    $direction = $label;
                    break;
                }
            }

            return ['bearing' => round($brng, 1), 'direction' => $direction];
        };

        $distance_m = $haversine($ktpLat, $ktpLng, $domLat, $domLng);
        $brng = $bearing($ktpLat, $ktpLng, $domLat, $domLng);

        // --- Validasi & status ---
        if ($distance_m === null) {
            $verdict = '<span class="text-warning fw-bold">Tidak dapat diverifikasi</span>';
        } elseif ($distance_m == 0) {
            $verdict = '<span class="text-primary fw-bold">Lokasi Sama Persis</span>';
        } elseif ($distance_m <= $threshold_meters) {
            $verdict = '<span class="text-success fw-bold">Sesuai (≤ ' . number_format($threshold_meters) . ' m)</span>';
        } else {
            $verdict = '<span class="text-danger fw-bold">Tidak Sesuai (> ' . number_format($threshold_meters) . ' m)</span>';
        }

        $alamatKtp = trim("{$row->ALAMAT} RT/RW {$row->RTRW}, Kel. {$row->KELURAHAN}, Kec. {$row->KECAMATAN}, {$row->KABKOT}, {$row->KODE_POS}, {$row->PROVINISI}");
        $alamatDom = trim("{$row->DOMISILI_ALAMAT} RT/RW {$row->DOMISILI_RTRW}, Kel. {$row->DOMISILI_KELURAHAN}, Kec. {$row->DOMISILI_KECAMATAN}, {$row->DOMISILI_KABKOT}, {$row->DOMISILI_KODE_POS}");

        $mapId = 'map_' . uniqid();

        // --- Panel Informasi ---
        $infoHtml = '
        <div class="card" style="height:' . (int)$height . 'px; font-size:13px;">
            <div class="card-body p-2">
                <b>Validasi Lokasi</b>
                <table class="table sp7-table-xs table-condensed table-striped sp7-table-no-border">
                    <tr><th>Status</th><td>' . $verdict . '</td></tr>
                    <tr><th>Jarak</th><td>' . ($distance_m ? number_format($distance_m, 1, ',', '.') . ' m' : '-') . '</td></tr>
                    <tr><th>Arah</th><td>' . ($brng ? $brng['direction'] . ' (' . $brng['bearing'] . '°)' : '-') . '</td></tr>
                    <tr><th>KTP</th><td>' . ($ktpLat ? "{$ktpLat}, {$ktpLng}" : '-') . '</td></tr>
                    <tr><th>Domisili</th><td>' . ($domLat ? "{$domLat}, {$domLng}" : '-') . '</td></tr>
                </table>
            </div>
        </div>';

        // --- Output HTML ---
        $html = '
        <div class="row">
            <div class="col-md-8">
                <div class="mb-2 text-end">
                    <div class="btn-group btn-group-sm" role="group">
                        <button type="button" class="btn btn-outline-secondary" id="btnMapDefault">Default</button>
                        <button type="button" class="btn btn-outline-secondary" id="btnMapLight">Light</button>
                        <button type="button" class="btn btn-outline-secondary" id="btnMapDark">Dark</button>
                    </div>
                </div>
                <div id="' . $mapId . '" style="height:' . (int)$height . 'px; border-radius:8px; border:1px solid #ccc;"></div>
            </div>
            <div class="col-md-4">' . $infoHtml . '</div>
        </div>

        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

        <script>
        document.addEventListener("DOMContentLoaded", function() {
            var map = L.map("' . $mapId . '").setView([' . ($ktpLat ?: 0) . ', ' . ($ktpLng ?: 0) . '], 13);

            // --- Semua tile ---
            var tiles = {
                default: L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", { maxZoom: 19, attribution: "© OpenStreetMap"}),
                light: L.tileLayer("https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png", { maxZoom: 19, attribution: "© CartoDB"}),
                dark: L.tileLayer("https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png", { maxZoom: 19, attribution: "© CartoDB"})
            };

            tiles["' . $theme . '"].addTo(map);

            var blueIcon = new L.Icon({
                iconUrl: "https://cdn.jsdelivr.net/gh/pointhi/leaflet-color-markers@master/img/marker-icon-blue.png",
                shadowUrl: "https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png",
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });

            var redIcon = new L.Icon({
                iconUrl: "https://cdn.jsdelivr.net/gh/pointhi/leaflet-color-markers@master/img/marker-icon-red.png",
                shadowUrl: "https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png",
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });

            var markers = [];

            ' . ($ktpLat ? 'var markerKtp = L.marker([' . $ktpLat . ', ' . $ktpLng . '], {icon: blueIcon}).addTo(map)
                .bindPopup("<b>Alamat KTP</b><br><small>' . addslashes($alamatKtp) . '</small>");
                markers.push(markerKtp);' : '') . '

            ' . ($domLat ? 'var markerDom = L.marker([' . $domLat . ', ' . $domLng . '], {icon: redIcon}).addTo(map)
                .bindPopup("<b>Alamat Domisili</b><br><small>' . addslashes($alamatDom) . '</small>");
                markers.push(markerDom);' : '') . '

            if (markers.length === 2) {
                var group = L.featureGroup(markers);
                map.fitBounds(group.getBounds().pad(0.3));

                L.polyline([
                    [' . $ktpLat . ', ' . $ktpLng . '],
                    [' . $domLat . ', ' . $domLng . ']
                ], {color: "blue", dashArray: "5,5"}).addTo(map)
                .bindPopup("Jarak: ' . ($distance_m ? number_format($distance_m, 1, ',', '.') . ' m' : '-') . '");
            }

            // --- Tombol ganti peta ---
            document.getElementById("btnMapDefault").addEventListener("click", function(){
                map.eachLayer(function(layer){ if(layer instanceof L.TileLayer) map.removeLayer(layer); });
                tiles.default.addTo(map);
            });
            document.getElementById("btnMapLight").addEventListener("click", function(){
                map.eachLayer(function(layer){ if(layer instanceof L.TileLayer) map.removeLayer(layer); });
                tiles.light.addTo(map);
            });
            document.getElementById("btnMapDark").addEventListener("click", function(){
                map.eachLayer(function(layer){ if(layer instanceof L.TileLayer) map.removeLayer(layer); });
                tiles.dark.addTo(map);
            });
        });
        </script>';

        return $html;
    }
}

// Component info Data Lainnya
if (!function_exists('info_lainnya')) {
    function info_lainnya($pinjamanId, $style_table = 'table table-condensed')
    {
        // Initial
        $_CI = &get_instance();

        // query
        $_CI->db->select("*");
        $_CI->db->from("vw_pinjaman");
        $_CI->db->where("ID_PINJAMAN", $pinjamanId);

        // Output
        $row = $_CI->db->get()->row();

        $html  = '';
        $html .= '';

        $html .= '
        <div class="m-b-5">
            <div class="f-s-13"><b>Data Lainnya</b></div>
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

// Component info Data Lainnya
if (!function_exists('info_pensiun')) {
    function info_pensiun($pinjamanId, $style_table = 'table table-condensed')
    {
        // Initial
        $_CI = &get_instance();

        // query
        $_CI->db->select("*");
        $_CI->db->from("vw_pinjaman");
        $_CI->db->where("ID_PINJAMAN", $pinjamanId);

        // Output
        $row = $_CI->db->get()->row();

        if ($row->ID_INSTANSI == 1) {
            $nip = $row->NIP_NRP;
        } elseif ($row->KODE_INSTANSI == 2) {
            $nip = $row->NO_KTPA;
        } else {
            $nip = '--';
        }

        $html  = '';
        $html .= '';

        $html .= '
        <div class="row">
            <div class="col-md-6">
                <div class="m-b-5">
                    <div class="f-s-13"><b>Data Instansi Pensiun</b></div>
                </div>

                <table class="' . $style_table . '">
                    <tbody>
                        <tr>
                            <td class="width-150">Instansi Pensiun</td>
                            <td>(' . $row->KODE_INSTANSI . ') ' . $row->NAMA_INSTANSI . '</td>
                        </tr>
                        <tr>
                            <td class="width-150">Nomor Pensiun</td>
                            <td>' . $row->NO_PENSIUN . '</td>
                        </tr>
                        <tr>
                            <td class="width-150">NIP / NRP / NO KTPA</td>
                            <td>' . $nip . '</td>
                        </tr>
                        <tr>
                            <td class="width-150">Nomor Giro Pos</td>
                            <td>' . $row->NOREK_GIROPOS . '</td>
                        </tr>
                        <tr>
                            <td class="width-150">Nama Pensiun (Carik)</td>
                            <td>' . $row->NAMA_PENSIUN . '</td>
                        </tr>
                        <tr>
                            <td class="width-150">Kode Jiwa</td>
                            <td>' . $row->KODE_JIWA . '</td>
                        </tr>
                        <tr>
                            <td class="width-150">Jenis Pensiun</td>
                            <td>(' . $row->KODE_JENIS_PENSIUN . ') ' . $row->NAMA_JENIS_PENSIUN . '</td>
                        </tr>
                        <tr>
                            <td class="width-150">Pangkat (Gol)</td>
                            <td>' . $row->GOLONGAN_PANGKAT . '</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="col-md-6">
                <div class="m-b-5">
                    <div class="f-s-13"><b>Data Skep Pensiun</b></div>
                </div>

                <table class="' . $style_table . '">
                    <tbody>
                        <tr>
                            <td class="width-150">Skep Pensiun</td>
                            <td>' . $row->NO_SKEP . '</td>
                        </tr>
                        <tr>
                            <td class="width-150">Tanggal Skep</td>
                            <td>' . format_date_indo_v2($row->TANGGAL_SKEP) . '</td>
                        </tr>
                        <tr>
                            <td class="width-150">Tanggal TMT Pensiun</td>
                            <td>' . format_date_indo_v2($row->TANGGAL_TMT_PENSIUN) . '</td>
                        </tr>
                        <tr>
                            <td class="width-150">Tanggal Bupen</td>
                            <td>' . format_date_indo_v2($row->TANGGAL_BUPEN) . '</td>
                        </tr>
                    </tbody>
                </table>

                <div class="m-b-5">
                    <div class="f-s-13"><b>Data Kantor Bayar</b></div>
                </div>

                <table class="' . $style_table . '">
                    <tbody>
                        <tr>
                            <td class="width-150">Kantor Bayar Sebelum</td>
                            <td>' . $row->KANTORBAYAR_SEBELUM . '</td>
                        </tr>
                        <tr>
                            <td class="width-150">Kantor Bayar Tujuan (POS)</td>
                            <td>(' . $row->KODE_KPC . ') ' . $row->NAMA_KPC . '</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="m-b-10">
            <div class="f-s-13"><b>Data Gaji Pensiun Bulanan</b></div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <table class="' . $style_table . '">
                    <tbody>
                        <tr class="bg-grey-transparent-1">
                            <td class="text-left" colspan="2"><b>Rincian Pendapatan</b></td>
                        </tr>
                        <tr>
                            <td class="text-left">Pokok Pensiun</td>
                            <td class="text-right" style="width: 150px;">' . number_format($row->PD_POKOK_PENSIUN) . '</td>
                        </tr>
                        <tr>
                            <td class="text-left">Tunjangan Istri</td>
                            <td class="text-right" style="width: 150px;">' . number_format($row->PD_TUN_ISTRI) . '</td>
                        </tr>
                        <tr>
                            <td class="text-left">Tunjangan Anak</td>
                            <td class="text-right" style="width: 150px;">' . number_format($row->PD_TUN_ANAK) . '</td>
                        </tr>
                        <tr>
                            <td class="text-left">Tunjangan Dahor</td>
                            <td class="text-right" style="width: 150px;">' . number_format($row->PD_TUN_DAHOR) . '</td>
                        </tr>
                        <tr>
                            <td class="text-left">Tunjangan Beras</td>
                            <td class="text-right" style="width: 150px;">' . number_format($row->PD_TUN_BERAS) . '</td>
                        </tr>
                        <tr>
                            <td class="text-left">Tunjangan Cacat</td>
                            <td class="text-right" style="width: 150px;">' . number_format($row->PD_TUN_CACAT) . '</td>
                        </tr>
                        <tr>
                            <td class="text-left">Pph Pasal 21</td>
                            <td class="text-right" style="width: 150px;">' . number_format($row->PD_TUN_PPH21) . '</td>
                        </tr>
                        <tr>
                            <td class="text-left">TPP</td>
                            <td class="text-right" style="width: 150px;">' . number_format($row->PD_TPP) . '</td>
                        </tr>
                        <tr>
                            <td class="text-left">TPM</td>
                            <td class="text-right" style="width: 150px;">' . number_format($row->PD_TPM) . '</td>
                        </tr>
                        <tr>
                            <td class="text-left">TKD</td>
                            <td class="text-right" style="width: 150px;">' . number_format($row->PD_TKD) . '</td>
                        </tr>
                        <tr>
                            <td class="text-left">Pembulatan</td>
                            <td class="text-right" style="width: 150px;">' . number_format($row->PD_PEMBULATAN) . '</td>
                        </tr>
                        <tr class="bg-grey-transparent-1">
                            <td class="text-left"><b>Jumlah Pendapatan <small>(A)</small></b></td>
                            <td class="text-right" style="width: 150px;"><b>' . number_format($row->PD_JUMLAH) . '</b></td>
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
                            <td class="text-left">Pph Pasal 21</td>
                            <td class="text-right" style="width: 150px;">' . number_format($row->PO_PPH21) . '</td>
                        </tr>
                        <tr>
                            <td class="text-left">Askes</td>
                            <td class="text-right" style="width: 150px;">' . number_format($row->PO_ASKSES) . '</td>
                        </tr>
                        <tr>
                            <td class="text-left">KPKN</td>
                            <td class="text-right" style="width: 150px;">' . number_format($row->PO_KPKN) . '</td>
                        </tr>
                        <tr>
                            <td class="text-left">Assos</td>
                            <td class="text-right" style="width: 150px;">' . number_format($row->PO_ASSOS) . '</td>
                        </tr>
                        <tr>
                            <td class="text-left">Kasda</td>
                            <td class="text-right" style="width: 150px;">' . number_format($row->PO_KASDA) . '</td>
                        </tr>
                        <tr>
                            <td class="text-left">Alimentasi</td>
                            <td class="text-right" style="width: 150px;">' . number_format($row->PO_ALIMENTASI) . '</td>
                        </tr>
                        <tr>
                            <td class="text-left">Sewa Rumah</td>
                            <td class="text-right" style="width: 150px;">' . number_format($row->PO_SEWARUMAH) . '</td>
                        </tr>
                        <tr>
                            <td class="text-left">Ganti Rugi</td>
                            <td class="text-right" style="width: 150px;">' . number_format($row->PO_GANTIRUGI) . '</td>
                        </tr>
                        <tr class="bg-grey-transparent-1">
                            <td class="text-left"><b>Jumlah Potongan <small>(B)</small></b></td>
                            <td class="text-right" style="width: 150px;"><b>' . number_format($row->PO_JUMLAH) . '</b></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="col-md-4">
                <table class="' . $style_table . '">
                    <tbody>
                        <tr class="bg-grey-transparent-1">
                            <td class="text-left" colspan="2"><b>Terima Besih</b></td>
                        </tr>
                        <tr>
                            <td class="text-left">Pendapatan</td>
                            <td class="text-right" style="width: 150px;">' . number_format($row->PD_JUMLAH) . '</td>
                        </tr>
                        <tr>
                            <td class="text-left">Potongan</td>
                            <td class="text-right" style="width: 150px;">' . number_format($row->PO_JUMLAH) . '</td>
                        </tr>
                        <tr class="bg-grey-transparent-1">
                            <td class="text-left"><b>Jumlah Bersih <small>(A) - (B)</small></b></td>
                            <td class="text-right" style="width: 150px;"><b>' . number_format($row->PO_TOTALBERSIH) . '</b></td>
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
if (!function_exists('info_simulasi_pembiayaan')) {
    function info_simulasi_pembiayaan($pinjamanId, $style_table = 'table table-condensed')
    {
        // Initial
        $_CI = &get_instance();

        // query
        $_CI->db->select("*");
        $_CI->db->from("vw_pinjaman");
        $_CI->db->where("ID_PINJAMAN", $pinjamanId);

        // Output
        $row = $_CI->db->get()->row_array();


        // Cek Jenis Rate
        if ($row['JENIS_BUNGA'] == 'EFFEKTIF') {
            $jenis_rate = $row['BUNGA_EFF_KOP'] . ' (%)';
        } else {
            $jenis_rate = (number_format($row['BUNGA_FLAT'] * 100, 2)) . ' (%)';
        }

        // Cek Fee Marketing
        $nomFeeMarketing = $row['PLAFOND'] * $row['IS_FEE'];

        // Hitung Asuransi
        $nomAssEnduser = $row['NOMINAL_BY_ASS_KOP'] - $nomFeeMarketing;
        $nomFlaging = $row['NOMINAL_BY_FLAG'];
        $nomBpp = $row['NOMINAL_BPP'];
        $nomLainnya = $row['NOMINAL_BY_LAINNYA'];
        $injectAsuransi = $nomAssEnduser + $nomFlaging + $nomLainnya;

        // Hitung Jumlah Biaya Potongan
        $byPotongan = $injectAsuransi + $nomFeeMarketing + $row['NOMINAL_BY_ADM'] + $row['NOMINAL_BY_TATALAKASAN'] + $row['NOMINAL_BY_PROVISI'] + $row['NOMINAL_BY_MUTASI'] + $row['NOMINAL_BY_BUKA_REKENING'] + $row['NOMINAL_POT_UM'] + $row['NOMINAL_RETENSI'];

        // Hitung terima kotor
        $terimaKotor = $row['PLAFOND'] - $byPotongan;

        // Hitung terima bersih
        $terimaBersih = $terimaKotor - $row['NOMINAL_PELUNASAN'] - $row['NOMINAL_BPP'];

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
							<td class="text-left" colspan="3"><b>Informasi pembiayaan</b></td>
						</tr>
						<tr>
							<td class="text-left" style="width: 150px;">Gaji Bersih</td>
							<td class="text-center" style="width: 10px;">:</td>
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
							<td class="text-left">Sisa Gaji</td>
							<td class="text-center">:</td>
							<td class="text-right">
								<div class="pull-right">' . number_format($row['PD_POKOK_PENSIUN'] - $row['ANGSURAN_KOP']) . '</div>
							</td>
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
						<tr class="bg-grey-transparent-1">
							<td class="text-left"><b>Mitra Take Over</b></td>
							<td class="text-center">:</td>
							<td class="text-right">
								<div class="pull-right">' . $row['NAMA_MITRA'] . '</div>
							</td>
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
							<td class="text-left">Nominal BPP</td>
							<td class="text-center">:</td>
							<td class="text-right">' . number_format($row['NOMINAL_BPP']) . '</td>
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
                            <td class="text-right">
                                <span class="pull-left">
                                    ' . ($row['NOMINAL_RETENSI'] == 0 ? '(0)' : '(1)') . '
                                </span>
                                ' . number_format($row['NOMINAL_RETENSI'], 0, ',', '.') . '
                            </td>
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

        <div class="m-b-5">
            <div class="f-s-13"><b>Data Analisa Pembiayaan</b></div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <table class="' . $style_table . '">
					<tbody>
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
							<td class="text-left" colspan="3"><b>Analisa Ratio (DSR/DBR)</b></td>
						</tr>
						<tr>
							<td class="text-left" style="width: 150px;">Max Ratio</td>
							<td class="text-center" style="width: 10px;">:</td>
							<td class="text-right"> <span class="pull-left">(' . calculate_ratio_angsuran($row['MAX_ANGSURAN'], $row['PO_TOTALBERSIH']) . ')</span> ' . number_format($row['MAX_ANGSURAN']) . ' </td>
						</tr>
						<tr>
							<td class="text-left" style="width: 150px;">Ratio Terpakai</td>
							<td class="text-center" style="width: 10px;">:</td>
							<td class="text-right"> <span class="pull-left">(' . calculate_ratio_angsuran($row['ANGSURAN_KOP'], $row['PO_TOTALBERSIH']) . ')</span> ' . number_format($row['ANGSURAN_KOP']) . ' </td>
						</tr>
                        <tr>
							<td class="text-left" style="width: 150px;">Sisa Ratio</td>
							<td class="text-center" style="width: 10px;">:</td>
							<td class="text-right"> <span class="pull-left">(' . calculate_ratio_angsuran($row['MAX_ANGSURAN'] - $row['ANGSURAN_KOP'], $row['PO_TOTALBERSIH']) . ')</span> ' . number_format($row['MAX_ANGSURAN'] - $row['ANGSURAN_KOP']) . ' </td>
						</tr>
					</tbody>
				</table>
            </div>
		</div>
        ';

        return $html;
    }
}

// Component info Mutasi Account Droping
if (!function_exists('info_mutasi_droping_pencairan')) {
    function info_mutasi_droping_pencairan($accnumber = NULL, $style_table = 'table table-condensed table-bordered')
    {
        // insialiasi
        $_ci = &get_instance();

        // get pad accnumber by id pinjaman
        $accnumber = str_pad($accnumber, 8, "0", STR_PAD_LEFT);

        // get data account droping
        $getacc = $_ci->db->query("SELECT accnumber, noreg, tglpengajuan, namaktp, plafond, nom_bpp, nom_mutasi, nom_feemarketing, jmlpotongan, jmlterimakotor  FROM vw_droping_account WHERE accnumber = '{$accnumber}'")->row_array();

        // get data transaksi droping pencairan
        $_ci->db->where("accnumber", $accnumber);
        $_ci->db->order_by("tgltransaksi", "ASC");
        $trx_droping = $_ci->db->get('vw_droping_transaksi_pencairan')->result_array();

        $saldoAwalTerimaKotor = $getacc['plafond'] - $getacc['jmlpotongan'] - $getacc['nom_bpp'] - $getacc['nom_mutasi'];

        // Transaksi Mutasi Rekening Droping Pencairan ke Debitur
        $output = '';
        $output .= '<div>';
        $output .= '<table class="' . $style_table . '">';
        $output .= '	<tr class="bg-silver">
							<th class="text-center width-100">Tanggal</th>
							<th class="text-left">Keterangan</th>
							<th class="text-right width-150">(Db) Debet</th>
							<th class="text-right width-150">(Cr) Kredit</th>
							<th class="text-right width-150">Sisa Pencairan</th>
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

// Component info History data pengajuan pinjaman
if (!function_exists('info_list_history_pinjaman')) {
    function info_list_history_pinjaman($where_id = [], $style_table = 'table table-condensed table-bordered')
    {
        // Jika tidak ada data, tampilkan pesan
        if (empty($where_id)) {
            return '<div class="alert alert-warning">Tidak ada data pinjaman yang tersedia.</div>';
        }

        $_CI = &get_instance();

        // query
        $_CI->db->select("ID_DEBITUR, ID_PINJAMAN, TANGGAL_PENGAJUAN_DT, NIK_KTP, NO_PENSIUN, NO_REGISTRASI, NO_KREDIT, NAMA_DEBITUR, PRODUK, NAMA_JENIS_BIAYA, PLAFOND, TENOR, STATUS_LUNAS, STATUS_PINJAMAN");
        $_CI->db->from("vw_pinjaman");
        $_CI->db->where($where_id);

        // Output
        $result = $_CI->db->get()->result();

        // Awal tabel
        $html = '
        <div class="table-responsive">
            <table class="' . $style_table . '">
                <thead>
                    <tr class="bg-silver">
                        <th class="text-left">Tgl Pengajuan</th>
                        <th class="text-left">No Registrasi</th>
                        <th class="text-left">No NIK</th>
                        <th class="text-left">Nama Debitur</th>
                        <th class="text-left">Jenis Biaya</th>
                        <th class="text-right">Plafond</th>
                        <th class="text-left">Tenor</th>
                        <th class="text-left">Status Pinjaman</th>
                    </tr>
                </thead>
                <tbody>';

        // Iterasi data pinjaman
        foreach ($result as $data) {

            $html .= '
            <tr>
                <td class="text-left">' . $data->TANGGAL_PENGAJUAN_DT . '</td>
                <td class="text-left">' . $data->NO_REGISTRASI . '</td>
                <td class="text-left">' . $data->NIK_KTP . '</td>
                <td class="text-left">' . $data->NAMA_DEBITUR . '</td>
                <td class="text-left">' . $data->NAMA_JENIS_BIAYA . '</td>
                <td class="text-right">' . number_format($data->PLAFOND) . '</td>
                <td class="text-left">' . number_format($data->TENOR) . ' Bulan</td>
                <td class="text-left">' . $data->STATUS_PINJAMAN . '</td>
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

// Component info History data pengajuan slik
if (!function_exists('info_list_history_slik')) {
    function info_list_history_slik($where_id = [], $style_table = 'table table-condensed table-bordered')
    {
        // Jika tidak ada data, tampilkan pesan
        if (empty($where_id)) {
            return '<div class="alert alert-warning">Tidak ada data pinjaman yang tersedia.</div>';
        }

        $_CI = &get_instance();

        // query select data ke table slik
        $_CI->db->select("*");
        $_CI->db->from("los_slik");
        $_CI->db->where($where_id);

        // Output
        $result = $_CI->db->get()->result();

        // Awal tabel
        $html = '
        <div class="table-responsive">
            <table class="' . $style_table . '">
                <thead>
                    <tr class="bg-silver">
                        <th class="text-left width-200">Tanggal</th>
                        <th class="text-left width-200">No Identitas</th>
                        <th class="text-left width-200">Pemohon</th>
                        <th class="text-left width-200">Bank Sumberdana</th>
                    </tr>
                </thead>
                <tbody>';

        // Iterasi data pinjaman
        foreach ($result as $data) {

            // Cek status komentar slik
            if ($data->SLIK_STATUS == 'Y') {
                $slik_user = $data->SLIK_USER;
                $slik_update = $data->SLIK_UPDATE_AT;
                $slik_komentar = $data->SLIK_KOMENTAR;
            } else {
                $slik_user = ' - ';
                $slik_update = ' - ';
                $slik_komentar = 'Pending, Belum ada informasi hasil SLIK dari Bank Sumberdana.';
            }

            $html .= '
            <tr>
                <td colspan="4" class="bg-yellow-transparent-1">
                    <b>Hasil Pemeriksaan SLIK/IDEB Periode ' . date('Ym', strtotime($data->TANGGAL_INPUT)) . '</b>
                </td>
            </tr>
            <tr>
                <td class="text-left">
                    <div><small><b>Periode</b></small></div>
                    <div class="m-b-5">' . date('Ym', strtotime($data->TANGGAL_INPUT)) . '</div>
                    <div><small><b>Tgl Pengajuan</b></small></div>
                    <div>' . $data->TANGGAL_INPUT . '</div>
                </td>
                <td class="text-left">
                    <div><small><b>Nomor NIK</b></small></div>
                    <div class="m-b-5">' . $data->NIK . '</div>
                </td>
                <td class="text-left">
                    <div><small><b>Nama Pemohon</b></small></div>
                    <div class="m-b-5">' . $data->NAMA . '</div>
                    <div><small><b>Kantor Cabang</b></small></div>
                    <div>' . get_info_cabang($data->KODE_CABANG)['DESKRIPSI_CABANG'] . '</div>
                </td>
                <td class="text-left">
                    <div><small><b>Nama Bank Sumberdana</b></small></div>
                    <div class="m-b-5">' . get_info_sumberdana($data->ID_SUMBERDANA)['NAMA_SUMBERDANA'] . '</div>
                    <div><small><b>Kode Slik</b></small></div>
                    <div>' . $data->NO_INV . '</div>
                </td>
            </tr>
            <tr>
               <td colspan="4" class="text-left">
                    <div><small><b>User Updated</b></small></div>
                    <div class="m-b-5">' . $slik_user . ' ' . $slik_update . '</div>
                    <div><small><b>Komentar SLIK</b></small></div>
                    <div>' . $slik_komentar . '</div>
                </td>
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

// Component info History data pengajuan pembiayaan
if (!function_exists('info_list_history_pembiayaan')) {
    function info_list_history_pembiayaan($where_id = [], $style_table = 'table table-condensed table-bordered')
    {
        // Jika tidak ada data, tampilkan pesan
        if (empty($where_id)) {
            return '<div class="alert alert-warning">Tidak ada data pinjaman yang tersedia.</div>';
        }

        $_CI = &get_instance();

        // query select data slik
        $_CI->db->select("*");
        $_CI->db->from("vw_pinjaman");
        $_CI->db->where($where_id);

        // Output
        $result = $_CI->db->get()->result();

        // Awal tabel
        $html = '
         <div class="table-responsive">
             <table class="' . $style_table . '">
                 <thead>
                     <tr class="bg-silver">
                         <th class="text-left width-200">Tanggal</th>
                         <th class="text-left width-200">No Identitas</th>
                         <th class="text-left width-200">Pemohon</th>
                         <th class="text-left width-200">Bank Sumberdana</th>
                         <th class="text-left">Hasil Approval</th>
                     </tr>
                 </thead>
                 <tbody>';

        // Iterasi data pinjaman
        foreach ($result as $data) {
            $html .= '
             <tr>
                 <td class="text-left">
                     <div><small><b>Periode</b></small></div>
                     <div class="m-b-5">' . date('Ym', strtotime($data->TANGGAL_PENGAJUAN_DT)) . '</div>
                     <div><small><b>Tgl Pengajuan</b></small></div>
                     <div>' . $data->TANGGAL_PENGAJUAN_DT . '</div>
                 </td>
                 <td class="text-left">
                     <div><small><b>Nomor NIK</b></small></div>
                     <div class="m-b-5">' . $data->NIK_KTP . '</div>
                 </td>
                 <td class="text-left">
                     <div><small><b>Nama Pemohon</b></small></div>
                     <div class="m-b-5">' . $data->NAMA_DEBITUR . '</div>
                     <div><small><b>Kantor Cabang</b></small></div>
                     <div>' . get_info_cabang($data->KODE_CABANG)['DESKRIPSI_CABANG'] . '</div>
                 </td>
                 <td class="text-left">
                     <div><small><b>Nama Bank Sumberdana</b></small></div>
                     <div class="m-b-5">' . get_info_sumberdana($data->ID_SUMBERDANA)['NAMA_SUMBERDANA'] . '</div>
                     <div><small><b>No Registrasi</b></small></div>
                     <div>' . $data->NO_REGISTRASI . '</div>
                 </td>
                 <td class="text-left">
                     <div><small><b>User Updated</b></small></div>
                     <div class="m-b-5">' . get_fullname_user($data->BANK_ID_USER) . ' ' . $data->BANK_UPDATE_AT . '</div>
                     <div><small><b>Komentar Approval</b></small></div>
                     <div class="' . ($data->STATUS_REJECT === 'Y' ? 'text-danger' : '') . '">' . ($data->STATUS_REJECT === 'Y' ? $data->BANK_KOMENTAR : '') .
                '</div>
                </td>
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

// Component info History data pengajuan slik
if (!function_exists('info_list_history_verifikasi')) {
    function info_list_history_verifikasi($where_id = [], $style_table = 'table table-condensed table-bordered')
    {
        // Jika tidak ada data, tampilkan pesan
        if (empty($where_id)) {
            return '<div class="alert alert-warning">Tidak ada data pinjaman yang tersedia.</div>';
        }

        $_CI = &get_instance();

        // query select data slik
        $_CI->db->select("*");
        $_CI->db->from("vw_pinjaman");
        $_CI->db->where($where_id);

        // Output
        $result = $_CI->db->get()->result();

        // Awal tabel
        $html = '
        <div class="table-responsive">
            <table class="' . $style_table . '">
                <thead>
                    <tr class="bg-silver">
                        <th class="text-left width-200">Tanggal</th>
                        <th class="text-left width-200">No Identitas</th>
                        <th class="text-left width-200">Pemohon</th>
                        <th class="text-left width-200">Bank Sumberdana</th>
                    </tr>
                </thead>
                <tbody>';

        // Iterasi data pinjaman
        foreach ($result as $data) {
            $html .= '
            <tr>
                <td class="text-left">
                    <div><small><b>Periode</b></small></div>
                    <div class="m-b-5">' . date('Ym', strtotime($data->TANGGAL_PENGAJUAN_DT)) . '</div>
                    <div><small><b>Tgl Pengajuan</b></small></div>
                    <div>' . $data->TANGGAL_PENGAJUAN_DT . '</div>
                </td>
                <td class="text-left">
                    <div><small><b>Nomor NIK</b></small></div>
                    <div class="m-b-5">' . $data->NIK_KTP . '</div>
                </td>
                <td class="text-left">
                    <div><small><b>Nama Pemohon</b></small></div>
                    <div class="m-b-5">' . $data->NAMA_DEBITUR . '</div>
                    <div><small><b>Kantor Cabang</b></small></div>
                    <div>' . get_info_cabang($data->KODE_CABANG)['DESKRIPSI_CABANG'] . '</div>
                </td>
                <td class="text-left">
                    <div><small><b>Nama Bank Sumberdana</b></small></div>
                    <div class="m-b-5">' . get_info_sumberdana($data->ID_SUMBERDANA)['NAMA_SUMBERDANA'] . '</div>
                    <div><small><b>No Registrasi</b></small></div>
                    <div>' . $data->NO_REGISTRASI . '</div>
                </td>
            </tr>
            <tr>
                <td colspan="4" class="text-left">
                    <div><small><b>User Updated</b></small></div>
                    <div class="m-b-5">' . get_fullname_user($data->VRF_ID_USER) . ' ' . $data->VRF_UPDATE_AT . '</div>
                    <div><small><b>Komentar Verifikasi</b></small></div>
                    <div>' . (($data->VRF_KOMENTAR != NULL) ? $data->VRF_KOMENTAR : '<span class="text-red">Verifikasi belum mengisi komentar atau belum di review</span>') . '</div>
                </td>
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

// (Account Droping) Component info History data transaksi droping
if (!function_exists('info_transaksi_droping')) {
    function info_transaksi_droping($transaksi, $style_table = 'table table-condensed table-striped table-bordered text-nowrap f-s-11')
    {
        $CI = &get_instance();
        $CI->load->helper('number'); // Load number helper if not already loaded

        // Initialize variables
        $no = 1;
        $sumofnominal = 0;

        // Start building the table
        $output = '
                    <div class="m-b-5">
                        <div class="f-s-13"><b>Data Transaksi Droping</b></div>
                        <div class="f-s-11">Detail Informasi Data Transaksi Droping</div>
                    </div>

                <div class="table-responsive m-b-10">
                    <table class="' . $style_table . '">
                        <thead>
                            <tr class="bg-silver">
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

        // Close the table
        $output .= '</tbody>
                    </table>
                </div>';

        return $output;
    }
}

// (Account Droping) Component info (Mutasi Rekening) Detail transaksi droping
if (!function_exists('info_transaksi_mutasi_droping')) {
    function info_transaksi_mutasi_droping($account, $mutasi_saldo_droping, $style_table = 'table table-condensed table-striped table-bordered f-s-11')
    {
        $CI = &get_instance();
        $CI->load->helper('number'); // Load number helper if not already loaded

        // Initialize variables
        $no = 2;

        $terimaKotor = $account['plafond'] - $account['jmlpotongan'] - $account['nom_feemarketing'] - $account['nom_mutasi'];
        $saldoDroping = $terimaKotor;

        // Start building the table
        $output = '
                <div class="m-b-5">
                    <div class="f-s-13"><b>Data Rekening Droping</b></div>
                    <div class="f-s-11">Detail Informasi Rekening Transaksi Droping</div>
                </div>

                <div class="table-responsive m-b-10">
                    <table class="' . $style_table . '">
                        <thead>
                            <tr class="bg-silver">
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
                            <div><b>Plafond Pembiayaan</b></div>
                            <div>Uraian : Plafond Pengajuan Pembiayaan</div>
                        </td>
                        <td class="text-right">' . number_format($account['plafond']) . '</td>
                        <td class="text-right">' . number_format(0) . '</td>
                        <td class="text-right">' . number_format($account['plafond']) . '</td>
                    </tr>';
        $output .= '<tr>
                        <td class="text-center">1</td>
                        <td class="text-center">' . format_date_indo_v2($account['tglpengajuan']) . '</td>
                        <td class="text-left">
                            <div><b>Potongan Pembiayaan</b></div>
                            <div>Uraian : Total Biaya Potongan</div>
                        </td>
                        <td class="text-right">' . number_format(0) . '</td>
                        <td class="text-right">' . number_format($account['jmlpotongan'] + $account['nom_feemarketing'] + $account['nom_mutasi']) . '</td>
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
