<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Family;
use DB;
use App\Models\StudentModel;
use App\FamilyFeesDetail;
use App\Classes;
use Validator;
use App\Helpers\HelperService;

class StudentController extends Controller {
    
    public function __construct(StudentModel $studentModel){
        $this->studentModel = $studentModel;
    }

    public function index(){
        return view('student.search_family');
    }

    public function searchFamilyAutoComplete(Request $request){
        $search = $request->get('student_name');
        $result = $this->studentModel->getFamilyDetail($search);
        return response()->json($result);
    }

    public function searchFamilyDetails(Request $request){
        $familyId = $request->input('id');
        $familyDetails = Family::find($familyId);
        if(!empty($familyDetails)){
            $data = array(
                'status' => 1,
                'id'     => base64_encode($familyDetails->id)
            );
        }else{
            $data = array(
                'status' => 0
            );
        }
        return response()->json($data);
    }

    public function showRegisterationForm(Request $request){
//        $sessions = getAdmissionSessions();
        $familyDetails = Family::find(base64_decode($request->id));
        return view('student.register',compact('familyDetails','sessions'));
    }

    public function registerStudent(Request $request){
        /*validation*/
        $rules = array(
            'name'                  => 'required',
            'gender'                => 'required',
            'dob'                   => 'required',
            'age'                   => 'required',
            'class'                 => 'required',
            'admission_date'        => 'required',
            'session'               => 'required',
            'religion'              => 'required',
            'caste'                 => 'required',
            'caste_category'        => 'required',
            'address'               => 'required',
            'place'                 => 'required',
            'contact_1'             => 'required',
            'scholar_no'            => 'required|unique:students,scholar_number',
            'family_code'           => 'required'
        );
        $validator = Validator::make($request->all(), $rules, 
            [
                'scholar_no.unique' => 'Scholar number has already been taken'
            ]
        );

        if ($validator->fails()){
            info('student registeration validation request Failed');
            foreach ($validator->errors()->all() as $key => $value){
                return $response = [
                    'error' => $value
                ];
            }
        }
        
        $session = HelperService::getCurrentSession()->id;
        
        // Start transaction!
        DB::beginTransaction();
        try{
            $familyDetails = Family::firstOrNew(['id' => $request->family_code]);
            $familyDetails->father_name = $request->father_name;
            $familyDetails->father_occupation = $request->father_occupation;
            $familyDetails->mother_name = $request->mother_name;
            $familyDetails->mother_occupation = $request->mother_occupation;
            $familyDetails->save();


            $studentDetails = new Student();
            $studentDetails->scholar_number = $request->scholar_no;
            $studentDetails->family_id = $request->family_code;
            $studentDetails->full_name = $request->name;
            $studentDetails->gender = $request->gender;
            $studentDetails->dob = date('Y-m-d',strtotime(str_replace('/','-',$request->dob)));
            $studentDetails->age = $request->age;
            $studentDetails->class_id = $request->class;
            $studentDetails->religion = $request->religion;
            $studentDetails->caste = $request->caste;
            $studentDetails->caste_category = $request->caste_category;
            $studentDetails->address = $request->address;
            $studentDetails->place = $request->place;
            $studentDetails->phone_one = $request->contact_1;
            $studentDetails->phone_two = $request->contact_2;
            $studentDetails->previous_school_name = $request->previous_school;
            $studentDetails->previous_school_class = $request->previous_school_class;
            $studentDetails->aadhar_number = $request->aadhar_no;
            $studentDetails->samagra_id = $request->samagra_id;
            $studentDetails->bank_account_number = $request->bank_account;
            $studentDetails->ifsc = $request->ifsc;
            $studentDetails->admission_date = date('Y-m-d',strtotime(str_replace('/','-',$request->admission_date)));
            $studentDetails->created_at = date('Y-m-d H:i:s');
            $studentDetails->save();

            $classFee = Classes::select('yearly_fees')->where('id',$request->class)->first();
            $familyFeesDetail = FamilyFeesDetail::where(['family_id' => $request->family_code,'session' => $session])->first();
            if(!empty($familyFeesDetail)){
                // update 
                $familyFeesDetail->yearly_fees += $classFee->yearly_fees ;
                $familyFeesDetail->save();

            }else{
                // new entry
                $familyFeesDetail = new FamilyFeesDetail();
                $familyFeesDetail->family_id = $request->family_code;
                $familyFeesDetail->session = $session;
                $familyFeesDetail->yearly_fees = $classFee->yearly_fees;
                $familyFeesDetail->save();
            }
            DB::commit();
            return [
                'success' => 'Student registered successfully'
            ];
        }catch(\Exception $exception){
            info('error occured in student registeration with error message '.$exception->getMessage());    
            DB::rollback();
            return [
                'error' => 'Please try again'
            ];
        }
    }

