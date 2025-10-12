<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cetak Barcode - {{ $inventaris->nama_barang }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print { display: none; }
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }

        .card-print {
            max-width: 500px;
            margin: 40px auto;
            padding: 20px;
            border-radius: 15px;
            border: 1px solid #dee2e6;
            background-color: #ffffff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .header-print {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header-print img {
            max-height: 60px;
        }

        .header-print .header-text {
            text-align: right;
            font-size: 0.9rem;
        }

        .barcode-box {
            text-align: center;
            margin-top: 10px;
        }

        .barcode-box img {
            max-height: 150px;
            margin-top: 10px;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            padding: 2px 0;
            font-size: 0.95rem;
        }

        .info-item span:first-child {
            font-weight: 600;
        }

        .btn-print {
            text-align: center;
            margin-top: 20px;
        }

        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 8px; /* spasi antar baris */
        }

        .label {
            width: 120px;
            font-weight: 600;
        }

        .value {
            flex: 1;
            padding-left: 10px; /* spasi antar label & value */
        }

    </style>
</head>
<body>
<div class="card-print">
    <!-- Header logo + instansi -->
    <div class="header-print">
        <img src="{{ asset('assets/images/damkar.png') }}" alt="Logo Damkar">
        <div class="header-text-center">
            <strong>Dinas Pemadam Kebakaran dan Penyelamatan</strong><br>
             Kabupaten Tanggamus <br>
        </div>
    </div>

    <!-- Nama & Type -->
    <div class="info-item">
        <span class="label">Nama Barang :</span>
        <span class="value">{{ $inventaris->nama_barang }}</span>
    </div>
    <div class="info-item">
        <span class="label">Type Barang &nbsp;:</span>
        <span class="value">{{ $inventaris->merk_type ?? '-' }}</span>
    </div>
    <div class="info-item">
        <span class="label">Nomor Label &nbsp;:</span>
        <span class="value">{{ $inventaris->nomor_lebelisasi }}</span>
    </div>

    <!-- Barcode -->
    <div class="barcode-box">
        @if ($inventaris->barcode_path)
            <img src="{{ asset($inventaris->barcode_path) }}" alt="Barcode">
        @endif
    </div>

    <!-- Print / Kembali -->
    <div class="btn-print no-print">
        <button onclick="window.print()" class="btn btn-success">🖨️ Cetak</button>
        <a href="{{ route('inventaris.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
</body>
</html>
