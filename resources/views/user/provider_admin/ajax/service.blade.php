@foreach($services as $service)
    <option value="{{ $service->service->pk_i_id }}">{{ $service->service->s_service }} </option>
@endforeach
