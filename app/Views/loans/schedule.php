<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMS - Loan Amortization Schedule (<?= esc($loan['loan_account_no'] ?? '') ?>)</title>
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

        /* Top Actions / Navigation */
        .top-nav-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            padding: 8px 16px;
            background: white;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            transition: all 0.2s;
        }

        .btn-back:hover {
            color: var(--primary);
            border-color: var(--primary);
            transform: translateX(-2px);
        }

        .action-buttons {
            display: flex;
            gap: 12px;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 18px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
            border: none;
        }

        .btn-print {
            background: white;
            border: 1px solid var(--border);
            color: var(--text-main);
        }
        .btn-print:hover {
            background: #f1f5f9;
        }

        /* Loan Header Card */
        .loan-banner {
            background: linear-gradient(135deg, #1e1e2f 0%, #2d2d44 100%);
            border-radius: var(--radius-lg);
            padding: 28px 32px;
            color: white;
            margin-bottom: 28px;
            box-shadow: var(--shadow-md);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .loan-banner-info h1 {
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.4px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .loan-banner-info p {
            color: #94a3b8;
            font-size: 14px;
            margin-top: 6px;
        }

        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(16, 185, 129, 0.2);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.4);
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
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
            flex-shrink: 0;
        }

        .icon-blue { background: #eef2ff; color: var(--primary); }
        .icon-green { background: #ecfdf5; color: var(--success); }
        .icon-purple { background: #f5f3ff; color: var(--secondary); }
        .icon-amber { background: #fffbeb; color: var(--warning); }

        .stat-content h3 { font-size: 22px; font-weight: 800; }
        .stat-content p { font-size: 13px; color: var(--text-muted); font-weight: 500; margin-top: 2px; }

        /* Loan Info Grid */
        .info-card {
            background: var(--card-bg);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
            padding: 24px;
            margin-bottom: 32px;
            box-shadow: var(--shadow-sm);
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .info-item label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .info-item span {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-main);
        }

        /* Amortization Table Card */
        .table-card {
            background: var(--card-bg);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            margin-bottom: 40px;
        }

        .table-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #ffffff;
        }

        .table-header h2 {
            font-size: 17px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        table { width: 100%; border-collapse: collapse; text-align: left; }
        th {
            background: #f8fafc;
            padding: 14px 20px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border);
        }
        td {
            padding: 16px 20px;
            font-size: 13px;
            color: var(--text-main);
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }
        tr:hover td { background: #fdfdfd; }

        .installment-badge {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #f1f5f9;
            color: var(--text-main);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 12px;
        }

        .badge-unpaid {
            background: #fffbeb;
            color: #b45309;
            border: 1px solid #fde68a;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .badge-paid {
            background: #ecfdf5;
            color: var(--success);
            border: 1px solid #a7f3d0;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .tfoot-total td {
            background: #f8fafc;
            font-weight: 800;
            font-size: 14px;
            border-top: 2px solid var(--border);
            color: var(--text-main);
        }

        @media print {
            .navbar, .top-nav-bar, .btn-action { display: none !important; }
            body { background: white; }
            .container { margin: 0; padding: 0; max-width: 100%; }
            .table-card, .info-card, .loan-banner { box-shadow: none; border: 1px solid #ccc; }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
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
            <a href="<?= base_url('loans/active') ?>" class="btn-nav btn-dash">Active Loans</a>
            <a href="<?= base_url('loans/applications') ?>" class="btn-nav btn-dash">Applications</a>
            <a href="<?= base_url('dashboard') ?>" class="btn-nav btn-dash">Dashboard</a>
            <a href="<?= base_url('logout') ?>" class="btn-nav btn-logout">Logout</a>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="container">

        <!-- Top Navigation -->
        <div class="top-nav-bar">
            <a href="<?= base_url('loans/active') ?>" class="btn-back">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                <span>Back to Active Loans</span>
            </a>
            <div class="action-buttons">
                <button onclick="window.print()" class="btn-action btn-print">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 6 2 18 2 18 9"></polyline>
                        <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                        <rect x="6" y="14" width="12" height="8"></rect>
                    </svg>
                    <span>Print Amortization Schedule</span>
                </button>
            </div>
        </div>

        <!-- Banner Header -->
        <div class="loan-banner">
            <div class="loan-banner-info">
                <h1>
                    <span><?= esc($loan['loan_account_no'] ?? 'LOAN-ACCOUNT') ?></span>
                    <span class="badge-status">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor">
                            <circle cx="12" cy="12" r="10"></circle>
                        </svg>
                        <?= esc($loan['status'] ?? 'Active') ?>
                    </span>
                </h1>
                <p>Borrower: <strong><?= esc($loan['customer_name'] ?? 'Customer') ?></strong> (<?= esc($loan['customer_code'] ?? 'N/A') ?>) &bull; Scheme: <?= esc($loan['product_name'] ?? 'Loan Product') ?></p>
            </div>
            <div>
                <span style="font-size: 13px; color: #94a3b8; display: block; text-align: right;">Disbursed On</span>
                <strong style="font-size: 16px; color: #f8fafc;"><?= !empty($loan['disbursed_at']) ? date('F d, Y', strtotime($loan['disbursed_at'])) : date('F d, Y') ?></strong>
            </div>
        </div>

        <?php 
            $totPrincipal = (float)($loan['principal_amount'] ?? 0);
            $totPayable = (float)($loan['total_payable'] ?? 0);
            $totInterest = max(0, $totPayable - $totPrincipal);
            $monthlyEmi = (float)($loan['emi_amount'] ?? 0);
        ?>

        <!-- Key Financials Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon icon-blue">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                        <line x1="2" y1="10" x2="22" y2="10"></line>
                    </svg>
                </div>
                <div class="stat-content">
                    <h3>Rs. <?= number_format($totPrincipal, 2) ?></h3>
                    <p>Principal Disbursed</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon icon-green">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                </div>
                <div class="stat-content">
                    <h3>Rs. <?= number_format($monthlyEmi, 2) ?></h3>
                    <p>Fixed Monthly EMI</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon icon-amber">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="1" x2="12" y2="23"></line>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                    </svg>
                </div>
                <div class="stat-content">
                    <h3>Rs. <?= number_format($totInterest, 2) ?></h3>
                    <p>Total Interest Charge</p>
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
                    <h3>Rs. <?= number_format($totPayable, 2) ?></h3>
                    <p>Total Repayable Value</p>
                </div>
            </div>
        </div>

        <!-- Facility Parameters Info Card -->
        <div class="info-card">
            <div class="info-grid">
                <div class="info-item">
                    <label>Borrower NIC</label>
                    <span><?= esc($loan['customer_nic'] ?? 'N/A') ?></span>
                </div>
                <div class="info-item">
                    <label>Borrower Contact</label>
                    <span><?= esc($loan['customer_phone'] ?? 'N/A') ?></span>
                </div>
                <div class="info-item">
                    <label>Annual Interest Rate</label>
                    <span style="color: var(--primary);"><?= number_format($loan['interest_rate'], 2) ?>% p.a.</span>
                </div>
                <div class="info-item">
                    <label>Tenure Period</label>
                    <span><?= esc($loan['tenure_months']) ?> Months</span>
                </div>
                <div class="info-item">
                    <label>Sanctioning Branch</label>
                    <span><?= esc($loan['branch_name'] ?? 'Main Branch') ?></span>
                </div>
                <div class="info-item">
                    <label>Approving Officer</label>
                    <span><?= esc($loan['approver_username'] ?? 'Branch Manager') ?></span>
                </div>
            </div>
        </div>

        <!-- Amortization Schedule Table -->
        <div class="table-card">
            <div class="table-header">
                <h2>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                    <span>Full Amortization Repayment Schedule</span>
                </h2>
                <span style="font-size: 13px; color: var(--text-muted); font-weight: 500;">
                    Total Installments: <?= count($schedules ?? []) ?>
                </span>
            </div>

            <table>
                <thead>
                    <tr>
                        <th style="width: 70px; text-align: center;">#</th>
                        <th>Due Date</th>
                        <th>Opening Principal</th>
                        <th>Principal (A)</th>
                        <th>Interest (B)</th>
                        <th>Total EMI (A+B)</th>
                        <th>Closing Balance</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $sumPrincipal = 0;
                        $sumInterest = 0;
                        $sumEmi = 0;
                        foreach ($schedules ?? [] as $row): 
                            $sumPrincipal += (float)$row['principal_component'];
                            $sumInterest  += (float)$row['interest_component'];
                            $sumEmi       += (float)$row['emi_amount'];
                    ?>
                        <tr>
                            <td style="text-align: center;">
                                <span class="installment-badge"><?= esc($row['installment_no']) ?></span>
                            </td>
                            <td>
                                <strong><?= date('M d, Y', strtotime($row['due_date'])) ?></strong>
                            </td>
                            <td>Rs. <?= number_format($row['opening_balance'], 2) ?></td>
                            <td style="color: var(--primary); font-weight: 600;">Rs. <?= number_format($row['principal_component'], 2) ?></td>
                            <td style="color: #b45309; font-weight: 600;">Rs. <?= number_format($row['interest_component'], 2) ?></td>
                            <td>
                                <strong style="color: var(--primary-dark); font-size: 14px;">Rs. <?= number_format($row['emi_amount'], 2) ?></strong>
                            </td>
                            <td>
                                <strong>Rs. <?= number_format($row['closing_balance'], 2) ?></strong>
                            </td>
                            <td>
                                <?php if ($row['status'] === 'Paid'): ?>
                                    <span class="badge-paid">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="20 6 9 17 4 12"></polyline>
                                        </svg>
                                        Paid
                                    </span>
                                <?php else: ?>
                                    <span class="badge-unpaid">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <polyline points="12 6 12 12 16 14"></polyline>
                                        </svg>
                                        Unpaid
                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="tfoot-total">
                        <td colspan="3" style="text-align: right; padding-right: 20px;">GRAND TOTALS:</td>
                        <td style="color: var(--primary);">Rs. <?= number_format($sumPrincipal, 2) ?></td>
                        <td style="color: #b45309;">Rs. <?= number_format($sumInterest, 2) ?></td>
                        <td style="color: var(--primary-dark);">Rs. <?= number_format($sumEmi, 2) ?></td>
                        <td>Rs. 0.00</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>

</body>
</html>
