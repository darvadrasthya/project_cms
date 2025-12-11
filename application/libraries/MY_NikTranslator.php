<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class NikTranslator
 * 
 * Kelas ini digunakan untuk memproses dan menganalisis NIK (Nomor Induk Kependudukan).
 */
class My_NikTranslator
{
    /**
     * @var object $CI Instance dari CodeIgniter.
     */
    protected $CI;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->CI = &get_instance();
    }

    /**
     * Mendapatkan dua digit terakhir dari tahun saat ini.
     * 
     * @return int Dua digit terakhir dari tahun saat ini.
     * 
     * @example 
     * $year = $translator->getCurrentYear();
     */
    function getCurrentYear()
    {
        return (int)date('y');
    }

    /**
     * Mendapatkan tahun dari NIK.
     * 
     * @param string $nik Nomor Induk Kependudukan.
     * @return int Dua digit tahun dari NIK.
     * 
     * @example 
     * $nikYear = $translator->getNIKYear('1234567890123456');
     */
    function getNIKYear($nik)
    {
        return (int)substr($nik, 10, 2);
    }

    /**
     * Mendapatkan tanggal dari NIK.
     * 
     * @param string $nik Nomor Induk Kependudukan.
     * @return int Tanggal dari NIK.
     * 
     * @example 
     * $date = $translator->getNIKDate('1234567890123456');
     */
    function getNIKDate($nik)
    {
        return (int)substr($nik, 6, 2);
    }

    /**
     * Mendapatkan tanggal penuh dari NIK.
     * 
     * @param string $nik Nomor Induk Kependudukan.
     * @param bool $isFemale Apakah pemilik NIK adalah perempuan.
     * @return string Tanggal dari NIK dengan dua digit.
     * 
     * @example 
     * $dateFull = $translator->getNIKDateFull('1234567890123456', true);
     */
    function getNIKDateFull($nik, $isFemale)
    {
        $date = (int)substr($nik, 6, 2);
        if ($isFemale) $date -= 40;
        return ($date > 10) ? $date : '0' . $date;
    }

    /**
     * Mendapatkan kode pos kecamatan dari NIK.
     * 
     * @param string $nik Nomor Induk Kependudukan.
     * @param array $location Data lokasi.
     * @return array Kode pos kecamatan.
     * 
     * @example 
     * $subdistrictPostalCode = $translator->getSubdistrictPostalCode('1234567890123456', $location);
     */
    function getSubdistrictPostalCode($nik, $location)
    {
        return explode(' -- ', $location['kecamatan'][substr($nik, 0, 6)]);
    }

    /**
     * Mendapatkan provinsi dari NIK.
     * 
     * @param string $nik Nomor Induk Kependudukan.
     * @param array $location Data lokasi.
     * @return string Nama provinsi.
     * 
     * @example 
     * $province = $translator->getProvince('1234567890123456', $location);
     */
    function getProvince($nik, $location)
    {
        return $location['provinsi'][substr($nik, 0, 2)];
    }

    /**
     * Mendapatkan kota dari NIK.
     * 
     * @param string $nik Nomor Induk Kependudukan.
     * @param array $location Data lokasi.
     * @return string Nama kota.
     * 
     * @example 
     * $city = $translator->getCity('1234567890123456', $location);
     */
    function getCity($nik, $location)
    {
        return $location['kabkot'][substr($nik, 0, 4)];
    }

    /**
     * Mendapatkan jenis kelamin dari NIK.
     * 
     * @param int $date Tanggal dari NIK.
     * @return string Jenis kelamin (LAKI-LAKI atau PEREMPUAN).
     * 
     * @example 
     * $gender = $translator->getGender(45);
     */
    function getGender($date)
    {
        return ($date > 40) ? 'PEREMPUAN' : 'LAKI-LAKI';
    }

    /**
     * Mendapatkan bulan lahir dari NIK.
     * 
     * @param string $nik Nomor Induk Kependudukan.
     * @return int Bulan lahir.
     * 
     * @example 
     * $bornMonth = $translator->getBornMonth('1234567890123456');
     */
    function getBornMonth($nik)
    {
        return (int)substr($nik, 8, 2);
    }

    /**
     * Mendapatkan bulan lahir lengkap dari NIK.
     * 
     * @param string $nik Nomor Induk Kependudukan.
     * @return string Bulan lahir dalam dua digit.
     * 
     * @example 
     * $bornMonthFull = $translator->getBornMonthFull('1234567890123456');
     */
    function getBornMonthFull($nik)
    {
        return substr($nik, 8, 2);
    }

    /**
     * Mendapatkan tahun lahir dari NIK.
     * 
     * @param int $nikYear Dua digit tahun dari NIK.
     * @param int $currentYear Dua digit tahun saat ini.
     * @return string Tahun lahir lengkap.
     * 
     * @example 
     * $bornYear = $translator->getBornYear(21, 23);
     */
    function getBornYear($nikYear, $currentYear)
    {
        return ($nikYear < $currentYear)
            ? (($nikYear > 10) ? '20' . $nikYear : '200' . $nikYear)
            : (($nikYear > 10) ? '19' . $nikYear : '190' . $nikYear);
    }

    /**
     * Mendapatkan kode unik dari NIK.
     * 
     * @param string $nik Nomor Induk Kependudukan.
     * @return string Kode unik dari NIK.
     * 
     * @example 
     * $uniqueCode = $translator->getUniqueCode('1234567890123456');
     */
    function getUniqueCode($nik)
    {
        return substr($nik, 12, 4);
    }

    /**
     * Mendapatkan usia dari tanggal lahir.
     * 
     * @param string $birthday Tanggal lahir dalam format YYYY-MM-DD.
     * @return array Usia dalam tahun, bulan, dan hari.
     * 
     * @example 
     * $age = $translator->getAge('2000-01-01');
     */
    function getAge($birthday)
    {
        date_default_timezone_set('Asia/Jakarta');
        $diff = date_diff(date_create($birthday), date_create(date('Y-m-d')));
        return [
            'years' => $diff->y,
            'months' => $diff->m,
            'days' => $diff->d,
        ];
    }

    /**
     * Mendapatkan informasi ulang tahun berikutnya.
     * 
     * @param string $birthday Tanggal lahir dalam format YYYY-MM-DD.
     * @return array Informasi ulang tahun berikutnya dalam teks, tahun, bulan, dan hari.
     * 
     * @example 
     * $nextBirthday = $translator->getNextBirthday('2000-01-01');
     */
    function getNextBirthday($birthday)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = explode('-', date('Y-m-d'));
        $birth = explode('-', $birthday);
        if ($date[1] == $birth[1] && $date[2] <= $birth[2]) $date[0] += 1;

        $births = $date[0] . substr($birthday, -6);
        $diff = date_diff(date_create(date('Y-m-d')), date_create($births));
        $y = ($diff->invert) ? -1 * $diff->y : $diff->y;
        $m = ($diff->invert) ? -1 * $diff->m : $diff->m;
        $d = ($diff->invert) ? -1 * $diff->d : $diff->d;

        $txt = '';
        if ($y != 0) $txt .= "$y tahun ";
        if ($m != 0) $txt .= "$m bulan ";
        if ($d != 0) $txt .= "$d hari ";
        $txt .= 'lagi';

        return [
            'text' => $txt,
            'year' => $y,
            'month' => $m,
            'day' => $d,
        ];
    }

    /**
     * Mendapatkan zodiak dari tanggal dan bulan lahir.
     * 
     * @param int $date Tanggal lahir.
     * @param int $month Bulan lahir.
     * @param bool $isFemale Apakah pemilik NIK adalah perempuan.
     * @return string Zodiak berdasarkan tanggal dan bulan lahir.
     * 
     * @example 
     * $zodiac = $translator->getZodiac(15, 1, false);
     */
    function getZodiac($date, $month, $isFemale)
    {
        if ($isFemale) $date -= 40;
        if (($month == 1 && $date >= 20) || ($month == 2 && $date < 19)) return 'Aquarius';
        if (($month == 2 && $date >= 19) || ($month == 3 && $date < 21)) return 'Pisces';
        if (($month == 3 && $date >= 21) || ($month == 4 && $date < 20)) return 'Aries';
        if (($month == 4 && $date >= 20) || ($month == 5 && $date < 21)) return 'Taurus';
        if (($month == 5 && $date >= 21) || ($month == 6 && $date < 22)) return 'Gemini';
        if (($month == 6 && $date >= 21) || ($month == 7 && $date < 23)) return 'Cancer';
        if (($month == 7 && $date >= 23) || ($month == 8 && $date < 23)) return 'Leo';
        if (($month == 8 && $date >= 23) || ($month == 9 && $date < 23)) return 'Virgo';
        if (($month == 9 && $date >= 23) || ($month == 10 && $date < 24)) return 'Libra';
        if (($month == 10 && $date >= 24) || ($month == 11 && $date < 23)) return 'Scorpio';
        if (($month == 11 && $date >= 23) || ($month == 12 && $date < 22)) return 'Sagitarius';
        if (($month == 12 && $date >= 22) || ($month == 1 && $date < 19)) return 'Capricorn';
        return 'Zodiak tidak ditemukan';
    }

    /**
     * Memproses dan menganalisis NIK.
     * 
     * @param string $nik Nomor Induk Kependudukan.
     * @return array|bool Informasi hasil analisis NIK atau FALSE jika NIK tidak valid.
     * 
     * @example 
     * $result = $translator->parse('1234567890123456');
     */
    function parse($nik)
    {
        $location = $this->getLocationAsset();

        // Check NIK and make sure it is correct
        if ($this->validate($nik)) {
            $currentYear = $this->getCurrentYear();
            $nikYear = $this->getNIKYear($nik);
            $nikDate = $this->getNIKDate($nik);
            $gender = $this->getGender($nikDate);

            $nikDateFull = $this->getNIKDateFull($nik, $gender == 'PEREMPUAN');

            $subdistrictPostalCode = $this->getSubdistrictPostalCode($nik, $location);
            $province = $this->getProvince($nik, $location);
            $city = $this->getCity($nik, $location);
            $subdistrict = $subdistrictPostalCode[0];
            $postalCode = $subdistrictPostalCode[1];

            $bornMonth = $this->getBornMonth($nik);
            $bornMonthFull = $this->getBornMonthFull($nik);
            $bornYear = $this->getBornYear($nikYear, $currentYear);

            $uniqueCode = $this->getUniqueCode($nik);
            $zodiac = $this->getZodiac($nikDate, $bornMonth, $gender == 'PEREMPUAN');
            $age = $this->getAge("$bornYear-$bornMonthFull-$nikDateFull");
            $nextBirthday = $this->getNextBirthday("$bornYear-$bornMonthFull-$nikDateFull");

            return [
                'nik' => $nik ?? '',
                'uniqueCode' => $uniqueCode ?? '',
                'gender' => $gender ?? '',
                'bornDate' => "$nikDateFull-$bornMonthFull-$bornYear" ?? '',
                'age' => [
                    'text' => $age['years'] . ' tahun ' . $age['months'] . ' bulan ' . $age['days'] . ' hari',
                    'year' => $age['years'],
                    'month' => $age['months'],
                    'days' => $age['days']
                ],
                'nextBirthday' => $nextBirthday,
                'zodiac' => $zodiac ?? '',
                'province' => $province ?? '',
                'city' => $city ?? '',
                'subdistrict' => $subdistrict ?? '',
                'postalCode' => $postalCode ?? ''
            ];
        } else {
            return false;
        }
    }

    /**
     * Memvalidasi NIK.
     * 
     * @param string $nik Nomor Induk Kependudukan.
     * @return bool TRUE jika NIK valid, FALSE jika tidak.
     * 
     * @example 
     * $isValid = $translator->validate('1234567890123456');
     */
    function validate($nik)
    {
        $loc = $this->getLocationAsset();
        return strlen($nik) == 16 &&
            $loc['provinsi'][substr($nik, 0, 2)] != null &&
            $loc['kabkot'][substr($nik, 0, 4)] != null &&
            $loc['kecamatan'][substr($nik, 0, 6)] != null;
    }

    /**
     * Memuat data lokasi seperti provinsi, kota, dan kecamatan dari data JSON lokal.
     * 
     * @return array Data lokasi dalam bentuk array.
     * 
     * @example 
     * $locationAsset = $translator->getLocationAsset();
     */
    function getLocationAsset()
    {
        $json_url = base_url('assets/mockup/getNikWilayah.json');
        $result = file_get_contents($json_url);
        return json_decode($result, true);
    }
}
