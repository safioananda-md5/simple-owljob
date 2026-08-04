<!DOCTYPE html>
<html lang="id" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Board - OwlJob Admin</title>
    <!-- FAVICON BURUNG HANTU (Favicon Tab Browser) -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%234f46e5'><path d='M12 2a9 9 0 0 1 9 9c0 3.1-1.5 5.8-3.9 7.4V20a2 2 0 0 1-2 2H8.9a2 2 0 0 1-2-2v-1.6A8.98 8.98 0 0 1 3 11a9 9 0 0 1 9-9z'/><circle cx='8' cy='10' r='2' fill='%23ffffff'/><circle cx='16' cy='10' r='2' fill='%23ffffff'/><path d='M12 13l-1.5 2h3L12 13z' fill='%23ffffff'/></svg>">

    <!-- Google Fonts (Inter) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        :root {
            --bg-main: #f4f6f9;
            --primary-color: #4f46e5;
            --primary-hover: #4338ca;
            --card-border: rgba(226, 232, 240, 0.8);
            --navbar-bg: #ffffff;
            --board-bg: rgba(255, 255, 255, 0.6);
            --column-bg: #f8fafc;
            --card-bg: #ffffff;
            --text-color: #334155;
            --text-muted: #64748b;
        }

        /* Variables untuk Dark Mode */
        [data-bs-theme="dark"] {
            --bg-main: #0f172a;
            --primary-color: #6366f1;
            --primary-hover: #4f46e5;
            --card-border: rgba(255, 255, 255, 0.1);
            --navbar-bg: #1e293b;
            --board-bg: rgba(30, 41, 59, 0.7);
            --column-bg: #0f172a;
            --card-bg: #1e293b;
            --text-color: #f8fafc;
            --text-muted: #94a3b8;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-main);
            color: var(--text-color);
            min-height: 100vh;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Navbar Style */
        .navbar-admin {
            background-color: var(--navbar-bg);
            border-bottom: 1px solid var(--card-border);
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .navbar-brand {
            font-weight: 700;
            letter-spacing: -0.5px;
            color: var(--primary-color) !important;
        }

        /* Search Input in Navbar */
        .search-wrapper {
            position: relative;
            max-width: 300px;
        }

        .search-wrapper .bi-search {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }

        .search-wrapper input {
            padding-left: 36px;
            background-color: var(--column-bg);
            border-color: var(--card-border);
            border-radius: 20px;
            font-size: 0.875rem;
            color: var(--text-color);
        }

        /* Breadcrumb Style */
        .breadcrumb-item a {
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 500;
        }

        .breadcrumb-item.active {
            color: var(--primary-color);
            font-weight: 600;
        }

        /* Main Kanban Board Container */
        .board-container {
            display: flex;
            flex-direction: row;
            overflow-x: auto;
            overflow-y: hidden;
            white-space: nowrap;
            padding: 1.5rem;
            height: calc(100vh - 210px);
            gap: 1.25rem;
            background-color: var(--board-bg);
            backdrop-filter: blur(8px);
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--card-border);
            transition: background-color 0.3s ease;
        }

        /* Column Style */
        .board-column {
            flex: 0 0 300px;
            max-width: 300px;
            background-color: var(--column-bg);
            border: 1px solid var(--card-border);
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            max-height: 100%;
            padding: 1rem;
            transition: background-color 0.3s ease;
        }

        .column-header span:first-child {
            white-space: normal;
            word-break: break-word;
            line-height: 1.3;
        }

        /* Column Header */
        .column-header {
            font-weight: 600;
            font-size: 0.95rem;
            padding: 0.6rem 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.5rem;
        }

        .bg-header-todo {
            background-color: #e0f2fe;
            color: #0369a1;
        }

        .bg-header-progress {
            background-color: #fef3c7;
            color: #b45309;
        }

        .bg-header-done {
            background-color: #dbeafe;
            color: #1d4ed8;
        }

        .bg-header-default {
            background-color: #f1f5f9;
            color: #475569;
        }

        /* Dark mode penyesuaian header status */
        [data-bs-theme="dark"] .bg-header-todo {
            background-color: rgba(3, 105, 161, 0.25);
            color: #38bdf8;
        }

        [data-bs-theme="dark"] .bg-header-progress {
            background-color: rgba(180, 83, 9, 0.25);
            color: #fbbf24;
        }

        [data-bs-theme="dark"] .bg-header-done {
            background-color: rgba(29, 78, 216, 0.25);
            color: #60a5fa;
        }

        [data-bs-theme="dark"] .bg-header-default {
            background-color: rgba(71, 85, 105, 0.25);
            color: #94a3b8;
        }

        /* Scrollable Column Body */
        .column-body {
            overflow-y: auto;
            flex-grow: 1;
            padding-right: 4px;
            display: flex;
            flex-direction: column;
            gap: 0.85rem;
        }

        /* Task Card Style */
        .task-card {
            background-color: var(--card-bg);
            border-radius: 10px;
            padding: 1rem;
            border: 1px solid var(--card-border);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
            white-space: normal;
            transition: all 0.2s ease-in-out;
        }

        .task-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3);
        }

        /* Custom Badges */
        .badge-custom {
            font-size: 0.7rem;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.5px;
            padding: 0.35em 0.65em;
            border-radius: 6px;
        }

        .badge-low {
            background-color: #d1fae5;
            color: #047857;
        }

        .badge-medium {
            background-color: #fef3c7;
            color: #b45309;
        }

        .badge-high {
            background-color: #fee2e2;
            color: #b91c1c;
        }

        [data-bs-theme="dark"] .badge-low {
            background-color: rgba(4, 120, 87, 0.3);
            color: #34d399;
        }

        [data-bs-theme="dark"] .badge-medium {
            background-color: rgba(180, 83, 9, 0.3);
            color: #fbbf24;
        }

        [data-bs-theme="dark"] .badge-high {
            background-color: rgba(185, 28, 28, 0.3);
            color: #f87171;
        }

        /* Custom Scrollbar */
        .column-body::-webkit-scrollbar,
        .board-container::-webkit-scrollbar {
            width: 5px;
            height: 6px;
        }

        .column-body::-webkit-scrollbar-thumb,
        .board-container::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 10px;
        }

        [data-bs-theme="dark"] .column-body::-webkit-scrollbar-thumb,
        [data-bs-theme="dark"] .board-container::-webkit-scrollbar-thumb {
            background-color: #334155;
        }
    </style>
