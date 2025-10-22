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
            max-width: 600px;
            margin: 40px auto;
            padding: 20px 30px;
            border-radius: 15px;
            border: 1px solid #dee2e6;
            background-color: #ffffff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .header-print {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 25px;
        }

        .header-print img {
            max-height: 60px;
        }

        .header-text-center {
            flex: 1;
            text-align: center;
            font-size: 0.9rem;
            line-height: 1.4;
        }

        .content-box {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .info-section {
            flex: 1;
        }

        .barcode-box {
            text-align: center;
            width: 150px;
        }

        .barcode-box img {
            max-width: 100%;
            max-height: 150px;
            margin-top: 10px;
        }

        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .label {
            width: 120px;
            font-weight: 600;
        }

        .value {
            flex: 1;
            padding-left: 10px;
        }

        .btn-print {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="card-print">
    <!-- Header -->
    <div class="header-print">
        <img src="{{ asset('assets/images/damkar.png') }}" alt="Logo Damkar">
        <div class="header-text-center">
            <strong>Dinas Pemadam Kebakaran dan Penyelamatan</strong><br>
            Kabupaten Tanggamus
        </div>
    </div>

    <!-- Konten: Kiri info, kanan barcode -->
    <div class="content-box">
        <div class="info-section">
            <div class="info-item">
                <span class="label">Nama Barang :</span>
                <span class="value">{{ $inventaris->nama_barang }}</span>
            </div>
            <div class="info-item">
                <span class="label">Type Barang :</span>
                <span class="value">{{ $inventaris->merk_type ?? '-' }}</span>
            </div>
            <div class="info-item">
                <span class="label">Nomor Label :</span>
                <span class="value">{{ $inventaris->nomor_lebelisasi }}</span>
            </div>
        </div>

        @if ($inventaris->barcode_path)
        <div class="barcode-box">
            <img src="{{ asset($inventaris->barcode_path) }}" alt="Barcode" width="100px">
        </div>
        @endif
    </div>

    <!-- Tombol -->
    <div class="btn-print no-print">
        <button onclick="window.print()" class="btn btn-success">🖨️ Cetak</button>
        <a href="{{ route('inventaris.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
</body>
</html>
