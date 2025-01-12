<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .invoice-info {
            margin-bottom: 30px;
        }
        .invoice-info table {
            width: 100%;
        }
        .invoice-info td {
            padding: 5px;
            vertical-align: top;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .items-table th,
        .items-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .items-table th {
            background-color: #f5f5f5;
        }
        .totals {
            float: right;
            width: 300px;
        }
        .totals table {
            width: 100%;
        }
        .totals td {
            padding: 5px;
        }
        .totals .total {
            font-weight: bold;
            font-size: 16px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>INVOICE</h1>
            <h2>{{ $invoice->invoice_number }}</h2>
        </div>

        <div class="invoice-info">
            <table>
                <tr>
                    <td width="50%">
                        <strong>From:</strong><br>
                        Your Company Name<br>
                        123 Business Street<br>
                        Business City, 12345<br>
                        contact@yourcompany.com<br>
                        +1 234 567 890
                    </td>
                    <td width="50%">
                        <strong>To:</strong><br>
                        {{ $invoice->customer->name }}<br>
                        {{ $invoice->billing_street }}<br>
                        {{ $invoice->billing_city }}, {{ $invoice->billing_postal_code }}<br>
                        {{ $invoice->billing_state }}, {{ $invoice->billing_country }}<br>
                        {{ $invoice->customer->email }}
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Invoice Date:</strong> {{ $invoice->created_at->format('d/m/Y') }}<br>
                        <strong>Due Date:</strong> {{ $invoice->due_date->format('d/m/Y') }}
                    </td>
                    <td>
                        <strong>Order Number:</strong> {{ $invoice->order->order_number }}<br>
                        <strong>Status:</strong> {{ ucfirst($invoice->status) }}
                    </td>
                </tr>
            </table>
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $item)
                <tr>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>€{{ number_format($item->unit_price, 2) }}</td>
                    <td>€{{ number_format($item->total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <table>
                <tr>
                    <td>Subtotal:</td>
                    <td align="right">€{{ number_format($invoice->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td>Tax (20%):</td>
                    <td align="right">€{{ number_format($invoice->tax, 2) }}</td>
                </tr>
                <tr class="total">
                    <td>Total:</td>
                    <td align="right">€{{ number_format($invoice->total, 2) }}</td>
                </tr>
            </table>
        </div>

        <div style="clear: both;"></div>

        <div class="footer">
            @if($invoice->payment_terms)
            <p><strong>Payment Terms:</strong> {{ $invoice->payment_terms }}</p>
            @endif

            @if($invoice->notes)
            <p><strong>Notes:</strong> {{ $invoice->notes }}</p>
            @endif

            <p>Thank you for your business!</p>
        </div>
    </div>
</body>
</html>