</head>

<body>

    <!-- NAVBAR ADMIN -->
    <nav class="navbar navbar-expand-lg navbar-admin sticky-top py-2">
        <div class="container-fluid px-4 px-lg-5">
            <a class="navbar-brand d-flex align-items-center gap-2" href="#">
                <i class="bi bi-owl fs-3"></i>
                <span>OwlJob Admin</span>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="adminNavbar">
                <!-- Search Bar -->
                <div class="search-wrapper my-2 my-lg-0 ms-lg-4 me-auto">
                    <i class="bi bi-search"></i>
                    <input type="text" class="form-control" placeholder="Cari task, project..." readonly>
                </div>

                <!-- Right Menu -->
                <div class="d-flex align-items-center gap-3 mt-3 mt-lg-0">

                    <!-- TOMBOL TOGGLE DARK MODE -->
                    <button class="btn btn-outline-secondary d-flex align-items-center justify-content-center" id="themeToggle" title="Ganti Mode">
                        Theme
                    </button>

                    <div class="vr d-none d-lg-block my-2 text-secondary"></div>

                    <!-- User Profile Dropdown -->
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle gap-2" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://ui-avatars.com/api/?name=Kharisma+Safio&background=4f46e5&color=fff" alt="User Avatar" width="36" height="36" class="rounded-circle">
                            <div class="d-none d-sm-block text-start">
                                <div class="fw-semibold fs-7 lh-sm">Kharisma Safio Ananda</div>
                                <small class="text-muted fs-8">safiopertama@gmail.com</small>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i> Profil</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i> Pengaturan</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-box-arrow-right me-2"></i> Keluar</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- CONTENT WRAPPER -->
    <main class="container-fluid px-4 px-lg-5 py-4">

        <!-- HEADER & BREADCRUMB -->
        <div class="d-md-flex align-items-center justify-content-between mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="#"><i class="bi bi-house-door"></i> Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="#">Projects</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Kanban Board</li>
                    </ol>
                </nav>
                <h4 class="fw-bold mb-0">Project Board Workspace</h4>
            </div>

            <!-- Action Header Buttons -->
            <div class="mt-3 mt-md-0 d-flex gap-2">
                <span class="badge rounded-pill bg-body-tertiary text-body border px-3 py-2 fw-normal">
                    <i class="bi bi-filter me-1"></i> if0_42571180
                </span>
                <button class="btn btn-primary btn-sm rounded-pill px-3" style="background-color: var(--primary-color); border:none;"><i class="bi bi-plus-lg me-1 d-none"></i> No Function</button>
            </div>
        </div>

        <!-- MAIN KANBAN BOARD CONTAINER -->
        <div class="board-container" id="board-task">
        </div>
    </main>

    <!-- Bootstrap 5 JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>

    <!-- SCRIPT DARK MODE TOGGLE -->
    <script>
        $(document).ready(function() {
            const $html = $('html');
            const $themeToggleBtn = $('#themeToggle');
            const $themeIcon = $('#themeIcon');

            // 1. Cek mode yang tersimpan di localStorage saat halaman dimuat
            const savedTheme = localStorage.getItem('theme') || 'light';
            setTheme(savedTheme);

            // 2. Event click tombol toggle
            $themeToggleBtn.on('click', function() {
                const currentTheme = $html.attr('data-bs-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                setTheme(newTheme);
            });

            // Fungsi untuk menerapkan tema
            function setTheme(theme) {
                $html.attr('data-bs-theme', theme);
                localStorage.setItem('theme', theme);

                if (theme === 'dark') {
                    $themeIcon.removeClass('bi-moon-stars-fill').addClass('bi-sun-fill');
                    $themeToggleBtn.removeClass('btn-outline-secondary').addClass('btn-outline-warning');
                } else {
                    $themeIcon.removeClass('bi-sun-fill').addClass('bi-moon-stars-fill');
                    $themeToggleBtn.removeClass('btn-outline-warning').addClass('btn-outline-secondary');
                }
            }
        });
    </script>
</body>

</html>