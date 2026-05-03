@extends('frontend.layout')

@section('content')

<div class="container mt-3" style="max-width: 600px;">

    <h5 class="mb-3 fw-bold">Profil Saya</h5>

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- ERROR --}}
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- VALIDATION ERROR --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('profile.update') }}" method="POST">
                @csrf

                {{-- NAMA --}}
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input 
                        type="text" 
                        name="name" 
                        class="form-control"
                        value="{{ old('name', $customer->name) }}"
                        required
                    >
                </div>

                {{-- EMAIL --}}
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input 
                        type="text" 
                        class="form-control bg-light"
                        value="{{ $customer->email }}"
                        disabled
                    >
                </div>

                {{-- NO HP --}}
                <div class="mb-3">
                    <label class="form-label">No HP</label>
                    <input 
                        type="text" 
                        name="phone" 
                        class="form-control"
                        value="{{ old('phone', $customer->phone) }}"
                        placeholder="08xxxxxxxxxx"
                        required
                    >
                </div>

                {{-- ALAMAT --}}
                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea 
                        name="address" 
                        class="form-control" 
                        rows="3"
                        required
                    >{{ old('address', $customer->address) }}</textarea>
                </div>

                {{-- BUTTON --}}
                <div class="d-grid">
                    <button type="submit" class="btn btn-dark">
                        Simpan Profil
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection