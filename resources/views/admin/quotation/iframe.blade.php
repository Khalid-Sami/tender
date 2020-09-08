<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>@lang('lang.subscribe_plan')</title>
</head>
<body>
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">@lang('lang.quotation')</h4>
    </div>            <!-- /modal-header -->
    <div class="modal-body">
        <div class="col-sm-12">
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=""></i></div>
                    <div class="tools">
                        <a href="javascript:;" class="expand" data-original-title="" title=""> </a>
                    </div>
                </div>
                <div class="portlet-body" style="display: block;">

                    <div class="row">
                        <div class="col-sm-12">
                            <h3>@lang('lang.quotation_details')</h3>
                            <h4> @lang('lang.price') : {{ $requestsQuotation->d_price }}</h4>

                            <div class="col-sm-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading"><b>@lang('lang.description')</b></div>
                                    <div class="panel-body">{{$requestsQuotation->s_description}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">

                            <?php
                            $help = new \App\helper\helpers();
                            $quotationAttachment = $help->getQuotationAttachment($requestsQuotation->pk_i_id);
                            ?>
                                <h3>@lang('lang.quotation_attach')</h3>
                            @foreach($quotationAttachment as $attach)
                                    <img class="col-sm-3" width="200" height="150"
                                         src="{{ asset('/images/quotation_attachment/'.$attach->s_url) }}" alt="">

                            @endforeach
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </div>            <!-- /modal-body -->
    <div class="modal-footer">
    </div>            <!-- /modal-footer -->
</div>         <!-- /modal-content -->


</body>
</html>