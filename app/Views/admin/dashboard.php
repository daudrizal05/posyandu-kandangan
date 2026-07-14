<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid pb-4">

  <!-- ============================================================
       ROW 1 — 4 Stat Cards (Posyandu, Balita, Ibu Hamil, Pengukuran)
  ============================================================ -->
  <div class="row g-3 mt-1">

    <!-- 1. Total Posyandu Aktif -->
    <div class="col-xl-3 col-md-6 col-sm-6">
      <div class="an-card">
        <div class="an-card-top">
          <span class="an-card-label">Total Posyandu Aktif</span>
          <span class="an-card-icon" style="background:#EBF5FF;color:#1a56db;">
            <i class="fas fa-clinic-medical"></i>
          </span>
        </div>
        <div class="an-card-value"><?= esc($totalPosyandu) ?></div>
        <div class="an-card-trend up">
          <i class="fas fa-arrow-up"></i>
          <span>Data aktif saat ini</span>
        </div>
      </div>
    </div>

    <!-- 2. Total Data Balita -->
    <div class="col-xl-3 col-md-6 col-sm-6">
      <div class="an-card">
        <div class="an-card-top">
          <span class="an-card-label">Total Data Balita</span>
          <span class="an-card-icon" style="background:#ECFDF5;color:#059669;">
            <i class="fas fa-child"></i>
          </span>
        </div>
        <div class="an-card-value"><?= esc($totalBalita) ?></div>
        <div class="an-card-trend up">
          <i class="fas fa-arrow-up"></i>
          <span>Terdaftar dalam sistem</span>
        </div>
      </div>
    </div>

    <!-- 3. Total Ibu Hamil -->
    <div class="col-xl-3 col-md-6 col-sm-6">
      <div class="an-card">
        <div class="an-card-top">
          <span class="an-card-label">Total Ibu Hamil</span>
          <span class="an-card-icon" style="background:#FDF2F8;color:#db2777;">
            <i class="fas fa-female"></i>
          </span>
        </div>
        <div class="an-card-value"><?= esc($totalIbuHamil) ?></div>
        <div class="an-card-trend up">
          <i class="fas fa-arrow-up"></i>
          <span>Terdaftar dalam sistem</span>
        </div>
      </div>
    </div>

    <!-- 4. Pengukuran Bulan Ini -->
    <div class="col-xl-3 col-md-6 col-sm-6">
      <div class="an-card">
        <div class="an-card-top">
          <span class="an-card-label">Pengukuran Bulan Ini</span>
          <span class="an-card-icon" style="background:#FFF7ED;color:#ea580c;">
            <i class="fas fa-weight"></i>
          </span>
        </div>
        <div class="an-card-value"><?= esc($totalPengukuran) ?></div>
        <div class="an-card-trend neutral">
          <i class="fas fa-chart-line"></i>
          <span>Bulan <?= date('F Y') ?></span>
        </div>
      </div>
    </div>

  </div><!-- /.row 1 -->


  <!-- ============================================================
       ROW 2 — 2 Stat Cards (Remaja, Lansia) + mini donut visuals
  ============================================================ -->
  <div class="row g-3 mt-1">

    <!-- 5. Total Remaja -->
    <div class="col-xl-3 col-md-6 col-sm-6">
      <div class="an-card">
        <div class="an-card-top">
          <span class="an-card-label">Total Remaja</span>
          <span class="an-card-icon" style="background:#F5F3FF;color:#7c3aed;">
            <i class="fas fa-user-graduate"></i>
          </span>
        </div>
        <div class="an-card-body-row">
          <div>
            <div class="an-card-value"><?= esc($totalRemaja) ?></div>
            <div class="an-card-trend up">
              <i class="fas fa-arrow-up"></i>
              <span>Data terdaftar</span>
            </div>
          </div>
          <div class="an-mini-donut" style="--donut-color:#7c3aed;--donut-pct:75;"></div>
        </div>
      </div>
    </div>

    <!-- 6. Total Lansia -->
    <div class="col-xl-3 col-md-6 col-sm-6">
      <div class="an-card">
        <div class="an-card-top">
          <span class="an-card-label">Total Lansia</span>
          <span class="an-card-icon" style="background:#FEF2F2;color:#dc2626;">
            <i class="fas fa-user-friends"></i>
          </span>
        </div>
        <div class="an-card-body-row">
          <div>
            <div class="an-card-value"><?= esc($totalLansia) ?></div>
            <div class="an-card-trend up">
              <i class="fas fa-arrow-up"></i>
              <span>Data terdaftar</span>
            </div>
          </div>
          <div class="an-mini-donut" style="--donut-color:#dc2626;--donut-pct:60;"></div>
        </div>
      </div>
    </div>

    <!-- 7. Total Usia Produktif -->
    <div class="col-xl-3 col-md-6 col-sm-6">
      <div class="an-card">
        <div class="an-card-top">
          <span class="an-card-label">Total Usia Produktif</span>
          <span class="an-card-icon" style="background:#F0FDFA;color:#0d9488;">
            <i class="fas fa-briefcase"></i>
          </span>
        </div>
        <div class="an-card-body-row">
          <div>
            <div class="an-card-value"><?= esc($totalUsiaProduktif) ?></div>
            <div class="an-card-trend up">
              <i class="fas fa-arrow-up"></i>
              <span>Data terdaftar</span>
            </div>
          </div>
          <div class="an-mini-donut" style="--donut-color:#0d9488;--donut-pct:50;"></div>
        </div>
      </div>
    </div>

    <!-- 8. Manajemen User -->
    <div class="col-xl-3 col-md-6 col-sm-6">
      <div class="an-card">
        <div class="an-card-top">
          <span class="an-card-label">Manajemen User</span>
          <span class="an-card-icon" style="background:#EFF6FF;color:#2563eb;">
            <i class="fas fa-users"></i>
          </span>
        </div>
        <div class="an-card-body-row">
          <div>
            <div class="an-card-value"><?= esc($totalUser) ?></div>
            <div class="an-card-trend neutral">
              <i class="fas fa-user-check"></i>
              <span>User terdaftar</span>
            </div>
          </div>
          <div class="an-mini-donut" style="--donut-color:#2563eb;--donut-pct:85;"></div>
        </div>
      </div>
    </div>

  </div><!-- /.row 2 -->


  <!-- ============================================================
       ROW 3 — Bar Chart (Tren Pengukuran) + 2 Mini Cards
  ============================================================ -->
  <div class="row g-3 mt-1">

    <!-- Bar Chart: Tren Pengukuran 6 Bulan -->
    <div class="col-lg-7">
      <div class="an-chart-card">
        <div class="an-chart-header">
          <h3>Tren Pengukuran</h3>
          <span class="an-chart-badge"><?= date('Y') ?> <i class="fas fa-chevron-down" style="font-size:9px;margin-left:4px;"></i></span>
        </div>
        <div class="an-chart-body">
          <canvas id="trendBarChart" style="max-height:280px;"></canvas>
        </div>
      </div>
    </div>

    <!-- 2 Mini Summary Cards -->
    <div class="col-lg-5">
      <div class="row g-3 h-100">

        <!-- Paid Invoices style = Total Berita -->
        <div class="col-12">
          <div class="an-mini-summary-card">
            <div class="an-mini-summary-left">
              <div class="an-mini-summary-avatars">
                <span class="av" style="background:#3b82f6;"><i class="fas fa-newspaper" style="color:#fff;font-size:12px;"></i></span>
                <span class="av" style="background:#10b981;"><i class="fas fa-image" style="color:#fff;font-size:12px;"></i></span>
                <span class="av" style="background:#f59e0b;margin-left:-6px;"><i class="fas fa-file-alt" style="color:#fff;font-size:12px;"></i></span>
              </div>
              <div>
                <div class="an-mini-summary-value"><?= esc($totalBerita) ?></div>
                <div class="an-mini-summary-label">Total Berita Dipublikasi</div>
              </div>
            </div>
            <span class="an-mini-summary-badge up"><i class="fas fa-arrow-up"></i> Aktif</span>
          </div>
        </div>

        <!-- Funds Received style = Cetak Laporan -->
        <div class="col-12">
          <div class="an-mini-summary-card">
            <div class="an-mini-summary-left">
              <div class="an-mini-summary-avatars">
                <span class="av" style="background:#8b5cf6;"><i class="fas fa-print" style="color:#fff;font-size:12px;"></i></span>
                <span class="av" style="background:#ec4899;"><i class="fas fa-file-pdf" style="color:#fff;font-size:12px;"></i></span>
                <span class="av" style="background:#14b8a6;margin-left:-6px;"><i class="fas fa-chart-bar" style="color:#fff;font-size:12px;"></i></span>
              </div>
              <div>
                <div class="an-mini-summary-value">Cetak Laporan</div>
                <div class="an-mini-summary-label">Unduh data kesehatan posyandu</div>
              </div>
            </div>
            <a href="<?= site_url('admin/laporan') ?>" class="an-mini-summary-badge neutral" style="text-decoration:none;"><i class="fas fa-external-link-alt"></i> Buka</a>
          </div>
        </div>

      </div>
    </div>

  </div><!-- /.row 3 -->


  <!-- ============================================================
       ROW 4 — Doughnut Chart (Status Gizi) + Recent Activity Table
  ============================================================ -->
  <div class="row g-3 mt-1">

    <!-- Doughnut: Status Gizi Balita -->
    <div class="col-lg-5">
      <div class="an-chart-card">
        <div class="an-chart-header">
          <h3>Status Gizi Balita</h3>
          <span class="an-chart-badge"><?= date('Y') ?> <i class="fas fa-chevron-down" style="font-size:9px;margin-left:4px;"></i></span>
        </div>
        <div class="an-chart-body" style="display:flex;align-items:center;justify-content:center;">
          <canvas id="giziDoughnutChart" style="max-height:280px;"></canvas>
        </div>
      </div>
    </div>

    <!-- Activity Table -->
    <div class="col-lg-7">
      <div class="an-chart-card">
        <div class="an-chart-header">
          <h3>Ringkasan Data</h3>
          <span class="an-chart-badge"><i class="fas fa-sync-alt"></i></span>
        </div>
        <div class="an-table-body">
          <table class="an-summary-table">
            <thead>
              <tr>
                <th>Kategori</th>
                <th>Jumlah</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <div class="an-row-info">
                    <span class="an-row-dot" style="background:#1a56db;"></span>
                    Posyandu Aktif
                  </div>
                </td>
                <td><strong><?= esc($totalPosyandu) ?></strong></td>
                <td><span class="an-status-badge active">Aktif</span></td>
              </tr>
              <tr>
                <td>
                  <div class="an-row-info">
                    <span class="an-row-dot" style="background:#059669;"></span>
                    Data Balita
                  </div>
                </td>
                <td><strong><?= esc($totalBalita) ?></strong></td>
                <td><span class="an-status-badge active">Terdaftar</span></td>
              </tr>
              <tr>
                <td>
                  <div class="an-row-info">
                    <span class="an-row-dot" style="background:#db2777;"></span>
                    Data Ibu Hamil
                  </div>
                </td>
                <td><strong><?= esc($totalIbuHamil) ?></strong></td>
                <td><span class="an-status-badge active">Terdaftar</span></td>
              </tr>
              <tr>
                <td>
                  <div class="an-row-info">
                    <span class="an-row-dot" style="background:#7c3aed;"></span>
                    Data Remaja
                  </div>
                </td>
                <td><strong><?= esc($totalRemaja) ?></strong></td>
                <td><span class="an-status-badge active">Terdaftar</span></td>
              </tr>
              <tr>
                <td>
                  <div class="an-row-info">
                    <span class="an-row-dot" style="background:#0d9488;"></span>
                    Data Usia Produktif
                  </div>
                </td>
                <td><strong><?= esc($totalUsiaProduktif) ?></strong></td>
                <td><span class="an-status-badge active">Terdaftar</span></td>
              </tr>
              <tr>
                <td>
                  <div class="an-row-info">
                    <span class="an-row-dot" style="background:#dc2626;"></span>
                    Data Lansia
                  </div>
                </td>
                <td><strong><?= esc($totalLansia) ?></strong></td>
                <td><span class="an-status-badge active">Terdaftar</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div><!-- /.row 4 -->

