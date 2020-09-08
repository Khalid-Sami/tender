@extends('_layout')
@section('style')

@endsection
@section('head_title')
    {{trans('lang.editReverseAuction')}}
@endsection
@section('title')
    {!!  trans('lang.editReverseAuction')!!}
@endsection
@section('msg')
    @if(session('msg'))
        <div class="alert alert-success alert-dismissible text-center" style=" position: absolute;width: 100%;z-index: 1;">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ session('msg') }}
        </div>
    @endif
    @if(session('error_msg'))
        <div class="alert alert-danger alert-dismissible text-center" style=" position: absolute;width: 100%;z-index: 1;">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ session('error_msg') }}
        </div>
    @endif

@endsection
@section('content')

    <form method="POST" id="editReverseAuctionForm" action="{{ action('AdminController@setEditReverseAuction',$reverseAuction->pk_i_id) }}" enctype="multipart/form-data">

        <div class="row portlet-body form-group">

            <div class="col-sm-12">
                <div class="form-group col-md-12">
                    <label for="reverseAuctionTitle" class="control-label">{{ trans('lang.reverseAuctionTitle') }}</label>
                    <input id="reverseAuctionTitle" name="reverseAuctionTitle" type="text" class="form-control" value="{{ $reverseAuction->s_title }}">
                    <div id="reverseAuctionTitle_validate" class="font-red"></div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group col-sm-6">
                    <label for="startDatepicker" class="control-label">{{ trans('lang.reverseAuctionStartDate') }}</label>
                    <div class="input-group date form_meridian_datetime form_datetime bs-datetime" id="startDateTender" data-date="2017-06-11T15:25:00Z">
                        <input id="startDate" name="startDate" type="text" size="16" class="form-control" value="{{ $reverseAuction->dt_open_date }}">
                        <span class="input-group-btn">
                        <button class="btn default date-set" type="button">
                            <i class="fa fa-calendar"></i>
                        </button>
                    </span>
                    </div>
                    <div id="startDate_validate" class="font-red"></div>
                </div>
                <div class="form-group col-sm-6">
                    <label for="endDatepicker" class="control-label">{{ trans('lang.reverseAuctionEndDate') }}</label>
                    <div class="input-group date form_meridian_datetime form_datetime bs-datetime" data-date="2017-06-11T15:25:00Z">
                        <input id="endDate" name="endDate" type="text" size="16" class="form-control" value="{{ $reverseAuction->dt_close_date }}">
                        <span class="input-group-btn">
                        <button class="btn default date-set" type="button">
                            <i class="fa fa-calendar"></i>
                        </button>
                    </span>
                    </div>
                    <div id="endDate_validate" class="font-red"></div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group col-sm-12">
                    <label for="editor1" class="control-label">{{ trans('lang.reverseAuctionDetails') }}</label>
                    <textarea id="editor1" class="wysihtml5 form-control" rows="6" name="editor1" data-error-container="#editor1_error">{{ $reverseAuction->s_description }}</textarea>
                    <div id="editor1_validate" class="font-red"></div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group col-sm-12">
                    <label for="reverseAuctionTerms" class="control-label">{{ trans('lang.reverseAuctionTerms') }}</label>
                    <textarea id="reverseAuctionTerms" class="wysihtml5 form-control" rows="6" name="reverseAuctionTerms" data-error-container="#tenderTerms_error">{{ $reverseAuction->s_terms }}</textarea>
                    <div id="reverseAuctionTerms_validate" class="font-red"></div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="col-md-12">
                    <label for="tenderTitle" class="control-label">{{ trans('lang.attachFile') }}: </label>
                </div>
                <div class="col-md-6">
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="input-group input-large">
                            <div class="form-control uneditable-input input-fixed input-medium">
                                <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                <span class="fileinput-filename"> </span>
                            </div>
                            <span class="input-group-addon btn default btn-file">
                                                                <span class="fileinput-new">{{ trans('lang.selectFile') }}</span>
                                                                <span class="fileinput-exists">{{ trans('lang.change_file') }}</span>
                                                                <input type="file" name="reverseAuctionFile[]" id="reverseAuctionFile" multiple=""> </span>
                            <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput">{{ trans('lang.remove') }}</a>
                        </div>
                    </div>
                    <div id="reverseAuctionFile_validate" class="font-red"></div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="col-sm-12 listFiles">
                    <div class="storedListFiles">
                        @foreach($reverseAuction->attachments as $attachment)
                            <span class="storedFile">
                                <a id="{{$attachment->pk_i_id}}" class="removeFile"><span class="glyphicon glyphicon-remove-sign"></span><a class="file" href="{{ asset('/files/reverse_auction/'.$attachment->s_url.'') }}">{{ $attachment->s_name }}</a></a>&nbsp;
                            </span>
                        @endforeach
                    </div>
                    <div class="newListFiles">
                    </div>
                </div>
            </div>
            <div class="col-sm-12" style="padding-top: 1%">
                <div class="col-sm-12">
                    <strong>@lang('lang.currency') / </strong> <cite>{{ $reverseAuction->currency->s_name }}</cite>
                </div>
            </div>
            <div class="col-sm-12" style="padding-top: 1%">
                <div class="col-sm-12">
                    <table id="itemsTable" class="col-sm-12" border="1" cellspacing="0">
                        <colgroup>
                            <col width="2%">
                            <col width="20%">
                            <col width="12%">
                            <col width="10%">
                            <col width="30%">
                        </colgroup>
                        <thead>
                        <tr style="background-color: #3e3e3e;color: white;text-align: center">
                            <th></th>
                            <th>{{ trans('lang.product') }}</th>
                            <th>{{ trans('lang.unit') }}</th>
                            <th>{{ trans('lang.quantity') }}</th>
                            <th>{{ trans('lang.Notes') }}</th>
                        </tr>
                        </thead>
                        <tbody id="itemsContentBody">
                        <tr id="{{$reverseAuction->auctionITem->fk_i_item_id}}" class="{{$reverseAuction->auctionITem->pk_i_id}}">
                            <td></td>
                            <td>{{$reverseAuction->auctionITem->item->s_name}}</td>
                            <td>{{$reverseAuction->auctionITem->item->unit->s_name}}</td>
                            <td><input name="quantityItem" type="text" class="form-control quantityItem" value="{{$reverseAuction->auctionITem->i_quantity}}"></td>
                            <td><input name="itemNotes" type="text" class="form-control itemNotes" value="{{$reverseAuction->auctionITem->s_notes}}">
                                <input type="hidden" name="ids" value="{{$reverseAuction->auctionITem->pk_i_id}}">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group col-sm-offset-5" style="margin-top: 20px;">
                    <input type="submit" value="{{trans('lang.save')}}" class="btn green submitForm col-sm-3">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </div>
            </div>

        </div>

    </form>

