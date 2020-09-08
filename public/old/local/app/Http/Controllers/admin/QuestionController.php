<?php

namespace App\Http\Controllers\admin;

use App\Option;
use App\Question;
use App\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{

    public $ILLEGAL_ACCESS = "Illegal Access";
    public $DONE = "Done!";
    public $DONE_JSON_MESSAGE = ['status' => 200, 'message' => 'Done'];

    public function __construct()
    {
        $this->middleware(['is.login', 'locale']);
//        $this->middleware(['locale']);

    }

    public function index($id){
        $service = Service::where('pk_i_id',$id)->first();
        if($service == null)
            return back();
        return view('Question.AddQuestion',compact('service'));
    }
    public function showQuestionPage(Request $request)
    {
        $id = $request->input('qId');
        $serviceCheck = Service::find(intval($id));
        if (!$serviceCheck) {
            return redirect()->back();
        }
        return view('Question.question')->with('service', $serviceCheck)->with('id',$id);
    }


    public function store(Request $request)
    {
//        dd($request->input('serviceId'));

        $question = [
            's_question_ar' => $request->input('question_ar'),
            's_question_en' => $request->input('question_en'),
            'i_question_type' => $request->input('questionType'),
            'i_answer_type' => $request->input('answerType'),
            'b_enabled' => $request->input('questionStatus'),
            'fk_i_service_id' => $request->input('serviceId'),
            'dt_created_date' => Carbon::now(),
            'dt_modified_date' => Carbon::now()
        ];

        $validator = Validator::make($question, $this->getRoles(), $this->getMessages());
        if ($validator->fails())
            return redirect()->back()->withErrors($validator->errors()->all());
        $question = Question::create($question);
        $options = [
            'options_ar' => $request->input('option_ar'),
            'options_en' => $request->input('option_en'),
            'answerDescription_ar' => $request->input('answerDescription_ar'),
            'answerDescription_en' => $request->input('answerDescription_en'),
            'answerStatus' => $request->input('answerStatus'),

        ];
        $this->storeOptions($options, $question->pk_i_id);
        return redirect()->route('questions')->with('id', $request->input('serviceId'));
    }

    private function storeOptions($options, $questionId)
    {
        for ($counter = 0; $counter < sizeof($options['options_ar']); $counter++) {
            $option = [
                'fk_i_question_id' => $questionId,
                's_option_en' => $options['options_ar'][$counter],
                's_option_ar' => $options['options_en'][$counter],
                's_description_en' => $options['answerDescription_en'][$counter],
                's_description_ar' => $options['answerDescription_ar'][$counter],
                'b_enabled' => $options['answerStatus'][$counter],
                'dt_created_date' => Carbon::now(),
                'dt_modified_date' => Carbon::now()
            ];
            $this->validateOptionAndStore($option);

        }

        return $this->DONE;

    }

    private function validateOptionAndStore($option)
    {
        $validator = Validator::make($option, $this->getRolesOfOptions(), $this->getMessagesOfOptions());
        if ($validator->fails())
            return redirect()->back()->withErrors($validator->errors()->all());

        Option::create($option);
        return $this->DONE;

    }

//    public function store(Request $request)
//    {
//
//        if ($request->ajax()) {
//            $this->ILLEGAL_ACCESS;
//        }
//        $question = json_decode($request['body']);
//        $question = $this->convertToArray($question[0]);
//        $validator = Validator::make($question, $this->getRoles(), $this->getMessages());
//        if ($validator->fails()) {
//            return response()->json(['status' => 400, 'message' => $validator->errors()->all()]);
//        }
//        $questionObject = new Question();
//        Question::create($question);
//        return response()->json(['status' => 200, 'message' => $this->DONE]);
//    }

    public function fillDataTable(Request $request)
    {
        if ($request->ajax()) {
            $this->ILLEGAL_ACCESS;
        }
        $id = intval($request['id']);
        return ['data' => Service::find($id)->questions()->where('dt_deleted_date', null)->get()];

    }

    public function delete(Request $request)
    {
        if ($request->ajax()) {
            $this->ILLEGAL_ACCESS;
        }
        $id = intval($request['body']);
        $question = Question::find($id);
        $question->dt_deleted_date = Carbon::now();
        $question->save();

    }

    public function getQuestion(Request $request)
    {
        if ($request->ajax()) {
            $this->ILLEGAL_ACCESS;
        }
        $id = intval($request['body']);
        return response()->json(['status' => 200, 'message' => Question::find($id)]);
    }

    public function update(Request $request)
    {
        if ($request->ajax()) {
            $this->ILLEGAL_ACCESS;
        }
        $question = json_decode($request['body']);
        $questionId = $question[0]->questionId;
        $question = $this->convertToArray($question[0], -1);

        $validator = Validator::make($question, $this->getRoles(-1), $this->getMessages(-1));
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'message' => $validator->errors()->all()]);
        }

        $questionObject = Question::find($questionId);
        $questionObject->s_question_ar = $question['s_question_ar'];
        $questionObject->s_question_en = $question['s_question_en'];
        $questionObject->i_question_type = $question['i_question_type'];
        $questionObject->i_answer_type = $question['i_answer_type'];
        $questionObject->b_enabled = $question['b_enabled'];
        $questionObject->dt_modified_date = $question['dt_modified_date'];
        $questionObject->update();
        return response()->json(['status' => 200, 'message' => $this->DONE]);
    }

    private function getRoles($status = 1)
    {
        if ($status == 1) {
            return [
                's_question_ar' => 'required',
                's_question_en' => 'required',
                'i_question_type' => 'required',
                'i_answer_type' => 'required',
                'b_enabled' => 'required',
                'fk_i_service_id' => 'required'
            ];
        } else {
            return [
                's_question_ar' => 'required',
                's_question_en' => 'required',
                'i_question_type' => 'required',
                'i_answer_type' => 'required',
                'b_enabled' => 'required'

            ];
        }
    }

    private function getMessages($status = 1)
    {

        if ($status == 1) {
            return [
                's_question_ar.required' => "يجب ادخال نص السؤال",
                's_question_en.required' => 'يجب ادخال نص السؤال (انجليزي)',
                'i_question_type.required' => 'يجب ادخال نوع السؤال',
                'i_answer_type.required' => 'يجب ادخال نوع الاجابة',
                'b_enabled.required' => 'يجب ادخال طبيعة الاجابة',
                'fk_i_service_id.required' => 'رقم الخدمة مطلوب'
            ];
        } else {
            return [
                's_question_ar.required' => "يجب ادخال نص السؤال",
                's_question_en.required' => 'يجب ادخال نص السؤال (انجليزي)',
                'i_question_type.required' => 'يجب ادخال نوع السؤال',
                'i_answer_type.required' => 'يجب ادخال نوع الاجابة',
                'b_enabled.required' => 'يجب ادخال طبيعة الاجابة'
            ];
        }
    }

    private function convertToArray($question, $status = 1)
    {
        if ($status == 1) {
            return [
                's_question_ar' => $question->question_ar,
                's_question_en' => $question->question_en,
                'i_question_type' => $question->questionType,
                'i_answer_type' => $question->answerType,
                'b_enabled' => $question->questionStatus,
                'fk_i_service_id' => $question->serviceId,
                'dt_created_date' => Carbon::now(),
                'dt_modified_date' => Carbon::now(),

            ];
        } else {
            return [
                's_question_ar' => $question->question_ar,
                's_question_en' => $question->question_en,
                'i_question_type' => $question->questionType,
                'i_answer_type' => $question->answerType,
                'b_enabled' => $question->questionStatus,
                'dt_modified_date' => Carbon::now(),

            ];
        }
    }


    private function getRolesOfOptions($status = 1)
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

    private function getMessagesOfOptions($status = 1)
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

}
