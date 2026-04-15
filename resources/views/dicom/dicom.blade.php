<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DICOM Monitoring</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-stats {
            transition: transform 0.2s;
            cursor: pointer;
        }

        .card-stats:hover {
            transform: translateY(-5px);
        }

        .table-responsive {
            border-radius: 8px;
            overflow: hidden;
        }

        .badge-pending {
            background-color: #dc3545;
        }

        .badge-sent {
            background-color: #198754;
        }

        .card-header-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px;
            border-radius: 8px 8px 0 0;
        }
    </style>
</head>

<body>

    <div class="container-fluid px-4 mt-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card-header-custom shadow-sm">
                    <h3 class="mb-0">
                        <i class="bi bi-activity me-2"></i>DICOM Router Monitoring
                    </h3>
                </div>
            </div>
        </div>


        <!-- Recent DICOM Table -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="bi bi-table me-2"></i>Recent DICOM
                            </h5>
                            <button class="btn btn-sm btn-outline-primary" onclick="refreshTable()">
                                <i class="bi bi-arrow-repeat"></i> Refresh
                            </button>
                        </div>
                    </div>
                    <div class="card-body ">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="12%" >Accession No</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recent as $index => $row)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td class="fw-bold">{{ $row->accession_number }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5">
                                                Tidak ada data
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="bi bi-info-circle"></i> Menampilkan {{ count($recent) }} data terbaru
                            </small>
                            <nav aria-label="Page navigation">
                                <ul class="pagination pagination-sm mb-0">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1">Previous</a>
                                    </li>
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">Next</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Optional JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Fungsi untuk refresh tabel
        function refreshTable() {
            location.reload();
        }

        // Fungsi untuk copy ke clipboard
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                // Bisa ditambahkan toast notification
                alert('Study UID berhasil disalin!');
            });
        }

        // Fungsi untuk melihat detail
        function viewDetails(accessionNumber) {
            alert('Detail untuk accession number: ' + accessionNumber);
            // Bisa diarahkan ke modal atau halaman detail
        }

        // Fungsi untuk mengirim ulang data
        function retrySend(accessionNumber) {
            if (confirm('Apakah Anda yakin ingin mengirim ulang data ini?')) {
                alert('Mengirim ulang data: ' + accessionNumber);
                // Tambahkan logic untuk retry send
            }
        }

        // Auto refresh setiap 30 detik (opsional)
        setInterval(function() {
            location.reload();
        }, 30000);
    </script>

</body>

</html>
