<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use GuzzleHttp\Client;

/**
 * Class MYFonnte
 *
 * Class ini digunakan untuk mengirim pesan menggunakan API Fonnte.
 */
class MY_FonnteInterface
{
    protected $ci;
    protected $client;

    /**
     * Konstruktor untuk class MYFonnte
     *
     * Menginisialisasi instance CodeIgniter dan Guzzle Client.
     */
    public function __construct()
    {
        // Mendapatkan instance CodeIgniter
        $this->ci = &get_instance();
        // Inisialisasi Guzzle Client
        $this->client = new Client();
    }

    /**
     * Mengirim pesan menggunakan cURL
     *
     * @param string $target Nomor tujuan pesan
     * @param string $message Isi pesan yang akan dikirim
     *
     * @return array Array yang berisi respons dari API dan status HTTP
     *
     * @note Menggunakan fungsi cURL bawaan PHP untuk mengirimkan permintaan HTTP.
     * Menyiapkan berbagai opsi cURL, termasuk URL, header, dan data yang dikirim.
     * Menangani respons cURL secara manual, termasuk mendapatkan kode status HTTP.
     */
    public function sendMessage($target, $message)
    {
        $base_url_api = getAppSettingAPI('fonnte', 'base_url_api');
        $token_key = getAppSettingAPI('fonnte', 'token_key');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $base_url_api,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => $target,
                'message' => $message,
                'delay' => 10,
                'countryCode' => '62'
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . $token_key
            ),
        ));

        $response = curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        // Decode response dari JSON ke array
        $response_array = json_decode($response, true);

        // Tambahkan status HTTP code ke array respons
        $response_array['http_code'] = $http_code;

        return $response_array;
    }

    /**
     * Mengirim pesan menggunakan Guzzle
     *
     * @param string $target Nomor tujuan pesan
     * @param string $message Isi pesan yang akan dikirim
     *
     * @return array Array yang berisi respons dari API dan status HTTP atau pesan kesalahan
     *
     * @note Menggunakan Guzzle, sebuah library HTTP client yang lebih modern dan mudah digunakan untuk mengirim permintaan HTTP.
     * Menyederhanakan proses pengaturan header dan data yang dikirim menggunakan form_params.
     * Penanganan respons lebih sederhana, dan Guzzle menyediakan cara mudah untuk menangani kesalahan melalui pengecualian (exception).
     */
    public function requestSendMessage($target, $message)
    {
        $base_url_api = getAppSettingAPI('fonnte', 'base_url_api');
        $token_key = getAppSettingAPI('fonnte', 'token_key');

        try {
            $response = $this->client->post($base_url_api, [
                'headers' => [
                    'Authorization' => $token_key
                ],
                'form_params' => [
                    'target' => $target,
                    'message' => $message,
                    'delay' => 10,
                    'countryCode' => '62'
                ]
            ]);

            $responseBody = $response->getBody()->getContents();
            $responseArray = json_decode($responseBody, true);
            $responseArray['http_code'] = $response->getStatusCode();

            return $responseArray;
        } catch (GuzzleHttp\Exception\RequestException $e) {
            return [
                'error' => $e->getMessage(),
                'http_code' => $e->getResponse()->getStatusCode()
            ];
        }
    }
}
