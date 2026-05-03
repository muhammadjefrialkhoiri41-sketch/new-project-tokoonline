@extends('backend.v_layouts.app')

@section('content')

<div class="container-fluid">

    <div class="card">
        <div class="card-body">

            <h4 class="card-title">{{ $judul }}</h4>

            <form action="{{ route('backend.kategori.store') }}" 
                  method="POST" 
                  enctype="multipart/form-data">

                @csrf

                {{-- Nama Kategori --}}
                <div class="form-group mb-3">
                    <label for="nama_kategori">Nama Kategori</label>
                    <input type="text"
                           name="nama_kategori"
                           id="nama_kategori"
                           class="form-control @error('nama_kategori') is-invalid @enderror"
                           value="{{ old('nama_kategori') }}"
                           placeholder="Masukkan nama kategori">

                    @error('nama_kategori')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Foto Kategori --}}
                <div class="form-group mb-3">
                    <label for="foto">Foto Kategori</label>
                    <input type="file"
                           name="foto"
                           id="foto"
                           class="form-control @error('foto') is-invalid @enderror">

                    @error('foto')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Status --}}
                <div class="form-group mb-4">
                    <label for="status">Status</label>
                    <select name="status"
                            id="status"
                            class="form-control @error('status') is-invalid @enderror">

                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>
                            Aktif
                        </option>

                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>
                            Blok
                        </option>
                    </select>

                    @error('status')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Tombol --}}
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>

                    <a href="{{ route('backend.kategori.index') }}" 
                       class="btn btn-secondary">
                        Kembali
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection