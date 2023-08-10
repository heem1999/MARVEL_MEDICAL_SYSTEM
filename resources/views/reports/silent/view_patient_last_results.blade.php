<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Patient Last Results</title>
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
    <h3 style="text-align: center;">Last Results of ( <b>{{ $patient_name }}</b> )</h3>

    <br>
    <table id="customers">
        <tr style="text-align: center">
            <th>Test Name</th>
            @foreach ($last_tests_results_header as $key => $last_tests_results_title)
                <th>{{ $key }}</th>
            @endforeach
        </tr>

        @foreach ($last_tests_results as $last_tests_results_test1)
            <tr>
                @foreach ($last_tests_results_test1 as $last_tests_results_test)
                    <td> {{ $last_tests_results_test->test->name_en }}
                    </td>
                @break
            @endforeach
            @foreach ($last_tests_results_test1 as $last_tests_results_test)
                <td> {{ $last_tests_results_test->result }}
                </td>
            @endforeach
        </tr>
    @endforeach

</table>

</body>

</html>