@endsection
@section('scripts')
    <script>
        $('#document').ready(function () {
            $('.alert-dismissible').delay(3000).fadeOut('slow');
            var checkIDS = [];
            var removeItems = [];


            $('#reverseAuctionFile').on('change', function(evt) {
                $('.newListFiles').find('a').remove();
                for (var x = 0; x < $(this)[0].files.length; x++) {
                    var f = evt.target.files[x];
                    $('.newListFiles').append('<a class="item">' + f.name + ' (' + f.size + ')</a>');
                }

            });

            $(".js-example-basic-multiple").select2();

            $.validator.addMethod("callbackPage", function (value, element) {
                return $('#itemsTable >tbody >tr').length > 0;
            });

            $('.submitForm').click(function () {
                $("#editReverseAuctionForm").validate();
                $("[name^=quantityItem]").each(function(){
                    $(this).rules("add", {
                        required: true,
                        number: true
                    });
                });

                {{--$('#reverseAuctionFile').rules('add',{--}}
                    {{--required: false,--}}
                    {{--messages: {--}}
                        {{--@if(app()->getLocale() =='ar')--}}
                        {{--required: "الملف حقل مطلوب",--}}
                        {{--@else--}}
                        {{--required: "File field is required"--}}
                        {{--@endif--}}
                    {{--}--}}
                {{--});--}}

            })

            $('#editReverseAuctionForm').validate({
                rules: {
                    reverseAuctionTitle: "required",
                    startDate: "required",
                    endDate: "required",
                },
                errorPlacement: function (error, element) {
                    var name = $(element).attr("id");
                    error.appendTo($("#" + name + "_validate"));
                },
                messages: {
                    @if(app()->getLocale() =='ar')
                    reverseAuctionTitle: "عنوان المناقصة حقل مطلوب",
                    startDate: "تاريخ بداية المناقصة حقل مطلوب",
                    endDate: " تاريخ نهاية المناقصة حقل مطلوب",

                    @else
                    reverseAuctionTitle: "Tender title field is required",
                    startDate: "Tender start date field is required",
                    endDate: "Tender end date field is required",

                    @endif
                }, submitHandler: function (form) {
                    form.submit();
                }
            });


        })
    </script>
    <script>
        $('body').on('click', '.removeFile', function() {
            var aTag = $(this);
            var attachID = $(this).attr('id');
            var tenderProposal = '{{$reverseAuction->pk_i_id}}';
            swal({
                    title: "{{ trans('lang.sure') }}",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "{{ trans('lang.yes_delete') }}",
                    cancelButtonText: "{{ trans('lang.cancel') }}",
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true
                },
                function () {

                    $.ajax({
                        method:'GET',
                        dataType: 'json',
                        url: '{{url('/')}}/' + tenderProposal + '/removeTenderProposalFile',
                        data:{
                            "_token": "{{csrf_token()}}",
                            'attachmentID' : attachID
                        },
                        success: function (data, textStatus, jqXHR) {
                            if(data.status){
                                swal("{{trans('lang.success')}}", "{{trans('lang.deleted')}}", "success");
                                aTag.closest('span').remove();
                            }
                        }
                    })

                });

        })
    </script>
@endsection