<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes;



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
        $currentYear = date('Y');
        $nextYear = date('Y',strtotime('+1 year'));
        for ($i=0; $i < count($request->yearly_fees); $i++) { 
            Classes::where('id', $request->id[$i])
                    ->update([
                        'yearly_fees' => $request->yearly_fees[$i]
                    ]);

            $academicYearHistory = AcademicYearHistory::firstOrNew(['class_id' => $request->id[$i],'session' => $currentYear . '-' . $nextYear]);
            $academicYearHistory->session = $currentYear . '-' . $nextYear;
            $academicYearHistory->class_id = $request->id[$i];
            $academicYearHistory->yearly_fees = $request->yearly_fees[$i];
            $academicYearHistory->save();
        }             
        return redirect('edit_class');
    }

}