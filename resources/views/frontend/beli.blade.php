@extends('frontend.layout')

@section('content')

<div class="container text-center py-3">
    <h5 class="fw-bold text-dark mb-1">Detail Pembelian Produk</h5>
    <small class="text-muted">Silakan lengkapi data pesanan Anda</small>
</div>

<section class="py-5" style="background-color: #f8f9fa;">
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-lg-10">
                <div class="card shadow border-0 rounded-4 overflow-hidden">
                    <div class="row g-0">

                        <!-- SIDEBAR PRODUK -->
                        <div class="col-md-5 bg-dark text-white p-4 d-flex flex-column justify-content-between">
                            <div>
                                <div class="text-center mb-4">
                                    <img src="{{ asset('storage/img-produk/'.$produk->foto) }}"
                                         class="img-fluid rounded shadow"
                                         style="max-height: 280px; object-fit: cover;">
                                </div>

                                <h3 class="fw-bold text-center mb-3">
                                    {{ $produk->nama_produk }}
                                </h3>

                                <div class="mb-3 p-3 rounded" style="background: rgba(255,255,255,0.1);">
                                    <small>Harga Satuan</small>
                                    <h5 class="fw-bold mb-0">
                                        Rp {{ number_format($produk->harga,0,',','.') }}
                                    </h5>
                                </div>

                                <div class="mb-3 p-3 rounded" style="background: rgba(255,255,255,0.1);">
                                    <small>Stok Tersedia</small>
                                    <h5 class="fw-bold mb-0">
                                        {{ $produk->stok }}
                                    </h5>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <div style="width:70px;height:70px;margin:auto;border-radius:50%;background:rgba(255,255,255,0.15);display:flex;align-items:center;justify-content:center;">
                                    <i class="bi bi-cart-fill text-white" style="font-size: 2rem;"></i>
                                </div>
                                <p class="mt-2 mb-0">Siap untuk dipesan</p>
                            </div>
                        </div>

                        <!-- FORM AREA -->
                        <div class="col-md-7 bg-white p-5">

                            <h3 class="fw-bold mb-4 text-dark">
                                Form Pembelian
                            </h3>

                            {{-- VALIDASI PROFIL --}}
                            @if(!auth('customer')->user()->phone || !auth('customer')->user()->address)
                                <div class="alert alert-danger">
                                    Lengkapi profil dulu sebelum checkout!
                                    <a href="{{ route('profile') }}">Klik disini</a>
                                </div>
                            @endif

                            <!-- INPUT (TIDAK DALAM FORM) -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Jumlah Beli</label>
                                <input type="number"
                                       id="jumlah"
                                       class="form-control rounded-3"
                                       min="1"
                                       max="{{ $produk->stok }}"
                                       value="1">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Total Harga</label>
                                <input type="text"
                                       id="total_harga"
                                       class="form-control rounded-3 bg-light"
                                       value="Rp {{ number_format($produk->harga,0,',','.') }}"
                                       readonly>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Metode Pembayaran</label>
                                <select id="metode_bayar" class="form-control rounded-3">
                                    <option value="">-- Pilih Metode Pembayaran --</option>
                                    <option value="COD">COD</option>
                                    <option value="Transfer Bank">Transfer Bank</option>
                                </select>
                            </div>

                            <!--  TOMBOL (2 FORM TERPISAH) -->
                            <div class="d-grid gap-2">

                                <!--  KERANJANG -->
                                <form action="{{ route('keranjang.tambah', $produk->id) }}" method="GET">
                                    <input type="hidden" name="qty" id="qty_input">
                                    <button type="submit" class="btn btn-warning py-2 rounded-3 fw-bold">
                                        + Masukkan ke Keranjang
                                    </button>
                                </form>

                                <!--  PESAN -->
                                <form action="{{ route('pesanan.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                                    <input type="hidden" name="jumlah" id="jumlah_hidden">
                                    <input type="hidden" name="metode_bayar" id="metode_hidden">

                                    <button type="submit" class="btn btn-dark py-2 rounded-3 fw-bold">
                                        Pesan Sekarang
                                    </button>
                                </form>

                            </div>

                            <div class="text-center mt-3">
                                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary w-100 rounded-3">
                                    Kembali
                                </a>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<script>
    const harga = {{ $produk->harga }};
    const jumlahInput = document.getElementById('jumlah');
    const totalHargaInput = document.getElementById('total_harga');

    const qtyInput = document.getElementById('qty_input');
    const jumlahHidden = document.getElementById('jumlah_hidden');
    const metodeHidden = document.getElementById('metode_hidden');

    jumlahInput.addEventListener('input', function() {
        let jumlah = parseInt(this.value) || 1;
        let total = harga * jumlah;

        totalHargaInput.value = 'Rp ' + total.toLocaleString('id-ID');

        qtyInput.value = jumlah;
        jumlahHidden.value = jumlah;
    });

    document.getElementById('metode_bayar').addEventListener('change', function() {
        metodeHidden.value = this.value;
    });

    // set default
    qtyInput.value = jumlahInput.value;
    jumlahHidden.value = jumlahInput.value;
</script>

@endsection