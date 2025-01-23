@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Laporan Beasiswa - Metode SAW</h2>
    
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form method="GET" action="{{ route('laporan.index') }}" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <label for="tahun" class="form-label">Tahun</label>
                <select name="tahun" id="tahun" class="form-control">
    <option value="">Semua</option>
    @foreach ($tahunOptions as $tahunOption)
        <option value="{{ $tahunOption->tahun }}" {{ request('tahun') == $tahunOption->tahun ? 'selected' : '' }}>
            {{ $tahunOption->tahun }}
        </option>
    @endforeach
</select>

            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>
    
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Nilai SAW</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($laporan as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ number_format($item->nilai_saw, 2) }}</td>
                        <td>{{ $item->status }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Data tidak ditemukan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
