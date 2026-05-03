@extends('frontend.layout')

@section('content')

<!-- SECTION -->
<section class="py-3" style="background-color: #f8f9fa;">
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-lg-10">
                <div class="card shadow border-0 rounded-4 overflow-hidden">
                    <div class="row g-0">

                        <!-- SIDEBAR PRODUK -->
                        <div class="col-md-5 bg-dark text-white p-4 d-flex flex-column justify-content-between">

                            <div>

                                <!-- GAMBAR -->
                                <div class="text-center mb-4">
                                    @if($pesanan->produk && $pesanan->produk->foto)
                                        <img src="{{ asset('storage/img-produk/'.$pesanan->produk->foto) }}"
                                             class="img-fluid rounded shadow"
                                             style="max-height: 250px; object-fit: cover;">
                                    @else
                                        <div class="bg-secondary d-flex align-items-center justify-content-center"
                                             style="height:250px;">
                                            No Image
                                        </div>
                                    @endif
                                </div>

                                <!-- NAMA -->
                                <h4 class="fw-bold text-center mb-3">
                                    {{ $pesanan->produk->nama_produk ?? 'Produk Tidak Ditemukan' }}
                                </h4>

                                <!-- STATUS -->
                                <div class="mb-3 p-3 rounded" style="background: rgba(255,255,255,0.1);">
                                    <small>Status</small>
                                    <div>
                                        @if($pesanan->status == 'menunggu')
                                            <span class="badge bg-warning text-dark">Menunggu</span>
                                        @elseif($pesanan->status == 'diproses')
                                            <span class="badge bg-success">Diproses</span>
                                        @elseif($pesanan->status == 'ditolak')
                                            <span class="badge bg-danger">Ditolak</span>
                                        @else
                                            <span class="badge bg-secondary">Unknown</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- TOTAL -->
                                <div class="mb-3 p-3 rounded" style="background: rgba(255,255,255,0.1);">
                                    <small>Total Harga</small>
                                    <h5 class="fw-bold mb-0">
                                        Rp {{ number_format($pesanan->total_harga,0,',','.') }}
                                    </h5>
                                </div>

                            </div>

                            <!-- ICON -->
                            <div class="text-center mt-3">
                                <i class="bi bi-receipt text-white" style="font-size: 2rem;"></i>
                                <p class="small mt-2">Detail pesanan</p>
                            </div>

                        </div>

                        <!-- FORM -->
                        <div class="col-md-7 bg-white p-5">

                            <h4 class="fw-bold mb-3">Data Pesanan</h4>

                            <!-- ALERT CEK ALAMAT -->
                            <div class="alert alert-warning d-flex justify-content-between align-items-center mb-4">
                                <div>
                                    ⚠️ <strong>Cek ulang alamat Anda</strong> sebelum pesanan diproses.
                                </div>
                                <a href="{{ route('profile') }}" class="btn btn-sm btn-primary">
                                    Klik di sini
                                </a>
                            </div>

                            <form action="{{ route('pesanan.update', $pesanan->id) }}" method="POST">
                                @csrf

                                <!-- JUMLAH -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Jumlah</label>
                                    <input type="text"
                                           class="form-control rounded-3 bg-light"
                                           value="{{ $pesanan->jumlah }}"
                                           readonly>
                                </div>

                                <!-- METODE -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Metode Bayar</label>
                                    <input type="text"
                                           class="form-control rounded-3 bg-light"
                                           value="{{ $pesanan->metode_bayar }}"
                                           readonly>
                                </div>

                                <!-- BUTTON -->
                                @if($pesanan->status == 'menunggu')
                                <div class="d-flex gap-2 mt-3">
                                    <button type="submit" class="btn btn-success w-50">
                                        Simpan
                                    </button>

                                    <a href="{{ route('pesanan.batal', $pesanan->id) }}"
                                       class="btn btn-danger w-50"
                                       onclick="return confirm('Batalkan pesanan ini?')">
                                        Batalkan
                                    </a>
                                </div>
                                @endif

                            </form>

                            <!-- KEMBALI -->
                            <a href="{{ route('cek.pesanan') }}"
                               class="btn btn-secondary w-100 mt-3">
                                Kembali
                            </a>

                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection