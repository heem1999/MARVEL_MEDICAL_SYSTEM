<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-0">App Reviews
                    </h4>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered mg-b-0 text-md-nowrap">
                        <thead>
                            <tr style="text-align: center">
                                <th>#</th>
                                <th>Nmae</th>
                                <th>Star</th>
                                <th>Comment</th>
                                <th>Request Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <div wire:poll.visible>
                                @foreach ($users_reviews as $key => $user_review)
                                <tr style="text-align: center">
                                <td>{{$loop->iteration}}</td>
                                <td>{{ $user_review->appUser->name }}</td>
                                
                                <td>@for ($i = 1; $i <= 5; $i++) <i
                                    class="fas fa-star  {{$i <= $user_review->star ? 'text-warning ' : 'activeStar'}}">
                                    </i>
                                    @endfor</td>
                                <td>{{ $user_review->cmt }}</td>
                                <td>
                                    <a title="patient info." href="homeservices?booking_id={{ $user_review->booking_id  }}&pagename=registrationDetails" target="_blank"><i
                                class="text-danger fas fa-edit"></i> patient info.</a>
                                &nbsp;-&nbsp;
                                <a title="patient services" href="homeservices?booking_id={{ $user_review->booking_id  }}&pagename=servicesDetails" target="_blank"><i
                                    class="text-danger fas fa-info"></i> patient services</a>

                                </td>
                            </tr>
                            
                            @endforeach
                                 
                        </div>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>