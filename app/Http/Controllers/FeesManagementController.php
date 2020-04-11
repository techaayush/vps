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
use App\FeesPayment;

class FeesManagementController extends Controller{
    
    public function __construct(StudentModel $studentModel, FeesManagementModel $feesManagementModel){
        $this->studentModel = $studentModel;
        $this->feesManagementModel = $feesManagementModel;
    }

    public function index(){
        return view('fees.search_student');
    }

    public function searchStudentAutoComplete(Request $request){
        $search = $request->get('student_name');
        $result = $this->studentModel->getStudentDetail($search);
        return response()->json($result);
    }

    public function searchStudentDetails(Request $request){
        $id = $request->input('id');
        $studentDetails = Student::find($id);
        if(!empty($studentDetails)){
            $data = array(
                'status' => 1,
                'id'     => base64_encode($studentDetails->id)
            );
        }else{
            $data = array(
                'status' => 0
            );
        }
        return response()->json($data);
    }



    public function showFeesEntryForm(Request $request){
    	$studentId = base64_decode($request->id);
        $result = $this->feesManagementModel->getStudentFeesDetail($studentId);
 		return view('fees.add_fees',compact('result'));
    }

    public function addFees(Request $request){
        $familyFeesDetail = FamilyFeesDetail::where(['family_id' => 101, 'session' => config('vps.currentSession')])->first();
                echo "<pre>";
                print_r($familyFeesDetail);
                die;
        $oldRemaining = $request->oldRemaining;
        $sessionFees = $request->sessionFees;
        $previousDeposited = $request->previous;
        $discount = $request->discount?$request->discount:0;
        $totalFee = $request->totalFee;
        $receivedFee = $request->receivedFee;
        $familyId = $request->fid;
        $currentSession = config('vps.currentSession');

        if($oldRemaining){
                
        }else{
            $feesPayment = new FeesPayment();
            $feesPayment->family_id = $familyId;
            $feesPayment->previous_deposited = $previousDeposited;
            $feesPayment->discount = $discount;
            $feesPayment->total_fees = $totalFee;
            $feesPayment->paid_amount = $receivedFee;
            $feesPayment->payment_date = date('Y-m-d');
            $feesPayment->remaining = $totalFee - $receivedFee;
            $feesPayment->save();

            $familyFeesDetail = FamilyFeesDetail::where(['family_id' => $familyId, 'session' => $currentSession])->first();
            $familyFeesDetail->yearly_fees -= $discount;
            $familyFeesDetail->paid_fees += $receivedFee;
            $familyFeesDetail->save();  
        }
        

    }

}