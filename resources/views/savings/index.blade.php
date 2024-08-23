@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                @if (auth()->user()->role == 'anggota')
                    <div class="card mb-4">
                        <h5 class="card-header">Tambah Simpanan</h5>
                        <div class="card-body">
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
                        </div>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-center">
                        <h5 class="mb-3 mb-md-0">Daftar Simpanan</h5>

                        @if (auth()->user()->role == 'sekretaris')
                            <a href="{{ route('savings.createBySekretaris') }}" class="btn btn-primary">
                                <i class="ti ti-plus d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Tambah Simpanan</span>
                            </a>
                        @endif
                    </div>
                    
                    <div class="card-body">
            
                        <!-- Input Pencarian -->
                        @if (auth()->user()->role != 'anggota')
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <input type="text" id="searchName" class="form-control" placeholder="Cari Nama Anggota">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <input type="text" id="searchJenis" class="form-control" placeholder="Cari Jenis Simpanan">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <input type="text" id="searchStatus" class="form-control" placeholder="Cari Status">
                                </div>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table" style="width: 1150px;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        @if (auth()->user()->role != 'anggota')
                                            <th>Nama Anggota</th>
                                        @endif
                                        <th>Jenis Simpanan</th>
                                        <th>Jumlah</th>
                                        <th>Status</th>
                                        <th>Tanggal Pembayaran</th>
                                    </tr>
                                </thead>
                                <tbody id="savingTableBody">
                                    @foreach ($savings as $saving)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            @if (auth()->user()->role != 'anggota')
                                                <td>{{ $saving->user->name }}</td>
                                            @endif
                                            <td>{{ $saving->jenis_simpanan }}</td>
                                            <td>Rp{{ number_format($saving->jumlah, 2, ',', '.') }}</td>
                                            <td>
                                                <span class="badge 
                                                    @if($saving->status == 'dibayar') bg-label-success
                                                    @elseif($saving->status == 'belum bayar') bg-label-warning 
                                                    @endif">
                                                    {{ $saving->status }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($saving->status == 'dibayar')
                                                    {{ \Carbon\Carbon::parse($saving->updated_at)->translatedFormat('d F Y H:i') }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var successMessage = @json(session('status'));

        document.addEventListener('DOMContentLoaded', function () {
            const searchInputs = {
                name: document.getElementById('searchName'),
                jenis: document.getElementById('searchJenis'),
                status: document.getElementById('searchStatus')
            };

            const savingTableBody = document.getElementById('savingTableBody');
            const savings = savingTableBody.getElementsByTagName('tr');

            Object.values(searchInputs).forEach(input => {
                input && input.addEventListener('input', function () {
                    filterTable();
                });
            });

            function filterTable() {
                for (let i = 0; i < savings.length; i++) {
                    const savingRow = savings[i];
                    let show = true;

                    if (searchInputs.name && searchInputs.name.value && !savingRow.children[1].textContent.toLowerCase().includes(searchInputs.name.value.toLowerCase())) {
                        show = false;
                    }
                    if (searchInputs.jenis && searchInputs.jenis.value && !savingRow.children[2].textContent.toLowerCase().includes(searchInputs.jenis.value.toLowerCase())) {
                        show = false;
                    }
                    if (searchInputs.status && searchInputs.status.value && !savingRow.children[4].textContent.toLowerCase().includes(searchInputs.status.value.toLowerCase())) {
                        show = false;
                    }

                    savingRow.style.display = show ? '' : 'none';
                }
            }
        });
    </script>
@endsection
