<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>KOKtons® Receipts</title>
    <style>
    
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px; 
            background: #f5f5f5; 
        }
        .receipt {
            border: 1px solid #333;
            border-radius: 40px; 
            padding: 25px;
            margin-bottom: 30px;
            width: 650px; 
            background: white;
            position: relative;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1); 
        }

        .receipt-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }
        .company-logo img {
            max-height: 60px; 
        }
        .barcode {
            text-align: center;
            margin-right: 50px;
        }
        .barcode-number {
            font-size: 12px;
            margin-top: 2px;
            letter-spacing: 0.5px;
            font-weight: bold;
        }

        .product-info {
            display: flex;
            justify-content: space-between;
            font-size: 20px;
            font-weight: 600; 
            margin-bottom: 20px;
        }
        .product-info .column p {
            margin: 4px 0;
        }
        .product-info .column strong {
            display: inline-block;
            width: 70px;
        }

        .company-details {
            margin-top: 15px;
            font-size: 24px;
        
        }

        .company-details p {
            margin: 3px 0;
        }

        .print-btn {
            margin-bottom: 20px;
            padding: 10px 20px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
        }

        @media print {
            .print-btn { display: none; }
            body { background: white; }
            .receipt { box-shadow: none; page-break-inside: avoid; margin-bottom: 20px; }
        }
    </style>
</head>
<body>

<button onclick="window.print()" class="print-btn">Print</button>

@php
    $companyName = App\Model\Meta::where('meta_name', 'receipt_company_name')->value('meta_value') ?? 'KOXTONS SPORTS EQUIPMENTS (P) LIMITED';
    $companyAddress = App\Model\Meta::where('meta_name', 'receipt_address')->value('meta_value') ?? '3/11, Mohkampur Industrial Area, Phase-I, Delhi Road, Meerut-250002 (UP), India';
    $customerCare = App\Model\Meta::where('meta_name', 'customer_care')->value('meta_value') ?? '0121-2528994';
    $companyEmail = App\Model\Meta::where('meta_name', 'company_email')->value('meta_value') ?? 'sales@koktons.com';
    $companyLogo = App\Model\Meta::where('meta_name', 'company_logo')->value('meta_value');
    $logoPath = $companyLogo ? asset('public/' . public_file() . $companyLogo) : null;
@endphp

@foreach($receipts as $mrp)
<div class="receipt">
    <div class="receipt-header">
        <div class="company-logo">
            @if($logoPath)
                <img src="{{ $logoPath }}" alt="Company Logo">
            @endif
        </div>
        <div class="barcode">
            {!! DNS1D::getBarcodeHTML($mrp->barcode, 'C128', 1.5, 50) !!}
            <div class="barcode-number">{{ $mrp->barcode }}</div>
        </div>
    </div>
    <div class="product-info" style="display:flex; justify-content: space-between; font-family: monospace; font-size:22px; font-weight:600;">
        <!-- Left Column -->
        <div>
            <div><span style="display:inline-block; width:8ch;">ITEM</span>: {{ $mrp->item_name }}</div>
            <div><span style="display:inline-block; width:8ch;">MODEL</span>: {{ $mrp->model }}</div>
            <div><span style="display:inline-block; width:8ch;">QTY</span>: {{ $mrp->qty }} {{ $mrp->qty_metric }}</div>
        </div>

        <!-- Right Column -->
        <div>
            <div><span style="display:inline-block; width:8ch;">CODE</span>: {{ $mrp->code }}</div>
            <div><span style="display:inline-block; width:8ch;">MFG</span>: {{ $mrp->mfg_date ? \Carbon\Carbon::parse($mrp->mfg_date)->format('M. Y') : '-' }}</div>
            <div><span style="display:inline-block; width:8ch;">MRP</span>: ₹{{ $mrp->mrp }}</div>
            <div style="text-align:right; font-weight:600 !important; font-size:12px !important;">(Incl. all taxes.)</div>
        </div>
    </div>

    <div class="company-details">
        <p style="font-weight:600;">Manufactured & Marketed by:</p>
       <p style="font-size: 26px !important; font-weight: 1000; text-decoration: underline; margin-top: -5px;">
            <strong>{{ $companyName }}</strong>
        </p>


        <p style="font-weight:600;">{{ $companyAddress }}</p>
        <p style="font-weight:600;">Customer Care: {{ $customerCare }}, {{ $companyEmail }}</p>
    </div>
</div>
@endforeach

</body>
</html>
