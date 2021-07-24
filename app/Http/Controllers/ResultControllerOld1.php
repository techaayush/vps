<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Family;
use DB;
use App\Models\StudentModel;
use App\FamilyFeesDetail;
use App\Classes;
use App\Models\FeesManagementModel;
use PDF;
use File;
use Storage;
use App\CoCurricularSubjectsGrades;
use App\TestMarks;
use App\Marks;
use App\ProjectMarks;
use App\ResultMetaData;
use App\Helpers\HelperService;
use App\AcademicSession;
use App\AssessmentType;
use Exception;

class ResultController extends Controller{
    
    public function __construct(){
        
    }


    public function store(Request $request){
        $this->examAddData = array();
        $this->examUpdateData = array();
        
        $this->testAddData = array();
        $this->testUpdateData = array();
        
        $this->projectAddData = array();
        $this->projectUpdateData = array();
        
        $this->coCurricularAddData = array();
        $this->coCurricularUpdateData = array();
        
        $this->resultMetaAddData = array();
        $this->resultMetaUpdateData = array();
            
        if(isset($_POST['upload']) && isset($_FILES)){   
                        
            $path = $_FILES["file"]["tmp_name"];
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $spreadsheet = $reader->load($path);
            
            $sheetData = $spreadsheet->getActiveSheet()->toArray();      
            $length = count($sheetData);
            $classGroup = trim($sheetData[3][1]);
            
            if($request->class != $classGroup){
                return redirect()->back()->with('error','Please select right class group');
            }

            $assessmentType = AssessmentType::where('category',trim($sheetData[2][1]))->first();
            if(empty($assessmentType))
                return redirect()->back()->with('error','Please insert right exam');

            $session = HelperService::getCurrentSession()->id;

            try{
                DB::beginTransaction();

                if($classGroup=='Pre-Primary'){
                    if($assessmentType==3){
                        for($count=7;$count<$length;$count++){
                            $this->storePrePrimaryAnnualResult($sheetData[$count],$assessmentType->id,$session);
                        }
                    }else{
                        for($count=7;$count<$length;$count++){
                            $this->storePrePrimaryQuaterlyAndHalfYearlyResult($sheetData[$count],$assessmentType->id,$session);
                        }
                    }
                }elseif ($classGroup=='Primary'){
                    if($assessmentType==3){
                        for($count=7;$count<$length;$count++){
                            $this->storePrimaryAnnualResult($sheetData[$count],$assessmentType->id,$session);
                        }
                    }else{
                        for($count=7;$count<$length;$count++){
                            $this->storePrimaryQuaterlyAndHalfYearlyResult($sheetData[$count],$assessmentType->id,$session);
                        }
                    }
                }elseif ($classGroup=='Middle'){
                    if($assessmentType==3){
                        for($count=7;$count<$length;$count++){
                            $this->storeMiddleAnnualResult($sheetData[$count],$assessmentType->id,$session);
                        }
                    }else{
                        for($count=7;$count<$length;$count++){
                            $this->storeMiddleQuaterlyAndHalfYearlyResult($sheetData[$count],$assessmentType->id,$session);
                        }
                    }
                }
                DB::commit();
                return redirect()->back()->with('success','Result uploaded successfully');
            }catch(\Exception $exception){
                info('error occured in result uploading with error message '.$exception->getMessage());   
                DB::rollback();
                return redirect()->back()->with('error','Please try again'); 
            }
            
        }
        $classes = Classes::all();
        return view('result.upload-result',compact('classes'));
    }



