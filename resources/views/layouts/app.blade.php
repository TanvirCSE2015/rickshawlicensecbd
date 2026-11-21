<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    <title>@yield('title', 'ঢাকা ক্যান্টনমেন্ট বোর্ড - রিক্সা লাইসেন্স ব্যবস্থাপনা')</title>

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
                    <ul class="nav topnav flex-nowrap" id="mainTabs">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                                <svg class="ic"><use href="#i-home" /></svg>হোম</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('applicant.create') ? 'active' : '' }}" href="{{ route('applicant.create') }}">
                                <svg class="ic"><use href="#i-file" /></svg>আবেদন ফরম</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('applicant.status') ? 'active' : '' }}" href="{{ route('applicant.status') }}">
                                <svg class="ic"><use href="#i-search" /></svg>আবেদনের অবস্থা ও ফি প্রদান</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    @yield('content')

    <footer class="text-center pb-4">
        <div class="container border-top pt-3">© ২০২৬ ঢাকা ক্যান্টনমেন্ট বোর্ড • সর্বস্বত্ব সংরক্ষিত</div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
