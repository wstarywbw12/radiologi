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
                            ServiceRequest Radiologi
                        </h3>
                  </div>
               </div>
            </div>
        </div>

        <!-- 🔍 Filter Tanggal dan Status -->
        <form method="GET" class="row g-2 mb-3">
            <div class="col-md-3">
                <input type="date" name="start_date" class="form-control" value="{{ $start }}">
            </div>
            <div class="col-md-3">
                <input type="date" name="end_date" class="form-control" value="{{ $end }}">
            </div>
            <div class="col-md-2">
                <select name="status_kirim" class="form-select">
                    <option value="all" {{ $statusKirim == 'all' ? 'selected' : '' }}>Semua Data</option>
                    <option value="1" {{ $statusKirim == '1' ? 'selected' : '' }}>Sudah Kirim</option>
                    <option value="0" {{ $statusKirim == '0' ? 'selected' : '' }}>Belum Kirim</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100">Filter</button>
            </div>
            <div class="col-md-2">
                <a href="{{ url()->current() }}" class="btn btn-secondary w-100">Reset</a>
            </div>
        </form>

        <!-- Info -->
        <div class="alert alert-info">
            Total Data: <strong>{{ $total }}</strong> | 
            Filter: 
            @if($statusKirim == 'all') Semua Data
            @elseif($statusKirim == '1') Sudah Kirim
            @elseif($statusKirim == '0') Belum Kirim
            @endif
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
                            <th>Status Kirim</th>
                            <th>Image Study</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $index => $row)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $row['tanggal_order'] }}</td>
                                <td>{{ $row['no_rm'] }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        @if ($row['processed_status'] == 1)
                                            <span class="badge bg-primary">{{ $row['no_rontgen'] }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ $row['no_rontgen'] }}</span>
                                        @endif
                                        <button type="button" class="btn btn-sm btn-outline-secondary copy-btn" 
                                                data-copy="{{ $row['no_rontgen'] }}"
                                                data-index="{{ $index }}"
                                                title="Salin No Rontgen & Kirim ke API">
                                            📋
                                        </button>
                                    </div>
                                </td>
                                <td>{{ $row['nama_pasien'] }}</td>
                                <td>{{ $row['nama_pemeriksaan'] }}</td>
                                <td>{{ $row['dokter_pengirim'] }}</td>
                                <td>{{ $row['radiolog_datetime_start'] }}</td>
                                <td>{{ $row['radiolog_datetime_end'] }}</td>
                                <td>
                                    @if ($row['processed_status'] == 1)
                                        <span class="badge bg-success">Sudah</span>
                                    @else
                                        <span class="badge bg-danger">Belum</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($row['imgstudy_status'] == 1)
                                        <span class="badge bg-success">Sudah</span>
                                    @else
                                        <span class="badge bg-danger">Belum</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center">Tidak ada</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>

    </div>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 9999; text-align: center; padding-top: 20%;">
        <div style="background: white; display: inline-block; padding: 20px; border-radius: 10px;">
            <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-3">Mengirim data ke SatuSehat...</p>
        </div>
    </div>

    <script>
        // Fungsi untuk menampilkan loading
        function showLoading() {
            document.getElementById('loadingOverlay').style.display = 'block';
        }

        function hideLoading() {
            document.getElementById('loadingOverlay').style.display = 'none';
        }

        // Fungsi untuk menampilkan notifikasi
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `alert alert-${type} position-fixed top-0 end-0 m-3`;
            notification.style.zIndex = '10000';
            notification.style.minWidth = '300px';
            notification.innerHTML = `
                <strong>${type === 'success' ? '✓ Berhasil' : '✗ Gagal'}</strong><br>
                ${message}
            `;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        // Fungsi untuk mengakses API
        async function callApi(noRontgen, button) {
            const apiUrl = `http://192.168.10.29/wslokal/satusehat/radiologi/worklist/ris/accno/${noRontgen}/manualsend`;
            
            showLoading();
            
            // Simpan teks asli tombol
            const originalText = button.innerHTML;
            button.innerHTML = '⏳';
            button.disabled = true;
            
            try {
                const response = await fetch(apiUrl, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                    }
                });
                
                let result;
                try {
                    result = await response.json();
                } catch(e) {
                    result = { message: await response.text() };
                }
                
                if (response.ok) {
                    showNotification(`Berhasil mengirim No Rontgen: ${noRontgen}`, 'success');
                    button.innerHTML = '✓';
                    setTimeout(() => {
                        button.innerHTML = originalText;
                        button.disabled = false;
                    }, 2000);
                    
                    // Refresh halaman setelah 2 detik
                    setTimeout(() => {
                        location.reload();
                    }, 2000);
                } else {
                    throw new Error(result.message || 'Gagal mengirim ke API');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification(`Gagal mengirim: ${error.message}`, 'danger');
                button.innerHTML = '❌';
                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.disabled = false;
                }, 2000);
            } finally {
                hideLoading();
            }
        }

        // Fungsi copy + API untuk tombol copy
        function copyAndSendToApi(text, button) {
            // Method 1: Clipboard API (modern)
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text).then(() => {
                    showSuccess(button);
                    // Panggil API setelah copy berhasil
                    callApi(text, button);
                }).catch(() => {
                    fallbackCopy(text, button, true);
                });
            } 
            // Method 2: Fallback untuk HTTP atau browser lama
            else {
                fallbackCopy(text, button, true);
            }
        }

        function fallbackCopy(text, button, callApiAfter = false) {
            const textarea = document.createElement('textarea');
            textarea.value = text;
            textarea.style.position = 'fixed';
            textarea.style.top = '-9999px';
            textarea.style.left = '-9999px';
            document.body.appendChild(textarea);
            textarea.select();
            textarea.setSelectionRange(0, text.length);
            
            try {
                const success = document.execCommand('copy');
                if (success) {
                    showSuccess(button);
                    if (callApiAfter) {
                        callApi(text, button);
                    }
                } else {
                    showError(button);
                }
            } catch (err) {
                showError(button);
            }
            
            document.body.removeChild(textarea);
        }

        function showSuccess(button) {
            const originalText = button.innerHTML;
            button.innerHTML = '✓';
            button.classList.remove('btn-outline-secondary');
            button.classList.add('btn-success');
            setTimeout(() => {
                if (button.innerHTML === '✓') {
                    button.innerHTML = originalText;
                    button.classList.remove('btn-success');
                    button.classList.add('btn-outline-secondary');
                }
            }, 1500);
        }

        function showError(button) {
            const originalText = button.innerHTML;
            button.innerHTML = '❌';
            button.classList.remove('btn-outline-secondary');
            button.classList.add('btn-danger');
            setTimeout(() => {
                button.innerHTML = originalText;
                button.classList.remove('btn-danger');
                button.classList.add('btn-outline-secondary');
            }, 1500);
            alert('Gagal menyalin. Silakan copy manual dengan seleksi teks.');
        }

        // Event listener untuk tombol copy (dengan API)
        document.querySelectorAll('.copy-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const textToCopy = this.getAttribute('data-copy');
                if (textToCopy && textToCopy.trim() !== '') {
                    copyAndSendToApi(textToCopy, this);
                } else {
                    alert('Tidak ada teks untuk disalin');
                }
            });
        });
    </script>

</body>

</html>