<?php

/**
 * StatusGiziHelper
 * Kalkulasi status gizi balita berdasarkan standar WHO 2006 (simplified)
 * Menggunakan tabel median & SD untuk BB/U, TB/U, BB/TB
 */

if (!function_exists('hitung_status_gizi')) {
    /**
     * Hitung status gizi balita
     *
     * @param float  $berat_badan  Berat badan dalam kg
     * @param float  $tinggi_badan Tinggi/panjang badan dalam cm
     * @param int    $usia_bulan   Usia dalam bulan (0-60)
     * @param string $jenis_kelamin 'L' (laki) atau 'P' (perempuan)
     * @return array ['status_gizi', 'zscore_bb_u', 'zscore_tb_u', 'zscore_bb_tb', 'keterangan']
     */
    function hitung_status_gizi(float $berat_badan, float $tinggi_badan, int $usia_bulan, string $jenis_kelamin): array
    {
        // Pastikan usia dalam range valid (0-60 bulan)
        $usia_bulan = max(0, min(60, $usia_bulan));
        $gender     = strtoupper($jenis_kelamin) === 'L' ? 'L' : 'P';

        // --- Z-score BB/U ---
        $ref_bbu = get_who_bbu($usia_bulan, $gender);
        $zscore_bb_u = null;
        if ($ref_bbu) {
            $zscore_bb_u = zscore_calc($berat_badan, $ref_bbu['median'], $ref_bbu['sd_minus'], $ref_bbu['sd_plus']);
        }

        // --- Z-score TB/U ---
        $ref_tbu = get_who_tbu($usia_bulan, $gender);
        $zscore_tb_u = null;
        if ($ref_tbu) {
            $zscore_tb_u = zscore_calc($tinggi_badan, $ref_tbu['median'], $ref_tbu['sd_minus'], $ref_tbu['sd_plus']);
        }

        // --- Z-score BB/TB ---
        $ref_bbtb = get_who_bbtb($tinggi_badan, $gender);
        $zscore_bb_tb = null;
        if ($ref_bbtb) {
            $zscore_bb_tb = zscore_calc($berat_badan, $ref_bbtb['median'], $ref_bbtb['sd_minus'], $ref_bbtb['sd_plus']);
        }

        // --- Tentukan Status Gizi berdasarkan z-score ---
        // Prioritas: BB/TB untuk wasting, TB/U untuk stunting
        $status_gizi  = 'normal';
        $keterangan   = 'Status gizi normal.';

        // Gizi Buruk: BB/TB < -3 SD
        if ($zscore_bb_tb !== null && $zscore_bb_tb < -3) {
            $status_gizi = 'gizi_buruk';
            $keterangan  = 'Gizi buruk (BB/TB < -3 SD). Segera rujuk ke fasilitas kesehatan.';
        }
        // Gizi Kurang: BB/TB -3 s/d -2 SD
        elseif ($zscore_bb_tb !== null && $zscore_bb_tb < -2) {
            $status_gizi = 'kurang';
            $keterangan  = 'Gizi kurang (BB/TB -3 s/d -2 SD). Perlu perhatian lebih.';
        }
        // Stunting: TB/U < -2 SD (bisa terjadi meski BB/TB normal)
        elseif ($zscore_tb_u !== null && $zscore_tb_u < -2) {
            $status_gizi = 'stunting';
            $keterangan  = 'Stunting (TB/U < -2 SD). Tinggi badan di bawah standar usia.';
        }
        // Normal
        else {
            $status_gizi = 'normal';
            $keterangan  = 'Status gizi normal.';
        }

        return [
            'status_gizi'  => $status_gizi,
            'zscore_bb_u'  => $zscore_bb_u  !== null ? round($zscore_bb_u, 2)  : null,
            'zscore_tb_u'  => $zscore_tb_u  !== null ? round($zscore_tb_u, 2)  : null,
            'zscore_bb_tb' => $zscore_bb_tb !== null ? round($zscore_bb_tb, 2) : null,
            'keterangan'   => $keterangan,
        ];
    }
}

