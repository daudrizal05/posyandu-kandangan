<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
      try {
        $db = \Config\Database::connect();
        
        $currentMonth = date('m');
        $currentYear = date('Y');
        $lastMonth = date('m', strtotime('-1 month'));
        $lastMonthYear = date('Y', strtotime('-1 month'));

        // Helper function for trends based on created_at
        $getTrend = function($table) use ($db, $currentMonth, $currentYear, $lastMonth, $lastMonthYear) {
            if (!$db->tableExists($table) || !$db->fieldExists('created_at', $table)) return ['current' => 0, 'last' => 0];
            $current = $db->query("SELECT COUNT(*) as total FROM $table WHERE EXTRACT(MONTH FROM created_at) = ? AND EXTRACT(YEAR FROM created_at) = ?", [$currentMonth, $currentYear])->getRow()->total;
            $last = $db->query("SELECT COUNT(*) as total FROM $table WHERE EXTRACT(MONTH FROM created_at) = ? AND EXTRACT(YEAR FROM created_at) = ?", [$lastMonth, $lastMonthYear])->getRow()->total;
            return ['current' => $current, 'last' => $last];
        };

        $formatTrend = function($data) {
            $diff = $data['current'] - $data['last'];
            if ($diff > 0) return "+$diff dari bulan lalu";
            if ($diff < 0) return "$diff dari bulan lalu";
            if ($data['current'] == 0 && $data['last'] == 0) return "0 data - mulai tambahkan";
            return "Tidak ada perubahan";
        };

        // 1. Data Kesehatan
        $totalPosyandu = $db->tableExists('posyandu') ? $db->table('posyandu')->where('status', 'aktif')->countAllResults() : 0;
        $trendPosyandu = $formatTrend($getTrend('posyandu'));

        $totalBalita = $db->tableExists('balita') ? $db->table('balita')->countAllResults() : 0;
        $trendBalita = $formatTrend($getTrend('balita'));

        $totalIbuHamil = $db->tableExists('pengukuran') ? $db->table('pengukuran')->countAllResults() : 0;
        // Trend Ibu Hamil / Pengukuran (using tanggal_pengukuran)
        if ($db->tableExists('pengukuran') && $db->fieldExists('tanggal_pengukuran', 'pengukuran')) {
            $cPengukuran = $db->query("SELECT COUNT(*) as total FROM pengukuran WHERE EXTRACT(MONTH FROM tanggal_pengukuran) = ? AND EXTRACT(YEAR FROM tanggal_pengukuran) = ?", [$currentMonth, $currentYear])->getRow()->total;
            $lPengukuran = $db->query("SELECT COUNT(*) as total FROM pengukuran WHERE EXTRACT(MONTH FROM tanggal_pengukuran) = ? AND EXTRACT(YEAR FROM tanggal_pengukuran) = ?", [$lastMonth, $lastMonthYear])->getRow()->total;
            $trendIbuHamil = $formatTrend(['current' => $cPengukuran, 'last' => $lPengukuran]);
        } else {
            $trendIbuHamil = "0 data - mulai tambahkan";
        }

        $totalLansia = $db->tableExists('lansia') ? $db->table('lansia')->countAllResults() : 0;
        $trendLansia = $formatTrend($getTrend('lansia'));

        $totalDataIbuHamil = $db->tableExists('ibu_hamil') ? $db->table('ibu_hamil')->countAllResults() : 0;
        $trendDataIbuHamil = $formatTrend($getTrend('ibu_hamil'));

        $totalRemaja = $db->tableExists('remaja') ? $db->table('remaja')->countAllResults() : 0;
        $trendRemaja = $formatTrend($getTrend('remaja'));

        $totalUsiaProduktif = $db->tableExists('usia_produktif') ? $db->table('usia_produktif')->countAllResults() : 0;
        $trendUsiaProduktif = $formatTrend($getTrend('usia_produktif'));

        // 2. Konten Website
        $totalBerita = $db->tableExists('berita') ? $db->table('berita')->countAllResults() : 0;
        $trendBerita = $formatTrend($getTrend('berita'));

        $totalGaleri = $db->tableExists('galeri') ? $db->table('galeri')->countAllResults() : 0;
        $trendGaleri = $formatTrend($getTrend('galeri'));

        $totalDokumen = $db->tableExists('download') ? $db->table('download')->countAllResults() : 0;
        $trendDokumen = $formatTrend($getTrend('download'));

        // 3. Aktivitas & Laporan
        $totalPesan = 0;
        if ($db->tableExists('kontak_pesan')) {
            try {
                $totalPesan = $db->table('kontak_pesan')->where('status_baca', 'false')->countAllResults();
            } catch (\Throwable $e) {
                $totalPesan = $db->table('kontak_pesan')->countAllResults();
            }
        }
        $trendPesan = $formatTrend($getTrend('kontak_pesan'));
        
        $totalUser = $db->tableExists('users') ? $db->table('users')->countAllResults() : 0;
        $trendUser = $formatTrend($getTrend('users'));

        // ==========================================
        // CHARTS DATA
        // ==========================================
        $chartGiziLabels = ['Normal', 'Kurang', 'Stunting', 'Gizi Buruk'];
        $chartGiziData = [0, 0, 0, 0];
        $trendLabels = [];
        $trendData = [];

        if ($db->tableExists('pengukuran')) {
            // Pie Chart - Status Gizi
            $queryStatusGizi = "
                SELECT p.status_gizi, COUNT(p.id) as total
                FROM pengukuran p
                INNER JOIN (
                    SELECT balita_id, MAX(tanggal_pengukuran) as max_tanggal
                    FROM pengukuran
                    GROUP BY balita_id
                ) latest ON p.balita_id = latest.balita_id AND p.tanggal_pengukuran = latest.max_tanggal
                GROUP BY p.status_gizi
            ";
            $statusGiziData = $db->query($queryStatusGizi)->getResultArray();
            foreach ($statusGiziData as $row) {
                if ($row['status_gizi'] == 'normal') $chartGiziData[0] = $row['total'];
                if ($row['status_gizi'] == 'kurang') $chartGiziData[1] = $row['total'];
                if ($row['status_gizi'] == 'stunting') $chartGiziData[2] = $row['total'];
                if ($row['status_gizi'] == 'gizi_buruk') $chartGiziData[3] = $row['total'];
            }

            // Line Chart - Tren Pengukuran (6 bulan)
            for ($i = 5; $i >= 0; $i--) {
                $m = date('m', strtotime("-$i months"));
                $y = date('Y', strtotime("-$i months"));
                $mName = date('M Y', strtotime("-$i months"));
                $trendLabels[] = $mName;
                
                $res = $db->query("SELECT COUNT(*) as total FROM pengukuran WHERE EXTRACT(MONTH FROM tanggal_pengukuran) = ? AND EXTRACT(YEAR FROM tanggal_pengukuran) = ?", [$m, $y])->getRow();
                $trendData[] = $res ? $res->total : 0;
            }
        }

        // ==========================================
        // RECENT ACTIVITIES (Aktivitas Terbaru)
        // ==========================================
        $activities = [];
        
        if ($db->tableExists('balita') && $db->fieldExists('created_at', 'balita')) {
            $balitaActs = $db->query("SELECT 'Data Balita baru ditambahkan' as text, created_at FROM balita WHERE created_at IS NOT NULL ORDER BY created_at DESC LIMIT 5")->getResultArray();
            $activities = array_merge($activities, $balitaActs);
        }
        if ($db->tableExists('kontak_pesan') && $db->fieldExists('created_at', 'kontak_pesan')) {
            $pesanActs = $db->query("SELECT 'Pesan masuk dari ' || nama as text, created_at FROM kontak_pesan WHERE created_at IS NOT NULL ORDER BY created_at DESC LIMIT 5")->getResultArray();
            $activities = array_merge($activities, $pesanActs);
        }
        if ($db->tableExists('berita') && $db->fieldExists('created_at', 'berita')) {
            $beritaActs = $db->query("SELECT 'Berita ' || judul || ' dipublikasikan' as text, created_at FROM berita WHERE created_at IS NOT NULL ORDER BY created_at DESC LIMIT 5")->getResultArray();
            $activities = array_merge($activities, $beritaActs);
        }
        
        // Sort by created_at desc
        usort($activities, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });
        
        // Format time ago and slice to 5
        $recentActivities = [];
        foreach (array_slice($activities, 0, 5) as $act) {
            $timeAgo = $this->timeElapsedString($act['created_at']);
            $recentActivities[] = ['text' => $act['text'] . " - " . $timeAgo];
        }

        $data = [
            'stats' => [
                'posyandu' => ['total' => $totalPosyandu, 'trend' => $trendPosyandu],
                'balita'   => ['total' => $totalBalita, 'trend' => $trendBalita],
                'pengukuran' => ['total' => $totalIbuHamil, 'trend' => $trendIbuHamil],
                'ibu_hamil'  => ['total' => $totalDataIbuHamil, 'trend' => $trendDataIbuHamil],
                'remaja'     => ['total' => $totalRemaja, 'trend' => $trendRemaja],
                'usia_produktif' => ['total' => $totalUsiaProduktif, 'trend' => $trendUsiaProduktif],
                'lansia'   => ['total' => $totalLansia, 'trend' => $trendLansia],
                'berita'   => ['total' => $totalBerita, 'trend' => $trendBerita],
                'galeri'   => ['total' => $totalGaleri, 'trend' => $trendGaleri],
                'dokumen'  => ['total' => $totalDokumen, 'trend' => $trendDokumen],
                'pesan'    => ['total' => $totalPesan, 'trend' => $trendPesan],
                'user'     => ['total' => $totalUser, 'trend' => $trendUser]
            ],
            'charts' => [
                'gizi' => [
                    'labels' => $chartGiziLabels,
                    'data' => $chartGiziData
                ],
                'trend' => [
                    'labels' => $trendLabels,
                    'data' => $trendData
                ]
            ],
            'recent_activities' => $recentActivities
        ];
        
        return $this->response->setJSON(['status' => true, 'data' => $data]);
      } catch (\Throwable $e) {
        return $this->response->setStatusCode(500)->setJSON([
            'status' => false,
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]);
      }
    }

    private function timeElapsedString($datetime, $full = false) {
        $now = new \DateTime;
        $ago = new \DateTime($datetime);
        $diff = $now->diff($ago);
    
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
    
        $string = array(
            'y' => 'tahun',
            'm' => 'bulan',
            'w' => 'minggu',
            'd' => 'hari',
            'h' => 'jam',
            'i' => 'menit',
            's' => 'detik',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v;
            } else {
                unset($string[$k]);
            }
        }
    
        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' lalu' : 'baru saja';
    }
}
