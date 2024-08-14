@extends('layouts.main')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Ajukan Pinjaman</h5>
                    <div class="card-body">
                        <form action="{{ route('loans.ajukan') }}" method="POST" id="formPengajuanPinjaman" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="jumlah">Jumlah Pinjaman</label>
                                    <input class="form-control" type="text" name="jumlah" id="jumlah">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="jangka_waktu">Jangka Waktu Pembayaran (bulan)</label>
                                    <input class="form-control" type="number" name="jangka_waktu" id="jangka_waktu">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="bank" class="form-label">Bank</label>
                                    <select id="bank" class="select2 form-select form-select-lg"
                                        data-allow-clear="true" name="bank">
                                        <option value="BRI">BRI</option>
                                        <option value="BNI">BNI</option>
                                        <option value="BTN">BTN</option>
                                        <option value="MANDIRI">MANDIRI</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="no_rek">Nomor Rekening</label>
                                    <input class="form-control" type="text" name="no_rek" id="no_rek">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="jaminan">Jaminan</label>
                                    <input class="form-control" type="file" name="jaminan" id="jaminan">
                                </div>
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary">Ajukan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
