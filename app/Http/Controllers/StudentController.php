<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Family;
use DB;
use App\Models\StudentModel;
use App\FamilyFeesDetail;
use App\Classes;

class StudentController extends Controller
{
    
    public function __construct(StudentModel $studentModel){
        $this->studentModel = $studentModel;
    }

    public function index(){
        return view('student.search_family');
    }

    public function searchFamilyAutoComplete(Request $request){
        $search = $request->get('student_name');
        $result = $this->studentModel->getFamilyDetail($search);

        // $result = Student::select('full_name as name','family_id as id','address')->where('full_name', 'LIKE', ''. $search. '%')->get();
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
        $familyDetails = Family::find(base64_decode($request->id));
        return view('student.register',compact('familyDetails'));
    }

    public function registerStudent(Request $request){
        $session = config('vps.currentSession');
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
            $studentDetails->dob = date('Y-m-d',strtotime($request->dob));
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
            $studentDetails->admission_date = date('Y-m-d',strtotime($request->admission_date));
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
        }catch(\Exception $exception){
            DB::rollback();
        }
    }
}
