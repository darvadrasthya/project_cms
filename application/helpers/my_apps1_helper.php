<?php

/**
 * MY_Apps1_helper.php
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

if (!function_exists('assets_version')) {
    /**
     * Generate a versioned URL for a CSS or JS file.
     *
     * @param string $filePath The path to the CSS or JS file relative to the 'assets' folder.
     * @return string The versioned URL.
     */
    function assets_version($filePath)
    {
        // Path relatif ke folder 'assets'
        $relativePath = 'assets/' . $filePath;

        if (file_exists($relativePath)) {
            $version = filemtime($relativePath); // Get the file modification timestamp
            $versionedUrl = base_url($relativePath) . '?v=' . $version; // Append version as a query string parameter
            return $versionedUrl;
        } else {
            return base_url($relativePath); // Jika file tidak ditemukan, kembalikan URL asli tanpa versi
        }
    }
}

if (!function_exists('is_logged')) {
    /**
     * Fungsi untuk memeriksa apakah pengguna sudah login atau belum.
     *
     * @return bool Mengembalikan nilai true jika pengguna sudah login, dan false jika belum.
     */
    function is_logged()
    {
        $CI = get_instance();
        return $CI->session->userdata('is_logged') !== null;
    }
}

if (!function_exists('restrict_access')) {
    /**
     * Fungsi untuk membatasi akses ke halaman tertentu.
     * Jika pengguna belum login, akan diarahkan ke halaman login.
     */
    function restrict_access()
    {
        if (!is_logged()) {
            redirect('auth');
        }
    }
}

if (!function_exists('grant_access')) {
    /**
     * Fungsi grant_access
     *
     * Fungsi ini digunakan untuk memeriksa apakah pengguna telah memiliki akses.
     * Jika pengguna sudah login, maka pengguna akan diarahkan ke halaman beranda.
     *
     * @return void
     */
    function grant_access()
    {
        $CI = get_instance();

        // Memeriksa apakah session isLoggedIn sudah ada
        if ($CI->session->userdata('is_logged') === TRUE) {
            // Mengarahkan pengguna ke halaman beranda
            redirect('home');
        }
    }
}

if (!function_exists('grant_access_level')) {
    /**
     * Fungsi grant_access_level
     *
     * Fungsi ini digunakan untuk memeriksa apakah pengguna telah memiliki akses.
     * Jika pengguna sudah login dan memiliki level akses yang sesuai,
     * maka pengguna akan diizinkan melanjutkan eksekusi. Jika tidak, pengguna
     * akan diarahkan ke halaman akses ditolak atau login.
     *
     * @param array $allowedLevels Daftar level pengguna yang diizinkan mengakses controller
     * @return void
     */
    function grant_access_level($allowedLevels = array())
    {
        $CI = get_instance();

        // Memeriksa apakah session isLoggedIn sudah ada
        if ($CI->session->userdata('isLoggedIn') === TRUE) {
            // Mendapatkan level user dari session
            $userLevel = $CI->session->userdata('level_user');

            // Memeriksa apakah level user termasuk dalam daftar level yang diizinkan
            if (!in_array($userLevel, $allowedLevels)) {
                // Mengarahkan pengguna ke halaman akses ditolak jika tidak memiliki akses
                show_error('Anda tidak memiliki akses untuk mengakses halaman ini', 403);
                exit; // Menghentikan eksekusi lebih lanjut
            }
        } else {
            // Mengarahkan pengguna ke halaman login jika belum login
            redirect('login');
            exit; // Menghentikan eksekusi lebih lanjut
        }
    }
}

if (!function_exists('activate_menu')) {
    /**
     * 2021-07-15 00:19:16
     * @package Active Link Menu
     * @link https://gist.github.com/sadanandkenganal/5f60461112b051dde5ab
     *
     * Fungsi ini digunakan untuk mengaktifkan menu berdasarkan controller.
     *
     * Cara Penggunaan:
     * echo activate_menu('nama_controller');
     * echo activate_menu(['controller1', 'controller2']);
     *
     * @param mixed $controller Nama controller atau array dari nama controller.
     * @return string Mengembalikan "active" jika controller sesuai, atau string kosong jika tidak sesuai.
     */
    function activate_menu($controller)
    {
        $CI = get_instance();
        $class = $CI->router->fetch_class();
        $is_active = FALSE;

        if (is_array($controller)) {
            foreach ($controller as $cont) {
                if ($cont == $class) {
                    $is_active = TRUE;
                }
            }
        } else {
            if ($controller == $class) {
                $is_active = TRUE;
            }
        }
        return ($is_active) ? "active" : "";
    }
}

if (!function_exists('flashdata_alert')) {
    /**
     * Fungsi untuk menampilkan flashdata alert.
     *
     * Cara Penggunaan:
     * flashdata_alert('Judul', 'Pesan alert', 'success');
     *
     * @param string $title Judul alert.
     * @param string $message Pesan alert.
     * @param string $alert Jenis alert (contoh: 'success', 'error').
     * @return bool Mengembalikan true jika flashdata alert diset, atau false jika tidak ada alert.
     */
    function flashdata_alert($title = '', $message = '', $alert = '')
    {
        $ci = get_instance();
        $alerts = $ci->session->set_flashdata(array('title' => $title, 'message' => $message, 'alert' => $alert));
        if ($alerts) {
            return $alerts;
        }
        return false;
    }
}

// Mengambil nilai 'setting_value' berdasarkan 'setting_key' dan 'setting_name' dari tabel 'app_settin g_system'.
if (!function_exists('getAppSetting')) {
    /**
     * Table Name: app_setting_system
     * Mengambil nilai 'setting_value' berdasarkan 'setting_key' dan 'setting_name' dari tabel 'app_setting_system'.
     *
     * @param string $settingName Kunci setting yang ingin dicari.
     * @param string $settingKey Kunci setting yang ingin dicari.
     * @return string|null Nilai 'setting_value' jika kunci setting ditemukan, atau null jika tidak ditemukan.
     */
    function getAppSetting($settingName, $settingKey)
    {
        $CI = &get_instance();

        $CI->db->where('setting_name', $settingName);
        $query = $CI->db->get('app_setting_system');

        if ($query->num_rows() === 0) {
            return null;
        }

        $data = $query->result_array();
        foreach ($data as $s_App) {
            if ($s_App['setting_key'] === $settingKey) {
                return $s_App['setting_value'];
            }
        }

        return null;
    }
}

// Mengambil nilai 'setting_value' berdasarkan 'setting_key' dan 'setting_name' dari tabel 'app_setting'.
if (!function_exists('getAppSettingAPI')) {
    /**
     * Table Name: app_setting
     * Mengambil nilai 'setting_value' berdasarkan 'setting_key' dan 'setting_name' dari tabel 'app_setting'.
     *
     * @param string $settingName Kunci setting yang ingin dicari.
     * @param string $settingKey Kunci setting yang ingin dicari.
     * @return string|null Nilai 'setting_value' jika kunci setting ditemukan, atau null jika tidak ditemukan.
     */
    function getAppSettingAPI($settingName, $settingKey)
    {
        $CI = &get_instance();

        $CI->db->where('setting_api_name', $settingName);
        $query = $CI->db->get('app_setting_api');

        if ($query->num_rows() === 0) {
            return null;
        }

        $data = $query->result_array();
        foreach ($data as $s_App) {
            if ($s_App['setting_key'] === $settingKey) {
                return $s_App['setting_value'];
            }
        }

        return null;
    }
}

// Mengambil nilai 'setting_value' berdasarkan 'setting_key' dan 'setting_name' dari tabel 'app_setting_system'.
if (!function_exists('updateAppSetting')) {
    /**
     * Table Name: app_setting_system
     * Mengambil nilai 'setting_value' berdasarkan 'setting_key' dan 'setting_name' dari tabel 'app_setting_system'.
     *
     * @param string $settingName Kunci setting yang ingin dicari.
     * @param string $settingKey Kunci setting yang ingin dicari.
     * @param string $newValue Nilai baru yang akan diupdate.
     * @return bool True jika update berhasil, false jika tidak.
     */
    function updateAppSetting($settingName, $settingKey, $newValue)
    {
        $CI = &get_instance();

        // Cari baris data yang sesuai dengan 'setting_name' dan 'setting_key'
        $CI->db->where('setting_name', $settingName);
        $CI->db->where('setting_key', $settingKey);
        $query = $CI->db->get('app_setting_system');

        if ($query->num_rows() === 0) {
            return false; // Data tidak ditemukan, update gagal
        }

        // Update nilai 'setting_value' dengan nilai baru
        $data = array('setting_value' => $newValue);
        $CI->db->where('setting_name', $settingName);
        $CI->db->where('setting_key', $settingKey);
        $CI->db->update('app_setting_system', $data);

        return true; // Update berhasil
    }
}

// Membuat teks dengan huruf pertama setiap kata menjadi huruf besar.
if (!function_exists('text_propper')) {
    /**
     * Membuat teks dengan huruf pertama setiap kata menjadi huruf besar.
     *
     * @param string $text Teks yang akan diproses.
     * @return string Teks dengan huruf pertama setiap kata menjadi huruf besar.
     */
    function text_propper($text)
    {
        // Pisahkan teks menjadi kata-kata
        $words = explode(' ', $text);

        // Inisialisasi array untuk menyimpan kata-kata yang telah diproses
        $processedWords = array();

        foreach ($words as $word) {
            // Konversi kata pertama menjadi huruf besar
            $processedWords[] = ucfirst(strtolower($word));
        }

        // Gabungkan kata-kata yang telah diproses dan kembalikan sebagai teks baru
        $processedText = implode(' ', $processedWords);
        return $processedText;
    }
}

if (!function_exists('format_no_tlp')) {
    function format_no_tlp($nomor_telepon, $hide = TRUE)
    {
        // Menghapus karakter selain angka
        $nomor_telepon = preg_replace('/[^0-9]/', '', $nomor_telepon);

        if (strlen($nomor_telepon) > 4) {
            // Jika nomor telepon dimulai dengan '62', ganti dengan '0'
            if (strpos($nomor_telepon, '62') === 0) {
                $nomor_telepon = '0' . substr($nomor_telepon, 2);
            }

            // Memisahkan nomor telepon setiap 4 digit dengan tanda '-'
            $nomor_telepon = implode('-', str_split($nomor_telepon, 4));

            if ($hide) {
                // Sensor nomor 4 digit terakhir
                $nomor_telepon = substr($nomor_telepon, 0, -4) . '<span class="text-red">****</span>';
            }
        }

        return $nomor_telepon;
    }
}

