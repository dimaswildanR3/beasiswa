@extends('layouts.master')

@section('content')
<section class="content card p-3">
    <div class="box">
        @if(session('sukses'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <h5><i class="fas fa-check"></i> Sukses :</h5>
            {{ session('sukses') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <h5><i class="fas fa-info"></i> Informasi :</h5>
            {{ session('warning') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <h5><i class="fas fa-exclamation-triangle"></i> Peringatan :</h5>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        <form action="{{ route('nilaipelajaran.store') }}" method="POST" id="orangtuaForm">
            @csrf
            <h4><i class="fas fa-book nav-icon"></i> Tambah Biodata Nilai Pelajaran</h4>
            <hr>

            <div class="row">
                <div class="col-md-6">
                    <label for="tahun">Tahun Angkatan</label>
                    <select name="tahun" id="tahun" class="form-control" required>
                        <option value="">-- Pilih Tahun Angkatan --</option>
                        @foreach($tahun as $t)
                            <option value="{{ $t->tahun }}">{{ $t->tahun }}</option>
                        @endforeach
                    </select>

                    <label for="kelas">Kelas</label>
                    <select name="kelas" id="kelas" class="form-control" required>
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>

                    <label for="tahun_pelajaran">Tahun Pelajaran</label>
                    <select name="tahun_pelajaran" id="tahun_pelajaran" class="form-control">
                        <option value="">Pilih Tahun Pelajaran</option>
                        @foreach ($tahunajaran as $tp)
                            <option value="{{ $tp }}">{{ $tp }}</option>
                        @endforeach
                    </select>

                    <button type="button" id="tampilkan-siswa" class="btn btn-primary mt-3">Tampilkan Siswa</button>
                </div>
            </div>

            <hr>
            <h5>Daftar Siswa</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>NIS</th>
                        <th>Nama Siswa</th>
                        <th>Beasiswa</th>
                        <th>Tahun Angkatan</th>
                        <th>Tahun Pelajaran</th>
                        <th>Kelas</th>
                        
                        @php
                        $userRole = Auth::user()->role; // Ambil role user yang login
                    @endphp
                    
                    @foreach($kriteria as $k)
                        @if(
                            ($userRole == 'guru_bahasa_arab' && $k->id == 1) ||
                            ($userRole == 'gurualquranhadist' && $k->id == 2) ||
                            ($userRole == 'gurufiqihaqidah' && $k->id == 3) ||
                            (!in_array($userRole, ['guru_bahasa_arab', 'gurualquranhadist', 'gurufiqihaqidah']))
                        )
                            <th>{{ $k->nama }}</th>
                        @endif
                    @endforeach
                    
                    </tr>
                </thead>
                <tbody id="siswa-list">
                    <!-- Data Siswa akan muncul di sini melalui AJAX -->
                </tbody>
            </table>

            <hr>
            <button type="submit" class="btn btn-success" id="saveButton" disabled><i class="fas fa-save"></i> Simpan</button>
            <a href="{{ route('nilaipelajaran.index') }}" class="btn btn-danger"><i class="fas fa-undo"></i> Batal</a>
        </form>
    </div>
</section>

<script>
    document.getElementById('tampilkan-siswa').addEventListener('click', function () {
        var tahun = document.getElementById('tahun').value;
        var kelas = document.getElementById('kelas').value;
        var tahunpelajaran = document.getElementById('tahun_pelajaran').value;

        // Reset daftar siswa sebelum menampilkan data baru
        var siswaList = document.getElementById('siswa-list');
        siswaList.innerHTML = '';  // Bersihkan daftar siswa sebelumnya

        // Reset tombol simpan
        document.getElementById('saveButton').disabled = true;

        if (tahun && kelas) {
            fetch(`/api/getsiswa?tahun=${tahun}&kelas=${kelas}&tahun_pelajaran=${tahunpelajaran}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);  // Menampilkan error dari API jika data tidak ditemukan
                    } else {
                        data.forEach(siswa => {
                            var role = '{{ auth()->user()->role }}';  // Mengetahui peran pengguna

                            // Fetch data kelas berdasarkan id
                            fetch(`/api/getkelas?id=${siswa.kelas}`)
                                .then(response => response.json())
                                .then(kelasData => {
                                    var namaKelas = kelasData ? kelasData.nama_kelas : 'Kelas tidak ditemukan';

                                    siswaList.innerHTML += `
                                        <tr>
                                            <td>${siswa.nis}</td>
                                            <td>${siswa.nama}</td>
                                            <td>Beasiswa Prestasi (BP)</td>
                                            <td>${siswa.tahun}</td>
                                            <td>${siswa.tahun_pelajaran}</td>
                                            <td>${namaKelas}</td>

                                            <input type="hidden" name="orangtua[${siswa.id}][id]" value="${siswa.id}">
                                            <input type="hidden" name="orangtua[${siswa.id}][beasiswa]" value="1">
                                            <input type="hidden" name="orangtua[${siswa.id}][tahun]" value="${siswa.tahun}">
                                            <input type="hidden" name="orangtua[${siswa.id}][kelas]" value="${siswa.kelas_id}">
                                            <input type="hidden" name="orangtua[${siswa.id}][tahun_pelajaran]" value="${siswa.tahun_pelajaran}">

                                            <!-- Menampilkan kolom nilai berdasarkan role -->
                                          @foreach($kriteria as $k)
    @if (auth()->user()->role === 'guru_bahasa_arab' && $k->id == 1)
        <td>
            <input type="number" name="nilai[${siswa.id}][{{ $k->id }}]" class="form-control" placeholder="Masukkan Nilai" required max="100">
        </td>
    @elseif (auth()->user()->role === 'guru_alquran_hadist' && $k->id == 2)
        <td>
            <input type="number" name="nilai[${siswa.id}][{{ $k->id }}]" class="form-control" placeholder="Masukkan Nilai" required max="100">
        </td>
    @elseif (auth()->user()->role === 'guru_fiqih_aqidah' && $k->id == 3)
        <td>
            <input type="number" name="nilai[${siswa.id}][{{ $k->id }}]" class="form-control" placeholder="Masukkan Nilai" required max="100">
        </td>
    @else
        <td>
            <input type="hidden" name="nilai[${siswa.id}][{{ $k->id }}]" value="0">
        </td>
    @endif
@endforeach

                                        </tr>
                                    `;
                                })
                                .catch(error => console.error('Error fetching kelas:', error));
                        });

                        // Mengaktifkan tombol simpan setelah siswa ditampilkan
                        document.getElementById('saveButton').disabled = false;
                    }
                })
                .catch(error => console.error('Error:', error));
        } else {
            alert("Tahun angkatan dan kelas harus dipilih");
        }
    });

    // Validasi form sebelum submit
    document.getElementById('orangtuaForm').addEventListener('submit', function (event) {
        var isValid = true;
        // Periksa jika ada field kosong
        document.querySelectorAll('input[required], select[required]').forEach(function (input) {
            if (!input.value) {
                isValid = false;
                input.classList.add('is-invalid');
            } else {
                input.classList.remove('is-invalid');
            }
        });
        if (!isValid) {
            event.preventDefault(); // Mencegah form disubmit
            alert('Semua kolom harus diisi!');
        }
    });

    document.querySelectorAll('input[type="number"]').forEach(function (input) {
    input.addEventListener('input', function () {
        if (parseInt(input.value) > 100) {
            input.value = 100; // Batasi nilai yang dimasukkan maksimal 100
        }
    });
});

</script>
@endsection
