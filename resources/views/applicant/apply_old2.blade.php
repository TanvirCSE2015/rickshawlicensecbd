<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    <title>ঢাকা ক্যান্টনমেন্ট বোর্ড - রিক্সা লাইসেন্স ব্যবস্থাপনা</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --green: #0A5C36;
            --green-dark: #07452A;
            --green-soft: #E6F2EB;
            --gold: #D97706;
            /* accent / decorative */
            --gold-strong: #B45309;
            /* gold used behind white text (AA contrast) */
            --gold-soft: #FEF3E2;
            --bg: #F4F6F9;
            --card: #FFFFFF;
            --text: #1F2937;
            --muted: #4B5563;
            --border: #E5E7EB;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            --shadow-lg: 0 12px 32px rgba(7, 69, 42, 0.18);
            --bs-primary: var(--green);
            --bs-primary-rgb: 10, 92, 54;
        }

        * {
            -webkit-tap-highlight-color: transparent;
        }

        body {
            font-family: 'Hind Siliguri', 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.6;
        }

        .en,
        .en * {
            font-family: 'Inter', 'Hind Siliguri', sans-serif;
        }

        /* ---------- Inline SVG icons (no CDN needed) ---------- */
        .ic {
            width: 1.15em;
            height: 1.15em;
            flex: none;
            stroke: currentColor;
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
            vertical-align: -0.2em;
        }

        .ic-lg {
            width: 1.6em;
            height: 1.6em;
        }

        /* ---------- Top bar ---------- */
        .topbar {
            background: #fff;
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: .75rem;
            min-width: 0;
        }

        .logo-box {
            width: 46px;
            height: 46px;
            flex: 0 0 46px;
            border-radius: 50%;
            border: 2px dashed var(--green);
            color: var(--green);
            display: grid;
            place-items: center;
            font-size: .62rem;
            font-weight: 700;
        }

        .brand-title {
            font-weight: 700;
            color: var(--green);
            font-size: 1.15rem;
            line-height: 1.2;
            margin: 0;
        }

        .brand-sub {
            font-size: .8rem;
            color: var(--muted);
            margin: 0;
        }

        .topnav {
            display: flex;
            gap: .25rem;
            overflow-x: auto;
            scrollbar-width: none;
        }

        .topnav::-webkit-scrollbar {
            display: none;
        }

        .topnav .nav-link {
            color: #374151;
            font-weight: 600;
            border-radius: 10px;
            padding: .55rem 1rem;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            gap: .45rem;
        }

        .topnav .nav-link:hover {
            background: var(--green-soft);
            color: var(--green);
        }

        .topnav .nav-link.active {
            background: var(--green);
            color: #fff;
        }

        /* ---------- Hero ---------- */
        .hero {
            background:
                radial-gradient(900px 300px at 85% -10%, rgba(255, 255, 255, .10), transparent 60%),
                linear-gradient(135deg, var(--green) 0%, var(--green-dark) 100%);
            color: #fff;
            padding: 3rem 0 6.5rem;
            position: relative;
            overflow: hidden;
        }

        .hero::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--gold), #F59E0B, var(--gold));
        }

        .hero-chip {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            background: rgba(255, 255, 255, .14);
            border: 1px solid rgba(255, 255, 255, .22);
            padding: .35rem .9rem;
            border-radius: 999px;
            font-size: .85rem;
            font-weight: 600;
            font-family: 'Inter', 'Hind Siliguri', sans-serif;
        }

        .hero h1 {
            font-size: clamp(1.9rem, 4.2vw, 2.9rem);
            font-weight: 700;
            line-height: 1.25;
            margin: 1rem 0 .75rem;
        }

        .hero p.lead {
            color: #D6EBDD;
            font-size: 1.1rem;
            max-width: 34rem;
            margin: 0;
        }

        .deadline-card {
            background: #fff;
            color: var(--text);
            border-radius: 20px;
            padding: 1.4rem 1.5rem;
            box-shadow: var(--shadow-lg);
            text-align: center;
        }

        .deadline-card .lbl {
            font-size: .9rem;
            color: var(--muted);
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: .4rem;
        }

        .deadline-card .date {
            font-size: 2.3rem;
            font-weight: 700;
            color: var(--gold-strong);
            line-height: 1.2;
            margin: .25rem 0 .6rem;
        }

        .deadline-card .bar {
            height: 6px;
            background: var(--border);
            border-radius: 3px;
            overflow: hidden;
        }

        .deadline-card .bar span {
            display: block;
            height: 100%;
            width: 92%;
            background: var(--gold-strong);
            border-radius: 3px;
        }

        .deadline-card .note {
            font-size: .82rem;
            color: var(--muted);
            margin-top: .5rem;
        }

        /* ---------- Big CTA cards (the two main buttons) ---------- */
        .cta-wrap {
            margin-top: -3.6rem;
            position: relative;
            z-index: 5;
        }

        .cta {
            display: flex;
            align-items: center;
            gap: 1.1rem;
            width: 100%;
            height: 100%;
            border: 0;
            text-align: left;
            cursor: pointer;
            text-decoration: none;
            border-radius: 18px;
            padding: 1.25rem 1.4rem;
            min-height: 96px;
            box-shadow: var(--shadow-lg);
            transition: transform .18s ease, box-shadow .18s ease;
            font-family: inherit;
        }

        .cta:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 36px rgba(7, 69, 42, .25);
        }

        .cta:focus-visible {
            outline: 3px solid #F59E0B;
            outline-offset: 3px;
        }

        .cta .cta-icon {
            width: 56px;
            height: 56px;
            flex: 0 0 56px;
            border-radius: 16px;
            display: grid;
            place-items: center;
            font-size: 1.5rem;
        }

        .cta .cta-title {
            display: block;
            font-size: 1.25rem;
            font-weight: 700;
            line-height: 1.3;
        }

        .cta .cta-sub {
            display: block;
            font-size: .92rem;
            margin-top: .1rem;
        }

        .cta .cta-arrow {
            margin-left: auto;
            font-size: 1.4rem;
            transition: transform .18s;
        }

        .cta:hover .cta-arrow {
            transform: translateX(4px);
        }

        .cta-apply {
            background: #fff;
            color: var(--green);
            border: 2px solid var(--green);
        }

        .cta-apply .cta-icon {
            background: var(--green);
            color: #fff;
        }

        .cta-apply .cta-sub {
            color: var(--muted);
        }

        .cta-status {
            background: var(--gold-strong);
            color: #fff;
            border: 2px solid var(--gold-strong);
        }

        .cta-status .cta-icon {
            background: rgba(255, 255, 255, .2);
            color: #fff;
        }

        .cta-status .cta-sub {
            color: #FFF3E0;
        }

        /* ---------- Steps ---------- */
        .step-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            box-shadow: var(--shadow);
            padding: 1.4rem;
            height: 100%;
            position: relative;
        }

        .step-num {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: var(--green);
            color: #fff;
            display: grid;
            place-items: center;
            font-weight: 700;
            margin-bottom: .75rem;
        }

        .step-card h3 {
            font-size: 1.15rem;
            font-weight: 700;
            margin: 0 0 .25rem;
        }

        .step-card p {
            margin: 0;
            color: var(--muted);
            font-size: .96rem;
        }

        /* ---------- Fee tiles ---------- */
        .tile {
            border-radius: 14px;
            padding: .9rem 1.1rem;
            height: 100%;
        }

        .tile .k {
            font-size: .85rem;
            font-weight: 600;
        }

        .tile .v {
            font-size: 1.6rem;
            font-weight: 700;
            line-height: 1.25;
        }

        .tile.gold {
            background: var(--gold-soft);
            color: #92400E;
        }

        .tile.green {
            background: var(--green-soft);
            color: var(--green-dark);
        }

        /* ---------- Section heading ---------- */
        .sec-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--green);
            margin: 0 0 1rem;
            display: flex;
            align-items: center;
            gap: .6rem;
        }

        .sec-title::after {
            content: "";
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        /* ---------- Rule cards ---------- */
        .rule-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 1rem 1.1rem;
            height: 100%;
            display: flex;
            gap: .9rem;
            align-items: flex-start;
            transition: border-color .15s, box-shadow .15s;
        }

        .rule-card:hover {
            border-color: #B8DCC7;
            box-shadow: var(--shadow);
        }

        .rule-badge {
            width: 40px;
            height: 40px;
            flex: 0 0 40px;
            border-radius: 12px;
            background: var(--green-soft);
            color: var(--green);
            display: grid;
            place-items: center;
            font-size: 1.15rem;
            position: relative;
        }

        .rule-badge small {
            position: absolute;
            top: -7px;
            right: -7px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: var(--gold-strong);
            color: #fff;
            font-size: .7rem;
            font-weight: 700;
            display: grid;
            place-items: center;
        }

        .rule-card p {
            margin: 0;
            font-size: .98rem;
        }

        .rule-card strong {
            color: var(--green);
        }

        /* ---------- Cards / headers ---------- */
        .page-banner {
            background: linear-gradient(135deg, var(--green), var(--green-dark));
            color: #fff;
            padding: 1.75rem 0;
            border-bottom: 4px solid var(--gold);
        }

        .page-banner h2 {
            margin: 0;
            font-size: 1.6rem;
            font-weight: 700;
        }

        .page-banner p {
            margin: .15rem 0 0;
            color: #D6EBDD;
        }

        .app-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            box-shadow: var(--shadow);
        }

        .card-head {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: .75rem;
        }

        .card-head h3 {
            font-size: 1.15rem;
            font-weight: 700;
            margin: 0;
            color: var(--green);
        }

        .card-head .en-sub {
            font-size: .8rem;
            color: var(--muted);
            font-family: 'Inter', sans-serif;
        }

        .card-pad {
            padding: 1.5rem;
        }

        .icon-chip {
            width: 40px;
            height: 40px;
            flex: 0 0 40px;
            border-radius: 12px;
            display: grid;
            place-items: center;
            background: var(--green-soft);
            color: var(--green);
            font-size: 1.15rem;
        }

        .icon-chip.gold {
            background: var(--gold-soft);
            color: var(--gold-strong);
        }

        /* ---------- Buttons ---------- */
        .btn {
            border-radius: 12px;
            font-weight: 600;
            padding: .7rem 1.4rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
        }

        .btn-green {
            background: var(--green);
            color: #fff;
            border: 1px solid var(--green);
        }

        .btn-green:hover,
        .btn-green:focus {
            background: var(--green-dark);
            color: #fff;
        }

        .btn-gold {
            background: var(--gold-strong);
            color: #fff;
            border: 1px solid var(--gold-strong);
        }

        .btn-gold:hover,
        .btn-gold:focus {
            background: #92400E;
            color: #fff;
        }

        .btn-outline-green {
            color: var(--green);
            border: 1.5px solid var(--green);
            background: #fff;
        }

        .btn-outline-green:hover {
            background: var(--green);
            color: #fff;
        }

        .btn-lg-cta {
            padding: .95rem 1.75rem;
            font-size: 1.05rem;
        }

        /* ---------- Form ---------- */
        .form-label {
            font-weight: 600;
            font-size: .95rem;
            margin-bottom: .35rem;
        }

        .req {
            color: #B91C1C;
            margin-left: 2px;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            border: 1.5px solid var(--border);
            padding: .65rem .9rem;
            background-color: #FCFCFD;
            font-family: 'Hind Siliguri', 'Inter', sans-serif;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--green);
            box-shadow: 0 0 0 .2rem rgba(10, 92, 54, .15);
            background: #fff;
        }

        .input-group-text {
            background: var(--green-soft);
            color: var(--green);
            border: 1.5px solid var(--border);
            border-right: 0;
            border-radius: 10px 0 0 10px;
        }

        .input-group .form-control {
            border-radius: 0 10px 10px 0;
        }

        .route-input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .route-card {
            display: flex;
            gap: .9rem;
            align-items: flex-start;
            height: 100%;
            border: 2px solid var(--border);
            border-radius: 14px;
            padding: 1rem 1.1rem;
            cursor: pointer;
            background: #fff;
            transition: all .2s;
            position: relative;
        }

        .route-card:hover {
            border-color: var(--green);
            background: #FAFDFB;
        }

        .route-badge {
            width: 44px;
            height: 44px;
            flex: 0 0 44px;
            border-radius: 12px;
            background: var(--green-soft);
            color: var(--green);
            display: grid;
            place-items: center;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .route-title {
            font-weight: 700;
            margin: 0;
        }

        .route-desc {
            font-size: .9rem;
            color: var(--muted);
            margin: .15rem 0 0;
        }

        .route-card .check {
            position: absolute;
            top: .75rem;
            right: .75rem;
            color: var(--green);
            font-size: 1.3rem;
            opacity: 0;
            transform: scale(.6);
            transition: all .2s;
        }

        .route-input:checked+.route-card {
            border-color: var(--green);
            background: var(--green-soft);
            box-shadow: 0 0 0 3px rgba(10, 92, 54, .12);
        }

        .route-input:checked+.route-card .route-badge {
            background: var(--green);
            color: #fff;
        }

        .route-input:checked+.route-card .check {
            opacity: 1;
            transform: scale(1);
        }

        .route-input:focus-visible+.route-card {
            outline: 3px solid var(--gold);
            outline-offset: 2px;
        }

        .upload-box {
            position: relative;
            border: 2px dashed #CBD5E1;
            border-radius: 14px;
            padding: 1.1rem;
            text-align: center;
            background: #FBFCFD;
            transition: all .2s;
            height: 100%;
            cursor: pointer;
            display: block;
        }

        .upload-box:hover {
            border-color: var(--green);
            background: var(--green-soft);
        }

        .upload-box:focus-within {
            outline: 3px solid var(--gold);
            outline-offset: 2px;
        }

        .upload-box input[type=file] {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .upload-box .u-icon {
            font-size: 1.9rem;
            color: var(--green);
        }

        .upload-box .u-label {
            font-weight: 600;
            font-size: .95rem;
            display: block;
            margin-top: .25rem;
        }

        .upload-box .u-hint {
            font-size: .8rem;
            color: var(--muted);
            display: block;
        }

        .upload-box .u-file {
            display: none;
            margin-top: .6rem;
            font-size: .82rem;
            font-weight: 600;
            color: var(--green);
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: .3rem .6rem;
            word-break: break-all;
            font-family: 'Inter', sans-serif;
        }

        .upload-box.has-file {
            border-style: solid;
            border-color: var(--green);
            background: var(--green-soft);
        }

        .upload-box.has-file .u-file {
            display: inline-block;
        }

        .fee-summary {
            border-radius: 16px;
            background: linear-gradient(135deg, #FFFBF2, var(--gold-soft));
            border: 1.5px solid #F5D9A8;
            padding: 1.5rem;
        }

        .fee-amount {
            font-size: 2.4rem;
            font-weight: 700;
            color: var(--gold-strong);
            line-height: 1;
        }

        .secure-note {
            font-size: .83rem;
            color: var(--muted);
        }

        .badge-pending, .badge-confirmed, .badge-approved, .badge-selected,
        .badge-rejected, .badge-expired, .badge-unselected {
            font-weight: 700;
            padding: .45rem 1rem;
            border-radius: 999px;
            font-size: .95rem;
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            border: 1px solid transparent;
            white-space: nowrap;
        }

        /* অপেক্ষমাণ: gold (unchanged) */
        .badge-pending   { background: var(--gold-soft);  color: #92400E; border-color: #F5D9A8; }

        /* গৃহীত হয়েছে: blue */
        .badge-confirmed { background: #E0F2FE;           color: #075985; border-color: #BAE6FD; }

        /* অনুমোদিত: soft green (unchanged) */
        .badge-approved  { background: var(--green-soft); color: var(--green-dark); border-color: #B8DCC7; }

        /* নির্বাচিত: solid green, the strongest positive state */
        .badge-selected  { background: var(--green);      color: #fff; border-color: var(--green); }

        /* বাতিল: red */
        .badge-rejected  { background: #FEE2E2;           color: #991B1B; border-color: #FECACA; }

        /* মেয়াদোত্তীর্ণ: neutral gray */
        .badge-expired   { background: #F3F4F6;           color: #374151; border-color: #D1D5DB; }

        /* অনির্বাচিত: indigo, clearly different from red and gold */
        .badge-unselected{ background: #EEF2FF;           color: #3730A3; border-color: #C7D2FE; }

        .info-item .k {
            font-size: .8rem;
            color: var(--muted);
            margin: 0;
        }

        .info-item .v {
            font-weight: 600;
            margin: 0;
        }

        .avatar {
            width: 64px;
            height: 64px;
            flex: 0 0 64px;
            border-radius: 50%;
            background: var(--green-soft);
            color: var(--green);
            display: grid;
            place-items: center;
            font-size: 2rem;
        }

        .fee-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: .6rem 0;
            border-bottom: 1px dashed var(--border);
            gap: 1rem;
        }

        .fee-row .amt {
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            white-space: nowrap;
        }

        .fee-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1.1rem;
            margin-top: 1rem;
            border-radius: 12px;
            background: var(--green);
            color: #fff;
        }

        .fee-total .amt {
            font-size: 1.5rem;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
        }

        .fee-locked {
            opacity: .65;
        }

        .table thead th {
            background: var(--green-soft);
            color: var(--green-dark);
            font-weight: 700;
            border-bottom: 0;
            white-space: nowrap;
            font-size: .9rem;
        }

        .table td {
            vertical-align: middle;
        }

        .txn-id {
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            font-size: .88rem;
        }

        .status-paid {
            background: var(--green-soft);
            color: var(--green-dark);
            font-weight: 600;
            border-radius: 999px;
            padding: .3rem .75rem;
            font-size: .8rem;
            display: inline-flex;
            align-items: center;
            gap: .3rem;
        }

        .form-control[readonly] {
            background: #F3F4F6;
            color: #4B5563;
            cursor: not-allowed;
        }

        .edit-notice {
            background: var(--gold-soft);
            border: 1px solid #F5D9A8;
            color: #92400E;
            border-radius: 12px;
            padding: .8rem 1rem;
            display: flex;
            gap: .6rem;
            align-items: flex-start;
        }

        .upload-box .u-current {
            display: none;
            margin-top: .6rem;
            font-size: .82rem;
            color: var(--muted);
            font-family: 'Inter', sans-serif;
            word-break: break-all;
        }

        .upload-box.has-current .u-current {
            display: block;
        }

        .fade-in {
            animation: fadeIn .35s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(8px);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            .fade-in,
            .cta,
            .cta .cta-arrow {
                animation: none;
                transition: none;
            }
        }

        footer {
            color: var(--muted);
            font-size: .85rem;
        }

        @media (max-width: 767.98px) {
            .hero {
                padding: 2rem 0 5.5rem;
            }

            .cta-wrap {
                margin-top: -3rem;
            }

            .cta {
                padding: 1.05rem 1.1rem;
            }

            .cta .cta-title {
                font-size: 1.1rem;
            }

            .brand-sub {
                display: none;
            }

            .card-pad {
                padding: 1.1rem;
            }
        }

        @media print {

            .topbar,
            .cta-wrap,
            .btn,
            footer {
                display: none !important;
            }
        }
    </style>
</head>

<body>

    <!-- ============ Inline SVG icon sprite ============ -->
    <svg xmlns="http://www.w3.org/2000/svg" style="position:absolute;width:0;height:0;overflow:hidden"
        aria-hidden="true" focusable="false">
        <symbol id="i-home" viewBox="0 0 24 24">
            <path d="M3 11 12 3l9 8M5 10v10h14V10" />
        </symbol>
        <symbol id="i-file" viewBox="0 0 24 24">
            <path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z" />
            <path d="M14 3v5h5M9 13h6M9 17h6" />
        </symbol>
        <symbol id="i-search" viewBox="0 0 24 24">
            <circle cx="11" cy="11" r="7" />
            <path d="m20 20-3.5-3.5" />
        </symbol>
        <symbol id="i-user" viewBox="0 0 24 24">
            <circle cx="12" cy="8" r="4" />
            <path d="M4 21a8 8 0 0 1 16 0" />
        </symbol>
        <symbol id="i-card" viewBox="0 0 24 24">
            <rect x="3" y="5" width="18" height="14" rx="2" />
            <path d="M3 10h18M7 15h4" />
        </symbol>
        <symbol id="i-calendar" viewBox="0 0 24 24">
            <rect x="3" y="5" width="18" height="16" rx="2" />
            <path d="M3 10h18M8 3v4M16 3v4" />
        </symbol>
        <symbol id="i-shield" viewBox="0 0 24 24">
            <path d="M12 3 4 6v6c0 5 3.5 8 8 9 4.5-1 8-4 8-9V6z" />
            <path d="m9 12 2 2 4-4" />
        </symbol>
        <symbol id="i-upload" viewBox="0 0 24 24">
            <path d="M12 16V4M7 9l5-5 5 5M5 20h14" />
        </symbol>
        <symbol id="i-check" viewBox="0 0 24 24">
            <path d="M20 6 9 17l-5-5" />
        </symbol>
        <symbol id="i-check-circle" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="9" />
            <path d="m8 12 3 3 5-6" />
        </symbol>
        <symbol id="i-download" viewBox="0 0 24 24">
            <path d="M12 4v12M7 11l5 5 5-5M5 20h14" />
        </symbol>
        <symbol id="i-lock" viewBox="0 0 24 24">
            <rect x="5" y="11" width="14" height="10" rx="2" />
            <path d="M8 11V7a4 4 0 0 1 8 0v4" />
        </symbol>
        <symbol id="i-unlock" viewBox="0 0 24 24">
            <rect x="4" y="11" width="14" height="10" rx="2" />
            <path d="M8 11V7a4 4 0 0 1 7.5-2" />
        </symbol>
        <symbol id="i-pin" viewBox="0 0 24 24">
            <path d="M12 21s7-6.2 7-11a7 7 0 1 0-14 0c0 4.8 7 11 7 11z" />
            <circle cx="12" cy="10" r="2.5" />
        </symbol>
        <symbol id="i-info" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="9" />
            <path d="M12 8h.01M11 12h1v5h1" />
        </symbol>
        <symbol id="i-clock" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="9" />
            <path d="M12 7v5l3 2" />
        </symbol>
        <symbol id="i-arrow" viewBox="0 0 24 24">
            <path d="M5 12h14M13 6l6 6-6 6" />
        </symbol>
        <symbol id="i-arrow-left" viewBox="0 0 24 24">
            <path d="M19 12H5M11 6l-6 6 6 6" />
        </symbol>
        <symbol id="i-percent" viewBox="0 0 24 24">
            <path d="M19 5 5 19" />
            <circle cx="7" cy="7" r="2.5" />
            <circle cx="17" cy="17" r="2.5" />
        </symbol>
        <symbol id="i-alert" viewBox="0 0 24 24">
            <path d="M12 3 2 20h20z" />
            <path d="M12 10v4M12 17h.01" />
        </symbol>
        <symbol id="i-paperclip" viewBox="0 0 24 24">
            <path d="m21 11-9 9a5 5 0 0 1-7-7l9-9a3.5 3.5 0 0 1 5 5l-9 9a2 2 0 0 1-3-3l8-8" />
        </symbol>
        <symbol id="i-printer" viewBox="0 0 24 24">
            <path d="M6 9V3h12v6M6 18H4v-7h16v7h-2" />
            <rect x="6" y="14" width="12" height="7" />
        </symbol>
        <symbol id="i-cash" viewBox="0 0 24 24">
            <rect x="2" y="6" width="20" height="12" rx="2" />
            <circle cx="12" cy="12" r="3" />
        </symbol>
        <symbol id="i-hourglass" viewBox="0 0 24 24">
            <path d="M6 3h12M6 21h12M7 3c0 5 5 6 5 9s-5 4-5 9M17 3c0 5-5 6-5 9s5 4 5 9" />
        </symbol>
        <symbol id="i-phone" viewBox="0 0 24 24">
            <rect x="7" y="2" width="10" height="20" rx="2" />
            <path d="M11 18h2" />
        </symbol>
        <symbol id="i-mail" viewBox="0 0 24 24">
            <rect x="3" y="5" width="18" height="14" rx="2" />
            <path d="m3 7 9 6 9-6" />
        </symbol>
        <symbol id="i-reset" viewBox="0 0 24 24">
            <path d="M3 12a9 9 0 1 0 3-6.7L3 8M3 3v5h5" />
        </symbol>
        <symbol id="i-camera" viewBox="0 0 24 24">
            <path d="M4 8h3l2-3h6l2 3h3v12H4z" />
            <circle cx="12" cy="13" r="3.5" />
        </symbol>
        <symbol id="i-receipt" viewBox="0 0 24 24">
            <path d="M6 3h12v18l-3-2-3 2-3-2-3 2z" />
            <path d="M9 8h6M9 12h6" />
        </symbol>
        <symbol id="i-badge" viewBox="0 0 24 24">
            <path
                d="M12 3l2.4 1.8 3-.2 1 2.8 2.5 1.7-.9 2.9.9 2.9-2.5 1.7-1 2.8-3-.2L12 21l-2.4-1.8-3 .2-1-2.8-2.5-1.7.9-2.9-.9-2.9 2.5-1.7 1-2.8 3 .2z" />
            <path d="m9 12 2 2 4-4" />
        </symbol>
        <symbol id="i-wallet" viewBox="0 0 24 24">
            <path d="M3 7a2 2 0 0 1 2-2h13v4" />
            <path d="M3 7v11a2 2 0 0 0 2 2h14v-4" />
            <path d="M21 9H16a2 2 0 0 0 0 5h5z" />
        </symbol>
        <symbol id="i-edit" viewBox="0 0 24 24">
            <path d="M4 20h4L19 9a2.8 2.8 0 0 0-4-4L4 16z" />
            <path d="m14 6 4 4" />
        </symbol>
        <symbol id="i-history" viewBox="0 0 24 24">
            <path d="M3 12a9 9 0 1 0 3-6.7L3 8M3 3v5h5" />
            <path d="M12 8v4l3 2" />
        </symbol>
        <symbol id="i-x-circle" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="m9 9 6 6M15 9l-6 6"/></symbol>
        <symbol id="i-minus-circle" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M8 12h8"/></symbol>
    </svg>

    <!-- ================= TOP BAR + NAV ================= -->
    <header class="topbar">
        <div class="container py-2">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2 gap-md-4">
                <div class="brand">
                    <div class="logo-box--" aria-label="Logo placeholder">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height:60px;">
                    </div>
                    <div class="min-w-0">
                        <p class="brand-title">ঢাকা ক্যান্টনমেন্ট বোর্ড</p>
                        <p class="brand-sub">ক্যান্টনমেন্ট এক্সিকিউটিভ অফিসারের কার্যালয়</p>
                    </div>
                </div>
                <nav>
                    <ul class="nav topnav flex-nowrap" id="mainTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="tab-home-btn" data-bs-toggle="pill"
                                data-bs-target="#tab-home" type="button" role="tab" aria-controls="tab-home"
                                aria-selected="true"><svg class="ic">
                                    <use href="#i-home" />
                                </svg>হোম</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab-apply-btn" data-bs-toggle="pill"
                                data-bs-target="#tab-apply" type="button" role="tab" aria-controls="tab-apply"
                                aria-selected="false"><svg class="ic">
                                    <use href="#i-file" />
                                </svg>আবেদন ফরম</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab-status-btn" data-bs-toggle="pill"
                                data-bs-target="#tab-status" type="button" role="tab" aria-controls="tab-status"
                                aria-selected="false"><svg class="ic">
                                    <use href="#i-search" />
                                </svg>আবেদনের অবস্থা ও ফি প্রদান</button>
                        </li>
                        <!-- Appears only while a user is editing their application -->
                        <li class="nav-item d-none" role="presentation" id="editTabItem">
                            <button class="nav-link" id="tab-edit-btn" data-bs-toggle="pill" data-bs-target="#tab-edit"
                                type="button" role="tab" aria-controls="tab-edit" aria-selected="false"><svg class="ic">
                                    <use href="#i-edit" />
                                </svg>আবেদন সম্পাদনা</button>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <div class="tab-content">

        <!-- =========================================================
       TAB 1 : HOME
  ========================================================== -->
        <div class="tab-pane fade show active" id="tab-home" role="tabpanel" aria-labelledby="tab-home-btn"
            tabindex="0">

            <section class="hero">
                <div class="container">
                    <div class="row align-items-center g-4">
                        <div class="col-lg-7">
                            <span class="hero-chip"><svg class="ic">
                                    <use href="#i-badge" />
                                </svg>Rickshaw License Management System</span>
                            <h1>রিক্সা লাইসেন্সের জন্য<br>অনলাইনে আবেদন করুন</h1>
                            <p class="lead">ঢাকা ক্যান্টনমেন্ট এলাকায় রিক্সা লাইসেন্সের আবেদন, অবস্থা যাচাই এবং ফি
                                প্রদান এখন এক জায়গায়।</p>
                        </div>
                        <div class="col-lg-5 col-xl-4 ms-lg-auto">
                            <div class="deadline-card">
                                <span class="lbl"><svg class="ic">
                                        <use href="#i-calendar" />
                                    </svg>আবেদনের শেষ তারিখ</span>
                                <div class="date">
                                    {{ bn_number(date('d-m-Y', strtotime($app_setting->app_expire_date))) }}</div>
                                <div class="bar" role="img" aria-label="সময় প্রায় শেষ"><span></span></div>
                                <div class="note">সময় প্রায় শেষ, দ্রুত আবেদন করুন</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- The two main buttons -->
            <div class="container cta-wrap">
                <div class="row g-3">
                    <div class="col-md-6">
                        <button type="button" class="cta cta-apply" data-goto="#tab-apply-btn">
                            <span class="cta-icon"><svg class="ic ic-lg">
                                    <use href="#i-file" />
                                </svg></span>
                            <span>
                                <span class="cta-title">নতুন আবেদন করুন</span>
                                <span class="cta-sub">ফরম পূরণ করুন ও ২০০/- টাকা আবেদন ফি দিন</span>
                            </span>
                            <svg class="ic cta-arrow">
                                <use href="#i-arrow" />
                            </svg>
                        </button>
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="cta cta-status" data-goto="#tab-status-btn">
                            <span class="cta-icon"><svg class="ic ic-lg">
                                    <use href="#i-search" />
                                </svg></span>
                            <span>
                                <span class="cta-title">আবেদনের অবস্থা ও ফি প্রদান</span>
                                <span class="cta-sub">NID ও মোবাইল নম্বর দিয়ে অবস্থা দেখুন</span>
                            </span>
                            <svg class="ic cta-arrow">
                                <use href="#i-arrow" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <main class="container py-5">

                <!-- Steps -->
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="step-card">
                            <div class="step-num">১</div>
                            <h3>আবেদন করুন</h3>
                            <p>ফরম পূরণ করে ডকুমেন্ট দিন এবং ২০০/- টাকা আবেদন ফি অনলাইনে পরিশোধ করুন।</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="step-card">
                            <div class="step-num">২</div>
                            <h3>অনুমোদন</h3>
                            <p>আবেদন যাচাইয়ের পর অবস্থা অনুসন্ধান পাতায় অনুমোদনের তথ্য দেখুন।</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="step-card">
                            <div class="step-num">৩</div>
                            <h3>বার্ষিক ফি প্রদান</h3>
                            <p>অনুমোদিত হলে বার্ষিক লাইসেন্স ফি পরিশোধ করে রশিদ ডাউনলোড করুন।</p>
                        </div>
                    </div>
                </div>

                <!-- Fee tiles -->
                <div class="row g-3 mb-5">
                    <div class="col-6 col-lg-3">
                        <div class="tile gold">
                            <div class="k">আবেদন ফি</div>
                            <div class="v">২০০/-</div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="tile green">
                            <div class="k">লাইসেন্স ফি</div>
                            <div class="v">৭,৩০০/-</div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="tile green">
                            <div class="k">ভ্যাট + উৎসকর</div>
                            <div class="v">১৫% + ১০%</div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="tile green">
                            <div class="k">জামানত ও মনিটরিং</div>
                            <div class="v">৩,০০০/-</div>
                        </div>
                    </div>
                </div>

                <!-- Rules -->
                <h2 class="sec-title">আবেদনের নির্দেশনা</h2>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="rule-card"><span class="rule-badge"><svg class="ic">
                                    <use href="#i-user" />
                                </svg><small>১</small></span>
                            <p>একজন ব্যক্তি একের অধিক কোটায় আবেদন করতে পারবেন না। আবেদনকারী মনোনীত হলে <strong>১টি
                                    লাইসেন্স</strong> ইজারা/বরাদ্দ পাবেন।</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="rule-card"><span class="rule-badge"><svg class="ic">
                                    <use href="#i-cash" />
                                </svg><small>২</small></span>
                            <p>আবেদনের সাথে সিইও, ঢাকা ক্যান্টনমেন্ট এর অনুকূলে লাইসেন্স ফি বাবদ <strong>৭৩০০/- (সাত
                                    হাজার তিনশত)</strong> টাকার পে-অর্ডারের কপিসহ তথ্য প্রদান করতে হবে। আবেদনকারী মনোনীত
                                হলে পে-অর্ডার জমা প্রদান করতে হবে।</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="rule-card"><span class="rule-badge"><svg class="ic">
                                    <use href="#i-percent" />
                                </svg><small>৩</small></span>
                            <p>রিক্সার লাইসেন্সের জন্য অনুমতিপ্রাপ্ত হলে লাইসেন্স ফি এর উপর <strong>১৫% ভ্যাট ও ১০%
                                    উৎসকর</strong> প্রদান করতে হবে। এছাড়া প্রতিটি লাইসেন্সের জন্য <strong>৩০০০/- (তিন
                                    হাজার)</strong> টাকা জমা রাখতে হবে। এর মধ্যে জামানত বাবদ ২০০০/- টাকা লাইসেন্সের
                                মেয়াদ শেষে ফেরতযোগ্য। অবশিষ্ট ১০০০/- টাকা রিক্সা মনিটরিং ফি বাবদ কর্তন করা হবে।</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="rule-card"><span class="rule-badge"><svg class="ic">
                                    <use href="#i-alert" />
                                </svg><small>৪</small></span>
                            <p>রিক্সার লাইসেন্স বিক্রয় করা যাবে না, তবে ভাড়া প্রদান করতে পারবেন। কোনো অনিয়ম পরিলক্ষিত
                                হলে <strong>জামানত বাজেয়াপ্ত</strong> ও প্রয়োজনীয় আইনানুগ ব্যবস্থা গ্রহণ করা হবে।</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="rule-card"><span class="rule-badge"><svg class="ic">
                                    <use href="#i-pin" />
                                </svg><small>৫</small></span>
                            <p>আবেদনকারী ঢাকা সিটিকর্পোরেশন বা ঢাকা ক্যান্টনমেন্ট বোর্ডের আওতাধীন এলাকায় বসবাসকারী হতে
                                হবে। প্রমানক হিসেবে সংশ্লিষ্ট এলাকার <strong>নাগরিক সনদপত্র</strong> দাখিল করতে হবে।</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="rule-card"><span class="rule-badge"><svg class="ic">
                                    <use href="#i-paperclip" />
                                </svg><small>৬</small></span>
                            <p>সকল কোটার আবেদনের ক্ষেত্রে <strong>কোটার প্রমানক</strong> সংযুক্ত করতে হবে।</p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="rule-card"><span class="rule-badge"><svg class="ic">
                                    <use href="#i-printer" />
                                </svg><small>৭</small></span>
                            <p>অনলাইনে আবেদন করার পর আবেদনের প্রিন্ট কপিসহ ঢাকা ক্যান্টনমেন্ট বোর্ডের রাজস্ব শাখায়
                                <strong>২০০/-টাকা</strong> আবেদন ফি জমা করার জন্য অনুরোধ করা হলো অন্যথায় আপনার আবেদনটি
                                বাতিল বলে গণ্য হবে।</p>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <!-- =========================================================
       TAB 2 : APPLICATION FORM
  ========================================================== -->
        <div class="tab-pane fade" id="tab-apply" role="tabpanel" aria-labelledby="tab-apply-btn" tabindex="0">
            <div class="page-banner">
                <div class="container">
                    <h2>অনলাইন আবেদন ফরম</h2>
                    <p>সকল তারকা (*) চিহ্নিত তথ্য আবশ্যক</p>
                </div>
            </div>
            <div class="container py-4 py-md-5">
                <form id="applyForm" method="POST" action="{{ route('applicant.store') }}" enctype="multipart/form-data"
                    novalidate>
                    @csrf

                    {{-- Server-side errors / flash messages --}}
                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <div class="fw-bold mb-1">আবেদন জমা দেওয়া যায়নি। অনুগ্রহ করে নিচের ভুলগুলো ঠিক করুন:</div>
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <div class="small mt-2">দ্রষ্টব্য: নিরাপত্তার কারণে ফাইলগুলো আবার নির্বাচন করতে হবে।</div>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-warning" role="alert">{{ session('error') }}</div>
                    @endif

                    {{-- 1. Route (area) & category --}}
                    <section class="app-card mb-4">
                        <div class="card-head">
                            <div class="icon-chip"><svg class="ic">
                                    <use href="#i-pin" />
                                </svg></div>
                            <div>
                                <h3>রুট ও ক্যাটাগরি নির্বাচন</h3><span class="en-sub">Route &amp; Category</span>
                            </div>
                        </div>
                        <div class="card-pad">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="form-label">রুট<span class="req">*</span></div>
                                    <div class="row g-3">
                                        @foreach ($areas as $area)
                                            <div class="col-12 col-lg-6">
                                                <div class="position-relative h-100">
                                                    <input class="route-input" type="radio" name="area_id"
                                                        id="area{{ $area->id }}" value="{{ $area->id }}" {{ old('area_id') == $area->id ? 'checked' : '' }} required>
                                                    <label class="route-card" for="area{{ $area->id }}">
                                                        <span class="route-badge">{{ $loop->iteration }}</span>
                                                        <span>
                                                            <p class="route-title">{{ $area->area_name }}</p>
                                                        </span>
                                                        <svg class="ic check">
                                                            <use href="#i-check-circle" />
                                                        </svg>
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="text-danger small mt-2 d-none" id="routeError"><svg class="ic me-1">
                                            <use href="#i-alert" />
                                        </svg>অনুগ্রহ করে একটি রুট নির্বাচন করুন।</div>
                                    @error('area_id')
                                    <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 col-md-6">
                                    <label for="category" class="form-label">ক্যাটাগরি<span class="req">*</span></label>
                                    <select id="category" name="category_id" class="form-select" required>
                                        <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>--
                                            ক্যাটাগরি নির্বাচন করুন --</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">ক্যাটাগরি নির্বাচন করুন।</div>
                                    @error('category_id')
                                    <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- 2. Personal information (name/address fields: Bangla only, enforced by the controller regex)
                    --}}
                    <section class="app-card mb-4">
                        <div class="card-head">
                            <div class="icon-chip"><svg class="ic">
                                    <use href="#i-user" />
                                </svg></div>
                            <div>
                                <h3>ব্যক্তিগত তথ্য</h3><span class="en-sub">Personal Information</span>
                            </div>
                        </div>
                        <div class="card-pad">
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label for="aName" class="form-label">আবেদনকারীর নাম<span
                                            class="req">*</span></label>
                                    <input type="text" class="form-control" id="aName" name="applicant_name"
                                        value="{{ old('applicant_name') }}" maxlength="255"
                                        placeholder="আপনার পূর্ণ নাম বাংলায় লিখুন" required>
                                    <div class="invalid-feedback">নাম আবশ্যক (শুধুমাত্র বাংলা অক্ষর)।</div>
                                    @error('applicant_name')
                                    <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="fName" class="form-label">পিতা/স্বামীর নাম<span
                                            class="req">*</span></label>
                                    <input type="text" class="form-control" id="fName" name="guardian_name"
                                        value="{{ old('guardian_name') }}" maxlength="255"
                                        placeholder="পিতা বা স্বামীর নাম বাংলায় লিখুন" required>
                                    <div class="invalid-feedback">পিতা/স্বামীর নাম আবশ্যক (শুধুমাত্র বাংলা অক্ষর)।</div>
                                    @error('guardian_name')
                                    <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="presentAddr" class="form-label">বর্তমান ঠিকানা<span
                                            class="req">*</span></label>
                                    <textarea class="form-control" id="presentAddr" name="present_address" rows="2"
                                        maxlength="255" placeholder="বাসা/হোল্ডিং, এলাকা, থানা"
                                        required>{{ old('present_address') }}</textarea>
                                    <div class="invalid-feedback">বর্তমান ঠিকানা আবশ্যক (শুধুমাত্র বাংলা অক্ষর)।</div>
                                    @error('present_address')
                                    <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="permAddr" class="form-label">স্থায়ী ঠিকানা<span
                                            class="req">*</span></label>
                                    <textarea class="form-control" id="permAddr" name="permanent_address" rows="2"
                                        maxlength="255" placeholder="গ্রাম/মহল্লা, ডাকঘর, উপজেলা, জেলা"
                                        required>{{ old('permanent_address') }}</textarea>
                                    <div class="invalid-feedback">স্থায়ী ঠিকানা আবশ্যক (শুধুমাত্র বাংলা অক্ষর)।</div>
                                    @error('permanent_address')
                                    <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="nid" class="form-label">এনআইডি/জন্মনিবন্ধন নং<span
                                            class="req">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><svg class="ic">
                                                <use href="#i-card" />
                                            </svg></span>
                                        <input type="text" class="form-control en" id="nid" name="nid_no"
                                            value="{{ old('nid_no') }}" maxlength="50" inputmode="numeric"
                                            placeholder="10 / 13 / 17 digit" required>
                                    </div>
                                    @error('nid_no')
                                    <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="mobile" class="form-label">মোবাইল<span class="req">*</span></label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text"><svg class="ic">
                                                <use href="#i-phone" />
                                            </svg></span>
                                        {{-- English or Bangla digits, 10-11 long (the controller converts Bangla digits
                                        with Helper::bn2en) --}}
                                        <input type="tel" class="form-control en" id="mobile" name="phone"
                                            value="{{ old('phone') }}" maxlength="11" inputmode="numeric"
                                            placeholder="01XXXXXXXXX" pattern="[0-9০-৯]{10,11}" required>
                                        <div class="invalid-feedback">মোবাইল নম্বর ১০ বা ১১ ডিজিটের হতে হবে।</div>
                                    </div>
                                    @error('phone')
                                    <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="email" class="form-label">ইমেইল <span
                                            class="text-muted small fw-normal">(ঐচ্ছিক)</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><svg class="ic">
                                                <use href="#i-mail" />
                                            </svg></span>
                                        <input type="email" class="form-control en" id="email" name="email"
                                            value="{{ old('email') }}" maxlength="255" placeholder="name@example.com">
                                    </div>
                                    @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- 3. Documents (max 10 MB each, jpg/jpeg/png/pdf) --}}
                    <section class="app-card mb-4">
                        <div class="card-head">
                            <div class="icon-chip"><svg class="ic">
                                    <use href="#i-upload" />
                                </svg></div>
                            <div>
                                <h3>প্রয়োজনীয় ডকুমেন্ট সংযুক্তকরণ</h3><span class="en-sub">Document Uploads</span>
                            </div>
                        </div>
                        <div class="card-pad">
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label class="upload-box"><input type="file" name="applicant_image"
                                            accept=".jpg,.jpeg,.png,.pdf" data-upload required>
                                        <svg class="ic u-icon">
                                            <use href="#i-camera" />
                                        </svg><span class="u-label">আবেদনকারীর ছবি<span class="req">*</span></span><span
                                            class="u-hint">JPG / PNG / PDF • সর্বোচ্চ 10MB</span><span
                                            class="u-file"></span></label>
                                    @error('applicant_image')
                                    <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="upload-box"><input type="file" name="citizen_certificate_image"
                                            accept=".jpg,.jpeg,.png,.pdf" data-upload required>
                                        <svg class="ic u-icon">
                                            <use href="#i-receipt" />
                                        </svg><span class="u-label">নাগরিকত্ব সনদ / ইউটিলিটি বিল কপি<span
                                                class="req">*</span></span><span class="u-hint">নাগরিক সনদ/বাসা ভাড়ার
                                            চুক্তিপত্র/বাড়ীর মালিকের প্রত্যয়ন/গ্যাস, পানি বা বিদ্যুৎ বিল • সর্বোচ্চ
                                            10MB</span><span class="u-file"></span></label>
                                    @error('citizen_certificate_image')
                                    <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="upload-box"><input type="file" name="category_proof_image"
                                            accept=".jpg,.jpeg,.png,.pdf" data-upload required>
                                        <svg class="ic u-icon">
                                            <use href="#i-badge" />
                                        </svg><span class="u-label">ক্যাটাগরি প্রমানক<span
                                                class="req">*</span></span><span class="u-hint">JPG / PNG / PDF •
                                            সর্বোচ্চ 10MB</span><span class="u-file"></span></label>
                                    @error('category_proof_image')
                                    <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="upload-box"><input type="file" name="nid_image"
                                            accept=".jpg,.jpeg,.png,.pdf" data-upload required>
                                        <svg class="ic u-icon">
                                            <use href="#i-card" />
                                        </svg><span class="u-label">এনআইডি<span class="req">*</span></span><span
                                            class="u-hint">সামনে ও পেছনের পাতা • সর্বোচ্চ 10MB</span><span
                                            class="u-file"></span></label>
                                    @error('nid_image')
                                    <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- 4. Application fee (payment starts after the form is stored: JanataPayService::startPayment)
                    --}}
                    <section class="app-card mb-4">
                        <div class="card-head">
                            <div class="icon-chip gold"><svg class="ic">
                                    <use href="#i-wallet" />
                                </svg></div>
                            <div>
                                <h3>আবেদন ফি প্রদান</h3><span class="en-sub">Application Fee Payment</span>
                            </div>
                        </div>
                        <div class="card-pad">
                            <div class="fee-summary">
                                <div class="row align-items-center g-3">
                                    <div class="col-12 col-md-7">
                                        <p class="mb-1 text-muted fw-semibold">আবেদন ফি (এককালীন, অফেরতযোগ্য)</p>
                                        <div class="fee-amount">{{ $app_setting->application_fee ?? 200 }}<small
                                                class="fs-4">/- টাকা</small></div>
                                        <p class="secure-note mt-2 mb-0"><svg class="ic text-success me-1">
                                                <use href="#i-shield" />
                                            </svg>জমা দেওয়ার পর আপনাকে নিরাপদ পেমেন্ট গেটওয়েতে নিয়ে যাওয়া হবে</p>
                                    </div>
                                    <div class="col-12 col-md-5 text-md-end">
                                        <button type="submit" class="btn btn-gold btn-lg-cta w-100"
                                            id="applySubmitBtn"><svg class="ic">
                                                <use href="#i-lock" />
                                            </svg><span>Submit &amp; Pay via Payment Gateway</span></button>
                                    </div>
                                </div>
                            </div>
                            {{-- No "name" on purpose: this checkbox is only checked in the browser, it is not sent to
                            the controller --}}
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" id="declare" required>
                                <label class="form-check-label" for="declare">আমি ঘোষণা করছি যে উপরোক্ত তথ্যসমূহ সত্য ও
                                    নির্ভুল।</label>
                            </div>
                        </div>
                    </section>

                    <div class="text-center">
                        <button type="button" class="btn btn-outline-green" data-goto="#tab-home-btn"><svg class="ic">
                                <use href="#i-arrow-left" />
                            </svg>ফিরে যান</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- =========================================================
       TAB 3 : STATUS, YEARLY FEE & PAYMENT HISTORY
  ========================================================== -->
        <div class="tab-pane fade" id="tab-status" role="tabpanel" aria-labelledby="tab-status-btn" tabindex="0">
            <div class="page-banner">
                <div class="container">
                    <h2>আবেদনের অবস্থা ও ফি প্রদান</h2>
                    <p>NID ও মোবাইল নম্বর দিয়ে আপনার আবেদনের অবস্থা, বার্ষিক ফি ও পেমেন্ট ইতিহাস দেখুন</p>
                </div>
            </div>
            <div class="container py-4 py-md-5">

                <section class="app-card mb-4">
                    <div class="card-head">
                        <div class="icon-chip"><svg class="ic">
                                <use href="#i-search" />
                            </svg></div>
                        <div>
                            <h3>আবেদনের অবস্থা অনুসন্ধান করুন</h3><span class="en-sub">Track Application Status</span>
                        </div>
                    </div>
                    <div class="card-pad">
                        <form id="searchForm" class="row g-3 align-items-end" action="{{ route('applicant.search') }}" method="POST" novalidate>
                            @csrf
                            <div class="col-12 col-md-9">
                                <label for="sSearch" class="form-label">এনআইডি অথবা মোবাইল নম্বর</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><svg class="ic"><use href="#i-search" /></svg></span>
                                    <input type="text" class="form-control en" id="sSearch" name="search"
                                        inputmode="numeric" maxlength="17" autocomplete="off"
                                        placeholder="NID বা 01XXXXXXXXX" required>
                                    <div class="invalid-feedback">সঠিক এনআইডি বা মোবাইল নম্বর দিন (শুধু সংখ্যা, ১০–১৭ ডিজিট)।</div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3 d-flex gap-2">
                                <button type="submit" class="btn btn-green flex-grow-1" id="searchBtn">
                                    <svg class="ic"><use href="#i-search" /></svg><span>অনুসন্ধান</span>
                                </button>
                                <button type="button" class="btn btn-outline-green" id="resetSearch" title="রিসেট" aria-label="রিসেট">
                                    <svg class="ic"><use href="#i-reset" /></svg>
                                </button>
                            </div>
                        </form>

                        <div id="searchError" class="alert alert-warning mt-3 d-none" role="alert"></div>
                        <p class="text-muted small mt-3 mb-0"><svg class="ic me-1">
                                <use href="#i-info" />
                            </svg>ডেমো: যেকোনো NID ও মোবাইল নম্বর দিয়ে অনুসন্ধান করলে নমুনা ফলাফল দেখাবে।</p>
                    </div>
                </section>

                <div id="saveNotice" class="alert alert-success d-none d-flex align-items-center gap-2" role="status">
                    <svg class="ic">
                        <use href="#i-check-circle" />
                    </svg><span>আপনার আবেদনের পরিবর্তন সফলভাবে সংরক্ষিত হয়েছে।</span>
                </div>

                <div id="resultView" class="d-none fade-in">

                    

                </div><!-- /resultView -->

                <div class="text-center">
                    <button type="button" class="btn btn-outline-green" data-goto="#tab-home-btn"><svg class="ic">
                            <use href="#i-arrow-left" />
                        </svg>ফিরে যান</button>
                </div>
            </div>
        </div>

        <!-- =========================================================
       TAB 4 : EDIT APPLICATION (opened from the status result)
  ========================================================== -->
        <div class="tab-pane fade" id="tab-edit" role="tabpanel" aria-labelledby="tab-edit-btn" tabindex="0">
            <div class="page-banner">
                <div class="container">
                    <h2>আবেদন সম্পাদনা</h2>
                    <p class="en">Application ID: DCB-RK-2026-004217</p>
                </div>
            </div>
            <div class="container py-4 py-md-5">
                <div class="edit-notice mb-4">
                    <svg class="ic mt-1">
                        <use href="#i-info" />
                    </svg>
                    <div>আপনি আপনার জমা দেওয়া আবেদনের তথ্য পরিবর্তন করছেন। <strong>এনআইডি নম্বর পরিবর্তন করা যাবে
                            না।</strong> নতুন ডকুমেন্ট না দিলে আগের ডকুমেন্টই থাকবে।</div>
                </div>

                <form id="editForm" method="POST" action="#" enctype="multipart/form-data" novalidate>
                    @csrf
                    @method('PUT')   {{-- must match the verb of the applicant.update route; delete this line if it is Route::post --}}
                    <input type="hidden" name="current_nid" value="">

                    <div id="editErrors" class="alert alert-danger d-none" role="alert"></div>

                    {{-- Route & category --}}
                    <section class="app-card mb-4">
                        <div class="card-head">
                            <div class="icon-chip"><svg class="ic"><use href="#i-pin" /></svg></div>
                            <div><h3>রুট ও ক্যাটাগরি</h3><span class="en-sub">Route &amp; Category</span></div>
                        </div>
                        <div class="card-pad">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="form-label">রুট<span class="req">*</span></div>
                                    <div class="row g-3">
                                        @foreach ($areas as $area)
                                            <div class="col-12 col-lg-6">
                                                <div class="position-relative h-100">
                                                    <input class="route-input" type="radio" name="area_id" id="eArea{{ $area->id }}"
                                                        value="{{ $area->id }}" required>
                                                    <label class="route-card" for="eArea{{ $area->id }}">
                                                        <span class="route-badge">{{ $loop->iteration }}</span>
                                                        <span><p class="route-title">{{ $area->area_name }}</p></span>
                                                        <svg class="ic check"><use href="#i-check-circle" /></svg>
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="text-danger small mt-2 d-none" id="eRouteError">
                                        <svg class="ic me-1"><use href="#i-alert" /></svg>অনুগ্রহ করে একটি রুট নির্বাচন করুন।
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label for="eCategory" class="form-label">ক্যাটাগরি<span class="req">*</span></label>
                                    <select id="eCategory" name="category_id" class="form-select" required>
                                        <option value="" disabled>-- ক্যাটাগরি নির্বাচন করুন --</option>
                                        {{-- $editCategories = all categories (see note in the answer); falls back to $categories --}}
                                        @foreach (($editCategories ?? $categories) as $category)
                                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">ক্যাটাগরি নির্বাচন করুন।</div>
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- Personal information --}}
                    <section class="app-card mb-4">
                        <div class="card-head">
                            <div class="icon-chip"><svg class="ic"><use href="#i-user" /></svg></div>
                            <div><h3>ব্যক্তিগত তথ্য</h3><span class="en-sub">Personal Information</span></div>
                        </div>
                        <div class="card-pad">
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label for="eName" class="form-label">আবেদনকারীর নাম<span class="req">*</span></label>
                                    <input type="text" class="form-control" id="eName" name="applicant_name" maxlength="255" required>
                                    <div class="invalid-feedback">নাম আবশ্যক (শুধুমাত্র বাংলা অক্ষর)।</div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="eFather" class="form-label">পিতা/স্বামীর নাম<span class="req">*</span></label>
                                    <input type="text" class="form-control" id="eFather" name="guardian_name" maxlength="255" required>
                                    <div class="invalid-feedback">পিতা/স্বামীর নাম আবশ্যক (শুধুমাত্র বাংলা অক্ষর)।</div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="ePresent" class="form-label">বর্তমান ঠিকানা<span class="req">*</span></label>
                                    <textarea class="form-control" id="ePresent" name="present_address" rows="2" maxlength="255" required></textarea>
                                    <div class="invalid-feedback">বর্তমান ঠিকানা আবশ্যক (শুধুমাত্র বাংলা অক্ষর)।</div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="ePerm" class="form-label">স্থায়ী ঠিকানা<span class="req">*</span></label>
                                    <textarea class="form-control" id="ePerm" name="permanent_address" rows="2" maxlength="255" required></textarea>
                                    <div class="invalid-feedback">স্থায়ী ঠিকানা আবশ্যক (শুধুমাত্র বাংলা অক্ষর)।</div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="eNid" class="form-label">এনআইডি/জন্মনিবন্ধন নং
                                        <span class="text-muted small fw-normal">(পরিবর্তনযোগ্য নয়)</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><svg class="ic"><use href="#i-lock" /></svg></span>
                                        <input type="text" class="form-control en" id="eNid" name="nid_no" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="eMobile" class="form-label">মোবাইল<span class="req">*</span></label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text"><svg class="ic"><use href="#i-phone" /></svg></span>
                                        <input type="tel" class="form-control en" id="eMobile" name="phone" maxlength="11"
                                            inputmode="numeric" pattern="[0-9০-৯]{10,11}" required>
                                        <div class="invalid-feedback">মোবাইল নম্বর ১০ বা ১১ ডিজিটের হতে হবে।</div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="eEmail" class="form-label">ইমেইল <span class="text-muted small fw-normal">(ঐচ্ছিক)</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><svg class="ic"><use href="#i-mail" /></svg></span>
                                        <input type="email" class="form-control en" id="eEmail" name="email" maxlength="255">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- Documents (optional: only the files the user picks are sent and replaced) --}}
                    <section class="app-card mb-4">
                        <div class="card-head">
                            <div class="icon-chip"><svg class="ic"><use href="#i-upload" /></svg></div>
                            <div>
                                <h3>ডকুমেন্ট পরিবর্তন <span class="fs-6 fw-normal text-muted">(ঐচ্ছিক)</span></h3>
                                <span class="en-sub">নতুন ফাইল না দিলে আগের ফাইলই থাকবে</span>
                            </div>
                        </div>
                        <div class="card-pad">
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label class="upload-box"><input type="file" name="applicant_image" accept=".jpg,.jpeg,.png,.pdf" data-edit-upload>
                                        <svg class="ic u-icon"><use href="#i-camera" /></svg><span class="u-label">আবেদনকারীর ছবি</span><span class="u-hint">JPG / PNG / PDF • সর্বোচ্চ 10MB</span><span class="u-file"></span></label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="upload-box"><input type="file" name="citizen_certificate_image" accept=".jpg,.jpeg,.png,.pdf" data-edit-upload>
                                        <svg class="ic u-icon"><use href="#i-receipt" /></svg><span class="u-label">নাগরিকত্ব সনদ / ইউটিলিটি বিল কপি</span><span class="u-hint">JPG / PNG / PDF • সর্বোচ্চ 10MB</span><span class="u-file"></span></label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="upload-box"><input type="file" name="category_proof_image" accept=".jpg,.jpeg,.png,.pdf" data-edit-upload>
                                        <svg class="ic u-icon"><use href="#i-badge" /></svg><span class="u-label">ক্যাটাগরি প্রমানক</span><span class="u-hint">JPG / PNG / PDF • সর্বোচ্চ 10MB</span><span class="u-file"></span></label>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="upload-box"><input type="file" name="nid_image" accept=".jpg,.jpeg,.png,.pdf" data-edit-upload>
                                        <svg class="ic u-icon"><use href="#i-card" /></svg><span class="u-label">এনআইডি</span><span class="u-hint">সামনে ও পেছনের পাতা • সর্বোচ্চ 10MB</span><span class="u-file"></span></label>
                                </div>
                            </div>
                        </div>
                    </section>

                    <div class="d-flex flex-column flex-sm-row justify-content-center gap-2">
                        <button type="submit" class="btn btn-green btn-lg-cta"><svg class="ic"><use href="#i-check" /></svg>পরিবর্তন সংরক্ষণ করুন</button>
                        <button type="button" class="btn btn-outline-green btn-lg-cta" id="cancelEditBtn"><svg class="ic"><use href="#i-arrow-left" /></svg>বাতিল করুন</button>
                    </div>
                </form>
            </div>
        </div>

    </div><!-- /tab-content -->

    <footer class="text-center pb-4">
        <div class="container border-top pt-3">© ২০২৬ ঢাকা ক্যান্টনমেন্ট বোর্ড • সর্বস্বত্ব সংরক্ষিত</div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @if ($errors->any() || session('error'))
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        bootstrap.Tab.getOrCreateInstance(document.getElementById('tab-apply-btn')).show();
    });
    </script>
    @endif
    <script>
        (function () {
            'use strict';

            // ---- 1. Switch tabs from the CTA / back buttons ----
            document.querySelectorAll('[data-goto]').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var target = document.querySelector(btn.getAttribute('data-goto'));
                    if (target) {
                        bootstrap.Tab.getOrCreateInstance(target).show();
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                });
            });
            // Scroll to top when a top-nav tab is used
            document.querySelectorAll('#mainTabs [data-bs-toggle="pill"]').forEach(function (t) {
                t.addEventListener('shown.bs.tab', function () { window.scrollTo({ top: 0 }); });
            });

            // ---- 2. File upload name preview ----
            document.querySelectorAll('input[data-upload]').forEach(function (input) {
                var box = input.closest('.upload-box');
                var icon = box.querySelector('.u-icon use');
                var original = icon.getAttribute('href');
                input.addEventListener('change', function () {
                    var label = box.querySelector('.u-file');
                    if (input.files && input.files.length) {
                        label.textContent = input.files[0].name;
                        box.classList.add('has-file');
                        icon.setAttribute('href', '#i-check-circle');
                    } else {
                        label.textContent = '';
                        box.classList.remove('has-file');
                        icon.setAttribute('href', original);
                    }
                });
            });

            // ---- 3. Application form (real submit) ----
            var applyForm  = document.getElementById('applyForm');
            var routeError = document.getElementById('routeError');
            var submitBtn  = document.getElementById('applySubmitBtn');

            // The controller rejects any Latin letters in these four fields (regex), so check it client-side too
            ['applicant_name','guardian_name','present_address','permanent_address'].forEach(function (name) {
            var el = applyForm.elements[name];
            var check = function () {
                el.setCustomValidity(/[A-Za-z]/.test(el.value) ? 'শুধুমাত্র বাংলা অক্ষর ও সংখ্যা লিখুন।' : '');
            };
            el.addEventListener('input', check);
            check();
            });

            applyForm.addEventListener('submit', function (e) {
            var areaChosen = applyForm.querySelector('input[name="area_id"]:checked');
            routeError.classList.toggle('d-none', !!areaChosen);
            applyForm.classList.add('was-validated');

            if (!areaChosen || !applyForm.checkValidity()) {
                e.preventDefault();                       // stop only when invalid
                var firstInvalid = applyForm.querySelector(':invalid');
                if (firstInvalid && areaChosen) firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                return;
            }
            // Valid: let the browser submit normally. Lock the button so a double click can't send it twice.
            submitBtn.disabled = true;
            submitBtn.querySelector('span').textContent = 'অপেক্ষা করুন...';
            });

            applyForm.querySelectorAll('input[name="area_id"]').forEach(function (r) {
            r.addEventListener('change', function () { routeError.classList.add('d-none'); });
            });

            // If the user presses Back from the payment page, unlock the button again
            window.addEventListener('pageshow', function (ev) {
            if (ev.persisted) {
                submitBtn.disabled = false;
                submitBtn.querySelector('span').textContent = 'Submit & Pay via Payment Gateway';
            }
            });

            // ---- 4. Search (single field: NID or mobile) ----
            var searchForm  = document.getElementById('searchForm');
            var searchInput = document.getElementById('sSearch');
            var searchBtn   = document.getElementById('searchBtn');
            var searchError = document.getElementById('searchError');
            var resultView  = document.getElementById('resultView');

            function bn2en(s) { return s.replace(/[০-৯]/g, function (d) { return '০১২৩৪৫৬৭৮৯'.indexOf(d); }); }

            searchForm.addEventListener('submit', function (e) {
            e.preventDefault();
            searchError.classList.add('d-none');

            var term = bn2en(searchInput.value).replace(/\D+/g, '');
            var ok = /^\d{10,17}$/.test(term);
            searchInput.setCustomValidity(ok ? '' : 'invalid');
            searchForm.classList.add('was-validated');
            if (!ok) return;

            var fd = new FormData(searchForm);          // includes the @csrf token
            fd.set('search', term);

            searchBtn.disabled = true;
            fetch(searchForm.action, {
                method: 'POST',
                body: fd,
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            })
            .then(function (r) { if (!r.ok) throw new Error(r.status); return r.json(); })
            .then(function (data) {
                if (data.error) {
                resultView.classList.add('d-none');
                searchError.textContent = data.error;
                searchError.classList.remove('d-none');
                return;
                }
                resultView.innerHTML = data.html;          // server-rendered applicant.search view
                resultView.classList.remove('d-none');
                resultView.scrollIntoView({ behavior: 'smooth', block: 'start' });
            })
            .catch(function () {
                searchError.textContent = 'অনুসন্ধান করা যায়নি। অনুগ্রহ করে আবার চেষ্টা করুন।';
                searchError.classList.remove('d-none');
            })
            .finally(function () { searchBtn.disabled = false; });
            });

            searchInput.addEventListener('input', function () { searchInput.setCustomValidity(''); });

            document.getElementById('resetSearch').addEventListener('click', function () {
            searchForm.reset();
            searchForm.classList.remove('was-validated');
            searchError.classList.add('d-none');
            resultView.classList.add('d-none');
            resultView.innerHTML = '';
            });

            // ---- 5. AJAX helpers ----
            var ajaxHeaders = { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' };

            function parseResponse(r) {
                return r.json().catch(function () { return {}; })
                        .then(function (data) { return { ok: r.ok, status: r.status, data: data }; });
            }
            function errorMessages(res) {
                if (res.status === 419) return ['পেজের সেশন শেষ হয়ে গেছে। পেজটি রিফ্রেশ করে আবার চেষ্টা করুন।'];
                if (res.data && res.data.errors) return [].concat.apply([], Object.values(res.data.errors));
                return [(res.data && res.data.message) || 'কিছু একটা সমস্যা হয়েছে। অনুগ্রহ করে আবার চেষ্টা করুন।'];
            }
            function showAlert(box, msgs) {
                box.textContent = '';
                var ul = document.createElement('ul'); ul.className = 'mb-0 ps-3';
                msgs.forEach(function (m) { var li = document.createElement('li'); li.textContent = m; ul.appendChild(li); });
                box.appendChild(ul);
                box.classList.remove('d-none');
                box.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            function goToStatusTab() {
                bootstrap.Tab.getOrCreateInstance(document.getElementById('tab-status-btn')).show();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }

            // ---- 6. Yearly fee payment (the form lives inside the AJAX-loaded result) ----
            resultView.addEventListener('submit', function (e) {
                var form = e.target.closest('form[data-ajax]');
                if (!form) return;
                e.preventDefault();

                var box = form.parentElement.querySelector('[data-form-alert]');
                var btn = form.querySelector('button[type=submit]');
                box.classList.add('d-none');
                btn.disabled = true;

                fetch(form.action, { method: 'POST', body: new FormData(form), headers: ajaxHeaders })
                    .then(parseResponse)
                    .then(function (res) {
                        if (res.ok && res.data.redirect) { window.location.href = res.data.redirect; return; }  // stays disabled while leaving
                        showAlert(box, errorMessages(res));
                        btn.disabled = false;
                    })
                    .catch(function () {
                        showAlert(box, ['নেটওয়ার্ক সমস্যা। অনুগ্রহ করে আবার চেষ্টা করুন।']);
                        btn.disabled = false;
                    });
            });

            // If the user comes Back from the payment page, unlock the button
            window.addEventListener('pageshow', function (ev) {
                if (ev.persisted) {
                    resultView.querySelectorAll('form[data-ajax] button[type=submit]').forEach(function (b) { b.disabled = false; });
                }
            });

            // ---- 7. Edit application ----
            var editForm    = document.getElementById('editForm');
            var editErrors  = document.getElementById('editErrors');
            var saveNotice  = document.getElementById('saveNotice');
            var editTabItem = document.getElementById('editTabItem');
            var editTabBtn  = document.getElementById('tab-edit-btn');
            var eRouteError = document.getElementById('eRouteError');      // optional

            // Open the edit tab and fill it from the button's data
            resultView.addEventListener('click', function (e) {
                var btn = e.target.closest('#editAppBtn');
                if (!btn) return;

                var d = JSON.parse(btn.getAttribute('data-applicant'));
                editForm.action = btn.getAttribute('data-update-url');
                if (editForm.elements['current_nid']) editForm.elements['current_nid'].value = d.nid_no;
                editForm.classList.remove('was-validated');
                editErrors.classList.add('d-none');
                if (eRouteError) eRouteError.classList.add('d-none');

                ['applicant_name', 'guardian_name', 'present_address', 'permanent_address',
                'nid_no', 'phone', 'email', 'category_id'].forEach(function (n) {
                    var el = editForm.elements[n];
                    if (el) el.value = d[n] == null ? '' : d[n];
                });
                var radio = editForm.querySelector('input[name="area_id"][value="' + d.area_id + '"]');
                if (radio) radio.checked = true;

                editForm.querySelectorAll('input[data-edit-upload]').forEach(function (inp) {
                    inp.value = '';
                    var box = inp.closest('.upload-box');
                    box.classList.remove('has-file');
                    box.querySelector('.u-file').textContent = '';
                });

                saveNotice.classList.add('d-none');
                editTabItem.classList.remove('d-none');
                bootstrap.Tab.getOrCreateInstance(editTabBtn).show();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });

            // Hide the extra tab as soon as the user leaves it
            editTabBtn.addEventListener('hidden.bs.tab', function () { editTabItem.classList.add('d-none'); });
            document.getElementById('cancelEditBtn').addEventListener('click', goToStatusTab);

            // Show the chosen replacement file name
            editForm.querySelectorAll('input[data-edit-upload]').forEach(function (inp) {
                inp.addEventListener('change', function () {
                    var box = inp.closest('.upload-box');
                    var label = box.querySelector('.u-file');
                    var has = inp.files && inp.files.length;
                    label.textContent = has ? inp.files[0].name : '';
                    box.classList.toggle('has-file', !!has);
                });
            });

            // Save
            editForm.addEventListener('submit', function (e) {
                e.preventDefault();
                editErrors.classList.add('d-none');
                editForm.classList.add('was-validated');

                var areaChosen = editForm.querySelector('input[name="area_id"]:checked');
                if (eRouteError) eRouteError.classList.toggle('d-none', !!areaChosen);
                if (!areaChosen || !editForm.checkValidity()) {
                    var bad = editForm.querySelector(':invalid');
                    if (bad) bad.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    return;
                }

                var btn = editForm.querySelector('button[type=submit]');
                btn.disabled = true;

                fetch(editForm.action, { method: 'POST', body: new FormData(editForm), headers: ajaxHeaders })   // _method=PUT is inside the form data
                    .then(parseResponse)
                    .then(function (res) {
                        if (!res.ok) { showAlert(editErrors, errorMessages(res)); return; }   // stays on the edit tab

                        goToStatusTab();
                        saveNotice.classList.remove('d-none');
                        if (res.data.nid_no) searchInput.value = res.data.nid_no;
                        searchForm.dispatchEvent(new Event('submit', { cancelable: true }));   // reload the result with fresh data
                    })
                    .catch(function () { showAlert(editErrors, ['নেটওয়ার্ক সমস্যা। অনুগ্রহ করে আবার চেষ্টা করুন।']); })
                    .finally(function () { btn.disabled = false; });
            });
        })();
    </script>
</body>

</html>