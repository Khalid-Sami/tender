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
            <th colspan="6" >@lang('lang.productDetails')</th>
        </tr>
        <tr>
            <th >@lang('lang.item')</th>
            <td colspan="5">{{ $item->s_name }}</td>
        </tr>
        <tr>
            <th>@lang('lang.category')</th>
            <td colspan="5">{{ $item->category->s_name }}</td>
        </tr>
        <tr>
            <th>@lang('lang.unit')</th>
            <td colspan="5">{{ $item->unit->s_name }}</td>
        </tr>
        <tr>
            <th>@lang('lang.type')</th>
            <td colspan="5">{{ $item->type->s_name }}</td>
        </tr>
        <tr>
            <th>@lang('lang.description')</th>
            <td colspan="5">{{ $item->s_description }}</td>
        </tr>
        </tbody>
    </table>
</div>

@foreach($offerItems as $item)
    <div style="margin-bottom: 10%">
        <table border="1">
            <tbody>
            <tr style="background-color: #81d4fa; color: white">
                <th colspan="6" style="text-align: @if(app()->getLocale() == "en") left @else right @endif">@lang('lang.company_account')</th>
            </tr>
            <tr>
                <th>@lang('lang.company_name')</th>
                <td colspan="5">{{ $item->offer->company->s_name }}</td>
            </tr>
            <tr>
                <th>@lang('lang.address')</th>
                <td colspan="5">
                    {{ $item->offer->company->s_address }}
                </td>
            </tr>
            <tr>
                <th>@lang('lang.city_ar')</th>
                <td colspan="2">{{ $item->offer->company->city->s_name }}</td>
                <th>@lang('lang.country_ar')</th>
                <td colspan="2">{{ $item->offer->company->country->s_name }}</td>
            </tr>
            <tr>
                <th>@lang('lang.E-mail')</th>
                <td colspan="5">{{ $item->offer->company->s_email }}</td>
            </tr>
            <tr>
                <th>@lang('lang.phone')</th>
                <td>{{ $item->offer->company->s_telephone_number }}</td>
                <th>@lang('lang.mobile')</th>
                <td>{{ $item->offer->company->s_mobile_number }}</td>
                <th>@lang('lang.fax')</th>
                <td>{{ $item->offer->company->s_fax }}</td>
            </tr>
            <tr>
                <th>@lang('lang.salesRepresentativeName')</th>
                <td colspan="2">{{ $item->offer->company->s_sales_representative_name }}</td>
                <th>@lang('lang.salesRepresentativeMobile')</th>
                <td colspan="2">{{ $item->offer->company->s_sales_representative_mobile }}</td>
            </tr>
            <tr style="background-color: #81d4fa; color: white;">
                <th colspan="6" style="text-align: @if(app()->getLocale() == "en") left @else right @endif">@lang('lang.productDetails')</th>
            </tr>
            <tr>
                <th>@lang('lang.item')</th>
                <td colspan="2">{{ $item->item->s_name }}</td>
                <th>@lang('lang.date')</th>
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
            </tbody>
        </table>
    </div>
@endforeach