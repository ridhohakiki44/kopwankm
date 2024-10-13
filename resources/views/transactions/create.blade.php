@extends('layouts.main')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Tambahkan Transaksi</h5>
                    <div class="card-body">
                        <form action="{{ route('transactions.store') }}" method="POST" id="formTransaction">
                            @csrf

                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="description">Uraian</label>
                                    <input class="form-control" type="text" name="description" id="description">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="type" class="form-label">Tipe</label>
                                    <select id="type" class="select2 form-select form-select-lg"
                                        data-allow-clear="true" name="type">
                                        <option value="debit">Debit</option>
                                        <option value="credit">Kredit</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="amount">Jumlah</label>
                                    <input class="form-control" type="number" name="amount" id="amount">
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
@endsection
