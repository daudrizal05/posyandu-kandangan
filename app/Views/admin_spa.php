<style>
    /* Reset for SPA to prevent inheriting unwanted global styles */
    #adminSpaOverlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: #ffffff;
        z-index: 1040;
        display: none;
        flex-direction: row;
        font-family: 'Poppins', sans-serif;
        color: #1e293b;
        overflow: hidden;
    }

    #adminSpaOverlay.active {
        display: flex;
    }

    /* Sidebar */
    .spa-sidebar {
        width: 260px;
        background: #ffffff;
        color: #1e293b;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        flex-shrink: 0;
        border-right: 1px solid #e2e8f0;
    }

    .spa-brand {
        height: 72px;
        min-height: 72px;
        max-height: 72px;
        flex: 0 0 72px;
        padding: 0 15px;
        font-size: 20px;
        font-weight: 800;
        border-bottom: 1px solid #1e3a8a;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: #1e40af;
        color: #ffffff;
        box-sizing: border-box;
        text-align: center;
        line-height: 1.2;
    }

    .spa-brand small {
        font-size: 9px;
        font-weight: 400;
        letter-spacing: 0.5px;
        color: #cbd5e1;
    }

    .brand-mini {
        display: none;
        font-size: 28px;
        font-weight: 800;
    }

    .spa-sidebar.collapsed .brand-full {
        display: none;
    }

    .spa-sidebar.collapsed .brand-mini {
        display: block;
    }

    .menu-header {
        font-size: 11px;
        color: #94a3b8;
        font-weight: 700;
        padding: 15px 16px 5px;
        margin-top: 10px;
        letter-spacing: 0.5px;
    }

    .spa-sidebar.collapsed .menu-header {
        display: none;
    }

    .spa-menu {
        list-style: none;
        padding: 10px 0;
        margin: 0;
        flex: 1;
        overflow-y: auto;
        overflow-x: hidden;
    }

    /* Custom scrollbar for sidebar */
    .spa-menu::-webkit-scrollbar {
        width: 6px;
    }
    .spa-menu::-webkit-scrollbar-track {
        background: transparent;
    }
    .spa-menu::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }
    .spa-menu::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    .spa-menu li {
        padding: 4px 16px;
    }

    .spa-menu a {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 16px;
        color: #64748b;
        text-decoration: none;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.2s;
        font-weight: 500;
    }

    .spa-menu a:hover,
    .spa-menu a.active {
        background: #eff4ff;
        color: #1a56db;
        font-weight: 600;
    }

    .spa-menu i {
        width: 20px;
        text-align: center;
    }

    /* Sidebar Toggle State */
    .spa-sidebar {
        transition: width 0.3s;
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .spa-sidebar::-webkit-scrollbar {
        display: none;
    }

    .spa-sidebar.collapsed {
        width: 70px;
        overflow: hidden;
    }

    .spa-sidebar.collapsed .spa-nav-link span {
        display: none;
    }

    .spa-sidebar.collapsed .spa-nav-link i {
        margin: 0;
        font-size: 20px;
        width: 100%;
        text-align: center;
    }

    .spa-sidebar.collapsed .spa-menu a {
        justify-content: center;
        padding: 15px 0;
    }

    .btn-hamburger {
        background: none;
        border: none;
        font-size: 20px;
        color: #1e293b;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 8px;
        transition: background 0.2s;
    }

    .btn-hamburger:hover {
        background: #e2e8f0;
    }

    /* Main Area */
    .spa-main {
        flex: 1;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        background: #ffffff;
        position: relative;
    }

    .spa-header {
        background: #1e40af;
        padding: 0 25px;
        display: flex;
        height: 72px;
        box-sizing: border-box;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #1e3a8a;
        color: #ffffff;
        z-index: 2;
        position: relative;
    }

    .spa-header h2 {
        font-size: 20px;
        font-weight: 600;
        margin: 0;
        color: #ffffff;
    }

    .btn-hamburger {
        background: none;
        border: none;
        font-size: 22px;
        color: #ffffff;
        cursor: pointer;
        margin-right: 15px;
        padding: 5px;
    }

    .spa-header-left {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .btn-close-spa {
        background: #ef4444;
        color: #fff;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-close-spa:hover {
        background: #dc2626;
    }

    /* Content Area */
    .spa-content {
        flex: 1;
        padding: 5px 24px 24px;
        overflow-y: auto;
        background: #F8F9FB;
    }

    .dash-section-title:first-child {
        margin-top: 5px;
    }

    /* ---- Analytics Dashboard (SPA) ---- */
    .an-card {
        background: #ffffff;
        border: 1px solid #E8ECF1;
        border-radius: 14px;
        padding: 22px 24px;
        transition: box-shadow 0.22s, transform 0.22s;
    }
    .an-card:hover {
        box-shadow: 0 8px 24px rgba(0,0,0,0.07);
        transform: translateY(-2px);
    }
    .an-card-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 14px;
    }
    .an-card-label {
        font-size: 13px;
        font-weight: 500;
        color: #8B95A5;
    }
    .an-card-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        flex-shrink: 0;
    }
    .an-card-value {
        font-size: 32px;
        font-weight: 800;
        color: #1A1D23;
        line-height: 1;
        margin-bottom: 8px;
        font-family: 'Inter', 'Poppins', sans-serif;
    }
    .an-card-trend {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        font-weight: 500;
    }
    .an-card-trend.up { color: #059669; }
    .an-card-trend.down { color: #dc2626; }
    .an-card-trend.neutral { color: #8B95A5; }
    .an-card-trend i { font-size: 10px; }

    .an-card-body-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .an-mini-donut {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: conic-gradient(
            var(--donut-color) calc(var(--donut-pct) * 1%),
            #E8ECF1 calc(var(--donut-pct) * 1%)
        );
        position: relative;
        flex-shrink: 0;
    }
    .an-mini-donut::after {
        content: '';
        position: absolute;
        top: 8px; left: 8px; right: 8px; bottom: 8px;
        border-radius: 50%;
        background: #fff;
    }

    .an-chart-card {
        background: #ffffff;
        border: 1px solid #E8ECF1;
        border-radius: 14px;
        overflow: hidden;
        height: 100%;
    }
    .an-chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 18px 24px;
        border-bottom: 1px solid #F3F4F6;
    }
    .an-chart-header h3 {
        font-size: 15px;
        font-weight: 600;
        color: #1A1D23;
        margin: 0;
    }
    .an-chart-badge {
        font-size: 12px;
        font-weight: 500;
        color: #8B95A5;
        background: #F8F9FB;
        padding: 5px 12px;
        border-radius: 6px;
        border: 1px solid #E8ECF1;
    }
    .an-chart-body {
        padding: 20px 24px 24px;
    }

    .an-mini-summary-card {
        background: #ffffff;
        border: 1px solid #E8ECF1;
        border-radius: 14px;
        padding: 22px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: box-shadow 0.22s;
    }
    .an-mini-summary-card:hover {
        box-shadow: 0 6px 20px rgba(0,0,0,0.06);
    }
    .an-mini-summary-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .an-mini-summary-avatars {
        display: flex;
        align-items: center;
    }
    .an-mini-summary-avatars .av {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #fff;
    }
    .an-mini-summary-avatars .av + .av {
        margin-left: -8px;
    }
    .an-mini-summary-value {
        font-size: 22px;
        font-weight: 800;
        color: #1A1D23;
        line-height: 1.2;
    }
    .an-mini-summary-label {
        font-size: 12px;
        color: #8B95A5;
        font-weight: 500;
    }
    .an-mini-summary-badge {
        font-size: 11px;
        font-weight: 600;
        padding: 5px 10px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .an-mini-summary-badge.up {
        background: #ECFDF5;
        color: #059669;
    }
    .an-mini-summary-badge.neutral {
        background: #EFF6FF;
        color: #2563eb;
    }

    .an-table-body { padding: 0; }
    .an-summary-table {
        width: 100%;
        border-collapse: collapse;
    }
    .an-summary-table th {
        background: #F8F9FB;
        padding: 12px 24px;
        font-size: 11px;
        font-weight: 600;
        color: #8B95A5;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        text-align: left;
        border-bottom: 1px solid #E8ECF1;
    }
    .an-summary-table td {
        padding: 14px 24px;
        font-size: 13.5px;
        color: #1A1D23;
        border-bottom: 1px solid #F3F4F6;
    }
    .an-summary-table tr:last-child td { border-bottom: none; }
    .an-summary-table tr:hover td { background: #FAFBFC; }
    .an-row-info {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 500;
    }
    .an-row-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
    }
    .an-status-badge {
        font-size: 11px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 20px;
    }
    .an-status-badge.active { background: #ECFDF5; color: #059669; }
    .an-status-badge.warning { background: #FFF7ED; color: #ea580c; }

    .an-grid-row { display: grid; gap: 16px; margin-bottom: 16px; }
    .an-grid-4 { grid-template-columns: repeat(4, 1fr); }
    .an-grid-2 { grid-template-columns: repeat(2, 1fr); }
    .an-grid-bar { grid-template-columns: 58% 1fr; }
    .an-grid-doughnut { grid-template-columns: 42% 1fr; }

    @media (max-width: 1024px) {
        .an-grid-4 { grid-template-columns: repeat(2, 1fr); }
        .an-grid-bar, .an-grid-doughnut { grid-template-columns: 1fr; }
    }
    @media (max-width: 640px) {
        .an-grid-4, .an-grid-2 { grid-template-columns: 1fr; }
    }

    /* Modals */
    .spa-modal {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1050;
        display: none;
        align-items: center;
        justify-content: center;
    }

    .spa-modal.active {
        display: flex;
    }

    .spa-modal-content {
        background: #fff;
        width: 500px;
        max-width: 90%;
        border-radius: 12px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        max-height: 90vh;
    }

    .spa-modal-header {
        padding: 16px 24px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .spa-modal-header h3 {
        margin: 0;
        font-size: 18px;
    }

    .spa-modal-close {
        background: none;
        border: none;
        font-size: 20px;
        cursor: pointer;
        color: #64748b;
    }

    .spa-modal-body {
        padding: 24px;
        overflow-y: auto;
    }

    .spa-modal-footer {
        padding: 16px 24px;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
        gap: 12px;
    }

    /* Forms & Tables */
    .form-group {
        margin-bottom: 16px;
    }

    .form-group label {
        display: block;
        margin-bottom: 6px;
        font-weight: 500;
        font-size: 14px;
    }

    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-family: inherit;
        font-size: 14px;
        outline: none;
    }

    .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
    }

    .btn-primary-spa {
        background: #3b82f6;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 500;
    }

    .btn-primary-spa:hover {
        background: #2563eb;
    }

    .btn-secondary-spa {
        background: #e2e8f0;
        color: #1e293b;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 500;
    }

    .btn-secondary-spa:hover {
        background: #cbd5e1;
    }

    .table-card {
        background: #fff;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .table-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
        align-items: center;
    }

    table.dataTable {
        width: 100% !important;
        border-collapse: collapse !important;
    }

    table.dataTable th,
    table.dataTable td {
        padding: 12px 16px;
        border-bottom: 1px solid #e2e8f0;
        text-align: left;
    }

    table.dataTable th {
        background: #f8fafc;
        font-weight: 600;
        color: #475569;
    }

    /* Dashboard Redesign */
    .dash-section-title {
        font-size: 16px;
        font-weight: 600;
        color: #475569;
        margin: 24px 0 12px;
        padding-bottom: 8px;
        border-bottom: 2px solid #e2e8f0;
    }

    .stats-grid-group {
        display: grid;
        gap: 16px;
        margin-bottom: 24px;
    }

    .grid-4 {
        grid-template-columns: repeat(4, 1fr);
    }

    .grid-3 {
        grid-template-columns: repeat(3, 1fr);
    }

    .grid-2 {
        grid-template-columns: repeat(2, 1fr);
    }

    @media (max-width: 1024px) {

        .grid-4,
        .grid-3,
        .grid-2 {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 640px) {

        .grid-4,
        .grid-3,
        .grid-2 {
            grid-template-columns: 1fr;
        }
    }

    .stat-card-admin {
        padding: 24px;
        position: relative;
        overflow: hidden;
        transition: transform .22s;
        color: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .stat-card-admin:hover {
        transform: translateY(-3px);
    }

    .stat-card-admin.c1 {
        background: #1a56db;
    }

    .stat-card-admin.c2 {
        background: #1e90ff;
    }

    .stat-card-admin.c3 {
        background: #1344b0;
    }

    .stat-card-admin.c4 {
        background: #0e337a;
    }

    .stat-card-admin .stat-bg-icon {
        position: absolute;
        right: -20px;
        bottom: -20px;
        font-size: 110px;
        color: rgba(255, 255, 255, 0.15);
        pointer-events: none;
        z-index: 0;
    }

    .stat-card-admin>div {
        position: relative;
        z-index: 1;
    }

    .stat-card-admin .stat-label {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1.2px;
        text-transform: uppercase;
        color: rgba(255, 255, 255, .85);
        margin-bottom: 12px;
    }

    .stat-card-admin .stat-value {
        font-size: 38px;
        font-weight: 800;
        color: #fff;
        line-height: 1;
        margin-bottom: 8px;
    }

    .stat-card-admin .stat-trend {
        font-size: 12.5px;
        font-weight: 500;
        color: rgba(255, 255, 255, .9);
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* Action Card / Laporan */
    .action-card {
        background: #fff;
        border: 2px dashed #cbd5e1;
        color: #1e293b;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 24px;
        border-radius: 12px;
        text-decoration: none;
        transition: all 0.2s;
        cursor: pointer;
        gap: 12px;
        height: 100%;
        box-sizing: border-box;
    }

    .action-card:hover {
        border-color: #3b82f6;
        background: #eff6ff;
        color: #1d4ed8;
        transform: translateY(-3px);
    }

    .action-card i {
        font-size: 32px;
        color: #3b82f6;
    }

    .action-card span {
        font-weight: 600;
        font-size: 16px;
    }

    /* Chart Containers */
    .charts-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-bottom: 24px;
    }

    @media (max-width: 1024px) {
        .charts-grid {
            grid-template-columns: 1fr;
        }
    }

    .chart-box {
        background: #fff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .chart-title {
        font-size: 15px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 16px;
        text-align: center;
    }

    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .empty-state {
        text-align: center;
        color: #94a3b8;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
    }

    .empty-state i {
        font-size: 32px;
        color: #cbd5e1;
    }

    /* Activity Feed */
    .activity-feed {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .activity-feed h3 {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 16px;
        color: #1e293b;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 12px;
    }

    .activity-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #eff6ff;
        color: #3b82f6;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
    }

    .activity-text {
        font-size: 14px;
        color: #475569;
    }

    /* Sidebar Footer Styles */
    .spa-sidebar-footer {
        margin-top: auto;
        border-top: 1px solid #f1f5f9;
        display: flex;
        flex-direction: column;
    }
    
    .sidebar-user-profile {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 20px 24px;
    }
    
    .user-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background-color: #40c4aa;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 16px;
        flex-shrink: 0;
    }
    
    .user-details {
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }
    
    .user-name {
        font-size: 14.5px;
        font-weight: 600;
        color: #0f172a;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .user-role {
        font-size: 12px;
        color: #64748b;
    }
    

    .sidebar-logout {
        padding: 0 24px 24px;
    }
    
    .btn-logout-sidebar {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #2563eb;
        color: #2563eb;
        background: transparent;
        text-decoration: none;
        font-weight: 500;
        font-size: 14px;
        transition: all 0.2s;
    }
    
    .btn-logout-sidebar:hover {
        background-color: #2563eb;
        color: #ffffff;
    }

    .spa-sidebar.collapsed .spa-sidebar-footer {
        display: none;
    }
</style>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div id="adminSpaOverlay">
    <!-- Sidebar -->
    <div class="spa-sidebar">
        <div class="spa-brand">
            <span class="brand-full">SIPOSKA</span>
            <span class="brand-mini">S</span>
        </div>
        <ul class="spa-menu">
            <li><a href="#dashboard" class="spa-nav-link" data-page="dashboard"><i class="fas fa-home"></i>
                    <span>Dashboard</span></a></li>
            <li><a href="#" onclick="event.preventDefault(); $('#adminSpaOverlay').removeClass('active'); $('body').css('overflow', 'auto'); localStorage.removeItem('adminSpaOpen');" class="spa-nav-link" style="color:#3b82f6;"><i class="fas fa-globe"></i>
                    <span>Halaman Depan</span></a></li>
            <li class="menu-header">DATA UTAMA</li>
            <li><a href="#posyandu" class="spa-nav-link" data-page="posyandu"><i class="fas fa-hospital"></i>
                    <span>Data Posyandu</span></a></li>
            <li><a href="#balita" class="spa-nav-link" data-page="balita"><i class="fas fa-child"></i> <span>Data
                        Balita</span></a></li>
            <li><a href="#pengukuran" class="spa-nav-link" data-page="pengukuran"><i class="fas fa-weight"></i>
                    <span>Data Pengukuran Balita</span></a></li>
            <li><a href="#ibu-hamil" class="spa-nav-link" data-page="ibu_hamil"><i class="fas fa-female"></i> <span>Data
                        Ibu Hamil</span></a></li>
            <li><a href="#remaja" class="spa-nav-link" data-page="remaja"><i class="fas fa-user-graduate"></i>
                    <span>Data Remaja</span></a></li>
            <li><a href="#usia-produktif" class="spa-nav-link" data-page="usia_produktif"><i class="fas fa-briefcase"></i>
                    <span>Data Usia Produktif</span></a></li>
            <li><a href="#lansia" class="spa-nav-link" data-page="lansia"><i class="fas fa-user-friends"></i> <span>Data
                        Lansia</span></a></li>
            <li class="menu-header">LAINNYA</li>
            <li><a href="#laporan" class="spa-nav-link" data-page="laporan"><i class="fas fa-print"></i> <span>Cetak
                        Laporan</span></a></li>
            <li><a href="#user" class="spa-nav-link" data-page="user"><i class="fas fa-users"></i> <span>Manajemen
                        User</span></a></li>
        </ul>
        
        <div class="spa-sidebar-footer">
            <?php 
                $userName = session()->get('name') ?? 'Admin';
                $userRole = session()->get('role') ?? 'Administrator';
                $nameParts = explode(' ', trim($userName));
                $initials = strtoupper(substr($nameParts[0] ?? 'A', 0, 1) . substr($nameParts[1] ?? '', 0, 1));
                
                if ($userRole == 'superadmin') $roleText = 'Super Admin';
                elseif ($userRole == 'admin_dinas') $roleText = 'Admin Dinas';
                else $roleText = 'Bidan Puskesmas';
            ?>
            <div class="sidebar-user-profile">
                <div class="user-avatar"><?= $initials ?></div>
                <div class="user-details">
                    <div class="user-name"><?= esc($userName) ?></div>
                    <div class="user-role"><?= esc($roleText) ?></div>
                </div>
            </div>
            

            <div class="sidebar-logout">
                <a href="<?= site_url('logout') ?>" class="btn-logout-sidebar">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="spa-main">
        <div class="spa-header">
            <div class="spa-header-left">
                <button class="btn-hamburger" id="btnToggleSidebar"><i class="fas fa-bars"></i></button>
                <h2 id="spaPageTitle">Dashboard</h2>
            </div>
        </div>
        <div class="spa-content" id="spaContent" style="position: relative; z-index: 1;">
            <!-- Dynamic Content Renders Here -->
        </div>
    </div>
</div>

<!-- Global Modal Container for forms -->
<div class="spa-modal" id="spaModal">
    <div class="spa-modal-content" id="spaModalContent">
        <!-- Injected via JS -->
    </div>
</div>

<script>
    let basePath = window.location.pathname;
    if (basePath.endsWith('index.php')) basePath = basePath.replace('index.php', '');
    if (!basePath.endsWith('/')) basePath += '/';
    const API_BASE_URL = window.location.origin + basePath + 'index.php/api/admin/';
    const CSRF_TOKEN = '<?= csrf_hash() ?>'; // Might need updating if token mismatch
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="<?= base_url('assets/js/admin_spa.js?v=' . time()) ?>"></script>
<style>
    /* Force DataTables text center for headers and data cells */
    table.dataTable th,
    table.dataTable td,
    table.dataTable thead th,
    .dt-center {
        text-align: center !important;
        vertical-align: middle !important;
    }
</style>