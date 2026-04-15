<!DOCTYPE html>
<html>
<head>
    <title>Hasil ImagingStudy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h5>Hasil</h5>
        </div>

        <div class="card-body">

            @if($status_message)
                <div class="alert alert-{{ $status_class }}">
                    {{ $status_message }}
                </div>
            @endif

            <h6>Response:</h6>
            <pre>{{ json_encode($data, JSON_PRETTY_PRINT) }}</pre>

            <a href="/cek-image-study" class="btn btn-primary mt-3">Kembali</a>

        </div>
    </div>
</div>

</body>
</html>