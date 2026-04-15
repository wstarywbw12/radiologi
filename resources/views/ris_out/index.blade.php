<!DOCTYPE html>
<html>
<head>
    <title>RIS OUT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">

    <h3 class="mb-4">Data RIS OUT</h3>

    <div class="card shadow-sm">
        <div class="card-body">

            <form method="GET" class="row g-2 mb-3">
    <div class="col-md-3">
        <input type="date" name="start_date" class="form-control"
               value="{{ request('start_date') }}">
    </div>
    <div class="col-md-3">
        <input type="date" name="end_date" class="form-control"
               value="{{ request('end_date') }}">
    </div>
    <div class="col-md-2">
        <button class="btn btn-primary w-100">Filter</button>
    </div>
    <div class="col-md-2">
        <a href="{{ url('/ris-out') }}" class="btn btn-secondary w-100">Reset</a>
    </div>
</form>

            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">admin_datetime_start</th>
                        <th width="15%">No Rontgen</th>
                    </tr>
                </thead>
               <tbody>
@forelse($data as $index => $row)
    <tr>
        <td>{{ $data->firstItem() + $index }}</td>
        <td>{{ $row->admin_datetime_start }}</td>
        <td>{{ $row->no_rontgen }}</td>
    </tr>
@empty
    <tr>
        <td colspan="3" class="text-center">Tidak ada data</td>
    </tr>
@endforelse
</tbody>
            </table>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $data->links() }}
            </div>

        </div>
    </div>

</div>

</body>
</html>