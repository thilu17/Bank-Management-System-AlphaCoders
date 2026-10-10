<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMS - Loan Products Configuration</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a0ca3;
            --primary-light: #4cc9f0;
            --secondary: #7209b7;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --bg: #f8fafc;
            --card-bg: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.08);
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navbar */
        .navbar {
            background: #1e1e2f;
            padding: 16px 36px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: white;
        }

        .brand-logo {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 18px;
        }

        .nav-brand h2 {
            font-size: 18px;
            font-weight: 700;
            letter-spacing: -0.3px;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .user-pill {
            background: rgba(255, 255, 255, 0.08);
            padding: 6px 14px;
            border-radius: 30px;
            font-size: 13px;
            color: #e2e8f0;
            display: flex;
            align-items: center;
            gap: 8px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .user-pill .badge {
            background: var(--primary);
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
        }

        .btn-nav {
            padding: 8px 16px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-dash {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .btn-dash:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .btn-logout {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
        }

        .btn-logout:hover {
            background: var(--danger);
            color: white;
        }

        /* Container */
        .container {
            max-width: 1280px;
            width: 100%;
            margin: 32px auto;
            padding: 0 24px;
        }

        /* Header section */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .page-header-text h1 {
            font-size: 26px;
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.5px;
        }

        .page-header-text p {
            color: var(--text-muted);
            font-size: 14px;
            margin-top: 4px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border: none;
            padding: 12px 22px;
            border-radius: var(--radius-sm);
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(67, 97, 238, 0.35);
            transition: all 0.25s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(67, 97, 238, 0.45);
        }

        /* Alerts */
        .alert {
            padding: 14px 18px;
            border-radius: var(--radius-sm);
            font-size: 14px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: opacity 0.4s ease, transform 0.4s ease, margin 0.4s ease, max-height 0.4s ease, padding 0.4s ease;
            overflow: hidden;
            max-height: 200px;
        }

        .alert.fade-out {
            opacity: 0;
            transform: translateY(-8px);
            margin-bottom: 0;
            max-height: 0;
            padding-top: 0;
            padding-bottom: 0;
            border-color: transparent;
        }

        .alert-close {
            background: transparent;
            border: none;
            cursor: pointer;
            font-size: 18px;
            color: inherit;
            opacity: 0.7;
            padding: 0 4px;
            line-height: 1;
            margin-left: 12px;
        }

        .alert-close:hover {
            opacity: 1;
        }

        .alert-success {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert-danger {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: var(--card-bg);
            border-radius: var(--radius-md);
            padding: 22px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        .icon-blue {
            background: #eef2ff;
            color: var(--primary);
        }

        .icon-purple {
            background: #f5f3ff;
            color: var(--secondary);
        }

        .icon-green {
            background: #ecfdf5;
            color: var(--success);
        }

        .stat-content h3 {
            font-size: 24px;
            font-weight: 800;
            color: var(--text-main);
        }

        .stat-content p {
            font-size: 13px;
            color: var(--text-muted);
            font-weight: 500;
        }

        /* Products Table Card */
        .table-card {
            background: var(--card-bg);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .card-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header h2 {
            font-size: 17px;
            font-weight: 700;
            color: var(--text-main);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th {
            background: #f8fafc;
            padding: 14px 24px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border);
        }

        td {
            padding: 18px 24px;
            font-size: 14px;
            color: var(--text-main);
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background: #fdfdfd;
        }

        .product-name-box {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .product-title {
            font-weight: 700;
            color: var(--text-main);
            font-size: 15px;
        }

        .product-code {
            font-size: 12px;
            color: var(--primary);
            font-weight: 600;
            background: #eff6ff;
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            width: fit-content;
        }

        .badge-type {
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .badge-compound {
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .badge-simple {
            background: #fefce8;
            color: #854d0e;
            border: 1px solid #fef08a;
        }

        .badge-status {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-active {
            background: #ecfdf5;
            color: var(--success);
        }

        .badge-inactive {
            background: #f1f5f9;
            color: #64748b;
        }

        .rate-highlight {
            font-weight: 800;
            font-size: 15px;
            color: var(--primary-dark);
        }

        /* Action Buttons */
        .actions-cell {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-action {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all 0.2s ease;
        }

        .btn-edit {
            background: #f1f5f9;
            color: var(--text-main);
        }

        .btn-edit:hover {
            background: #e2e8f0;
        }

        .btn-toggle {
            background: #fef2f2;
            color: var(--danger);
        }

        .btn-toggle.activate {
            background: #ecfdf5;
            color: var(--success);
        }

        .btn-delete {
            background: #fff1f2;
            color: #e11d48;
        }

        .btn-delete:hover {
            background: #ffe4e6;
            color: #be123c;
        }

        /* Modal */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            padding: 20px;
        }

        .modal-card {
            background: white;
            width: 100%;
            max-width: 640px;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            animation: modalPop 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes modalPop {
            from {
                transform: scale(0.95);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .modal-header {
            padding: 20px 28px;
            background: #f8fafc;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h3 {
            font-size: 18px;
            font-weight: 700;
        }

        .modal-close {
            background: transparent;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: var(--text-muted);
        }

        .modal-body {
            padding: 28px;
            max-height: 80vh;
            overflow-y: auto;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 16px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 6px;
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            font-size: 14px;
            color: var(--text-main);
            transition: all 0.2s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
        }

        .form-hint {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 4px;
        }

        .modal-footer {
            padding: 18px 28px;
            background: #f8fafc;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }

        .btn-cancel {
            background: white;
            border: 1px solid var(--border);
            padding: 10px 18px;
            border-radius: var(--radius-sm);
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }

        .empty-state {
            padding: 60px 20px;
            text-align: center;
            color: var(--text-muted);
        }

        .empty-state h4 {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 8px;
        }
    </style>
</head>

<body>

    <!-- Top Navbar -->
    <nav class="navbar">
        <a href="<?= base_url('dashboard') ?>" class="nav-brand">
            <div class="brand-logo">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                    stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="21" x2="21" y2="21"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                    <polygon points="12 2 3 7 21 7 12 2"></polygon>
                    <line x1="5" y1="10" x2="5" y2="21"></line>
                    <line x1="9" y1="10" x2="9" y2="21"></line>
                    <line x1="15" y1="10" x2="15" y2="21"></line>
                    <line x1="19" y1="10" x2="19" y2="21"></line>
                </svg>
            </div>
            <h2> Bank Management</h2>
        </a>
        <div class="nav-actions">
            <div class="user-pill">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                <span><?= esc($username ?? 'Branch Manager') ?></span>
                <span class="badge"><?= esc($role ?? 'Branch Manager') ?></span>
            </div>
            <a href="<?= base_url('dashboard') ?>" class="btn-nav btn-dash">Dashboard</a>
            <a href="<?= base_url('logout') ?>" class="btn-nav btn-logout">Logout</a>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="container">

        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-text">
                <h1>Loan Product Engine</h1>
                <p>Configure bank loan schemes, interest calculation models (Simple vs Compound EMI), and limits.</p>
            </div>
            <button class="btn-primary" onclick="openModal()">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                    stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                <span>Configure New Loan Type</span>
            </button>
        </div>

        <!-- Feedback Alerts -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success auto-dismiss">
                <span style="display: flex; align-items: center; gap: 8px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    <?= session()->getFlashdata('success') ?>
                </span>
                <button type="button" class="alert-close" onclick="dismissAlert(this.parentElement)"
                    aria-label="Close">&times;</button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger auto-dismiss">
                <span style="display: flex; align-items: center; gap: 8px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="15" y1="9" x2="9" y2="15"></line>
                        <line x1="9" y1="9" x2="15" y2="15"></line>
                    </svg>
                    <?= session()->getFlashdata('error') ?>
                </span>
                <button type="button" class="alert-close" onclick="dismissAlert(this.parentElement)"
                    aria-label="Close">&times;</button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger auto-dismiss">
                <div>
                    <strong style="display: block; margin-bottom: 4px;">Please correct the following:</strong>
                    <ul style="padding-left: 18px;">
                        <?php foreach (session()->getFlashdata('errors') as $err): ?>
                            <li><?= esc($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <button type="button" class="alert-close" onclick="dismissAlert(this.parentElement)"
                    aria-label="Close">&times;</button>
            </div>
        <?php endif; ?>

        <!-- Stats Overview Cards -->
        <?php
        $totalProducts = count($products ?? []);
        $activeCount = 0;
        $compoundCount = 0;
        foreach ($products ?? [] as $p) {
            if ($p['is_active'])
                $activeCount++;
            if ($p['interest_type'] === 'compound')
                $compoundCount++;
        }
        ?>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon icon-blue">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                    </svg>
                </div>
                <div class="stat-content">
                    <h3><?= $totalProducts ?></h3>
                    <p>Total Loan Products</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon icon-green">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                </div>
                <div class="stat-content">
                    <h3><?= $activeCount ?></h3>
                    <p>Active Loan Offerings</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon icon-purple">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                        <polyline points="17 6 23 6 23 12"></polyline>
                    </svg>
                </div>
                <div class="stat-content">
                    <h3><?= $compoundCount ?></h3>
                    <p>Reducing Balance (EMI) Types</p>
                </div>
            </div>
        </div>

        <!-- Products Table -->
        <div class="table-card">
            <div class="card-header">
                <h2>Configured Loan Products</h2>
                <span style="font-size: 13px; color: var(--text-muted);">Manage interest rates & tenure rules</span>
            </div>

            <?php if (empty($products)): ?>
                <div class="empty-state">
                    <h4>No loan products configured yet</h4>
                    <p>Click "Configure New Loan Type" to define your bank's first loan offering.</p>
                </div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Product Name & Code</th>
                            <th>Interest Rate</th>
                            <th>Calculation Rule</th>
                            <th>Amount Range (LKR)</th>
                            <th>Tenure Range</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td>
                                    <div class="product-name-box">
                                        <span class="product-title"><?= esc($product['name']) ?></span>
                                        <span class="product-code"><?= esc($product['code']) ?></span>
                                    </div>
                                </td>
                                <td>
                                    <span class="rate-highlight"><?= number_format($product['interest_rate'], 2) ?>%</span>
                                    <span style="font-size: 12px; color: var(--text-muted); display: block;">p.a.</span>
                                </td>
                                <td>
                                    <?php if ($product['interest_type'] === 'compound'): ?>
                                        <span class="badge-type badge-compound">Compound (Reducing EMI)</span>
                                    <?php else: ?>
                                        <span class="badge-type badge-simple">Simple (Flat Rate)</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong>Rs. <?= number_format($product['min_amount'], 2) ?></strong><br>
                                    <span style="font-size: 12px; color: var(--text-muted);">to Rs.
                                        <?= number_format($product['max_amount'], 2) ?></span>
                                </td>
                                <td>
                                    <strong><?= esc($product['min_tenure_months']) ?> -
                                        <?= esc($product['max_tenure_months']) ?></strong>
                                    <span style="font-size: 12px; color: var(--text-muted);">Months</span>
                                </td>
                                <td>
                                    <?php if ($product['is_active']): ?>
                                        <span class="badge-status badge-active">● Active</span>
                                    <?php else: ?>
                                        <span class="badge-status badge-inactive">● Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="actions-cell">
                                        <button class="btn-action btn-edit"
                                            onclick='editProduct(<?= json_encode($product) ?>)'>Edit</button>
                                        <a href="<?= base_url('loans/products/toggle/' . $product['id']) ?>"
                                            class="btn-action btn-toggle <?= $product['is_active'] ? '' : 'activate' ?>">
                                            <?= $product['is_active'] ? 'Deactivate' : 'Activate' ?>
                                        </a>
                                        <a href="<?= base_url('loans/products/delete/' . $product['id']) ?>"
                                            class="btn-action btn-delete"
                                            onclick="return confirm('Are you sure you want to delete \'<?= esc(addslashes($product['name'])) ?>\'?');">
                                            Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

    <!-- Create / Edit Modal -->
    <div class="modal-overlay" id="productModal">
        <div class="modal-card">
            <div class="modal-header">
                <h3 id="modalTitle">Configure Loan Product</h3>
                <button class="modal-close" onclick="closeModal()">&times;</button>
            </div>
            <form id="productForm" method="POST" action="<?= base_url('loans/products/create') ?>">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Product Name *</label>
                            <input type="text" name="name" id="name" class="form-control"
                                placeholder="e.g. Personal Express Loan" required>
                        </div>
                        <div class="form-group">
                            <label for="code">Product Code *</label>
                            <input type="text" name="code" id="code" class="form-control" placeholder="e.g. PL-01"
                                required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="2"
                            placeholder="Eligibility, requirements, or product overview..."></textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="interest_rate">Base Interest Rate (% per annum) *</label>
                            <input type="number" step="0.01" min="0.01" max="100" name="interest_rate"
                                id="interest_rate" class="form-control" placeholder="e.g. 12.50" required>
                        </div>
                        <div class="form-group">
                            <label for="interest_type">Interest Calculation Rule *</label>
                            <select name="interest_type" id="interest_type" class="form-control" required>
                                <option value="compound">Compound / Reducing Balance (Standard EMI)</option>
                                <option value="simple">Simple / Flat Rate</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="min_amount">Min Loan Amount (LKR) *</label>
                            <input type="number" step="1000" name="min_amount" id="min_amount" class="form-control"
                                placeholder="50000" required>
                        </div>
                        <div class="form-group">
                            <label for="max_amount">Max Loan Amount (LKR) *</label>
                            <input type="number" step="1000" name="max_amount" id="max_amount" class="form-control"
                                placeholder="2000000" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="min_tenure_months">Min Tenure (Months) *</label>
                            <input type="number" min="1" name="min_tenure_months" id="min_tenure_months"
                                class="form-control" placeholder="6" required>
                        </div>
                        <div class="form-group">
                            <label for="max_tenure_months">Max Tenure (Months) *</label>
                            <input type="number" min="1" name="max_tenure_months" id="max_tenure_months"
                                class="form-control" placeholder="60" required>
                        </div>
                    </div>

                    <div class="form-group" style="display: flex; align-items: center; gap: 8px; margin-top: 10px;">
                        <input type="checkbox" name="is_active" id="is_active" value="1" checked>
                        <label for="is_active" style="margin-bottom: 0; cursor: pointer;">Available for new customer
                            applications immediately</label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn-primary" id="modalSubmitBtn">Save Configuration</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('productModal');
        const form = document.getElementById('productForm');
        const modalTitle = document.getElementById('modalTitle');
        const submitBtn = document.getElementById('modalSubmitBtn');

        function openModal() {
            modalTitle.innerText = "Configure New Loan Product";
            submitBtn.innerText = "Save Configuration";
            form.action = "<?= base_url('loans/products/create') ?>";
            form.reset();
            document.getElementById('is_active').checked = true;
            modal.style.display = 'flex';
        }

        function closeModal() {
            modal.style.display = 'none';
        }

        function editProduct(product) {
            modalTitle.innerText = "Edit Loan Product: " + product.name;
            submitBtn.innerText = "Update Configuration";
            form.action = "<?= base_url('loans/products/update') ?>/" + product.id;

            document.getElementById('name').value = product.name;
            document.getElementById('code').value = product.code;
            document.getElementById('description').value = product.description || '';
            document.getElementById('interest_rate').value = product.interest_rate;
            document.getElementById('interest_type').value = product.interest_type;
            document.getElementById('min_amount').value = product.min_amount;
            document.getElementById('max_amount').value = product.max_amount;
            document.getElementById('min_tenure_months').value = product.min_tenure_months;
            document.getElementById('max_tenure_months').value = product.max_tenure_months;
            document.getElementById('is_active').checked = (product.is_active == 1);

            modal.style.display = 'flex';
        }

        // Close when clicking backdrop
        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                closeModal();
            }
        });

        // Dismiss alert smoothly
        function dismissAlert(alertElem) {
            if (!alertElem) return;
            alertElem.classList.add('fade-out');
            setTimeout(() => {
                alertElem.remove();
            }, 450);
        }

        // Auto-dismiss toast alerts after 4 seconds
        document.addEventListener('DOMContentLoaded', () => {
            const alerts = document.querySelectorAll('.auto-dismiss');
            alerts.forEach(alert => {
                setTimeout(() => {
                    dismissAlert(alert);
                }, 4000);
            });
        });
    </script>
</body>

</html>