    public function studentsList(){
        return view('student.students-list');
    }

    public function getStudentsList(Request $request){
        $columns = array( 
            0 => 'full_name',
            1 => 'class_id',
            2 => 'father_name',
            3 => 'status'
        );
        if($request->input('order.0.column') != ''){
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');
        }else{
            $order = 'class_id';
            $dir = 'desc';
        }

        $limit = $request->input('length');
        $offset = $request->input('start');
        $search = $request->input('search.value');

        
        $studentsData = $this->studentModel->getStudentsData($limit, $offset, $order, $dir, $search, $flag = 1);
        $studentsDataCount = count($studentsData);
        $students = $this->studentModel->getStudentsData($limit, $offset, $order, $dir, $search, $flag = 0);
        
        $data = collect();
        if(!empty($students) && count($students) > 0){
            foreach($students as $res_val){
                $row = [
                    'studentName'=> $res_val->studentName,
                    'class'=> $res_val->class,
                    'fatherName'=> $res_val->fatherName,
                    'status'=> $res_val->status == 1 ? 'Available' : 'Left',
                    'action'=>' <a  href="'.route('edit-student',base64_encode($res_val->studentId)).'" class="m-btn edit-ccuser"><i class="fa fa-pencil"></i> Edit</a> '
                ] ;
                $data->push($row);
            }
        }

        $jsonData = array(
            "draw"            => intval($request->input('draw')),  
            "recordsTotal"    => intval($studentsDataCount),  
            "recordsFiltered" => intval($studentsDataCount), 
            "data"            => $data   
        );
        return response()->json( $jsonData );   
    }


    public function editStudent(Request $request){
        $studentId = base64_decode($request->id);
        $studentDetails = $this->studentModel->getStudentDetailById($studentId);
        return view('student.edit-student',compact('studentDetails'));
    }

    public function editStudentDetails(Request $request){
        /*validation*/
        $rules = array(
             'name'                  => 'required',
             'address'               => 'required',
             'place'                 => 'required',
             'contact_1'             => 'required',
             'status'                => 'required'
        );
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()){
            info('student updation validation request Failed');
            foreach ($validator->errors()->all() as $key => $value){
                return $response = [
                    'error' => $value
                ];
            }
        }
        if(empty($request->sid)){
            return [
                'error' => 'Please try again'
            ];
        }

        $studentId = base64_decode($request->sid);

        // Start transaction!
        DB::beginTransaction();
        try{
            $studentDetails = Student::where('id',$studentId)->first();
            $studentDetails->full_name = $request->name;
            $studentDetails->address = $request->address;
            $studentDetails->place = $request->place;
            $studentDetails->phone_one = $request->contact_1;
            $studentDetails->phone_two = $request->contact_2;
            $studentDetails->previous_school_name = $request->previous_school;
            $studentDetails->previous_school_class = $request->previous_school_class;
            $studentDetails->aadhar_number = $request->aadhar_no;
            $studentDetails->samagra_id = $request->samagra_id;
            $studentDetails->bank_account_number = $request->bank_account;
            $studentDetails->ifsc = $request->ifsc;
            $studentDetails->status = $request->status;
            $studentDetails->save();


            $familyDetails = Family::where(['id' => $studentDetails->family_id])->first();
            $familyDetails->father_name = $request->father_name;
            $familyDetails->father_occupation = $request->father_occupation;
            $familyDetails->mother_name = $request->mother_name;
            $familyDetails->mother_occupation = $request->mother_occupation;
            $familyDetails->save();

            DB::commit();
            return [
                'success' => 'Student updated successfully'
            ];
        }catch(\Exception $exception){        
            info('error occured in student updation with error message '.$exception->getMessage());    
            DB::rollback();
            return [
                'error' => 'Please try again'
            ];
        }
    }


    public function showAttendenceSheet(Request $request){
        if($request->isMethod('post')){
            $class = $request->class;
            $studentsData = $this->studentModel->getClassStudents($class);
            $session = HelperService::getCurrentSession()->session;
            return view('attendance.sheet')->with('studentsList',$studentsData)->with('session',$session);
        }
        return view('attendance.class-attendence-sheet');
    }
}