</div><!-- /.container-fluid -->
<?= $this->endSection() ?>


<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function () {

  Chart.defaults.font.family = "'Inter', sans-serif";
  Chart.defaults.font.size   = 12;

  /* ==========================================
     BAR CHART — Tren Pengukuran 6 Bulan
  ========================================== */
  const ctxBar = document.getElementById('trendBarChart');
  if (ctxBar) {
    new Chart(ctxBar, {
      type: 'bar',
      data: {
        labels: <?= $trendLabels ?>,
        datasets: [{
          label: 'Pengukuran',
          data: <?= $trendData ?>,
          backgroundColor: 'rgba(59, 130, 246, 0.85)',
          borderRadius: 6,
          borderSkipped: false,
          barPercentage: 0.55,
          categoryPercentage: 0.65,
          hoverBackgroundColor: '#2563eb'
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          x: {
            grid: { display: false },
            ticks: { font: { size: 11, weight: '500' }, color: '#9CA3AF' }
          },
          y: {
            beginAtZero: true,
            grid: { color: '#F3F4F6', drawBorder: false },
            ticks: {
              stepSize: 1,
              font: { size: 11 },
              color: '#9CA3AF'
            }
          }
        },
        plugins: {
          legend: { display: false },
          tooltip: {
            backgroundColor: '#1F2937',
            titleFont: { size: 13, weight: '600' },
            bodyFont: { size: 12 },
            padding: 12,
            cornerRadius: 8,
            callbacks: {
              label: ctx => ` ${ctx.parsed.y} pengukuran`
            }
          }
        }
      }
    });
  }

  /* ==========================================
     DOUGHNUT CHART — Status Gizi Balita
  ========================================== */
  const ctxDoughnut = document.getElementById('giziDoughnutChart');
  if (ctxDoughnut) {
    new Chart(ctxDoughnut, {
      type: 'doughnut',
      data: {
        labels: <?= $chartGiziLabels ?>,
        datasets: [{
          data: <?= $chartGiziData ?>,
          backgroundColor: [
            '#10B981',  /* Normal  - hijau  */
            '#F59E0B',  /* Kurang  - kuning */
            '#EF4444',  /* Stunting - merah */
            '#7F1D1D'   /* Gizi Buruk - merah gelap */
          ],
          borderColor: '#ffffff',
          borderWidth: 3,
          hoverOffset: 6
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '60%',
        plugins: {
          legend: {
            position: 'bottom',
            labels: {
              padding: 16,
              boxWidth: 12,
              boxHeight: 12,
              borderRadius: 4,
              useBorderRadius: true,
              font: { size: 12, weight: '500' },
              color: '#6B7280'
            }
          },
          tooltip: {
            backgroundColor: '#1F2937',
            titleFont: { size: 13, weight: '600' },
            bodyFont: { size: 12 },
            padding: 12,
            cornerRadius: 8,
            callbacks: {
              label: function (ctx) {
                const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                const pct   = total > 0 ? ((ctx.parsed / total) * 100).toFixed(1) : 0;
                return ` ${ctx.label}: ${ctx.parsed} (${pct}%)`;
              }
            }
          }
        }
      }
    });
  }

});
</script>
<?= $this->endSection() ?>