if (!function_exists('format_telepon')) {
    // Menubah format no telepon
    // 2023-10-18 18:58:48
    function format_telepon($telepon, $format = '')
    {
        // Menghilangkan karakter selain angka
        $telepon = preg_replace('/[^0-9]/', '', $telepon);

        if ($format == 'id') {
            // Mengubah karakter pertama menjadi '0'
            $telepon[0] = '0';
        } elseif ($format == 'en') {
            // Mengganti karakter pertama menjadi '62' dan karakter kedua dengan karakter asli
            $telepon[0] = '6';
        }

        return $telepon;
    }
}

if (!function_exists('save_date_to_db')) {
    /**
     * Convert multiple date formats to yyyy-mm-dd if valid.
     *
     * @param string $date Input date.
     * @return string|null yyyy-mm-dd format or null if invalid.
     */
    function save_date_to_db($date)
    {
        $formats = ['d/m/Y', 'd-m-Y', 'Y-m-d', 'Y/m/d'];

        foreach ($formats as $format) {
            $dt = DateTime::createFromFormat($format, $date);
            $errors = DateTime::getLastErrors();

            if ($dt && $errors['warning_count'] === 0 && $errors['error_count'] === 0) {
                return $dt->format('Y-m-d');
            }
        }

        return null;
    }
}

if (!function_exists('format_date_time')) {
    function format_date_time($date)
    {
        $getFormatDate = getAppSetting('app', 'app_format_datetime');
        return date($getFormatDate, strtotime($date));
    }
}

if (!function_exists('format_date')) {
    function format_date($date)
    {
        $getFormatDate = getAppSetting('app', 'app_format_date');
        return date($getFormatDate, strtotime($date));
    }
}

if (!function_exists('format_time')) {
    function format_time($date)
    {
        $getFormatDate = getAppSetting('app', 'app_format_time');
        return date($getFormatDate, strtotime($date));
    }
}

if (!function_exists('format_date_custom')) {
    function format_date_custom($date, $format = 'Y-m-d')
    {
        return date($format, strtotime($date));
    }
}

if (!function_exists('generate_kode_id_bydate')) {
    /**
     * Menghasilkan kode pengajuan berdasarkan ID dan tanggal.
     *
     * Fungsi ini menggabungkan tanggal dalam format 'yymmdd'
     * dengan ID yang diformat menjadi 4 digit, dipisahkan oleh tanda hubung.
     *
     * @param int|null $Id ID pengajuan yang akan digunakan.
     * @param string|null $date Tanggal yang akan digunakan untuk menghasilkan kode.
     * @return string Kode pengajuan yang dihasilkan.
     */
    function generate_kode_id_bydate($Id = NULL, $date = NULL)
    {
        return date('ymd', strtotime($date)) . '-' . str_pad($Id, 4, '0', STR_PAD_LEFT);
    }
}

if (!function_exists('generate_gravatar_image')) {
    function generate_gravatar_image($email, $size = 80)
    {
        $email = strtolower(trim($email));
        $hash = md5($email);
        return "https://www.gravatar.com/avatar/{$hash}";
    }
}

if (!function_exists('remove_formating')) {
    /**
     * Implementasi fungsi remove_formating().
     *
     * Contoh penggunaan:
     *
     * // Contoh 1: Menghapus karakter koma (,) dan titik (.) dari nilai
     * $inputValue = '10,000.50';
     * $removedValue = remove_formating($inputValue);
     * echo "Nilai setelah dihapus format: " . $removedValue;
     *
     * // Contoh 2: Menghapus karakter persentase (%) dari nilai
     * $inputValue = '50%';
     * $removedValueWithPercentage = remove_formating($inputValue, array('%'));
     * echo "Nilai setelah dihapus karakter '%': " . $removedValueWithPercentage;
     *
     * @param string $value Nilai yang akan diproses
     * @param array $characters Array karakter yang ingin dihapus (opsional)
     * @return string Nilai tanpa karakter yang dihapus
     */
    function remove_formating($value, $characters = array(',', '.'))
    {
        return str_replace($characters, '', $value);
    }
}

if (!function_exists('generate_auto_code')) {
    /**
     * Fungsi untuk menghasilkan kode otomatis berdasarkan format tertentu.
     *
     * @param string $paramsID Prefix kode (misalnya: "INV", "USR").
     * @param int $trim Panjang digit angka di akhir kode.
     * @param string $field Nama kolom yang digunakan untuk mengambil data kode.
     * @param string $table Nama tabel database yang akan dicek.
     * @param array|null $where Kondisi tambahan untuk filter query (opsional).
     *
     * @return string Kode yang dihasilkan (misalnya: "INV001", "USR002").
     *
     * Contoh penggunaan:
     * generate_auto_code('INV', 3, 'kode_transaksi', 'transaksi', ['status' => 'active']);
     */
    function generate_auto_code($paramsID = '', $trim, $field, $table, $where = null)
    {
        // Dapatkan instance CodeIgniter
        $ci = &get_instance();

        // Pilih bagian akhir dari field yang akan dijadikan basis kode
        $ci->db->select('RIGHT(' . $field . ', ' . $trim . ') AS KODE', FALSE);

        // Tambahkan kondisi where jika diberikan
        if (!empty($where)) {
            $ci->db->where($where);
        }

        // Urutkan kode secara descending untuk mengambil kode terbesar
        $ci->db->order_by('KODE', 'DESC');
        $ci->db->limit(1);

        // Eksekusi query untuk mendapatkan data terakhir
        $query = $ci->db->get($table);

        // Tentukan kode baru berdasarkan hasil query
        if ($query->num_rows() > 0) {
            // Jika kode sudah ada, tingkatkan nilainya
            $data = $query->row();
            $kode = intval($data->KODE) + 1;
        } else {
            // Jika kode belum ada, mulai dari 1
            $kode = 1;
        }

        // Format kode baru dengan padding angka nol di depan
        $batas = str_pad($kode, $trim, "0", STR_PAD_LEFT);

        // Gabungkan prefix dengan kode angka
        $result = $paramsID . $batas;

        // Kembalikan kode yang dihasilkan
        return $result;
    }
}

if (!function_exists('decimal_to_percentage')) {
    /**
     * Mengkonversi nilai desimal menjadi persentase.
     *
     * @param float $decimalValue Nilai desimal yang akan dikonversi.
     * @param int $precision Jumlah digit desimal yang diinginkan dalam hasil persentase.
     * @return string Nilai persentase yang diformat.
     */
    function decimal_to_percentage($decimalValue, $precision = 2)
    {
        if (!is_numeric($decimalValue)) {
            return '0.00%'; // Nilai default jika input bukan angka.
        }

        // Mengkonversi nilai desimal menjadi persentase dengan mengalikan dengan 100.
        $percentValue = $decimalValue * 100;

        // Memformat hasil dengan jumlah digit desimal yang diinginkan dan tanda persen.
        $formattedPercent = number_format($percentValue, $precision) . ' %';

        return $formattedPercent;
    }
}

if (!function_exists('percentage_to_decimal')) {
    /**
     * Mengkonversi nilai persentase menjadi desimal.
     *
     * @param string $percentageValue Nilai persentase yang akan dikonversi.
     * @return float Nilai desimal hasil konversi.
     */
    function percentage_to_decimal($percentageValue)
    {
        // Menghapus spasi dan simbol persen dari input
        $cleanValue = str_replace([' ', '%'], '', $percentageValue);

        // Memastikan nilai setelah pembersihan adalah angka
        if (!is_numeric($cleanValue)) {
            return 0.0; // Nilai default jika input tidak valid
        }

        // Mengonversi nilai menjadi desimal dengan membagi dengan 100
        $decimalValue = $cleanValue / 100;

        return (float)$decimalValue;
    }
}

if (!function_exists('convert_local_to_E164_format')) {
    /**
     * Mengonversi nomor telepon lokal Indonesia ke format internasional (E.164).
     *
     * @param string $number Nomor telepon dalam format lokal (misalnya: 081234567890).
     * @return string Nomor telepon dalam format internasional (misalnya: 6281234567890).
     */
    function convert_local_to_E164_format($number)
    {
        // Menghapus karakter non-digit
        $number = preg_replace('/\D/', '', $number);

        // Jika nomor dimulai dengan 0, gantikan dengan kode negara 62
        if (strpos($number, '0') === 0) {
            $number = '62' . substr($number, 1);
        }

        return $number;
    }
}

if (!function_exists('convert_E164_to_local_format')) {
    /**
     * Mengonversi nomor telepon dari format internasional (E.164) ke format lokal Indonesia.
     *
     * @param string $number Nomor telepon dalam format internasional (misalnya: 6281234567890).
     * @return string Nomor telepon dalam format lokal Indonesia (misalnya: 081234567890).
     */
    function convert_E164_to_local_format($number)
    {
        // Menghapus karakter non-digit
        $number = preg_replace('/\D/', '', $number);

        // Jika nomor dimulai dengan kode negara 62, ganti dengan 0
        if (strpos($number, '62') === 0) {
            $number = '0' . substr($number, 2);
        }

        return $number;
    }
}

if (!function_exists('label_is_active')) {
    function label_is_active($str)
    {
        // Menggunakan ekspresi reguler untuk hanya mengambil huruf dan angka
        $result = ($str == '1') ? "Aktif" : "Tidak Aktif";
        return $result;
    }
}

if (!function_exists('send_fonnte_message')) {
    /**
     * Send message to one or multiple targets using Fonnte API
     *
     * @param array|string $targets Array of target numbers or a single target number
     * @param string $message The message to send
     * @param string $countryCode (optional) Country code, default is '62'
     * @param int $delay (optional) Delay between messages, default is 5
     * @return mixed The response from the API or false on failure
     */
    function send_fonnte_message($targets, $message, $countryCode = '62')
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => getAppSettingAPI('fonnte', 'base_url_api'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => $targets,
                'message' => $message,
                'delay' => 5,
                'countryCode' => $countryCode
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . getAppSettingAPI('fonnte', 'token_key')
            ),
        ));

        $response = curl_exec($curl);
        $error_msg = null;

        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
        }
        curl_close($curl);

        if ($error_msg) {
            return array('error' => $error_msg);
        }

        return json_decode($response, true);
    }
}

if (!function_exists('get_row_data')) {
    /**
     * Ambil data dari tabel dan kembalikan sebagai row_array
     *
     * @param string $table Nama tabel
     * @param array $where Kondisi where dalam format array
     * @param array $select Kolom yang ingin diambil
     * @return array Hasil query sebagai row_array
     * @used $user_data = get_row_data($table, $where, $select);
     */
    function get_row_data($table, $where = [], $select = ['*'])
    {
        $CI = &get_instance();
        $CI->load->database();

        // Tentukan kolom yang ingin diambil
        $CI->db->select($select);

        // Tentukan tabel dan kondisi where
        $CI->db->where($where);
        $query = $CI->db->get($table);

        // Kembalikan hasil query sebagai row_array
        return $query->row_array();
    }
}

