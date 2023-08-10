<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Financial Claim Brief</title>
    <style>
        #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #customers td,
        #customers th {
            border: 1px solid black;
            padding: 8px;
        }


        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            color: black;
        }

        #customers td {

            text-align: center;

        }

        /* basic header*/
        #patient_info {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #patient_info td,
        #patient_info th {
            border: none;
            padding: 8px;
        }

        #patient_info th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            color: black;
        }

        .page-break {
            page-break-after: always;
        }

    </style>
</head>

<body>
    <br>
    <h3 style="text-align: center;">Financial Claim Brief</h3>
    <br>
    <table id="patient_info">
        <tr>
            <th>Date from:</th>
            <td>{{ date('Y-m-d H:i:s', strtotime($dateFrom)) }} </td>
            <th>To:</th>
            <td>{{ date('Y-m-d H:i:s', strtotime($dateTo)) }}</td>
        </tr>
        <tr>
            <th>Payer:</th>
            <td>{{ $registration_details[0]->payer->name_en }}
            </td>
            <th>Contract:</th>
            <td>
                @if ($contract_id)
                    {{ $registration_details[0]->payer_contract->name_en }}
                @else
                    All
                @endif
            </td>
        </tr>
    </table>
    <br>
    <table id="customers">
        <tr>
            <th>No.</th>
            <th>Insurance ID's</th>
            <th>Patient Name(s)</th>
            <th>Total Amount</th>
            <th>Credit Share</th>
            <th>Visit Date</th>
        </tr>
        <?php
        $total_Insurance_credit = 0;
        $total_amount = 0;
        ?>    
        @foreach ($registration_details as $key => $registration_detail)
      
        <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $registration_detail->insurance_id }}</td>
                <td>{{ $registration_detail->patient->patient_name }}</td>
                <td>{{ number_format($registration_detail->total_Cash_Required + $registration_detail->total_Credit_Required) }}
                </td>
                <td>{{ number_format($registration_detail->total_Credit_Required) }}
                </td>
                <td>{{ date('Y-m-d ', strtotime($registration_detail->created_at)) }}</td>
            </tr>
            <?php
                    $total_Insurance_credit = $total_Insurance_credit + $registration_detail->total_Credit_Required;
                    $total_amount = $total_amount+$registration_detail->total_Cash_Required + $registration_detail->total_Credit_Required;
                    
                    ?>
        @endforeach
        <tr>
            <td colspan='3'><b> Totals :</b></td>
            <td><b>{{ number_format($total_amount) }}</b></td>
            <td><b>{{ number_format($total_Insurance_credit) }}</b></td>
        </tr>
    </table>

</body>

</html>
