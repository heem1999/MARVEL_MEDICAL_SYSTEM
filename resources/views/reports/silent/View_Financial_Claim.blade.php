<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Financial Claim Details</title>
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
    <h3 style="text-align: center;">Financial Claim Details</h3>
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
            <th>Acc.No.</th>
            <th>Patient Name(s)</th>
            <th>Service</th>
            <th>Branch</th>
            <th>Visit Date</th>
            <th>Insurance ID's</th>
            <th>Service Price</th>
            <th>Patient Share</th>
            <th>credit Share</th>
            <th>Payer Should Pay</th>
        </tr>
        <?php
        $total_Insurance_credit1 = 0;
        $total_Patient_cash1 = 0;
        $total_Payer_should_pay = 0;
        ?>
        @foreach ($registration_details as $registration_detail)
            <?php
            $total_Insurance_credit = 0;
            $total_Patient_cash = 0;
            ?>
            @foreach ($registered_serv_prices->where('acc', $registration_detail->acc) as $registered_serv_price)
                <tr>
                    <td>{{ $registration_detail->acc }}</td>
                    <td>{{ $registration_detail->patient->patient_name }}</td>
                    <td>{{ $registered_serv_price->service->name_en }}</td>
                    <td>{{ $registration_detail->branch->name_en }}</td>
                    <td>{{ $registration_detail->created_at }}</td>
                    @if ($registration_detail->insurance_id)
                        <td>{{ $registration_detail->insurance_id }}</td>
                    @else
                        <td>-</td>
                    @endif

                    <td>{{ number_format($registered_serv_price->current_price) }}
                    </td>
                    <td>{{ number_format($registered_serv_price->service_price_cash) }}
                    </td>
                    <td>{{ number_format($registered_serv_price->service_price_credit) }}
                    </td>
                    <?php
                    $total_Insurance_credit = $total_Insurance_credit + $registered_serv_price->service_price_credit;
                    $total_Patient_cash = $total_Patient_cash + $registered_serv_price->service_price_cash;
                    
                    ?>

                </tr>
            @endforeach
            <tr>
                <td colspan='7'><b> Total required for the patient :</b></td>
                <td><b>{{ number_format($total_Patient_cash) }}</b></td>
                <td><b>{{ number_format($total_Insurance_credit) }}</b></td>
                <td><b>{{ number_format($total_Insurance_credit) }}</b></td>
            </tr>
            <?php
            $total_Insurance_credit1 = $total_Insurance_credit1 + $total_Insurance_credit;
            $total_Patient_cash1 = $total_Patient_cash1 + $total_Patient_cash;
            ?>
        @endforeach
        <tr>
            <td colspan='7'><b> Totals :</b></td>
            <td><b>{{ number_format($total_Patient_cash1) }}</b></td>
            <td><b>{{ number_format($total_Insurance_credit1) }}</b></td>
            <td><b>{{ number_format($total_Insurance_credit1) }}</b></td>
        </tr>
    </table>

</body>

</html>
