@extends('layouts.main')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Pendaftaran Anggota</h5>

                <div class="card-body">
                    <form method="post" action="{{ route('pendaftaran-anggota.ajukan') }}" id="formAccountSettings"
                        enctype="multipart/form-data">
                        @csrf
                        @method('patch')

                        <div class="row">

                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="nik">NIK</label>
                                <input class="form-control" type="text" id="nik" name="nik" value=""
                                    placeholder="NIK" />
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input class="form-control" type="text" id="alamat" name="alamat" value=""
                                    placeholder="Alamat" />
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="nomor_telepon">Nomor Telepon</label>
                                <input class="form-control" type="text" id="nomor_telepon" name="nomor_telepon"
                                    value="" placeholder="081234567890" />
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="flatpickr-date" class="form-label">Tanggal Lahir</label>
                                <input type="text" class="form-control" placeholder="YYYY-MM-DD" id="flatpickr-date"
                                    name="tanggal_lahir" />
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="pekerjaan">Pekerjaan</label>
                                <input class="form-control" type="text" id="pekerjaan" name="pekerjaan"
                                    value="" placeholder="Pekerjaan" />
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="select2Basic" class="form-label">Penghasilan</label>
                                <select id="select2Basic" class="select2 form-select form-select-lg"
                                    data-allow-clear="true" name="penghasilan">
                                    <option value="500.000 - 1.000.000">500.000 - 1.000.000</option>
                                    <option value="1.000.000 - 1.500.000">1.000.000 - 1.500.000</option>
                                    <option value="1.500.000 - 2.000.000">1.500.000 - 2.000.000</option>
                                    <option value="2.000.000 - 3.000.000">2.000.000 - 3.000.000</option>
                                    <option value="3.000.000 - 10.000.000">3.000.000 - 10.000.000</option>
                                </select>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="ktp" class="form-label">KTP</label>
                                <input class="form-control" type="file" id="ktp" name="ktp" />
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="kartu_keluarga" class="form-label">Kartu Keluarga</label>
                                <input class="form-control" type="file" id="kartu_keluarga" name="kartu_keluarga" />
                            </div>
                        </div>

                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">Ajukan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
