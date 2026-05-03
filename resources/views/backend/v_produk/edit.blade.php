@extends('backend.v_layouts.app')

@section('content')
<!-- contentAwal -->

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">

                <form action="{{ route('backend.produk.update', $edit->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    <div class="card-body">
                        <h4 class="card-title">{{ $judul }}</h4>

                        <div class="row">
                            {{-- FOTO --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Foto</label>

                                    @if ($edit->foto)
                                        <img src="{{ asset('storage/img-produk/' . $edit->foto) }}"
                                             class="foto-preview mb-2 img-fluid">
                                    @else
                                        <img src="{{ asset('storage/img-produk/img-default.jpg') }}"
                                             class="foto-preview mb-2 img-fluid">
                                    @endif

                                    <input type="file"
                                           name="foto"
                                           class="form-control @error('foto') is-invalid @enderror"
                                           onchange="previewFoto()">

                                    @error('foto')
                                        <div class="invalid-feedback alert-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            {{-- DATA PRODUK --}}
                            <div class="col-md-8">

                                {{-- STATUS --}}
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                                        <option value="">- Pilih Status -</option>
                                        <option value="1" {{ old('status', $edit->status) == 1 ? 'selected' : '' }}>Public</option>
                                        <option value="0" {{ old('status', $edit->status) == 0 ? 'selected' : '' }}>Blok</option>
                                    </select>

                                    @error('status')
                                        <span class="invalid-feedback alert-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- KATEGORI --}}
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <select name="kategori_id" class="form-control @error('kategori_id') is-invalid @enderror">
                                        <option value="">- Pilih Kategori -</option>
                                        @foreach ($kategori as $row)
                                            <option value="{{ $row->id }}"
                                                {{ old('kategori_id', $edit->kategori_id) == $row->id ? 'selected' : '' }}>
                                                {{ $row->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('kategori_id')
                                        <span class="invalid-feedback alert-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- NAMA PRODUK --}}
                                <div class="form-group">
                                    <label>Nama Produk</label>
                                    <input type="text"
                                           name="nama_produk"
                                           value="{{ old('nama_produk', $edit->nama_produk) }}"
                                           class="form-control @error('nama_produk') is-invalid @enderror"
                                           placeholder="Masukkan Nama Produk">

                                    @error('nama_produk')
                                        <span class="invalid-feedback alert-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- DETAIL --}}
                                <div class="form-group">
                                    <label>Detail</label>
                                    <textarea name="detail"
                                              id="ckeditor"
                                              class="form-control @error('detail') is-invalid @enderror"
                                              rows="4">{{ old('detail', $edit->detail) }}</textarea>

                                    @error('detail')
                                        <span class="invalid-feedback alert-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- HARGA --}}
                                <div class="form-group">
                                    <label>Harga</label>
                                    <input type="text"
                                           name="harga"
                                           onkeypress="return hanyaAngka(event)"
                                           value="{{ old('harga', $edit->harga) }}"
                                           class="form-control @error('harga') is-invalid @enderror">

                                    @error('harga')
                                        <span class="invalid-feedback alert-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- BERAT --}}
                                <div class="form-group">
                                    <label>Berat</label>
                                    <input type="text"
                                           name="berat"
                                           onkeypress="return hanyaAngka(event)"
                                           value="{{ old('berat', $edit->berat) }}"
                                           class="form-control @error('berat') is-invalid @enderror">

                                    @error('berat')
                                        <span class="invalid-feedback alert-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- STOK --}}
                                <div class="form-group">
                                    <label>Stok</label>
                                    <input type="text"
                                           name="stok"
                                           onkeypress="return hanyaAngka(event)"
                                           value="{{ old('stok', $edit->stok) }}"
                                           class="form-control @error('stok') is-invalid @enderror">

                                    @error('stok')
                                        <span class="invalid-feedback alert-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- BUTTON --}}
                    <div class="border-top">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary">Perbaharui</button>
                            <a href="{{ route('backend.produk.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<!-- contentAkhir -->

{{-- PREVIEW FOTO --}}
<script>
function previewFoto() {
    const foto = document.querySelector('input[name="foto"]');
    const preview = document.querySelector('.foto-preview');

    const reader = new FileReader();
    reader.readAsDataURL(foto.files[0]);

    reader.onload = function(e) {
        preview.src = e.target.result;
    };
}
</script>

@endsection
