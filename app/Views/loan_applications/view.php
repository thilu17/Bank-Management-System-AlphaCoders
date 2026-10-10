<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMS - Application <?= esc($application['application_no']) ?></title>
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
            max-width: 1100px;
            width: 100%;
            margin: 32px auto;
            padding: 0 24px;
        }

        /* Detail Header */
        .detail-header {
            background: white;
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            padding: 28px 36px;
            margin-bottom: 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .app-title-box h1 {
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: var(--text-main);
        }

        .app-meta {
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 6px;
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }

        .badge-status {
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .status-pending { background: #fefce8; color: #a16207; border: 1px solid #fef08a; }
        .status-approved { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
        .status-rejected { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
        .status-disbursed { background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; }

        /* Cards Grid */
        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 24px;
        }

        .card {
            background: white;
            border-radius: var(--radius-md);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            padding: 24px;
        }

        .card h3 {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 8px;
            border-bottom: 1px solid var(--border);
            padding-bottom: 12px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 14px;
        }

        .info-label { color: var(--text-muted); font-weight: 500; }
        .info-val { color: var(--text-main); font-weight: 700; text-align: right; }

        /* Doc links */
        .doc-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            background: #f8fafc;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            text-decoration: none;
            color: var(--primary);
            font-weight: 600;
            font-size: 13px;
            margin-right: 12px;
            margin-top: 8px;
            transition: all 0.2s ease;
        }
        .doc-pill:hover {
            background: #eff6ff;
            border-color: var(--primary);
        }

        .btn-back {
            padding: 10px 20px;
            background: #f1f5f9;
            color: var(--text-main);
            border-radius: var(--radius-sm);
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
        }
        .btn-back:hover { background: #e2e8f0; }
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
                <span><?= esc($username ?? 'Officer') ?></span>
                <span class="badge"><?= esc($role ?? 'Staff') ?></span>
            </div>
            <a href="<?= base_url('loans/applications') ?>" class="btn-nav btn-dash">Applications Queue</a>
            <a href="<?= base_url('dashboard') ?>" class="btn-nav btn-dash">Dashboard</a>
            <a href="<?= base_url('logout') ?>" class="btn-nav btn-logout">Logout</a>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="container">

        <!-- Top Header Card -->
        <div class="detail-header">
            <div class="app-title-box">
                <h1>Application <?= esc($application['application_no']) ?></h1>
                <div class="app-meta">
                    <span style="display: inline-flex; align-items: center; gap: 6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--text-muted);">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        <span>Submitted: <?= date('M d, Y - h:i A', strtotime($application['created_at'])) ?></span>
                    </span>
                    <span style="display: inline-flex; align-items: center; gap: 6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--text-muted);">
                            <path d="M3 21h18"></path>
                            <path d="M5 21V7l8-4v18"></path>
                            <path d="M19 21V11l-6-3"></path>
                            <path d="M9 9v.01"></path>
                            <path d="M9 12v.01"></path>
                            <path d="M9 15v.01"></path>
                            <path d="M9 18v.01"></path>
                        </svg>
                        <span>Branch: <?= esc($application['branch_name'] ?? 'Main Branch') ?></span>
                    </span>
                    <span style="display: inline-flex; align-items: center; gap: 6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--text-muted);">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <span>Underwritten by: <?= esc($application['officer_username'] ?? 'Officer') ?></span>
                    </span>
                </div>
            </div>

            <div>
                <?php 
                    $statusClass = 'status-pending';
                    if ($application['status'] === 'Approved') $statusClass = 'status-approved';
                    elseif ($application['status'] === 'Rejected') $statusClass = 'status-rejected';
                    elseif ($application['status'] === 'Disbursed') $statusClass = 'status-disbursed';
                ?>
                <span class="badge-status <?= $statusClass ?>">
                    ● Status: <?= esc($application['status']) ?>
                </span>
            </div>
        </div>

        <!-- 2 Column Grid for Details -->
        <div class="grid-2">
            <!-- Loan Parameters Card -->
            <div class="card">
                <h3>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--primary);">
                        <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                        <line x1="2" y1="10" x2="22" y2="10"></line>
                    </svg>
                    <span>Loan Terms & Parameters</span>
                </h3>
                <div class="info-row">
                    <span class="info-label">Loan Product Offering</span>
                    <span class="info-val"><?= esc($application['product_name']) ?> (<?= esc($application['product_code']) ?>)</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Requested Principal Amount</span>
                    <span class="info-val" style="color: var(--primary); font-size: 16px;">Rs. <?= number_format($application['amount_requested'], 2) ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Proposed Annual Interest Rate</span>
                    <span class="info-val"><?= number_format($application['proposed_interest_rate'], 2) ?>% p.a.</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tenure Duration</span>
                    <span class="info-val"><?= esc($application['tenure_months']) ?> Months</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Applicant Monthly Income</span>
                    <span class="info-val">Rs. <?= number_format($application['monthly_income'] ?? 0, 2) ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Stated Purpose of Loan</span>
                    <span class="info-val"><?= esc($application['purpose'] ?? 'General Financing') ?></span>
                </div>
            </div>

            <!-- Customer Profile Card -->
            <div class="card">
                <h3>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--primary);">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <span>Applicant Customer Profile</span>
                </h3>
                <div class="info-row">
                    <span class="info-label">Customer Name</span>
                    <span class="info-val"><?= esc($application['customer_name']) ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Customer ID Code</span>
                    <span class="info-val"><?= esc($application['customer_code']) ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">National Identity Card (NIC)</span>
                    <span class="info-val"><?= esc($application['customer_nic'] ?? 'N/A') ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Contact Phone</span>
                    <span class="info-val"><?= esc($application['customer_phone'] ?? 'N/A') ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Occupation / Trade</span>
                    <span class="info-val"><?= esc($application['customer_occupation'] ?? 'Salaried Professional') ?></span>
                </div>
            </div>
        </div>

        <div class="grid-2">
            <!-- Collateral Information Card -->
            <div class="card">
                <h3>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--primary);">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                    </svg>
                    <span>Pledged Collateral Security</span>
                </h3>
                <div class="info-row">
                    <span class="info-label">Collateral Asset Type</span>
                    <span class="info-val"><?= esc($application['collateral_type'] ?? 'None / Unsecured') ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Assessed Market Value</span>
                    <span class="info-val">Rs. <?= number_format($application['collateral_value'] ?? 0, 2) ?></span>
                </div>
                <div style="margin-top: 12px; font-size: 13px; color: var(--text-muted);">
                    <strong>Asset Description & Details:</strong>
                    <p style="margin-top: 4px; color: var(--text-main);"><?= nl2br(esc($application['collateral_description'] ?? 'No additional description provided.')) ?></p>
                </div>
            </div>

            <!-- Guarantor Card -->
            <div class="card">
                <h3>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--primary);">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                    <span>Primary Guarantor Details</span>
                </h3>
                <div class="info-row">
                    <span class="info-label">Guarantor Name</span>
                    <span class="info-val"><?= esc($application['guarantor_name'] ?: 'None Specified') ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Guarantor NIC</span>
                    <span class="info-val"><?= esc($application['guarantor_nic'] ?: 'N/A') ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Guarantor Phone</span>
                    <span class="info-val"><?= esc($application['guarantor_phone'] ?: 'N/A') ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Relationship to Borrower</span>
                    <span class="info-val"><?= esc($application['guarantor_relationship'] ?: 'N/A') ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Guarantor Address</span>
                    <span class="info-val"><?= esc($application['guarantor_address'] ?: 'N/A') ?></span>
                </div>
            </div>
        </div>

        <!-- Document Attachments & Remarks Card -->
        <div class="card" style="margin-bottom: 30px;">
            <h3>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--primary);">
                    <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                </svg>
                <span>Attached Verification Documents & Officer Remarks</span>
            </h3>
            
            <div style="margin-bottom: 20px;">
                <span class="info-label" style="display: block; margin-bottom: 8px;">Uploaded Verification Files:</span>
                <?php if (!empty($application['kyc_doc_path'])): ?>
                    <a href="<?= base_url($application['kyc_doc_path']) ?>" target="_blank" class="doc-pill">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                        </svg>
                        <span>KYC Identity Document (NIC/Passport)</span> &rarr;
                    </a>
                <?php else: ?>
                    <span style="font-size: 13px; color: var(--text-muted); margin-right: 16px;">KYC doc not uploaded</span>
                <?php endif; ?>

                <?php if (!empty($application['income_doc_path'])): ?>
                    <a href="<?= base_url($application['income_doc_path']) ?>" target="_blank" class="doc-pill">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="20" x2="18" y2="10"></line>
                            <line x1="12" y1="20" x2="12" y2="4"></line>
                            <line x1="6" y1="20" x2="6" y2="14"></line>
                        </svg>
                        <span>Income Verification (Salary Slip / Statement)</span> &rarr;
                    </a>
                <?php else: ?>
                    <span style="font-size: 13px; color: var(--text-muted);">Income doc not uploaded</span>
                <?php endif; ?>
            </div>

            <?php if (!empty($application['remarks'])): ?>
                <div style="background: #f8fafc; padding: 14px 18px; border-radius: var(--radius-sm); border: 1px solid var(--border); font-size: 13px;">
                    <strong>Officer Review Remarks:</strong>
                    <p style="margin-top: 4px; color: var(--text-main);"><?= nl2br(esc($application['remarks'])) ?></p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Manager Underwriting & Approval Decision Card -->
        <?php if (in_array($role, ['Branch Manager', 'SUPER ADMIN']) && $application['status'] === 'Pending Review'): ?>
            <div class="card" style="border: 2px solid var(--primary); background: linear-gradient(180deg, #ffffff, #f8fafc); margin-bottom: 30px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; flex-wrap: wrap; gap: 12px;">
                    <div>
                        <h3 style="border-bottom: none; padding-bottom: 0; margin-bottom: 4px; color: var(--primary-dark);">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="color: var(--primary);">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                            <span>Branch Manager Underwriting Decision</span>
                        </h3>
                        <p style="font-size: 13px; color: var(--text-muted);">Authorize disbursement and trigger Ledger Service to credit Customer Savings.</p>
                    </div>

                    <div style="display: flex; gap: 12px; align-items: center;">
                        <!-- Reject Button -->
                        <button type="button" onclick="openRejectModal()" style="padding: 11px 20px; background: #fff1f2; border: 1px solid #fecdd3; color: #e11d48; border-radius: var(--radius-sm); font-weight: 700; font-size: 14px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="15" y1="9" x2="9" y2="15"></line>
                                <line x1="9" y1="9" x2="15" y2="15"></line>
                            </svg>
                            <span>Reject Application</span>
                        </button>

                        <!-- Approve & Disburse Form -->
                        <form method="POST" action="<?= base_url('loans/applications/approve/' . $application['id']) ?>" onsubmit="return confirm('Approve this loan for Rs. <?= number_format($application['amount_requested'], 2) ?> and disburse funds to Customer Savings immediately?');">
                            <?= csrf_field() ?>
                            <button type="submit" style="padding: 11px 24px; background: linear-gradient(135deg, #10b981, #059669); border: none; color: white; border-radius: var(--radius-sm); font-weight: 700; font-size: 14px; cursor: pointer; box-shadow: 0 4px 14px rgba(16, 185, 129, 0.35); display: inline-flex; align-items: center; gap: 8px;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                                <span>Approve & Disburse Funds</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        <?php elseif ($application['status'] === 'Disbursed'): ?>
            <div class="card" style="border: 1px solid #a7f3d0; background: #ecfdf5; margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 40px; height: 40px; background: #10b981; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                    <div>
                        <h4 style="font-size: 16px; font-weight: 700; color: #065f46;">Loan Approved & Disbursed</h4>
                        <p style="font-size: 13px; color: #047857;">Funds credited to customer savings account. Loan facility is now active.</p>
                    </div>
                </div>
                <a href="<?= base_url('loans/active') ?>" class="btn-primary" style="padding: 8px 18px; font-size: 13px;">View in Active Portfolio &rarr;</a>
            </div>
        <?php endif; ?>

        <!-- Rejection Reason Modal -->
        <div id="rejectModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 1000; align-items: center; justify-content: center; padding: 20px;">
            <div style="background: white; border-radius: var(--radius-lg); max-width: 500px; width: 100%; box-shadow: var(--shadow-lg); overflow: hidden;">
                <div style="padding: 20px 24px; background: #f8fafc; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="font-size: 17px; font-weight: 700; color: #e11d48;">Reject Loan Application</h3>
                    <button type="button" onclick="closeRejectModal()" style="background: transparent; border: none; font-size: 20px; cursor: pointer; color: var(--text-muted);">&times;</button>
                </div>
                <form method="POST" action="<?= base_url('loans/applications/reject/' . $application['id']) ?>">
                    <?= csrf_field() ?>
                    <div style="padding: 24px;">
                        <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 14px;">Please provide the formal reason for rejecting this loan application:</p>
                        <textarea name="rejection_reason" rows="3" style="width: 100%; padding: 10px 14px; border-radius: var(--radius-sm); border: 1px solid var(--border); font-size: 14px; font-family: inherit;" placeholder="e.g. Insufficient verifiable monthly income / Ineligible collateral value..." required></textarea>
                    </div>
                    <div style="padding: 16px 24px; background: #f8fafc; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: 10px;">
                        <button type="button" onclick="closeRejectModal()" style="padding: 8px 16px; border: 1px solid var(--border); background: white; border-radius: var(--radius-sm); cursor: pointer; font-weight: 600;">Cancel</button>
                        <button type="submit" style="padding: 8px 18px; background: #e11d48; color: white; border: none; border-radius: var(--radius-sm); cursor: pointer; font-weight: 600;">Confirm Rejection</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Back Button -->
        <div>
            <a href="<?= base_url('loans/applications') ?>" class="btn-back">&larr; Back to Applications Queue</a>
        </div>
    </div>

    <script>
        function openRejectModal() {
            document.getElementById('rejectModal').style.display = 'flex';
        }
        function closeRejectModal() {
            document.getElementById('rejectModal').style.display = 'none';
        }
    </script>
</body>
</html>
