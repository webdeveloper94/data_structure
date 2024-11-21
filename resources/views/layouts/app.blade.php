<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <!-- Bootstrap Icons -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Custom CSS -->
        <style>
            body {
                font-family: 'Poppins', sans-serif;
                background-color: #f8f9fa;
            }
            .card {
                transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
                border: none;
                box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            }
            .card:hover {
                transform: translateY(-5px);
                box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            }
            .stat-icon {
                width: 48px;
                height: 48px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 12px;
            }
            .activity-timeline::before {
                content: '';
                position: absolute;
                left: 20px;
                top: 0;
                bottom: 0;
                width: 2px;
                background: #e9ecef;
                z-index: 0;
            }
            .timeline-icon {
                z-index: 1;
                position: relative;
            }
            .list-group-item {
                border: none;
                padding: 1rem;
                margin-bottom: 0.5rem;
                border-radius: 0.5rem !important;
                background-color: #f8f9fa;
                transition: all 0.2s ease-in-out;
            }
            .list-group-item:hover {
                background-color: #e9ecef;
                transform: translateX(5px);
            }
            .btn {
                padding: 0.6rem 1.2rem;
                font-weight: 500;
                border-radius: 8px;
            }
            .display-5 {
                font-weight: 600;
                color: #2c3e50;
            }
            .progress {
                height: 8px;
                border-radius: 4px;
            }
            .navbar {
                box-shadow: 0 2px 4px rgba(0,0,0,.08);
            }
            .dashboard-header {
                background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
                color: white;
                padding: 2rem 0;
                margin-bottom: 2rem;
                box-shadow: 0 4px 6px rgba(0,0,0,.1);
            }
            .stat-card {
                background: white;
                border-radius: 15px;
                overflow: hidden;
            }
            .stat-card .card-body {
                padding: 1.5rem;
            }
            .recent-activity-card {
                background: white;
                border-radius: 15px;
                padding: 1.5rem;
            }
            .quick-actions-card {
                background: white;
                border-radius: 15px;
                padding: 1.5rem;
            }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-light">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                @yield('content')
            </main>
        </div>
    </body>
</html>
