@extends('frontend.layout')

@section('content')

<div class="container py-4">

    <h4 class="fw-bold mb-4">
        Checkout Pesanan
    </h4>

    <div class="card p-4">

        <form action="{{ route('checkout') }}" method="POST">
            @csrf

            {{-- METODE PEMBAYARAN --}}
            <div class="mb-3">

                <label class="form-label">
                    Metode Pembayaran
                </label>

                <select name="metode_bayar"
                        class="form-control"
                        required>

                    <option value="">
                        -- Pilih Metode Pembayaran --
                    </option>

                    <option value="COD">
                        COD
                    </option>

                    <option value="Transfer Bank">
                        Transfer Bank
                    </option>

                </select>

            </div>

            {{-- TOMBOL PESAN --}}
            <button type="submit"
                    class="btn btn-success">

                Pesan Sekarang

            </button>

            <a href="{{ route('keranjang.index') }}"
               class="btn btn-secondary">

                Kembali

            </a>

        </form>

    </div>

</div>

@endsection