    private function storePrePrimaryQuaterlyAndHalfYearlyResult($studentResultInformation,$assessmentType,$session){
        $numberOfSubjects = 3;
        $scholarNumber = trim($studentResultInformation[1]);
        $hindiMarks = trim($studentResultInformation[2]);
        $englishMarks = trim($studentResultInformation[3]);
        $mathsMarks = trim($studentResultInformation[4]);
        $maxMarksPerSubject = trim($studentResultInformation[5]);
        $drawingGrade = trim($studentResultInformation[6]);
        $healthGrade = trim($studentResultInformation[7]);
        $gamesGrade = trim($studentResultInformation[8]);
        $literaryGrade = trim($studentResultInformation[9]);
        $scientificGrade = trim($studentResultInformation[10]);
        $culturalGrade = trim($studentResultInformation[11]);
        $creativityGrade = trim($studentResultInformation[12]);
        $coOperationGrade = trim($studentResultInformation[13]);
        $punctualityGrade = trim($studentResultInformation[14]);
        $cleanlinessGrade = trim($studentResultInformation[15]);
        $disciplineGrade = trim($studentResultInformation[16]);
        $regularityGrade = trim($studentResultInformation[17]);
        $aptitudeGrade = trim($studentResultInformation[18]);
        $truthnessGrade = trim($studentResultInformation[19]);
        $evsAwarenessGrade = trim($studentResultInformation[20]);
        $leadershipGrade = trim($studentResultInformation[21]);
        $honestyGrade = trim($studentResultInformation[22]);
        $totalDays = trim($studentResultInformation[23]);
        $daysPresent = trim($studentResultInformation[24]);


        if(!empty($scholarNumber) && !empty($session) && !empty($hindiMarks) && !empty($englishMarks) && !empty($mathsMarks) && !empty($maxMarksPerSubject) && !empty($totalDays) && !empty($daysPresent)){


                $hindiMarks = ($hindiMarks=='AB')?NULL:$hindiMarks;
                $englishMarks = ($englishMarks=='AB')?NULL:$englishMarks;
                $mathsMarks = ($mathsMarks=='AB')?NULL:$mathsMarks;
                

                $totalMarks = $maxMarksPerSubject * $numberOfSubjects;

                $total = $hindiMarks + $englishMarks + $mathsMarks;
                $percentage = ($total/$totalMarks) * 100;

            

                // $resultMetaData = new ResultMetaData();
                // $resultMetaData->session = $session;
                // $resultMetaData->scholar_number = $scholarNumber;
                // $resultMetaData->assessment_type = $assessmentType;
                // $resultMetaData->present_days = $daysPresent;
                // $resultMetaData->total_days = $totalDays;
                // $resultMetaData->result_total = $total;  
                // $resultMetaData->total_marks = $totalMarks;  
                // $resultMetaData->result_percentage = $percentage;    
                // $resultMetaData->created_at = date('Y-m-d H:i:s');    
                // $resultMetaData->updated_at = date('Y-m-d H:i:s');    
                // $resultMetaData->save();



                // info('resultdata '.$scholarNumber.' is '.$resultMetaData->id);

                $marks = new Marks();
                $marks->session = $session;
                $marks->scholar_number = $scholarNumber;
                $marks->assessment_type = $assessmentType;
                $marks->subject_id = 1;
                $marks->marks_obtained = $hindiMarks;
                // $marks->max_marks = $maxMarksPerSubject;
                // $marks->result_id = $resultMetaData->id;
                $marks->save();


                $marks = new Marks();
                $marks->session = $session;
                $marks->scholar_number = $scholarNumber;
                $marks->assessment_type = $assessmentType;
                $marks->subject_id = 2;
                $marks->marks_obtained = $englishMarks;
                $marks->save();


                $marks = new Marks();
                $marks->session = $session;
                $marks->scholar_number = $scholarNumber;
                $marks->assessment_type = $assessmentType;
                $marks->subject_id = 3;
                $marks->marks_obtained = $mathsMarks;
                $marks->save();

                $coCurricularSubjects = array(
                    'DRAWING' => $drawingGrade,
                    'HEALTH' => $healthGrade,
                    'GAMES' => $gamesGrade,
                    'LITERARY' => $literaryGrade,
                    'SCIENTIFIC' => $scientificGrade,
                    'CULTURAL' => $culturalGrade,
                    'CREATIVITY' => $creativityGrade,
                    'CO_OPERATION' => $coOperationGrade,
                    'PUNCTUALITY' => $punctualityGrade,
                    'CLEANLINESS' => $cleanlinessGrade,
                    'DISCIPLINE' => $disciplineGrade,
                    'REGULARITY' => $regularityGrade,
                    'APTITUDE' => $aptitudeGrade,
                    'TRUTHNESS' => $truthnessGrade,
                    'EVS_AWARENESS' => $evsAwarenessGrade,
                    'LEADERSHIP' => $leadershipGrade,
                    'HONESTY' => $honestyGrade
                );

                $coCurricularSubjectsGrades = new CoCurricularSubjectsGrades();
                $coCurricularSubjectsGrades->session = $session;
                $coCurricularSubjectsGrades->scholar_number = $scholarNumber;
                $coCurricularSubjectsGrades->assessment_type = $assessmentType;
                $coCurricularSubjectsGrades->grades = json_encode($coCurricularSubjects);
                $coCurricularSubjectsGrades->save();

        }
    }