if (!function_exists('calculate_sla')) {
    /**
     * Menghitung durasi SLA antara dua tanggal dan mengembalikannya dalam format Hari, Jam, Menit, Detik
     *
     * @param string $start_date Tanggal mulai (tanggal pengajuan)
     * @param string $end_date Tanggal akhir (tanggal cair)
     * @return string Durasi dalam format Hari, Jam, Menit, Detik
     */
    function calculate_sla($start_date, $end_date)
    {
        // Mengubah tanggal menjadi objek DateTime
        $start = new DateTime($start_date);
        $end = new DateTime($end_date);

        // Menghitung perbedaan antara dua tanggal
        $interval = $start->diff($end);

        // Mengembalikan durasi dalam format Hari, Jam, Menit, Detik
        return sprintf(
            '%d Hari, %d Jam, %d Menit, %d Detik',
            $interval->days,
            $interval->h,
            $interval->i,
            $interval->s
        );
    }
}

// Generate message for whatsapp
if (!function_exists('format_whatsapp_message')) {
    /**
     * Membentuk pesan WhatsApp dengan newline (\n) atau double newline (\n\n) untuk breakline
     *
     * @param array $lines Array dari setiap baris pesan
     * @param bool $doubleNewline Gunakan double newline jika true
     * @return string Pesan yang dibentuk dengan newline atau double newline
     */
    function format_whatsapp_message($lines = [], $doubleNewline = false)
    {
        $separator = $doubleNewline ? "\n\n" : "\n";
        return implode($separator, $lines);
    }
}

// Bersihkan input dari karakter berbahaya
if (!function_exists('sanitize_input')) {
    function sanitize_input($input)
    {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
        $input = strip_tags($input);

        // Gunakan xss_clean bawaan CodeIgniter untuk tambahan keamanan
        $CI = &get_instance();
        $input = $CI->security->xss_clean($input);

        return $input;
    }
}

// Setting params if null
if (!function_exists('set_if_null')) {
    function set_if_null($input)
    {
        return (!isset($input) || trim($input) === '') ? NULL : $input;
    }
}

// Fungsi untuk mencatat log aktivitas login
if (!function_exists('create_log_login')) {
    /**
     * Fungsi untuk mencatat log aktivitas login ke tabel `los_log_login`.
     *
     * @param string $tipe Tipe aktivitas login (misalnya: "LOGIN_SUCCESS", "LOGIN_FAILED").
     * @param string $str Deskripsi tambahan untuk log.
     *
     * Contoh penggunaan:
     * create_log_login("LOGIN_SUCCESS", "Pengguna berhasil login.");
     */
    function create_log_login($tipe = "", $str = "")
    {
        // Dapatkan instance CodeIgniter
        $CI = &get_instance();

        // Tentukan browser/agent pengguna
        $agent = $CI->agent->is_browser() ? $CI->agent->browser() . ' ' . $CI->agent->version() : ($CI->agent->is_mobile() ? $CI->agent->mobile() : 'Undefined');

        // Ambil ID_LOGIN dari session
        $id_login = strtoupper($CI->session->userdata('sess_id_login') ?? '');

        // Tentukan NAMA_USER berdasarkan ID_LOGIN
        $nama_user = ($id_login === '0' || empty($id_login)) ? NULL : strtoupper($CI->session->userdata('sess_nama_user') ?? '');

        // Persiapkan data untuk dimasukkan ke dalam tabel log
        $param = [
            'ID'          => $CI->uuid->v4(),
            'ID_LOGIN'    => $id_login,
            'NAMA_USER'   => $nama_user,
            'TIPE'        => $tipe,
            'DESKRIPSI'   => $str,
            'BROWSER'     => $agent,
            'OS'          => $CI->agent->platform(),
            'IP_ADDRESS'  => $CI->input->ip_address(),
        ];

        // Simpan data ke dalam tabel log
        $CI->db->insert('los_log_login', $param);
    }
}

// Membuat entri log untuk pengajuan pinjaman.
if (!function_exists('create_log_komentar')) {
    /**
     * Membuat entri log untuk pengajuan pinjaman.
     *
     * Fungsi ini mencatat informasi tentang pengajuan pinjaman, termasuk
     * jenis tindakan, ID pinjaman, deskripsi, ID pengguna, informasi browser,
     * sistem operasi, dan alamat IP.
     *
     * @param string $tipe Jenis entri log (misalnya, 'create', 'update').
     * @param string $id_pinjaman ID pinjaman yang sedang dicatat.
     * @param string $deskripsi Deskripsi dari entri log.
     * @return void
     *
     * Contoh penggunaan:
     * create_log_komentar('create', '12345', 'Pengajuan pinjaman baru');
     * create_log_komentar('update', '12345', 'Pengajuan pinjaman diperbarui');
     */
    function create_log_komentar($id_pinjaman = null, $rolename = null, $tipe = null, $komentar = null)
    {
        $CI = &get_instance(); // Mendapatkan instance CodeIgniter

        // Menentukan user agent (browser atau mobile)
        if ($CI->agent->is_browser()) {
            $agent = $CI->agent->browser() . ' ' . $CI->agent->version();
        } elseif ($CI->agent->is_mobile()) {
            $agent = $CI->agent->mobile();
        } else {
            $agent = 'Undefined';
        }

        // Menyiapkan parameter log
        $param = [
            'ID_USER' => strtoupper($CI->session->userdata('sess_id_user')),
            'ID_LOGIN' => strtoupper($CI->session->userdata('sess_id_login')),
            'ID_PINJAMAN' => !empty($id_pinjaman) ? $id_pinjaman : null,
            'ROLE' => !empty($rolename) ? $rolename : null,
            'TIPE' => !empty($tipe) ? $tipe : null,
            'KOMENTAR' => !empty($komentar) ? $komentar : null,
            'DATE_AT' => date('Y-m-d H:i:s'),
            'BROWSER' => $agent,
            'OS' => $CI->agent->platform(),
            'IP_ADDRESS' => $CI->input->ip_address(),
        ];

        // Menyimpan entri log ke dalam database
        $CI->db->insert('los_log_komentar', $param);
    }
}

// Membuat entri log untuk pengajuan pinjaman.
if (!function_exists('create_log_pengajuan')) {
    /**
     * Membuat entri log untuk pengajuan pinjaman.
     *
     * Fungsi ini mencatat informasi tentang pengajuan pinjaman, termasuk
     * jenis tindakan, ID pinjaman, deskripsi, ID pengguna, informasi browser,
     * sistem operasi, dan alamat IP.
     *
     * @param string $tipe Jenis entri log (misalnya, 'create', 'update').
     * @param string $id_pinjaman ID pinjaman yang sedang dicatat.
     * @param string $deskripsi Deskripsi dari entri log.
     * @return void
     *
     * Contoh penggunaan:
     * create_log_pengajuan('create', '12345', 'Pengajuan pinjaman baru');
     * create_log_pengajuan('update', '12345', 'Pengajuan pinjaman diperbarui');
     */
    function create_log_pengajuan($id_pinjaman = null, $rolename = null, $tipe = null, $deskripsi = null)
    {
        $CI = &get_instance(); // Mendapatkan instance CodeIgniter

        // Menentukan user agent (browser atau mobile)
        if ($CI->agent->is_browser()) {
            $agent = $CI->agent->browser() . ' ' . $CI->agent->version();
        } elseif ($CI->agent->is_mobile()) {
            $agent = $CI->agent->mobile();
        } else {
            $agent = 'Undefined';
        }

        // Menyiapkan parameter log
        $param = [
            'ID_PINJAMAN' => !empty($id_pinjaman) ? $id_pinjaman : null,
            'ID_USER' => strtoupper($CI->session->userdata('sess_id_user')),
            'ID_LOGIN' => strtoupper($CI->session->userdata('sess_id_login')),
            'ROLE' => !empty($rolename) ? $rolename : null,
            'TIPE' => !empty($tipe) ? $tipe : null,
            'DESKRIPSI' => !empty($deskripsi) ? $deskripsi : null,
            'DATE_AT' => date('Y-m-d H:i:s'),
            'BROWSER' => $agent,
            'OS' => $CI->agent->platform(),
            'IP_ADDRESS' => $CI->input->ip_address(),
        ];

        // Menyimpan entri log ke dalam database
        $CI->db->insert('los_log_pengajuan', $param);
    }
}

// Membuat entri log untuk proses download
if (!function_exists('create_log_download')) {
    /**
     * Menyimpan log aktivitas download file ke database
     *
     * @param array $params
     *    - role: string
     *    - jenis_file: string
     *    - nama_file: string
     *    - keterangan: string (optional)
     *    - url: string (optional)
     *    - timestamp: string (optional)
     *    - use_hash: bool (optional)
     * @return array
     *    - success: bool
     *    - hash: string|null
     */
    function create_log_download($params = [])
    {
        $CI = &get_instance();

        // Ambil data user dari session
        $id_user   = $CI->session->userdata('sess_id_user') ?? null;
        $id_login  = $CI->session->userdata('sess_id_login') ?? null;
        $username  = $CI->session->userdata('sess_username') ?? null;
        $timestamp = $params['timestamp'] ?? date('Y-m-d H:i:s');

        $nama_file = $params['nama_file'] ?? 'unknown';
        $use_hash  = $params['use_hash'] ?? false;

        $hash = null;
        if ($use_hash && $username) {
            $concat = $nama_file . '|' . $username . '|' . $timestamp;
            $hash   = hash('sha256', $concat);
        }

        // Ambil informasi browser/device
        $browser = $CI->agent->browser() . ' ' . $CI->agent->version();
        $os      = $CI->agent->platform();
        $ip      = $CI->input->ip_address();

        // Simpan data log ke database
        $data = [
            'ID_USER'    => $id_user,
            'ID_LOGIN'   => $id_login,
            'USERNAME'   => $username,
            'ROLE'       => $params['role'] ?? 'unknown',
            'NAMA_FILE'  => $nama_file,
            'JENIS_FILE' => $params['jenis_file'] ?? 'general',
            'URL'        => $params['url'] ?? current_url(),
            'KETERANGAN' => $params['keterangan'] ?? null,
            'BROWSER'    => $browser,
            'OS'         => $os,
            'IP_ADDRESS' => $ip,
            'DATE_AT'    => $timestamp,
            'FILE_HASH'  => $hash
        ];

        return [
            'success' => $CI->db->insert('los_log_download', $data),
            'hash'    => $hash
        ];
    }
}

