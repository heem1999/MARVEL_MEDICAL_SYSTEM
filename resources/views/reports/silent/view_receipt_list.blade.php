<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Receipt List</title>
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
    <h3 style="text-align: center;">Receipt List</h3>
    <br>
    <table id="patient_info">
        <tr>
            <th>Date from:</th>
            <td>{{ date('Y-m-d H:i:s', strtotime($dateFrom)) }} </td>
            <th>To:</th>
            <td>{{ date('Y-m-d H:i:s', strtotime($dateTo)) }}</td>
        </tr>
    </table>
    <br>
    @foreach ($registration_payment_transaction as $key => $payment_transaction)
        <b>Payment Method:</b> {{ $key }}
        <table id="customers">
            <tr>
                <th>Branch</th>
                <th>ACC No.</th>
                <th>Patient Name</th>
                <th>Trans. Date</th>
                <th>Total Amount</th>
                <th>Payment</th>
                <th>Refund</th>
                <th>Reg. by</th>
            </tr>
            <?php
            $total_Payments = 0;
            $total_Refunds = 0;
            ?>
            @foreach ($payment_transaction as $transaction)
                <tr>
                    <td> {{ $registrations_details_all->Where('acc', $transaction->acc)->first()->branch->name_en }}
                    </td>
                    <td> {{ $transaction->acc }} </td>
                    <td>{{ $registrations_details_all->Where('acc', $transaction->acc)->first()->patient->patient_name }}
                    </td>
                    <td>{{ $transaction->created_at }} </td>
                    <td>{{ number_format($registrations_details_all->Where('acc', $transaction->acc)->first()->total_Cash_Required) }}
                    </td>
                    @if ($transaction->transaction_type == 'Payment')
                        <td>{{ number_format($transaction->amount) }} </td>
                        <?php
                        $total_Payments = $total_Payments + $transaction->amount;
                        ?>
                    @else
                        <td>0.0</td>
                    @endif
                    @if ($transaction->transaction_type == 'Refund')
                        <td>{{ number_format($transaction->amount) }} </td>
                        <?php
                        $total_Refunds = $total_Refunds + $transaction->amount;
                        ?>
                    @else
                        <td>0.0</td>
                    @endif
                    <td>{{ $registrations_details_all->Where('acc', $transaction->acc)->first()->user->full_name }}
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan='5'><b> Total :</b></td>
                <td>{{ number_format($total_Payments) }}</td>
                <td>{{ number_format($total_Refunds) }}</td>
            </tr>
            <tr>
                <td colspan='5'><b> Total Net Payments:</b></td>
                <td colspan='2'>{{ number_format($total_Payments - $total_Refunds) }}</td>
            </tr>
        </table>
        <br>


        <br><br>
    @endforeach
</body>

</html>
