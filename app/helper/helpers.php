<?php
namespace App\helper;

use App\ConversationUser;
use App\RequestQuotationAttachment;
use App\ServiceQuestionOptionsView;
use App\SPCities;
use App\SPQuestionAnswer;
use App\RequestQuotation;

class helpers
{


   public function getQuotationStatus($id){

       $data = RequestQuotation::where('fk_i_request_id',$id)->get();
       $status = 0;
       foreach ($data as $d){
           if($d->i_status == 65){
               $status = 65;
               break;
           }
       }
       if($status == 0){
           $status = 64;
       }
       return $status;

    }

    public function getQuotationAttachment($id){

        return RequestQuotationAttachment::where('fk_i_request_quotation_id',$id)->get();
    }

    public static function getData($id, $con_id)
    {
        return ConversationUser::where("conversation_id", $con_id)->whereNotIn("user_id", [$id])
            ->join('t_user as tu', 'tu.pk_i_id', '=', 'conversation_user.user_id')
            ->first();
    }
    public static function getQuestionOptions($question_id)
    {
        $data = ServiceQuestionOptionsView::where('fk_i_question_id', $question_id)->get();
        return $data;
    }

    public static function getQuestionChecked($service_provider_id,$service_id, $question_id)
    {
        $check = SPQuestionAnswer::where([
            'fk_i_service_provider_id' => $service_provider_id,
            'fk_i_service_id' => $service_id,
            'fk_i_question_id' => $question_id
        ])->count();
        if($check == 0){
            return '';
        }else{
            return 'checked';
        }
    }
    public static function getOptionsChecked($service_provider_id,$service_id, $question_id,$option_id)
    {
        $check = SPQuestionAnswer::where([
            'fk_i_service_provider_id' => $service_provider_id,
            'fk_i_service_id' => $service_id,
            'fk_i_question_id' => $question_id,
            'fk_i_option_id' => $option_id
        ])->count();
        if($check == 0){
            return '';
        }else{
            return 'checked';
        }
    }

    public static function getCheckedCity($city_id, $provider_id)
    {
        $speciality = SPCities::where(['fk_i_service_provider_id' => $provider_id, 'fk_i_city_id' => $city_id])->first();
        if ($speciality) {
            return 'checked';
        } else {
            return '';
        }
    }

    static function sum_the_time($time1, $time2)
    {
        $times = array($time1, $time2);
        $seconds = 0;
        foreach ($times as $time) {
            list($hour, $minute, $second) = explode(':', $time);
            $seconds += $hour * 3600;
            $seconds += $minute * 60;
            $seconds += $second;
        }
        $hours = floor($seconds / 3600);
        $seconds -= $hours * 3600;
        $minutes = floor($seconds / 60);
        $seconds -= $minutes * 60;
        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }

    static function getColor($id)
    {
        switch ($id) {
            case '33':
                return '#C8D046';
                break;

            case '32':
                return '#3598DC';
                break;

            case '29':
                return '#26C281';
                break;

            case '31':
                return '#8E44AD';
                break;

            case '28':
                return '#E7505A';
                break;

            case '30':
                return '#E1E5EC';
                break;

        }
    }


}