<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Patient result</title>
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

    {{-- all tests types result --}}
    <?php
    $i = 0;
    ?>
    @foreach ($patient_services_final as $key => $xx)
    @if ($i !== 0)
    <div class="page-break"></div>
    @endif
    <br>
    <div style="text-align: center;">
        <span style="float:left;"><h3 style="text-align: center;">{{ $company_infos->name_en }}</h3><h3 >{{ $branch->name_en }}</h3></span>
        <img style="vertical-align:middle" src="{{ 'data:image/png;base64,' .base64_encode(file_get_contents(public_path('assets/img/brand/LMS.png'))) }}" />
        <span style="float: right;"><h3 style="text-align: center;">{{ $company_infos->name_ar }}</h3><h3>{{ $branch->name_en }}</h3></span>
      </div>
      
    <table id="patient_info">
        <tr>
            <th>Patient Name</th>
            <td>{{ $registrations_details->patient->patient_name }} </td>
            <th>Patient No.</th>
            <td>{{ $registrations_details->patient->patient_no }}</td>
        </tr>
        <tr>
            <th>ACC No.</th>
            <td>{{ $registrations_details->acc }} </td>
            <th>Patient Sex</th>
            <td>{{ $registrations_details->patient->gender }}</td>
        </tr>
        <tr>
            <th>Age</th>
            <td>{{ $registrations_details->patient->age_y }} Year</td>
            <th>Patient Mobile</th>
            <td>{{ $registrations_details->patient->phone }}</td>
        </tr>
        <tr>
            <th>Payer</th>
            <td>{{ $registrations_details->payer->name_en }}</td>
            <th>Branch</th>
            <td>{{ $registrations_details->branch->name_en }}</td>
        </tr>

        <tr>
            <th>Sample Date</th>
            <td>{{ $registrations_details->payer->name_en }}</td>
            <th>Report Date</th>
            <td>{{ $registrations_details->branch->name_en }}</td>
        </tr>

        <tr>
            <th>Referring Doctor</th>
            <td>{{ $registrations_details->referringDoctor->name_en }}</td>
            <th> </th>
            <td> </td>
        </tr>
    </table>
    <br>
    <h3 style="text-align: center;">{{ $key }}</h3>

    <table id="customers">
        <thead>
            <th>Test</th>
            <th>Result</th>
            <th>Unit</th>
            <th>Ref. Rang</th>
        </thead>
        @foreach ($patient_services_final[$key] as $patient_test)
        <tr>
            <td>{{ $patient_test['service_tests'][0]['test']['name_en'] }}
                <br>
            </td>
            <td>{{ $patient_test['service_tests'][0]['result'] }}
                @if ($patient_test['service_tests'][0]['result'] < $patient_test['service_tests'][0]['from'])
                    &nbsp;&nbsp;<b style="color: red">L</b>
                    @elseif($patient_test['service_tests'][0]['result'] > $patient_test['service_tests'][0]['to'])
                    &nbsp;&nbsp;<b style="color: red">H</b>
                    @endif
            </td>
            <td>{{ $patient_test['service_tests'][0]['unit'] }}</td>
            <td>{{ $patient_test['service_tests'][0]['from'] }} -
                {{ $patient_test['service_tests'][0]['to'] }}
            </td>
        </tr>
        @endforeach
    </table>
    {{-- Comments --}}
    <p><b>Comments:</b>
        @foreach ($patient_services_final[$key] as $patient_test)
        @if ($patient_test['service_tests'][0]['test_comment'] && $patient_test['service_tests'][0]['test_comment_type']
        == 'Result')
        <br> - {{ $patient_test['service_tests'][0]['test_comment'] }}
        @endif
        @endforeach
    </p>
    <?php
        $i = 1;
        ?>
    <br>
    <div style=" position: relative;float: right; padding-left: 10px;">
        <b style="text-align: right;">Reviewed By:
        </b>
        @foreach ($patient_services_final[$key] as $patient_test)
        <div height="66" width="132">
            @if ($patient_test['service_tests'][0]['reviewed_name']['signature'])
            <img height="66" width="132"
                src="{{ 'data:image/png;base64,' .base64_encode(file_get_contents(public_path($patient_test['service_tests'][0]['reviewed_name']['signature']))) }}" />
