<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Maaş Bordrosu - {{ \Carbon\Carbon::parse($salary->payment_date)->format('m/Y') }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 14px;
            color: #333;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: #1a56db;
            font-size: 24px;
        }
        .info-table, .salary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-table td {
            padding: 5px 0;
        }
        .info-table td:first-child {
            font-weight: bold;
            width: 30%;
        }
        .salary-table th, .salary-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .salary-table th {
            background-color: #f9fafb;
            font-weight: bold;
        }
        .total-row {
            font-weight: bold;
            background-color: #f3f4f6;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>BORDRO BİLGİ FİŞİ</h1>
        <p>Ödeme Dönemi: {{ \Carbon\Carbon::parse($salary->payment_date)->format('F Y') }}</p>
    </div>

    <table class="info-table">
        <tr>
            <td>Ad Soyad:</td>
            <td>{{ $salary->employee->first_name }} {{ $salary->employee->last_name }}</td>
        </tr>
        <tr>
            <td>Departman / Ünvan:</td>
            <td>{{ $salary->employee->department->name ?? '-' }} / {{ $salary->employee->position->name ?? '-' }}</td>
        </tr>
        <tr>
            <td>İşe Giriş Tarihi:</td>
            <td>{{ \Carbon\Carbon::parse($salary->employee->hire_date)->format('d.m.Y') }}</td>
        </tr>
    </table>

    <table class="salary-table">
        <thead>
            <tr>
                <th>Açıklama</th>
                <th style="text-align: right;">Tutar (TL)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Temel Maaş (Brüt)</td>
                <td style="text-align: right;">{{ number_format($salary->amount, 2) }} ₺</td>
            </tr>
            @if($salary->bonus > 0)
            <tr>
                <td>Prim / Ek Ödeme</td>
                <td style="text-align: right; color: green;">+ {{ number_format($salary->bonus, 2) }} ₺</td>
            </tr>
            @endif
            @if($salary->deduction > 0)
            <tr>
                <td>Kesintiler (Avans vs.)</td>
                <td style="text-align: right; color: red;">- {{ number_format($salary->deduction, 2) }} ₺</td>
            </tr>
            @endif
            <tr class="total-row">
                <td>Net Ödenen Tutar</td>
                <td style="text-align: right;">{{ number_format($salary->net_salary, 2) }} ₺</td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top: 50px;">
        <p>Yukarıda dökümü yapılan maaş ödemesi tarafıma eksiksiz olarak yapılmıştır.</p>
        <table style="width: 100%; margin-top: 30px;">
            <tr>
                <td style="text-align: center;">
                    <strong>Şirket Yetkilisi</strong><br>
                    İmza
                </td>
                <td style="text-align: center;">
                    <strong>Personel</strong><br>
                    İmza
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        Bu belge sistem tarafından otomatik oluşturulmuştur. <br>
        Oluşturulma Tarihi: {{ now()->format('d.m.Y H:i') }}
    </div>

</body>
</html>
