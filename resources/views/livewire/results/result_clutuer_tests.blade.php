<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card mg-b-20">

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
                        <label for="inputName" class="control-label">Test name:</label>
                        <b>{{ $reg_samples_barcode_servs_test->test->name_en }}</b>
                    </div>
                    <div class="col">
                        <label for="inputName" class="control-label">Test status:</label>
                        <b>{{ $reg_samples_barcode_servs_test->test_status }}</b>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col">
                        <label for="inputName" class="control-label">Organism:<b class="text-danger fas">*</b></label>
                        <div class="input-group">

                            <select class="form-control " wire:model.defer="selected_organism">
                                <option value="" selected>
                                    -- Select item --
                                </option>
                                @foreach ($organisms as $organism)
                                    <option value="{{ $organism->id }}">
                                        {{ $organism->name_en }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col">
                        <label for="inputName" class="control-label">Sensitivity:</label>
                        <div class="input-group">
                            <select class="form-control " wire:model.defer="selected_sensitivity">
                                <option value="" selected>
                                    -- Select item --
                                </option>
                                <option selected value="Intermediate" selected>
                                    Intermediate
                                </option>
                                <option value="Resistant" selected>
                                    Resistant
                                </option>
                                <option value="Sensitive" selected>
                                    Sensitive
                                </option>
                                <option value="-" selected>
                                    -
                                </option>
                                <option value="Neg" selected>
                                    Neg
                                </option>
                                <option value="Pos" selected>
                                    Pos
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col">
                        <label for="inputName" class="control-label">Antibiotics:<b
                                class="text-danger fas">*</b></label>

                        <div class="input-group">
                            <select class="form-control " multiple="multiple" wire:model.defer="selected_antibiotics">

                                @foreach ($antibiotics as $antibiotic)
                                    <option value="{{ $antibiotic->id }}">
                                        {{ $antibiotic->name_en }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        (<b class="text-danger fas"> ctrl+click for multiple selections</b>)
                    </div>
                </div>

                <br>

                <div class="d-flex justify-content-center">
                    <div wire:loading wire:target="searchData">
                        loading ...
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <button wire:click="add_antibiotics" class="btn btn-primary">Add</button>&nbsp;&nbsp;
                </div>

            </div>
        </div>
    </div>

    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered mg-b-0 text-md-nowrap">
                        <thead>
                            <tr style="text-align: center">
                                <th>Organism</th>
                                <th>Sensitivity</th>
                                <th>Antibiotic</th>
                                <th>Operations</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($result_clutuer_tests as $key => $result_clutuer_test)
                                @foreach ($result_clutuer_org_antis->where('rct_org_id', $result_clutuer_test->id) as $antibiotic)
                                    <tr style="text-align: center">
                                        <td>{{ $result_clutuer_test->organism->name_en }}</td>
                                        <td>{{ $antibiotic->sensitivity }}</td>
                                        <td>{{ $antibiotic->antibiotic->name_en }}</td>
                                        <td><a wire:click="delete_antibiotics({{ $antibiotic->id }})"
                                                title="Delete antibiotic" href="#"><i
                                                    class="text-danger fas fa-trash-alt "></i>
                                            </a></td>
                                    </tr>
                                @endforeach
                            @endforeach

                        </tbody>
                    </table>

                    <hr>

                    <br>
                    <div class="d-flex justify-content-center">
                        <div wire:loading wire:target="add_modifier">
                            Saving ...
                        </div>
                    </div>

                    <table class="table table-bordered mg-b-0 text-md-nowrap">
                        <thead>
                            <tr style="text-align: center">
                                <th>Organism</th>
                                <th>Modifier</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($result_clutuer_tests as $key => $result_clutuer_test)
                                <tr style="text-align: center">
                                    <td>{{ $result_clutuer_test->organism->name_en }}</td>
                                    <td>
                                        <div class="input-group">
                                            <select class="form-control" {{ $reg_samples_barcode_servs_test->test_status == 'Reviewed' ? 'disabled' : '' }}
                                                wire:model.defer="selected_modifier.{{ $key }}."
                                                wire:change="add_modifier({{ $result_clutuer_test->id }},{{ $key }})">
                                                @if ($result_clutuer_test->modifier)
                                                    <option selected value="{{ $result_clutuer_test->modifier }}">
                                                        {{ $result_clutuer_test->modifier }}
                                                    </option>
                                                @endif
                                                <option value="100,000 cfu/ml">
                                                    100,000 cfu/ml
                                                </option>
                                                <option value="90,000 cfu/ml">
                                                    90,000 cfu/ml
                                                </option>
                                                <option value="80,000 cfu/ml">
                                                    80,000 cfu/ml
                                                </option>
                                                <option value="70,000 cfu/ml">
                                                    70,000 cfu/ml
                                                </option>
                                                <option value="60,000 cfu/ml">
                                                    60,000 cfu/ml
                                                </option>
                                                <option value="35,000 cfu/ml">
                                                    35,000 cfu/ml
                                                </option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <hr>

                    <label><b>Test comment:</b>
                    </label>

                    <textarea wire:model.defer="Cultuer_test_comment" cols="150" rows="5">
                    </textarea>
                    <div class="d-flex justify-content-center">

                        @if ($reg_samples_barcode_servs_test->test_status == 'Received')
                            <button
                                wire:click="save_test_result_Culture({{ $reg_samples_barcode_servs_test->id }},{{ $reg_samples_barcode_servs_test->rsbs_id }},'Save')"
                                type="submit" class="btn btn-info"> <i title="Save"
                                    class="text-primary fas fa-check"></i> Save</button>
                        @elseif ($reg_samples_barcode_servs_test->test_status == 'Verified')
                            <button
                                wire:click="save_test_result_Culture({{ $reg_samples_barcode_servs_test->id }},{{ $reg_samples_barcode_servs_test->rsbs_id }},'Review')"
                                type="submit" class="btn btn-info"> <i title="Review"
                                    class="text-success fas fa-check-double"></i> Review</button>
                        @elseif ($reg_samples_barcode_servs_test->test_status == 'Reviewed')
                            <button
                                wire:click="save_test_result_Culture({{ $reg_samples_barcode_servs_test->id }},{{ $reg_samples_barcode_servs_test->rsbs_id }},'Undo Review')"
                                type="submit" class="btn btn-info"> <i title="Undo Review"
                                    class="text-danger fas fa-window-close"></i> Undo Review</button>
                        @else
                            <label for="inputName" class='text-danger control-label'><b>Test not received
                                    yet.</b>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
