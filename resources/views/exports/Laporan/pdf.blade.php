<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Laporan</title>
    <style>
        /* Gaya CSS Anda bisa ditambahkan di sini */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h2>Laporan Tagihan</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pelanggan</th>
                <th>No Pelanggan</th>
                <th>Periode</th>
                <th>Pemakaian</th>
                <th>Total</th>
                <th>Status Pembayaran</th>
                <th>Waktu Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr>
                    <td>{{ $row['No'] }}</td>
                    <td>{{ $row['Nama Pelanggan'] }}</td>
                    <td>{{ $row['No Pelanggan'] }}</td>
                    <td>{{ $row['Periode'] }}</td>
                    <td>{{ $row['Pemakaian'] }}</td>
                    <td>{{ $row['Total'] }}</td>
                    <td>{{ $row['Status Pembayaran'] }}</td>
                    <td>{{ $row['Waktu Pembayaran'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
