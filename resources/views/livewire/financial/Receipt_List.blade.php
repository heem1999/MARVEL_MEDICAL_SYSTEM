<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-0">Search Criteria
                    </h4>
                </div>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if (session()->has('Error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session()->get('Error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="row">
                 
                    <div class="col">
                        <label for="inputName" class="control-label">Reg. Branch:</label>
                        <select wire:model="selectedbranchid" class="form-control">
                            <option value="" selected>
                                -- Select branch --
                            </option>
                            @foreach ($branches as $branche)
                                <option value="{{ $branche->id }}">
                                    {{ $branche->name_en }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <label  for="inputName" class="control-label">Transaction Date From: <b
                                class="text-danger fas" >*</b></label>
                        <div class="input-group ">
                            <input class="form-control" format="YYYY-MM-DD" min="2022-01-01T08:30"
                                type="datetime-local" wire:model="dateFrom" required>
                        </div>
                    </div>
                    <div class="col">
                        <label for="inputName" class="control-label">Transaction Date To: <b
                                class="text-danger fas">*</b></label>
                        <div class="input-group ">
                            <input class="form-control" format="YYYY-MM-DD" min="2022-01-01T08:30"
                                type="datetime-local" wire:model="dateTo" required>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <label for="inputName" class="control-label">Created by:</label>
                        <select wire:model="selected_user_id" class="form-control">
                            <option value="" selected>
                                -- Select user --
                            </option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col">
                        <label for="inputName" class="control-label">Payment Method:</label>
                        <select wire:model.lazy="payment_method" class="form-control ">
                            <option value="" selected>
                                All
                            </option>
                            <option value="Cash">
                                Cash
                            </option>
                            <option value="Bank">
                                Bank
                            </option>
                        </select>
                    </div>
                    <div class="col">
                        <label for="inputName" class="control-label">Transaction Type:</label>
                        <select wire:model.lazy="transaction_type" class="form-control ">
                            <option value="" selected>
                                All
                            </option>
                            <option value="Payment">
                                Payment
                            </option>
                            <option value="Refund">
                                Refund
                            </option>
                        </select>
                    </div>
                </div>

                <br>
                <div class="d-flex justify-content-center">
                    <div wire:loading wire:target="View_Receipt_List">
                        loading ...
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <a
                    href="View_Receipt_List?payment_method={{ $payment_method }}&transaction_type={{ $transaction_type }}&branch_id={{ $selectedbranchid }}&selected_user_id={{ $selected_user_id }}&dateFrom={{ $dateFrom }}&dateTo={{ $dateTo }}"
                    onclick="var popup =window.open(this.href, 'mywin',
            'left=20,top=20,width=900,height=700'); return false; "> <button class="btn btn-primary">
                              View</button></a>&nbsp;&nbsp;
                    <button type="button" class="btn btn-danger" wire:click="mount">Rest</button>
                </div>

            </div>
        </div>
    </div>
</div>
