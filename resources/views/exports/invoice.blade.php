<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 10;
            background-color: #f4f4f4;
        }

        .container {
            padding: 20px;
            margin: auto;
            width: 80%;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            position: relative;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header img {
            width: 100px;
            height: auto;
        }

        .header h1 {
            color: #1e3a8a;
            /* Tailwind CSS class text-blue-800 equivalent */
            margin: 0;
        }

        .invoice-title {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        .paid-stamp {
            position: absolute;
            top: 50%;
            left: 50%;
            font-size: 40px;
            color: red;
            transform: translate(-50%, -50%) rotate(-30deg);
            opacity: 0.5;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <x-application-logo class="block w-auto text-gray-800 fill-current h-9" />
            <h1>Pamsimas - Sanur Tirta Abadi</h1>
        </div>
        <div class="invoice-title">Invoice</div>
        <table>
            <tr>
                <th>No</th>
                <td>{{ $data['No'] }}</td>
            </tr>
            <tr>
                <th>Nama Pelanggan</th>
                <td>{{ $data['Nama Pelanggan'] }}</td>
            </tr>
            <tr>
                <th>No Pelanggan</th>
                <td>{{ $data['No Pelanggan'] }}</td>
            </tr>
            <tr>
                <th>Periode</th>
                <td>{{ $data['Periode'] }}</td>
            </tr>
            <tr>
                <th>Pemakaian</th>
                <td>{{ $data['Pemakaian'] }}</td>
            </tr>
            <tr>
                <th>Total</th>
                <td>{{ $data['Total'] }}</td>
            </tr>
            <tr>
                <th>Status Pembayaran</th>
                <td>{{ $data['Status Pembayaran'] }}</td>
            </tr>
            <tr>
                <th>Waktu Pembayaran</th>
                <td>{{ $data['Waktu Pembayaran'] }}</td>
            </tr>
        </table>
        @if ($data['Status Pembayaran'] == 'success')
            <div class="paid-stamp">LUNAS</div>
        @endif
    </div>
    <div class="footer">
        © {{ date('Y') }} Pamsimas - Sanur Tirta Abadi. All rights reserved.
    </div>
</body>

</html>
