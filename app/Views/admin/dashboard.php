<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid pb-4">

  <!-- ============================================================
       ROW 1 — STAT CARDS (5 kartu)
  ============================================================ -->
  <div class="row g-3 mt-1">

    <!-- 1. Total Posyandu Aktif -->
    <div class="col-xl-3 col-md-6 col-sm-6">
      <div class="small-box bg-teal">
        <div class="inner">
          <h3><?= esc($totalPosyandu) ?></h3>
          <p>Total Posyandu Aktif</p>
        </div>
        <div class="icon"><i class="fas fa-clinic-medical"></i></div>
        <a href="<?= site_url('admin/posyandu') ?>" class="small-box-footer">
          More info <i class="fas fa-arrow-circle-right ml-1"></i>
        </a>
      </div>
    </div>

    <!-- 2. Total Data Balita -->
    <div class="col-xl-3 col-md-6 col-sm-6">
      <div class="small-box bg-success">
        <div class="inner">
          <h3><?= esc($totalBalita) ?></h3>
          <p>Total Data Balita</p>
        </div>
        <div class="icon"><i class="fas fa-child"></i></div>
        <a href="<?= site_url('admin/balita') ?>" class="small-box-footer">
          More info <i class="fas fa-arrow-circle-right ml-1"></i>
        </a>
      </div>
    </div>

    <!-- 3. Pengukuran Bulan Ini -->
    <div class="col-xl-3 col-md-6 col-sm-6">
      <div class="small-box bg-amber">
        <div class="inner">
          <h3><?= esc($totalPengukuran) ?></h3>
          <p>Ibu Hamil Bulan Ini</p>
        </div>
        <div class="icon"><i class="fas fa-weight"></i></div>
        <a href="<?= site_url('admin/pengukuran') ?>" class="small-box-footer">
          More info <i class="fas fa-arrow-circle-right ml-1"></i>
        </a>
      </div>
    </div>

  </div><!-- /.row 1 -->



  <!-- ============================================================
       ROW 2 — CHARTS
  ============================================================ -->
  <div class="row mt-2">

    <!-- Pie Chart: Status Gizi -->
    <div class="col-md-5">
      <div class="chart-card">
        <div class="chart-card-header">
          <span class="chart-icon" style="background:#f0fdf4;color:#16a34a;">
            <i class="fas fa-chart-pie"></i>
          </span>
          <h3>Proporsi Status Gizi Balita</h3>
          <span style="margin-left:auto;font-size:11px;color:#9ca3af;font-weight:500;">Pengukuran Terakhir</span>
        </div>
        <div class="chart-card-body" style="padding:24px;">
          <canvas id="giziPieChart" style="max-height:280px;"></canvas>
        </div>
      </div>
    </div>

    <!-- Line Chart: Tren Pengukuran -->
    <div class="col-md-7">
      <div class="chart-card">
        <div class="chart-card-header">
          <span class="chart-icon" style="background:#eff6ff;color:#2563eb;">
            <i class="fas fa-chart-line"></i>
          </span>
          <h3>Tren Jumlah Ibu Hamil</h3>
          <span style="margin-left:auto;font-size:11px;color:#9ca3af;font-weight:500;">6 Bulan Terakhir</span>
        </div>
        <div class="chart-card-body" style="padding:24px;">
          <canvas id="trendLineChart" style="max-height:280px;"></canvas>
        </div>
      </div>
    </div>

  </div><!-- /.row 2 -->

</div><!-- /.container-fluid -->
<?= $this->endSection() ?>


<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function () {

  /* ---- Shared font defaults ---- */
  Chart.defaults.font.family = "'Inter', sans-serif";
  Chart.defaults.font.size   = 12;

  /* ==========================================
     PIE CHART — Status Gizi Balita
  ========================================== */
  const ctxPie = document.getElementById('giziPieChart');
  if (ctxPie) {
    new Chart(ctxPie, {
      type: 'doughnut',
      data: {
        labels: <?= $chartGiziLabels ?>,
        datasets: [{
          data: <?= $chartGiziData ?>,
          backgroundColor: [
            'rgba(22, 163, 74, 0.85)',   /* Normal  - hijau   */
            'rgba(234, 179,  8, 0.85)',  /* Kurang  - kuning  */
            'rgba(234, 88,  12, 0.85)',  /* Stunting- oranye  */
            'rgba(220, 38,  38, 0.85)'   /* Gizi Buruk - merah */
          ],
          borderColor: '#ffffff',
          borderWidth: 3,
          hoverOffset: 6
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '55%',
        plugins: {
          legend: {
            position: 'bottom',
            labels: {
              padding: 18,
              boxWidth: 12,
              boxHeight: 12,
              borderRadius: 4,
              useBorderRadius: true,
              font: { size: 12, weight: '500' }
            }
          },
          tooltip: {
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

  /* ==========================================
     LINE CHART — Tren Pengukuran
  ========================================== */
  const ctxLine = document.getElementById('trendLineChart');
  if (ctxLine) {
    new Chart(ctxLine, {
      type: 'line',
      data: {
        labels: <?= $trendLabels ?>,
        datasets: [{
          label: 'Total Ibu Hamil',
          data: <?= $trendData ?>,
          fill: true,
          backgroundColor: 'rgba(37, 99, 235, 0.08)',
          borderColor: '#2563eb',
          borderWidth: 2.5,
          pointBackgroundColor: '#2563eb',
          pointBorderColor: '#fff',
          pointBorderWidth: 2,
          pointRadius: 5,
          pointHoverRadius: 7,
          tension: 0.38
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          x: {
            grid: { display: false },
            ticks: { font: { size: 12 }, color: '#6b7280' }
          },
          y: {
            beginAtZero: true,
            grid: { color: 'rgba(0,0,0,0.05)', drawBorder: false },
            ticks: {
              stepSize: 1,
              font: { size: 12 },
              color: '#6b7280'
            }
          }
        },
        plugins: {
          legend: { display: false },
          tooltip: {
            backgroundColor: '#1b2a4a',
            titleFont: { size: 13, weight: '600' },
            bodyFont:  { size: 12 },
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

});
</script>
<?= $this->endSection() ?>
