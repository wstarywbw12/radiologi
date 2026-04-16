<!DOCTYPE html>
<html>

<head>
    <title>Worklist Radiologi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-4">

        <div class="row mb-4">
            <div class="col-12">
               <div class="card">
                  <div class="card-header">
                        <h3>
                            Data Worklist Radiologi
                        </h3>
                  </div>
               </div>
            </div>
        </div>

        <!-- 🔍 Filter Tanggal -->
        <form method="GET" class="row g-2 mb-3">
            <div class="col-md-3">
                <input type="date" name="start_date" class="form-control" value="{{ $start }}">
            </div>
            <div class="col-md-3">
                <input type="date" name="end_date" class="form-control" value="{{ $end }}">
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100">Filter</button>
            </div>
        </form>

        <!-- Info -->
        <div class="alert alert-info">
            Total Data: <strong>{{ $total }}</strong>
        </div>

        <div class="card shadow-sm">
            <div class="card-body table-responsive">

                <table class="table table-bordered table-striped table-sm">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Tanggal Order</th>
                            <th>No RM</th>
                            <th>No Rontgen</th>
                            <th>Nama Pasien</th>
                            <th>Pemeriksaan</th>
                            <th>Dokter</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>Status SatuSehat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $index => $row)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $row['tanggal_order'] }}</td>
                                <td>{{ $row['no_rm'] }}</td>
                                <td>
                                    <span class="badge bg-primary">
                                        {{ $row['no_rontgen'] }}
                                    </span>
                                </td>
                                <td>{{ $row['nama_pasien'] }}</td>
                                <td>{{ $row['nama_pemeriksaan'] }}</td>
                                <td>{{ $row['dokter_pengirim'] }}</td>
                                <td>{{ $row['radiolog_datetime_start'] }}</td>
                                <td>{{ $row['radiolog_datetime_end'] }}</td>
                                <td>
                                    @if ($row['svcreq_status'] == 1)
                                        <span class="badge bg-success">Sudah</span>
                                    @else
                                        <span class="badge bg-danger">Belum</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>

    </div>

</body>

</html>