if (!function_exists('zscore_calc')) {
    /**
     * Hitung Z-score dengan SD yang berbeda untuk atas/bawah (Box-Cox)
     */
    function zscore_calc(float $nilai, float $median, float $sd_minus, float $sd_plus): float
    {
        if ($nilai < $median) {
            return ($nilai - $median) / $sd_minus;
        } else {
            return ($nilai - $median) / $sd_plus;
        }
    }
}

if (!function_exists('get_who_bbu')) {
    /**
     * Referensi WHO 2006 BB/U (Berat Badan per Umur)
     * Format: usia_bulan => [median, sd_minus (SD ke bawah), sd_plus (SD ke atas)]
     * Data diambil dari WHO Child Growth Standards (simplified key values)
     */
    function get_who_bbu(int $usia, string $gender): ?array
    {
        // Tabel WHO BB/U untuk Laki-laki (L) — median & 1 SD (approx ±)
        $bbu_L = [
            0  => ['median'=>3.3,  'sd_minus'=>0.4,  'sd_plus'=>0.4],
            1  => ['median'=>4.5,  'sd_minus'=>0.5,  'sd_plus'=>0.6],
            2  => ['median'=>5.6,  'sd_minus'=>0.6,  'sd_plus'=>0.7],
            3  => ['median'=>6.4,  'sd_minus'=>0.7,  'sd_plus'=>0.8],
            4  => ['median'=>7.0,  'sd_minus'=>0.8,  'sd_plus'=>0.9],
            5  => ['median'=>7.5,  'sd_minus'=>0.8,  'sd_plus'=>0.9],
            6  => ['median'=>7.9,  'sd_minus'=>0.9,  'sd_plus'=>1.0],
            7  => ['median'=>8.3,  'sd_minus'=>0.9,  'sd_plus'=>1.0],
            8  => ['median'=>8.6,  'sd_minus'=>1.0,  'sd_plus'=>1.1],
            9  => ['median'=>8.9,  'sd_minus'=>1.0,  'sd_plus'=>1.1],
            10 => ['median'=>9.2,  'sd_minus'=>1.0,  'sd_plus'=>1.2],
            11 => ['median'=>9.4,  'sd_minus'=>1.1,  'sd_plus'=>1.2],
            12 => ['median'=>9.6,  'sd_minus'=>1.1,  'sd_plus'=>1.3],
            15 => ['median'=>10.3, 'sd_minus'=>1.2,  'sd_plus'=>1.4],
            18 => ['median'=>10.9, 'sd_minus'=>1.3,  'sd_plus'=>1.5],
            21 => ['median'=>11.5, 'sd_minus'=>1.3,  'sd_plus'=>1.6],
            24 => ['median'=>12.1, 'sd_minus'=>1.4,  'sd_plus'=>1.7],
            30 => ['median'=>13.3, 'sd_minus'=>1.5,  'sd_plus'=>1.9],
            36 => ['median'=>14.3, 'sd_minus'=>1.6,  'sd_plus'=>2.1],
            42 => ['median'=>15.3, 'sd_minus'=>1.8,  'sd_plus'=>2.2],
            48 => ['median'=>16.3, 'sd_minus'=>1.9,  'sd_plus'=>2.4],
            54 => ['median'=>17.3, 'sd_minus'=>2.0,  'sd_plus'=>2.6],
            60 => ['median'=>18.3, 'sd_minus'=>2.2,  'sd_plus'=>2.8],
        ];

        // Tabel WHO BB/U untuk Perempuan (P)
        $bbu_P = [
            0  => ['median'=>3.2,  'sd_minus'=>0.4,  'sd_plus'=>0.4],
            1  => ['median'=>4.2,  'sd_minus'=>0.5,  'sd_plus'=>0.5],
            2  => ['median'=>5.1,  'sd_minus'=>0.6,  'sd_plus'=>0.6],
            3  => ['median'=>5.8,  'sd_minus'=>0.6,  'sd_plus'=>0.7],
            4  => ['median'=>6.4,  'sd_minus'=>0.7,  'sd_plus'=>0.8],
            5  => ['median'=>6.9,  'sd_minus'=>0.7,  'sd_plus'=>0.9],
            6  => ['median'=>7.3,  'sd_minus'=>0.8,  'sd_plus'=>0.9],
            7  => ['median'=>7.6,  'sd_minus'=>0.9,  'sd_plus'=>1.0],
            8  => ['median'=>7.9,  'sd_minus'=>0.9,  'sd_plus'=>1.1],
            9  => ['median'=>8.2,  'sd_minus'=>1.0,  'sd_plus'=>1.1],
            10 => ['median'=>8.5,  'sd_minus'=>1.0,  'sd_plus'=>1.2],
            11 => ['median'=>8.7,  'sd_minus'=>1.0,  'sd_plus'=>1.2],
            12 => ['median'=>8.9,  'sd_minus'=>1.1,  'sd_plus'=>1.3],
            15 => ['median'=>9.6,  'sd_minus'=>1.1,  'sd_plus'=>1.4],
            18 => ['median'=>10.2, 'sd_minus'=>1.2,  'sd_plus'=>1.5],
            21 => ['median'=>10.9, 'sd_minus'=>1.3,  'sd_plus'=>1.6],
            24 => ['median'=>11.5, 'sd_minus'=>1.3,  'sd_plus'=>1.7],
            30 => ['median'=>12.8, 'sd_minus'=>1.5,  'sd_plus'=>1.9],
            36 => ['median'=>13.9, 'sd_minus'=>1.6,  'sd_plus'=>2.1],
            42 => ['median'=>15.0, 'sd_minus'=>1.8,  'sd_plus'=>2.3],
            48 => ['median'=>16.1, 'sd_minus'=>1.9,  'sd_plus'=>2.5],
            54 => ['median'=>17.2, 'sd_minus'=>2.1,  'sd_plus'=>2.7],
            60 => ['median'=>18.2, 'sd_minus'=>2.2,  'sd_plus'=>2.9],
        ];

        $table = $gender === 'L' ? $bbu_L : $bbu_P;
        return interpolate_table($table, $usia);
    }
}

