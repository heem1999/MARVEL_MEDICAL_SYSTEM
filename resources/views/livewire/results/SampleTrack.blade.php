<div class="row row-sm">
    <div class="col-xl-12">
        <!-- div -->
        <div class="card mg-b-20" id="tabs-style2">
            <div class="text-wrap">
                <div class="example">
                    <div class="panel panel-primary tabs-style-2">
                        <div class=" tab-menu-heading">
                            <div class="tabs-menu1">
                                <!-- Tabs -->
                                <ul class="nav panel-tabs main-nav-line">
                                    <li><a href="#tab1" class="nav-link active" data-toggle="tab">Sample Details</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body tabs-menu-body main-content-body-right border">
                            <div class="tab-content">
                               
                                <!-- if have enter right acc no -->
                                @if ($SampleTrack_data)
                                    <div class="tab-pane active" id="tab1">
                                        <div id="SampleDetails">
                                            <div style="width: 100%; height: 20px; border-bottom: 1px solid black; text-align: center">
                                                <span style="font-size: 15px; background-color: #F3F5F6; padding: 0 10px;">
                                                    Patient Details
                                                </span>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col">
                                                    <label for="inputName" class="control-label">Patient Name:
                                                    </label>
                                                    <b id="patient_name"> {{ $SampleTrack_data['registrations_details']->patient->patient_name }}</b>
                                                </div>
                
                                                <div class="col">
                                                    <label for="inputName" class="control-label">Acc No.:
                                                    </label>
                                                    <b id="acc">{{ $SampleTrack_data['registrations_details']->acc }}</b>
                                                </div>
                                                <div class="col">
                                                    <label for="inputName" class="control-label">Patient Number 
                                                    </label>
                                                    <b id="registrationDate">{{ $SampleTrack_data['registrations_details']->patient->patient_no }}</b>
                                                </div>
                                            </div>
                                        </div>
                
                                        <div id="SampleServices">
                                            <br> <br>
                                            <div style="width: 100%; height: 20px; border-bottom: 1px solid black; text-align: center">
                                                <span style="font-size: 15px; background-color: #F3F5F6; padding: 0 10px;">
                                                    Sample Services
                                                </span>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col">
                                                    @foreach ($SampleTrack_data['samples_services'] as $service)
                                                    <li>{{ $service }}</li>
                                                @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div id="SampleServices">
                                            <br> <br>
                                            <div style="width: 100%; height: 20px; border-bottom: 1px solid black; text-align: center">
                                                <span style="font-size: 15px; background-color: #F3F5F6; padding: 0 10px;">
                                                    Sample Track ( {{ $SampleTrack_data['sample_barcode'] }} )
                                                </span>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col">
                                                    <table class="table table-bordered mg-b-0 text-md-nowrap table-hover">
                                                        <thead>
                                                            <tr style="text-align: center">
                                                                <th>Location</th>
                                                                <th>Sample Status</th>
                                                                <th>Date/Time</th>
                                                                <th>User</th>
                                                                <th>Time Period</th>
                                                                <th>Processing Unit</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($SampleTrack_data['sample_traking_transactions'] as $sample)
                                                            <tr style="text-align: center">
                                                            @if ($sample->location_id==0&&$sample->analyzer_id==0)
                                                            <td>Registration</td>
                                                            @elseif ($sample->analyzer_id>0)
                                                            <td>Auto</td>
                                                            @else
                                                            <td>{{ $sample->location->name_en }}</td>
                                                            @endif
                                                            <td>{{ $sample->sample_status }}</td>
                                                            <td>{{ $sample->created_at }}</td>
                                                            <td>
                                                                @if ($sample->Created_by>0)
                                                                {{ $sample->user->name }}
                                                                @elseif ($sample->analyzer_id>0)
                                                                {{ $sample->analyzer->name_en }}   
                                                                @endif
                                                            </td>
                                                            <td>{{ $SampleTrack_data['sample_traking_transactions'][0]['created_at']->diffInMinutes($sample->created_at)
}} Min</td>
                                                            <td>{{ $SampleTrack_data['sample_traking_transactions'][0]['sample']['processing_unit']['name_en']}}</td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                     
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>



    </div>
</div>
