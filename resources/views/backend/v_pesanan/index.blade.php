@extends('backend.v_layouts.app')

@section('content')

<div class="container-fluid">

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Data Pesanan</h4>

            <div class="table-responsive">
                <table id="zero_config" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Metode Bayar</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($pesanan as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                {{ $item->produk->nama_produk ?? '-' }}
                            </td>

                            <td>{{ $item->jumlah }}</td>

                            <td>{{ $item->metode_bayar }}</td>

                            <td>
                                @if($item->status == 'menunggu')
                                    <span class="badge badge-warning">Menunggu</span>
                                @elseif($item->status == 'diproses')
                                    <span class="badge badge-success">Diproses</span>
                                @else
                                    <span class="badge badge-danger">Ditolak</span>
                                @endif
                            </td>

                            <td>{{ $item->created_at }}</td>

                            <td>
                                <a href="{{ route('backend.pesanan.proses', $item->id) }}"
                                   class="btn btn-success btn-sm">
                                    Proses
                                </a>

                                <a href="{{ route('backend.pesanan.tolak', $item->id) }}"
                                   class="btn btn-warning btn-sm">
                                    Tolak
                                </a>

                                <form action="{{ route('backend.pesanan.destroy', $item->id) }}"
                                      method="POST"
                                      style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-danger btn-sm">
                                        Hapus
                                    </button>
                                </form>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>

@endsection