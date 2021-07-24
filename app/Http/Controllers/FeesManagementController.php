<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Family;
use DB;
use App\FamilyFeesDetail;
use App\Classes;
use App\Models\FeesManagementModel;
use App\FeesPayment;
use PDF;
use File;
use Storage;
use App\Helpers\HelperService;


class FeesManagementController extends Controller{
    
    public function __construct(FeesManagementModel $feesManagementModel){
        $this->feesManagementModel = $feesManagementModel;
    }

    public function index(){
        return view('fees.search_student');
    }

    public function searchStudentAutoComplete(Request $request){
        $search = $request->get('student_name');
        $result = $this->feesManagementModel->getStudentDetail($search);
        return response()->json($result);
    }

    public function searchStudentDetails(Request $request){
        $id = $request->input('id');
        $studentDetails = Student::find($id);
        if(!empty($studentDetails)){
            $result = $this->feesManagementModel->getFamilyFeesDetail($studentDetails->id);
            if($result->balance<1){
                $data = array(
                    'status' => 0,
                    'message' => 'Full fees already paid.'
                );
            }else{
                $data = array(
                    'status' => 1,
                    'id'     => base64_encode($studentDetails->id)
                );
            }
        }else{
            $data = array(
                'status' => 0
            );
        }
        return response()->json($data);
    }

    public function showFeesEntryForm(Request $request){
    	$studentId = base64_decode($request->id);
        $result = $this->feesManagementModel->getFamilyFeesDetail($studentId);
 		return view('fees.add_fees',compact('result'));
    }

    public function addFees(Request $request){ 

        if(empty($request->receivedFee)){
            return [
                'error' => 'Fee is required'
            ];
        } 
                
        $oldRemaining = $request->oldRemaining;
        $sessionFees = $request->sessionFees;
        $previousDeposited = $request->previous;
        $discount = $request->discount?$request->discount:0;
        $totalBalance = $request->totalBalance;
        $receivedFee = $request->receivedFee;
        $familyId = $request->fid;
        $currentSession = HelperService::getCurrentSession()->session;
        $currentSessionId = HelperService::getCurrentSession()->id;
          
        // Start transaction!
        DB::beginTransaction();
        try{

            $studentsDetail = $this->feesManagementModel->getFamilyStudentsDetail($familyId);
                
            $receiptData = array(
                'session' => $currentSession,
                'date'    => date('d/m/Y'),
                'studentsDetail' => $studentsDetail,
                'oldRemaining' => $oldRemaining,
                'sessionFee' => $sessionFees,
                'previousDeposited' => $previousDeposited,
                'discount'      => $discount,
                'totalBalance' => $totalBalance,
                'receivedFee' => $receivedFee,
                'remainingFee' => $totalBalance - $receivedFee
            );        
            $feesPayment = new FeesPayment();
            $feesPayment->family_id = $familyId;
            $feesPayment->previous_deposited = $previousDeposited;
            $feesPayment->discount = $discount;
            $feesPayment->total_balance = $totalBalance;
            $feesPayment->paid_amount = $receivedFee;
            $feesPayment->payment_date = date('Y-m-d');
            $feesPayment->save();
            $feesPaymentId = $feesPayment->id;

            $familyFeesDetail = FamilyFeesDetail::where(['family_id' => $familyId, 'session' => $currentSessionId])->first();
            $familyFeesDetail->paid_fees += $receivedFee;
            $familyFeesDetail->discount += $discount;
            $familyFeesDetail->save();  
        
            $path = public_path('fees-receipts/');  
            $directoryName = 'receipt_'.$familyId;
            
            if(!File::exists($path.$directoryName)){
                File::makeDirectory($path.$directoryName);
            }
            $receiptData['receiptNo'] = $feesPaymentId;

            $filePath = $path.$directoryName.'/'.$feesPaymentId;
            $pdf=PDF::loadView('receipt-pdf',$receiptData);
            $pdf->save($filePath.'.pdf');
            DB::commit();

            return response()->json(array(
                'success' => 'Fees added successfully',
                'link' => asset('fees-receipts/receipt_').$familyId.'/'.$feesPaymentId.'.pdf'
            ));
        }catch(\Exception $exception){
            info('error occured in fees entry with error message '.$exception->getMessage());    
            DB::rollback();
            return [
                'error' => 'Please try again'
            ];
        }
        
    }


    public function searchFeesDetail(){
        return view('fees.search_fees_detail');
    }

    public function showStudentFeesDetail(Request $request){
        $familyId = $request->id;
        return view('fees.fees_detail',compact('familyId'));
    }

    public function getStudentPaymentsList(Request $request){
        if(!empty($request->id))
            $familyId = base64_decode($request->id);
        else
            $familyId = 0;

        $columns = array( 
                0 => 'id',
                1 => 'paid_amount',
                2 => 'payment_date'
            );
        if($request->input('order.0.column') != ''){
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');
        }else{
            $order = 'id';
            $dir = 'desc';
        }

        $limit = $request->input('length');
        $offset = $request->input('start');
        $search = $request->input('search.value');

        
        $feesPaymentData = $this->feesManagementModel->getFeesPaymentDetail($limit, $offset, $order, $dir, $search, $flag = 1,$familyId);
        $feesPaymentDataCount = count($feesPaymentData);
        $payments = $this->feesManagementModel->getFeesPaymentDetail($limit, $offset, $order, $dir, $search, $flag = 0,$familyId);
        
        $data = collect();
        if(!empty($payments) && count($payments) > 0){
            foreach($payments as $res_val){
                $row = [
                    'receipt'=> $res_val->id,
                    'amount'=> $res_val->paid_amount,
                    'date'=> date('d/m/Y',strtotime($res_val->payment_date)),
                    'action' => '<a  href="'.asset('fees-receipts/receipt_').$familyId.'/'.$res_val->id.'.pdf'.'" target="_blank" class="m-btn edit-ccuser"><i class="fa fa-pencil"></i>Print Receipt</a> '
                ] ;
                $data->push($row);
            }
        }

        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($feesPaymentDataCount),  
                    "recordsFiltered" => intval($feesPaymentDataCount), 
                    "data"            => $data   
                    );
        return response()->json( $json_data );
    }

}