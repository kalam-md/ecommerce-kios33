<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice #{{ $order->order_number }}</title>
    <style>
        @page {
            size: landscape;
            margin: 40px;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        
        .container {
            max-width: 100%;
        }
        
        .invoice-header {
            font-size: 16px;
            margin-bottom: 20px;
            color: #333;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        
        th {
            background-color: white;
            border: 1px solid #dee2e6;
            padding: 12px 8px;
            text-align: left;
            font-weight: normal;
            color: #333;
        }
        
        td {
            padding: 12px 8px;
            border: 1px solid #dee2e6;
        }
        
        .customer-info {
            margin-bottom: 20px;
            line-height: 1.6;
            float: left;
            width: 40%;
        }
        
        .customer-info div {
            margin-bottom: 5px;
        }
        
        .totals-section {
            float: right;
            width: 40%;
            margin-bottom: 30px;
        }
        
        .totals-table {
            width: 100%;
            margin-bottom: 0;
        }
        
        .totals-table td {
            border: none;
            padding: 5px 0;
        }
        
        .totals-table td:last-child {
            text-align: right;
        }
        
        .footer {
            clear: both;
            margin-top: 40px;
            color: #666;
            font-size: 13px;
            line-height: 1.6;
        }
        
        .gray-text {
            color: #666;
        }

        /* Memastikan alignment yang tepat untuk kolom harga */
        .price-column {
            text-align: center;
        }
        
        .quantity-column {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="invoice-header">
            Invoice : {{ $order->order_number }}
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>PRODUK</th>
                    <th>BERAT</th>
                    <th>HARGA</th>
                    <th>KUANTITAS</th>
                    <th>TOTAL HARGA</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->produk->nama_produk }}</td>
                    <td>{{ $item->produk->berat }} gram</td>
                    <td>Rp {{ number_format($item->price, 0, ',', '.') }}/{{ $item->produk->satuan }}</td>
                    <td>{{ $item->quantity }} Produk</td>
                    <td>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="customer-info">
            <div><span class="gray-text">Nama Pembeli:</span> {{ $order->user->nama_lengkap }}</div>
            <div><span class="gray-text">Nomor Telepon:</span> {{ $order->user->nomor_telepon }}</div>
            <div><span class="gray-text">Email:</span> {{ $order->user->email }}</div>
            <div><span class="gray-text">Alamat:</span> {{ $order->alamat }}</div>
        </div>

        <div class="totals-section">
            <table class="totals-table">
                <tr>
                    <td>Subtotal:</td>
                    <td class="price-column">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Tax:</td>
                    <td class="price-column">0%</td>
                </tr>
                <tr>
                    <td>Total:</td>
                    <td class="price-column">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <strong>Keterangan:</strong> Kami sangat menghargai kepercayaan Anda dengan berbelanja di tempat kami. Semoga produk yang Anda beli memberikan manfaat dan kepuasan. Jangan ragu untuk kembali dan melihat penawaran menarik lainnya.
        </div>
    </div>
</body>
</html>