if (!function_exists('get_who_tbu')) {
    /**
     * Referensi WHO 2006 TB/U (Tinggi Badan per Umur) dalam cm
     */
    function get_who_tbu(int $usia, string $gender): ?array
    {
        $tbu_L = [
            0  => ['median'=>49.9, 'sd_minus'=>1.9, 'sd_plus'=>1.9],
            1  => ['median'=>54.7, 'sd_minus'=>2.0, 'sd_plus'=>2.0],
            2  => ['median'=>58.4, 'sd_minus'=>2.1, 'sd_plus'=>2.1],
            3  => ['median'=>61.4, 'sd_minus'=>2.2, 'sd_plus'=>2.2],
            4  => ['median'=>63.9, 'sd_minus'=>2.3, 'sd_plus'=>2.3],
            5  => ['median'=>65.9, 'sd_minus'=>2.4, 'sd_plus'=>2.4],
            6  => ['median'=>67.6, 'sd_minus'=>2.5, 'sd_plus'=>2.5],
            9  => ['median'=>72.3, 'sd_minus'=>2.7, 'sd_plus'=>2.7],
            12 => ['median'=>75.7, 'sd_minus'=>2.6, 'sd_plus'=>2.6],
            18 => ['median'=>82.3, 'sd_minus'=>2.8, 'sd_plus'=>2.8],
            24 => ['median'=>87.8, 'sd_minus'=>3.1, 'sd_plus'=>3.1],
            30 => ['median'=>92.7, 'sd_minus'=>3.2, 'sd_plus'=>3.2],
            36 => ['median'=>96.1, 'sd_minus'=>3.4, 'sd_plus'=>3.4],
            48 => ['median'=>103.3,'sd_minus'=>3.7, 'sd_plus'=>3.7],
            60 => ['median'=>110.0,'sd_minus'=>4.0, 'sd_plus'=>4.0],
        ];

        $tbu_P = [
            0  => ['median'=>49.1, 'sd_minus'=>1.9, 'sd_plus'=>1.9],
            1  => ['median'=>53.7, 'sd_minus'=>2.0, 'sd_plus'=>2.0],
            2  => ['median'=>57.1, 'sd_minus'=>2.1, 'sd_plus'=>2.1],
            3  => ['median'=>59.8, 'sd_minus'=>2.2, 'sd_plus'=>2.2],
            4  => ['median'=>62.1, 'sd_minus'=>2.3, 'sd_plus'=>2.3],
            5  => ['median'=>64.0, 'sd_minus'=>2.4, 'sd_plus'=>2.4],
            6  => ['median'=>65.7, 'sd_minus'=>2.5, 'sd_plus'=>2.5],
            9  => ['median'=>70.1, 'sd_minus'=>2.7, 'sd_plus'=>2.7],
            12 => ['median'=>74.0, 'sd_minus'=>2.8, 'sd_plus'=>2.8],
            18 => ['median'=>80.7, 'sd_minus'=>3.0, 'sd_plus'=>3.0],
            24 => ['median'=>86.4, 'sd_minus'=>3.3, 'sd_plus'=>3.3],
            30 => ['median'=>91.4, 'sd_minus'=>3.4, 'sd_plus'=>3.4],
            36 => ['median'=>95.1, 'sd_minus'=>3.6, 'sd_plus'=>3.6],
            48 => ['median'=>102.7,'sd_minus'=>4.0, 'sd_plus'=>4.0],
            60 => ['median'=>109.4,'sd_minus'=>4.3, 'sd_plus'=>4.3],
        ];

        $table = $gender === 'L' ? $tbu_L : $tbu_P;
        return interpolate_table($table, $usia);
    }
}

