@extends('frontend.layout')

@section('content')

<section class="py-3">
    <div class="container">
        <div class="row">

            @forelse ($kategori as $item)
                <div class="col-md-3 mb-4">
                    <div class="card h-100 shadow-sm border-0">

                        @if($item->foto)
                            <img src="{{ asset('storage/img-kategori/'.$item->foto) }}"
                                 class="card-img-top"
                                 style="height:180px; object-fit:cover;">
                        @else
                            <img src="https://via.placeholder.com/300x200?text=No+Image"
                                 class="card-img-top"
                                 style="height:180px; object-fit:cover;">
                        @endif

                        <div class="card-body text-center">
                            <h6 class="fw-bold mb-2">
                                {{ $item->nama_kategori }}
                            </h6>
                        </div>

                        <div class="card-footer text-center border-0 bg-transparent">
                            <a href="{{ route('kategori.produk', $item->id) }}"
                               class="btn btn-dark btn-sm w-100">
                                Lihat Produk
                            </a>
                        </div>

                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <h5>Belum ada kategori tersedia</h5>
                </div>
            @endforelse

        </div>
    </div>
</section>

@endsection