// Menyimpan log hasil proses sinkronisasi SLIK ke
if (!function_exists('create_log_slik_sync')) {
    /**
     * Menyimpan log hasil proses sinkronisasi SLIK ke dalam tabel `los_log_slik_sync`.
     *
     * Fungsi ini digunakan untuk mencatat hasil dari proses sinkronisasi,
     * baik itu berhasil atau gagal, beserta deskripsi keterangannya.
     *
     * @param int|string $idPinjaman  ID pinjaman (boleh dalam bentuk numerik atau string terenkripsi).
     * @param bool $status            Status hasil proses: `true` jika sukses, `false` jika gagal.
     * @param string $keterangan      Deskripsi hasil proses sinkronisasi (misalnya alasan kegagalan).
     * @return void
     */
    function create_log_slik_sync($idPinjaman, $status, $keterangan)
    {
        // Ambil instance CI untuk akses database
        $CI = &get_instance();

        // Load database jika belum dimuat
        $CI->load->database();

        // Insert log ke tabel `los_log_slik_sync`
        $CI->db->insert('los_log_slik_sync', [
            'ID_PINJAMAN' => $idPinjaman,
            'status' => $status ? 'sukses' : 'gagal', // Konversi boolean ke teks
            'DESKRIPSI' => $keterangan,               // Simpan deskripsi hasil sinkron
        ]);
    }
}

/**
 * Simpan log aktivitas user (fleksibel + aman)
 *
 * @param string $activity   Deskripsi aktivitas
 * @param array  $extraData  Data tambahan (akan disimpan dalam kolom JSON log_extra)
 */
