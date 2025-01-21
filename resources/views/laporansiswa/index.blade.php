@extends('layouts.master')

@section('content')
<section class="content card" style="padding: 10px;">
    <div class="box">
        @if(session('sukses'))
        <div class="alert alert-success alert-dismissible fade show">
            <h5><i class="fas fa-check"></i> Sukses :</h5>
            {{ session('sukses') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        @endif

        @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show">
            <h5><i class="fas fa-info"></i> Informasi :</h5>
            {{ session('warning') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <h5><i class="fas fa-exclamation-triangle"></i> Peringatan :</h5>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        @endif

        <div class="row">
            <div class="col">
                <h4><i class="nav-icon fas fa-child"></i> Laporan Beasiswa Berprestasi</h4>
                <hr>
            </div>
        </div>

        <form action="/laporansiswa/index/cari" method="GET"style=" margin-bottom: 20px;">
            <div class="form-group mb-3">
                <label for="siswa" class="mb-2">Siswa:</label>
                <select id="siswa" name="cari" class="form-control select2 pt-2">
                    <option value="" style=" margin-bottom: 20px;">-- Pilih Siswa --</option>
                    @foreach($siswa as $s)
                    <option value="{{ $s->id }}" style=" margin-bottom: 20px;">{{ $s->nama }} ({{ $s->nis }})</option>
                    @endforeach
                </select>
                
            </div>

            <label for="tahun">Tahun:</label>
            <select id="tahun" name="tahun" class="form-control">
                <option value="">Pilih Tahun</option>
                @foreach($siswa->unique('tahun') as $s)
                <option value="{{ $s->tahun }}">{{ $s->tahun }}</option>
                @endforeach
            </select>
            <br>
            <input type="submit" class="btn btn-primary" value="Tampilkan">
        </form>

        <div class="col">
            <a class="btn btn-primary btn-sm" href="/laporansiswa/export_excel">
                <i class="fas fa-file-excel"></i> Download Excel
            </a>
            <a class="btn btn-success btn-sm" href="index">
                <i class="fas fa-sync-alt"></i> Refresh
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr class="bg-light">
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Tahun Angkatan</th>
                        <th>Beasiswa Kepala</th>
                        <th>Beasiswa Yayasan</th>
                        <th>Beasiswa Orang Tua Asuh</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($datas as $siswa)
                    <tr>
                        <td>{{ $siswa->siswa->nis }}</td>
                        <td>{{ $siswa->siswa->nama }}</td>
                        <td>{{ $siswa->siswa->tahun }}</td>
                        <td>
                            {{ ($siswa->nilai / DB::table('penilaian')->where('id_kriteria', 1)->count() * DB::table('model')->where('id', 1)->value('bobot')) +
                               ($siswa->nilai / DB::table('penilaian')->where('id_kriteria', 1)->count() * DB::table('model')->where('id', 2)->value('bobot')) +
                               ($siswa->nilai / DB::table('penilaian')->where('id_kriteria', 1)->count() * DB::table('model')->where('id', 3)->value('bobot')) }}
                        </td>
                        <td>
                            {{ ($siswa->nilai / DB::table('penilaian')->where('id_kriteria', 1)->count() * DB::table('model')->where('id', 10)->value('bobot')) +
                               ($siswa->nilai / DB::table('penilaian')->where('id_kriteria', 1)->count() * DB::table('model')->where('id', 10)->value('bobot')) +
                               ($siswa->nilai / DB::table('penilaian')->where('id_kriteria', 1)->count() * DB::table('model')->where('id', 10)->value('bobot')) }}
                        </td>
                        <td>
                            {{ ($siswa->nilai / DB::table('penilaian')->where('id_kriteria', 1)->count() * DB::table('model')->where('id', 10)->value('bobot')) +
                               ($siswa->nilai / DB::table('penilaian')->where('id_kriteria', 1)->count() * DB::table('model')->where('id', 10)->value('bobot')) +
                               ($siswa->nilai / DB::table('penilaian')->where('id_kriteria', 1)->count() * DB::table('model')->where('id', 40)->value('bobot')) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "-- Pilih Siswa --",
            allowClear: true
        });

        $('#tahun').on('change', function() {
            const selectedYear = $(this).val();
            $('tbody tr').each(function() {
                const rowYear = $(this).find('td:nth-child(3)').text();
                if (selectedYear === "" || rowYear === selectedYear) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });
</script>

@endsection
