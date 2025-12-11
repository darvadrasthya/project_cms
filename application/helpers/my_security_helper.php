<?php

// Fungsi untuk mencegah percobaan intercept menggunakan alat seperti Burp Suite.
if (!function_exists('prevent_intercept')) {
    function prevent_intercept()
    {
        // Dapatkan instance CodeIgniter
        $CI = &get_instance();

        // Cek User-Agent
        $user_agent = $CI->input->user_agent();

        // Daftar User-Agent yang mencurigakan
        $suspicious_agents = [
            'Burp', 'Zap', 'Fiddler', 'Proxy', 'PostmanRuntime', 'Python', 'Java'
        ];

        foreach ($suspicious_agents as $agent) {
            if (stripos($user_agent, $agent) !== false) {
                show_error('Access denied. Suspicious activity detected.', 403);
                exit;
            }
        }

        // Cek apakah header mencurigakan (proxy tools sering menambahkan header tertentu)
        $headers = $CI->input->request_headers();

        if (isset($headers['X-Forwarded-For']) || isset($headers['X-ProxyUser-IP'])) {
            show_error('Access denied. Proxy usage detected.', 403);
            exit;
        }

        // Cek metode akses (contoh untuk deteksi direct access)
        if (empty($_SERVER['HTTP_REFERER']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            show_error('Access denied. Direct request detected.', 403);
            exit;
        }

        // Cek pola request berulang yang mencurigakan
        $ip_address = $CI->input->ip_address();
        $rate_limit_key = 'rate_limit_' . $ip_address;

        // Menggunakan session untuk melacak aktivitas per IP
        $rate_limit = $CI->session->userdata($rate_limit_key) ?? 0;
        $CI->session->set_userdata($rate_limit_key, $rate_limit + 1);

        if ($rate_limit > 25) { // Atur batas request sesuai kebutuhan
            show_error('Access denied. Rate limit exceeded.', 429);
            exit;
        }
    }
}

if (!function_exists('checking_csrf')) {
    function checking_csrf()
    {
        $ci = get_instance();

        // Ambil token dari POST dan session
        $token_post = $ci->input->post('_token');
        $token_session = $ci->session->csrf_token;

        // Validasi token
        if (!$token_post || !$token_session || $token_post !== $token_session) {
            $ci->session->unset_userdata('csrf_token');
            $ci->output->set_status_header(403);
            show_error(
                '&#9940; Token tidak valid <br> &#9940; IP address Anda telah dicatat: ' . $ci->input->ip_address()
            );
            return false;
        }

        // Perbarui token setelah diverifikasi
        regenerate_csrf_token();
        return true;
    }
}

if (!function_exists('get_csrf_token')) {
    function get_csrf_token()
    {
        $ci = get_instance();
        if (!$ci->session->csrf_token) {
            regenerate_csrf_token();
        }
        return $ci->session->csrf_token;
    }
}

if (!function_exists('regenerate_csrf_token')) {
    function regenerate_csrf_token()
    {
        $ci = get_instance();
        $ci->session->csrf_token = base64_encode(random_bytes(32));
    }
}

if (!function_exists('get_csrf_token_name')) {
    function get_csrf_token_name()
    {
        return '_token';
    }
}

if (!function_exists('get_csrf_form')) {
    function get_csrf_form()
    {
        return '<input type="hidden" name="' . get_csrf_token_name() . '" value="' . get_csrf_token() . '">';
    }
}

// ----------------------------------
// Secure URL Encryption
// MEnggunakan Metode AES OpenSSL
// ----------------------------------

// Generate a random initialization vector (IV) of specified length.
if (!function_exists('get_rnd_iv')) {
    function get_rnd_iv($iv_len)
    {
        return random_bytes($iv_len); // Use random_bytes for better randomness
    }
}

// Encrypts a plaintext string using AES-CTR and a password.
if (!function_exists('enkrip')) {
    function enkrip($plain_text, $password = 'ridwanpanji')
    {
        // Generate a random IV
        $iv_len = openssl_cipher_iv_length('aes-256-ctr');
        $iv = get_rnd_iv($iv_len);

        // Encrypt the plaintext using AES-CTR
        $encrypted = openssl_encrypt($plain_text, 'aes-256-ctr', $password, OPENSSL_RAW_DATA, $iv);

        // Combine IV and encrypted text for decryption
        $output = $iv . $encrypted;

        // Convert the result to hexadecimal
        return bin2hex($output);
    }
}

// Decrypts an encrypted string using AES-CTR and a password.
if (!function_exists('dekrip')) {
    function dekrip($enc_text, $password = 'ridwanpanji')
    {
        // Validasi panjang string hexadecimal
        if (strlen($enc_text) % 2 !== 0) {
            return false; // Atau throw exception sesuai kebutuhan
        }

        // Convert the hexadecimal encoded string back to binary
        $enc_text = hex2bin($enc_text);

        // Extract the IV and the encrypted text
        $iv_len = openssl_cipher_iv_length('aes-256-ctr');
        $iv = substr($enc_text, 0, $iv_len);
        $encrypted = substr($enc_text, $iv_len);

        // Validasi panjang IV
        if (strlen($iv) !== $iv_len) {
            return false; // IV tidak valid
        }

        // Decrypt the text using AES-CTR
        return openssl_decrypt($encrypted, 'aes-256-ctr', $password, OPENSSL_RAW_DATA, $iv);
    }
}

// ----------------------------------
// Secure ID Enkripsi
// Mengkodekan ID menggunakan metode enkripsi sederhana
// ----------------------------------

// Fungsi ini digunakan untuk baik pengkodean maupun dekodean dengan menyesuaikan operasi berdasarkan offset yang diberikan.
if (!function_exists('transform_id')) {
    /**
     * Mengubah ID dengan menerapkan operasi matematis pada setiap karakter.
     *
     * Fungsi ini digunakan untuk baik pengkodean maupun dekodean dengan menyesuaikan operasi berdasarkan offset yang diberikan.
     *
     * @param string $id ID yang akan diubah.
     * @param int $offset Nilai yang akan ditambahkan (untuk pengkodean) atau dikurangi (untuk dekodean).
     * @return string ID yang telah diubah.
     */
    function transform_id($id, $offset)
    {
        $idChars = str_split($id); // Membagi ID menjadi karakter-karakter individual
        $transformedId = '';

        foreach ($idChars as $char) {
            // Terapkan transformasi dan pastikan hasilnya adalah satu digit
            $transformedChar = ($char + $offset + 10) % 10; // Menambahkan 10 memastikan hasil positif
            $transformedId .= $transformedChar; // Tambahkan karakter yang telah diubah
        }

        return $transformedId; // Kembalikan ID yang telah diubah
    }
}

// Mengkodekan ID menggunakan metode enkripsi sederhana.
if (!function_exists('encode_id')) {
    /**
     * Mengkodekan ID menggunakan metode enkripsi sederhana.
     *
     * Fungsi ini menerima ID sebagai input, membaginya menjadi karakter-karakter individual,
     * dan menerapkan transformasi pada setiap karakter dengan menambahkan 5 dan mengambil hasilnya modulo 10.
     *
     * @param string $id ID yang akan dikodekan.
     * @return string ID yang telah dikodekan.
     */
    function encode_id($id)
    {
        return transform_id($id, 5); // Kodekan ID dengan menambahkan 5
    }
}

// Mendekode ID yang telah dikodekan kembali ke bentuk aslinya.
if (!function_exists('decode_id')) {
    /**
     * Mendekode ID yang telah dikodekan kembali ke bentuk aslinya.
     *
     * Fungsi ini menerima ID yang telah dikodekan sebagai input, membaginya menjadi karakter-karakter individual,
     * dan menerapkan transformasi pada setiap karakter dengan mengurangi 5 dan mengambil hasilnya modulo 10.
     *
     * @param string $encodedId ID yang telah dikodekan untuk didekode.
     * @return string ID asli.
     */
    function decode_id($encodedId)
    {
        return transform_id($encodedId, -5); // Dekode ID dengan mengurangi 5
    }
}

// --------------------------------------------
// Token Hashing
// Generate Token untuk handle Ajax Databtales
// --------------------------------------------

// Mengecek apakah fungsi generate_secure_token sudah ada.
// Jika belum, maka didefinisikan fungsinya.
if (!function_exists('generate_secure_token')) {

    /**
     * Fungsi untuk menghasilkan token acak yang aman.
     *
     * @param int $length Panjang token dalam byte sebelum dikonversi ke heksadesimal.
     * @return string Token acak dalam format heksadesimal.
     */
    function generate_secure_token($length = 32)
    {
        // Menggunakan random_bytes jika tersedia (PHP 7+), sangat aman secara kriptografi
        if (function_exists('random_bytes')) {
            return bin2hex(random_bytes($length));
        }
        // Jika random_bytes tidak tersedia, gunakan openssl_random_pseudo_bytes
        elseif (function_exists('openssl_random_pseudo_bytes')) {
            return bin2hex(openssl_random_pseudo_bytes($length));
        } else {
            // Fallback jika tidak ada fungsi kriptografi yang tersedia
            // Kurang aman, hanya digunakan sebagai jalan terakhir
            $token = '';
            for ($i = 0; $i < $length; $i++) {
                $token .= chr(mt_rand(0, 255)); // Angka acak 0-255 dikonversi ke karakter
            }
            return bin2hex($token); // Konversi token biner ke heksadesimal
        }
    }
}

// Mengecek apakah fungsi validate_secure_token sudah ada.
// Jika belum, maka didefinisikan fungsinya.
if (!function_exists('validate_secure_token')) {

    /**
     * Fungsi untuk memvalidasi apakah token yang diterima cocok dengan token yang disimpan.
     * Perbandingan dilakukan secara aman untuk mencegah timing attacks.
     *
     * @param string $received_token Token yang diterima (biasanya dari user/client).
     * @param string $stored_token Token yang disimpan secara internal/di server.
     * @return bool True jika token cocok, false jika tidak.
     */
    function validate_secure_token($received_token, $stored_token)
    {
        // Validasi input harus berupa string
        if (!is_string($received_token) || !is_string($stored_token)) {
            return false;
        }

        // Gunakan hash_equals jika tersedia (PHP 5.6+), aman dari timing attack
        if (function_exists('hash_equals')) {
            return hash_equals($stored_token, $received_token);
        }

        // Fallback jika hash_equals tidak tersedia
        // Perbandingan dilakukan secara konstan tanpa membeberkan panjang token
        if (strlen($received_token) !== strlen($stored_token)) {
            return false;
        }

        $result = 0;
        for ($i = 0; $i < strlen($received_token); $i++) {
            // XOR antara karakter yang sama posisi dari dua token
            // Disimpan dalam $result agar proses tetap berjalan meski tidak cocok
            $result |= ord($received_token[$i]) ^ ord($stored_token[$i]);
        }

        // Jika semua karakter sama, hasil XOR = 0
        return $result === 0;
    }
}