if (!function_exists('get_who_bbtb')) {
    /**
     * Referensi WHO 2006 BB/TB (Berat Badan per Tinggi Badan)
     * Keyed by tinggi badan (cm), ambil yang terdekat
     */
    function get_who_bbtb(float $tinggi, string $gender): ?array
    {
        // Simplified lookup: cari nilai terdekat dari tabel 45-120cm
        $bbtb_L = [
            45 => ['median'=>2.4,  'sd_minus'=>0.3, 'sd_plus'=>0.3],
            50 => ['median'=>3.4,  'sd_minus'=>0.4, 'sd_plus'=>0.4],
            55 => ['median'=>4.5,  'sd_minus'=>0.5, 'sd_plus'=>0.5],
            60 => ['median'=>5.7,  'sd_minus'=>0.6, 'sd_plus'=>0.6],
            65 => ['median'=>7.1,  'sd_minus'=>0.7, 'sd_plus'=>0.8],
            70 => ['median'=>8.3,  'sd_minus'=>0.8, 'sd_plus'=>0.9],
            75 => ['median'=>9.3,  'sd_minus'=>0.9, 'sd_plus'=>1.0],
            80 => ['median'=>10.2, 'sd_minus'=>1.0, 'sd_plus'=>1.1],
            85 => ['median'=>11.1, 'sd_minus'=>1.1, 'sd_plus'=>1.2],
            90 => ['median'=>12.0, 'sd_minus'=>1.2, 'sd_plus'=>1.4],
            95 => ['median'=>13.0, 'sd_minus'=>1.3, 'sd_plus'=>1.5],
            100=> ['median'=>14.0, 'sd_minus'=>1.4, 'sd_plus'=>1.7],
            105=> ['median'=>15.2, 'sd_minus'=>1.6, 'sd_plus'=>1.8],
            110=> ['median'=>16.4, 'sd_minus'=>1.7, 'sd_plus'=>2.1],
            115=> ['median'=>17.7, 'sd_minus'=>1.9, 'sd_plus'=>2.3],
            120=> ['median'=>19.1, 'sd_minus'=>2.1, 'sd_plus'=>2.6],
        ];

        $bbtb_P = [
            45 => ['median'=>2.5,  'sd_minus'=>0.3, 'sd_plus'=>0.3],
            50 => ['median'=>3.4,  'sd_minus'=>0.4, 'sd_plus'=>0.4],
            55 => ['median'=>4.5,  'sd_minus'=>0.5, 'sd_plus'=>0.5],
            60 => ['median'=>5.7,  'sd_minus'=>0.6, 'sd_plus'=>0.6],
            65 => ['median'=>7.0,  'sd_minus'=>0.7, 'sd_plus'=>0.8],
            70 => ['median'=>8.2,  'sd_minus'=>0.8, 'sd_plus'=>1.0],
            75 => ['median'=>9.2,  'sd_minus'=>0.9, 'sd_plus'=>1.1],
            80 => ['median'=>10.1, 'sd_minus'=>1.0, 'sd_plus'=>1.2],
            85 => ['median'=>11.1, 'sd_minus'=>1.1, 'sd_plus'=>1.3],
            90 => ['median'=>12.1, 'sd_minus'=>1.2, 'sd_plus'=>1.5],
            95 => ['median'=>13.2, 'sd_minus'=>1.3, 'sd_plus'=>1.7],
            100=> ['median'=>14.3, 'sd_minus'=>1.5, 'sd_plus'=>1.9],
            105=> ['median'=>15.5, 'sd_minus'=>1.6, 'sd_plus'=>2.1],
            110=> ['median'=>16.9, 'sd_minus'=>1.8, 'sd_plus'=>2.3],
            115=> ['median'=>18.3, 'sd_minus'=>2.0, 'sd_plus'=>2.6],
            120=> ['median'=>19.9, 'sd_minus'=>2.2, 'sd_plus'=>2.9],
        ];

        $table = $gender === 'L' ? $bbtb_L : $bbtb_P;

        // Ambil nilai terdekat
        $keys = array_keys($table);
        $closest = null;
        $minDiff = PHP_INT_MAX;
        foreach ($keys as $k) {
            $diff = abs($tinggi - $k);
            if ($diff < $minDiff) {
                $minDiff  = $diff;
                $closest  = $k;
            }
        }
        return $closest !== null ? $table[$closest] : null;
    }
}

