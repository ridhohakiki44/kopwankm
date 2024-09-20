@extends('layouts.main')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Pendaftaran Anggota</h5>

                <div class="card-body">
                    <form method="post" action="{{ route('pendaftaran-anggota.ajukan') }}" id="formPendaftaranAnggota"
                        enctype="multipart/form-data">
                        @csrf
                        @method('patch')

                        <div class="row">

                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="nik">NIK</label>
                                <input class="form-control" type="text" id="nik" name="nik" placeholder="NIK" maxlength="16" />
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="alamat" class="form-label">Alamat</label>
                                <select id="alamat" class="select2 form-select form-select-lg"
                                    data-allow-clear="true" name="alamat">
                                    <option value="Bunga Tanjung">Bunga Tanjung</option>
                                    <option value="Kampung Padang Selatan">Kampung Padang Selatan</option>
                                    <option value="Kampung Padang Utara">Kampung Padang Utara</option>
                                    <option value="Pasar Baru Barat">Pasar Baru Barat</option>
                                    <option value="Pasar Baru Timur">Pasar Baru Timur</option>
                                    <option value="Pasar Baru Utara">Pasar Baru Utara</option>
                                    <option value="Pasar Dua Suak">Pasar Dua Suak</option>
                                    <option value="Pasar Muara">Pasar Muara</option>
                                    <option value="Pasar Pokan">Pasar Pokan</option>
                                    <option value="Pasar Satu">Pasar Satu</option>
                                    <option value="Pigogah Patibubur">Pigogah Patibubur</option>
                                    <option value="Pulau Panjang">Pulau Panjang</option>
                                    <option value="Silawai Tengah">Silawai Tengah</option>
                                    <option value="Silawai Timur">Silawai Timur</option>
                                </select>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="nomor_telepon">Nomor Telepon</label>
                                <input class="form-control" type="text" id="nomor_telepon" name="nomor_telepon" placeholder="081234567890" />
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="text" class="form-control" placeholder="YYYY-MM-DD" id="tanggal_lahir" name="tanggal_lahir" />
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label" for="pekerjaan">Pekerjaan</label>
                                <select id="pekerjaan" class="select2 form-select form-select-lg"
                                    data-allow-clear="true" name="pekerjaan">
                                    <option value="Ibu Rumah Tangga">Ibu Rumah Tangga</option>
                                    <option value="Petani">Petani</option>
                                    <option value="Pedagang">Pedagang</option>
                                    <option value="Guru">Guru</option>
                                    <option value="Dokter">Dokter</option>
                                    <option value="Bidan">Bidan</option>
                                    <option value="PNS">PNS</option>
                                    <option value="PPPK">PPPK</option>
                                    <option value="Karyawan Honorer">Karyawan Honorer</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>

                            <div class="mb-3 col-md-6" id="input-pekerjaan-lainnya" style="display: none;">
                                <label class="form-label" for="pekerjaan_lainnya">Pekerjaan Lainnya</label>
                                <input type="text" id="pekerjaan_lainnya" class="form-control" name="pekerjaan_lainnya" placeholder="Pekerjaan lainnya" />
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="penghasilan" class="form-label">Penghasilan</label>
                                <select id="penghasilan" class="select2 form-select form-select-lg"
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
