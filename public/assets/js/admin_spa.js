$(document).ready(function () {
    // ==========================================
    // GLOBAL: FETCH POSYANDU LIST (used by dropdowns & filters)
    // ==========================================
    window._posyanduList = [];
    window._balitaList = [];
    $.get(API_BASE_URL + 'posyandu', function (res) {
        window._posyanduList = (res.data || []).filter(p => p.status === 'aktif' || !p.status);
    });
    $.get(API_BASE_URL + 'balita', function (res) {
        window._balitaList = res.data || [];
    });

    // ==========================================
    // SPA OVERLAY TOGGLE
    // ==========================================
    $('#btnOpenAdminSPA').on('click', function (e) {
        e.preventDefault();
        $('#adminSpaOverlay').addClass('active');
        $('body').css('overflow', 'hidden');
        localStorage.setItem('adminSpaOpen', '1');
        const lastPage = localStorage.getItem('adminSpaPage') || 'dashboard';
        $('.spa-nav-link[data-page="' + lastPage + '"]').click();
    });

    // Auto-open on refresh if it was open
    if (localStorage.getItem('adminSpaOpen') === '1') {
        $('#adminSpaOverlay').addClass('active');
        $('body').css('overflow', 'hidden');
        const lastPage = localStorage.getItem('adminSpaPage') || 'dashboard';
        setTimeout(() => {
            $('.spa-nav-link[data-page="' + lastPage + '"]').click();
        }, 100);
    }

    $('#btnCloseAdminSPA2').on('click', function () {
        $('#adminSpaOverlay').removeClass('active');
        $('body').css('overflow', 'auto');
        localStorage.removeItem('adminSpaOpen');
    });

    $(document).on('click', '#btnToggleSidebar', function () {
        $('.spa-sidebar').toggleClass('collapsed');
    });

    $(document).on('click', '.spa-nav-link', function (e) {
        e.preventDefault();
        const page = $(this).data('page');
        if (!page) return;
        localStorage.setItem('adminSpaPage', page);
        $('.spa-nav-link').removeClass('active');
        $('.spa-sidebar .spa-nav-link[data-page="' + page + '"]').addClass('active');
        $('#spaPageTitle').text($('.spa-sidebar .spa-nav-link[data-page="' + page + '"]').text().trim());
        if ($(window).width() <= 768) { $('.spa-sidebar').addClass('collapsed'); }
        loadPage(page);
    });

    // ==========================================
    // PAGE ROUTER
    // ==========================================
    function loadPage(page) {
        $('#spaContent').html('<div style="padding:40px;text-align:center;"><i class="fas fa-spinner fa-spin fa-2x"></i></div>');

        if (page === 'dashboard') loadDashboard();
        else if (page === 'posyandu') loadCrudPage(cfgPosyandu);
        else if (page === 'balita') loadCrudPage(cfgBalita);
        else if (page === 'pengukuran') loadCrudPage(cfgPengukuran);
        else if (page === 'ibu_hamil') loadCrudPage(cfgIbuHamil);
        else if (page === 'remaja') loadCrudPage(cfgRemaja);
        else if (page === 'usia_produktif') loadCrudPage(cfgUsiaProduktif);
        else if (page === 'lansia') loadCrudPage(cfgLansia);
        else if (page === 'berita') loadCrudPage(cfgBerita);
        else if (page === 'galeri') loadCrudPage(cfgGaleri);
        else if (page === 'infografis') loadCrudPage(cfgInfografis);
        else if (page === 'dokumen') loadCrudPage(cfgDokumen);
        else if (page === 'halaman_statis') loadCrudPage(cfgHalaman);
        else if (page === 'pesan') loadCrudPage(cfgPesan);
        else if (page === 'user') loadCrudPage(cfgUser);
        else if (page === 'laporan') loadLaporan();
    }

    // ==========================================
    // DASHBOARD
    // ==========================================
    function loadDashboard() {
        $.get(API_BASE_URL + 'dashboard', function (res) {
            const d = res.data || res;
            const stats = d.stats || {};
            const charts = d.charts || {};
            const activities = d.recent_activities || [];

            // Helper: create a summary card that navigates on click
            const card = (label, count, trend, icon, bg, page) => `
                <a href="#${page}" class="spa-nav-link" data-page="${page}" style="
                    flex:1; min-width:200px; background:${bg}; border-radius:12px; padding:24px;
                    color:#fff; position:relative; overflow:hidden; text-decoration:none;
                    display:block; transition:transform .22s; cursor:pointer;
                " onmouseenter="this.style.transform='translateY(-3px)'" onmouseleave="this.style.transform='none'">
                    <div style="position:absolute;right:-10px;bottom:-15px;font-size:90px;color:rgba(0,0,0,0.12);pointer-events:none;">
                        <i class="${icon}"></i>
                    </div>
                    <div style="position:relative;z-index:2;">
                        <div style="font-size:11px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;color:rgba(255,255,255,.85);margin-bottom:12px;">${label}</div>
                        <div style="font-size:38px;font-weight:800;line-height:1;margin-bottom:8px;">${count}</div>
                        <div style="font-size:12.5px;font-weight:500;color:rgba(255,255,255,.9);display:flex;align-items:center;gap:4px;">
                            <i class="fas fa-chart-line"></i> ${trend}
                        </div>
                    </div>
                </a>
            `;

            const trendText = (total) => total > 0 ? `+${total} dari bulan lalu` : '0 data – mulai tambahkan';

            let html = `
                <!-- ===== Data Kesehatan ===== -->
                <div class="dash-section-title"><i class="fas fa-heartbeat"></i> Data Kesehatan</div>
                <div style="display:flex;flex-wrap:wrap;gap:16px;margin-bottom:24px;">
                    ${card('DATA POSYANDU', stats.posyandu.total, trendText(stats.posyandu.total), 'fas fa-clinic-medical', '#1a56db', 'posyandu')}
                    ${card('DATA BALITA', stats.balita.total, trendText(stats.balita.total), 'fas fa-child', '#10b981', 'balita')}
                    ${card('DATA PENGUKURAN BALITA', stats.pengukuran.total, trendText(stats.pengukuran.total), 'fas fa-weight', '#f59e0b', 'pengukuran')}
                    ${card('DATA IBU HAMIL', stats.ibu_hamil ? stats.ibu_hamil.total : 0, trendText(stats.ibu_hamil ? stats.ibu_hamil.total : 0), 'fas fa-female', '#d946ef', 'ibu_hamil')}
                    ${card('DATA REMAJA', stats.remaja ? stats.remaja.total : 0, trendText(stats.remaja ? stats.remaja.total : 0), 'fas fa-user-graduate', '#8b5cf6', 'remaja')}
                    ${card('DATA USIA PRODUKTIF', stats.usia_produktif ? stats.usia_produktif.total : 0, trendText(stats.usia_produktif ? stats.usia_produktif.total : 0), 'fas fa-briefcase', '#14b8a6', 'usia_produktif')}
                    ${card('DATA LANSIA', stats.lansia.total, trendText(stats.lansia.total), 'fas fa-user-friends', '#ef4444', 'lansia')}
                </div>



                <!-- ===== Aktivitas & Laporan ===== -->
                <div class="dash-section-title"><i class="fas fa-tasks"></i> Aktivitas & Laporan</div>
                <div style="display:flex;flex-wrap:wrap;gap:16px;margin-bottom:24px;">
                    ${card('MANAJEMEN USER', stats.user ? stats.user.total : 0, trendText(stats.user ? stats.user.total : 0), 'fas fa-users', '#059669', 'user')}
                    <a href="#laporan" class="spa-nav-link" data-page="laporan" style="
                        flex:1; min-width:200px; background:#f59e0b; border-radius:12px; padding:24px;
                        color:#fff; position:relative; overflow:hidden; text-decoration:none;
                        display:block; transition:transform .22s; cursor:pointer;
                    " onmouseenter="this.style.transform='translateY(-3px)'" onmouseleave="this.style.transform='none'">
                        <div style="position:absolute;right:-10px;bottom:-15px;font-size:90px;color:rgba(0,0,0,0.12);pointer-events:none;">
                            <i class="fas fa-print"></i>
                        </div>
                        <div style="position:relative;z-index:2;">
                            <div style="font-size:11px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;color:rgba(255,255,255,.85);margin-bottom:12px;">CETAK LAPORAN</div>
                            <div style="font-size:38px;font-weight:800;line-height:1;margin-bottom:8px;">–</div>
                            <div style="font-size:12.5px;font-weight:500;color:rgba(255,255,255,.9);display:flex;align-items:center;gap:4px;">
                                <i class="fas fa-chart-line"></i> Semua Data
                            </div>
                        </div>
                    </a>
                </div>

                <!-- ===== Charts ===== -->
                <div class="charts-grid">
                    <div class="chart-box">
                        <div class="chart-title">Proporsi Status Gizi Balita</div>
                        <div class="chart-container" id="giziContainer">
                            <canvas id="giziChart"></canvas>
                        </div>
                    </div>
                    <div class="chart-box">
                        <div class="chart-title">Tren Pengukuran (6 Bulan)</div>
                        <div class="chart-container" id="trenContainer">
                            <canvas id="trenChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="activity-feed">
                    <h3><i class="fas fa-history"></i> Aktivitas Terbaru</h3>
                    <div id="activityList">
                        <!-- Activities -->
                    </div>
                </div>
            `;

            $('#spaContent').html(html);

            // Init Charts
            const sumGizi = charts.gizi.data.reduce((a, b) => a + Number(b), 0);
            if (sumGizi > 0) {
                new Chart(document.getElementById('giziChart'), {
                    type: 'doughnut',
                    data: {
                        labels: charts.gizi.labels,
                        datasets: [{
                            data: charts.gizi.data,
                            backgroundColor: ['#10b981', '#f59e0b', '#ef4444', '#7f1d1d'],
                            borderWidth: 0
                        }]
                    },
                    options: { maintainAspectRatio: false }
                });
            } else {
                $('#giziContainer').html('<div class="empty-state"><i class="fas fa-chart-pie"></i><span>Belum ada data pengukuran bulan ini</span></div>');
            }

            const sumTren = charts.trend.data.reduce((a, b) => a + Number(b), 0);
            if (sumTren > 0) {
                new Chart(document.getElementById('trenChart'), {
                    type: 'line',
                    data: {
                        labels: charts.trend.labels,
                        datasets: [{
                            label: 'Jumlah Pengukuran',
                            data: charts.trend.data,
                            borderColor: '#3b82f6',
                            tension: 0.3,
                            fill: true,
                            backgroundColor: 'rgba(59, 130, 246, 0.1)'
                        }]
                    },
                    options: { maintainAspectRatio: false }
                });
            } else {
                $('#trenContainer').html('<div class="empty-state"><i class="fas fa-chart-line"></i><span>Belum ada data tren pengukuran</span></div>');
            }

            // Init Activities
            if (activities.length > 0) {
                let actHtml = '';
                activities.forEach(act => {
                    actHtml += `
                        <div class="activity-item">
                            <div class="activity-icon"><i class="fas fa-bell"></i></div>
                            <div class="activity-text">${act.text}</div>
                        </div>
                    `;
                });
                $('#activityList').html(actHtml);
            } else {
                $('#activityList').html('<div class="empty-state" style="padding:20px 0;"><i class="fas fa-inbox"></i><span>Belum ada aktivitas terbaru</span></div>');
            }

        }).fail(function (xhr) {
            let errMsg = 'Gagal memuat dashboard.';
            try { let j = xhr.responseJSON; if (j && j.message) errMsg += ' Error: ' + j.message + ' (line ' + j.line + ')'; } catch (e) { }
            $('#spaContent').html('<p style="color:red;">' + errMsg + '</p>');
        });
    }

    // ==========================================
    // LAPORAN
    // ==========================================
    function loadLaporan() {
        // Karena laporan tidak diubah ke JSON (tetap view), kita render iframe atau link.
        // Paling mudah memberikan form pilihan cetak yang membuka tab baru.
        const html = `
            <div class="table-card">
                <h3>Cetak Laporan</h3>
                <p class="text-muted">Pilih jenis laporan untuk dicetak/diunduh.</p>
                <div style="display:flex;gap:16px;margin-top:20px;flex-wrap:wrap;">
                    <a href="${API_BASE_URL}laporan/cetak_balita" target="_blank" class="btn-primary-spa"><i class="fas fa-print"></i> Laporan Balita</a>
                    <a href="${API_BASE_URL}laporan/cetak_pengukuran" target="_blank" class="btn-primary-spa"><i class="fas fa-print"></i> Laporan Pengukuran Balita</a>
                    <a href="${API_BASE_URL}laporan/cetak_ibu_hamil" target="_blank" class="btn-primary-spa"><i class="fas fa-print"></i> Laporan Ibu Hamil</a>
                    <a href="${API_BASE_URL}laporan/cetak_remaja" target="_blank" class="btn-primary-spa"><i class="fas fa-print"></i> Laporan Remaja</a>
                    <a href="${API_BASE_URL}laporan/cetak_usia_produktif" target="_blank" class="btn-primary-spa"><i class="fas fa-print"></i> Laporan Usia Produktif</a>
                    <a href="${API_BASE_URL}laporan/cetak_lansia" target="_blank" class="btn-primary-spa"><i class="fas fa-print"></i> Laporan Lansia</a>
                </div>
            </div>
        `;
        $('#spaContent').html(html);
    }

    // ==========================================
    // GENERIC CRUD GENERATOR
    // ==========================================
    function loadCrudPage(config) {
        const tableId = 'dt_' + config.name;

        // Build filter bar HTML
        let filterHtml = '';
        if (config.hasPosyanduFilter) {
            filterHtml = `
                <div style="margin-bottom:16px; display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                    <label style="font-weight:600; font-size:13px; color:#475569; white-space:nowrap;">Filter Posyandu:</label>
                    <select id="filterPosyandu_${config.name}" style="padding:8px 12px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:13px; min-width:220px; font-family:inherit; background:#fff; cursor:pointer;">
                        <option value="">Semua Posyandu</option>
                    </select>
                </div>
            `;
        }

        const html = `
            <div class="table-card">
                <div class="table-header" style="justify-content: flex-end;">
                    ${config.noAdd ? '' : `<button class="btn-primary-spa" id="btnAdd_${config.name}"><i class="fas fa-plus"></i> Tambah</button>`}
                </div>
                ${filterHtml}
                <div style="overflow-x:auto;">
                    <table id="${tableId}" class="display dataTable" style="width:100%">
                        <thead><tr>${config.columns.map(c => `<th>${c.label}</th>`).join('')}<th>Aksi</th></tr></thead>
                    </table>
                </div>
            </div>
        `;
        $('#spaContent').html(html);

        // Populate posyandu filter dropdown
        if (config.hasPosyanduFilter) {
            const $filterSelect = $(`#filterPosyandu_${config.name}`);
            (window._posyanduList || []).forEach(p => {
                $filterSelect.append(`<option value="${p.nama_posyandu}">${p.nama_posyandu}</option>`);
            });
        }

        // Find posyandu column index for filtering
        const posyanduColIdx = config.columns.findIndex(c => c.data === 'nama_posyandu');

        const dt = $(`#${tableId}`).DataTable({
            ajax: {
                url: API_BASE_URL + config.endpoint,
                dataSrc: 'data',
                error: function (xhr, error, thrown) {
                    Swal.fire('Error', 'Gagal memuat data.', 'error');
                }
            },
            columns: [
                ...config.columns.map(c => ({
                    data: c.data,
                    className: 'dt-center',
                    render: c.render ? c.render : function (data) { return data ?? '-'; }
                })),
                {
                    data: 'id',
                    orderable: false,
                    className: 'dt-center',
                    render: function (data, type, row) {
                        let btns = '';
                        if (config.hasView) {
                            btns += `<button class="btn-view" data-id="${data}" style="background:none;border:none;color:#3b82f6;cursor:pointer;margin-right:8px;" title="Lihat"><i class="fas fa-eye"></i></button>`;
                        }
                        btns += `
                            <button class="btn-edit" data-id="${data}" style="background:none;border:none;color:#f59e0b;cursor:pointer;margin-right:8px;" title="Edit"><i class="fas fa-edit"></i></button>
                            <button class="btn-delete" data-id="${data}" style="background:none;border:none;color:#ef4444;cursor:pointer;" title="Hapus"><i class="fas fa-trash"></i></button>
                        `;
                        return btns;
                    }
                }
            ]
        });

        // Wire up posyandu filter
        if (config.hasPosyanduFilter && posyanduColIdx >= 0) {
            $(`#filterPosyandu_${config.name}`).on('change', function () {
                const val = $(this).val();
                dt.column(posyanduColIdx).search(val ? '^' + $.fn.dataTable.util.escapeRegex(val) + '$' : '', true, false).draw();
            });
        }

        if (!config.noAdd) {
            $(`#btnAdd_${config.name}`).on('click', () => showFormModal(config, null, dt));
        }

        $(`#${tableId}`).on('click', '.btn-edit', function () {
            const id = $(this).data('id');
            $.get(API_BASE_URL + config.endpoint + '/' + id, function (res) {
                showFormModal(config, res, dt);
            });
        });

        $(`#${tableId}`).on('click', '.btn-view', function () {
            const id = $(this).data('id');
            $.get(API_BASE_URL + config.endpoint + '/' + id, function (res) {
                let html = '<div style="text-align:left; line-height:1.6; font-size:14px; margin-top:10px; padding:10px; background:#f8fafc; border-radius:8px;">';
                config.fields.forEach(f => {
                    if (f.name !== 'password') {
                        html += `<div><strong>${f.label}:</strong> <span style="color:#475569;">${res[f.name] || '-'}</span></div>`;
                    }
                });
                html += '</div>';
                Swal.fire({
                    title: 'Detail ' + config.title,
                    html: html,
                    icon: 'info',
                    confirmButtonText: 'Tutup'
                });
            });
        });

        $(`#${tableId}`).on('click', '.btn-delete', function () {
            const id = $(this).data('id');
            Swal.fire({
                title: 'Hapus data?', text: "Data yang dihapus tidak bisa dikembalikan!", icon: 'warning',
                showCancelButton: true, confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: API_BASE_URL + config.endpoint + '/' + id,
                        type: 'DELETE',
                        success: function (res) {
                            Swal.fire('Terhapus!', res.message, 'success');
                            dt.ajax.reload(null, false);
                        },
                        error: function (err) { Swal.fire('Error', err.responseJSON?.message || 'Gagal', 'error'); }
                    });
                }
            });
        });
    }

    function showFormModal(config, data, dt) {
        const isEdit = !!data;
        const title = (isEdit ? 'Edit ' : 'Tambah ') + config.title;
        let formBody = `<form id="spaForm">`;

        config.fields.forEach(f => {
            const val = data ? (data[f.name] ?? '') : '';
            formBody += `<div class="form-group"><label>${f.label}</label>`;

            if (f.type === 'select_posyandu') {
                // Dynamic dropdown filled from posyandu list
                formBody += `<select class="form-control" name="${f.name}" required>`;
                formBody += `<option value="">-- Pilih Posyandu --</option>`;
                (window._posyanduList || []).forEach(p => {
                    const selected = val == p.id ? 'selected' : '';
                    formBody += `<option value="${p.id}" ${selected}>${p.nama_posyandu}</option>`;
                });
                formBody += `</select>`;
            } else if (f.type === 'select_posyandu_readonly') {
                // Read-only posyandu info (for pengukuran — auto-filled from balita)
                formBody += `<input type="hidden" name="${f.name}" id="field_posyandu_id" value="${val}">`;
                formBody += `<input type="text" class="form-control" id="display_posyandu" value="" readonly style="background:#f1f5f9; color:#64748b; cursor:not-allowed;" placeholder="Otomatis dari Balita yang dipilih">`;
            } else if (f.type === 'select_balita') {
                // Dynamic dropdown filled from balita list
                formBody += `<select class="form-control" name="${f.name}" id="field_balita_id" required>`;
                formBody += `<option value="">-- Pilih Balita --</option>`;
                (window._balitaList || []).forEach(b => {
                    const selected = val == b.id ? 'selected' : '';
                    formBody += `<option value="${b.id}" data-posyandu-id="${b.posyandu_id || ''}" data-posyandu-nama="${b.nama_posyandu || ''}" ${selected}>${b.nama_balita} (${b.nik || '-'})</option>`;
                });
                formBody += `</select>`;
            } else if (f.type === 'textarea') {
                formBody += `<textarea class="form-control" name="${f.name}" required>${val}</textarea>`;
            } else if (f.type === 'select') {
                formBody += `<select class="form-control" name="${f.name}" required>`;
                f.options.forEach(opt => {
                    const selected = val == opt.value ? 'selected' : '';
                    formBody += `<option value="${opt.value}" ${selected}>${opt.label}</option>`;
                });
                formBody += `</select>`;
            } else if (f.type === 'file') {
                formBody += `<input type="file" class="form-control" name="${f.name}" ${isEdit ? '' : 'required'}>`;
            } else {
                formBody += `<input type="${f.type || 'text'}" class="form-control" name="${f.name}" value="${val}" required>`;
            }
            formBody += `</div>`;
        });
        if (config.customHTML) {
            formBody += config.customHTML(data);
        }
        formBody += `</form>`;

        const html = `
            <div class="spa-modal-header">
                <h3>${title}</h3>
                <button class="spa-modal-close" onclick="$('#spaModal').removeClass('active')">&times;</button>
            </div>
            <div class="spa-modal-body">${formBody}</div>
            <div class="spa-modal-footer">
                <button class="btn-secondary-spa" onclick="$('#spaModal').removeClass('active')">Batal</button>
                <button class="btn-primary-spa" id="btnSaveSpaForm">Simpan</button>
            </div>
        `;
        $('#spaModalContent').html(html);
        $('#spaModal').addClass('active');

        // Wire up balita → posyandu auto-fill for pengukuran
        if ($('#field_balita_id').length) {
            function updatePosyanduFromBalita() {
                const $sel = $('#field_balita_id option:selected');
                const pid = $sel.data('posyandu-id') || '';
                const pnama = $sel.data('posyandu-nama') || '';
                $('#field_posyandu_id').val(pid);
                $('#display_posyandu').val(pnama || (pid ? 'Posyandu ID: ' + pid : ''));
            }
            $('#field_balita_id').on('change', updatePosyanduFromBalita);
            // Auto-fill on edit
            if (data) { updatePosyanduFromBalita(); }
        }

        if (config.onModalReady) {
            config.onModalReady(data);
        }

        $('#btnSaveSpaForm').on('click', function () {
            const form = document.getElementById('spaForm');
            if (!form.reportValidity()) return;

            const formData = new FormData(form);

            if (config.onBeforeSave) {
                if (config.onBeforeSave(formData) === false) return;
            }

            let url = API_BASE_URL + config.endpoint;
            let type = 'POST';

            if (isEdit) {
                url += '/' + data.id;
                if (!config.hasFile) {
                    type = 'PUT';
                    // Convert FormData to JSON for PUT if no file
                    const obj = {};
                    formData.forEach((value, key) => obj[key] = value);
                    sendForm(url, type, JSON.stringify(obj), 'application/json');
                    return;
                } else {
                    // For file uploads in CI4 PUT is tricky, we use POST
                    // (Assuming CI4 route supports POST for update when hasFile is true)
                    type = 'POST';
                }
            }

            $.ajax({
                url: url, type: type, data: formData,
                processData: false, contentType: false,
                success: function (res) {
                    $('#spaModal').removeClass('active');
                    Swal.fire('Berhasil!', res.message, 'success');
                    dt.ajax.reload(null, false);
                },
                error: function (err) {
                    let msg = err.responseJSON?.message || 'Gagal menyimpan';
                    if (err.responseJSON?.errors) {
                        msg = Object.values(err.responseJSON.errors).join('<br>');
                    }
                    Swal.fire('Error', msg, 'error');
                }
            });
        });

        function sendForm(url, type, data, contentType) {
            $.ajax({
                url: url, type: type, data: data, contentType: contentType,
                success: function (res) {
                    $('#spaModal').removeClass('active');
                    Swal.fire('Berhasil!', res.message, 'success');
                    dt.ajax.reload(null, false);
                },
                error: function (err) {
                    let msg = err.responseJSON?.message || 'Gagal menyimpan';
                    if (err.responseJSON?.errors) {
                        msg = Object.values(err.responseJSON.errors).join('<br>');
                    }
                    Swal.fire('Error', msg, 'error');
                }
            });
        }
    }

    // ==========================================
    // CONFIGURATIONS FOR EACH MODULE
    // ==========================================
    const cfgPosyandu = {
        name: 'posyandu', title: 'Posyandu', endpoint: 'posyandu', hasFile: false, hasView: true,
        columns: [
            { data: 'nama_posyandu', label: 'Nama Posyandu' },
            { data: 'desa_kelurahan', label: 'Desa/Kelurahan' },
            { data: 'alamat', label: 'Alamat' },
            { data: 'nama_ketua_kader', label: 'Ketua Kader' },
            { data: 'kontak', label: 'Kontak' },
            { data: 'status', label: 'Status' },

        ],
        fields: [
            { name: 'nama_posyandu', label: 'Nama Posyandu' },
            { name: 'desa_kelurahan', label: 'Desa/Kelurahan' },
            { name: 'alamat', label: 'Alamat', type: 'textarea' },
            { name: 'nama_ketua_kader', label: 'Ketua Kader' },
            { name: 'kontak', label: 'Kontak' },
            { name: 'status', label: 'Status', type: 'select', options: [{ value: 'aktif', label: 'Aktif' }, { value: 'nonaktif', label: 'Nonaktif' }] }
        ]
    };

    const cfgBalita = {
        name: 'balita', title: 'Balita', endpoint: 'balita', hasFile: false, hasView: true, hasPosyanduFilter: true,
        columns: [
            { data: null, label: 'No', render: (d, t, r, m) => m.row + 1 },
            { data: 'nama_posyandu', label: 'Posyandu' },
            { data: 'nama_balita', label: 'Nama' },
            { data: 'jenis_kelamin', label: 'JK', render: d => d === 'L' ? 'L' : 'P' },
            { data: 'tanggal_lahir', label: 'Tgl Lahir' },
            { data: 'nama_ibu', label: 'Nama Ortu', render: function (data, type, row) { return row.nama_ibu || row.nama_ayah || '-'; } },
            { data: 'berat', label: 'Berat' },
            { data: 'tinggi', label: 'Tinggi' },
            { data: 'bb_u', label: 'BB/U' },
            { data: 'zs_bb_u', label: 'ZS BB/U' },
            { data: 'tb_u', label: 'TB/U' },
            { data: 'zs_tb_u', label: 'ZS TB/U' },
            { data: 'bb_tb', label: 'BB/TB' },
            { data: 'zs_bb_tb', label: 'ZS BB/TB' }
        ],
        fields: [
            { name: 'posyandu_id', label: 'Posyandu <span class="text-danger">*</span>', type: 'select_posyandu' },
            { name: 'nik', label: 'NIK' },
            { name: 'nama_balita', label: 'Nama Balita' },
            { name: 'jenis_kelamin', label: 'Jenis Kelamin', type: 'select', options: [{ value: 'L', label: 'Laki-laki' }, { value: 'P', label: 'Perempuan' }] },
            { name: 'tanggal_lahir', label: 'Tanggal Lahir', type: 'date' },
            { name: 'nama_ibu', label: 'Nama Ortu (Ibu)' },
            { name: 'berat', label: 'Berat', type: 'number' },
            { name: 'tinggi', label: 'Tinggi', type: 'number' },
            { name: 'bb_u', label: 'BB/U (Contoh: Normal/Kurang)' },
            { name: 'zs_bb_u', label: 'ZS BB/U', type: 'number' },
            { name: 'tb_u', label: 'TB/U (Contoh: Normal/Pendek)' },
            { name: 'zs_tb_u', label: 'ZS TB/U', type: 'number' },
            { name: 'bb_tb', label: 'BB/TB (Contoh: Gizi Baik/Buruk)' },
            { name: 'zs_bb_tb', label: 'ZS BB/TB', type: 'number' }
        ]
    };

    const cfgPengukuran = {
        name: 'pengukuran', title: 'Data Pengukuran Balita', endpoint: 'pengukuran', hasFile: false, hasView: true, hasPosyanduFilter: true,
        columns: [
            { data: 'nama_posyandu', label: 'Posyandu' },
            { data: 'tanggal_pengukuran', label: 'Tanggal' },
            { data: 'nama_balita', label: 'Nama Balita' },
            { data: 'berat_badan', label: 'BB (kg)' },
            { data: 'tinggi_badan', label: 'TB (cm)' },
            { data: 'status_gizi', label: 'Status' }
        ],
        fields: [
            { name: 'balita_id', label: 'Balita <span class="text-danger">*</span>', type: 'select_balita' },
            { name: 'posyandu_id', label: 'Posyandu (otomatis)', type: 'select_posyandu_readonly' },
            { name: 'tanggal_pengukuran', label: 'Tanggal', type: 'date' },
            { name: 'berat_badan', label: 'BB (kg)', type: 'number' },
            { name: 'tinggi_badan', label: 'TB (cm)', type: 'number' },
            { name: 'lingkar_kepala', label: 'Lingkar Kepala (cm)', type: 'number' }
        ]
    };

    const cfgIbuHamil = {
        name: 'ibu_hamil', title: 'Data Ibu Hamil', endpoint: 'ibu_hamil', hasFile: false, hasView: true, hasPosyanduFilter: true,
        columns: [
            { data: 'nama_posyandu', label: 'Posyandu' },
            { data: 'nama_ibu', label: 'Nama Ibu' },
            { data: 'nama_suami', label: 'Nama Suami' },
            { data: 'tanggal_lahir', label: 'Tgl Lahir' },
            { data: 'no_hp', label: 'No HP' },
            { data: 'taksiran_lahir', label: 'Taksiran Lahir' },
            { data: 'status', label: 'Status' }
        ],
        fields: [
            { name: 'posyandu_id', label: 'Posyandu <span class="text-danger">*</span>', type: 'select_posyandu' },
            { name: 'nik', label: 'NIK <span class="text-danger">*</span>' },
            { name: 'nama_ibu', label: 'Nama Ibu <span class="text-danger">*</span>' },
            { name: 'nama_suami', label: 'Nama Suami' },
            { name: 'tempat_lahir', label: 'Tempat Lahir' },
            { name: 'tanggal_lahir', label: 'Tanggal Lahir', type: 'date' },
            { name: 'alamat', label: 'Alamat', type: 'textarea' },
            { name: 'no_hp', label: 'No HP' },
            { name: 'tanggal_hpht', label: 'HPHT', type: 'date' },
            { name: 'taksiran_lahir', label: 'Taksiran Lahir', type: 'date' },
            { name: 'golongan_darah', label: 'Golongan Darah', type: 'select', options: [
                {value: '-', label: '-'}, {value: 'A', label: 'A'}, {value: 'B', label: 'B'}, {value: 'AB', label: 'AB'}, {value: 'O', label: 'O'}
            ] },
            { name: 'status', label: 'Status', type: 'select', options: [
                {value: 'aktif', label: 'Aktif'}, {value: 'nonaktif', label: 'Nonaktif'}
            ] }
        ]
    };

    const cfgRemaja = {
        name: 'remaja', title: 'Data Remaja', endpoint: 'remaja', hasFile: false, hasView: true, hasPosyanduFilter: true,
        columns: [
            { data: 'nama_posyandu', label: 'Posyandu' },
            { data: 'nik', label: 'NIK' },
            { data: 'nama', label: 'Nama Lengkap' },
            { data: 'jenis_kelamin', label: 'L/P' },
            { data: 'no_hp', label: 'No HP' },
            { data: 'berat_badan', label: 'BB (kg)' },
            { data: 'tinggi_badan', label: 'TB (cm)' }
        ],
        fields: [
            { name: 'posyandu_id', label: 'Posyandu <span class="text-danger">*</span>', type: 'select_posyandu' },
            { name: 'nik', label: 'NIK <span class="text-danger">*</span>' },
            { name: 'nama', label: 'Nama Lengkap <span class="text-danger">*</span>' },
            { name: 'tanggal_lahir', label: 'Tanggal Lahir', type: 'date' },
            { name: 'jenis_kelamin', label: 'Jenis Kelamin', type: 'select', options: [
                {value: 'L', label: 'Laki-laki'}, {value: 'P', label: 'Perempuan'}
            ] },
            { name: 'alamat', label: 'Alamat', type: 'textarea' },
            { name: 'no_hp', label: 'No Handphone' },
            { name: 'berat_badan', label: 'Berat Badan (kg)', type: 'number' },
            { name: 'tinggi_badan', label: 'Tinggi Badan (cm)', type: 'number' },
            { name: 'lila', label: 'LiLA (cm)', type: 'number' },
            { name: 'tekanan_darah', label: 'Tekanan Darah (cth: 120/80)' },
            { name: 'hb', label: 'Kadar Hb (g/dL)', type: 'number' }
        ]
    };

    const cfgUsiaProduktif = {
        name: 'usia_produktif', title: 'Data Usia Produktif', endpoint: 'usia_produktif', hasFile: false, hasView: true, hasPosyanduFilter: true,
        columns: [
            { data: 'nama_posyandu', label: 'Posyandu' },
            { data: 'nik', label: 'NIK' },
            { data: 'nama', label: 'Nama Lengkap' },
            { data: 'jenis_kelamin', label: 'L/P' },
            { data: 'tekanan_darah', label: 'Tensi Darah' },
            { data: 'gula_darah', label: 'Gula Darah' },
            { data: 'kolesterol', label: 'Kolesterol' }
        ],
        fields: [
            { name: 'posyandu_id', label: 'Posyandu <span class="text-danger">*</span>', type: 'select_posyandu' },
            { name: 'nik', label: 'NIK <span class="text-danger">*</span>' },
            { name: 'nama', label: 'Nama Lengkap <span class="text-danger">*</span>' },
            { name: 'tanggal_lahir', label: 'Tanggal Lahir', type: 'date' },
            { name: 'jenis_kelamin', label: 'Jenis Kelamin', type: 'select', options: [
                {value: 'L', label: 'Laki-laki'}, {value: 'P', label: 'Perempuan'}
            ] },
            { name: 'alamat', label: 'Alamat', type: 'textarea' },
            { name: 'no_hp', label: 'No Handphone' },
            { name: 'berat_badan', label: 'Berat Badan (kg)', type: 'number' },
            { name: 'tinggi_badan', label: 'Tinggi Badan (cm)', type: 'number' },
            { name: 'lingkar_perut', label: 'Lingkar Perut (cm)', type: 'number' },
            { name: 'tekanan_darah', label: 'Tekanan Darah (cth: 120/80)' },
            { name: 'gula_darah', label: 'Gula Darah Sewaktu (mg/dL)', type: 'number' },
            { name: 'kolesterol', label: 'Kolesterol Total (mg/dL)', type: 'number' },
            { name: 'asam_urat', label: 'Asam Urat (mg/dL)', type: 'number' }
        ]
    };

    const cfgLansia = {
        name: 'lansia', title: 'Data Lansia', endpoint: 'lansia', hasFile: false, hasView: true, hasPosyanduFilter: true,
        columns: [
            { data: 'nama_posyandu', label: 'Posyandu' },
            { data: 'nama', label: 'Nama' },
            { data: 'alamat', label: 'Alamat' },
            { data: 'tanggal_lahir', label: 'Tgl Lahir' },
            { data: 'umur', label: 'Umur' },
            { data: 'lingkar_lengan_atas', label: 'L. Lengan' },
            { data: 'bb', label: 'BB' },
            { data: 'tb', label: 'TB' },
            { data: 'lingkar_pinggang', label: 'L. Pinggang' },
            { data: 'imt', label: 'IMT' },
            { data: 'nik', label: 'NIK' },
            { data: 'no_bpjs', label: 'No BPJS' },
            { data: 'keluhan', label: 'Keluhan' },
            { data: 'tensi', label: 'Tensi' },
            { data: 'obat', label: 'Obat' }
        ],
        fields: [
            { name: 'posyandu_id', label: 'Posyandu <span class="text-danger">*</span>', type: 'select_posyandu' },
            { name: 'nama', label: 'Nama <span class="text-danger">*</span>' },
            { name: 'alamat', label: 'Alamat <span class="text-danger">*</span>', type: 'textarea' },
            { name: 'tanggal_lahir', label: 'Tgl Lahir <span class="text-danger">*</span>', type: 'date' },
            { name: 'umur', label: 'Umur <span class="text-danger">*</span>', type: 'number' },
            { name: 'lingkar_lengan_atas', label: 'Lingkar Lengan Atas <span class="text-danger">*</span>', type: 'number' },
            { name: 'bb', label: 'BB <span class="text-danger">*</span>', type: 'number' },
            { name: 'tb', label: 'TB <span class="text-danger">*</span>', type: 'number' },
            { name: 'lingkar_pinggang', label: 'Lingkar Pinggang <span class="text-danger">*</span>', type: 'number' },
            { name: 'imt', label: 'Indeks Massa Tubuh <span class="text-danger">*</span>', type: 'number' },
            { name: 'nik', label: 'NIK <span class="text-danger">*</span>' },
            { name: 'no_bpjs', label: 'No BPJS <span class="text-danger">*</span>' },
            { name: 'keluhan', label: 'Keluhan <span class="text-danger">*</span>', type: 'textarea' },
            { name: 'tensi', label: 'Tensi <span class="text-danger">*</span>' },
            { name: 'obat', label: 'Obat <span class="text-danger">*</span>', type: 'textarea' }
        ]
    };

    const cfgBerita = {
        name: 'berita', title: 'Berita', endpoint: 'berita', hasFile: true, hasView: true,
        columns: [
            { data: 'judul', label: 'Judul' },
            { data: 'kategori', label: 'Kategori' },
            { data: 'status', label: 'Status' }
        ],
        fields: [
            { name: 'judul', label: 'Judul' },
            { name: 'kategori', label: 'Kategori' },
            { name: 'isi', label: 'Isi Konten', type: 'textarea' },
            { name: 'status', label: 'Status', type: 'select', options: [{ value: 'draft', label: 'Draft' }, { value: 'published', label: 'Published' }] },
            { name: 'thumbnail', label: 'Thumbnail (Image)', type: 'file' }
        ]
    };

    const cfgGaleri = {
        name: 'galeri', title: 'Galeri', endpoint: 'galeri', hasFile: true, hasView: true,
        columns: [
            { data: 'judul', label: 'Judul' },
            { data: 'tanggal', label: 'Tanggal' }
        ],
        fields: [
            { name: 'judul', label: 'Judul' },
            { name: 'deskripsi', label: 'Deskripsi', type: 'textarea' },
            { name: 'tanggal', label: 'Tanggal', type: 'date' },
            { name: 'foto', label: 'Foto', type: 'file' }
        ]
    };

    const cfgInfografis = {
        name: 'infografis', title: 'Infografis', endpoint: 'infografis', hasFile: true, hasView: true,
        columns: [
            { data: 'judul', label: 'Judul' },
            { data: 'tanggal_upload', label: 'Tanggal' }
        ],
        fields: [
            { name: 'judul', label: 'Judul' },
            { name: 'deskripsi', label: 'Deskripsi', type: 'textarea' },
            { name: 'foto', label: 'Foto', type: 'file' }
        ]
    };

    const cfgDokumen = {
        name: 'dokumen', title: 'Dokumen', endpoint: 'dokumen', hasFile: true, hasView: true,
        columns: [
            { data: 'judul_file', label: 'Judul' },
            { data: 'kategori', label: 'Kategori' }
        ],
        fields: [
            { name: 'judul_file', label: 'Judul File' },
            { name: 'kategori', label: 'Kategori' },
            { name: 'file', label: 'Upload File', type: 'file' }
        ]
    };

    const cfgHalaman = {
        name: 'halaman', title: 'Halaman Statis', endpoint: 'halaman_statis', hasFile: false,
        columns: [
            { data: 'judul', label: 'Judul' },
            { data: 'slug', label: 'Slug' }
        ],
        fields: [
            { name: 'judul', label: 'Judul' },
            { name: 'konten', label: 'Konten HTML', type: 'textarea' }
        ]
    };

    const cfgPesan = {
        name: 'pesan', title: 'Pesan Masuk', endpoint: 'pesan', hasFile: false, noAdd: true, hasView: true,
        columns: [
            { data: 'nama', label: 'Nama' },
            { data: 'subjek', label: 'Subjek' },
            { data: 'status_baca', label: 'Status', render: d => (d === 't' || d === true || d == 1) ? 'Dibaca' : 'Belum' }
        ],
        fields: [
            { name: 'nama', label: 'Nama' },
            { name: 'subjek', label: 'Subjek' },
            { name: 'pesan', label: 'Pesan', type: 'textarea' }
        ]
    };

    const cfgUser = {
        name: 'user', title: 'Manajemen User', endpoint: 'user', hasFile: false, hasView: true,
        columns: [
            { data: 'name', label: 'Nama' },
            { data: 'username', label: 'Username' },
            { data: 'role', label: 'Role' }
        ],
        fields: [
            { name: 'posyandu_id', label: 'Data Posyandu', type: 'select_posyandu' },
            { name: 'name', label: 'Nama' },
            { name: 'username', label: 'Username' },
            { name: 'password', label: 'Password' },
            { name: 'role', label: 'Role', type: 'select', options: [{ value: 'admin', label: 'Admin' }, { value: 'kader', label: 'Kader' }, { value: 'bidan', label: 'Bidan' }] }
        ]
    };
});






