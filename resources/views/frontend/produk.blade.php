@extends('frontend.layout')

@section('content')
<!-- JUDUL HALAMAN -->
<div class="container text-center py-3">
    <h5 class="fw-bold text-dark mb-1">{{ $kategori->nama_kategori }}</h5>
    <small class="text-muted">
        Daftar produk {{ $kategori->nama_kategori }}
    </small>
</div>

<!-- PRODUK -->
<section class="py-3">
    <div class="container">
        <div class="row">

            @forelse($kategori->produk as $item)
            <div class="col-md-3 mb-4">

                <div class="card h-100 shadow-sm border-0">

                    <!-- GAMBAR -->
                    <img src="{{ asset('storage/img-produk/'.$item->foto) }}"
                         class="card-img-top"
                         style="height:200px; object-fit:cover;">

                    <!-- BODY -->
                    <div class="card-body text-center">

                        <h6 class="fw-bold mb-2">
                            {{ $item->nama_produk }}
                        </h6>

                        <div class="text-warning mb-2">
                            ★★★★☆
                        </div>

                        <p class="fw-bold mb-1">
                            Rp {{ number_format($item->harga, 0, ',', '.') }}
                        </p>

                        <small class="text-muted">
                            Stok: {{ $item->stok }}
                        </small>

                    </div>

                    <!-- BUTTON -->
                    <div class="card-footer text-center border-0 bg-transparent">

                        <a href="#" class="btn btn-outline-secondary btn-sm">
                            Detail
                        </a>

                        <a href="{{ route('produk.beli', $item->id) }}"
                           class="btn btn-dark btn-sm">
                            Beli
                        </a>

                    </div>

                </div>

            </div>
            @empty

            <div class="col-12 text-center">
                <h5>Produk belum tersedia</h5>
            </div>

            @endforelse

        </div>
    </div>
</section>

@endsection