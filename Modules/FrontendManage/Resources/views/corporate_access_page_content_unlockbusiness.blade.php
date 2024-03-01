
<!-- Content Provider LIST start-->
<div class="col-xl-12 mb-25" id="unlock_business_section">
    <?php 
        $cp = !empty($corporate_access_page_content->content_provider_list) ? $corporate_access_page_content->content_provider_list : '';
        $content_providers_arr = json_decode($cp);
        $content_providers = collect($content_providers_arr)->sortBy('order');

    ?>
    
    @if(!empty($content_providers) && count($content_providers)>0) 
       <div class="card"> 
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="accordion" class="dd unlock_business_dd">
                            <ol class="dd-list">
                                @foreach($content_providers as $key => $value)
                                    <?php $user = \App\User::find($value->id);
                                    ?>
                                    <li class="dd-item" data-id="{{ $value->id }}">
                                        <div class="card accordion_card" id="accordion_{{$value->id}}">
                                            <div class="card-header item_header" id="heading_{{$value->id}}">
                                                <div class="dd-handle">
                                                    <div class="float-left">
                                                        {{ $user->name }}
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
                                                    <a href="javascript:void(0);" onclick="elementDeleteCp({{$value->id}})"
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
                                                                        <img class="imagePreview_cp_logo_{{ $value->id }}"
                                                                             style="max-width: 100%"
                                                                             src="{{ file_exists($user->image) ? asset('/'.$user->image) : '' }}"
                                                                             alt="">
                                                                    </div> 
                                                                </div>
                                                                <div class="col-xl-8">
                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label"
                                                                               for="">{{ __('courses.Thumbnail Image') }}
                                                                            <small>({{__('common.Recommended Size')}} 167X91) 
                                                                            </small>
                                                                        </label>
                                                                        <div class="primary_file_uploader">
                                                                            <input class="primary-input  filePlaceholder {{ @$errors->has('cp_logo_' . $value->id ) ? ' is-invalid' : '' }}" type="text" id="" 
                                                                                    placeholder="Browse file" 
                                                                                    readonly="" {{ $errors->has('cp_logo_' . $value->id ) ? ' autofocus' : '' }}>
                                                                            <button class="" type="button">
                                                                                <label class="primary-btn small fix-gr-bg"
                                                                                        for="cp_logo_{{ $value->id }}">{{ __('common.Browse') }}</label>
                                                                                <input type="file"
                                                                                       class="d-none fileUpload imgInput_1"
                                                                                       name="cp_logo_{{ $value->id }}" id="cp_logo_{{ $value->id }}">
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-xl-12">
                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label"
                                                                            for="">Content Provider/ Partner's Page Title
                                                                        </label>
                                                                        <input class="primary_input_field"
                                                                            placeholder="Content Provider/ Partner's Page Title"
                                                                            type="text" name="cp_page_title"
                                                                            {{ $errors->first('cp_page_title') ? ' autofocus' : '' }}
                                                                            value="{{isset($user->company_banner_title)? $user->company_banner_title : 'Start Learning from the World-Class Providers'}}" maxlength="50">
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-12">
                                                                    <div class="primary_input mb-25">
                                                                        <label class="primary_input_label"
                                                                            for="">Content Provider/ Partner's Page Sub Title
                                                                        </label>
                                                                        <input class="primary_input_field"
                                                                            placeholder="Content Provider/ Partner's Page Sub Title"
                                                                            type="text" name="cp_page_sub_title"
                                                                            {{ $errors->first('cp_page_sub_title') ? ' autofocus' : '' }}
                                                                            value="{{isset($user->company_banner_subtitle)? $user->company_banner_subtitle : 'Subscribe now via Corporate Access'}}" maxlength="100">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 text-center">
                                                                    <div class="d-flex justify-content-center pt_20">
                                                                        <button type="button"
                                                                                class="editBtn_cp{{ $value->id  }} primary-btn fix-gr-bg"><i
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
            <h1>unlock_business_section close</h1>
        </div>
    @endif
</div>
<!-- Content Provider LIST end-->


<!-- Delete Course Element Module -->
        <div class="modal fade admin-query" id="deleteItem">
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
                            <input type="hidden" name="id" id="item-delete" value="">
                            <a class="primary-btn fix-gr-bg" id="delete-cp-item" href="">@lang('common.Delete')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@push('scripts')
<script>
        function blankCpData() {
            $('#cp_multi_input').val('').trigger('change');
        }
  
        function elementDeleteCp(id) {

            $('#deleteItem').modal('show');
            $('#item-delete').val(id);
        }

        function readURL1(input) {
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

        $("input[id^='cp_logo_']").change(function () {
            readURL1(this);
        });

    /* Content Provider's function start */
    $(document).on('click', "button[class^='editBtn_cp']", function (event) {
        var id = $(this).closest("form").find('.id').val();
        var logo = $(this).closest("form").find("input[id^=cp_logo_]")[0].files;
        var cp_page_title = $(this).closest("form").find("input[name=cp_page_title]").val();
        var cp_page_sub_title = $(this).closest("form").find("input[name=cp_page_sub_title]").val();
        var fd = new FormData();
        
            fd.append('logo', logo.length > 0  ? logo[0] : '');
            fd.append('_token', "{{ csrf_token() }}");
            fd.append('id', id);
            fd.append('cp_page_title', cp_page_title);
            fd.append('cp_page_sub_title', cp_page_sub_title);
        
            $.ajax({
                url: "{{ route('frontend.editContentProviderElement') }}",
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
        
    
    });



    $('#add_cp_btn').on('click', function (event) {
        let cp_ids = $('#cp_multi_input').val();
        let url = "{{ route('frontend.addContentProvider') }}";

        let numOfInputItem = cp_ids.length;
        let itemLimit = 18;
        let unlockBusinessItems = $('.unlock_business_dd > ol').children('li').length;
        // console.log(unlockBusinessItems);

        if ((numOfInputItem + unlockBusinessItems) > itemLimit) {
            event.preventDefault();
            toastr.error('The maximum length for this list is 18 items.', 'Failed');
        } else {
            
            let data = {
                'cp_ids': cp_ids,
                '_token': '{{ csrf_token() }}'
            }
            
            $.post(url, data, function (response) {
                console.log(response);
                if (response.success == true) {
                    blankCpData();
                    toastr.success("Operation successful", "Successful", { timeOut: 5000, });
                    location.reload();
                } else {
                    toastr.error("Operation failed", "Error", { timeOut: 5000, });
                }
            });
        }
    });


    $(document).ready(function () {
        let url = "{{ route('frontend.reorderingContentProvider') }}";
        $(document).on('mouseover', 'body', function (e) {

            $('.unlock_business_dd').nestable({
                maxDepth: 3,
                callback: function (l, e) {
                    let order = JSON.stringify($('.unlock_business_dd').nestable('serialize'));
                    //console.log(order);
                    let data = {
                        'order': order,
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

    $(document).on('click', '#delete-cp-item', function (event) {
        event.preventDefault();
        let url = "{{ route('frontend.deleteContentProvider') }}";
        $('#deleteItem').modal('hide');
        let id = $('#item-delete').val();
        let data = {
            'id': id,
            '_token': '{{ csrf_token() }}',
        }
        
        console.log(id);
        $.post(url, data,
            function (response) {
                console.log(response);
                if (response.success == true)
                {
                    toastr.success("Operation successful", "Successful", { timeOut: 5000, });
                    location.reload();
                } else {
                    toastr.error("Operation failed", "Error", { timeOut: 5000, });
                }
                
            });
    });
    /* Content Provider's function end */

</script>
@endpush