if (!function_exists('create_log_user_activity')) {
    function create_log_user_activity($activity = '', array $extraData = [])
    {
        $CI = &get_instance();

        $user_id   = $CI->session->userdata('sess_id_user');
        $username  = $CI->session->userdata('sess_username');

        // Data log utama
        $data = [
            'log_user_id'    => $user_id ?? 0,
            'log_username'   => $username ?? 'guest',
            'log_activity'   => $activity,
            'log_ip_address' => $CI->input->ip_address(),
            'log_user_agent' => $CI->input->user_agent(),
            'log_created_at' => date('Y-m-d H:i:s'),
        ];

        // Simpan extra data (jika ada)
        if (!empty($extraData)) {
            $data['log_extra'] = json_encode($extraData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        $CI->db->insert('los_log_user_activity', $data);
    }
}

// Mengembalikan label HTML berdasarkan jenis kredit yang diberikan
if (!function_exists('format_jenis_kredit_nolabel')) {
    /**
     * Mengembalikan label HTML berdasarkan jenis kredit yang diberikan.
     *
     * Fungsi ini menerima jenis kredit sebagai parameter dan mengembalikan
     * string HTML yang sesuai dengan jenis kredit tersebut. Jika jenis kredit
     * tidak dikenali, fungsi akan mengembalikan pesan kesalahan.
     *
     * @param string $jenisKredit Jenis kredit yang ingin dicek.
     * @return string Label HTML yang sesuai dengan jenis kredit.
     */
    function format_jenis_kredit($jenisKredit)
    {
        // Inisialisasi variabel untuk menyimpan HTML
        $html = '';

        // Menentukan label berdasarkan jenis kredit
        switch ($jenisKredit) {
            case 'makro':
                $html = "<span class='text-blue'>PEMBIAYAAN MAKRO</span>";
                break;
            case 'mikro':
                $html = "<span class='text-green'>PEMBIAYAAN MIKRO</span>";
                break;
            default:
                $html = "<span class='text-red'>Code Error 404</span>";
                break;
        }

        return $html; // Mengembalikan label HTML
    }
}

// Mengembalikan bulan dalam format dua digit
if (!function_exists('convert_month')) {
    /**
     * Mengembalikan bulan dalam format dua digit.
     *
     * @param int $bln Bulan dalam format angka (1-12).
     * @return string Bulan dalam format dua digit.
     */
    function convert_month($bln)
    {
        return str_pad($bln, 2, '0', STR_PAD_LEFT); // Menggunakan str_pad untuk format dua digit
    }
}

// Mengubah tanggal dalam format YYYY-MM-DD menjadi format DD/MM/YYYY dengan pemisah yang dapat disesuaika
if (!function_exists('format_date_indo_v2')) {
    /**
     * Mengubah tanggal dalam format YYYY-MM-DD menjadi format DD/MM/YYYY dengan pemisah yang dapat disesuaikan.
     *
     * @param string|null $tgl Tanggal dalam format YYYY-MM-DD.
     * @param string $separator Pemisah yang digunakan antara tanggal, bulan, dan tahun. Default adalah '/'.
     * @return string|false Tanggal dalam format DD{separator}MM{separator}YYYY atau false jika input null.
     */
    function format_date_indo_v2($tgl, $separator = '/')
    {
        if ($tgl === null) {
            return false; // Mengembalikan false jika tanggal null
        }

        // Mengubah format tanggal dari YYYY-MM-DD ke DD/MM/YYYY
        $pecah = explode("-", $tgl);
        if (count($pecah) !== 3) {
            return false; // Mengembalikan false jika format tidak valid
        }

        $tanggal = $pecah[2];
        $bulan = convert_month((int)$pecah[1]); // Mengonversi bulan ke integer
        $tahun = $pecah[0];

        return "{$tanggal}{$separator}{$bulan}{$separator}{$tahun}"; // Mengembalikan format DD{separator}MM{separator}YYYY
    }
}

// Mengambil nama lengkap pengguna berdasarkan ID pengguna atau ID login.
if (!function_exists('get_fullname_user')) {
    /**
     * Mengambil nama lengkap pengguna berdasarkan ID pengguna atau ID login.
     *
     * Fungsi ini menggunakan CodeIgniter's database instance untuk menjalankan
     * query yang mengambil nama pengguna dari tabel vw_authentikasi berdasarkan
     * ID pengguna atau ID login yang diberikan.
     *
     * @param int $id ID pengguna atau ID login yang ingin dicari.
     * @param string $type Tipe ID yang digunakan untuk pencarian ('user' atau 'login').
     * @return string|null Nama pengguna jika ditemukan, atau null jika tidak ada.
     */
    function get_fullname_user($id, $type = 'user')
    {
        $CI = &get_instance(); // Mendapatkan instance CodeIgniter

        // Menjalankan query untuk mendapatkan nama pengguna dengan parameter binding
        $CI->db->select('NAMA_USER'); // Hanya memilih kolom NAMA_USER
        $CI->db->from('vw_authentikasi');

        // Menentukan kondisi pencarian berdasarkan tipe ID
        if ($type === 'login') {
            $CI->db->where('ID_LOGIN', $id);
        } else {
            $CI->db->where('ID_USER', $id);
        }

        $query = $CI->db->get();
        $row = $query->row_array();

        // Mengembalikan nama pengguna atau null jika tidak ditemukan
        return isset($row['NAMA_USER']) ? $row['NAMA_USER'] : null;
    }
}

// Memeriksa apakah booking untuk ID pinjaman tertentu sudah terverifikasi
if (!function_exists('checked_booking')) {
    /**
     * Memeriksa apakah booking untuk ID pinjaman tertentu sudah terverifikasi.
     *
     * @param int $id_pinjaman ID pinjaman yang ingin diperiksa.
     * @return string|null Mengembalikan "checked" jika booking status adalah 1, atau null jika tidak.
     */
    function checked_booking($id_pinjaman)
    {
        $ci = get_instance();

        // Mengambil data booking berdasarkan ID pinjaman
        $ci->db->select('BOOKING_STATUS');
        $ci->db->from('los_debitur_pinjaman');
        $ci->db->where('ID_PINJAMAN', $id_pinjaman);
        $query = $ci->db->get();

        // Memeriksa apakah data ditemukan
        if ($query->num_rows() > 0) {
            $data = $query->row_array();
            return ($data['BOOKING_STATUS'] == 1) ? "checked" : null;
        }

        return null; // Mengembalikan null jika tidak ditemukan
    }
}

// Mengambil status booking pengguna berdasarkan ID pinjaman
if (!function_exists('get_user_booking')) {
    /**
     * Mengambil status booking pengguna berdasarkan ID pinjaman.
     *
     * Fungsi ini mengembalikan HTML untuk menampilkan status booking
     * pengguna berdasarkan ID pinjaman yang diberikan.
     *
     * @param int $id_pinjaman ID pinjaman yang ingin dicari.
     * @return string HTML yang menunjukkan status booking pengguna.
     */
    function get_user_booking($id_pinjaman)
    {
        $ci = get_instance();

        // Mengambil data booking berdasarkan ID pinjaman
        $ci->db->select('BOOKING_STATUS, BOOKING_ID_USER');
        $ci->db->where('ID_PINJAMAN', $id_pinjaman);
        $data = $ci->db->get('los_debitur_pinjaman')->row_array();

        // Memeriksa apakah data ditemukan
        if (!$data) {
            return "<span class='text-gray'>Data tidak ditemukan</span>"; // Menangani kasus jika tidak ada data
        }

        // Menentukan status booking dan mengembalikan HTML yang sesuai
        if ($data['BOOKING_STATUS'] == 1) {
            $userName = get_name_iduser($data['BOOKING_ID_USER']);
            return "<span class='text-red'> <i class='fa fa-lock'></i> Lock <br> <i class='fa fa-user'></i> {$userName}</span>";
        } else {
            return "<span class='text-green'> <i class='fa fa-lock-open'></i> Unlock </span>";
        }
    }
}

// Mengambil nama karyawan berdasarkan ID karyawan
if (!function_exists('get_nama_karyawan')) {
    /**
     * Mengambil nama karyawan berdasarkan ID karyawan.
     *
     * Fungsi ini menggunakan CodeIgniter's database instance untuk menjalankan
     * query yang mengambil nama karyawan dari tabel karyawan berdasarkan
     * ID karyawan yang diberikan.
     *
     * @param int $id ID karyawan yang ingin dicari.
     * @return string|null Nama karyawan jika ditemukan, atau null jika tidak ada.
     */
    function get_nama_karyawan($id)
    {
        $CI = &get_instance();

        // Menjalankan query untuk mendapatkan nama karyawan dengan parameter binding
        $CI->db->select('NAMA_KARYAWAN');
        $CI->db->from('los_karyawan');
        $CI->db->where('ID_KARYAWAN', $id);
        $query = $CI->db->get();

        // Memeriksa apakah data ditemukan
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return $row['NAMA_KARYAWAN'];
        }

        return null; // Mengembalikan null jika tidak ditemukan
    }
}

// Logging Verifikasi
if (!function_exists('get_log_pengembalian_verifikasi')) {
    /**
     * Mengambil log pengembalian verifikasi berdasarkan ID pinjaman.
     *
     * Metode ini melakukan langkah-langkah berikut:
     * 1. Memastikan bahwa ID pinjaman yang diberikan tidak null sebelum melakukan query.
     * 2. Jika ID null, metode akan mengembalikan null (atau bisa juga melempar exception jika diinginkan).
     * 3. Memilih kolom yang diperlukan dari tabel log_hispengajuan, termasuk total jumlah dan tanggal terakhir.
     * 4. Menambahkan kondisi untuk memfilter hasil berdasarkan tipe log "Dikembalikan Verifikasi" dan ID pinjaman yang diberikan.
     * 5. Mengambil hasil dari tabel log_hispengajuan dan mengembalikannya sebagai array.
     *
     * @param int|null $id ID pinjaman yang digunakan untuk memfilter log.
     * @return array|null Mengembalikan array hasil log atau null jika ID tidak valid.
     */
    function get_log_pengembalian_verifikasi($id = null)
    {
        // Mendapatkan instance CodeIgniter
        $CI = &get_instance();
        $CI->load->database(); // Memastikan database di-load

        // Memastikan ID tidak null sebelum melakukan query
        if ($id === null) {
            return null; // Atau bisa juga throw exception jika diinginkan
        }

        // Memilih kolom yang diperlukan dari tabel log_hispengajuan
        $CI->db->select("CONCAT(COUNT(ID_PINJAMAN), 'x ', TIPE) AS total, MAX(DATE_AT) AS lastdate");

        // Menambahkan kondisi untuk tipe dan ID pinjaman
        $CI->db->where("TIPE", "Update Dikembalikan Verifikasi");
        $CI->db->where("ID_PINJAMAN", $id);

        // Mengambil hasil dari tabel log_hispengajuan
        $result = $CI->db->get("los_log_pengajuan")->row_array();

        return $result; // Mengembalikan hasil sebagai array
    }
}

// Fungsi untuk memisahkan RT dan RW dari string
if (!function_exists('split_rtrw')) {
    // $string : Input string dengan format RT/RW (contoh: "001/002")
    // $mode   : 'split_rt' untuk RT, 'split_rw' untuk RW, NULL untuk string asli
    function split_rtrw($string, $mode = NULL)
    {
        if ($mode == 'rt') {
            return substr($string, 0, 3);
        } elseif ($mode == 'rw') {
            return substr($string, 4, 3);
        } else {
            return $string;
        }
    }
}

// Fungsi untuk mengonversi kode jenis kelamin menjadi teks
// $string : 'L' untuk Laki-laki, 'P' untuk Perempuan
if (!function_exists('jenis_kelamin')) {
    function jenis_kelamin($string)
    {
        return $string == 'L' ? 'LAKI-LAKI' : 'PEREMPUAN';
    }
}

// Cek expire ktp
if (!function_exists('is_ktp_exp')) {
    function is_ktp_exp($date, $format = 'Y-m-d')
    {
        // Cek jika tanggal valid
        if (strtotime($date) === false) {
            return "Invalid date";
        }

        $year = date('Y', strtotime($date));

        if ($year >= 2999) {
            return "SEUMUR HIDUP";
        } else {
            return date($format, strtotime($date)); // Format tanggal sesuai kebutuhan, misalnya 'd-m-Y'
        }
    }
}

# hitung usia saat pengajuan
# ---
if (!function_exists('usia_pengajuan')) {
    function usia_pengajuan($tgl_awal, $tgl_akhir)
    {
        $awal  = new DateTime($tgl_awal);
        $akhir = new DateTime($tgl_akhir);
        $diff  = $awal->diff($akhir);

        return $diff->y . ' Tahun, ' . $diff->m . ' Bulan, ' . $diff->d . ' Hari';
    }
}

// hitung tanggal jatuh tempo berdasarkan tenor yang di ajukan
// ---
if (!function_exists('tgl_jatuh_tempo')) {
    function tgl_jatuh_tempo($tanggal, $tenor)
    {
        return date('Y-m-d', strtotime(' +' . $tenor . ' month', strtotime($tanggal)));
    }
}

// hitung usia saat jatuh tempo
// hitung tanggal jatuh tempo berdasarkan tenor yang di ajukan
// ---
if (!function_exists('usia_jatuh_tempo')) {
    function usia_jatuh_tempo($tgl_awal, $tgl_akhir)
    {
        $awal  = new DateTime($tgl_awal);
        $akhir = new DateTime($tgl_akhir);
        $diff  = $awal->diff($akhir);

        return $diff->y . ' Tahun, ' . $diff->m . ' Bulan, ' . $diff->d . ' Hari';
    }
}

// Periksa apakah fungsi is_label_jenispensiun belum ada
if (!function_exists('is_label_jenispensiun')) {
    function is_label_jenispensiun($status)
    {
        // Jika status 1, kembalikan label TSP
        if ($status === '1') {
            return 'TSP';
        }
        // Jika status 2, kembalikan label ASB
        else if ($status === '2') {
            return 'ASB';
        }
        // Jika status tidak dikenali, kembalikan string kosong
        return '';
    }
}

// Label status upload
if (!function_exists('status_file_upload')) {
    function status_file_upload($pathUpload)
    {
        // Path relatif ke folder 'upload'
        $statusUpload = TRUE;

        // Jika pathUpload kosong atau mengarah ke folder root 'upload'
        if (empty($pathUpload) || $pathUpload === 'upload') {
            // Redirect ke file '404.pdf' di folder 'upload'
            $statusUpload = FALSE;
        }

        // Kembalikan URL absolut ke file upload
        return $statusUpload;
    }
}

// Link directory upload
if (!function_exists('asset_file_upload')) {
    function asset_file_upload($pathUpload)
    {
        // Domain yang diizinkan
        $allowedDomain = 'https://cloud.kopjasjbs.com/';

        // Jika pathUpload kosong atau mengarah ke folder root 'upload'
        if (empty($pathUpload) || $pathUpload === 'upload') {
            return base_url('upload/404.pdf');
        }

        // Periksa apakah pathUpload adalah URL penuh
        if (filter_var($pathUpload, FILTER_VALIDATE_URL)) {
            // Jika URL tidak mengandung domain yang diizinkan
            if (strpos($pathUpload, $allowedDomain) !== 0) {
                return base_url('upload/404.pdf');
            }
            // Jika URL valid, kembalikan URL tersebut langsung
            return $pathUpload;
        }

        // Jika pathUpload relatif, pastikan tetap mengarah ke folder 'upload'
        return base_url($pathUpload);
    }
}

if (!function_exists('get_info_sumberdana')) {
    /**
     * Mengambil informasi lengkap sumber dana berdasarkan ID
     *
     * Fungsi ini mengambil informasi dari tabel `los_sumberdana`
     * dan menggabungkan data terkait dari tabel `los_sumberdana_group`
     * menggunakan LEFT JOIN.
     *
     * @param int|string $id ID dari sumber dana yang ingin dicari
     * @return object|null Mengembalikan objek data sumber dana jika ditemukan,
     *                     atau null jika data tidak ditemukan.
     */
    function get_info_sumberdana($id)
    {
        // Ambil instance CodeIgniter
        $CI = &get_instance();

        // Query data sumber dana dengan join menggunakan Query Builder
        $result = $CI->db->select('a.*, b.ID_GROUP_SUMBERDANA, b.KODE_GROUP_SUMBERDANA, b.NAMA_GROUP_SUMBERDANA')
            ->from('los_sumberdana AS a')
            ->join('los_sumberdana_group AS b', 'b.ID_SUMBERDANA = a.ID_SUMBERDANA', 'left')
            ->where('a.ID_SUMBERDANA', $id)
            ->get()
            ->row_array();

        // Mengembalikan data (objek) atau null jika tidak ditemukan
        return $result ?: null;
    }
}

if (!function_exists('get_info_cabang')) {
    /**
     * Mengambil informasi cabang berdasarkan group cabang dan kode cabang
     *
     * Fungsi ini mengambil data dari tabel `los_cabang` dan
     * menggabungkan data terkait dari tabel `los_cabang_referensi`
     * menggunakan LEFT JOIN berdasarkan `KODE_CABANG`.
     *
     * @param int $group_id ID group cabang untuk filter data
     * @param string|int $kode_cabang Kode cabang untuk filter data
     * @return object|null Mengembalikan objek data cabang jika ditemukan,
     *                     atau null jika tidak ada data.
     */
    function get_info_cabang($kode_cabang)
    {
        // Ambil instance CodeIgniter
        $CI = &get_instance();

        // Query data cabang dengan LEFT JOIN
        $result = $CI->db->select('a.*, c.KODE_CABANG, c.NAMA_AREA')
            ->from('los_cabang AS a')
            ->join('los_cabang_referensi AS c', 'c.KODE_CABANG = a.KODE_CABANG', 'left')
            ->where('a.ID_GROUP_CABANG', 2)
            ->where('a.KODE_CABANG', $kode_cabang)
            ->get()
            ->row_array();

        // Mengembalikan data objek atau null jika tidak ditemukan
        return $result ?: null;
    }
}

// Membersihkan dan merapikan konten HTML dari editor wysihtml5
if (!function_exists('clean_wysihtml5_content')) {
    /**
     * Membersihkan dan merapikan konten HTML dari editor wysihtml5
     *
     * @param string $html Konten HTML yang perlu dirapikan.
     * @return string Konten HTML yang telah dirapikan.
     */
    function clean_wysihtml5_content($html)
    {
        // Hapus elemen <br> yang berlebihan
        $html = preg_replace('/(<br>\s*){2,}/', '<br>', $html);

        // Hapus elemen kosong seperti <div></div> atau <p></p>
        $html = preg_replace('/<div>(\s|&nbsp;)*<\/div>/', '', $html);
        $html = preg_replace('/<p>(\s|&nbsp;)*<\/p>/', '', $html);

        // Hapus spasi berlebih di dalam elemen
        $html = preg_replace('/\s+/', ' ', $html);

        // Hapus tag HTML yang tidak diperlukan (contoh: style atau script)
        $html = strip_tags($html, '<div><p><br><b><i><u><ul><ol><li>');

        // Hapus elemen duplikat yang sama berturut-turut
        $html = preg_replace('/(<div>.*?<\/div>)(\s*\\1)+/s', '\\1', $html);

        // Trim untuk menghapus spasi ekstra di awal/akhir
        $html = trim($html);

        return $html;
    }
}

// Fungsi untuk menghitung tanggal jatuh tempo pinjaman
if (!function_exists('hitung_tgl_jatuhtempo')) {
    /**
     * Menghitung tanggal jatuh tempo berdasarkan tanggal pinjaman dan jangka waktu (dalam bulan).
     * @param string $tanggalPinjaman - Tanggal pinjaman dalam format 'Y-m-d'
     * @param int $jangkaWaktu - Jangka waktu pinjaman dalam bulan
     * @return string - Tanggal jatuh tempo dalam format 'Y-m-d'
     */
    function hitung_tgl_jatuhtempo($tanggalPinjaman, $jangkaWaktu)
    {
        $tanggalPinjaman = new DateTime($tanggalPinjaman);
        $tanggalPinjaman->add(new DateInterval("P{$jangkaWaktu}M")); // Tambah jangka waktu dalam bulan
        return $tanggalPinjaman->format('Y-m-d');
    }
}

// Fungsi untuk menghitung usia saat jatuh tempo (dalam Tahun, Bulan, Hari)
if (!function_exists('hitung_usia_jatuhtempo')) {
    /**
     * Menghitung usia debitur saat jatuh tempo dalam format Tahun, Bulan, Hari.
     * @param string $tanggalLahir - Tanggal lahir debitur dalam format 'Y-m-d'
     * @param string $tanggalJatuhTempo - Tanggal jatuh tempo dalam format 'Y-m-d'
     * @return string - Usia dalam format 'X Tahun, Y Bulan, Z Hari'
     */
    function hitung_usia_jatuhtempo($tanggalLahir, $tanggalJatuhTempo)
    {
        $tanggalLahir = new DateTime($tanggalLahir);
        $tanggalJatuhTempo = new DateTime($tanggalJatuhTempo);
        $selisih = $tanggalLahir->diff($tanggalJatuhTempo);

        // Format hasil ke dalam "X Tahun, Y Bulan, Z Hari"
        return "{$selisih->y} Tahun, {$selisih->m} Bulan, {$selisih->d} Hari";
    }
}

// Fungsi untuk menghitung rasio pinjaman
if (!function_exists('hitung_rasio_angsuran')) {
    /**
     * Menghitung rasio pinjaman berdasarkan angsuran bulanan dan gaji.
     * @param float $angsuranBulanan - Jumlah angsuran bulanan
     * @param float $gaji - Gaji bulanan peminjam
     * @return float - Rasio pinjaman dalam persentase (%)
     */
    function hitung_rasio_angsuran($angsuranBulanan, $gaji)
    {
        if ($gaji == 0) {
            return 0; // Menghindari pembagian dengan nol
        }

        $rasio = ($angsuranBulanan / $gaji) * 100; // Hitung rasio dalam persen
        return round($rasio, 0) . '%'; // Bulatkan ke dua desimal
    }
}

// Fungsi ini untuk menampilkan alert dan langsung redirect ke halaman yang di tuju
if (!function_exists('show_alert_and_redirect')) {
    function show_alert_and_redirect($message, $redirectUrl)
    {
        echo '<script language="javascript">';
        echo "alert('$message');";
        echo '</script>';
        echo "<script>window.location.href = '" . site_url($redirectUrl) . "';</script>";
    }
}

// Fungsi untuk mendapatkan status SLIK dan waktu sinkronisasi terakhir.
/**
 * Fungsi untuk mendapatkan status SLIK dan waktu sinkronisasi terakhir.
 *
 * @param array $data Data yang berisi informasi SLIK.
 * @return array Mengembalikan array dengan status SLIK dan waktu sinkronisasi terakhir.
 */
if (!function_exists('get_slik_status')) {
    function get_slik_status($data)
    {
        $status = '';
        $last_sync = '--';

        if (isset($data['STATUS_BIC']) && $data['STATUS_BIC'] == 'Y') {
            $status = '<span class="label label-green">Status : Approved</span>';
            $last_sync = (!empty($data['BI_UPDATE_AT'])) ? $data['BI_UPDATE_AT'] : '--';
        } else {
            $status = '<span class="label label-warning">Status : Pending</span>';
        }

        return [
            'status' => $status,
            'last_sync' => $last_sync
        ];
    }
}

/**
 * Fungsi untuk mendapatkan URL file yang sudah di-upload.
 * Jika file tidak ditemukan, maka akan mengembalikan file default.
 *
 * @param string $table Nama tabel database yang menyimpan data file.
 * @param string $id_field Nama kolom yang digunakan untuk mencari data (misalnya 'ID_PINJAMAN').
 * @param mixed $id_value Nilai dari kolom tersebut (ID yang dicari).
 * @param string $upload_folder Nama folder penyimpanan file di dalam 'upload/'.
 * @return string URL file yang di-upload atau file default jika tidak ditemukan.
 *
 * $filePathAkadBank = get_uploaded_file('los_upload_akad_bank', 'ID_PINJAMAN', $data['ID_PINJAMAN'], 'file_upload_akad_bank');
 */
if (!function_exists('get_uploaded_file')) {
    function get_uploaded_file($table, $id_field, $id_value, $upload_folder)
    {
        // Ambil instance CI untuk menggunakan database
        $CI = &get_instance();
        $CI->load->database();

        // URL default jika file tidak ditemukan
        $defaultFile = base_url('upload/404.pdf');

        // Query untuk mendapatkan nama file berdasarkan ID yang diberikan
        $CI->db->select('NAMA_FILE');
        $query = $CI->db->get_where($table, [$id_field => $id_value]);
        $fileData = $query->row_array();

        // Validasi apakah data ditemukan dan nama file ada
        if (!empty($fileData) && !empty($fileData['NAMA_FILE'])) {
            $fileName = basename($fileData['NAMA_FILE']); // Mencegah Directory Traversal Attack
            $filePath = realpath(FCPATH . "upload/$upload_folder/" . $fileName);

            // Pastikan file berada dalam direktori yang diizinkan
            if ($filePath && strpos($filePath, realpath(FCPATH . "upload/$upload_folder/")) === 0) {
                // Pastikan file ada dan berformat PDF
                if (file_exists($filePath) && pathinfo($filePath, PATHINFO_EXTENSION) === 'pdf') {
                    return base_url("upload/$upload_folder/" . $fileName);
                }
            }
        }

        // Jika file tidak ditemukan, kembalikan URL default
        return $defaultFile;
    }
}

/**
 * Helper untuk mengambil tanggal terakhir update dari tabel log.
 *
 * @param string $table  Nama tabel yang akan diambil data terakhir update-nya.
 * @param string $column Nama kolom yang menyimpan timestamp update (default: 'updated_at').
 * @param array  $where  Kondisi tambahan untuk filter data (default: kosong).
 * @return string|null   Tanggal terakhir update atau null jika tidak ada data.
 */
if (!function_exists('get_last_update')) {
    function get_last_update($table, $column = '', $where = [])
    {
        $CI = &get_instance();
        $CI->load->database();

        $CI->db->select_max($column, 'last_update');

        if (!empty($where)) {
            $CI->db->where($where);
        }

        $query = $CI->db->get($table);

        if ($query->num_rows() > 0) {
            return $query->row()->last_update;
        }

        return null;
    }
}

/**
 * Helper function untuk mengecek jenis rate bunga
 *
 * @param array $row Data yang berisi informasi jenis bunga
 * @return string Jenis rate dalam format string dengan persen
 */
if (!function_exists('cek_jenis_rate')) {
    function cek_jenis_rate($row, $sumber)
    {
        // Mengecek jika jenis bunga adalah 'EFFEKTIF'
        if (isset($row['JENIS_BUNGA']) && $row['JENIS_BUNGA'] == 'EFFEKTIF') {
            if ($sumber === 'kop' && isset($row['BUNGA_EFF_KOP'])) {
                return $row['BUNGA_EFF_KOP'];
            } elseif ($sumber === 'bank' && isset($row['BUNGA_EFF_BANK'])) {
                return $row['BUNGA_EFF_BANK'];
            }
        } elseif (isset($row['BUNGA_FLAT']) && $row['JENIS_BUNGA'] == 'FLAT') {
            // Mengembalikan bunga flat berdasarkan sumber
            if ($sumber === 'kop' && isset($row['BUNGA_FLAT'])) {
                return number_format($row['BUNGA_FLAT'] * 100, 2);
            } elseif ($sumber === 'bank' && isset($row['BUNGA_FLAT_BANK'])) {
                return number_format($row['BUNGA_FLAT_BANK'] * 100, 2);
            }
        }

        return ' -- ';
    }
}

// Helper untuk mendapatkan informasi status antrian pengajuan
// Refactored on 2025-02-01
if (!function_exists('tracking_antrian_pengajuan')) {
    function tracking_antrian_pengajuan($id_pinjaman = NULL)
    {
        $_ci = &get_instance();

        // Ambil data pinjaman berdasarkan ID
        $row = $_ci->db->select("ID_PINJAMAN, ID_DEBITUR, NO_REGISTRASI, NAMA_DEBITUR, STATUS_ANTRIAN_DEBITUR, STATUS_ANTRIAN_OPS, STATUS_KEMBALIKAN_VRF, STATUS_APPROVAL, STATUS_ANTRIAN_PENDING, STATUS_CAIR, STATUS_OPS, STATUS_DAFNOM, STATUS_REJECT")
            ->from("vw_pinjaman")
            ->where("ID_PINJAMAN", $id_pinjaman)
            ->get()
            ->row_array();

        // Jika data tidak ditemukan, kembalikan status default
        if (!$row) {
            return default_response();
        }

        return determine_status($row);
    }
}

// Fungsi untuk mengembalikan respons default
if (!function_exists('default_response')) {
    function default_response()
    {
        return [
            'cekpos' => label('danger', 'DATA TIDAK DITEMUKAN'),
            'cekstatus' => status_icon('user-slash', 'text-danger', 'DATA TIDAK DITEMUKAN'),
        ];
    }
}

// Fungsi untuk menentukan status berdasarkan data antrian
if (!function_exists('determine_status')) {
    function determine_status($row)
    {
        $cekPos = '';
        $cekStatus = '';

        switch (true) {
            case ($row['STATUS_ANTRIAN_DEBITUR'] == 1 && $row['STATUS_ANTRIAN_OPS'] == 1 && $row['STATUS_KEMBALIKAN_VRF'] == 'Y'):
                return response('danger', 'KANTOR LAYANAN', 'reply-all', 'text-danger', 'DIKEMBALIKAN VERIFIKASI');

            case ($row['STATUS_ANTRIAN_DEBITUR'] == 2 && $row['STATUS_ANTRIAN_OPS'] == 1 && $row['STATUS_KEMBALIKAN_VRF'] == 'N'):
                return response('green', 'VERIFIKASI', $row['STATUS_ANTRIAN_PENDING'] == 1 ? 'road' : 'user-check', $row['STATUS_ANTRIAN_PENDING'] == 1 ? 'text-info' : 'text-blue', $row['STATUS_ANTRIAN_PENDING'] == 1 ? 'ON BOARDING' : 'PROSES VERIFIKASI (CHECKING)');

            case ($row['STATUS_ANTRIAN_DEBITUR'] == 6 && $row['STATUS_ANTRIAN_OPS'] == 1 && $row['STATUS_KEMBALIKAN_VRF'] == 'N'):
                return response('green', 'VERIFIKASI', $row['STATUS_ANTRIAN_PENDING'] == 1 ? 'question-circle' : 'user-clock', 'text-warning', $row['STATUS_ANTRIAN_PENDING'] == 1 ? 'ON BOARDING' : 'PROSES VERIFIKASI (PENDING)');

            case ($row['STATUS_ANTRIAN_DEBITUR'] == 4 && $row['STATUS_ANTRIAN_OPS'] == 1):
                return response('purple', 'APP KREDIT', 'user-tag', 'text-warning', 'PROSES TAKE OVER');

            case ($row['STATUS_ANTRIAN_DEBITUR'] == 5 && $row['STATUS_ANTRIAN_OPS'] == 1 && $row['STATUS_OPS'] == 'N'):
                return response('purple', 'APP KREDIT', 'user-tag', 'text-green', 'PROSES UPLOAD AKAD');

            case ($row['STATUS_ANTRIAN_DEBITUR'] == 5 && $row['STATUS_ANTRIAN_OPS'] == 5 && $row['STATUS_OPS'] == 'Y' && $row['STATUS_CAIR'] == 'Y' && $row['STATUS_DAFNOM'] == 'N'):
                return response('purple', 'APP KREDIT', 'user-ninja', 'text-red', 'PROSES DAFNOM KE BANK');

            case ($row['STATUS_ANTRIAN_DEBITUR'] == 5 && $row['STATUS_ANTRIAN_OPS'] == 5 && $row['STATUS_OPS'] == 'Y' && $row['STATUS_CAIR'] == 'Y' && $row['STATUS_DAFNOM'] == 'Y'):
                if ($row['STATUS_REJECT'] == 'Y') {
                    return response('primary', 'APPROVAL BANK', 'times-circle', 'text-red', 'DI REJECT OLEH BANK');
                } elseif ($row['STATUS_APPROVAL'] == 'Y') {
                    return response('primary', 'APPROVAL BANK', 'check-circle', 'text-green', 'DISETUJUI OLEH BANK');
                } else {
                    return response('primary', 'APPROVAL BANK', 'question-circle', 'text-warning', 'PROSES PEMERIKSAAN BANK');
                }

            default:
                return response('danger', '404 (BYPASS)', 'user-slash', 'text-danger', 'TIDAK ADA DI ANTRIAN 404 (BYPASS)');
        }
    }
}

// Fungsi helper untuk membuat label HTML
if (!function_exists('label')) {
    function label($color, $text)
    {
        return '<span class="label label-' . $color . ' f-w-600"> <i class="fa fa-chevron-circle-right fa-fw"></i> ' . $text . '</span>';
    }
}

// Fungsi helper untuk membuat status dengan ikon
if (!function_exists('status_icon')) {
    function status_icon($icon, $color, $text)
    {
        return '<i class="fas fa-' . $icon . ' fa-fw ' . $color . '"></i> ' . $text;
    }
}

// Fungsi untuk membuat respons status secara singkat
if (!function_exists('response')) {
    function response($labelColor, $labelText, $icon, $iconColor, $statusText)
    {
        return [
            'cekpos' => label($labelColor, $labelText),
            'cekstatus' => status_icon($icon, $iconColor, $statusText),
        ];
    }
}

// 
if (!function_exists('menu_active')) {
    /**
     * Return class 'active' jika URI cocok
     *
     * @param string|array $uri URI atau array URI yang ingin dicek
     * @param string $class Nama class yang dikembalikan, default: 'active'
     * @return string
     */
    function menu_active($uri, $class = 'active')
    {
        $CI = &get_instance();
        $current_uri = $CI->uri->uri_string();

        if (is_array($uri)) {
            foreach ($uri as $u) {
                if (strpos($current_uri, trim($u, '/')) === 0) {
                    return $class;
                }
            }
        } else {
            if (strpos($current_uri, trim($uri, '/')) === 0) {
                return $class;
            }
        }

        return '';
    }
}

// 
if (!function_exists('clean_input_html')) {
    /**
     * Membersihkan input HTML dari spasi berlebih, tag kosong, karakter aneh, dan XSS ringan.
     *
     * @param string $html
     * @return string
     */
    function clean_input_html($html)
    {
        if (!is_string($html)) return $html;

        // 1. Hapus karakter non-printable
        $html = preg_replace('/[\x00-\x1F\x7F]/u', '', $html);

        // 2. Hilangkan script injection
        $html = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $html);

        // 3. Ganti &nbsp; ke spasi biasa
        $html = str_replace('&nbsp;', ' ', $html);

        // 4. Standarisasi <br>
        $html = preg_replace('/<br\s*\/?>/i', '<br>', $html);

        // 5. Gabungkan <br> berturut-turut jadi satu
        $html = preg_replace('/(<br>\s*){2,}/i', '<br>', $html);

        // 6. Trim setiap baris dari spasi/tab
        $html = preg_replace('/^[\h\v]+|[\h\v]+$/m', '', $html);

        // 7. Hapus <p> kosong
        $html = preg_replace('/<p>\s*<\/p>/', '', $html);

        // 8. Hapus tag HTML kosong lain (seperti <div></div>)
        $html = preg_replace('/<([a-z][a-z0-9]*)[^>]*>\s*<\/\1>/i', '', $html);

        // 9. Normalisasi spasi berlebih dalam kalimat
        $html = preg_replace('/[ ]{2,}/', ' ', $html);

        return trim($html);
    }
}

