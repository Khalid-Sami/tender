@extends('_layout')
@section('style')
@endsection
@section('head_title')
    {{trans('lang.pricesOffers')}}
@endsection
@section('title')
    <div class="row">
        <div class="col-md-3">
            {{trans('lang.pricesOffers')}}
        </div>
        @if($tenderProposal->i_status != 102 && $tenderProposal->i_status != 103)
            <div class="col-md-2 col-md-offset-6">
                <a href="{{ action('AdminController@reviewedTenderProposalPO',$tenderProposal->pk_i_id) }}" class="btn btn-success">@lang('lang.reviewed')</a>
            </div>
        @endif
    </div>
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
  {{--<form method="get" id="adoptionTenderProposal">--}}
  <div class="row">
      <div class="col-md-12 ">
          <div class="panel panel-default">
              <div class="panel-heading">
                  <h3 class="panel-title">@lang('lang.tenderDetails')</h3>
              </div>
              <div class="panel-body">
                <div class="col-md-12">
                    <div class="col-md-12">
                        <strong>@lang('lang.tenderTitle'): </strong>
                        <cite style="color: #2b71a8">{{ $tenderProposal->tender->s_title }}</cite>
                    </div>
                </div>
                  <div class="col-md-12">
                      <div class="col-md-6">
                          <strong>@lang('lang.tenderStartDate'): </strong>
                          <cite style="color: #2b71a8">{{ $tenderProposal->tender->dt_open_date }}</cite>
                      </div>
                      <div class="col-md-6">
                          <strong>@lang('lang.tenderEndDate'): </strong>
                          <cite style="color: #2b71a8">{{ $tenderProposal->tender->dt_close_date }}</cite>
                      </div>
                  </div>
                  <div class="col-md-12">
                      <div class="col-md-6">
                          <strong>@lang('lang.currency'): </strong>
                          <cite style="color: #2b71a8">{{ $tenderProposal->tender->currency->s_name }}</cite>
                      </div>
                      <div class="col-md-6">
                          <strong>@lang('lang.status'): </strong>
                          <cite style="color: #2b71a8">{{ $tenderProposal->tender->status->s_name }}</cite>
                      </div>
                  </div>
                  <div class="col-md-12">
                      <div class="col-md-12">
                          <strong>@lang('lang.tenderDetails'): </strong>
                          <div class="note note-info">
                              @if($tenderProposal->tender->s_description != "")
                                  <p> {{ $tenderProposal->tender->s_description }} </p>
                              @else
                                  <p> @lang('lang.noDetails') </p>
                              @endif
                          </div>
                      </div>
                  </div>
                  <div class="col-md-12">
                      <div class="col-md-12">
                          <strong>@lang('lang.tenderTerms'): </strong>
                          <div class="note note-danger">
                              @if($tenderProposal->tender->s_terms != "")
                                  <p> {{ $tenderProposal->tender->s_terms }} </p>
                              @else
                                  <p> @lang('lang.noTerms') </p>
                              @endif
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">@lang('lang.company_account')</h3>
            </div>
            <div class="panel-body">
                <div class="col-md-12">
                    <div class="col-md-12">
                        <strong>@lang('lang.company_name'): </strong>
                        <cite>{{ $tenderProposal->company->s_name }}</cite>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-12">
                        <strong>@lang('lang.e-mail'): </strong>
                        <cite>{{ $tenderProposal->company->s_email }}</cite>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-4">
                        <strong>@lang('lang.faxNumber'): </strong>
                        <cite>{{ $tenderProposal->company->s_fax }}</cite>
                    </div>
                    <div class="col-md-4">
                        <strong>@lang('lang.tel'): </strong>
                        <cite>{{ $tenderProposal->company->s_telephone_number }}</cite>
                    </div>
                    <div class="col-md-4">
                        <strong>@lang('lang.mobile_number'): </strong>
                        <cite>{{ $tenderProposal->company->s_mobile_number }}</cite>
                    </div>
                </div>
                {{--<div class="col-md-12">--}}
                    {{--<div class="col-md-12">--}}
                        {{--<strong>@lang('lang.addressCompany'): </strong>--}}
                        {{--<cite>{{ $tenderProposal->company->s_mobile_number }}</cite>--}}
                    {{--</div>--}}
                {{--</div>--}}
            </div>
        </div>
    </div>
      <div class="col-md-12">
          <div class="panel panel-info">
              <div class="panel-heading">
                  <h3 class="panel-title">@lang('lang.showPrices')</h3>
              </div>
              <div class="panel-body">
                  <div class="col-md-12">
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
                                  <td class="itemQun">{{ $item->tenderItems->i_quantity }}</td>
                                  <td>{{ $item->d_price }}</td>
                                  <td class="itemTotal">{{ $item->d_price * $item->tenderItems->i_quantity }}</td>
                                  <td>
                                      @if($item->b_is_different == 1)
                                          <input style="width: 60%; height: auto" type="checkbox" class="form-control isDiff" name="isDiff[]" value="{{ $item->pk_i_id }}" checked disabled>
                                      @else
                                          <input style="width: 60%; height: auto" type="checkbox" class="form-control isDiff" name="isDiff[]" value="{{ $item->pk_i_id }}" disabled>
                                      @endif
                                  </td>
                                  <td>{{ $item->s_note }}
                                      <input type="hidden" name="itemQuantity[{{$key+1}}]" value="{{$item->tenderItems->i_quantity}}">
                                      <input type="hidden" name="tenderItemID[{{$key+1}}]" value="{{ $item->pk_i_id }}">
                                  </td>
                              </tr>
                          @endforeach
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
      </div>
      @if($tenderProposal->tender->i_accept_offer != 1)
          <div class="col-md-offset-5">
              <a class="btn btn-primary" id="adoption" href="">@lang('lang.acceptOffer')</a>
          </div>
      @endif

  </div>
  {{--</form>--}}
@endsection
@section('scripts')
    <script>
        $('document').ready(function () {
            $('#adoption').click(function(event){
                var thisButton = $(this);
                event.preventDefault();
                swal({
                        title: "{{ trans('lang.approvedRequest') }}",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "{{ trans('lang.okBtn') }}",
                        cancelButtonText: "{{ trans('lang.cancel') }}",
                        closeOnConfirm: false,
                        showLoaderOnConfirm: true
                    },
                    function () {
                        $.ajax({
                            method: "GET",
                            dataType: "json",
                            url: '{{action('AdminController@adoptionTenderProposal',$tenderProposal->pk_i_id)}}',
                            data: {
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function (data, textStatus, jqXHR) {
                                if (data.status) {
                                    swal("{{trans('lang.success')}}", "{{trans('lang.successApproved')}}", "success");
                                    thisButton.remove()
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                            }
                        });

                    });
            })
        })
    </script>
@endsection