<!DOCTYPE html>
<html>

<head>
    <title>Service Request</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-4">

        <h3 class="mb-4">Data Service Request (SATUSEHAT)</h3>

        <!-- 🔍 Search -->
        <form method="GET" class="row g-2 mb-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control"
                    placeholder="Cari Satusehat ID / Request Param..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100">Search</button>
            </div>
            <div class="col-md-2">
                <a href="{{ url('/service-request') }}" class="btn btn-secondary w-100">Reset</a>
            </div>
        </form>

        <div class="card shadow-sm">
            <div class="card-body">

                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th width="5%">No</th>
                            <th>Connection Name</th>
                            <th>Satusehat ID</th>
                            <th>Acc Number</th>
                            <th>Request Param</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $index => $row)
                            <tr>
                                <td>{{ $data->firstItem() + $index }}</td>
                                <td>{{ $row->connection_name }}</td>
                                <td>
                                    <code>{{ $row->satusehat_id }}</code>
                                </td>
                                <td>
                                    {{ $row->accession_number ?? '-' }}
                                </td>
                                <td>
                                    <small>{{ Str::limit($row->request_param, 50) }}</small>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $data->links('pagination::bootstrap-5') }}
                </div>

            </div>
        </div>

    </div>

</body>

</html>