// Convert Indo
if (!function_exists('format_indo_date')) {
    /**
     * Mengubah format tanggal YYYY-MM-DD menjadi format Bulan Tahun dalam Bahasa Indonesia
     * Contoh: 2025-07-01 → "Juli 2025"
     * 
     * @param string $date Tanggal dalam format YYYY-MM-DD
     * @return string Hasil format dalam Bahasa Indonesia atau string asli jika format salah
     */
    function format_indo_date($date)
    {
        // Cek jika tanggal kosong atau invalid
        if (empty($date) || $date == '0000-00-00') return '-';

        // Daftar nama bulan dalam Bahasa Indonesia (array singkat)
        $bulan = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        // Pisahkan komponen tanggal
        $parts = explode('-', $date);
        if (count($parts) != 3) return $date;

        // Ambil bulan dan tahun
        $month_num = (int)$parts[1];
        $tahun = $parts[0];

        // Validasi nomor bulan
        if ($month_num < 1 || $month_num > 12) return $date;

        return $bulan[$month_num - 1] . ' ' . $tahun;
    }
}

// Generate Kode Bayar
if (!function_exists('generate_kode_bayar')) {
    /**
     * Generate formatted nomor
     * @param string $nomor_registrasi
     * @param string|int $no_urut
     * @param string $date (optional, default: today)
     * @return string
     *
     * Format: NomorRegistrasi-YYMM-NoUrut(PAD 3 digit)
     * Example: 31010001-2407-001
     */
    function generate_kode_bayar($nomorKredit = 'xxxxxxxx', $angsKe = 'xxx', $date = null)
    {
        // Ambil tanggal, default hari ini
        $date = $date ? strtotime($date) : time();
        $yy = date('y', $date);
        $mm = date('m', $date);

        // Padding no urut jadi 3 digit
        $angsKe_padded = str_pad($angsKe, 3, '0', STR_PAD_LEFT);

        // Gabungkan format
        return "{$nomorKredit}-{$yy}{$mm}-{$angsKe_padded}";
    }
}

