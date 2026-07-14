<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PosyanduModel;
use App\Models\BalitaModel;
use App\Models\PengukuranModel;
use App\Models\BeritaModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $posyanduModel = new PosyanduModel();
        $balitaModel = new BalitaModel();
        $pengukuranModel = new PengukuranModel();
        $beritaModel = new BeritaModel();

        // 1. Total Posyandu aktif
        $totalPosyandu = $posyanduModel->where('status', 'aktif')->countAllResults();

        // 2. Total Data Balita
        $totalBalita = $balitaModel->countAllResults();

        $totalPengukuranBulanIni = 0;
        $chartGiziLabels = ['Normal', 'Kurang', 'Stunting', 'Gizi Buruk'];
        $chartGiziData = [0, 0, 0, 0];
        $totalBerita = 0;
        $totalPesanUnread = 0;
        $trendLabels = [];
        $trendData = [];

        $db = \Config\Database::connect();
        
        // 3. Total Pengukuran bulan ini & Status Gizi & Trend
        if ($db->tableExists('pengukuran') && $db->fieldExists('tanggal_pengukuran', 'pengukuran')) {
            // 3. Total Pengukuran bulan ini
            $currentMonth = date('m');
            $currentYear = date('Y');
            
            $queryPengukuranBulanIni = "SELECT COUNT(*) as total FROM pengukuran WHERE EXTRACT(MONTH FROM tanggal_pengukuran) = ? AND EXTRACT(YEAR FROM tanggal_pengukuran) = ?";
            $resultPengukuran = $db->query($queryPengukuranBulanIni, [$currentMonth, $currentYear])->getRow();
            if ($resultPengukuran) {
                $totalPengukuranBulanIni = $resultPengukuran->total;
            }

            // 4. Jumlah Balita dengan status gizi: normal / kurang / stunting / gizi_buruk
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

            // 7. Grafik tren pengukuran gizi per bulan (line chart, 6 bulan terakhir)
            // Generate last 6 months labels
            for ($i = 5; $i >= 0; $i--) {
                $month = date('m', strtotime("-$i months"));
                $year = date('Y', strtotime("-$i months"));
                $monthName = date('M Y', strtotime("-$i months"));
                $trendLabels[] = $monthName;
                
                $queryTrend = "SELECT COUNT(*) as total FROM pengukuran WHERE EXTRACT(MONTH FROM tanggal_pengukuran) = ? AND EXTRACT(YEAR FROM tanggal_pengukuran) = ?";
                $res = $db->query($queryTrend, [$month, $year])->getRow();
                $trendData[] = $res ? $res->total : 0;
            }
        }

        if ($db->tableExists('berita')) {
            // 5. Total Berita published
            $totalBerita = $beritaModel->where('status', 'published')->countAllResults();
        }

        $data = [
            'title'             => 'Dashboard',
            'totalPosyandu'     => $totalPosyandu,
            'totalBalita'       => $totalBalita,
            'totalPengukuran'   => $totalPengukuranBulanIni,
            'totalBerita'       => $totalBerita,
            'totalPesanUnread'  => $totalPesanUnread,
            'chartGiziLabels'   => json_encode($chartGiziLabels),
            'chartGiziData'     => json_encode($chartGiziData),
            'trendLabels'       => json_encode($trendLabels),
            'trendData'         => json_encode($trendData)
        ];
        
        return view('admin/dashboard', $data);
    }
}