    private function storePrePrimaryAnnualResult($studentResultInformation,$assessmentType,$session){
        $numberOfSubjects = 3;
        $scholarNumber = trim($studentResultInformation[1]);
        $hindiMarks = trim($studentResultInformation[2]);
        $englishMarks = trim($studentResultInformation[3]);
        $mathsMarks = trim($studentResultInformation[4]);
        $maxMarksPerSubject = trim($studentResultInformation[5]);
        $drawingGrade = trim($studentResultInformation[6]);
        $healthGrade = trim($studentResultInformation[7]);
        $gamesGrade = trim($studentResultInformation[8]);
        $literaryGrade = trim($studentResultInformation[9]);
        $scientificGrade = trim($studentResultInformation[10]);
        $culturalGrade = trim($studentResultInformation[11]);
        $creativityGrade = trim($studentResultInformation[12]);
        $coOperationGrade = trim($studentResultInformation[13]);
        $punctualityGrade = trim($studentResultInformation[14]);
        $cleanlinessGrade = trim($studentResultInformation[15]);
        $disciplineGrade = trim($studentResultInformation[16]);
        $regularityGrade = trim($studentResultInformation[17]);
        $aptitudeGrade = trim($studentResultInformation[18]);
        $truthnessGrade = trim($studentResultInformation[19]);
        $evsAwarenessGrade = trim($studentResultInformation[20]);
        $leadershipGrade = trim($studentResultInformation[21]);
        $honestyGrade = trim($studentResultInformation[22]);
        $totalDays = trim($studentResultInformation[23]);
        $daysPresent = trim($studentResultInformation[24]);


        if(!empty($scholarNumber) && !empty($session) && !empty($hindiMarks) && !empty($englishMarks) && !empty($mathsMarks) && !empty($maxMarksPerSubject) && !empty($totalDays) && !empty($daysPresent)){


                $hindiMarks = ($hindiMarks=='AB')?NULL:$hindiMarks;
                $englishMarks = ($englishMarks=='AB')?NULL:$englishMarks;
                $mathsMarks = ($mathsMarks=='AB')?NULL:$mathsMarks;
                

                $totalMarks = $maxMarksPerSubject * $numberOfSubjects;

                $total = $hindiMarks + $englishMarks + $mathsMarks;
                $percentage = ($total/$totalMarks) * 100;

            

                $marks = new Marks();
                $marks->session = $session;
                $marks->scholar_number = $scholarNumber;
                $marks->assessment_type = $assessmentType;
                $marks->subject_id = 1;
                $marks->marks_obtained = $hindiMarks;
                $marks->save();


                $marks = new Marks();
                $marks->session = $session;
                $marks->scholar_number = $scholarNumber;
                $marks->assessment_type = $assessmentType;
                $marks->subject_id = 2;
                $marks->marks_obtained = $englishMarks;
                $marks->save();


                $marks = new Marks();
                $marks->session = $session;
                $marks->scholar_number = $scholarNumber;
                $marks->assessment_type = $assessmentType;
                $marks->subject_id = 3;
                $marks->marks_obtained = $mathsMarks;
                $marks->save();

                $coCurricularSubjects = array(
                    'DRAWING' => $drawingGrade,
                    'HEALTH' => $healthGrade,
                    'GAMES' => $gamesGrade,
                    'LITERARY' => $literaryGrade,
                    'SCIENTIFIC' => $scientificGrade,
                    'CULTURAL' => $culturalGrade,
                    'CREATIVITY' => $creativityGrade,
                    'CO_OPERATION' => $coOperationGrade,
                    'PUNCTUALITY' => $punctualityGrade,
                    'CLEANLINESS' => $cleanlinessGrade,
                    'DISCIPLINE' => $disciplineGrade,
                    'REGULARITY' => $regularityGrade,
                    'APTITUDE' => $aptitudeGrade,
                    'TRUTHNESS' => $truthnessGrade,
                    'EVS_AWARENESS' => $evsAwarenessGrade,
                    'LEADERSHIP' => $leadershipGrade,
                    'HONESTY' => $honestyGrade
                );

                $coCurricularSubjectsGrades = new CoCurricularSubjectsGrades();
                $coCurricularSubjectsGrades->session = $session;
                $coCurricularSubjectsGrades->scholar_number = $scholarNumber;
                $coCurricularSubjectsGrades->assessment_type = $assessmentType;
                $coCurricularSubjectsGrades->grades = json_encode($coCurricularSubjects);
                $coCurricularSubjectsGrades->save();

        }
    }


