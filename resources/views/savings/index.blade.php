@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                @if (auth()->user()->role == 'anggota' || auth()->user()->role == 'sekretaris')
                    <div class="card mb-4">
                        <h5 class="card-header">Tambah Simpanan</h5>
                        <div class="card-body">
                            @if (auth()->user()->role == 'anggota')
                                <form action="{{ route('savings.store') }}" method="POST" id="formTambahSimpanan">
                                    @csrf

                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label for="jenis_simpanan" class="form-label">Jenis Simpanan</label>
                                            <select id="jenis_simpanan" class="select2 form-select form-select-lg"
                                                data-allow-clear="true" name="jenis_simpanan">
                                                <option value="wajib">Simpanan Wajib</option>
                                                <option value="sukarela">Simpanan Sukarela</option>
                                            </select>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label" for="jumlah">Jumlah</label>
                                            <input type="number" name="jumlah" id="jumlah" class="form-control" required
                                                min="1000">
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <button type="submit" class="btn btn-primary">Tambah</button>
                                    </div>
                                </form>
                            @elseif (auth()->user()->role == 'sekretaris')
                                <a href="{{ route('savings.createBySekretaris') }}" class="btn btn-primary">Tambah</a>
                            @endif
                        </div>
                    </div>
                @endif

                <div class="card">
                    <h5 class="card-header">Daftar Simpanan</h5>
                    <div class="card-body">
            
                        <div class="row mb-3">
                            @if (auth()->user()->role != 'anggota')
                                <div class="col-md-4 mb-3">
                                    <input type="text" id="search_name" class="form-control" placeholder="Cari Nama Anggota" onkeyup="fetchSavings()">
                                </div>
                            @endif
                            <div class="col-md-4 mb-3">
                                <input type="text" id="search_jenis" class="form-control" placeholder="Cari Jenis Simpanan" onkeyup="fetchSavings()">
                            </div>
                            <div class="col-md-4 mb-3">
                                <input type="text" id="search_status" class="form-control" placeholder="Cari Status" onkeyup="fetchSavings()">
                            </div>
                        </div>

                        <div id="savings-table">
                            <!-- Tabel akan dimuat di sini -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var successMessage = @json(session('status'));

        function formatDate(dateString) {
            const optionsDate = { day: '2-digit', month: 'long', year: 'numeric' };
            const optionsTime = { hour: '2-digit', minute: '2-digit' };

            const date = new Date(dateString);
            const formattedDate = date.toLocaleDateString('id-ID', optionsDate);
            const formattedTime = date.toLocaleTimeString('id-ID', optionsTime);

            return `${formattedDate}, ${formattedTime}`;
        }
        
        function fetchSavings() {
            const search_name = document.getElementById('search_name') ? document.getElementById('search_name').value : '';
            const search_jenis = document.getElementById('search_jenis').value;
            const search_status = document.getElementById('search_status').value;

            fetch(`/savings?search_name=${search_name}&search_jenis=${search_jenis}&search_status=${search_status}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                let tableContent = `<table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            @if (auth()->user()->role != 'anggota')
                                <th>Nama</th>
                            @endif
                            <th>Jenis Simpanan</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Tanggal Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>`;

                data.forEach((saving, index) => {
                    tableContent += `
                        <tr>
                            <td>${index + 1}</td>
                            @if (auth()->user()->role != 'anggota')
                                <td>${saving.user.name}</td>
                            @endif
                            <td>${saving.jenis_simpanan}</td>
                            <td>Rp${new Intl.NumberFormat('id-ID').format(saving.jumlah)}</td>
                            <td>${saving.status}</td>
                            <td>${saving.status == 'dibayar' ? formatDate(saving.updated_at) : ''}</td>
                        </tr>`;
                });

                tableContent += `</tbody></table>`;
                document.getElementById('savings-table').innerHTML = tableContent;
            })
            .catch(error => console.error('Error:', error));
        }

        // Panggil fungsi ini untuk pertama kali agar tabel dimuat
        fetchSavings();
        
    </script>
@endsection
