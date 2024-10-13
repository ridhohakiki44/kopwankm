@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                    <div class="card mb-4">
                        <h5 class="card-header">Tambah Simpanan</h5>
                        <div class="card-body">
                                <form action="{{ route('savings.storeBySekretaris') }}" method="POST" id="formTambahSimpananBySekretaris">
                                    @csrf

                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label for="user_id" class="form-label">Nama Anggota</label>
                                            <select id="user_id" name="user_id[]" class="select2 form-select" multiple>
                                                <option value="all">Semua Anggota</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="jenis_simpanan" class="form-label">Jenis Simpanan</label>
                                            <select id="jenis_simpanan" class="select2 form-select form-select-lg"
                                                data-allow-clear="true" name="jenis_simpanan">
                                                <option value="wajib">Simpanan Wajib</option>
                                                <option value="sukarela">Simpanan Sukarela</option>
                                            </select>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label for="status" class="form-label">Status</label>
                                            <select id="status" class="select2 form-select form-select-lg"
                                                data-allow-clear="true" name="status">
                                                <option value="belum bayar">Belum Bayar</option>
                                                <option value="dibayar">Dibayar</option>
                                            </select>
                                        </div>
                                        <div class="mb-3 col-md-6" id="jumlahWrapper">
                                            <label class="form-label" for="jumlah">Jumlah</label>
                                            <input type="number" name="jumlah" id="jumlah" class="form-control">
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <button type="submit" class="btn btn-success">Tambah</button>
                                    </div>
                                </form>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    <script>
        var successMessage = @json(session('status'));
    </script>
@endsection