    private function storePrimaryQuaterlyAndHalfYearlyResult($studentResultInformation,$assessmentType,$session){
        $numberOfSubjects = 4;
        $scholarNumber = trim($studentResultInformation[1]);
        $hindiMarks = trim($studentResultInformation[2]);
        $englishMarks = trim($studentResultInformation[3]);
        $mathsMarks = trim($studentResultInformation[4]);
        $evsMarks = trim($studentResultInformation[5]);
        
        
        $maxMarksPerSubject = trim($studentResultInformation[6]);

        $drawingGrade = trim($studentResultInformation[7]);
        $healthGrade = trim($studentResultInformation[8]);
        $gamesGrade = trim($studentResultInformation[9]);
        $literaryGrade = trim($studentResultInformation[10]);
        $scientificGrade = trim($studentResultInformation[11]);
        $culturalGrade = trim($studentResultInformation[12]);
        $creativityGrade = trim($studentResultInformation[13]);
        $coOperationGrade = trim($studentResultInformation[14]);
        $punctualityGrade = trim($studentResultInformation[15]);
        $cleanlinessGrade = trim($studentResultInformation[16]);
        $disciplineGrade = trim($studentResultInformation[17]);
        $regularityGrade = trim($studentResultInformation[18]);
        $aptitudeGrade = trim($studentResultInformation[19]);
        $truthnessGrade = trim($studentResultInformation[20]);
        $evsAwarenessGrade = trim($studentResultInformation[21]);
        $leadershipGrade = trim($studentResultInformation[22]);
        $honestyGrade = trim($studentResultInformation[23]);

        $totalDays = trim($studentResultInformation[29]);
        $daysPresent = trim($studentResultInformation[30]);     
        

        if(!empty($scholarNumber) && !empty($session) && !empty($hindiMarks) && !empty($englishMarks) && !empty($mathsMarks) && !empty($evsMarks) && !empty($maxMarksPerSubject) && !empty($totalDays) && !empty($daysPresent)){

                
                $hindiMarks = ($hindiMarks=='AB')?NULL:$hindiMarks;
                $englishMarks = ($englishMarks=='AB')?NULL:$englishMarks;
                $mathsMarks = ($mathsMarks=='AB')?NULL:$mathsMarks;
                $evsMarks = ($evsMarks=='AB')?NULL:$evsMarks;

                $totalMarks = $maxMarksPerSubject * $numberOfSubjects;

                $total = $hindiMarks + $englishMarks + $mathsMarks + $evsMarks;
                $percentage = ($total/$totalMarks) * 100;


                $marks = new Marks();
                $marks->session = $session;
                $marks->scholar_number = $scholarNumber;
                $marks->assessment_type = $assessmentType;
                $marks->subject_id = 1;
                $marks->marks_obtained = $hindiMarks;
                $marks->save();



                $marks = new Marks();
                $marks->session = $session;
                $marks->scholar_number = $scholarNumber;
                $marks->assessment_type = $assessmentType;
                $marks->subject_id = 2;
                $marks->marks_obtained = $englishMarks;
                $marks->save();
               

                $marks = new Marks();
                $marks->session = $session;
                $marks->scholar_number = $scholarNumber;
                $marks->assessment_type = $assessmentType;
                $marks->subject_id = 3;
                $marks->marks_obtained = $mathsMarks;
                $marks->save();


                $marks = new Marks();
                $marks->session = $session;
                $marks->scholar_number = $scholarNumber;
                $marks->assessment_type = $assessmentType;
                $marks->subject_id = 7;
                $marks->marks_obtained = $evsMarks;
                $marks->save();


                $coCurricularSubjects = array(
                    'DRAWING' => $drawingGrade,
                    'HEALTH' => $healthGrade,
                    'GAMES' => $gamesGrade,
                    'LITERARY' => $literaryGrade,
                    'SCIENTIFIC' => $scientificGrade,
                    'CULTURAL' => $culturalGrade,
                    'CREATIVITY' => $creativityGrade,
                    'CO_OPERATION' => $coOperationGrade,
                    'PUNCTUALITY' => $punctualityGrade,
                    'CLEANLINESS' => $cleanlinessGrade,
                    'DISCIPLINE' => $disciplineGrade,
                    'REGULARITY' => $regularityGrade,
                    'APTITUDE' => $aptitudeGrade,
                    'TRUTHNESS' => $truthnessGrade,
                    'EVS_AWARENESS' => $evsAwarenessGrade,
                    'LEADERSHIP' => $leadershipGrade,
                    'HONESTY' => $honestyGrade
                );

                $coCurricularSubjectsGrades = new CoCurricularSubjectsGrades();
                $coCurricularSubjectsGrades->session = $session;
                $coCurricularSubjectsGrades->scholar_number = $scholarNumber;
                $coCurricularSubjectsGrades->assessment_type = $assessmentType;
                $coCurricularSubjectsGrades->grades = json_encode($coCurricularSubjects);
                $coCurricularSubjectsGrades->save();
        }else{
            throw new Exception('Please fill required fields in sheet.');
        }

    }

