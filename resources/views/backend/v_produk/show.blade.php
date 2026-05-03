@extends('backend.v_layouts.app')

@section('content')
<!-- contentAwal -->

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">{{ $judul }}</h4>

                    <div class="row">
                        <!-- KIRI -->
                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Kategori</label>
                                <select class="form-control" disabled>
                                    <option>
                                        {{ $show->kategori->nama_kategori ?? '-' }}
                                    </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Nama Produk</label>
                                <input type="text"
                                    class="form-control"
                                    value="{{ $show->nama_produk }}"
                                    disabled>
                            </div>

                            <div class="form-group">
                                <label>Detail</label>
                                <textarea class="form-control"
                                    rows="5"
                                    disabled>{{ $show->detail }}</textarea>
                            </div>

                            <div class="form-group">
                                <label>Foto Utama</label><br>
                                @if ($show->foto)
                                    <img src="{{ asset('storage/img-produk/' . $show->foto) }}"
                                         class="img-fluid rounded"
                                         alt="Foto Produk">
                                @else
                                    <p class="text-muted">Tidak ada foto</p>
                                @endif
                            </div>

                        </div>

                        <!-- KANAN -->
                        <div class="col-md-6">
                            <label>Foto Tambahan</label>

                            <div class="row">
                                @forelse ($show->fotoProduk as $foto)
                                    <div class="col-md-6 mb-3">
                                        <img src="{{ asset('storage/img-produk/' . $foto->foto) }}"
                                             class="img-fluid rounded"
                                             alt="Foto Tambahan">
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <p class="text-muted">Tidak ada foto tambahan</p>
                                    </div>
                                @endforelse
                            </div>

                        </div>
                    </div>

                </div>

                <div class="border-top">
                    <div class="card-body">
                        <a href="{{ route('backend.produk.index') }}"
                           class="btn btn-secondary">
                            Kembali
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<a href="{{ route('backend.produk.edit', $show->id) }}"
   class="btn btn-primary">
    Edit Produk
</a>

<!-- contentAkhir -->
@endsection
