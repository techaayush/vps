<?php

namespace App\Helpers;
use App\AcademicSession;


class HelperService {

    static function getCurrentSession(){
        $academicSession = AcademicSession::where('current_session',1)->first();
        return $academicSession;
    }

    function getGradeForPercentage($percentage){
        $grade = '';
        if($percentage >= 75){
            $grade = 'A';
        }elseif ($percentage >= 60) {
            $grade = 'B';
        }elseif ($percentage >= 45) {
            $grade = 'C';
        }elseif ($percentage >= 33) {
            $grade = 'D';
        }else{
            $grade = 'E';
        }
        return $grade;
    }

    function getAdmissionSessions(){
        $month = date('n');
        $session = array();
        $currentYear = date('Y');
        $previousYear = date('Y',strtotime('-1 year'));
        $nextYear = date('Y',strtotime('+1 year'));

        if($month >= 1 && $month <= 6){
            $session[0] = $previousYear . '-' . $currentYear;
            $session[1] = $currentYear . '-' . $nextYear;
        }else{
            $session[0] = $currentYear . '-' . $nextYear;
        }
        return $session;
    }

}