    private function storePrimaryAnnualResult($studentResultInformation,$assessmentType,$session){
        $numberOfSubjects = 4;
        $scholarNumber = trim($studentResultInformation[1]);
        $hindiMarks = trim($studentResultInformation[2]);
        $englishMarks = trim($studentResultInformation[3]);
        $mathsMarks = trim($studentResultInformation[4]);
        $evsMarks = trim($studentResultInformation[5]);
        
        
        $maxMarksPerSubject = trim($studentResultInformation[6]);

        $drawingGrade = trim($studentResultInformation[7]);
        $healthGrade = trim($studentResultInformation[8]);
        $gamesGrade = trim($studentResultInformation[9]);
        $literaryGrade = trim($studentResultInformation[10]);
        $scientificGrade = trim($studentResultInformation[11]);
        $culturalGrade = trim($studentResultInformation[12]);
        $creativityGrade = trim($studentResultInformation[13]);
        $coOperationGrade = trim($studentResultInformation[14]);
        $punctualityGrade = trim($studentResultInformation[15]);
        $cleanlinessGrade = trim($studentResultInformation[16]);
        $disciplineGrade = trim($studentResultInformation[17]);
        $regularityGrade = trim($studentResultInformation[18]);
        $aptitudeGrade = trim($studentResultInformation[19]);
        $truthnessGrade = trim($studentResultInformation[20]);
        $evsAwarenessGrade = trim($studentResultInformation[21]);
        $leadershipGrade = trim($studentResultInformation[22]);
        $honestyGrade = trim($studentResultInformation[23]);

        $hindiTestMarks = trim($studentResultInformation[24]);
        $englishTestMarks = trim($studentResultInformation[25]);
        $mathsTestMarks = trim($studentResultInformation[26]);
        $evsTestMarks = trim($studentResultInformation[27]);

        $maxTestMarks = trim($studentResultInformation[28]);


        $totalDays = trim($studentResultInformation[29]);
        $daysPresent = trim($studentResultInformation[30]);     
        

        if(!empty($scholarNumber) && !empty($session) && !empty($hindiMarks) && !empty($englishMarks) && !empty($mathsMarks) && !empty($evsMarks) && !empty($maxMarksPerSubject) && !empty($totalDays) && !empty($daysPresent) && !empty($hindiTestMarks) && !empty($englishTestMarks) && !empty($mathsTestMarks) && !empty($evsTestMarks) && !empty($maxTestMarks)){

                    $hindiMarks = ($hindiMarks=='AB')?NULL:$hindiMarks;
                    $englishMarks = ($englishMarks=='AB')?NULL:$englishMarks;
                    $mathsMarks = ($mathsMarks=='AB')?NULL:$mathsMarks;
                    $evsMarks = ($evsMarks=='AB')?NULL:$evsMarks;

                    

                    $hindiTestMarks = ($hindiTestMarks=='AB')?NULL:$hindiTestMarks;
                    $englishTestMarks = ($englishTestMarks=='AB')?NULL:$englishTestMarks;
                    $mathsTestMarks = ($mathsTestMarks=='AB')?NULL:$mathsTestMarks;
                    $evsTestMarks = ($evsTestMarks=='AB')?NULL:$evsTestMarks;

                    $totalMarks = $maxMarksPerSubject * $numberOfSubjects;

                    $total = $hindiMarks + $englishMarks + $mathsMarks + $evsMarks;
                    $percentage = ($total/$totalMarks) * 100;


                    // $testMarks = new TestMarks();
                    // $testMarks->session = $session;
                    // $testMarks->scholar_number = $scholarNumber;
                    // $testMarks->subject_id = 1;
                    // $testMarks->marks_obtained = $hindiTestMarks;
                    // $testMarks->max_marks = $maxTestMarks;
                    // $testMarks->result_id = $resultMetaData->id;


                    $marks = new Marks();
                    $marks->session = $session;
                    $marks->scholar_number = $scholarNumber;
                    $marks->assessment_type = $assessmentType;
                    $marks->subject_id = 1;
                    $marks->marks_obtained = $hindiMarks;
                    $marks->save();



                    $marks = new Marks();
                    $marks->session = $session;
                    $marks->scholar_number = $scholarNumber;
                    $marks->assessment_type = $assessmentType;
                    $marks->subject_id = 2;
                    $marks->marks_obtained = $englishMarks;
                    $marks->save();
                   

                    $marks = new Marks();
                    $marks->session = $session;
                    $marks->scholar_number = $scholarNumber;
                    $marks->assessment_type = $assessmentType;
                    $marks->subject_id = 3;
                    $marks->marks_obtained = $mathsMarks;
                    $marks->save();


                    $marks = new Marks();
                    $marks->session = $session;
                    $marks->scholar_number = $scholarNumber;
                    $marks->assessment_type = $assessmentType;
                    $marks->subject_id = 7;
                    $marks->marks_obtained = $evsMarks;
                    $marks->save();


                    $coCurricularSubjects = array(
                        'DRAWING' => $drawingGrade,
                        'HEALTH' => $healthGrade,
                        'GAMES' => $gamesGrade,
                        'LITERARY' => $literaryGrade,
                        'SCIENTIFIC' => $scientificGrade,
                        'CULTURAL' => $culturalGrade,
                        'CREATIVITY' => $creativityGrade,
                        'CO_OPERATION' => $coOperationGrade,
                        'PUNCTUALITY' => $punctualityGrade,
                        'CLEANLINESS' => $cleanlinessGrade,
                        'DISCIPLINE' => $disciplineGrade,
                        'REGULARITY' => $regularityGrade,
                        'APTITUDE' => $aptitudeGrade,
                        'TRUTHNESS' => $truthnessGrade,
                        'EVS_AWARENESS' => $evsAwarenessGrade,
                        'LEADERSHIP' => $leadershipGrade,
                        'HONESTY' => $honestyGrade
                    );

                    $coCurricularSubjectsGrades = new CoCurricularSubjectsGrades();
                    $coCurricularSubjectsGrades->session = $session;
                    $coCurricularSubjectsGrades->scholar_number = $scholarNumber;
                    $coCurricularSubjectsGrades->assessment_type = $assessmentType;
                    $coCurricularSubjectsGrades->grades = json_encode($coCurricularSubjects);
                    $coCurricularSubjectsGrades->save();
        }else{
            throw new Exception('Please fill required fields in sheet.');
        }

    }

