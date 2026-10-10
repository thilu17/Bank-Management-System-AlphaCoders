<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMS - Loan Applications Queue</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
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
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 12px rgba(0,0,0,0.06);
            --shadow-lg: 0 10px 25px rgba(0,0,0,0.08);
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', 'Inter', sans-serif; }

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
            box-shadow: 0 4px 20px rgba(0,0,0,0.12);
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

        .nav-brand h2 { font-size: 18px; font-weight: 700; letter-spacing: -0.3px; }

        .nav-actions { display: flex; align-items: center; gap: 16px; }

        .user-pill {
            background: rgba(255,255,255,0.08);
            padding: 6px 14px;
            border-radius: 30px;
            font-size: 13px;
            color: #e2e8f0;
            display: flex;
            align-items: center;
            gap: 8px;
            border: 1px solid rgba(255,255,255,0.1);
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

        .btn-dash { background: rgba(255,255,255,0.1); color: white; }
        .btn-dash:hover { background: rgba(255,255,255,0.2); }
        .btn-logout { background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.3); color: #fca5a5; }
        .btn-logout:hover { background: var(--danger); color: white; }

        /* Container */
        .container {
            max-width: 1280px;
            width: 100%;
            margin: 32px auto;
            padding: 0 24px;
        }

        /* Header */
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
            text-decoration: none;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(67, 97, 238, 0.45);
        }

        /* Filter Tabs */
        .filter-tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .filter-tab {
            padding: 8px 16px;
            background: white;
            border: 1px solid var(--border);
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-muted);
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .filter-tab:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .filter-tab.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        /* Table Card */
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

        .card-header h2 { font-size: 17px; font-weight: 700; }

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

        tr:hover td { background: #fdfdfd; }

        /* Badges */
        .badge-status {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .status-pending { background: #fefce8; color: #a16207; border: 1px solid #fef08a; }
        .status-approved { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
        .status-rejected { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
        .status-disbursed { background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; }

        .btn-view {
            padding: 6px 14px;
            background: #f1f5f9;
            color: var(--text-main);
            border-radius: 6px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.2s ease;
        }
        .btn-view:hover { background: #e2e8f0; }

        /* Alerts */
        .alert {
            padding: 14px 18px;
            border-radius: var(--radius-sm);
            font-size: 14px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: opacity 0.4s ease, transform 0.4s ease, max-height 0.4s ease;
            overflow: hidden;
        }
        .alert.fade-out { opacity: 0; transform: translateY(-8px); max-height: 0; padding-top: 0; padding-bottom: 0; }
        .alert-success { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
        .alert-close { background: transparent; border: none; cursor: pointer; font-size: 18px; color: inherit; }

        .empty-state {
            padding: 60px 20px;
            text-align: center;
            color: var(--text-muted);
        }
    </style>
</head>
<body>

    <!-- Top Navbar -->
    <nav class="navbar">
        <a href="<?= base_url('dashboard') ?>" class="nav-brand">
            <div class="brand-logo">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="21" x2="21" y2="21"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                    <polygon points="12 2 3 7 21 7 12 2"></polygon>
                    <line x1="5" y1="10" x2="5" y2="21"></line>
                    <line x1="9" y1="10" x2="9" y2="21"></line>
                    <line x1="15" y1="10" x2="15" y2="21"></line>
                    <line x1="19" y1="10" x2="19" y2="21"></line>
                </svg>
            </div>
            <h2>Bank Management</h2>
        </a>
        <div class="nav-actions">
            <div class="user-pill">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                <span><?= esc($username ?? 'Loan Officer') ?></span>
                <span class="badge"><?= esc($role ?? 'Loan Officer') ?></span>
            </div>
            <a href="<?= base_url('loans/products') ?>" class="btn-nav btn-dash">Loan Products</a>
            <a href="<?= base_url('dashboard') ?>" class="btn-nav btn-dash">Dashboard</a>
            <a href="<?= base_url('logout') ?>" class="btn-nav btn-logout">Logout</a>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="container">

        <!-- Header -->
        <div class="page-header">
            <div class="page-header-text">
                <h1>Loan Applications Queue</h1>
                <p>Manage submitted loan proposals, credit review states, and officer recommendations.</p>
            </div>
            <a href="<?= base_url('loans/apply') ?>" class="btn-primary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                <span>Submit New Application</span>
            </a>
        </div>

        <!-- Toast Alerts -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success auto-dismiss">
                <span style="display: flex; align-items: center; gap: 8px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    <?= session()->getFlashdata('success') ?>
                </span>
                <button type="button" class="alert-close" onclick="dismissAlert(this.parentElement)">&times;</button>
            </div>
        <?php endif; ?>

        <!-- Filter Tabs -->
        <div class="filter-tabs">
            <a href="<?= base_url('loans/applications') ?>" class="filter-tab <?= empty($statusFilter) ? 'active' : '' ?>" style="display: inline-flex; align-items: center; gap: 6px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="8" y1="6" x2="21" y2="6"></line>
                    <line x1="8" y1="12" x2="21" y2="12"></line>
                    <line x1="8" y1="18" x2="21" y2="18"></line>
                    <line x1="3" y1="6" x2="3.01" y2="6"></line>
                    <line x1="3" y1="12" x2="3.01" y2="12"></line>
                    <line x1="3" y1="18" x2="3.01" y2="18"></line>
                </svg>
                <span>All Applications</span>
            </a>
            <a href="<?= base_url('loans/applications?status=Pending Review') ?>" class="filter-tab <?= ($statusFilter === 'Pending Review') ? 'active' : '' ?>" style="display: inline-flex; align-items: center; gap: 6px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
                <span>Pending Review</span>
            </a>
            <a href="<?= base_url('loans/applications?status=Approved') ?>" class="filter-tab <?= ($statusFilter === 'Approved') ? 'active' : '' ?>" style="display: inline-flex; align-items: center; gap: 6px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
                <span>Approved</span>
            </a>
            <a href="<?= base_url('loans/applications?status=Disbursed') ?>" class="filter-tab <?= ($statusFilter === 'Disbursed') ? 'active' : '' ?>" style="display: inline-flex; align-items: center; gap: 6px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                </svg>
                <span>Disbursed</span>
            </a>
            <a href="<?= base_url('loans/applications?status=Rejected') ?>" class="filter-tab <?= ($statusFilter === 'Rejected') ? 'active' : '' ?>" style="display: inline-flex; align-items: center; gap: 6px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="15" y1="9" x2="9" y2="15"></line>
                    <line x1="9" y1="9" x2="15" y2="15"></line>
                </svg>
                <span>Rejected</span>
            </a>
        </div>

        <!-- Applications Table -->
        <div class="table-card">
            <div class="card-header">
                <h2>Submitted Applications (<?= count($applications ?? []) ?>)</h2>
                <span style="font-size: 13px; color: var(--text-muted);">Real-time underwriting queue</span>
            </div>

            <?php if (empty($applications)): ?>
                <div class="empty-state">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color: #cbd5e1; margin-bottom: 12px;">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                    </svg>
                    <h4 style="font-size: 16px; font-weight: 700; color: var(--text-main); margin-bottom: 6px;">No applications found in this queue</h4>
                    <p>Click "Submit New Application" to register a new loan proposal for approval.</p>
                </div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Application No</th>
                            <th>Applicant Customer</th>
                            <th>Loan Scheme</th>
                            <th>Requested Principal</th>
                            <th>Tenure / Rate</th>
                            <th>Officer</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($applications as $app): ?>
                            <tr>
                                <td>
                                    <strong style="color: var(--primary); font-size: 14px;"><?= esc($app['application_no']) ?></strong>
                                    <span style="display: block; font-size: 11px; color: var(--text-muted);"><?= date('M d, Y', strtotime($app['created_at'])) ?></span>
                                </td>
                                <td>
                                    <strong style="color: var(--text-main);"><?= esc($app['customer_name']) ?></strong>
                                    <span style="display: block; font-size: 12px; color: var(--text-muted);">NIC: <?= esc($app['customer_nic'] ?? 'N/A') ?></span>
                                </td>
                                <td>
                                    <span><?= esc($app['product_name']) ?></span>
                                    <span style="display: block; font-size: 11px; color: var(--primary); font-weight: 600;"><?= esc($app['product_code']) ?></span>
                                </td>
                                <td>
                                    <strong style="font-size: 15px; color: var(--text-main);">Rs. <?= number_format($app['amount_requested'], 2) ?></strong>
                                </td>
                                <td>
                                    <span><?= esc($app['tenure_months']) ?> Months</span>
                                    <span style="display: block; font-size: 12px; color: var(--text-muted); font-weight: 600;">@ <?= number_format($app['proposed_interest_rate'], 2) ?>% p.a.</span>
                                </td>
                                <td>
                                    <span style="font-size: 13px; color: var(--text-muted);"><?= esc($app['officer_username'] ?? 'Officer') ?></span>
                                </td>
                                <td>
                                    <?php 
                                        $statusClass = 'status-pending';
                                        if ($app['status'] === 'Approved') $statusClass = 'status-approved';
                                        elseif ($app['status'] === 'Rejected') $statusClass = 'status-rejected';
                                        elseif ($app['status'] === 'Disbursed') $statusClass = 'status-disbursed';
                                    ?>
                                    <span class="badge-status <?= $statusClass ?>">
                                        <?= esc($app['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?= base_url('loans/applications/view/' . $app['id']) ?>" class="btn-view">
                                        Review Details &rarr;
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function dismissAlert(alertElem) {
            if (!alertElem) return;
            alertElem.classList.add('fade-out');
            setTimeout(() => { alertElem.remove(); }, 450);
        }

        document.addEventListener('DOMContentLoaded', () => {
            const alerts = document.querySelectorAll('.auto-dismiss');
            alerts.forEach(alert => {
                setTimeout(() => { dismissAlert(alert); }, 4000);
            });
        });
    </script>
</body>
</html>
