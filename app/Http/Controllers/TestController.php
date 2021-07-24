<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentModel;
use Storage;
use App\Helpers\HelperService;


class TestController extends Controller{

	//it's constructor and it load js and mail service helper
    public function __construct(StudentModel $studentModel){
        $this->studentModel = $studentModel;
    }

    public function index(){
    	return view('test.marks-sheet');
    }

    public function downloadTestMarksSheet(Request $request){
        $class = $request->class;
        $prePrimaryClasses = array(
            1,2,3
        );
        $primaryClasses = array(
            4,5,6,7,8
        );
        $middleClasses = array(
            9,10,11
        );

        if(in_array($class, $prePrimaryClasses)){
            $path = public_path('pre-primary-test-sheet.xlsx');  
            $styleRange = 'A7:I100';
            $fileName = "pre-primary-test-data.xlsx";

        }elseif (in_array($class, $primaryClasses)) {
            $path = public_path('primary-test-sheet.xlsx'); 
            $styleRange = 'A7:J100';
            $fileName = "primary-test-data.xlsx";


        }elseif(in_array($class, $middleClasses)){
            $path = public_path('middle-test-sheet.xlsx'); 
            $styleRange = 'A7:L100';
            $fileName = "middle-test-data.xlsx";
        }

        if(!empty($path)){
            $studentsData = $this->studentModel->getClassStudents($class);
            if(!empty($studentsData) && count($studentsData)){
                $className = $studentsData[0]->className;

                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                $spreadsheet = $reader->load($path);

                $styleArray = array(
                  'alignment' => array(
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT
                  )
                );
                $spreadsheet->getActiveSheet()->getStyle($styleRange)->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->setShowGridlines(true);
                $spreadsheet->getActiveSheet()->getPageSetup()
                            ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                $spreadsheet->getActiveSheet()->setCellValue('B3', date('F'));
                $spreadsheet->getActiveSheet()->setCellValue('F3', $className);
                $spreadsheet->getActiveSheet()->setCellValue('F1', HelperService::getCurrentSession()->session);
                $excelData = array();

                foreach ($studentsData as $key => $studentData) {
                    $excelData[] = array(
                        $key+1 , $studentData->full_name , $studentData->father_name
                    );
                }
                
                $spreadsheet->getActiveSheet()->fromArray(
                    $excelData,  // The data to set
                    NULL,        // Array values with this value will not be set
                    'A7'         // Top left coordinate of the worksheet range where
                                 //    we want to set these values (default is A1)
                );
                $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

                $writer->save($fileName);
                $downloadFileName = $className.'_'.date('F').'_'.HelperService::getCurrentSession()->session.'.xlsx';
                return response()->download($fileName,$downloadFileName);
            }else{
                return redirect()->back()->with('error','No record found');
            }
        }else{
             return redirect()->back()->with('error','No file found');
        }
        
    }

}