    private function storeMiddleQuaterlyAndHalfYearlyResult($studentResultInformation,$assessmentType,$session){
        $numberOfSubjects = 6;
        $scholarNumber = trim($studentResultInformation[1]);
        $hindiMarks = trim($studentResultInformation[2]);
        $englishMarks = trim($studentResultInformation[3]);
        $mathsMarks = trim($studentResultInformation[4]);
        $sanskritMarks = trim($studentResultInformation[5]);
        $scienceMarks = trim($studentResultInformation[6]);
        $socialMarks = trim($studentResultInformation[7]);


        $maxMarksPerSubject = trim($studentResultInformation[8]);

        $drawingGrade = trim($studentResultInformation[9]);
        $healthGrade = trim($studentResultInformation[10]);
        $gamesGrade = trim($studentResultInformation[11]);
        $literaryGrade = trim($studentResultInformation[12]);
        $scientificGrade = trim($studentResultInformation[13]);
        $culturalGrade = trim($studentResultInformation[14]);
        $creativityGrade = trim($studentResultInformation[15]);
        $coOperationGrade = trim($studentResultInformation[16]);
        $punctualityGrade = trim($studentResultInformation[17]);
        $cleanlinessGrade = trim($studentResultInformation[18]);
        $disciplineGrade = trim($studentResultInformation[19]);
        $regularityGrade = trim($studentResultInformation[20]);
        $aptitudeGrade = trim($studentResultInformation[21]);
        $truthnessGrade = trim($studentResultInformation[22]);
        $evsAwarenessGrade = trim($studentResultInformation[23]);
        $leadershipGrade = trim($studentResultInformation[24]);
        $honestyGrade = trim($studentResultInformation[25]);

        $hindiTestMarks = trim($studentResultInformation[26]);
        $englishTestMarks = trim($studentResultInformation[27]);
        $mathsTestMarks = trim($studentResultInformation[28]);
        $sanskritTestMarks = trim($studentResultInformation[29]);
        $scienceTestMarks = trim($studentResultInformation[30]);
        $socialTestMarks = trim($studentResultInformation[31]);

        $maxTestMarks = trim($studentResultInformation[32]);

        $hindiProjectMarks = trim($studentResultInformation[33]);
        $englishProjectMarks = trim($studentResultInformation[34]);
        $mathsProjectMarks = trim($studentResultInformation[35]);
        $sanskritProjectMarks = trim($studentResultInformation[36]);
        $scienceProjectMarks = trim($studentResultInformation[37]);
        $socialProjectMarks = trim($studentResultInformation[38]);

        $maxProjectMarks = trim($studentResultInformation[39]);


        $totalDays = trim($studentResultInformation[40]);
        $daysPresent = trim($studentResultInformation[41]);


        if(!empty($scholarNumber) && !empty($session) && !empty($hindiMarks) && !empty($englishMarks) && !empty($mathsMarks) && !empty($sanskritMarks) && !empty($scienceMarks) && !empty($socialMarks) && !empty($maxMarksPerSubject) && !empty($totalDays) && !empty($daysPresent)){

                $hindiMarks = ($hindiMarks=='AB')?NULL:$hindiMarks;
                $englishMarks = ($englishMarks=='AB')?NULL:$englishMarks;
                $mathsMarks = ($mathsMarks=='AB')?NULL:$mathsMarks;
                $evsMarks = ($evsMarks=='AB')?NULL:$evsMarks;
                $evsMarks = ($evsMarks=='AB')?NULL:$evsMarks;
                $evsMarks = ($evsMarks=='AB')?NULL:$evsMarks;

                $totalMarks = $maxMarksPerSubject * $numberOfSubjects;

                $total = $hindiMarks + $englishMarks + $mathsMarks + $evsMarks;
                $percentage = ($total/$totalMarks) * 100;

                

                $totalMarks = $maxMarksPerSubject * $numberOfSubjects;
                $total = $hindiMarks + $englishMarks + $mathsMarks + $sanskritMarks + $socialMarks + $scienceMarks;
                $percentage = ($total/$totalMarks) * 100;


                $marks = new Marks();
                $marks->session = $session;
                $marks->scholar_number = $scholarNumber;
                $marks->assessment_type = $assessmentType;
                $marks->subject_id = 1;
                $marks->marks_obtained = $hindiMarks;
                $marks->save();


                // $this->examAddData[] = $marks->attributesToArray();


                $marks = new Marks();
                $marks->session = $session;
                $marks->scholar_number = $scholarNumber;
                $marks->assessment_type = $assessmentType;
                $marks->subject_id = 2;
                $marks->marks_obtained = $englishMarks;
                $marks->save();

                // $this->examAddData[] = $marks->attributesToArray();


                $marks = new Marks();
                $marks->session = $session;
                $marks->scholar_number = $scholarNumber;
                $marks->assessment_type = $assessmentType;
                $marks->subject_id = 3;
                $marks->marks_obtained = $mathsMarks;
                $marks->save();

                // $this->examAddData[] = $marks->attributesToArray();

                $marks = new Marks();
                $marks->session = $session;
                $marks->scholar_number = $scholarNumber;
                $marks->assessment_type = $assessmentType;
                $marks->subject_id = 4;
                $marks->marks_obtained = $sanskritMarks;
                $marks->save();

                // $this->examAddData[] = $marks->attributesToArray();

                $marks = new Marks();
                $marks->session = $session;
                $marks->scholar_number = $scholarNumber;
                $marks->assessment_type = $assessmentType;
                $marks->subject_id = 5;
                $marks->marks_obtained = $scienceMarks;
                $marks->save();

                // $this->examAddData[] = $marks->attributesToArray();

                $marks = new Marks();
                $marks->session = $session;
                $marks->scholar_number = $scholarNumber;
                $marks->assessment_type = $assessmentType;
                $marks->subject_id = 6;
                $marks->marks_obtained = $socialMarks;
                $marks->save();

                // $this->examAddData[] = $marks->attributesToArray();

                // if($assessmentType==3){

                    // $testMarks = new TestMarks();
                    // $testMarks->session = $session;
                    // $testMarks->scholar_number = $scholarNumber;
                    // $testMarks->subject_id = 6;
                    // $testMarks->marks_obtained = $socialTestMarks;
                    // $testMarks->max_marks = $maxTestMarks;
                    // $testMarks->result_id = $resultMetaData->id;
                    // $testMarks->save();

                    // $this->testAddData[] = $testMarks->attributesToArray();

                    // $projectMarks = new ProjectMarks();
                    // $projectMarks->session = $session;
                    // $projectMarks->scholar_number = $scholarNumber;
                    // $projectMarks->subject_id = 6;
                    // $projectMarks->marks_obtained = $socialProjectMarks;
                    // $projectMarks->max_marks = $maxProjectMarks;
                    // $projectMarks->result_id = $resultMetaData->id;
                    // $projectMarks->save();

                    // $this->projectAddData[] = $projectMarks->attributesToArray();
                // }

                $coCurricularSubjects = array(
                    'DRAWING' => $drawingGrade,
                    'HEALTH' => $healthGrade,
                    'GAMES' => $gamesGrade,
                    'LITERARY' => $literaryGrade,
                    'SCIENTIFIC' => $scientificGrade,
                    'CULTURAL' => $culturalGrade,
                    'CREATIVITY' => $creativityGrade,
                    'CO_OPERATION' => $coOperationGrade,
                    'PUNCTUALITY' => $punctualityGrade,
                    'CLEANLINESS' => $cleanlinessGrade,
                    'DISCIPLINE' => $disciplineGrade,
                    'REGULARITY' => $regularityGrade,
                    'APTITUDE' => $aptitudeGrade,
                    'TRUTHNESS' => $truthnessGrade,
                    'EVS_AWARENESS' => $evsAwarenessGrade,
                    'LEADERSHIP' => $leadershipGrade,
                    'HONESTY' => $honestyGrade
                );

                $coCurricularSubjectsGrades = new CoCurricularSubjectsGrades();
                $coCurricularSubjectsGrades->session = $session;
                $coCurricularSubjectsGrades->scholar_number = $scholarNumber;
                $coCurricularSubjectsGrades->assessment_type = $assessmentType;
                $coCurricularSubjectsGrades->grades = json_encode($coCurricularSubjects);
                $coCurricularSubjectsGrades->save();
        }


    }

