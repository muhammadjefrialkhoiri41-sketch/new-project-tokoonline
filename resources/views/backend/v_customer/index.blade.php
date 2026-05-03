@extends('backend.v_layouts.app')

@section('content')

<div class="container-fluid mt-4">
    <h4 class="mb-3">Halaman Customer</h4>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="tableCustomer">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($customers as $index => $c)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $c->name }}</td>
                            <td>{{ $c->email }}</td>

                            {{-- STATUS --}}
                            <td>
                                @if($c->status == 'active')
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Blocked</span>
                                @endif
                            </td>

                            {{-- AKSI --}}
                            <td>

                                {{-- DETAIL (opsional, bisa lo sambung nanti) --}}
                                <a href="#" class="btn btn-warning btn-sm">
                                    Detail
                                </a>

                                {{-- UBAH (opsional) --}}
                                <a href="#" class="btn btn-info btn-sm">
                                    Ubah
                                </a>

                                {{-- BLOKIR / AKTIFKAN --}}
                                @if($c->status == 'active')
                                    <a href="{{ route('backend.customer.blokir', $c->id) }}"
                                       class="btn btn-secondary btn-sm">
                                        Blokir
                                    </a>
                                @else
                                    <a href="{{ route('backend.customer.aktifkan', $c->id) }}"
                                       class="btn btn-success btn-sm">
                                        Aktifkan
                                    </a>
                                @endif

                                {{-- HAPUS --}}
                                <form action="{{ route('backend.customer.destroy', $c->id) }}"
                                      method="POST"
                                      style="display:inline;">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin hapus customer?')">
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


@section('scripts')
<script>
    $(document).ready(function() {
        $('#tableCustomer').DataTable();
    });
</script>
@endsection