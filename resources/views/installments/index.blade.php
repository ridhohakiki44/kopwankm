@extends('layouts.main')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">Angsuran Pinjaman</h5>
                <div class="card-body">

                    <!-- Input Pencarian -->
                    @if (auth()->user()->role != 'anggota')
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <input type="text" id="searchName" class="form-control" placeholder="Cari Nama">
                            </div>
                            <div class="col-md-4 mb-3">
                                <input type="text" id="searchStatus" class="form-control" placeholder="Cari Status">
                            </div>
                            <div class="col-md-4 mb-3">
                                <input type="text" class="form-control" placeholder="Rentang Tanggal Jatuh Tempo" id="flatpickr-range" />
                            </div>
                            
                        </div>
                    @endif

                    <div class="table-responsive">
                        @if ($installments->isEmpty())
                                <p>Tidak ada angsuran pinjaman.</p>
                        @else
                            <table class="table" style="width: 1150px;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        @if (auth()->user()->role != 'anggota')
                                            <td>Nama Anggota</td>
                                        @endif
                                        <th>Jumlah Angsuran</th>
                                        <th>Tanggal Jatuh Tempo</th>
                                        <th>Status</th>
                                        <th>Tanggal Pembayaran</th>
                                    </tr>
                                </thead>
                                <tbody id="installmentTableBody">
                                    @foreach ($installments as $installment)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            @if (auth()->user()->role != 'anggota')
                                                <td>{{ $installment->loan->user->name }}</td>
                                            @endif
                                            <td>Rp{{ number_format($installment->jumlah, 2, ',', '.') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($installment->jatuh_tempo)->translatedFormat('d F Y') }}</td>
                                            <td>
                                                <span class="badge 
                                                    @if($installment->status == 'dibayar') bg-label-success
                                                    @elseif($installment->status == 'belum bayar') bg-label-warning 
                                                    @endif">
                                                    {{ ucfirst($installment->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($installment->status == 'dibayar')
                                                    {{ \Carbon\Carbon::parse($installment->updated_at)->translatedFormat('d F Y H:i') }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Inisialisasi flatpickr dengan locale Indonesia
        flatpickrRange = document.querySelector('#flatpickr-range');
        if (typeof flatpickrRange !== 'undefined') {
            flatpickrRange.flatpickr({
                mode: 'range',
                dateFormat: 'd F Y',
                locale: {
                    firstDayOfWeek: 1,
                    weekdays: {
                        shorthand: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                        longhand: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
                    },
                    months: {
                        shorthand: [
                            'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
                        ],
                        longhand: [
                            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                        ],
                    },
                }
            });
        }

        const searchInputs = {
            name: document.getElementById('searchName'),
            status: document.getElementById('searchStatus'),
            dateRange: flatpickrRange
        };

        const installmentTableBody = document.getElementById('installmentTableBody');
        const installments = installmentTableBody.getElementsByTagName('tr');

        Object.values(searchInputs).forEach(input => {
            input && input.addEventListener('input', function () {
                filterTable();
            });
        });

        function parseDate(dateString) {
            // Parsing string tanggal dengan bulan dalam bahasa Indonesia menjadi objek Date
            const [day, monthName, year] = dateString.split(' ');
            const months = {
                Januari: 0, Februari: 1, Maret: 2, April: 3, Mei: 4, Juni: 5,
                Juli: 6, Agustus: 7, September: 8, Oktober: 9, November: 10, Desember: 11
            };
            const month = months[monthName];
            return new Date(year, month, day);
        }

        function filterTable() {
            const dateRange = searchInputs.dateRange.value.split(' to ');
            for (let i = 0; i < installments.length; i++) {
                const installmentRow = installments[i];
                let show = true;

                if (searchInputs.name && searchInputs.name.value && !installmentRow.children[1].textContent.toLowerCase().includes(searchInputs.name.value.toLowerCase())) {
                    show = false;
                }
                if (searchInputs.status && searchInputs.status.value && !installmentRow.children[4].textContent.toLowerCase().includes(searchInputs.status.value.toLowerCase())) {
                    show = false;
                }
                if (dateRange.length === 2) {
                    const startDate = parseDate(dateRange[0]);
                    const endDate = parseDate(dateRange[1]);
                    const installmentDate = parseDate(installmentRow.children[3].textContent);

                    if (installmentDate < startDate || installmentDate > endDate) {
                        show = false;
                    }
                }

                installmentRow.style.display = show ? '' : 'none';
            }
        }
    });
</script>

@endsection
