@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Detail Barang</h2>
    <div class="card mt-3">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Nomor Labelisasi</th>
                    <td>{{ $inventaris->nomor_lebelisasi }}</td>
                </tr>
                <tr>
                    <th>Kode Barang</th>
                    <td>{{ $inventaris->kode_barang }}</td>
                </tr>
                <tr>
                    <th>Jenis / Nama Barang</th>
                    <td>{{ $inventaris->nama_barang }}</td>
                </tr>
                <tr>
                    <th>Nomor Register</th>
                    <td>{{ $inventaris->nomor_register ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Merk / Type</th>
                    <td>{{ $inventaris->merk_type ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Ukuran / CC</th>
                    <td>{{ $inventaris->ukuran_cc ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Bahan</th>
                    <td>{{ $inventaris->bahan ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Tahun Pembelian</th>
                    <td>{{ $inventaris->tahun_pembelian ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Nomor Pabrik</th>
                    <td>{{ $inventaris->nomor_pabrik ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Nomor Rangka</th>
                    <td>{{ $inventaris->nomor_rangka ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Nomor Mesin</th>
                    <td>{{ $inventaris->nomor_mesin ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Nomor Polisi</th>
                    <td>{{ $inventaris->nomor_polisi ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Nomor BPKB</th>
                    <td>{{ $inventaris->nomor_bpkb ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Asal Usul</th>
                    <td>{{ $inventaris->asal_usul ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Harga (ribuan Rp)</th>
                    <td>{{ number_format($inventaris->harga ?? 0, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Kondisi SIMDA</th>
                    <td>{{ $inventaris->kondisi_simda ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Kondisi Saat Ini</th>
                    <td>{{ $inventaris->kondisi_saat_ini ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Keberadaan</th>
                    <td>{{ $inventaris->keberadaan ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Keterangan</th>
                    <td>{{ $inventaris->keterangan ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Foto Lokasi</th>
                   <td>
                        @if($inventaris->foto_lokasi)
                            <img src="{{ asset('storage/' . $inventaris->foto_lokasi) }}"
                                alt="Foto Lokasi"
                                class="img-thumbnail mb-2 preview-img"
                                style="max-height: 100px; cursor: pointer;"
                                data-bs-toggle="modal"
                                data-bs-target="#previewModal"
                                data-src="{{ asset('storage/' . $inventaris->foto_lokasi) }}">
                        @else
                            <span class="text-muted">Tidak ada foto</span>
                        @endif
                    </td>

                </tr>
                <tr>
                    <th>Barcode</th>
                    <td>
                        @if($inventaris->barcode_path)
                            <img src="{{ asset($inventaris->barcode_path) }}" width="200">
                        @else
                            <span class="text-muted">Belum ada barcode</span>
                        @endif
                    </td>
                </tr>
            </table>

            <!-- Modal Preview Foto -->
            <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content bg-transparent border-0">
                <div class="modal-body p-0 text-center">
                    <img id="modalImage" src="" class="img-fluid rounded" alt="Preview Foto">
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
                </div>
            </div>
            </div>


            <a href="{{ route('inventaris.index') }}" class="btn btn-secondary mt-2">← Kembali</a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const previewImages = document.querySelectorAll('.preview-img');
    const modalImage = document.getElementById('modalImage');

    previewImages.forEach(img => {
        img.addEventListener('click', function() {
            const src = this.getAttribute('data-src');
            modalImage.src = src;
        });
    });
});
</script>

@endsection