if (!function_exists('interpolate_table')) {
    /**
     * Interpolasi linear antar dua titik data terdekat dalam tabel
     */
    function interpolate_table(array $table, int $usia): ?array
    {
        if (isset($table[$usia])) {
            return $table[$usia];
        }

        $keys = array_keys($table);
        sort($keys);

        // Cari batas bawah & atas
        $lower = null;
        $upper = null;
        foreach ($keys as $k) {
            if ($k <= $usia) { $lower = $k; }
            if ($k >= $usia && $upper === null) { $upper = $k; }
        }

        if ($lower === null && $upper !== null) return $table[$upper];
        if ($upper === null && $lower !== null) return $table[$lower];
        if ($lower === null && $upper === null) return null;
        if ($lower === $upper) return $table[$lower];

        // Interpolasi
        $ratio  = ($usia - $lower) / ($upper - $lower);
        $lo     = $table[$lower];
        $hi     = $table[$upper];

        return [
            'median'   => $lo['median']   + ($hi['median']   - $lo['median'])   * $ratio,
            'sd_minus' => $lo['sd_minus'] + ($hi['sd_minus'] - $lo['sd_minus']) * $ratio,
            'sd_plus'  => $lo['sd_plus']  + ($hi['sd_plus']  - $lo['sd_plus'])  * $ratio,
        ];
    }
}