// Fungsi untuk generate number dan bisa custom
if (!function_exists('generate_custom_number')) {
    /**
     * Generator nomor multifungsi dengan berbagai format
     * 
     * @param string $format Format nomor yang diinginkan:
     *   - 'pembayaran': Format pembayaran (contoh: INV-2407-001)
     *   - 'registrasi': Format registrasi (contoh: REG-2024-0001)
     *   - 'acak': Nomor acak (contoh: RND-8A2F4C)
     *   - 'custom': Format custom (gunakan parameter $customFormat)
     * @param array $params Parameter tambahan:
     *   - 'prefix' => Awalan nomor (default: '')
     *   - 'nomor' => Nomor dasar (default: '')
     *   - 'panjang' => Panjang nomor (default: 4)
     *   - 'tanggal' => Tanggal (default: sekarang)
     *   - 'customFormat' => Format custom (untuk tipe 'custom')
     * @return string Nomor yang dihasilkan
     */
    function generate_custom_number($format = 'pembayaran', $params = [])
    {
        // Set default parameter
        $defaults = [
            'prefix' => '',
            'nomor' => '',
            'panjang' => 4,
            'tanggal' => date('Y-m-d'),
            'customFormat' => ''
        ];
        $options = array_merge($defaults, $params);

        // Ekstrak parameter
        $prefix = $options['prefix'];
        $nomor = $options['nomor'];
        $panjang = $options['panjang'];
        $tanggal = strtotime($options['tanggal']);
        $customFormat = $options['customFormat'];

        // Generate berdasarkan format
        switch ($format) {
            case 'pembayaran':
                $tglFormat = date('ym', $tanggal);
                $nomorFormat = str_pad($nomor ?: 1, $panjang, '0', STR_PAD_LEFT);
                return ($prefix ?: 'INV') . "-{$tglFormat}-{$nomorFormat}";

            case 'registrasi':
                $tahun = date('Y', $tanggal);
                $nomorFormat = str_pad($nomor ?: 1, $panjang, '0', STR_PAD_LEFT);
                return ($prefix ?: 'REG') . "-{$tahun}-{$nomorFormat}";

            case 'acak':
                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                $random = '';
                for ($i = 0; $i < $panjang; $i++) {
                    $random .= $chars[rand(0, strlen($chars) - 1)];
                }
                return ($prefix ?: 'RND') . "-{$random}";

            case 'custom':
                $replacements = [
                    '{prefix}' => $prefix,
                    '{nomor}' => str_pad($nomor, $panjang, '0', STR_PAD_LEFT),
                    '{YY}' => date('y', $tanggal),
                    '{MM}' => date('m', $tanggal),
                    '{DD}' => date('d', $tanggal),
                    '{YYYY}' => date('Y', $tanggal)
                ];
                return str_replace(
                    array_keys($replacements),
                    array_values($replacements),
                    $customFormat
                );

            default:
                return str_pad($nomor ?: 1, $panjang, '0', STR_PAD_LEFT);
        }
    }
}

