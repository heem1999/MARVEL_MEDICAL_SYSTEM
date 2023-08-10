<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>sample ID's </title>
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

    <?php
    $i = 0;
    ?>
    @foreach ($registration_samples_barcodes as $registration_samples_barcode)
        @if ($i !== 0)
            <div class="page-break"></div>
        @endif
        <div >
            <div >

                <b>{{ $registration_samples_barcode->Processing_unit->name_en }}</b> -
                <b>{{ $registrations_details->acc }}</b> <br>
                <b>{{ $registrations_details->patient->patient_name }}</b>

            </div>
            <div >{!! DNS1D::getBarcodeHTML('4445645656', 'C128', 3, 40) !!}
                <b style="text-align: center;font-size: 1.5rem">{{ $registration_samples_barcode->sample_barcode }} -
                    ({{ $registrations_details->branch->code }})
                </b>
            </div>
        </div>
        <?php
        $i = 1;
        ?>
    @endforeach

    {{-- <div class="page-break"></div>
    <table id="customers">
        <tr>
            <th>Company</th>
            <th>Contact</th>
            <th>Country</th>
        </tr>
        <tr>
            <td>Alfreds Futterkiste</td>
            <td>Maria Anders</td>
            <td>Germany</td>
        </tr>
        <tr>
            <td>Berglunds snabbköp</td>
            <td>Christina Berglund</td>
            <td>Sweden</td>
        </tr>
    </table> --}}
</body>

</html>
