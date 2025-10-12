@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">📦 Data Inventaris</h4>
            <a href="{{ route('inventaris.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle me-1"></i> Tambah Barang
            </a>
        </div>

        <div class="card-body bg-light">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form id="searchForm" method="GET" action="{{ route('inventaris.search') }}" class="mb-4">
                <div class="input-group">
                    <input type="text" id="searchInput" name="q" class="form-control" placeholder="🔍 Cari nama / kode / nomor label...">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                    <button type="button" id="scanBtn" class="btn btn-success" title="Scan Barcode">
                        <i class="bi bi-upc-scan"></i>
                    </button>
                </div>
            </form>

            <div id="reader" style="width: 300px; margin: 0 auto 20px auto; display: none; border: 2px dashed #198754; border-radius: 10px;"></div>

            <form action="{{ route('inventaris.export') }}" method="POST" class="d-inline">
                @csrf
                <input type="hidden" name="q" value="{{ request('q') }}"> {{-- optional kalau mau bawa keyword search --}}
                <button type="submit" class="btn btn-success mb-3">
                    <i class="bi bi-file-earmark-spreadsheet me-1"></i> Export Excel
                </button>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nomor Label</th>
                            <th>Nama Barang</th>
                            <th>Kode Barang</th>
                            <th>Tahun</th>
                            {{-- <th>Barcode</th> --}}
                            <th>📸 Foto Lokasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($inventaris as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nomor_lebelisasi }}</td>
                            <td>{{ $item->nama_barang }}</td>
                            <td>{{ $item->kode_barang }}</td>
                            <td>{{ $item->tahun_pembelian }}</td>
                            {{-- <td>
                                @if ($item->barcode_path)
                                    <img src="{{ asset($item->barcode_path) }}" height="40">
                                @else
                                    <small class="text-muted">Tidak ada</small>
                                @endif
                            </td> --}}
                            <td>
                                @if ($item->foto_lokasi)
                                    <img src="{{ asset('storage/' . $item->foto_lokasi) }}" height="60" class="rounded shadow-sm">
                                @else
                                    <small class="text-muted">Belum ada foto</small>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('inventaris.show', $item->id) }}"
                                       class="btn btn-sm btn-outline-info"
                                       data-bs-toggle="tooltip"
                                       title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('inventaris.edit', $item->id) }}"
                                       class="btn btn-sm btn-outline-warning"
                                       data-bs-toggle="tooltip"
                                       title="Edit Data">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="{{ route('inventaris.printBarcode', $item->id) }}"
                                       {{-- target="_blank" --}}
                                       class="btn btn-sm btn-outline-success"
                                       data-bs-toggle="tooltip"
                                       title="Cetak Barcode">
                                        <i class="bi bi-upc-scan"></i>
                                    </a>
                                    <form action="{{ route('inventaris.destroy', $item->id) }}"
                                          method="POST"
                                          style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Hapus data ini?')"
                                                data-bs-toggle="tooltip"
                                                title="Hapus Data">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-3">
                                <i class="bi bi-inbox me-1"></i> Belum ada data inventaris
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                 <!-- PAGINASI -->
                <div class="d-flex justify-content-end mt-3">
                    {{ $inventaris->links('pagination::bootstrap-5') }}
                </div>

            </div>
        </div>
    </div>
</div>

{{-- ✅ Script Scan Barcode --}}
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    const scanBtn = document.getElementById('scanBtn');
    const reader = document.getElementById('reader');
    const searchInput = document.getElementById('searchInput');
    const searchForm = document.getElementById('searchForm');
    let html5QrCode = null;

    scanBtn.addEventListener('click', async () => {
        if (reader.style.display === 'none' || reader.style.display === '') {
            reader.style.display = 'block';
            scanBtn.classList.add("active");
            scanBtn.innerHTML = '<i class="bi bi-camera-video-off"></i>';

            if (!html5QrCode) {
                html5QrCode = new Html5Qrcode("reader");
            }

            try {
                await html5QrCode.start(
                    { facingMode: "environment" },
                    { fps: 10, qrbox: { width: 250, height: 250 } },
                    qrCodeMessage => {
                        searchInput.value = qrCodeMessage;
                        html5QrCode.stop().then(() => {
                            reader.style.display = 'none';
                            scanBtn.classList.remove("active");
                            scanBtn.innerHTML = '<i class="bi bi-upc-scan"></i>';
                            searchForm.submit();
                        });
                    },
                    errorMessage => {}
                );
            } catch (err) {
                alert("Tidak bisa mengakses kamera: " + err);
            }
        } else {
            html5QrCode?.stop().then(() => {
                reader.style.display = 'none';
                scanBtn.classList.remove("active");
                scanBtn.innerHTML = '<i class="bi bi-upc-scan"></i>';
            });
        }
    });
});
</script>
@endsection
