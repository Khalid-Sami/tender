<style>
    table {
        width:100%;
    }
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
    }
    th, td {
        padding: 5px;
        /*text-align: left;*/
    }

</style>
<div style="margin: auto; text-align:center;">
    <img src="{{url('/')}}/images/maqased-logo.png">
</div>

<div style="margin-bottom: 10%">
    <table border="1">
        <tbody>
        <tr style="background-color: #4db6ac; color: white" >
            <th colspan="6" >@lang('lang.tenderDetails')</th>
        </tr>
        <tr>
            <th >@lang('lang.tender')</th>
            <td colspan="5">{{ $tender->s_title }}</td>
        </tr>
        <tr>
            <th>@lang('lang.tenderStartDate')</th>
            <td colspan="5">{{ $tender->dt_open_date }}</td>
        </tr>
        <tr>
            <th>@lang('lang.tenderEndDate')</th>
            <td colspan="5">{{ $tender->dt_close_date }}</td>
        </tr>
        <tr>
            <th>@lang('lang.status')</th>
            <td colspan="5">{{ $tender->status->s_name }}</td>
        </tr>
        <tr>
            <th>@lang('lang.currency')</th>
            <td colspan="5">{{ $tender->currency->s_name }}</td>
        </tr>
        <tr>
            @if(app()->getLocale() == "en")
                <th>Number Of Tender Proposals</th>
            @else
                <th>عدد المتقدمين للمناقصة</th>
            @endif
{{--            <th>@lang('lang.tenderProposals')</th>--}}
            <td colspan="5">{{ $proposalsNum }}</td>
        </tr>
        <tr style="background-color: #4db6ac; color: white">
            <th colspan="6" >@lang('lang.approval')</th>
        </tr>
        <tr>
            <th>@lang('lang.company')</th>
            <td colspan="2">
                @if($tender->accetpoffer != null)
                    {{ $tender->accetpoffer->company->s_name }}
                @else
                    -----
                @endif
            </td>
            <th>@lang('lang.date')</th>
            <td colspan="2">
                @if($tender->accetpoffer != null)
                    {{ $tender->dt_accept_offer_date }}
                @else
                    -----
                @endif
            </td>
        </tr>
        </tbody>
    </table>
</div>

@foreach($tender->tenderProposal as $proposal)
        <div style="margin-bottom: 10%">
            <table border="1">
                <tbody>
                <tr style="background-color: #81d4fa; color: white">
                    <th colspan="6" style="text-align: @if(app()->getLocale() == "en") left @else right @endif">@lang('lang.company_account')</th>
                </tr>
                <tr>
                    <th>@lang('lang.company_name')</th>
                    <td colspan="5">{{ $proposal->company->s_name }}</td>
                </tr>
                <tr>
                    <th>@lang('lang.address')</th>
                    <td colspan="5">
                        @if(app()->getLocale() == "en")
                            {{ $proposal->company->s_address_en }}
                        @else
                            {{ $proposal->company->s_address_ar }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>@lang('lang.city_ar')</th>
                    <td colspan="2">{{ $proposal->company->city->s_name }}</td>
                    <th>@lang('lang.country_ar')</th>
                    <td colspan="2">{{ $proposal->company->country->s_name }}</td>
                </tr>
                <tr>
                    <th>@lang('lang.E-mail')</th>
                    <td colspan="5">{{ $proposal->company->s_email }}</td>
                </tr>
                <tr>
                    <th>@lang('lang.phone')</th>
                    <td>{{ $proposal->company->s_telephone_number }}</td>
                    <th>@lang('lang.mobile')</th>
                    <td>{{ $proposal->company->s_mobile_number }}</td>
                    <th>@lang('lang.fax')</th>
                    <td>{{ $proposal->company->s_fax }}</td>
                </tr>
                <tr style="background-color: #81d4fa; color: white;">
                    <th colspan="6" style="text-align: @if(app()->getLocale() == "en") left @else right @endif">@lang('lang.items')</th>
                </tr>
                <tr>
                    <th>@lang('lang.item') #</th>
                    <th>@lang('lang.item')</th>
                    <th>@lang('lang.Notes')</th>
                    <th>@lang('lang.quantity')</th>
                    <th>@lang('lang.unitCost')</th>
                    <th>@lang('lang.totalCost')</th>
                </tr>
                <?php $total = 0 ?>
                @foreach($proposal->tenderProposalItems as $key=>$item)
                    <?php $total =  $total + $item->tenderItems->i_quantity * $item->d_price ?>
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{ $item->tenderItems->item->s_name }}</td>
                        <td>{{ $item->s_note }}</td>
                        <td>{{ $item->tenderItems->i_quantity }}</td>
                        <td>{{ $item->d_price }}</td>
                        <td>{{ $item->tenderItems->i_quantity * $item->d_price }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="4"></td>
                    <th>@lang('lang.total')</th>
                    <td>
                        {{ $total }}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
@endforeach