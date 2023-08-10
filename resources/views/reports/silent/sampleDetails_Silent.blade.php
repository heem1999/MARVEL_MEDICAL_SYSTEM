<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>samples details </title>
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
            <th>Sample Date</th>
            <td>{{ $sample_date }} </td>
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
            <th>Referring Doctor</th>
            <td>{{ $registrations_details->referringDoctor->name_en }}</td>
            <th> </th>
            <td> </td>
        </tr>
    </table>
    <br>
    <h3 style="text-align: center;">Sampling Details</h3>
    <table id="customers">
        <tr>
            <th>Sample ID(s)</th>
            <th>Service Name</th>
            <th>status</th>
        </tr>

        @foreach ($registration_samples_barcodes as $registration_samples_barcode)
            <tr>
                <td
                    rowspan="{{ $registration_samples_barcode_services->where('samples_barcode_id', $registration_samples_barcode->id)->count() }}">
                    {{ $registration_samples_barcode->sample_barcode }}</td>
                <?php
                $key_already_printed = 0;
                ?>
                @foreach ($registration_samples_barcode_services as $key1 => $registration_samples_barcode_service)
                    @if ($registration_samples_barcode_service->samples_barcode_id == $registration_samples_barcode->id)
                        @if ($registration_samples_barcode_service->service_status == 'Reserved')
                            <td style="background-color: silver">
                                {{ $registration_samples_barcode_service->service->name_en }}</td>
                            <td style="background-color: silver">
                                {{ $registration_samples_barcode_service->service_status }}</td>
                        @else
                            <td> {{ $registration_samples_barcode_service->service->name_en }}</td>
                            <td>{{ $registration_samples_barcode_service->service_status }}</td>
                        @endif
                        <?php
                        $key_already_printed = $key1;
                        ?>
                    @break
                @endif
            @endforeach
        </tr>

        @foreach ($registration_samples_barcode_services as $key => $registration_samples_barcode_service)
            @if ($key !== $key_already_printed && $registration_samples_barcode_service->samples_barcode_id == $registration_samples_barcode->id)
                <tr>
                    @if ($registration_samples_barcode_service->service_status == 'Reserved')
                        <td style="background-color: silver">
                            {{ $registration_samples_barcode_service->service->name_en }}</td>
                        <td style="background-color: silver">
                            {{ $registration_samples_barcode_service->service_status }}</td>
                    @else
                        <td> {{ $registration_samples_barcode_service->service->name_en }}</td>
                        <td>{{ $registration_samples_barcode_service->service_status }}</td>
                    @endif

                </tr>
            @endif
        @endforeach
    @endforeach

</table>

</body>

</html>
