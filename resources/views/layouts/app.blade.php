<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inventaris Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Pagination ukuran kecil */
        .pagination .page-link {
            color: #198754;            /* teks hijau */
            background-color: #fff;    /* background putih */
            border: 1px solid #198754; /* border hijau */
            padding: 0.25rem 0.5rem;   /* perkecil padding */
            font-size: 0.85rem;        /* font lebih kecil */
            border-radius: 5px;
        }

        /* Halaman aktif */
        .pagination .active .page-link {
            background-color: #198754;
            border-color: #198754;
            color: #fff;
        }

        /* Hover */
        .pagination .page-link:hover {
            background-color: #198754;
            color: #fff;
            border-color: #198754;
        }


    </style>
</head>
<body>
    @include('layouts.header')

    <main class="py-4">
        @yield('content')
    </main>

    @yield('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
    </script>

</body>
{{-- @include('layouts.footer') --}}
</html>
