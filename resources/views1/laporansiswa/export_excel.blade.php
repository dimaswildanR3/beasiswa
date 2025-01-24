<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Laporan Beasiswa Berprestasi
  </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="/adminLTE/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/adminLTE/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  
  <style>
    body {
      font-family: 'Source Sans Pro', sans-serif;
      margin: 0;
      padding: 0;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    th, td {
      padding: 10px;
      text-align: center;
      border: 1px solid #ddd;
    }

    th {
      background-color: #f4f4f4;
      color: #333;
    }

    .table-responsive {
      overflow-x: auto;
    }

    h6 {
      font-weight: bold;
      font-size: 18px;
      margin-bottom: 20px;
    }

    .bg-light {
      background-color: #f8f9fa !important;
    }

    /* Column width adjustments */
    th div, td div {
      width: 120px;
      word-wrap: break-word;
    }

    @media print {
      table {
        width: 100%;
      }

      th, td {
        padding: 5px;
        font-size: 12px;
      }
    }
  </style>

</head>

<body>
  <div class="wrapper">
    <!-- Main content -->
    <div class="row">
      <div class="col-12 table-responsive">
        <table class="table table-bordered table-head-fixed bg-white">
          <thead>
            <tr>
              <td colspan="8" align="center">
                <h6><b>Laporan Beasiswa Berprestasi (BP)</b></h6>
              </td>
            </tr>
            <tr class="bg-light">
              <th>NIS</th>
              <th><div>Nama</div></th>
              <th><div>Tahun</div></th>
              <th>Nilai Preferensi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($siswa as $siswas)
              <tr>
                <td>{{ $siswas->siswa->nis }}</td>
                <td>{{ $siswas->siswa->nama }}</td>
                <td>{{ $siswas->siswa->tahun }}</td>
                <td>
                  @php
                    $bobot_kepala = $siswas->nilai_preferensi;
                  @endphp
                  {{ $bobot_kepala }}
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    window.addEventListener("load", window.print());
  </script>

</body>

</html>
