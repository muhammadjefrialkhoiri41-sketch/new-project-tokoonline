@extends('frontend.layout')

@section('content')

<!-- LIST PESANAN -->
<section class="py-3">
    <div class="container">
        <div class="row">

            @forelse($pesanan as $item)
            <div class="col-md-6 mb-4">

                <div class="card shadow-sm border-0 h-100">
                    <div class="row g-0">

                        <!-- GAMBAR -->
                        <div class="col-md-4">
                            <img src="{{ asset('storage/img-produk/'.$item->produk->foto) }}"
                                 class="img-fluid h-100"
                                 style="object-fit: cover;">
                        </div>

                        <!-- INFO -->
                        <div class="col-md-8">
                            <div class="card-body">

                                <h6 class="fw-bold mb-2">
                                    {{ $item->produk->nama_produk }}
                                </h6>

                                <p class="mb-1">
                                    <strong>Jumlah:</strong> {{ $item->jumlah }}
                                </p>

                                <p class="mb-1">
                                    <strong>Total:</strong>
                                    Rp {{ number_format($item->total_harga,0,',','.') }}
                                </p>

                                <!-- STATUS -->
                                <div class="mb-2">
                                    @if($item->status == 'menunggu')
                                        <span class="badge bg-warning text-dark">Menunggu</span>
                                    @elseif($item->status == 'diproses')
                                        <span class="badge bg-success">Diproses</span>
                                    @elseif($item->status == 'ditolak')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </div>

                                <!-- BUTTON -->
                                <a href="{{ route('pesanan.detail', $item->id) }}"
                                   class="btn btn-secondary btn-sm text-white">
                                    Detail
                                </a>

                            </div>
                        </div>

                    </div>
                </div>

            </div>
            @empty

            <div class="col-12 text-center">
                <h5>Belum ada pesanan</h5>
            </div>

            @endforelse

        </div>
    </div>
</section>


@endsection