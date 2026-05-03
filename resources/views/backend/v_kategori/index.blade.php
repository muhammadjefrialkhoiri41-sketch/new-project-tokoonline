@extends('backend.v_layouts.app')

@section('content')

<div class="container-fluid">

    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title">{{ $judul }}</h4>

                <a href="{{ route('backend.kategori.create') }}" class="btn btn-primary">
                    + Tambah Kategori
                </a>
            </div>

            <div class="table-responsive">
                <table id="zero_config" class="table table-striped table-bordered">

                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Foto</th>
                            <th>Nama Kategori</th>
                            <th>Slug</th>
                            <th width="10%">Status</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($index as $item)
                        <tr>

                            {{-- Nomor --}}
                            <td>{{ $loop->iteration }}</td>

                            {{-- Foto --}}
                            <td class="text-center">
                                @if($item->foto)
                                    <img src="{{ asset('storage/img-kategori/'.$item->foto) }}"
                                         width="80"
                                         height="80"
                                         style="object-fit: cover; border-radius: 8px;">
                                @else
                                    <span class="text-muted">Tidak ada foto</span>
                                @endif
                            </td>

                            {{-- Nama --}}
                            <td>{{ $item->nama_kategori }}</td>

                            {{-- Slug --}}
                            <td>{{ $item->slug }}</td>

                            {{-- Status --}}
                            <td class="text-center">
                                @if($item->status == 1)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-danger">Blok</span>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td class="text-center">

                                {{-- Tombol Edit --}}
                                <a href="{{ route('backend.kategori.edit', $item->id) }}"
                                   class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('backend.kategori.destroy', $item->id) }}"
                                      method="POST"
                                      style="display:inline-block;">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-danger btn-sm show_confirm"
                                            data-konf-delete="{{ $item->nama_kategori }}">
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