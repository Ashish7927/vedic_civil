
<!-- Corporate LIST start-->
<div class="col-xl-12 mb-25" id="trusted_by_section">
    <?php 
        $corporate_data = !empty($corporate_access_page_content->corporate_list) ? $corporate_access_page_content->corporate_list : '';
        $corporate_arr = json_decode($corporate_data);
        $corporates = collect($corporate_arr)->sortBy('order');
 
    ?>
    @if(!empty($corporates) && count($corporates)>0)
       <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="accordion" class="dd trusted_by_section_dd">
                            <ol class="dd-list">
                                @foreach($corporates as $key => $value)
                                    <?php $company = DB::table('companies')->where('id', $value->id)->first(); ?>
                                    <li class="dd-item" data-id="{{ $value->id }}">
                                        <div class="card accordion_card" id="accordion_{{$value->id}}">
                                            <div class="card-header item_header" id="heading_{{$value->id}}">
                                                <div class="dd-handle">
                                                    <div class="float-left">
                                                        {{ $company->name }}
                                                    </div>
                                                </div>
                                                <div class="float-right btn_div">
                                                    <a href="javascript:void(0);" onclick="" data-toggle="collapse"
                                                        data-target="#collapse_{{$value->id}}" aria-expanded="false"
                                                        aria-controls="collapse_{{$value->id}}"
                                                        class="primary-btn small fix-gr-bg text-center button panel-title">
                                                        <i class="ti-settings settingBtn"></i>
                                                        <span class="collapge_arrow_normal"></span>
                                                    </a>
                                                    <a href="javascript:void(0);" onclick="elementDelete({{$value->id}})"
                                                       class="primary-btn small fix-gr-bg text-center button">
                                                        <i class="ti-close"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            
                                            <div id="collapse_{{$value->id}}" class="collapse"
                                             aria-labelledby="heading_{{$value->id}}"
                                             data-parent="#accordion_{{$value->id}}">
                                                <div class="card-body">
                                                    <form enctype="multipart/form-data" class="elementEditForm">
                                                        <div class="row">
                                                            <input type="hidden" name="id" class="id"
                                                                value="{{$value->id}}">
                                                                <div class="col-xl-4">
                                                                    <div class="primary_input mb-25">
                                                                        <img class="imagePreview_company_logo_{{ $value->id }}"
                                                                             style="max-width: 100%"
                                                                             src="{{ file_exists($company->logo) ? asset('/'.$company->logo) : '' }}"
                                                                             alt="">
                                                                    </div> 
                                                                </div>
                                                                <div class="col-xl-8">
                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label"
                                                                               for="">{{ __('courses.Thumbnail Image') }}
                                                                            <small>({{__('common.Recommended Size')}} 187x91)
                                                                            </small>
                                                                        </label>
                                                                        <div class="primary_file_uploader">
                                                                            <input class="primary-input  filePlaceholder {{ @$errors->has('company_logo_' . $value->id ) ? ' is-invalid' : '' }}" type="text" id="" 
                                                                                    placeholder="Browse file" 
                                                                                    readonly="" {{ $errors->has('company_logo_' . $value->id ) ? ' autofocus' : '' }}>
                                                                            <button class="" type="button">
                                                                                <label class="primary-btn small fix-gr-bg"
                                                                                        for="company_logo_{{ $value->id }}">{{ __('common.Browse') }}</label>
                                                                                <input type="file"
                                                                                       class="d-none fileUpload imgInput_1"
                                                                                       name="company_logo_{{ $value->id }}" id="company_logo_{{ $value->id }}">
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 text-center">
                                                                    <div class="d-flex justify-content-center pt_20">
                                                                        <button type="button"
                                                                                class="editBtn_ca{{ $value->id  }} primary-btn fix-gr-bg"><i
                                                                                    class="ti-check"></i>
                                                                            {{ __('update') }}
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="card d-none">
        </div>
    @endif
</div>
<!-- Corporate LIST end-->


