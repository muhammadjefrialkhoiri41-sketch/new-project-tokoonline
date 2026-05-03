@extends('frontend.layout')

@section('content')

<div class="container py-4">
    <h4 class="fw-bold mb-4">Keranjang Saya</h4>

    @if($items->count() > 0)

        @foreach($items as $item)
            <div class="card mb-3 p-3">
                <h5>{{ $item->produk->nama_produk }}</h5>
                <p>Qty: {{ $item->qty }}</p>
                <p>Harga: Rp {{ number_format($item->produk->harga,0,',','.') }}</p>

                <a href="{{ route('keranjang.hapus', $item->id) }}" 
                   class="btn btn-danger btn-sm">
                    Hapus
                </a>
            </div>
        @endforeach

    @else
        <p>Keranjang kosong</p>
    @endif

</div>

@endsection