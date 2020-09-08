<option value="">@lang('lang.choose_option')</option>
@foreach($data as $d)
    <option
            value="{{ $d->pk_i_id }}"
    @if($d->pk_i_id == $option_id)
        {{'selected'}}
            @endif
    >{{$d->s_name}}</option>
@endforeach