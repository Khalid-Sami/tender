<?php

namespace App\Http\Controllers\admin;

use App\ServiceQuestionView;
use App\ServiceQuestionOptions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OptionController extends Controller
{

    public $ILLEGAL_ACCESS = "Illegal Access";
    public $DONE = "Done!";
    public $DONE_JSON_MESSAGE = ['status' => 200, 'message' => 'Done'];

    public function __construct()
    {
        $this->middleware(['is.login', 'locale']);
//        $this->middleware(['locale']);

    }

    public function store(Request $request)
    {
        if (!$request->ajax()) {
            return $this->ILLEGAL_ACCESS;
        }
        $option = json_decode($request['body']);
        $option = $this->convertToArray($option[0]);
        $validator = Validator::make($option, $this->getRoles(), $this->getMessages());
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'message' => $validator->errors()->all()]);
        }
        ServiceQuestionOptions::create($option);
        return response()->json(['status' => 200, 'message' => $this->DONE]);

    }

    private function convertToArray($option, $status = 1)
    {
        return [
            'fk_i_question_id' => $option->questionId,
            's_option_en' => $option->option_en,
            's_option_ar' => $option->option_ar,
            's_description_en' => $option->answerDescription_en,
            's_description_ar' => $option->answerDescription_ar,
            'b_enabled' => $option->answerStatus,
            'dt_created_date' => Carbon::now(),
            'dt_modified_date' => Carbon::now()];
    }

    private function getRoles($status = 1)
    {

        return [
            'fk_i_question_id' => 'required',
            's_option_en' => 'required',
            's_option_ar' => 'required',
            's_description_en' => 'required',
            's_description_ar' => 'required',
            'b_enabled' => 'required'
        ];
    }

    private function getMessages($status = 1)
    {

        return [
            'fk_i_question_id.required' => "يجب ادخال رقم السؤال ",
            's_option_ar.required' => 'يجب ادخال نص الخيار (عربي)',
            's_option_en.required' => 'يجب ادخال نص الخيار (انجليزي)',
            's_description_en.required' => 'يجب ادخال وصف الخيار (انجليزي)',
            's_description_ar.required' => 'يجب ادخال وصف الخيار (عربي)',
            'b_enabled.required' => 'يجب ادخال حال الخيار '
        ];
    }

    public function getOption(Request $request)
    {
        if (!$request->ajax())
            return $this->ILLEGAL_ACCESS;

        $id = intval($request['body']);
        return ServiceQuestionView::find($id)->options;
    }

    public function getQuestionOptions(Request $request)
    {

//        dd($request['id']);
        if (!$request->ajax())
            return $this->ILLEGAL_ACCESS;
        $id = intval($request['id']);
        if (ServiceQuestionView::find($id) == null || $id == null)
            return [];

        return ['data' => ServiceQuestionView::find($id)->serviceOptions()->get(['s_option', 's_Description', 'b_enabled'])];

    }

}
