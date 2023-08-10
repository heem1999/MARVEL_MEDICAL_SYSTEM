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
    <br>
    <br>
    <div style="text-align: center;">
        <span style="float:left;"><h3 style="text-align: center; font-family:Tahoma">{{ $company_infos->name_en }}</h3></span>
        <img style="vertical-align:middle" src="{{ 'data:image/png;base64,' .base64_encode(file_get_contents(public_path('assets/img/brand/LMS.png'))) }}" />
        <span style="float: right; "><h3 style="text-align: center;font-family:Tahoma">{{ $company_infos->name_ar }}</h3></span>
    </div>
    
    <u><h3 style="text-align: right;font-family:Tahoma ">{{ $dateFrom }} / التاريخ</h3></u>
    <br>
    <u><h2 style="text-align: center; font-size: 1.5rem;font-family:Tahoma ">{{ $title }}</h2></u>
      
    <div style="text-align: right;">
        <pre style="font-size: 1.5rem;font-family:Tahoma ">{{ $content }}</pre>
    </div>
</body>

</html>