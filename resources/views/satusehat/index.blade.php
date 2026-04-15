<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cari ImagingStudy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5>Form Pencarian ImagingStudy</h5>
        </div>
        <div class="card-body">

            <form method="POST" action="{{ route('satusehat.search') }}">
                @csrf


                <div class="mb-3">
                    <label>Accession Number</label>
                    <input type="text" name="accnumber" class="form-control" required>
                </div>

                <button class="btn btn-success">Cari</button>
            </form>

        </div>
    </div>
</div>

</body>
</html>