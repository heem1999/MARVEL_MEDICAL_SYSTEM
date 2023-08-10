<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reprint Receipt number</title>
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
<div style="text-align: center;">
    <span style="float:left;"><h3 style="text-align: center;">{{ $company_infos->name_en }}</h3><h3 >{{ $branch->name_en }}</h3></span>
    <img style="vertical-align:middle" src="{{ 'data:image/png;base64,' .base64_encode(file_get_contents(public_path('assets/img/brand/LMS.png'))) }}" />
    <span style="float: right;"><h3 style="text-align: center;">{{ $company_infos->name_ar }}</h3><h3>{{ $branch->name_en }}</h3></span>
  </div>
  
    <h3 style="text-align: center;">Sales Receipt</h3>
    <br>
    <table id="patient_info">
        <tr>
            <th>Patient Name</th>
            <td>{{ $registration_details->patient->patient_name }} </td>
            <th>Patient No.</th>
            <td>{{ $registration_details->patient->patient_no }}</td>
        </tr>
        <tr>
            <th>ACC No.</th>
            <td>{{ $registration_details->acc }} </td>
            <th>Branch</th>
            <td>{{ $registration_details->branch->name_en }}</td>
        </tr>

        <tr>
            <th>Payer</th>
            <td>{{ $registration_details->payer->name_en }}</td>
            <th>Payer Contract</th>
            <td>{{ $registration_details->payer_contract->name_en }}</td>
        </tr>

        <tr>
            <th>Referring Doctor</th>
            <td>{{ $registration_details->referringDoctor->name_en }}</td>
            <th> </th>
            <td> </td>
        </tr>

    </table>
    <br>
    <br>

    <h3>Lab Service(s)</h3>
    <table id="customers">
        <thead>
            <tr>

                <th class="border-bottom-0">Service Code</th>
                <th class="border-bottom-0">Service</th>
                <th class="border-bottom-0">Price</th>
                <th class="border-bottom-0">Result Date</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $total_services_price1 = 0;
            $total_services_price_cash = 0;
            ?>
            @foreach ($patient_services as $key => $service)
                <tr>
                    <td> {{ $service['service']['code'] }}</td>
                    <td> {{ $service['service']['name_en'] }}</td>
                    <td> {{ number_format($service['current_price']) }}
                    </td>
                    <td> {{ $service['result_date'] }}</td>
                    <?php
                    $total_services_price1 = $total_services_price1 + $service['current_price'];
                    $total_services_price_cash = $total_services_price_cash + $service['service_price_cash'];
                    ?>
                </tr>
            @endforeach
            <tr>
                <td colspan='2'><b> Sub Total :</b></td>
                <td>{{ number_format($total_services_price1) }}</td>
            </tr>
        </tbody>

    </table>
    <br>

    <h3>Extra Service(s)</h3>
    <table id="customers">
        <thead>
            <tr>
                <th class="border-bottom-0">Service Code</th>
                <th class="border-bottom-0">Service</th>
                <th class="border-bottom-0">Price</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $total_extra_services_price = 0;
            ?>
            @foreach ($patient_extra_services as $key => $service)
                <tr>
                    <td> - </td>
                    <td> {{ $service['extra_service']['name_en'] }}
                    </td>
                    <td> {{ number_format($service['current_price']) }}
                    </td>
                    <?php
                    $total_extra_services_price = $total_extra_services_price + $service['current_price'];
                    ?>
                </tr>
            @endforeach
            <tr>
                <td colspan='2'><b>Sub Total :</b></td>
                <td>{{ number_format($total_extra_services_price) }}</td>
            </tr>
        </tbody>

    </table>
    <br>
    {{-- @if($registration_payment_transaction) --}}
    <h3>Payment Details</h3>
        <table id="customers">
            <thead>
                <tr>
                    <th class="border-bottom-0">Trans No.</th>
                    <th class="border-bottom-0">Payment Method</th>
                    <th class="border-bottom-0">Amount</th>
                    <th class="border-bottom-0">Transaction Date</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $total_pay = 0;
                ?>
                @foreach ($registration_payment_transaction as $key => $payment_transaction)
                    <tr>
                        <td> {{ $payment_transaction['id'] }}
                        </td>
                        <td> {{ $payment_transaction['payment_method'] }}
                        </td>
                        <td> {{ number_format($payment_transaction['amount']) }}
                        </td>
                        <td> {{ $payment_transaction['created_at'] }}
                        </td>
                        <?php
                        $total_pay = $total_pay + $payment_transaction['amount'];
                        ?>
                    </tr>
                @endforeach
                <tr>
                    <td colspan='2'><b>Total Payments :</b></td>
                    <td>{{ number_format($total_pay) }}</td>
                </tr>
            </tbody>
        </table>
    {{--@endif--}}
    <br>
    <hr>

    <table id="patient_info">
        <tr>
            <th>Total Amount Paid: </th>
            <td>{{ number_format($total_pay) }}</td>
            <th>Total Cash Required:</th>
            <td>{{ number_format($registration_details->total_Cash_Required) }}</td>
        </tr>
         {{--<tr colspan="2">
            <td><b>{{ $registration_details->time_to_receive_result }}</b></td>
        </tr>
        <tr>
            <th>Receipt Date</th>
            <td>{{ $registration_payment_transaction[0]['created_at'] }}</td>
        </tr> --}}

    </table>

    <h3 style="text-align: center;">{{ $registration_details->time_to_receive_result }}</h3>
</body>

</html>
