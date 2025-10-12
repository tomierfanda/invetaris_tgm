@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">➕ Tambah Data Inventaris</h4>
            <a href="{{ route('inventaris.index') }}" class="btn btn-sm btn-light">← Kembali</a>
        </div>

        <div class="card-body bg-light">
            <form action="{{ route('inventaris.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nomor Labelisasi</label>
                        <input type="text" name="nomor_lebelisasi" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Kode Barang</label>
                        <input type="text" name="kode_barang" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nomor Register</label>
                        <input type="text" name="nomor_register" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Merk / Type</label>
                        <input type="text" name="merk_type" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Ukuran / CC</label>
                        <input type="text" name="ukuran_cc" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Bahan</label>
                        <input type="text" name="bahan" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Tahun Pembelian</label>
                        <input type="number" name="tahun_pembelian" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nomor Pabrik</label>
                        <input type="text" name="nomor_pabrik" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nomor Rangka</label>
                        <input type="text" name="nomor_rangka" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nomor Mesin</label>
                        <input type="text" name="nomor_mesin" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nomor Polisi</label>
                        <input type="text" name="nomor_polisi" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nomor BPKB</label>
                        <input type="text" name="nomor_bpkb" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Asal Usul</label>
                        <input type="text" name="asal_usul" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Harga</label>
                        <input type="text" name="harga" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Kondisi SIMDA</label>
                        <input type="text" name="kondisi_simda" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Kondisi Saat Ini</label>
                        <input type="text" name="kondisi_saat_ini" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Keberadaan</label>
                        <input type="text" name="keberadaan" class="form-control">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" rows="3" class="form-control"></textarea>
                    </div>

                    {{-- Foto Lokasi --}}
                    <div class="col-12">
                        <label class="form-label">Foto Lokasi</label>
                        <input type="file" name="foto_lokasi" class="form-control" accept="image/*" onchange="previewImage(event)">
                        <div class="mt-2">
                            <p class="text-muted small mb-1">Preview foto:</p>
                            <img id="preview" class="img-thumbnail d-none" style="max-height: 200px;">
                        </div>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-success px-4">💾 Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewImage(event) {
    const preview = document.getElementById('preview');
    const file = event.target.files[0];
    if (file) {
        preview.src = URL.createObjectURL(file);
        preview.classList.remove('d-none');
    }
}
</script>
@endsection
