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

        <form action="{{ route('orangtua.store') }}" method="POST" id="orangtuaForm">
            @csrf
            <h4><i class="nav-icon fas fa-user-friends"></i> Tambah Data Orangtua</h4>
            <hr>

            <div class="row">
                <div class="col-md-6">
                    <label for="tahun_angkatan">Tahun Angkatan</label>
                    <select name="tahun_angkatan" id="tahun_angkatan" class="form-control" required>
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
                        <th>Nama Orangtua</th>
                        <th>Jenis Kelamin</th>
                        <th>Penghasilan</th>
                        <th>Tanggungan</th>
                    </tr>
                </thead>
                <tbody id="siswa-list">
                    <!-- Data Siswa akan muncul di sini melalui AJAX -->
                </tbody>
            </table>

            <hr>
            <button type="submit" class="btn btn-success" id="saveButton" disabled><i class="fas fa-save"></i> Simpan</button>
            <a href="{{ route('orangtua.index') }}" class="btn btn-danger"><i class="fas fa-undo"></i> Batal</a>
        </form>
    </div>
</section>

<script>
    document.getElementById('tampilkan-siswa').addEventListener('click', function () {
      var tahun = document.getElementById('tahun_angkatan').value;
      var kelas = document.getElementById('kelas').value;
  
      if (tahun && kelas) {
          fetch(`/api/siswa?tahun_angkatan=${tahun}&kelas=${kelas}`)
              .then(response => response.json())
              .then(data => {
                  var siswaList = document.getElementById('siswa-list');
                  siswaList.innerHTML = '';  // Bersihkan daftar siswa sebelumnya
  
                  data.forEach(siswa => {
                      siswaList.innerHTML += `
                          <tr>
                              <td>${siswa.nis}</td>
                              <td>${siswa.nama}</td>
                              <td><input type="text" name="orangtua[${siswa.id}][nama_orangtua]" class="form-control" required></td>
                              <td>
                                  <select name="orangtua[${siswa.id}][jenis_kelamin]" class="form-control" required>
                                      <option value="Laki-Laki">Laki-laki</option>
                                      <option value="Perempuan">Perempuan</option>
                                  </select>
                              </td>
                              <td><input type="number" name="orangtua[${siswa.id}][penghasilan]" class="form-control" required></td>
                              <td><input type="number" name="orangtua[${siswa.id}][tanggungan]" class="form-control" required></td>
                              <!-- Menambahkan NIS dan Nama Siswa sebagai input tersembunyi -->
                              <input type="hidden" name="orangtua[${siswa.id}][id]" value="${siswa.id}">
                              <input type="hidden" name="orangtua[${siswa.id}][nama]" value="${siswa.nama}">
                              <input type="hidden" name="orangtua[${siswa.id}][tahun]" value="${siswa.tahun}">
                              <input type="hidden" name="orangtua[${siswa.id}][kelas]" value="${siswa.kelas}">
                          </tr>
                      `;
                  });

                  // Mengaktifkan tombol simpan setelah siswa ditampilkan
                  document.getElementById('saveButton').disabled = false;
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
</script>
@endsection
