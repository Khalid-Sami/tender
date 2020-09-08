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
    <h3 style="color: #0d3625;text-align: center">{{ $reportHeader }}</h3>
</div>
@foreach($providers as $provider)
    <div style="margin-bottom: 10%">
        <table border="1">
            <tbody>
            <tr style="background-color: #81d4fa; color: white">
                <th colspan="6" style="text-align: @if(app()->getLocale() == "en") left @else right @endif">@lang('lang.company_account')</th>
            </tr>
            <tr>
                <th>@lang('lang.company_name')</th>
                <td colspan="5">{{ $provider->company->s_name }}</td>
            </tr>
            <tr>
                <th>@lang('lang.address')</th>
                <td colspan="5">
                    @if(app()->getLocale() == "en")
                        {{ $provider->company->s_address_en }}
                    @else
                        {{ $provider->company->s_address_ar }}
                    @endif
                </td>
            </tr>
            <tr>
                <th>@lang('lang.city_ar')</th>
                <td colspan="2">{{ $provider->company->city->s_name }}</td>
                <th>@lang('lang.country_ar')</th>
                <td colspan="2">{{ $provider->company->country->s_name }}</td>
            </tr>
            <tr>
                <th>@lang('lang.E-mail')</th>
                <td colspan="5">{{ $provider->company->s_email }}</td>
            </tr>
            <tr>
                <th>@lang('lang.phone')</th>
                <td>{{ $provider->company->s_telephone_number }}</td>
                <th>@lang('lang.mobile')</th>
                <td>{{ $provider->company->s_mobile_number }}</td>
                <th>@lang('lang.fax')</th>
                <td>{{ $provider->company->s_fax }}</td>
            </tr>
            <tr>
                <th>@lang('lang.salesRepresentativeName')</th>
                <td colspan="2">{{ $provider->company->s_sales_representative_name }}</td>
                <th>@lang('lang.salesRepresentativeMobile')</th>
                <td colspan="2">{{ $provider->company->s_sales_representative_mobile }}</td>
            </tr>
            <tr>
                <th>@lang('lang.status')</th>
                <td>{{ $provider->company->status->s_name }}</td>
            </tr>
            </tbody>
        </table>
    </div>
@endforeach