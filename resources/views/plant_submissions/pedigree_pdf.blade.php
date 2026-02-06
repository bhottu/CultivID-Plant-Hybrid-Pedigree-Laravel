<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pedigree Certificate</title>

    <style>
        @page {
    size: A4 landscape;
    margin: 0;
}
       body {
    margin: 0;
    padding: 0;
    font-family: DejaVu Sans;
    font-size: 12px;
    color: #1f2937;
}

        .certificate {
    margin: 10mm;
    padding: 25px;
   
    box-sizing: border-box;
    background: transparent;
}

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            height: 70px;
            margin-bottom: 10px;
            border-radius: 12px;
            
        }

        .title {
            font-size: 22px;
            font-weight: bold;
            letter-spacing: 2px;
            color: #14532d;
        }

        .subtitle {
            font-size: 18px;
            color: #4b5563;
            font-style: italic;
            text-decoration: underline;
            letter-spacing: 2px;
        }

        .info {
            margin: 20px 0;
           font-size: 13px;
        }

        .info table {
            width: 100%;
        }

        .info td {
            padding: 4px 0;
        }

        .pedigree {
            margin-top: 15px;
            border-collapse: collapse;
            width: 100%;
            text-align: center;
        }

        .pedigree td, .pedigree th {
            border: 1px solid #000000;
            padding: 5px;
        }

        .pedigree th {
            background: #c3fed0;
            font-size: 11px;
            color: #1b1a1a;
        }

        .child {
            background: #ffffff;
            font-weight: bold;
            font-style: italic;
            font-size: 13px;
        }

        .female {
            background: #ffffff;
            font-style: italic;
            font-size: 13px;
        }

        .male {
            background: #ffffff;
            font-style: italic;
            font-size: 13px;
        }

        .footer {
            margin-top: 25px;
            display: table;
            width: 100%;
        }

        .sign {
            display: table-cell;
            width: 33%;
            text-align: center;
            vertical-align: bottom;
        }

        .sign-line {
            margin-top: 20px;
            border-top: 1px solid #374151;
            display: inline-block;
            width: 80%;
            margin: 0 auto;
        }
        .sign-label {
            margin-top: 1px;
            font-size: 11px;
            color: #374151;
        }
        .signature-img {
            display: block;
            margin: 0 auto 3px auto;
            height: 60px;
        }
        .qr {
            text-align: center;
        }

        .level-title {
            font-size: 11px;
            color: #6b7280;
            background: #fef9c3;
        }
        /* BACKGROUND FULL BLEED */
        .bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 297mm;
            height: 210mm;
            z-index: -1;
        }
    </style>
</head>
<body>
<body>

<img class="bg" src="{{ public_path('certificate-bg.png') }}">

<div class="certificate">

    {{-- HEADER --}}
    <div class="header">
        {{-- Ganti path logo --}}
        <img src="{{ public_path('logo.png') }}">
        <div class="title">CERTIFICATE OF PEDIGREE</div>
        <div class="subtitle">{{ $plantSubmission->plant_id }}</div>
    </div>

    {{-- INFO --}}
    <div class="info">
        <table>
            <tr>
                <td><strong>Certificate No</strong></td>
                <td> {{ $certificateNumber }}</td>
                
                <td><strong>Breeder</strong></td>
                <td> {{ $plantSubmission->penyilang ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Issued Date</strong></td>
                <td> {{ optional($plantSubmission->certificate_issued_at)->format('d F Y') }}</td>
                <td><strong>Authorized by</strong></td>
                <td> www.cultiv.id | plant registry</td>
            </tr>
        </table>
    </div>

    {{-- PEDIGREE TABLE --}}
<table class="pedigree">
    <thead>
        <tr>
            <th>Parent</th>
            <th>Grandparents</th>
            <th>Great Grandparents</th>
        </tr>
    </thead>

    <tbody>
        {{-- PARENT BETINA --}}
        <tr>
            <td rowspan="4" class="female">
                ♀ {{ $pedigree['betina_node']['plant_id'] ?? '—' }}
            </td>

            <td rowspan="2" class="female">
                ♀ {{ $pedigree['betina_node']['betina_node']['plant_id'] ?? '—' }}
            </td>

            <td class="female">
                ♀ {{ $pedigree['betina_node']['betina_node']['betina_node']['plant_id'] ?? '—' }}
            </td>
        </tr>

        <tr>
            <td class="male">
                ♂ {{ $pedigree['betina_node']['betina_node']['jantan_node']['plant_id'] ?? '—' }}
            </td>
        </tr>

        <tr>
            <td rowspan="2" class="male">
                ♂ {{ $pedigree['betina_node']['jantan_node']['plant_id'] ?? '—' }}
            </td>

            <td class="female">
                ♀ {{ $pedigree['betina_node']['jantan_node']['betina_node']['plant_id'] ?? '—' }}
            </td>
        </tr>

        <tr>
            <td class="male">
                ♂ {{ $pedigree['betina_node']['jantan_node']['jantan_node']['plant_id'] ?? '—' }}
            </td>
        </tr>

        {{-- PARENT JANTAN --}}
        <tr>
            <td rowspan="4" class="male">
                ♂ {{ $pedigree['jantan_node']['plant_id'] ?? '—' }}
            </td>

            <td rowspan="2" class="female">
                ♀ {{ $pedigree['jantan_node']['betina_node']['plant_id'] ?? '—' }}
            </td>

            <td class="female">
                ♀ {{ $pedigree['jantan_node']['betina_node']['betina_node']['plant_id'] ?? '—' }}
            </td>
        </tr>

        <tr>
            <td class="male">
                ♂ {{ $pedigree['jantan_node']['betina_node']['jantan_node']['plant_id'] ?? '—' }}
            </td>
        </tr>

        <tr>
            <td rowspan="2" class="male">
                ♂ {{ $pedigree['jantan_node']['jantan_node']['plant_id'] ?? '—' }}
            </td>

            <td class="female">
                ♀ {{ $pedigree['jantan_node']['jantan_node']['betina_node']['plant_id'] ?? '—' }}
            </td>
        </tr>

        <tr>
            <td class="male">
                ♂ {{ $pedigree['jantan_node']['jantan_node']['jantan_node']['plant_id'] ?? '—' }}
            </td>
        </tr>
    </tbody>
</table>


    {{-- FOOTER --}}
    <div class="footer">
        <div class="sign">
            Breeder
            <div class="sign-line"></div>
        </div>

  <div class="sign">
    <img src="{{ public_path('signature.png') }}" class="signature-img">

    <div class="sign-line"></div>

    <div class="sign-label">
        Authorized Signature
    </div>
</div>


<div class="sign qr">
    <img src="{{ $qrPath }}" width="100">
    <div style="font-size:10px; margin-top:4px;">
        QR Verification
    </div>
</div>


    </div>

</div>

</body>
</html>
