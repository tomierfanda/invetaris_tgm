@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">✏️ Edit Data Inventaris</h4>
            <a href="{{ route('inventaris.index') }}" class="btn btn-sm btn-light">← Kembali</a>
        </div>

        <div class="card-body bg-light">
            <form action="{{ route('inventaris.update', $inventaris->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nomor Labelisasi</label>
                        <input type="text" name="nomor_lebelisasi" value="{{ $inventaris->nomor_lebelisasi }}" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Kode Barang</label>
                        <input type="text" name="kode_barang" value="{{ $inventaris->kode_barang }}" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nama Barang</label>
                        <input type="text" name="nama_barang" value="{{ $inventaris->nama_barang }}" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nomor Register</label>
                        <input type="text" name="nomor_register" value="{{ $inventaris->nomor_register }}" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Merk / Type</label>
                        <input type="text" name="merk_type" value="{{ $inventaris->merk_type }}" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Ukuran / CC</label>
                        <input type="text" name="ukuran_cc" value="{{ $inventaris->ukuran_cc }}" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Bahan</label>
                        <input type="text" name="bahan" value="{{ $inventaris->bahan }}" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Tahun Pembelian</label>
                        <input type="number" name="tahun_pembelian" value="{{ $inventaris->tahun_pembelian }}" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nomor Pabrik</label>
                        <input type="text" name="nomor_pabrik" value="{{ $inventaris->nomor_pabrik }}" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nomor Rangka</label>
                        <input type="text" name="nomor_rangka" value="{{ $inventaris->nomor_rangka }}" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nomor Mesin</label>
                        <input type="text" name="nomor_mesin" value="{{ $inventaris->nomor_mesin }}" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nomor Polisi</label>
                        <input type="text" name="nomor_polisi" value="{{ $inventaris->nomor_polisi }}" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nomor BPKB</label>
                        <input type="text" name="nomor_bpkb" value="{{ $inventaris->nomor_bpkb }}" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Asal Usul</label>
                        <input type="text" name="asal_usul" value="{{ $inventaris->asal_usul }}" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Harga</label>
                        <input type="text" name="harga" value="{{ $inventaris->harga }}" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Kondisi SIMDA</label>
                        <input type="text" name="kondisi_simda" value="{{ $inventaris->kondisi_simda }}" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Kondisi Saat Ini</label>
                        <input type="text" name="kondisi_saat_ini" value="{{ $inventaris->kondisi_saat_ini }}" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Keberadaan</label>
                        <input type="text" name="keberadaan" value="{{ $inventaris->keberadaan }}" class="form-control">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" rows="3" class="form-control">{{ $inventaris->keterangan }}</textarea>
                    </div>

                    {{-- Foto Lokasi --}}
                    <div class="col-12">
                        <label class="form-label">Foto Lokasi</label><br>

                        @if($inventaris->foto_lokasi)
                            <div class="mb-2">
                                <p class="text-muted small mb-1">Foto saat ini:</p>
                                <img src="{{ asset('storage/' . $inventaris->foto_lokasi) }}" alt="Foto Lokasi" class="img-thumbnail mb-2" style="max-height: 200px;">
                            </div>
                        @endif

                        <input type="file" name="foto_lokasi" class="form-control" accept="image/*" onchange="previewImage(event)">
                        <div class="mt-2">
                            <p class="text-muted small mb-1">Preview foto baru:</p>
                            <img id="preview" class="img-thumbnail d-none" style="max-height: 200px;">
                        </div>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-success px-4">💾 Update</button>
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
