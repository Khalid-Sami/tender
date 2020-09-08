@foreach($questions as $index=>$question)
    {{--<option value="{{ $question->pk_i_id }}">{{ $question->s_name }} </option>--}}
    <div class="col-sm-12">
        <div class="panel-group accordion col-sm-6" id="accordion{{$index}}">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title" style="display: flex;">
                        <input type="hidden" name="checkMe[]">
                        <input type="checkbox" {!! \App\helper\helpers::getQuestionChecked($service_provider_id,$service_id,$question->pk_i_id) !!} name="questionsCheckbox[]" value="{{$question->pk_i_id}}" style="margin-top: 12px">
                        <a style="width: 100%;" class="accordion-toggle accordion-toggle-styled collapsed"
                           data-toggle="collapse" data-parent="#accordion{{$index}}" href="#collapse_{{$index}}_1"
                           aria-expanded="false"> {{$question->s_question}} </a>
                    </h4>
                </div>
                <div id="collapse_{{$index}}_1" class="panel-collapse collapse" aria-expanded="false"
                     style="height: 0px;">
                    <div class="panel-body">

                        <p>
                        <?php
                        $data = \App\helper\helpers::getQuestionOptions($question->pk_i_id);

                        ?>
                        @foreach($data as $d)
                            <div class="col-sm-12">
                                <label class="checkbox-inline"><input type="checkbox" name="optionsCheckbox{{$index}}[]" {!! \App\helper\helpers::getOptionsChecked($service_provider_id,$service_id,$question->pk_i_id,$d->pk_i_id) !!}   value="{{$d->pk_i_id}}">{{ $d->s_option }}
                                </label>
                            </div>
                            @endforeach
                            </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