    private function storeMiddleAnnualResult($studentResultInformation,$assessmentType,$session){
        $numberOfSubjects = 6;
        $scholarNumber = trim($studentResultInformation[1]);
        $hindiMarks = trim($studentResultInformation[2]);
        $englishMarks = trim($studentResultInformation[3]);
        $mathsMarks = trim($studentResultInformation[4]);
        $sanskritMarks = trim($studentResultInformation[5]);
        $scienceMarks = trim($studentResultInformation[6]);
        $socialMarks = trim($studentResultInformation[7]);


        $maxMarksPerSubject = trim($studentResultInformation[8]);

        $drawingGrade = trim($studentResultInformation[9]);
        $healthGrade = trim($studentResultInformation[10]);
        $gamesGrade = trim($studentResultInformation[11]);
        $literaryGrade = trim($studentResultInformation[12]);
        $scientificGrade = trim($studentResultInformation[13]);
        $culturalGrade = trim($studentResultInformation[14]);
        $creativityGrade = trim($studentResultInformation[15]);
        $coOperationGrade = trim($studentResultInformation[16]);
        $punctualityGrade = trim($studentResultInformation[17]);
        $cleanlinessGrade = trim($studentResultInformation[18]);
        $disciplineGrade = trim($studentResultInformation[19]);
        $regularityGrade = trim($studentResultInformation[20]);
        $aptitudeGrade = trim($studentResultInformation[21]);
        $truthnessGrade = trim($studentResultInformation[22]);
        $evsAwarenessGrade = trim($studentResultInformation[23]);
        $leadershipGrade = trim($studentResultInformation[24]);
        $honestyGrade = trim($studentResultInformation[25]);

        $hindiTestMarks = trim($studentResultInformation[26]);
        $englishTestMarks = trim($studentResultInformation[27]);
        $mathsTestMarks = trim($studentResultInformation[28]);
        $sanskritTestMarks = trim($studentResultInformation[29]);
        $scienceTestMarks = trim($studentResultInformation[30]);
        $socialTestMarks = trim($studentResultInformation[31]);

        $maxTestMarks = trim($studentResultInformation[32]);

        $hindiProjectMarks = trim($studentResultInformation[33]);
        $englishProjectMarks = trim($studentResultInformation[34]);
        $mathsProjectMarks = trim($studentResultInformation[35]);
        $sanskritProjectMarks = trim($studentResultInformation[36]);
        $scienceProjectMarks = trim($studentResultInformation[37]);
        $socialProjectMarks = trim($studentResultInformation[38]);

        $maxProjectMarks = trim($studentResultInformation[39]);


        $totalDays = trim($studentResultInformation[40]);
        $daysPresent = trim($studentResultInformation[41]);


        if(!empty($scholarNumber) && !empty($session) && !empty($hindiMarks) && !empty($englishMarks) && !empty($mathsMarks) && !empty($sanskritMarks) && !empty($scienceMarks) && !empty($socialMarks) && !empty($maxMarksPerSubject) && !empty($totalDays) && !empty($daysPresent)){

                $hindiMarks = ($hindiMarks=='AB')?NULL:$hindiMarks;
                $englishMarks = ($englishMarks=='AB')?NULL:$englishMarks;
                $mathsMarks = ($mathsMarks=='AB')?NULL:$mathsMarks;
                $evsMarks = ($evsMarks=='AB')?NULL:$evsMarks;
                $evsMarks = ($evsMarks=='AB')?NULL:$evsMarks;
                $evsMarks = ($evsMarks=='AB')?NULL:$evsMarks;

                $totalMarks = $maxMarksPerSubject * $numberOfSubjects;

                $total = $hindiMarks + $englishMarks + $mathsMarks + $evsMarks;
                $percentage = ($total/$totalMarks) * 100;

                

                $totalMarks = $maxMarksPerSubject * $numberOfSubjects;
                $total = $hindiMarks + $englishMarks + $mathsMarks + $sanskritMarks + $socialMarks + $scienceMarks;
                $percentage = ($total/$totalMarks) * 100;

                $marks = new Marks();
                $marks->session = $session;
                $marks->scholar_number = $scholarNumber;
                $marks->assessment_type = $assessmentType;
                $marks->subject_id = 1;
                $marks->marks_obtained = $hindiMarks;
                $marks->save();


                $marks = new Marks();
                $marks->session = $session;
                $marks->scholar_number = $scholarNumber;
                $marks->assessment_type = $assessmentType;
                $marks->subject_id = 2;
                $marks->marks_obtained = $englishMarks;
                $marks->save();


                $marks = new Marks();
                $marks->session = $session;
                $marks->scholar_number = $scholarNumber;
                $marks->assessment_type = $assessmentType;
                $marks->subject_id = 3;
                $marks->marks_obtained = $mathsMarks;
                $marks->save();

                $marks = new Marks();
                $marks->session = $session;
                $marks->scholar_number = $scholarNumber;
                $marks->assessment_type = $assessmentType;
                $marks->subject_id = 4;
                $marks->marks_obtained = $sanskritMarks;
                $marks->save();

                $marks = new Marks();
                $marks->session = $session;
                $marks->scholar_number = $scholarNumber;
                $marks->assessment_type = $assessmentType;
                $marks->subject_id = 5;
                $marks->marks_obtained = $scienceMarks;
                $marks->save();

                $marks = new Marks();
                $marks->session = $session;
                $marks->scholar_number = $scholarNumber;
                $marks->assessment_type = $assessmentType;
                $marks->subject_id = 6;
                $marks->marks_obtained = $socialMarks;
                $marks->save();

                // if($assessmentType==3){

                    
                // }

                $coCurricularSubjects = array(
                    'DRAWING' => $drawingGrade,
                    'HEALTH' => $healthGrade,
                    'GAMES' => $gamesGrade,
                    'LITERARY' => $literaryGrade,
                    'SCIENTIFIC' => $scientificGrade,
                    'CULTURAL' => $culturalGrade,
                    'CREATIVITY' => $creativityGrade,
                    'CO_OPERATION' => $coOperationGrade,
                    'PUNCTUALITY' => $punctualityGrade,
                    'CLEANLINESS' => $cleanlinessGrade,
                    'DISCIPLINE' => $disciplineGrade,
                    'REGULARITY' => $regularityGrade,
                    'APTITUDE' => $aptitudeGrade,
                    'TRUTHNESS' => $truthnessGrade,
                    'EVS_AWARENESS' => $evsAwarenessGrade,
                    'LEADERSHIP' => $leadershipGrade,
                    'HONESTY' => $honestyGrade
                );

                $coCurricularSubjectsGrades = new CoCurricularSubjectsGrades();
                $coCurricularSubjectsGrades->session = $session;
                $coCurricularSubjectsGrades->scholar_number = $scholarNumber;
                $coCurricularSubjectsGrades->assessment_type = $assessmentType;
                $coCurricularSubjectsGrades->grades = json_encode($coCurricularSubjects);
                $coCurricularSubjectsGrades->save();
        }


    }

    public function getResult(){
        $result = Marks::select();
    }

}