@endif
        </div>
        {{ $patient_test['service_tests'][0]['reviewed_name']['titile'] }}
        {{ $patient_test['service_tests'][0]['reviewed_name']['full_name'] }}
        @break
        @endforeach
    </div>
    @endforeach


    {{-- cultuer tests types result only --}}

    <?php
$j = 0;
?>
    @foreach ($Culture_tests as $key => $Culture_test)
    @if ($j !== 0 || $i == 1)
    <div class="page-break"></div>
    @endif

    <table id="patient_info">
        <tr>
            <th>Patient Name</th>
            <td>{{ $registrations_details->patient->patient_name }} </td>
            <th>Patient No.</th>
            <td>{{ $registrations_details->patient->patient_no }}</td>
        </tr>
        <tr>
            <th>ACC No.</th>
            <td>{{ $registrations_details->acc }} </td>
            <th>Patient Sex</th>
            <td>{{ $registrations_details->patient->gender }}</td>
        </tr>
        <tr>
            <th>Age</th>
            <td>{{ $registrations_details->patient->age_y }} Year</td>
            <th>Patient Mobile</th>
            <td>{{ $registrations_details->patient->phone }}</td>
        </tr>
        <tr>
            <th>Payer</th>
            <td>{{ $registrations_details->payer->name_en }}</td>
            <th>Branch</th>
            <td>{{ $registrations_details->branch->name_en }}</td>
        </tr>

        <tr>
            <th>Sample Date</th>
            <td>{{ $registrations_details->created_at }}</td>
            <th>Report Date</th>
            <td>{{ $registrations_details->created_at }}</td>
        </tr>

    </table>
    <br>
    <h3 style="text-align: center;">({{ $j+1 }}) {{ $Culture_test->test->name_en }}</h3>
    <h4 style="text-align: center;">Modifier:
        @foreach ( $result_clutuer_tests->where('rsbst_id', $Culture_test->id) as $key => $result_clutuer_test)
        ( {{ $result_clutuer_test->modifier }} )
        @endforeach
    </h4>

    <table id="customers">
        <thead>
            <tr style="text-align: center">
                <th>Organism</th>
                <th>Sensitivity</th>
                <th>Antibiotic</th>
            </tr>
        </thead>
        @foreach ($result_clutuer_tests->where('rsbst_id', $Culture_test->id) as $key => $result_clutuer_test)
        @foreach ($result_clutuer_org_antis->where('rct_org_id', $result_clutuer_test->id) as $antibiotic)
        <tr style="text-align: center">
            <td>{{ $result_clutuer_test->organism->name_en }}</td>
            <td>{{ $antibiotic->sensitivity }}</td>
            <td>{{ $antibiotic->antibiotic->name_en }}</td>
        </tr>
        @endforeach
        @endforeach
    </table>
    {{-- Comments
    <p><b>Comments:</b>
        @foreach ($patient_services_final[$key] as $patient_test)
        @if ($patient_test['service_tests'][0]['test_comment'] && $patient_test['service_tests'][0]['test_comment_type']
        == 'Result')
        <br> - {{ $patient_test['service_tests'][0]['test_comment'] }}
        @endif
        @endforeach
    </p> --}}

    <br>
    <div style=" position: relative;float: right; padding-left: 10px;">
        <b style="text-align: right;">Reviewed By:
        </b>
        <div height="66" width="132">
            @if ($Culture_test->reviewed_name->signature)
            <img height="66" width="132"
            src="{{ 'data:image/png;base64,' .base64_encode(file_get_contents(public_path($Culture_test->reviewed_name->signature))) }}" />
            @endif
           

        </div>
        {{ $Culture_test->reviewed_name->titile }}
        {{ $Culture_test->reviewed_name->full_name }}

    </div>
    <?php
    $j++;
    ?>
    @endforeach

    {{-- <div class="page-break"></div> --}}

</body>

</html>