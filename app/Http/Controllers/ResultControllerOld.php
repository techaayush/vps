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
use App\Result;
use PDF;
use File;
use Storage;
use App\CoCurricularSubjectsGrades;
use App\TestMarks;
use App\ExamMarks;
use App\ProjectMarks;
use App\ResultMetaData;
use App\Helpers\HelperService;

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
            $examType = trim($sheetData[2][1]);
            $classGroup = trim($sheetData[3][1]);
            
            if($request->class != $classGroup){
                return redirect()->back()->with('error','Please select right class group');
            }

            $session = HelperService::getCurrentSession()->id;

            if($classGroup=='Pre-Primary'){
                for($count=7;$count<$length;$count++){
                    $this->storePrePrimaryResult($sheetData[$count],$examType,$session);
                } 
            }elseif ($classGroup=='Primary'){
                for($count=7;$count<$length;$count++){
                    $this->storePrimaryResult($sheetData[$count],$examType,$session);
                }
            }elseif ($classGroup=='Middle'){
                for($count=7;$count<$length;$count++){
                    $this->storeMiddleResult($sheetData[$count],$examType,$session);
                }
            }
            
            try{
                DB::beginTransaction();

                if(!empty($this->examAddData)){
                    ExamMarks::insert($this->examAddData);
                }
                if(!empty($this->coCurricularAddData)){
                    CoCurricularSubjectsGrades::insert($this->coCurricularAddData);
                }
                if(!empty($this->resultMetaAddData)){
                    ResultMetaData::insert($this->resultMetaAddData);
                }
                if(!empty($this->testAddData)){
                    TestMarks::insert($this->testAddData);
                }
                if(!empty($this->projectAddData)){
                    ProjectMarks::insert($this->projectAddData);
                }
                DB::commit();
                return redirect()->back()->with('success','Result uploaded successfully');
            }catch(\Exception $exception){
                info('error occured in result uploading with error message '.$exception->getMessage());    
                DB::rollback();
                return redirect()->back()->with('error','Please try again');
            }
        }
        return view('result.upload-result');
    }



    protected function storePrePrimaryResult($studentResultInformation,$examType,$session){
        $numberOfSubjects = 3;
        $scholarNumber = trim($studentResultInformation[0]);
        // $session = trim($studentResultInformation[1]);
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

                for ($j=0; $j < $numberOfSubjects ; $j++) {
                    $examMarks = new ExamMarks();
                    $examMarks->session = $session;
                    $examMarks->scholar_number = $scholarNumber;
                    $examMarks->exam_type = $examType;
                    $examMarks->subject_id = $j+1;
                    $examMarks->marks = trim($studentResultInformation[$j+2])=='AB'?NULL:trim($studentResultInformation[$j+2]);
                    $examMarks->max_marks = $maxMarksPerSubject;

                    $this->examAddData[] = $examMarks->attributesToArray();
                }

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
                $coCurricularSubjectsGrades->exam_type = $examType;
                $coCurricularSubjectsGrades->grades = json_encode($coCurricularSubjects);

                $this->coCurricularAddData[] = $coCurricularSubjectsGrades->attributesToArray();


                $totalMarks = $maxMarksPerSubject * $numberOfSubjects;

                $total = $hindiMarks + $englishMarks + $mathsMarks;
                $percentage = ($total/$totalMarks) * 100;


                $resultMetaData = new ResultMetaData();
                $resultMetaData->session = $session;
                $resultMetaData->scholar_number = $scholarNumber;
                $resultMetaData->exam_type = $examType;
                $resultMetaData->present_days = $daysPresent;
                $resultMetaData->total_days = $totalDays;
                $resultMetaData->result_total = $total;   
                $resultMetaData->total_marks = $totalMarks;   
                $resultMetaData->result_percentage = $percentage;    
                $resultMetaData->created_at = date('Y-m-d H:i:s');    
                $resultMetaData->updated_at = date('Y-m-d H:i:s');    

                $this->resultMetaAddData[] = $resultMetaData->attributesToArray();



                /*$totalMarks = $maxMarksPerSubject * $numberOfSubjects;

                $total = ($hindiMarks=='AB'?0:$hindiMarks) + ($englishMarks=='AB'?0:$englishMarks) + ($mathsMarks=='AB'?0:$mathsMarks);
                $percentage = ($total/$totalMarks) * 100;


                $result = Result::where('scholar_number',$scholarNumber)->where('session',$session)->first();
                        
                if(!empty($result)){
                    $marks = $result->marks;
                    $marks[$examType] = array(
                        'hindi_marks' => $hindiMarks,
                        'english_marks' => $englishMarks,
                        'maths_marks' => $mathsMarks,
                        'co_curricular_subjects' => array(
                            'DRAWING' => 'A',
                            'HEALTH' => 'A',
                            'APTITUDE' => 'B',
                            'HONESTY' => 'A',
                            'CREATIVITY' => 'B'
                        ),
                        'total' => 10,
                        'days_attended' => 10,
                        'total_days' => 20,
                        'id' => $result->id
                    );
                    $this->resultUpdateData[] = $marks;
                }else{
                    $marks = array(
                        $examType => array(
                            'hindi_marks' => $hindiMarks,
                            'english_marks' => $englishMarks,
                            'maths_marks'   => $mathsMarks,
                            'max_marks_per_subject' => $maxMarksPerSubject,
                            'co_curricular_subjects' => array(
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
                            ),
                            'total_marks' => $total,
                            'days_attended' => $daysPresent,
                            'total_days' => $totalDays
                        ) 
                    );

                    $result = new Result();
                    $result->session = $session;
                    $result->scholar_number= $scholarNumber;
                    $result->marks= json_encode($marks);
                    $result->created_at= date('Y-m-d H:i:s');
                    $result->updated_at= date('Y-m-d H:i:s');
                
                    $this->resultAddData[] = $result->attributesToArray();

                }  */              
           
        }
    }


    protected function storePrimaryResult($studentResultInformation,$examType,$session){
        $numberOfSubjects = 4;
        $scholarNumber = trim($studentResultInformation[0]);
        // $session = trim($studentResultInformation[1]);
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


        if(!empty($scholarNumber) && !empty($session) && !empty($hindiMarks) && !empty($englishMarks) && !empty($mathsMarks) && !empty($evsMarks) && !empty($maxMarksPerSubject) && !empty($totalDays) && !empty($daysPresent)){

                $examMarks = new ExamMarks();
                $examMarks->session = $session;
                $examMarks->scholar_number = $scholarNumber;
                $examMarks->exam_type = $examType;
                $examMarks->subject_id = 1;
                $examMarks->marks = $hindiMarks;
                $examMarks->max_marks = $maxMarksPerSubject;

                $this->examAddData[] = $examMarks->attributesToArray();


                $examMarks = new ExamMarks();
                $examMarks->session = $session;
                $examMarks->scholar_number = $scholarNumber;
                $examMarks->exam_type = $examType;
                $examMarks->subject_id = 2;
                $examMarks->marks = $englishMarks;
                $examMarks->max_marks = $maxMarksPerSubject;

                $this->examAddData[] = $examMarks->attributesToArray();


                $examMarks = new ExamMarks();
                $examMarks->session = $session;
                $examMarks->scholar_number = $scholarNumber;
                $examMarks->exam_type = $examType;
                $examMarks->subject_id = 3;
                $examMarks->marks = $mathsMarks;
                $examMarks->max_marks = $maxMarksPerSubject;

                $this->examAddData[] = $examMarks->attributesToArray();

                $examMarks = new ExamMarks();
                $examMarks->session = $session;
                $examMarks->scholar_number = $scholarNumber;
                $examMarks->exam_type = $examType;
                $examMarks->subject_id = 7;
                $examMarks->marks = $evsMarks;
                $examMarks->max_marks = $maxMarksPerSubject;

                $this->examAddData[] = $examMarks->attributesToArray();

                if($examType=='annual'){
                            
                    $testMarks = new TestMarks();
                    $testMarks->session = $session;
                    $testMarks->scholar_number = $scholarNumber;
                    $testMarks->subject_id = 1;
                    $testMarks->marks = $hindiTestMarks;
                    $testMarks->max_marks = $maxTestMarks;

                    $this->testAddData[] = $testMarks->attributesToArray();

                    $testMarks = new TestMarks();
                    $testMarks->session = $session;
                    $testMarks->scholar_number = $scholarNumber;
                    $testMarks->subject_id = 2;
                    $testMarks->marks = $englishTestMarks;
                    $testMarks->max_marks = $maxTestMarks;

                    $this->testAddData[] = $testMarks->attributesToArray();

                    $testMarks = new TestMarks();
                    $testMarks->session = $session;
                    $testMarks->scholar_number = $scholarNumber;
                    $testMarks->subject_id = 3;
                    $testMarks->marks = $mathsTestMarks;
                    $testMarks->max_marks = $maxTestMarks;

                    $this->testAddData[] = $testMarks->attributesToArray();

                    $testMarks = new TestMarks();
                    $testMarks->session = $session;
                    $testMarks->scholar_number = $scholarNumber;
                    $testMarks->subject_id = 7;
                    $testMarks->marks = $evsTestMarks;
                    $testMarks->max_marks = $maxTestMarks;

                    $this->testAddData[] = $testMarks->attributesToArray();
                }
                
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
                $coCurricularSubjectsGrades->exam_type = $examType;
                $coCurricularSubjectsGrades->grades = json_encode($coCurricularSubjects);

                $this->coCurricularAddData[] = $coCurricularSubjectsGrades->attributesToArray();

                $totalMarks = $maxMarksPerSubject * $numberOfSubjects;

                $total = $hindiMarks + $englishMarks + $mathsMarks + $evsMarks;
                $percentage = ($total/$totalMarks) * 100;


                $resultMetaData = new ResultMetaData();
                $resultMetaData->session = $session;
                $resultMetaData->scholar_number = $scholarNumber;
                $resultMetaData->exam_type = $examType;
                $resultMetaData->present_days = $daysPresent;
                $resultMetaData->total_days = $totalDays;
                $resultMetaData->result_total = $total;   
                $resultMetaData->total_marks = $totalMarks;   
                $resultMetaData->result_percentage = $percentage;    
                $resultMetaData->created_at = date('Y-m-d H:i:s');    
                $resultMetaData->updated_at = date('Y-m-d H:i:s');    

                $this->resultMetaAddData[] = $resultMetaData->attributesToArray();

        }

    }

    protected function storeMiddleResult($studentResultInformation,$examType,$session){
        $numberOfSubjects = 6;
        $scholarNumber = trim($studentResultInformation[0]);
        // $session = trim($studentResultInformation[1]);
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

                $examMarks = new ExamMarks();
                $examMarks->session = $session;
                $examMarks->scholar_number = $scholarNumber;
                $examMarks->exam_type = $examType;
                $examMarks->subject_id = 1;
                $examMarks->marks = $hindiMarks;
                $examMarks->max_marks = $maxMarksPerSubject;

                $this->examAddData[] = $examMarks->attributesToArray();


                $examMarks = new ExamMarks();
                $examMarks->session = $session;
                $examMarks->scholar_number = $scholarNumber;
                $examMarks->exam_type = $examType;
                $examMarks->subject_id = 2;
                $examMarks->marks = $englishMarks;
                $examMarks->max_marks = $maxMarksPerSubject;

                $this->examAddData[] = $examMarks->attributesToArray();


                $examMarks = new ExamMarks();
                $examMarks->session = $session;
                $examMarks->scholar_number = $scholarNumber;
                $examMarks->exam_type = $examType;
                $examMarks->subject_id = 3;
                $examMarks->marks = $mathsMarks;
                $examMarks->max_marks = $maxMarksPerSubject;

                $this->examAddData[] = $examMarks->attributesToArray();

                $examMarks = new ExamMarks();
                $examMarks->session = $session;
                $examMarks->scholar_number = $scholarNumber;
                $examMarks->exam_type = $examType;
                $examMarks->subject_id = 4;
                $examMarks->marks = $sanskritMarks;
                $examMarks->max_marks = $maxMarksPerSubject;

                $this->examAddData[] = $examMarks->attributesToArray();

                $examMarks = new ExamMarks();
                $examMarks->session = $session;
                $examMarks->scholar_number = $scholarNumber;
                $examMarks->exam_type = $examType;
                $examMarks->subject_id = 5;
                $examMarks->marks = $scienceMarks;
                $examMarks->max_marks = $maxMarksPerSubject;

                $this->examAddData[] = $examMarks->attributesToArray();

                $examMarks = new ExamMarks();
                $examMarks->session = $session;
                $examMarks->scholar_number = $scholarNumber;
                $examMarks->exam_type = $examType;
                $examMarks->subject_id = 6;
                $examMarks->marks = $socialMarks;
                $examMarks->max_marks = $maxMarksPerSubject;

                $this->examAddData[] = $examMarks->attributesToArray();

                if($examType=='annual'){

                    $testMarks = new TestMarks();
                    $testMarks->session = $session;
                    $testMarks->scholar_number = $scholarNumber;
                    $testMarks->subject_id = 1;
                    $testMarks->marks = $hindiTestMarks;
                    $testMarks->max_marks = $maxTestMarks;

                    $this->testAddData[] = $testMarks->attributesToArray();

                    $testMarks = new TestMarks();
                    $testMarks->session = $session;
                    $testMarks->scholar_number = $scholarNumber;
                    $testMarks->subject_id = 2;
                    $testMarks->marks = $englishTestMarks;
                    $testMarks->max_marks = $maxTestMarks;

                    $this->testAddData[] = $testMarks->attributesToArray();

                    $testMarks = new TestMarks();
                    $testMarks->session = $session;
                    $testMarks->scholar_number = $scholarNumber;
                    $testMarks->subject_id = 3;
                    $testMarks->marks = $mathsTestMarks;
                    $testMarks->max_marks = $maxTestMarks;

                    $this->testAddData[] = $testMarks->attributesToArray();

                    $testMarks = new TestMarks();
                    $testMarks->session = $session;
                    $testMarks->scholar_number = $scholarNumber;
                    $testMarks->subject_id = 4;
                    $testMarks->marks = $sanskritTestMarks;
                    $testMarks->max_marks = $maxTestMarks;

                    $this->testAddData[] = $testMarks->attributesToArray();

                    $testMarks = new TestMarks();
                    $testMarks->session = $session;
                    $testMarks->scholar_number = $scholarNumber;
                    $testMarks->subject_id = 5;
                    $testMarks->marks = $scienceTestMarks;
                    $testMarks->max_marks = $maxTestMarks;

                    $this->testAddData[] = $testMarks->attributesToArray();

                    $testMarks = new TestMarks();
                    $testMarks->session = $session;
                    $testMarks->scholar_number = $scholarNumber;
                    $testMarks->subject_id = 6;
                    $testMarks->marks = $socialTestMarks;
                    $testMarks->max_marks = $maxTestMarks;

                    $this->testAddData[] = $testMarks->attributesToArray();


                    $projectMarks = new ProjectMarks();
                    $projectMarks->session = $session;
                    $projectMarks->scholar_number = $scholarNumber;
                    $projectMarks->subject_id = 1;
                    $projectMarks->marks = $hindiProjectMarks;
                    $projectMarks->max_marks = $maxProjectMarks;

                    $this->projectAddData[] = $projectMarks->attributesToArray();

                    $projectMarks = new ProjectMarks();
                    $projectMarks->session = $session;
                    $projectMarks->scholar_number = $scholarNumber;
                    $projectMarks->subject_id = 2;
                    $projectMarks->marks = $englishProjectMarks;
                    $projectMarks->max_marks = $maxProjectMarks;

                    $this->projectAddData[] = $projectMarks->attributesToArray();

                    $projectMarks = new ProjectMarks();
                    $projectMarks->session = $session;
                    $projectMarks->scholar_number = $scholarNumber;
                    $projectMarks->subject_id = 3;
                    $projectMarks->marks = $mathsProjectMarks;
                    $projectMarks->max_marks = $maxProjectMarks;

                    $this->projectAddData[] = $projectMarks->attributesToArray();

                    $projectMarks = new ProjectMarks();
                    $projectMarks->session = $session;
                    $projectMarks->scholar_number = $scholarNumber;
                    $projectMarks->subject_id = 4;
                    $projectMarks->marks = $sanskritProjectMarks;
                    $projectMarks->max_marks = $maxProjectMarks;

                    $this->projectAddData[] = $projectMarks->attributesToArray();

                    $projectMarks = new ProjectMarks();
                    $projectMarks->session = $session;
                    $projectMarks->scholar_number = $scholarNumber;
                    $projectMarks->subject_id = 5;
                    $projectMarks->marks = $scienceProjectMarks;
                    $projectMarks->max_marks = $maxProjectMarks;

                    $this->projectAddData[] = $projectMarks->attributesToArray();

                    $projectMarks = new ProjectMarks();
                    $projectMarks->session = $session;
                    $projectMarks->scholar_number = $scholarNumber;
                    $projectMarks->subject_id = 6;
                    $projectMarks->marks = $socialProjectMarks;
                    $projectMarks->max_marks = $maxProjectMarks;

                    $this->projectAddData[] = $projectMarks->attributesToArray();
                }

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
                $coCurricularSubjectsGrades->exam_type = $examType;
                $coCurricularSubjectsGrades->grades = json_encode($coCurricularSubjects);

                $this->coCurricularAddData[] = $coCurricularSubjectsGrades->attributesToArray();

                $totalMarks = $maxMarksPerSubject * $numberOfSubjects;

                $total = $hindiMarks + $englishMarks + $mathsMarks + $sanskritMarks + $socialMarks + $scienceMarks;
                $percentage = ($total/$totalMarks) * 100;


                $resultMetaData = new ResultMetaData();
                $resultMetaData->session = $session;
                $resultMetaData->scholar_number = $scholarNumber;
                $resultMetaData->exam_type = $examType;
                $resultMetaData->present_days = $daysPresent;
                $resultMetaData->total_days = $totalDays;
                $resultMetaData->result_total = $total;  
                $resultMetaData->total_marks = $totalMarks;  
                $resultMetaData->result_percentage = $percentage;    
                $resultMetaData->created_at = date('Y-m-d H:i:s');    
                $resultMetaData->updated_at = date('Y-m-d H:i:s');    

                $this->resultMetaAddData[] = $resultMetaData->attributesToArray();

        }


    }

    public function getResult(){
        $result = ExamMarks::select();
        // $result = PrePrimaryMarks::where(['student_id'=>16,'session'=>'2019-2020'])->first();

        // $hindiMarks = $result->hindi_marks;
        // $englishMarks = $result->english_marks;
        // $mathsMarks = $result->maths_marks;

        // $maxMarksPerSubject = $result->max_marks_per_subject;
        // $per = 10/$maxMarksPerSubject*100;
        // $hindiGrade = '';
        // echo getGradeForPercentage($per);die;

        // $result->percentage = $percentage;
        //      $result->update();

        // DB::beginTransaction();
        // do all your updates here

        // foreach ($this->resultUpdateData as $result) {
        //     $id = $result['annual']['id'];
        //     unset($result['annual']['id']);
        

        //     Result::where('id', '=', $id)
        //         ->update([
        //             'marks' => json_encode($result)  
        //         ]);
        // }
        // when do
        // DB::commit();
    }

}
