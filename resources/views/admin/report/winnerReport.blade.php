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

<div>
    <h3 style="color: #0d3625;text-align: center">{{ $header }}</h3>
</div>

@foreach($offers as $offer)
    <div style="margin-bottom: 10%">
        <table border="1">
            <tbody>
            <tr style="background-color: #81d4fa; color: white">
                <th colspan="6" style="text-align: @if(app()->getLocale() == "en") left @else right @endif">@lang('lang.company_account')</th>
            </tr>
            <tr>
                <th>@lang('lang.company_name')</th>
                <td colspan="5">{{ $offer->company->s_name }}</td>
            </tr>
            <tr>
                <th>@lang('lang.address')</th>
                <td colspan="5">
                    {{ $offer->company->s_address }}
                </td>
            </tr>
            <tr>
                <th>@lang('lang.city_ar')</th>
                <td colspan="2">{{ $offer->company->city->s_name }}</td>
                <th>@lang('lang.country_ar')</th>
                <td colspan="2">{{ $offer->company->country->s_name }}</td>
            </tr>
            <tr>
                <th>@lang('lang.E-mail')</th>
                <td colspan="5">{{ $offer->company->s_email }}</td>
            </tr>
            <tr>
                <th>@lang('lang.phone')</th>
                <td>{{ $offer->company->s_telephone_number }}</td>
                <th>@lang('lang.mobile')</th>
                <td>{{ $offer->company->s_mobile_number }}</td>
                <th>@lang('lang.fax')</th>
                <td>{{ $offer->company->s_fax }}</td>
            </tr>
            <tr>
                <th>@lang('lang.salesRepresentativeName')</th>
                <td colspan="2">{{ $offer->company->s_sales_representative_name }}</td>
                <th>@lang('lang.salesRepresentativeMobile')</th>
                <td colspan="2">{{ $offer->company->s_sales_representative_mobile }}</td>
            </tr>
            <tr style="background-color: #81d4fa; color: white;">
                <th colspan="6" style="text-align: @if(app()->getLocale() == "en") left @else right @endif">@lang('lang.productDetails')</th>
            </tr>
            @foreach($offer->items as $item)
            <tr style="background-color:#cfd8dc;color:white">
                <th style="color: black">@lang('lang.item')</th>
                <td colspan="2">{{ $item->item->s_name }}</td>
                <th style="color: black">@lang('lang.date')</th>
                <td colspan="2">{{ $item->dt_created_date }}</td>
            </tr>
            <tr>
                <th>@lang('lang.category')</th>
                <td colspan="5">{{ $item->item->category->s_name }}</td>
            </tr>
            <tr>
                <th>@lang('lang.currency')</th>
                <td colspan="5">{{ $item->offer->currency->s_name }}</td>
            </tr>
            <tr>
                <th>@lang('lang.quantity')</th>
                <td>{{ $item->i_quantity }}</td>
                <th>@lang('lang.price')</th>
                <td>{{ $item->d_price }}</td>
                <th>@lang('lang.total')</th>
                <td>{{ (float)$item->i_quantity * (float)$item->d_price }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endforeach