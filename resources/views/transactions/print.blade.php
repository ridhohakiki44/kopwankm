<!DOCTYPE html>
<html>
<head>
    <!-- Title -->
    <title>Kopwan - KM</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap" rel="stylesheet" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('backend/assets/vendor/css/rtl/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('backend/assets/css/demo.css') }}" />
</head>
<body>
    <div class="text-center mt-3">
        <h3>Laporan Keuangan Kopwan - KM</h3>
        <h5>{{ \Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}</h5>
    </div>
    <div class="text-nowrap">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Uraian</th>
                    <th>Debit</th>
                    <th>Kredit</th>
                    <th>Saldo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ \Carbon\Carbon::parse($transaction->date)->translatedFormat('d F Y') }}</td>
                        <td>{{ $transaction->description }}</td>
                        <td>
                            @if ($transaction->debit)
                                Rp{{ number_format($transaction->debit, 2, ',', '.') }}
                            @endif
                        </td>
                        <td>
                            @if ($transaction->credit)
                                Rp{{ number_format($transaction->credit, 2, ',', '.') }}
                            @endif
                        </td>
                        <td>Rp{{ number_format($transaction->balance, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
