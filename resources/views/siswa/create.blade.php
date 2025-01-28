@extends('layouts.master')

@section('content')
<section class="content card" style="padding: 10px 10px 10px 10px">
    <div class="box">
        @if(session('sukses'))
        <div class="callout callout-success alert alert-success alert-dismissible fade show" role="alert">
            <h5><i class="fas fa-check"></i> Sukses :</h5>
            {{session('sukses')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        @if(session('warning'))
        <div class="callout callout-warning alert alert-warning alert-dismissible fade show" role="alert">
            <h5><i class="fas fa-info"></i> Informasi :</h5>
            {{session('warning')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        @if ($errors->any())
        <div class="callout callout-danger alert alert-danger alert-dismissible fade show">
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
        
        <form action="/siswa/store" method="POST" enctype="multipart/form-data">
            <h4><i class="nav-icon fas fa-child my-1 btn-sm-1"></i> Tambah Biodata Siswa</h4>
            <hr>
            {{ csrf_field() }}

            <div class="col-md-12">
                <label for="tahun">Tahun Angkatan</label>
                <input value="{{ old('tahun') }}" name="tahun" type="number" class="form-control" id="tahun"
                       placeholder="Tahun" min="2000" max="2099" step="1" required 
                       oninvalid="this.setCustomValidity('Isian ini tidak boleh kosong !')"
                       oninput="setCustomValidity('')" onblur="validateYear(this)">
            </div>
            <div class="col-md-12">
                <label for="tahun_pelajaran">Tahun Pelajaran</label>
                <select name="tahun_pelajaran" class="form-control" id="tahun_pelajaran" required oninvalid="this.setCustomValidity('Isian ini tidak boleh kosong !')" oninput="setCustomValidity('')">
                    <option value="">-- Pilih Tahun Pelajaran --</option>
                    @for ($i = date('Y'); $i >= 2000; $i--)
                        <option value="{{ $i }}/{{ $i+1 }}" {{ old('tahun_pelajaran') == "$i/$i+1" ? 'selected' : '' }}>
                            {{ $i }}/{{ $i+1 }}
                        </option>
                    @endfor
                </select>
            </div>
            
            <hr>
            <button type="button" class="btn btn-primary btn-sm" id="tambahData"><i class="fas fa-plus"></i> Tambah Data</button>
            
            <div id="inputContainer">
                <!-- Form input dinamis akan muncul di sini -->
            </div>
            
            <hr>
            <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> SIMPAN</button>
            <a class="btn btn-danger btn-sm" href="index" role="button"><i class="fas fa-undo"></i> BATAL</a>
        </form>
    </div>
</section>
<script>
    document.getElementById("tambahData").addEventListener("click", function () {
        let container = document.getElementById("inputContainer");
        let newRow = document.createElement("div");
        newRow.classList.add("row", "mt-3", "border", "p-3", "form-group");
        
        newRow.innerHTML = `
            <div class="col-md-6">
                <label for="nama">Nama Siswa</label>
                <input name="nama[]" type="text" class="form-control" placeholder="Nama Siswa" required>
            </div>
            <div class="col-md-6">
                <label for="nis">NIS</label>
                <input name="nis[]" type="number" class="form-control" placeholder="NIS" required>
            </div>
            <div class="col-md-6">
                <label for="alamat">Alamat</label>
                <input name="alamat[]" type="text" class="form-control" placeholder="Alamat" required>
            </div>
            <div class="col-md-6">
                <label for="Jenis_kelamin">Jenis Kelamin</label>
                <select name="Jenis_kelamin[]" class="form-control">
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option value="Laki-Laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="kelas">Kelas</label>
                <select name="kelas[]" class="form-control" required>
                    <option value="">Pilih Kelas</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>
        `;
        
        container.appendChild(newRow);
    });
    </script>
    
<script>
    function validateYear(input) {
        let year = parseInt(input.value);
        if (!isNaN(year)) {  // Cek apakah yang diinput adalah angka
            if (year < 2000) {
                input.value = 2000; // Jika kurang dari 2000, set ke 2000
            } else if (year > 2099) {
                input.value = 2099; // Jika lebih dari 2099, set ke 2099
            }
        }
    }
    </script>
@endsection
