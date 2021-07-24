<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes;
use App\AcademicYearHistory;
use App\AcademicSession;
use App\Helpers\HelperService;
use DB;

/**
 * 
 */
class ClassController extends Controller{
	
	public function __construct(){
		
	}

	public function editClassForm(){
        $classes = Classes::all();
        return view('edit_class',compact('classes'));
    }

    public function editClass(Request $request){

        try{
            DB::beginTransaction();
            for ($i=1; $i <= count($request->yearly_fees); $i++) { 
                Classes::where('id', $i)
                        ->update([
                            'yearly_fees' => $request->yearly_fees[$i]
                        ]);

                $academicYearHistory = AcademicYearHistory::firstOrNew(['class_id' => $i,'session' => HelperService::getCurrentSession()->id]);
                $academicYearHistory->session = HelperService::getCurrentSession()->id;
                $academicYearHistory->class_id = $i;
                $academicYearHistory->yearly_fees = $request->yearly_fees[$i];
                $academicYearHistory->save();
            }  
            DB::commit();
        }catch(\Exception $exception){
            DB::rollback();
        }           
        return redirect('edit_class');
    }

}