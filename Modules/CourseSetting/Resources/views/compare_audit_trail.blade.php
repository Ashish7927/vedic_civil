<div class="modal-dialog modal_1000px modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h1>{{__("common.Compare Data Change")}}</h1>
            <button type="button" class="close " data-dismiss="modal">
                <i class="ti-close "></i>
            </button>
        </div>

        <div class="modal-body">
            <div class="table-responsive">
                <table class="table">
                    <thead class="thead-dark">
                    <tr>
                        @foreach($columnChanges as $one)
                            <th scope="col">{{$one}}</th>
                        @endforeach
                    </tr>

                    </thead>
                    <tbody>
                    <tr>
                        @foreach($dataChanges as $dataChange)
                            <th scope="row">{{$dataChange["changes"]}}</th>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach($dataChanges as $dataChange)
                            <th scope="row">{{$dataChange["original"]}}</th>
                        @endforeach
                    </tr>
                    </tbody>

                </table>
            </div>

            <div class="col-lg-12 text-center pt_15">
                <div class="d-flex justify-content-center">
                    <button class="primary-btn semi_large2  fix-gr-bg" data-dismiss="modal"
                            type="button"><i
                            class="ti-check"></i> {{__('common.Close')}}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