<!-- Delete Course Element Module -->
        <div class="modal fade admin-query" id="deleteItem2">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">@lang('common.Delete') Item</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <h4>@lang('common.Are you sure to delete ?')</h4>
                        </div>
                        <div class="mt-40 d-flex justify-content-between">
                            <button type="button" class="primary-btn tr-bg"
                                    data-dismiss="modal">@lang('common.Cancel')</button>
                            <input type="hidden" name="id" id="item-delete2" value="">
                            <a class="primary-btn fix-gr-bg" id="delete-item" href="#">@lang('common.Delete')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@push('scripts')
<script>
        
        function blankData() {
            $('#ca_multi_input').val('').trigger('change');
        }
  
        function elementDelete(id) {
            $('#deleteItem2').modal('show');
            $('#item-delete2').val(id);
        }

        function readURL2(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    imgId = '.imagePreview_'+$(input).attr('id');
                    $(imgId).attr('src', e.target.result);
                    console.log(input);
                    console.log($(input).attr('id'));
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $("input[id^='company_logo_']").change(function () {
            readURL2(this);
        });

    /* Corporate Accesse's function start */
    $(document).on('click', "button[class^='editBtn_ca']", function (event) {
        var id = $(this).closest("form").find('.id').val();
        var logo = $(this).closest("form").find("input[id^=company_logo_]")[0].files;
        var fd = new FormData();
        
        // Check file selected or not
        if(logo.length > 0 ){
            fd.append('logo',logo[0]);
            fd.append('_token', "{{ csrf_token() }}");
            fd.append('id', id);
        
            $.ajax({
                url: "{{ route('frontend.editCorporateElement') }}",
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    if (response.success == true) {
                        toastr.success("Operation successful", "Successful", { timeOut: 5000, });
                        location.reload();
                    } else {
                        toastr.error("Operation failed", "Error", { timeOut: 5000, });
                        location.reload();
                    }
                },
            });
        }else{
           alert("Please select a file.");
        }
    
    });

    $('#add_ca_btn').on('click', function (event) {
        let ca_ids = $('#ca_multi_input').val();
        let url = "{{ route('frontend.addCorporate') }}";

        let numOfInputItem = ca_ids.length;
        let itemLimit = 20;
        let trustedByItems = $('.trusted_by_section_dd > ol').children('li').length;

        if ((trustedByItems + numOfInputItem) > itemLimit) {
            let itemRemove = 0;
            itemRemove = (numOfInputItem + trustedByItems) - itemLimit;

            event.preventDefault();
            toastr.error('The maximum length for this list is 20 items. <br/>Please remove ' + itemRemove + ' items.', 'Failed', { timeOut: 5000, });
        } else {

            let data = {
                'ca_ids': ca_ids,
                '_token': '{{ csrf_token() }}'
            }
            
            $.post(url, data, function (response) {
                if (response.success == true) {
                    blankData();
                    toastr.success("Operation successful", "Successful", { timeOut: 5000, });
                    location.reload();
                } else {
                    toastr.error("Operation failed", "Error", { timeOut: 5000, });
                }
            });
        }

    });


    $(document).ready(function () {
        let url = "{{ route('frontend.reorderingCorporate') }}";
        $(document).on('mouseover', 'body', function (e) {
    
            
            $('.trusted_by_section_dd').nestable({
                maxDepth: 3,
                callback: function (l, e) {
                    let order = JSON.stringify($('.trusted_by_section_dd').nestable('serialize'));
                    console.log(order);
                    let data = {
                        'orderCorporate': order,
                        '_token': '{{ csrf_token() }}'
                    }
                    $.post(url, data, function (data) {
                        if (data != 1) {
                            toastr.error("Element is Not Moved. Error ocurred", "Error", { timeOut: 5000, });
                        }
                    });
                }
            });
        });
    });

    $(document).on('click', '#delete-item', function (event) {
        event.preventDefault();
        let url = "{{ route('frontend.deleteCorporate') }}";
        $('#deleteItem2').modal('hide');
        let id = $('#item-delete2').val();
        let data = {
            'id': id,
            '_token': '{{ csrf_token() }}',
        }
        $.post(url, data,
            function (response) {
                if (response.success == true)
                {
                    toastr.success("Operation successful", "Successful", { timeOut: 5000, });
                    location.reload();
                } else {
                    toastr.error("Operation failed", "Error", { timeOut: 5000, });
                }
            });
    });
    /* Corporate Accesse's function end */

</script>
@endpush