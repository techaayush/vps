<?php
namespace App\Models;
use DB;
use App\Helpers\HelperService;

class FeesManagementModel
{
    protected $connection;
    //it's for data base connection
    function __construct() {
        $this->connection = DB::connection();
    }


    public function getFamilyFeesDetail($studentId){
       return $query = $this->connection->table('family as f')->select(['s.full_name as name','f.father_name','c.name as class','old_remaining','paid_fees','ffd.family_id','ac.session','discount',$this->connection->raw('ffd.yearly_fees-ffd.discount AS session_fees'),$this->connection->raw('old_remaining + ffd.yearly_fees - paid_fees - discount AS balance')])
           ->Join('students as s', 's.family_id', '=', 'f.id')
           ->Join('family_fees_detail as ffd', 'ffd.family_id', '=', 's.family_id')
           ->Join('academic_session as ac', 'ac.id', '=', 'ffd.session')
           ->Join('class as c', 'c.id', '=', 's.class_id')
           ->where(['s.id' => $studentId,'status' => 1,'ffd.session' => HelperService::getCurrentSession()->id])->first();
    }

    public function getFamilyStudentsDetail($familyId){
      return $query = $this->connection->table('family as f')->select(['s.full_name as studentName','f.father_name as fatherName','c.name as class'])
           ->Join('students as s', 's.family_id', '=', 'f.id')
           ->Join('class as c', 'c.id', '=', 's.class_id')
           ->where(['status' => 1,'f.id' => $familyId])->get();
    }

    public function getFeesPaymentDetail($limit, $offset, $order, $dir, $search, $flag,$familyId){
      $query = $this->connection->table('fees_payment as fp')->select(['fp.*']);
      $query->where('family_id',$familyId);             
      if(!empty($search)){
        $query->where(function ($query) use($search) {
            $query->where('id','LIKE',"{$search}%")
                  ->orWhere('paid_amount','LIKE',"{$search}%");
        });
      }
      $query->orderBy($order,$dir);
      if($flag==0)
        $query->offset($offset)->limit($limit);
      return $query->get();   
    }

    public function getStudentDetail($name){
      return $query = $this->connection->table('students as s')->select(['s.full_name as name','s.id as id','f.father_name'])
             ->Join('family as f', 'f.id', '=', 's.family_id')
             ->where([['full_name','LIKE',$name.'%'],['status',1]])->get();
    }

}