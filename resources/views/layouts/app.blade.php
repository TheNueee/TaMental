<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">


    {{-- Custom CSS --}}
    <style>
        :root {
            --primary-orange: #F4A261;
            --secondary-orange: #E76F51;
            --text-dark: #2D3748;
            --text-light: #718096;
            --border-light: #E2E8F0;
            --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --border-radius-lg: 12px;
            --border-radius-full: 9999px;
        }

        body {
            font-family: 'Lexend Deca', sans-serif;
            font-weight: 400;
            line-height: 1.6;
            color: var(--text-dark);
            padding-top: 0;
        }

        /* Navbar Styles */
        .custom-navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border-light);
            border-radius: var(--border-radius-lg);
            padding: 8px 24px;
            width: 95%;
            max-width: 1200px;
            margin: 16px auto;
            box-shadow: var(--shadow-md);
            transition: all 0.3s ease;
        }

        .custom-navbar:hover {
            box-shadow: 0 8px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .navbar-brand {
            font-weight: 600;
            font-size: 1.25rem;
            color: var(--text-dark) !important;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .navbar-logo {
            height: 32px;
            width: auto;
            object-fit: contain;
        }

        .navbar-nav .nav-link {
            font-weight: 500;
            font-size: 0.95rem;
            color: var(--text-dark) !important;
            padding: 8px 16px !important;
            margin: 0 4px;
            border-radius: 8px;
            transition: all 0.2s ease;
            position: relative;
        }

        .navbar-nav .nav-link:hover {
            color: var(--primary-orange) !important;
            background-color: rgba(244, 162, 97, 0.1);
            transform: translateY(-1px);
        }

        .navbar-nav .nav-link:active,
        .navbar-nav .nav-link.active {
            color: var(--primary-orange) !important;
            background-color: rgba(244, 162, 97, 0.15);
        }

        /* CTA Button Styles */
        .btn-cta {
            background: linear-gradient(135deg, var(--primary-orange) 0%, var(--secondary-orange) 100%);
            border: none;
            border-radius: var(--border-radius-full);
            padding: 10px 24px;
            font-size: 0.95rem;
            font-weight: 600;
            color: white !important;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-sm);
            min-width: 120px;
            white-space: nowrap;
        }

        .btn-cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(244, 162, 97, 0.4);
            color: white !important;
            opacity: 0.95;
        }

        .btn-cta:active {
            transform: translateY(0);
            box-shadow: var(--shadow-sm);
        }

        .btn-cta2 {
            background: linear-gradient(135deg, var(--primary-orange) 0%, var(--secondary-orange) 100%);
            border: none;
            border-radius: var(--border-radius-full);
            padding: 14px 32px;
            font-size: 1.1rem;
            font-weight: 600;
            color: white !important;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-md);
            min-width: 160px;
            white-space: nowrap;
        }

        .btn-cta2:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px -5px rgba(244, 162, 97, 0.5);
            color: white !important;
            opacity: 0.95;
        }

        .btn-cta2:active {
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .btn-outline-cta {
            color: var(--primary-orange);
            border: 2px solid var(--primary-orange);
            background-color: transparent;
            transition: all 0.3s ease;
        }

        .btn-outline-cta:hover {
        background-color: var(--primary-orange);
        color: white;
}

        /* Login Link */
        .btn-login {
            color: var(--primary-orange) !important;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            padding: 10px 16px;
            border-radius: 8px;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .btn-login:hover {
            color: var(--secondary-orange) !important;
            background-color: rgba(244, 162, 97, 0.1);
            transform: translateY(-1px);
        }

        /* Primary Text */
        .primarytext {
            color: var(--primary-orange);
            font-weight: 600;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .custom-navbar {
                width: 95%;
                margin: 12px auto;
                padding: 12px 16px;
            }

            .navbar-nav .nav-link {
                padding: 12px 8px !important;
                margin: 2px 0;
            }

            .btn-cta {
                padding: 12px 20px;
                font-size: 0.9rem;
                min-width: 100px;
            }

            .btn-cta2 {
                padding: 14px 24px;
                font-size: 1rem;
                min-width: 140px;
            }

            .navbar-collapse {
                margin-top: 16px;
                padding-top: 16px;
                border-top: 1px solid var(--border-light);
            }

            .d-flex.align-items-center {
                flex-direction: column;
                gap: 12px;
                align-items: stretch !important;
            }

            .d-flex.align-items-center > * {
                text-align: center;
            }
        }

        /* Navbar Toggle Button */
        .navbar-toggler {
            border: none;
            padding: 4px 8px;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .navbar-toggler:hover {
            background-color: rgba(244, 162, 97, 0.1);
        }

        .navbar-toggler:focus {
            box-shadow: 0 0 0 3px rgba(244, 162, 97, 0.25);
        }

        /* Footer */
        .footer {
            background-color: #f8f9fa;
            border-top: 1px solid var(--border-light);
            margin-top: 60px;
        }

        /* Main Content */
        main {
            padding-top: 100px;
        }

        @media (max-width: 768px) {
            main {
                padding-top: 120px;
            }
        }

        /* Detail Page Container */
        .detail-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px;
            background: white;
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-md);
            margin-top: 4px;
        }

        .detail-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--border-light);
        }

        .detail-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .detail-subtitle {
            color: var(--text-light);
            font-size: 1.1rem;
            font-weight: 500;
        }

        /* Detail Info Cards */
        .detail-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .detail-info-card {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border: 1px solid var(--border-light);
            border-radius: var(--border-radius-lg);
            padding: 20px;
            transition: all 0.3s ease;
        }

        .detail-info-label {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-light);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .detail-info-value {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        /* Score Cards */
        .score-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .score-card {
            background: white;
            border: 2px solid var(--border-light);
            border-radius: var(--border-radius-lg);
            padding: 25px;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .score-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, var(--primary-orange), var(--secondary-orange));
        }

        .score-type {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 15px;
        }

        .score-value {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary-orange);
            margin-bottom: 10px;
            line-height: 1;
        }

        .score-category {
            display: inline-block;
            padding: 8px 16px;
            border-radius: var(--border-radius-full);
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Score Category Colors */
        .category-normal {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }

        .category-mild {
            background: linear-gradient(135deg, #f2d43c, #ffc400);
            color: white;
        }

        .category-moderate {
            background: linear-gradient(135deg, #efa544, #ff9100);
            color: white;
        }

        .category-severe {
            background: linear-gradient(135deg, #ed523a, #ff1900);
            color: white;
        }

        .category-extremely-severe {
            background: linear-gradient(135deg, #d42c2c, #ff0000);
            color: white;
        }

        /* Action Buttons */
        .detail-actions {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            padding-top: 20px;
            border-top: 1px solid var(--border-light);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            border: none;
            border-radius: var(--border-radius-full);
            padding: 12px 24px;
            font-size: 0.95rem;
            font-weight: 600;
            color: white;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-sm);
            cursor: pointer;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(239, 68, 68, 0.4);
            color: white;
            opacity: 0.95;
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6b7280, #4b5563);
            border: none;
            border-radius: var(--border-radius-full);
            padding: 12px 24px;
            font-size: 0.95rem;
            font-weight: 600;
            color: white;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-sm);
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(107, 114, 128, 0.4);
            color: white;
            opacity: 0.95;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .detail-container {
                margin: 4px;
                padding: 15px;
            }
            
            .detail-title {
                font-size: 1.5rem;
            }
            
            .score-cards {
                grid-template-columns: 1fr;
            }
            
            .detail-actions {
                flex-direction: column;
            }
            
            .score-value {
                font-size: 2rem;
            }
        }

        /* Animation for page load */
        .custom-navbar {
            animation: slideDown 0.6s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* RIWAYAT-RIWAYAT */
        .consultation-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        font-family: 'Lexend Deca', sans-serif;
        }

        .header-section {
            background: linear-gradient(135deg, var(--primary-orange) 0%, var(--secondary-orange) 100%);
            border-radius: var(--border-radius-lg);
            padding: 40px;
            color: white;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-md);
        }

        .header-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .header-content {
            position: relative;
            z-index: 2;
        }

        .header-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .header-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 25px;
        }

        .new-consultation-btn {
            background: rgba(255,255,255,0.2);
            border: 2px solid rgba(255,255,255,0.3);
            color: white;
            padding: 15px 30px;
            border-radius: var(--border-radius-full);
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            box-shadow: var(--shadow-sm);
        }

        .new-consultation-btn:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            color: white;
            text-decoration: none;
        }

        .controls-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            gap: 20px;
            flex-wrap: wrap;
        }

        .timeline-section {
            position: relative;
        }

        .timeline-header {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 15px;
            font-family: 'Lexend Deca', sans-serif;
        }

        .timeline-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary-orange), var(--secondary-orange));
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            box-shadow: var(--shadow-sm);
        }

        .consultation-timeline {
            position: relative;
        }

        .consultation-card {
            background: white;
            border-radius: var(--border-radius-lg);
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-light);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            font-family: 'Lexend Deca', sans-serif;
        }

        .consultation-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }

        .consultation-card:hover::before {
            width: 8px;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .layanan-info {
            flex-grow: 1;
        }

        .layanan-name {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 8px;
            font-family: 'Lexend Deca', sans-serif;
        }

        .professional-name {
            color: var(--primary-orange);
            font-weight: 600;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 8px;
            font-family: 'Lexend Deca', sans-serif;
        }

        .status-badge {
            padding: 8px 16px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-scheduled {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
        }

        .status-completed {
            background: linear-gradient(135deg, #2196F3, #1976D2);
            color: white;
        }

        .status-cancelled {
            background: linear-gradient(135deg, #f44336, #d32f2f);
            color: white;
        }

        .status-pending {
            background: linear-gradient(135deg, #FF9800, #F57C00);
            color: white;
        }

        .datetime-info {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 12px;
        }

        .datetime-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-light);
            font-weight: 500;
            font-family: 'Lexend Deca', sans-serif;
        }

        .datetime-icon {
            width: 20px;
            height: 20px;
            color: var(--primary-orange);
        }

        .actions-section {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
        }

        .action-btn {
            padding: 10px 20px;
            border-radius: var(--border-radius-full);
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
            font-family: 'Lexend Deca', sans-serif;
            box-shadow: var(--shadow-sm);
        }

        .btn-join {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
        }

        .btn-join:hover {
            background: linear-gradient(135deg, #45a049, #388e3c);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(76, 175, 80, 0.3);
            color: white;
            text-decoration: none;
        }

        .btn-reschedule {
            background: linear-gradient(135deg, #FF9800, #F57C00);
            color: white;
        }

        .btn-reschedule:hover {
            background: linear-gradient(135deg, #F57C00, #E65100);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 152, 0, 0.3);
            color: white;
            text-decoration: none;
        }

        .btn-cancel {
            background: linear-gradient(135deg, #f44336, #d32f2f);
            color: white;
        }

        .btn-cancel:hover {
            background: linear-gradient(135deg, #d32f2f, #b71c1c);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(244, 67, 54, 0.3);
        }

        .empty-state {
            text-align: center;
            padding: 80px 20px;
            color: #999;
        }

        .empty-icon {
            width: 120px;
            height: 120px;
            margin: 0 auto 30px;
            background: #f8f9fa;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            color: #ddd;
        }

        .empty-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #666;
            margin-bottom: 10px;
        }

        .empty-description {
            font-size: 1rem;
            color: #999;
            margin-bottom: 30px;
        }

        .alert {
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            border: none;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .alert-success {
            background: linear-gradient(135deg, rgba(76, 175, 80, 0.1), rgba(69, 160, 73, 0.1));
            color: #2e7d32;
            border-left: 5px solid #4CAF50;
        }

        /* Reschedule */
        .reschedule-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .reschedule-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .reschedule-header h2 {
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .reschedule-subtitle {
            color: #7f8c8d;
            font-size: 16px;
        }

        .progress-steps {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 40px;
        }

        .progress-step {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .step-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .step-circle.completed {
            background: #27ae60;
            color: white;
        }

        .step-circle.active {
            background: #3498db;
            color: white;
        }

        .step-circle.pending {
            background: #ecf0f1;
            color: #95a5a6;
        }

        .step-connector {
            width: 100px;
            height: 3px;
            background: #ecf0f1;
            margin: 0 10px;
        }

        .step-connector.completed {
            background: #27ae60;
        }

        .step-label {
            font-size: 14px;
            color: #7f8c8d;
        }

        .reschedule-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .card-section {
            padding: 25px;
            border-bottom: 1px solid #ecf0f1;
        }

        .card-section:last-child {
            border-bottom: none;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 18px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .current-appointment {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
        }

        .appointment-detail {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }

        .appointment-detail:last-child {
            margin-bottom: 0;
        }

        .detail-icon {
            font-size: 18px;
        }

        .detail-label {
            font-weight: 600;
            color: #2c3e50;
            min-width: 100px;
        }

        .detail-value {
            color: #34495e;
        }

        .calendar-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .calendar-container {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .month-year {
            font-size: 18px;
            font-weight: 600;
            color: #2c3e50;
            margin: 0;
        }

        .calendar-nav {
            display: flex;
            gap: 10px;
        }

        .nav-btn {
            background: #E76F51;
            color: white;
            border: none;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            cursor: pointer;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s;
        }

        .nav-btn:hover {
            background: #2980b9;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
        }

        .calendar-day-header {
            text-align: center;
            font-weight: 600;
            color: #7f8c8d;
            padding: 10px 5px;
            font-size: 12px;
        }

        .calendar-day {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 500;
            background: white;
        }

        .calendar-day:hover:not(.other-month):not(.disabled) {
            background: #e3f2fd;
        }

         .today-btn {
            background: var(--primary-orange);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .today-btn:hover {
            background: var(--secondary-orange);
        }

        .calendar-day.today {
            background: #F4A261;
            color: white;
        }

        .calendar-day.selected {
            background: #27ae60 !important;
            color: white;
        }

        .calendar-day.other-month {
            background: #dedede;
            border-color: #fadbd8;
            color: #676767;
            cursor: not-allowed;
            text-decoration: line-through;
        }

        .calendar-day.disabled {
            color: #e74c3c;
            background: #fdf2f2;
            cursor: not-allowed;
            text-decoration: line-through;
        }

        .time-slots-container {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
        }

        .period-title {
            font-size: 16px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .time-slots-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }

        .time-slot {
            background: white;
            border: 2px solid #ecf0f1;
            border-radius: 8px;
            padding: 12px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 500;
        }

        .time-slot:hover:not(.disabled) {
            border-color: #3498db;
            background: #e3f2fd;
        }

        .time-slot.selected {
            background: #27ae60;
            border-color: #27ae60;
            color: white;
        }

        .time-slot.disabled {
            background: #fdf2f2;
            border-color: #fadbd8;
            color: #e74c3c;
            cursor: not-allowed;
            text-decoration: line-through;
        }


        .confirmation-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .confirmation-details {
            display: grid;
            gap: 12px;
        }

        .confirmation-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .confirmation-label {
            font-weight: 500;
            opacity: 0.9;
        }

        .confirmation-value {
            font-weight: 600;
        }

        .policy-notice {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 10px;
            padding: 15px;
            display: flex;
            gap: 12px;
            align-items: flex-start;
        }

        .policy-icon {
            font-size: 20px;
            flex-shrink: 0;
        }

        .policy-text {
            color: #856404;
            line-height: 1.5;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            padding: 25px;
            background: #f8f9fa;
        }


        .alert {
            margin-top: 20px;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid transparent;
        }

        .alert-danger {
            background: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }

        @media (max-width: 768px) {
            .calendar-section {
                grid-template-columns: 2fr;
            }
            
            .time-slots-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .action-buttons {
                flex-direction: column;
            }
        }

        /* Consultation Events */
        .consultation-event {
            background: var(--primary-orange);
            color: white;
            padding: 2px 4px;
            border-radius: 4px;
            font-size: 0.65rem;
            margin-bottom: 2px;
            cursor: pointer;
            transition: all 0.2s ease;
            line-height: 1.2;
        }

        .consultation-event:hover {
            background: var(--secondary-orange);
            transform: scale(1.05);
        }

        .consultation-event.scheduled {
            background: #10b981;
        }

        .consultation-event.pending {
            background: #f59e0b;
        }

        .consultation-event.completed {
            background: #6b7280;
        }

        .consultation-event.cancelled {
            background: #ef4444;
        }

        /* Consultation List */
        .consultation-card {
            background: white;
            padding: 15px;
            border-radius: 10px;
            border-left: 4px solid var(--primary-orange);
            box-shadow: var(--shadow-sm);
            margin-bottom: 12px;
            transition: all 0.2s ease;
        }

        .consultation-card:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .consultation-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 8px;
        }

        .consultation-client {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
        }

        .consultation-service {
            font-size: 0.85rem;
            color: var(--text-light);
            margin: 2px 0;
        }/* ==================== RESCHEDULE STYLES ==================== */

        .reschedule-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .reschedule-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .reschedule-header h2 {
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .reschedule-subtitle {
            color: #7f8c8d;
            font-size: 16px;
        }

        .reschedule-progress-steps {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 40px;
        }

        .reschedule-progress-step {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .reschedule-step-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-bottom: 8px;
            color: var(--primary-orange)
        }

        .reschedule-step-circle.completed {
            background: #27ae60;
            color: white;
        }

        .reschedule-step-circle.active {
            background: var(--primary-orange);
            color: white;
        }

        .reschedule-step-circle.pending {
            background: #ecf0f1;
            color: #95a5a6;
        }

        .reschedule-step-connector {
            width: 100px;
            height: 3px;
            background: #ecf0f1;
            margin: 0 10px;
        }

        .reschedule-step-connector.completed {
            background: #27ae60;
        }

        .reschedule-step-label {
            font-size: 14px;
            color: #7f8c8d;
        }

        .reschedule-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .reschedule-card-section {
            padding: 25px;
        }

        .reschedule-card-section:last-child {
            border-bottom: none;
        }

        .reschedule-section-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 18px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .reschedule-current-appointment {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
        }

        .reschedule-appointment-detail {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }

        .reschedule-appointment-detail:last-child {
            margin-bottom: 0;
        }

        .reschedule-detail-icon {
            font-size: 18px;
        }

        .reschedule-detail-label {
            font-weight: 600;
            color: #2c3e50;
            min-width: 100px;
        }

        .reschedule-detail-value {
            color: #34495e;
        }

        .reschedule-calendar-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .reschedule-calendar-container {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
        }

        .reschedule-calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .reschedule-month-year {
            font-size: 18px;
            font-weight: 600;
            color: #2c3e50;
            margin: 0;
        }

        .reschedule-calendar-nav {
            display: flex;
            gap: 10px;
        }

        .reschedule-nav-btn {
            background: #E76F51;
            color: white;
            border: none;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            cursor: pointer;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s;
        }

        .reschedule-nav-btn:hover {
            background: #2980b9;
        }

        .reschedule-calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
        }

        .reschedule-calendar-day-header {
            text-align: center;
            font-weight: 600;
            color: #7f8c8d;
            padding: 10px 5px;
            font-size: 12px;
        }

        .reschedule-calendar-day {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 500;
            background: white;
        }

        .reschedule-calendar-day:hover:not(.other-month):not(.disabled) {
            background: #e3f2fd;
        }

        .reschedule-today-btn {
            background: var(--primary-orange);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .reschedule-today-btn:hover {
            background: var(--secondary-orange);
        }

        .reschedule-calendar-day.today {
            background: #F4A261;
            color: white;
        }

        .reschedule-calendar-day.selected {
            background: #27ae60 !important;
            color: white;
        }

        .reschedule-calendar-day.other-month {
            background: #dedede;
            border-color: #fadbd8;
            color: #676767;
            cursor: not-allowed;
            text-decoration: line-through;
        }

        .reschedule-calendar-day.disabled {
            color: #e74c3c;
            background: #fdf2f2;
            cursor: not-allowed;
            text-decoration: line-through;
        }

        .reschedule-time-slots-container {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
        }

        .reschedule-period-title {
            font-size: 16px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .reschedule-time-slots-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }

        .reschedule-time-slot {
            background: white;
            border: 2px solid #ecf0f1;
            border-radius: 8px;
            padding: 12px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 500;
        }

        .reschedule-time-slot:hover:not(.disabled) {
            border-color: #3498db;
            background: #e3f2fd;
        }

        .reschedule-time-slot.selected {
            background: #27ae60;
            border-color: #27ae60;
            color: white;
        }

        .reschedule-time-slot.disabled {
            background: #fdf2f2;
            border-color: #fadbd8;
            color: #e74c3c;
            cursor: not-allowed;
            text-decoration: line-through;
        }

        .reschedule-confirmation-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .reschedule-confirmation-details {
            display: grid;
            gap: 12px;
        }

        .reschedule-confirmation-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .reschedule-confirmation-label {
            font-weight: 500;
            opacity: 0.9;
        }

        .reschedule-confirmation-value {
            font-weight: 600;
        }

        .reschedule-policy-notice {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 10px;
            padding: 10px;
            display: flex;
            gap: 12px;
            align-items: flex-start;
            margin-left: 18px;
            margin-right: 18px;
            margin-bottom: 18px;
        }

        .reschedule-policy-icon {
            font-size: 20px;
            flex-shrink: 0;
        }

        .reschedule-policy-text {
            color: #856404;
            line-height: 1.5;
        }

        .reschedule-action-buttons {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            padding: 25px;
            background: #f8f9fa;
        }

        .reschedule-alert {
            margin-top: 20px;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid transparent;
        }

        .reschedule-alert-danger {
            background: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }

        @media (max-width: 768px) {
            .reschedule-calendar-section {
                grid-template-columns: 2fr;
            }

            .reschedule-time-slots-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .reschedule-action-buttons {
                flex-direction: column;
            }
        }

        /* ================= PROFESSIONAL HISTORY STYLES ================= */

        .professional-calendar-consultation-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 16px;
            box-shadow: var(--shadow-md);
        }

        .professional-calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f1f5f9;
        }

        .professional-calendar-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
        }

        .professional-calendar-subtitle {
            color: var(--text-light);
            font-size: 0.95rem;
            margin-top: 5px;
        }

        .professional-calendar-nav {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .professional-nav-btn {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            color: var(--text-dark);
            text-decoration: none;
        }

        .professional-nav-btn:hover {
            background: var(--primary-orange);
            color: white;
            border-color: var(--primary-orange);
            text-decoration: none;
        }

        .professional-today-btn {
            background: var(--primary-orange);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .professional-today-btn:hover {
            background: var(--secondary-orange);
        }

        .professional-month-year {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0 20px;
        }

        .professional-calendar-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            align-items: start;
        }

        .professional-calendar-section,
        .professional-consultations-section {
            background: #f9fafb;
            border-radius: 12px;
            padding: 20px;
        }

        .professional-consultations-section {
            max-height: 600px;
            overflow-y: auto;
        }

        .professional-section-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .professional-calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 1px;
            background: #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
        }

        .professional-calendar-header-cell {
            background: #f8fafc;
            padding: 8px 4px;
            text-align: center;
            font-weight: 600;
            color: var(--text-light);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .professional-calendar-day {
            background: white;
            min-height: 70px;
            padding: 6px;
            position: relative;
            transition: background-color 0.2s ease;
            cursor: pointer;
        }

        .professional-calendar-day:hover {
            background: #f8fafc;
        }

        .professional-calendar-day.other-month {
            background: #f8fafc;
            color: #cbd5e0;
        }

        .professional-calendar-day.today {
            background: #fef3e2;
            border: 2px solid var(--primary-orange);
        }

        .professional-day-number {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 3px;
            font-size: 0.8rem;
        }

        .professional-other-month .professional-day-number {
            color: #cbd5e0;
        }

        .professional-today .professional-day-number {
            color: var(--primary-orange);
            font-weight: 700;
        }

        .professional-consultation-event {
            background: var(--primary-orange);
            color: white;
            padding: 2px 4px;
            border-radius: 4px;
            font-size: 0.65rem;
            margin-bottom: 2px;
            cursor: pointer;
            transition: all 0.2s ease;
            line-height: 1.2;
        }

        .professional-consultation-event:hover {
            background: var(--secondary-orange);
            transform: scale(1.05);
        }

        .professional-consultation-event.scheduled {
            background: #10b981;
        }

        .professional-consultation-event.pending {
            background: #f59e0b;
        }

        .professional-consultation-event.completed {
            background: #6b7280;
        }

        .professional-consultation-event.cancelled {
            background: #ef4444;
        }

        .professional-consultation-card {
            background: white;
            padding: 15px;
            border-radius: 10px;
            border-left: 4px solid var(--primary-orange);
            box-shadow: var(--shadow-sm);
            margin-bottom: 12px;
            transition: all 0.2s ease;
        }

        .professional-consultation-card:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .professional-consultation-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 8px;
        }

        .professional-consultation-client {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
        }

        .professional-consultation-service {
            font-size: 0.85rem;
            color: var(--text-light);
            margin: 2px 0;
        }

        .professional-consultation-time {
            font-size: 0.85rem;
            color: var(--text-dark);
            font-weight: 500;
        }

        .professional-consultation-actions {
            display: flex;
            flex-direction: column;
            gap: 5px;
            align-items: end;
        }

        .professional-status-badge {
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.7rem;
            font-weight: 600;
            color: white;
        }

        .professional-status-scheduled {
            background: #10b981;
        }

        .professional-status-pending {
            background: #f59e0b;
        }

        .professional-status-completed {
            background: #6b7280;
        }

        .professional-status-cancelled {
            background: #ef4444;
        }

        .professional-join-meeting-btn {
            background: var(--secondary-orange);
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.75rem;
            font-weight: 600;
            transition: background 0.2s ease;
        }

        .professional-join-meeting-btn:hover {
            background: #d15e47;
            color: white;
            text-decoration: none;
        }

        .professional-calendar-legend {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 15px;
            flex-wrap: wrap;
        }

        .professional-legend-item {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.8rem;
            color: var(--text-light);
        }

        .professional-legend-color {
            width: 12px;
            height: 12px;
            border-radius: 3px;
        }

        .professional-legend-color.scheduled {
            background: #10b981;
        }

        .professional-legend-color.pending {
            background: #f59e0b;
        }

        .professional-legend-color.completed {
            background: #6b7280;
        }

        .professional-legend-color.cancelled {
            background: #ef4444;
        }

        .professional-empty-state {
            text-align: center;
            padding: 40px 20px;
            color: var(--text-light);
        }

        .professional-empty-icon {
            font-size: 3rem;
            margin-bottom: 15px;
        }

        .professional-empty-title {
            color: var(--text-light);
            margin-bottom: 10px;
            font-size: 1.1rem;
        }

        .professional-empty-description {
            color: var(--text-light);
            margin: 0;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .professional-calendar-layout {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .professional-calendar-consultation-container {
                margin: 10px;
                padding: 15px;
            }

            .professional-calendar-header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .professional-calendar-nav {
                order: -1;
            }

            .professional-consultations-section {
                max-height: none;
            }
        }

        /* ================= CLIENT HISTORY STYLES ================= */
.client-calendar-consultation-container {
    max-width: 1200px;
    margin: 20px auto;
    padding: 20px;
    background: white;
    border-radius: 16px;
    box-shadow: var(--shadow-md);
}

.client-calendar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f1f5f9;
}

.client-calendar-title {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--text-dark);
    margin: 0;
}

.client-calendar-subtitle {
    color: var(--text-light);
    font-size: 0.95rem;
    margin-top: 5px;
}

.client-calendar-nav {
    display: flex;
    align-items: center;
    gap: 15px;
}

.client-nav-btn {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    color: var(--text-dark);
    text-decoration: none;
}

.client-nav-btn:hover {
    background: var(--primary-orange);
    color: white;
    border-color: var(--primary-orange);
    text-decoration: none;
}

.client-today-btn {
    background: var(--primary-orange);
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s ease;
}

.client-today-btn:hover {
    background: var(--secondary-orange);
}

.client-month-year {
    font-size: 1.2rem;
    font-weight: 600;
    color: var(--text-dark);
    margin: 0 20px;
}

.client-calendar-layout {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
    align-items: start;
}

.client-calendar-section,
.client-consultations-section {
    background: #f9fafb;
    border-radius: 12px;
    padding: 20px;
}

.client-consultations-section {
    max-height: 600px;
    overflow-y: auto;
}

.client-section-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.client-calendar-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 1px;
    background: #e2e8f0;
    border-radius: 12px;
    overflow: hidden;
}

.client-calendar-header-cell {
    background: #f8fafc;
    padding: 8px 4px;
    text-align: center;
    font-weight: 600;
    color: var(--text-light);
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.client-calendar-day {
    background: white;
    min-height: 70px;
    padding: 6px;
    position: relative;
    transition: background-color 0.2s ease;
    cursor: pointer;
}

.client-calendar-day:hover {
    background: #f8fafc;
}

.client-calendar-day.other-month {
    background: #f8fafc;
    color: #cbd5e0;
}

.client-calendar-day.today {
    background: #fef3e2;
    border: 2px solid var(--primary-orange);
}

.client-day-number {
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 3px;
    font-size: 0.8rem;
}

.client-other-month .client-day-number {
    color: #cbd5e0;
}

.client-today .client-day-number {
    color: var(--primary-orange);
    font-weight: 700;
}

.client-consultation-event {
    background: var(--primary-orange);
    color: white;
    padding: 2px 4px;
    border-radius: 4px;
    font-size: 0.65rem;
    margin-bottom: 2px;
    cursor: pointer;
    transition: all 0.2s ease;
    line-height: 1.2;
}

.client-consultation-event:hover {
    background: var(--secondary-orange);
    transform: scale(1.05);
}

.client-consultation-event.scheduled {
    background: #10b981;
}

.client-consultation-event.pending {
    background: #f59e0b;
}

.client-consultation-event.completed {
    background: #6b7280;
}

.client-consultation-event.cancelled {
    background: #ef4444;
}

.client-consultation-card {
    background: white;
    padding: 15px;
    border-radius: 10px;
    border-left: 4px solid var(--primary-orange);
    box-shadow: var(--shadow-sm);
    margin-bottom: 12px;
    transition: all 0.2s ease;
}

.client-consultation-card:hover {
}

.client-consultation-header {
    display: flex;
    justify-content: space-between;
    align-items: start;
    margin-bottom: 8px;
}

.client-consultation-professional {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-dark);
    margin: 0;
}

.client-consultation-service {
    font-size: 0.85rem;
    color: var(--text-light);
    margin: 2px 0;
}

.client-consultation-time {
    font-size: 0.85rem;
    color: var(--text-dark);
    font-weight: 500;
}

.client-consultation-actions {
    display: flex;
    flex-direction: column;
    gap: 5px;
    align-items: end;
}

.client-status-badge {
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 0.7rem;
    font-weight: 600;
    color: white;
}

.client-status-scheduled {
    background: #10b981;
}

.client-status-pending {
    background: #f59e0b;
}

.client-status-completed {
    background: #6b7280;
}

.client-status-cancelled {
    background: #ef4444;
}

.client-action-buttons {
    display: flex;
    gap: 5px;
    margin-top: 8px;
    flex-wrap: wrap;
}

.client-action-btn {
    padding: 4px 8px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 0.7rem;
    font-weight: 600;
    transition: all 0.2s ease;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.client-action-btn:hover {
    text-decoration: none;
    transform: translateY(-1px);
}

.client-btn-detail {
    background: #3b82f6;
    color: white;
}

.client-btn-detail:hover {
    background: #2563eb;
    color: white;
}

.client-btn-join {
    background: var(--secondary-orange);
    color: white;
}

.client-btn-join:hover {
    background: #d15e47;
    color: white;
}

.client-btn-reschedule {
    background: #f59e0b;
    color: white;
}

.client-btn-reschedule:hover {
    background: #d97706;
    color: white;
}

.client-btn-cancel {
    background: #ef4444;
    color: white;
}

.client-btn-cancel:hover {
    background: #dc2626;
    color: white;
}

.client-calendar-legend {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-top: 15px;
    flex-wrap: wrap;
}

.client-legend-item {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 0.8rem;
    color: var(--text-light);
}

.client-legend-color {
    width: 12px;
    height: 12px;
    border-radius: 3px;
}

.client-legend-color.scheduled {
    background: #10b981;
}

.client-legend-color.pending {
    background: #f59e0b;
}

.client-legend-color.completed {
    background: #6b7280;
}

.client-legend-color.cancelled {
    background: #ef4444;
}

.client-empty-state {
    text-align: center;
    padding: 40px 20px;
    color: var(--text-light);
}

.client-empty-icon {
    font-size: 3rem;
    margin-bottom: 15px;
}

.client-empty-title {
    color: var(--text-light);
    margin-bottom: 10px;
    font-size: 1.1rem;
}

.client-empty-description {
    color: var(--text-light);
    margin: 0;
    font-size: 0.9rem;
}

.client-new-consultation-btn {
    background: var(--primary-orange);
    color: white;
    padding: 8px 16px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s ease;
    margin-top: 15px;
}

.client-new-consultation-btn:hover {
    background: var(--secondary-orange);
    color: white;
    text-decoration: none;
    transform: translateY(-1px);
}

@media (max-width: 768px) {
    .client-calendar-layout {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .client-calendar-consultation-container {
        margin: 10px;
        padding: 15px;
    }
    
    .client-calendar-header {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }
    
    .client-calendar-nav {
        order: -1;
    }
    
    .client-consultations-section {
        max-height: none;
    }
    
    .client-action-buttons {
        justify-content: center;
    }
    
    .client-consultation-actions {
        align-items: center;
    }
}

        /* Client Detail Page Styles */
        .client-header {
            background: linear-gradient(135deg, #f8f9ff 0%, #fff5f0 100%);
            border-radius: var(--border-radius-lg);
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-sm);
        }

        .client-avatar {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-orange), var(--secondary-orange));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .info-card {
            background: white;
            border-radius: var(--border-radius-lg);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-light);
            transition: all 0.3s ease;
        }

        .info-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .condition-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .condition-item {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: var(--border-radius-lg);
            padding: 1.5rem;
            text-align: center;
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .condition-item.severe {
            border-color: #dc2626;
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
        }

        .condition-item.moderate {
            border-color: #ea580c;
            background: linear-gradient(135deg, #fff7ed 0%, #fed7aa 100%);
        }

        .condition-item.mild {
            border-color: #eab308;
            background: linear-gradient(135deg, #fefce8 0%, #fef3c7 100%);
        }

        .condition-item.normal {
            border-color: #16a34a;
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        }

        .condition-label {
            font-size: 0.9rem;
            color: var(--text-light);
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 500;
        }

        .condition-value {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.25rem;
        }

        .condition-date {
            font-size: 0.8rem;
            color: var(--text-light);
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 1.5rem;
        }

        .section-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-orange), var(--secondary-orange));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }

        .trend-indicator {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            font-size: 0.8rem;
            padding: 0.25rem 0.5rem;
            border-radius: 20px;
            font-weight: 500;
        }

        .trend-up {
            background: #fef2f2;
            color: #dc2626;
        }

        .trend-down {
            background: #f0fdf4;
            color: #16a34a;
        }

        .trend-stable {
            background: #f8fafc;
            color: var(--text-light);
        }

        .notes-section {
            background: linear-gradient(135deg, #fef7ff 0%, #f3e8ff 100%);
            border-left: 4px solid var(--primary-orange);
            border-radius: var(--border-radius-lg);
            padding: 1.5rem;
            margin-top: 1rem;
        }

        .notes-content {
            font-style: italic;
            color: var(--text-dark);
            line-height: 1.7;
        }

        .empty-notes {
            color: var(--text-light);
            text-align: center;
            padding: 2rem;
            font-style: italic;
        }

        .back-btn {
            background: white;
            border: 2px solid var(--border-light);
            border-radius: var(--border-radius-full);
            padding: 0.75rem 1.5rem;
            color: var(--text-dark);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
            margin-bottom: 2rem;
        }

        .back-btn:hover {
            border-color: var(--primary-orange);
            color: var(--primary-orange);
            transform: translateX(-3px);
            text-decoration: none;
        }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .quick-actions {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
            flex-wrap: wrap;
        }

        .contact-info {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            background: #f8fafc;
            border-radius: 8px;
        }

        .contact-icon {
            width: 32px;
            height: 32px;
            background: var(--primary-orange);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .client-header {
                padding: 1.5rem;
            }
            
            .condition-grid {
                grid-template-columns: 1fr;
            }
            
            .stats-row {
                grid-template-columns: 1fr;
            }
            
            .quick-actions {
                flex-direction: column;
            }
        }

        /* Booking Page Styles */
        .booking-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            min-height: 100vh;
        }

        .booking-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .booking-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 10px;
        }

        .booking-subtitle {
            font-size: 1.1rem;
            color: var(--text-light);
        }

        .booking-content {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 30px;
            align-items: start;
        }

        .booking-form-card {
            background: white;
            border-radius: var(--border-radius-lg);
            padding: 30px;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-light);
        }

        .professional-info {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 30px;
            padding: 20px;
            background: linear-gradient(135deg, #fff8f0 0%, #fef3e7 100%);
            border-radius: var(--border-radius-lg);
        }

        .professional-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--primary-orange);
        }

        .professional-details h3 {
            color: var(--text-dark);
            font-size: 1.3rem;
            font-weight: 600;
            margin: 0 0 5px 0;
        }

        .professional-details p {
            color: var(--text-light);
            margin: 0;
            font-size: 0.9rem;
        }

        .form-section {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .form-select, .form-input, .form-textarea {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid var(--border-light);
            border-radius: var(--border-radius-lg);
            font-size: 1rem;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .form-select:focus, .form-input:focus, .form-textarea:focus {
            outline: none;
            border-color: var(--primary-orange);
            box-shadow: 0 0 0 3px rgba(244, 162, 97, 0.1);
        }

        .form-select {
            background: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e") no-repeat right 12px center/16px 16px;
            background-color: white;
            appearance: none;
            cursor: pointer;
        }

        .form-textarea {
            resize: vertical;
            min-height: 100px;
        }

        .service-option {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            margin-bottom: 10px;
            border: 2px solid var(--border-light);
            border-radius: var(--border-radius-lg);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .service-option:hover {
            border-color: var(--primary-orange);
            background: rgba(244, 162, 97, 0.05);
        }

        .service-option.selected {
            border-color: var(--primary-orange);
            background: linear-gradient(135deg, #fff8f0 0%, #fef3e7 100%);
        }

        .service-option input[type="radio"] {
            display: none;
        }

        .service-info h4 {
            color: var(--text-dark);
            font-weight: 600;
            margin: 0 0 5px 0;
        }

        .service-info p {
            color: var(--text-light);
            margin: 0;
            font-size: 0.9rem;
        }

        .service-price {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--primary-orange);
        }

        .datetime-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .booking-summary {
            background: white;
            border-radius: var(--border-radius-lg);
            padding: 25px;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-light);
            position: sticky;
            top: 20px;
            height: fit-content;
        }

        .summary-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 20px;
            text-align: center;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid var(--border-light);
            font-size: 
        }

        .summary-item:last-child {
            border-bottom: none;
            padding-top: 15px;
            margin-top: 10px;
            border-top: 2px solid var(--border-light);
        }

        .summary-label {
            color: var(--text-light);
            font-size: 0.9rem;
        }

        .summary-value {
            color: var(--text-dark);
            font-weight: 400;
            font-size: 10pt;
        }

        .summary-total {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--primary-orange);
        }

        .btn-book {
            width: 100%;
            background: linear-gradient(135deg, var(--primary-orange) 0%, var(--secondary-orange) 100%);
            border: none;
            border-radius: var(--border-radius-full);
            padding: 16px 24px;
            font-size: 1.1rem;
            font-weight: 600;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-md);
            margin-top: 20px;
        }

        .btn-book:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px -5px rgba(244, 162, 97, 0.5);
        }

        .btn-book:active {
            transform: translateY(0);
        }

        .btn-book:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 5px;
        }

        .success-message {
            color: #28a745;
            font-size: 0.875rem;
            margin-top: 5px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .booking-content {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .booking-summary {
                order: -1;
                position: static;
            }
            
            .datetime-section {
                grid-template-columns: 1fr;
            }
            
            .professional-info {
                flex-direction: column;
                text-align: center;
            }
            
            .booking-title {
                font-size: 2rem;
            }
        }

        /* Reschedule Page Styles */
        .reschedule-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }

        .reschedule-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .reschedule-header h2 {
            color: var(--text-dark);
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .reschedule-subtitle {
            color: var(--text-light);
            font-size: 1.1rem;
        }

        /* Progress Steps */
        .progress-steps {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 40px;
            padding: 0 20px;
        }

        .progress-step {
            display: flex;
            align-items: center;
            position: relative;
        }

        .step-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .step-circle.active {
            background: linear-gradient(135deg, var(--primary-orange), var(--secondary-orange));
            color: white;
        }

        .step-circle.completed {
            background: #4CAF50;
            color: white;
        }

        .step-circle.pending {
            background: #f8f9fa;
            border: 2px solid var(--border-light);
            color: var(--text-light);
        }

        .step-label {
            margin-left: 10px;
            font-weight: 500;
            color: var(--text-dark);
            font-size: 0.9rem;
        }

        .step-connector {
            width: 60px;
            height: 2px;
            background: var(--border-light);
            margin: 0 20px;
        }

        .step-connector.completed {
            background: #4CAF50;
        }

        /* Main Card */
        .reschedule-card {
            background: white;
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-md);
            overflow: hidden;
            margin-bottom: 30px;
        }

        .card-section {
            padding: 30px;
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Current Appointment Info */
        .current-appointment {
            background: linear-gradient(135deg, #f8f9ff 0%, #e8f2ff 100%);
            border: 2px solid #e3f2fd;
            border-radius: var(--border-radius-lg);
            padding: 25px;
            margin-bottom: 30px;
        }

        .appointment-detail {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
            font-size: 1rem;
        }

        .appointment-detail:last-child {
            margin-bottom: 0;
        }

        .detail-icon {
            font-size: 1.2rem;
            width: 24px;
            text-align: center;
        }

        .detail-label {
            font-weight: 600;
            color: var(--text-dark);
            min-width: 120px;
        }

        .detail-value {
            color: var(--text-light);
        }


        /* Time Slots Section */
        .time-slots-container {
            background: #f8f9fa;
            border-radius: var(--border-radius-lg);
            padding: 20px;
            max-height: 400px;
            overflow-y: auto;
        }

        .time-period {
            margin-bottom: 25px;
        }

        .period-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid var(--border-light);
        }

        .time-slots-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
            gap: 10px;
        }

        .time-slot {
            padding: 12px 8px;
            text-align: center;
            border: 2px solid var(--border-light);
            border-radius: 8px;
            background: white;
            cursor: pointer;
            transition: all 0.2s ease;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .time-slot:hover {
            border-color: var(--primary-orange);
            background: linear-gradient(135deg, #fff8f3, #fef3ec);
            transform: translateY(-1px);
        }

        .time-slot.selected {
            background: linear-gradient(135deg, var(--primary-orange), var(--secondary-orange));
            border-color: var(--secondary-orange);
            color: white;
            font-weight: 600;
        }

        .time-slot.unavailable {
            background: #f5f5f5;
            color: #999;
            cursor: not-allowed;
            opacity: 0.6;
        }

        /* Confirmation Section */
        .confirmation-card {
            background: linear-gradient(135deg, #f0fdf4 0%, #e8f5e8 100%);
            border: 2px solid #d1fae5;
            border-radius: var(--border-radius-lg);
            padding: 25px;
        }

        .confirmation-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.2rem;
            font-weight: 600;
            color: #059669;
            margin-bottom: 20px;
        }

        .confirmation-details {
            display: grid;
            gap: 15px;
        }

        .confirmation-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(16, 185, 129, 0.2);
        }

        .confirmation-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .confirmation-label {
            font-weight: 600;
            color: var(--text-dark);
        }

        .confirmation-value {
            color: var(--text-light);
            font-weight: 500;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 25px 30px;
            background: #f8f9fa;
            border-top: 1px solid var(--border-light);
            gap: 15px;
        }

        .btn-back {
            background: white;
            border: 2px solid var(--border-light);
            border-radius: var(--border-radius-full);
            padding: 12px 24px;
            font-weight: 600;
            color: var(--text-light);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            border-color: var(--primary-orange);
            color: var(--primary-orange);
            transform: translateY(-1px);
            background: white;
        }

        .btn-confirm {
            background: linear-gradient(135deg, var(--primary-orange) 0%, var(--secondary-orange) 100%);
            border: none;
            border-radius: var(--border-radius-full);
            padding: 12px 32px;
            font-size: 1rem;
            font-weight: 600;
            color: white;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-sm);
        }

        .btn-confirm:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(244, 162, 97, 0.4);
        }

        .btn-confirm:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
            box-shadow: var(--shadow-sm);
        }

        /* Policy Notice */
        .policy-notice {
            background: #fef3c7;
            border: 1px solid #f59e0b;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 20px;
            display: flex;
            align-items: start;
            gap: 8px;
            margin-right: 20px;
            margin-left: 20px;
        }

        .policy-icon {
            font-size: 1.2rem;
            margin-top: 2px;
        }

        .policy-text {
            font-size: 0.9rem;
            color: #856404;
            line-height: 1.5;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .reschedule-container {
                padding: 15px;
            }
            
            .calendar-section {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .progress-steps {
                flex-direction: column;
                gap: 15px;
            }
            
            .step-connector {
                width: 2px;
                height: 30px;
                margin: 10px 0;
            }
            
            .action-buttons {
                flex-direction: column;
                gap: 10px;
            }
            
            .btn-back,
            .btn-confirm {
                width: 100%;
                justify-content: center;
            }
            
            .time-slots-grid {
                grid-template-columns: repeat(auto-fit, minmax(80px, 1fr));
            }
}
        
        @media (max-width: 768px) {
            .consultation-container {
                padding: 15px;
            }
            
            .header-title {
                font-size: 2rem;
            }
            
            .controls-section {
                flex-direction: column;
                align-items: stretch;
            }
            
            .filter-controls {
                justify-content: center;
            }
            
            .card-header {
                flex-direction: column;
                gap: 15px;
            }
            
            .datetime-info {
                flex-direction: column;
                gap: 10px;
                align-items: flex-start;
            }
            
            .actions-section {
                justify-content: center;
            }

            .profile-photo {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #dee2e6;
            background-color: #f8f9fa;
        }
    }
    </style>
</head>
<body class="d-flex flex-column h-100">
    <header>
        <nav class="navbar navbar-expand-md fixed-top custom-navbar">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('images/logo-kamidengar.png') }}" alt="KamiDengar" class="navbar-logo">
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarMain">
                    <ul class="navbar-nav me-auto mb-2 mb-md-0">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('disclaimer') ? 'active' : '' }}" href="{{ route('disclaimer') }}">Pengujian</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('daftarprofesional') ? 'active' : '' }}" href="{{ route('daftarprofesional')}}">Konsultasi</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('tentang-kami') ? 'active' : '' }}" href="#">Tentang Kami</a>
                            </li>
                        @else
                            @php $role = Auth::user()->role; @endphp

                            @if($role === 'client')
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::is('client/pengujian/riwayat') ? 'active' : '' }}" href="{{ route('client.pengujian.riwayat') }}">Pengujian</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::is('client/konsultasi') ? 'active' : '' }}" href="{{ route('client.konsultasi.index') }}">Konsultasi</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Pandora Box</a>
                                </li>
                             @elseif($role === 'professional')
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::is('professional/konsultasi') ? 'active' : '' }}" href="{{ route('professional.konsultasi.index') }}">Jadwal Konsultasi</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::is('professional/klien') ? 'active' : '' }}" href="{{ route('professional.klien.index') }}">Daftar Klien</a>
                                </li> 
                            @endif
                        @endguest
                    </ul>

                    <div class="d-flex align-items-center">
                        @guest
                            <a href="{{ route('login.form') }}" class="btn-login me-3">Login</a>
                            <a href="{{ route('register.form') }}" class="btn btn-cta">Daftar Akun</a>
                        @else
                            
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-cta">
                                    Logout
                                    <span class="d-none d-lg-inline">{{ Auth::user()->username }}</span>
                                </button>
                            </form>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main role="main" class="flex-shrink-0">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <footer class="footer mt-auto py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0 text-muted">&copy; {{ config('app.name') }} {{ date('Y') }}</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0 text-muted">Built with Laravel</p>
                </div>
            </div>
        </div>
    </footer>

        <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEls = document.querySelectorAll('.fullcalendar');
        calendarEls.forEach(el => {
            const events = JSON.parse(el.getAttribute('data-events') || '[]');
            new FullCalendar.Calendar(el, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: ''
                },
                events: events,
                height: 'auto',
                themeSystem: 'standard'
            }).render();
        });
    });
    </script>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>