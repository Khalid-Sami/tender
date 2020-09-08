@extends('_layout')
@section('style')

@endsection
@section('head_title')
    {{trans('lang.bidding')}}
@endsection
@section('title')
    {!!  trans('lang.bidding')!!}
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

    <form method="post" id="editBiddingForm" action="{{ action('ServiceProviderController@editSPBidding',$tenderProposal->pk_i_id) }}" enctype="multipart/form-data">

        <input type="hidden" name="tenderID" value="{{ $tenderProposal->tender->pk_i_id }}">
        <input type="hidden" name="startTenderDate" value="{{ $tenderProposal->tender->dt_open_date }}">
        <input type="hidden" name="endTenderDate" value="{{ $tenderProposal->tender->dt_close_date }}">

        <div class="row portlet-body form-group">

            <div class="col-sm-12">
                <div class="form-group col-md-12">
                    <label for="tenderTitle" class="control-label">{{ trans('lang.tenderTitle') }}: </label>
                    <cite style="color: #2b71a8">{{ $tenderProposal->tender->s_title }}</cite>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group col-md-6">
                    <label for="tenderTitle" class="control-label">{{ trans('lang.tenderStartDate') }}: </label>
                    <cite style="color: #2b71a8">{{ $tenderProposal->tender->dt_open_date }}</cite>
                </div>
                <div class="form-group col-md-6">
                    <label for="tenderTitle" class="control-label">{{ trans('lang.tenderEndDate') }}: </label>
                    <cite style="color: #2b71a8">{{ $tenderProposal->tender->dt_close_date }}</cite>
                </div>
            </div>

            {{--<div class="col-sm-12">--}}
            {{--<div class="form-group col-md-6">--}}
            {{--<label for="tenderTitle" class="control-label">{{ trans('lang.tenderEndDate') }}: </label>--}}
            {{--<cite style="color: #2b71a8">{{ $tender->dt_close_date }}</cite>--}}
            {{--</div>--}}
            {{--</div>--}}

            <div class="col-sm-12">
                <div class="form-group col-md-12">
                    <label for="tenderTitle" class="control-label">{{ trans('lang.currency') }}: </label>
                    <cite style="color: #2b71a8">{{ $tenderProposal->tender->currency->s_name }}</cite>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="col-sm-12">
                    <label>{{ trans('lang.tenderDetails') }}</label>
                    <div class="note note-success">
                        @if($tenderProposal->tender->s_description != "")
                            <p>{{ $tenderProposal->tender->s_description }}</p>
                        @else
                            <p>{{ trans('lang.noDetails') }}</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                {{--<div class="form-group col-md-12">--}}
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
                                                                <input type="file" name="tenderFile[]" id="fileTender" multiple=""> </span>
                            <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput">{{ trans('lang.remove') }}</a>
                        </div>
                    </div>
                    <div id="fileTender_validate" class="font-red"></div>
                </div>
                {{--</div>--}}
            </div>
            <div class="col-sm-12">
                <div class="col-sm-12 listFiles">
                    <div class="storedListFiles">
                        @foreach($tenderProposal->attachments as $attachment)
                            <span class="storedFile">
                                @if($attachment->i_attach_type == 2)
                                    <a id="{{$attachment->pk_i_id}}" class="removeFile"><span class="glyphicon glyphicon-remove-sign"></span><a class="file" href="{{ asset('/files/tender_proposal/'.$attachment->s_url.'') }}">{{ $attachment->s_name }}</a></a>&nbsp;
                                @endif
                            </span>
                            {{--                            <a href="{{ asset('/files/tender_proposal/'.$attachment->s_url.'') }}">{{ $attachment->s_name }}</a>--}}
                        @endforeach
                    </div>
                    <div class="newListFiles">
                        {{--                    <label>{{ trans('lang.newFiles') }}</label>--}}
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group col-sm-12">
                    <label for="editor1" class="control-label">{{ trans('lang.Notes') }}</label>
                    {{--<textarea id="tenderDetails" name="markdown" data-provide="markdown" rows="5" data-error-container="#editor_error"></textarea>--}}
                    <textarea class="wysihtml5 form-control" rows="6" name="editor1" data-error-container="#editor1_error">{{ $tenderProposal->s_notes }}</textarea>
                    <div id="editor1_validate" class="font-red"></div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="col-sm-12">
                    <label>{{ trans('lang.items') }}</label>
                    <table id="itemsTable" class="col-sm-12" border="1" cellspacing="0">
                        <colgroup>
                            <col width="2%">
                            <!--<col width="50px">-->
                            <col width="15%">
                            <col width="9%">
                            <col width="9%">
                            <col width="9%">
                            <col width="9%">
                            <col width="5%">
                            <col width="30%">
                        </colgroup>
                        <thead>
                        <tr style="background-color: #3e3e3e;color: white;text-align: center">
                            <th>#</th>
                            <th>{{ trans('lang.product') }}</th>
                            <th>{{ trans('lang.unit') }}</th>
                            <th>{{ trans('lang.quantity') }}</th>
                            <th>{{ trans('lang.price') }}</th>
                            <th>{{ trans('lang.total') }}</th>
                            <th>{{ trans('lang.isDifferent') }}</th>
                            {{--                        <th style="text-align: center">{{ trans('lang.price') }}</th>--}}
                            {{--                        <th style="text-align: center">{{ trans('lang.total') }}</th>--}}
                            {{--                        <th style="text-align: center">{{ trans('lang.isDifferent') }}</th>--}}
                            <th>{{ trans('lang.Notes') }}</th>
                        </tr>
                        </thead>
                        <tbody id="itemsContentBody">
                        @foreach($tenderProposal->tenderProposalItems as $key => $item)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $item->tenderItems->item->s_name }}</td>
                                <td>{{ $item->tenderItems->item->unit->s_name }}</td>
                                <td class="itemQun">{{ $item->i_quantity }}</td>
                                <td><input name="price[{{$key+1}}]" type="text" class="form-control priceInput" value="{{ $item->d_price }}"></td>
                                <td class="itemTotal">{{ $item->d_total }}</td>
                                <td>
                                    @if($item->b_is_different == 1)
                                        <input style="width: 60%; height: auto" type="checkbox" class="form-control isDiff" name="isDiff[]" value="{{ $item->pk_i_id }}" checked>
                                    @else
                                        <input style="width: 60%; height: auto" type="checkbox" class="form-control isDiff" name="isDiff[]" value="{{ $item->pk_i_id }}">
                                    @endif
                                </td>
                                <td><input name="notes[{{$key+1}}]" type="text" class="form-control" value="{{ $item->s_note }}">
                                    <input type="hidden" name="itemQuantity[{{$key+1}}]" value="{{$item->i_quantity}}">
                                    <input type="hidden" name="tenderItemID[{{$key+1}}]" value="{{ $item->pk_i_id }}">
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group col-sm-offset-5" style="margin-top: 20px;">
                    <input type="submit" value="{{trans('lang.save')}}" class="btn green submitForm col-sm-3">
                    {{--                {!! Form::submit(trans('lang.save'),['class' => 'btn green submitForm']) !!}--}}
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

            $('#fileTender').on('change', function(evt) {
                $('.listFiles').find('.newListFiles').find('a').remove();
                for (var x = 0; x < $(this)[0].files.length; x++) {
                    var f = evt.target.files[x];
                    $('.newListFiles').append('<a class="item">' + f.name + ' (' + f.size + ')</a>');
                }

            });


            $(".js-example-basic-multiple").select2();

            $('.submitForm').click(function () {
                $("#editBiddingForm").validate();
                $("[name^=price]").each(function(){
                    $(this).rules("add", {
                        required: true,
                        number: true
                    });
                });
                $('#fileTender').rules('add',{
                    required: true,
                    messages: {
                        @if(app()->getLocale() =='ar')
                        required: "الملف حقل مطلوب",
                        @else
                        required: "File field is required"
                        @endif
                    }
                });
                $("[name^=notes]").each(function(){
                    var thisCheck = $(this);
                    $(this).rules("add", {
                        required: function () {
                            if(thisCheck.closest('tr').find(".isDiff").is(':checked')){
                                return true;
                            }
                            else {
                                return false;
                            }
                        }
                    });
                });
            })

            $('#editBiddingForm').validate({
                rules: {
                    "tenderFile[]": {
                        required: true
                    },
                    "price[]": {
                        required: true,
                        number: true
                    }

                },
                errorPlacement: function (error, element) {
                    var id = $(element).attr("id");
                    error.appendTo($("#" + id + "_validate"));
                },
                messages: {
                    @if(app()->getLocale() =='ar')
                    "tenderFile[]": {
                        required: "الملف حقل مطلوب"
                    },
                    @else
                    "tenderFile[]": {
                        required: "File field is required"
                    },
                    @endif
                }
                , submitHandler: function (form) {
                    form.submit();
                }
            });

            $('body').on('keyup','.priceInput',function (){
                $(this).rules("add", {
                    required: true,
                    number: true
                });
                if($(this).valid()){
                    var value = parseFloat($(this).closest('tr').find('.itemQun').text()) * parseFloat($(this).val())
                    $(this).closest('tr').find('.itemTotal').text(value)
                }
                else {
                    $(this).closest('tr').find('.itemTotal').text(0)
                }
            });
        })
    </script>
    <script>
        $('body').on('click', '.removeFile', function() {
//        e.preventDefault();
            var aTag = $(this);
            var attachID = $(this).attr('id');
            var tenderProposal = '{{$tenderProposal->pk_i_id}}';
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