// Label info Status Cair
if (!function_exists('is_status_cair')) {
    /**
     * Mengkonversi status lunas (Y/N) ke berbagai format tampilan
     * 
     * @param string $status Kode status (Y = Lunas, N = Belum Lunas)
     * @param string $format Format output yang diinginkan:
     *   - 'label' => Label dengan warna (Bootstrap style)
     *   - 'text' => Text biasa
     *   - 'icon' => Icon Font Awesome
     *   - 'badge' => Badge dengan warna
     * @param array $custom Custom label (opsional):
     *   - 'lunas' => Text untuk status Y
     *   - 'belum' => Text untuk status N
     * @return string Output sesuai format
     * 
     * echo status_lunas('Y', 'text', ['lunas' => 'Fully Paid']);
     * // Output: Fully Paid
     * echo status_lunas('N', 'text', ['belum' => 'In Process']);
     * // Output: In Process
     */
    function is_status_cair($status, $format = 'text', $custom = [])
    {
        // Default label
        $labels = [
            'cair' => $custom['lunas'] ?? 'Disetujui',
            'belumcair' => $custom['belum'] ?? 'Belum Disetujui'
        ];

        // Data untuk berbagai format
        $formats = [
            'Y' => [ // Sudah Cair
                'text' => $labels['cair'],
                'label' => '<span class="label label-success">' . $labels['cair'] . '</span>',
                'badge' => '<span class="badge bg-success">' . $labels['cair'] . '</span>',
                'icon' => '<i class="fas fa-check-circle text-success"></i> ' . $labels['cair']
            ],
            'N' => [ // Belum Cair
                'text' => $labels['belumcair'],
                'label' => '<span class="label label-warning">' . $labels['belumcair'] . '</span>',
                'badge' => '<span class="badge bg-warning">' . $labels['belumcair'] . '</span>',
                'icon' => '<i class="fas fa-clock text-warning"></i> ' . $labels['belumcair']
            ]
        ];

        $status = strtoupper((string)$status); // Konversi ke uppercase dan string

        // Return format yang diminta, default ke text jika format tidak ada
        return $formats[$status][$format] ?? $formats[$status]['text'] ?? 'Status Tidak Valid';
    }
}

// Label Info Status Bayar Angsuran
if (!function_exists('is_status_bayar')) {
    /**
     * Mengkonversi status pembayaran (1/0) ke berbagai format tampilan
     * 
     * @param int $status Kode status (1 = sudah bayar, 0 = belum bayar)
     * @param string $format Format output yang diinginkan:
     *   - 'label' => Label dengan warna (Bootstrap style)
     *   - 'text' => Text biasa
     *   - 'icon' => Icon Font Awesome
     *   - 'badge' => Badge dengan warna
     * @param array $custom Custom label (opsional):
     *   - 'paid' => Text untuk status sudah bayar
     *   - 'unpaid' => Text untuk status belum bayar
     * @return string Output sesuai format
     */
    function is_status_bayar($status, $format = 'text', $custom = [])
    {
        // Default label
        $labels = [
            'paid' => $custom['paid'] ?? 'Sudah Bayar',
            'unpaid' => $custom['unpaid'] ?? 'Belum Bayar'
        ];

        // Data untuk berbagai format
        $formats = [
            '1' => [ // Sudah Bayar
                'text' => $labels['paid'],
                'label' => '<span class="label label-success">' . $labels['paid'] . '</span>',
                'badge' => '<span class="badge bg-success">' . $labels['paid'] . '</span>',
                'icon' => '<i class="fas fa-check-circle text-success"></i> ' . $labels['paid'],
                'addclass' => 'sp7-bg-green-light'
            ],
            '0' => [ // Belum Bayar
                'text' => $labels['unpaid'],
                'label' => '<span class="label label-danger">' . $labels['unpaid'] . '</span>',
                'badge' => '<span class="badge bg-danger">' . $labels['unpaid'] . '</span>',
                'icon' => '<i class="fas fa-times-circle text-danger"></i> ' . $labels['unpaid'],
                'addclass' => 'sp7-bg-red-light'
            ]
        ];

        $status = (string)$status; // Konversi ke string untuk key array

        // Return format yang diminta, default ke text jika format tidak ada
        return $formats[$status][$format] ?? $formats[$status]['text'];
    }
}

// Label info Status Lunas
if (!function_exists('is_status_lunas')) {
    /**
     * Mengkonversi status lunas (Y/N) ke berbagai format tampilan
     * 
     * @param string $status Kode status (Y = Lunas, N = Belum Lunas)
     * @param string $format Format output yang diinginkan:
     *   - 'label' => Label dengan warna (Bootstrap style)
     *   - 'text' => Text biasa
     *   - 'icon' => Icon Font Awesome
     *   - 'badge' => Badge dengan warna
     * @param array $custom Custom label (opsional):
     *   - 'lunas' => Text untuk status Y
     *   - 'belum' => Text untuk status N
     * @return string Output sesuai format
     * 
     * echo status_lunas('Y', 'text', ['lunas' => 'Fully Paid']);
     * // Output: Fully Paid
     * echo status_lunas('N', 'text', ['belum' => 'In Process']);
     * // Output: In Process
     */
    function is_status_lunas($status, $format = 'text', $custom = [])
    {
        // Default label
        $labels = [
            'lunas' => $custom['lunas'] ?? 'Lunas',
            'belum' => $custom['belum'] ?? 'Belum Lunas'
        ];

        // Data untuk berbagai format
        $formats = [
            'Y' => [ // Lunas
                'text' => $labels['lunas'],
                'label' => '<span class="label label-success">' . $labels['lunas'] . '</span>',
                'badge' => '<span class="badge bg-success">' . $labels['lunas'] . '</span>',
                'icon' => '<i class="fas fa-check-circle text-success"></i> ' . $labels['lunas']
            ],
            'N' => [ // Belum Lunas
                'text' => $labels['belum'],
                'label' => '<span class="label label-warning">' . $labels['belum'] . '</span>',
                'badge' => '<span class="badge bg-warning">' . $labels['belum'] . '</span>',
                'icon' => '<i class="fas fa-clock text-warning"></i> ' . $labels['belum']
            ]
        ];

        $status = strtoupper((string)$status); // Konversi ke uppercase dan string

        // Return format yang diminta, default ke text jika format tidak ada
        return $formats[$status][$format] ?? $formats[$status]['text'] ?? 'Status Tidak Valid';
    }
}

// Label info status pinjaman
if (!function_exists('is_status_pinjaman')) {
    function is_status_pinjaman($status, $format = 'text', $custom = [])
    {
        // Default label with corrected spelling
        $labels = [
            'aktif' => $custom['aktif'] ?? 'Pinjaman Aktif', // Fixed typo "AKtif" to "Aktif"
            'tidakaktif' => $custom['tidakaktif'] ?? 'Pinjaman Tidak Aktif'
        ];

        // Data untuk berbagai format
        $formats = [
            'AKTIF' => [ // Key in uppercase to match your strtoupper conversion
                'text' => $labels['aktif'],
                'label' => '<span class="label label-success">' . $labels['aktif'] . '</span>',
                'badge' => '<span class="badge bg-success">' . $labels['aktif'] . '</span>',
                'icon' => '<i class="fas fa-check-circle text-success"></i> ' . $labels['aktif']
            ],
            'TIDAK AKTIF' => [ // Key in uppercase to match your strtoupper conversion
                'text' => $labels['tidakaktif'],
                'label' => '<span class="label label-warning">' . $labels['tidakaktif'] . '</span>',
                'badge' => '<span class="badge bg-warning">' . $labels['tidakaktif'] . '</span>',
                'icon' => '<i class="fas fa-clock text-warning"></i> ' . $labels['tidakaktif'] // Fixed variable name
            ]
        ];

        $status = strtoupper(trim((string)$status)); // Added trim() to remove whitespace

        // Return format yang diminta
        return $formats[$status][$format] ?? $formats[$status]['text'] ?? 'Status Tidak Valid';
    }
}

// Format Alamat
if (!function_exists('format_alamat_debitur')) {
    /**
     * Format alamat lengkap debitur
     *
     * @param object $row Data object debitur (berisi field alamat)
     * @return string HTML string alamat lengkap
     */
    function format_alamat_debitur($row)
    {
        $alamat = $row->ALAMAT;

        if (!empty($row->RTRW)) {
            $alamat .= ' RT/RW ' . $row->RTRW . '<br>';
        } else {
            $alamat .= '<br>';
        }

        $alamat .= $row->KELURAHAN;
        $alamat .= ', ' . $row->KECAMATAN;
        $alamat .= ', ' . $row->KABKOT;
        $alamat .= ', ' . $row->PROVINISI;

        return $alamat;
    }
}

// Masking Identitas NIK
if (!function_exists('masking_nik')) {
    function masking_nik($nik)
    {
        return substr($nik, 0, 6) . str_repeat('*', 6) . substr($nik, -4);
    }
}

// Msking tanggal lahir
if (!function_exists('masking_tanggal_lahir')) {
    /**
     * Mask sebagian tanggal lahir untuk keperluan privasi
     *
     * @param string $tanggal Format Y-m-d atau d-m-Y
     * @param string $mode Pilihan: 'tahun', 'tanggal', 'full'
     * @return string
     */
    function masking_tanggal_lahir($tanggal, $mode = 'tahun')
    {
        if (!$tanggal || $tanggal === '0000-00-00') return '-';

        // Coba deteksi format Y-m-d atau d-m-Y
        if (strpos($tanggal, '-') !== false) {
            $parts = explode('-', $tanggal);

            if (strlen($parts[0]) === 4) {
                // Format: Y-m-d
                list($y, $m, $d) = $parts;
            } else {
                // Format: d-m-Y
                list($d, $m, $y) = $parts;
            }
        } else {
            return $tanggal;
        }

        switch ($mode) {
            case 'tanggal':
                return '**-' . $m . '-' . $y;
            case 'full':
                return '**-**-****';
            case 'tahun':
            default:
                return $d . '-' . $m . '-****';
        }
    }
}

// Membuat format kode dengan prefix dan padding angka menggunakan str_pad.
if (!function_exists('format_kode_prefix')) {
    /**
     * Membuat format kode dengan prefix dan padding angka menggunakan str_pad.
     *
     * Contoh:
     *   format_kode_prefix('KP', 2, 4); → KP0002
     *
     * @param string $prefix Prefix huruf seperti 'KP', 'REG', dll
     * @param int $number Nomor urut / ID yang akan diproses
     * @param int $padLength Jumlah total digit angka (default 4 = '0002')
     * @return string Kode hasil gabungan prefix + angka yang dipad
     */
    function format_kode_prefix($prefix, $number, $padLength = 4)
    {
        $paddedNumber = str_pad($number, $padLength, '0', STR_PAD_LEFT);
        return $prefix . $paddedNumber;
    }
}