if (!function_exists('label_status_gizi')) {
    /**
     * Ambil label display-friendly dari kode status gizi
     */
    function label_status_gizi(string $status): string
    {
        return match($status) {
            'normal'     => 'Normal',
            'kurang'     => 'Gizi Kurang',
            'stunting'   => 'Stunting',
            'gizi_buruk' => 'Gizi Buruk',
            default      => ucfirst($status),
        };
    }
}

if (!function_exists('badge_status_gizi')) {
    /**
     * Badge HTML untuk status gizi
     */
    function badge_status_gizi(string $status): string
    {
        $map = [
            'normal'     => ['success',  'Normal'],
            'kurang'     => ['warning',  'Gizi Kurang'],
            'stunting'   => ['orange',   'Stunting'],
            'gizi_buruk' => ['danger',   'Gizi Buruk'],
        ];
        $cfg = $map[$status] ?? ['secondary', ucfirst($status)];
        $color = $cfg[0];
        $label = $cfg[1];
        if ($color === 'orange') {
            return "<span class=\"badge\" style=\"background:#f97316;color:#fff;\">{$label}</span>";
        }
        return "<span class=\"badge badge-{$color}\">{$label}</span>";
    }
}

if (!function_exists('hitung_umur_bulan')) {
    /**
     * Hitung usia dalam bulan dari tanggal lahir sampai hari ini
     *
     * @param string $tanggal_lahir Format Y-m-d
     * @return int Usia dalam bulan
     */
    function hitung_umur_bulan(string $tanggal_lahir): int
    {
        $lahir = new \DateTime($tanggal_lahir);
        $now   = new \DateTime();
        $diff  = $lahir->diff($now);
        return ($diff->y * 12) + $diff->m;
    }
}

if (!function_exists('hitung_status_gizi_detail')) {
    /**
     * Wrapper hitung_status_gizi yang mengembalikan format detail per indikator
     * Dipakai oleh IbuHamilController sub-tabel anak
     *
     * @return array ['bb_u' => ['status','zscore'], 'tb_u' => [...], 'bb_tb' => [...]]
     */
    function hitung_status_gizi_detail(float $berat, float $tinggi, int $usia_bulan, string $jk): array
    {
        $result = hitung_status_gizi($berat, $tinggi, $usia_bulan, $jk);

        // Tentukan status per indikator
        $zBBU  = $result['zscore_bb_u'];
        $zTBU  = $result['zscore_tb_u'];
        $zBBTB = $result['zscore_bb_tb'];

        $statusBBU = 'Normal';
        if ($zBBU !== null) {
            if ($zBBU < -3) $statusBBU = 'BB Sangat Kurang';
            elseif ($zBBU < -2) $statusBBU = 'BB Kurang';
            elseif ($zBBU > 2) $statusBBU = 'BB Lebih';
        }

        $statusTBU = 'Normal';
        if ($zTBU !== null) {
            if ($zTBU < -3) $statusTBU = 'Sangat Pendek';
            elseif ($zTBU < -2) $statusTBU = 'Pendek';
            elseif ($zTBU > 2) $statusTBU = 'Tinggi';
        }

        $statusBBTB = 'Normal';
        if ($zBBTB !== null) {
            if ($zBBTB < -3) $statusBBTB = 'Gizi Buruk';
            elseif ($zBBTB < -2) $statusBBTB = 'Gizi Kurang';
            elseif ($zBBTB > 2) $statusBBTB = 'Gizi Lebih';
        }

        return [
            'bb_u'  => ['status' => $statusBBU,  'zscore' => $zBBU],
            'tb_u'  => ['status' => $statusTBU,  'zscore' => $zTBU],
            'bb_tb' => ['status' => $statusBBTB, 'zscore' => $zBBTB],
        ];
    }
}

