<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMS - Active Loan Accounts</title>
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
        }

        .icon-blue { background: #eef2ff; color: var(--primary); }
        .icon-green { background: #ecfdf5; color: var(--success); }
        .icon-purple { background: #f5f3ff; color: var(--secondary); }

        .stat-content h3 { font-size: 22px; font-weight: 800; }
        .stat-content p { font-size: 13px; color: var(--text-muted); font-weight: 500; }

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

        table { width: 100%; border-collapse: collapse; text-align: left; }
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

        .badge-active {
            background: #ecfdf5;
            color: var(--success);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            border: 1px solid #a7f3d0;
        }

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
                <span><?= esc($username ?? 'Branch Manager') ?></span>
                <span class="badge"><?= esc($role ?? 'Branch Manager') ?></span>
            </div>
            <a href="<?= base_url('loans/applications') ?>" class="btn-nav btn-dash">Applications Queue</a>
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
                <h1>Active Disbursed Loans</h1>
                <p>Overview of all live credit facilities, customer repayments, and current outstanding exposure.</p>
            </div>
            <a href="<?= base_url('loans/applications') ?>" class="btn-primary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="8" y1="6" x2="21" y2="6"></line>
                    <line x1="8" y1="12" x2="21" y2="12"></line>
                    <line x1="8" y1="18" x2="21" y2="18"></line>
                    <line x1="3" y1="6" x2="3.01" y2="6"></line>
                    <line x1="3" y1="12" x2="3.01" y2="12"></line>
                    <line x1="3" y1="18" x2="3.01" y2="18"></line>
                </svg>
                <span>Review Applications Queue</span>
            </a>
        </div>

        <!-- Stats Overview -->
        <?php 
            $totalActive = count($activeLoans ?? []);
            $totalDisbursed = 0;
            $totalOutstanding = 0;
            foreach ($activeLoans ?? [] as $loan) {
                $totalDisbursed += (float)$loan['principal_amount'];
                $totalOutstanding += (float)$loan['outstanding_balance'];
            }
        ?>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon icon-blue">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                        <line x1="2" y1="10" x2="22" y2="10"></line>
                    </svg>
                </div>
                <div class="stat-content">
                    <h3><?= $totalActive ?></h3>
                    <p>Active Loan Facilities</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon icon-green">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                    </svg>
                </div>
                <div class="stat-content">
                    <h3>Rs. <?= number_format($totalDisbursed, 2) ?></h3>
                    <p>Total Disbursed Capital</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon icon-purple">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                        <polyline points="17 6 23 6 23 12"></polyline>
                    </svg>
                </div>
                <div class="stat-content">
                    <h3>Rs. <?= number_format($totalOutstanding, 2) ?></h3>
                    <p>Current Total Outstanding</p>
                </div>
            </div>
        </div>

        <!-- Loans Table -->
        <div class="table-card">
            <div class="card-header">
                <h2>Live Loan Portfolio</h2>
                <span style="font-size: 13px; color: var(--text-muted);">Active credit portfolio</span>
            </div>

            <?php if (empty($activeLoans)): ?>
                <div class="empty-state">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color: #cbd5e1; margin-bottom: 12px;">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                    <h4 style="font-size: 16px; font-weight: 700; color: var(--text-main); margin-bottom: 6px;">No active loans disbursed yet</h4>
                    <p>Go to Applications Queue to review and approve pending applications.</p>
                </div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Loan Account No</th>
                            <th>Borrower Customer</th>
                            <th>Scheme & Rate</th>
                            <th>Principal Disbursed</th>
                            <th>Monthly EMI</th>
                            <th>Outstanding</th>
                            <th>Disbursed Date</th>
                            <th>Status</th>
                            <th style="text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($activeLoans as $loan): ?>
                            <tr>
                                <td>
                                    <strong style="color: var(--primary); font-size: 14px;"><?= esc($loan['loan_account_no']) ?></strong>
                                    <span style="display: block; font-size: 11px; color: var(--text-muted);">Branch: <?= esc($loan['branch_name'] ?? 'Main') ?></span>
                                </td>
                                <td>
                                    <strong><?= esc($loan['customer_name']) ?></strong>
                                    <span style="display: block; font-size: 12px; color: var(--text-muted);"><?= esc($loan['customer_code']) ?> (NIC: <?= esc($loan['customer_nic'] ?? 'N/A') ?>)</span>
                                </td>
                                <td>
                                    <span><?= esc($loan['product_name']) ?></span>
                                    <span style="display: block; font-size: 12px; color: var(--primary); font-weight: 600;"><?= number_format($loan['interest_rate'], 2) ?>% p.a. (<?= esc($loan['tenure_months']) ?>M)</span>
                                </td>
                                <td>
                                    <strong>Rs. <?= number_format($loan['principal_amount'], 2) ?></strong>
                                </td>
                                <td>
                                    <strong style="color: var(--primary-dark);">Rs. <?= number_format($loan['emi_amount'], 2) ?></strong>
                                </td>
                                <td>
                                    <strong style="color: #b91c1c;">Rs. <?= number_format($loan['outstanding_balance'], 2) ?></strong>
                                </td>
                                <td>
                                    <span><?= date('M d, Y', strtotime($loan['disbursed_at'])) ?></span>
                                    <span style="display: block; font-size: 11px; color: var(--text-muted);">By: <?= esc($loan['approver_username'] ?? 'Manager') ?></span>
                                </td>
                                <td>
                                    <span class="badge-active">● Active</span>
                                </td>
                                <td style="text-align: right;">
                                    <a href="<?= base_url('loans/schedule/' . $loan['id']) ?>" class="btn-primary" style="padding: 6px 12px; font-size: 12px; text-decoration: none;">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg>
                                        <span>Schedule</span>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
