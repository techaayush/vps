<?php
namespace App\Models;
use DB;
class FeesManagementModel
{
    protected $connection;
    //it's for data base connection
    function __construct() {
        $this->connection = DB::connection();
    }


   public function getStudentFeesDetail($studentId){
       return $query = $this->connection->table('family as f')->select(['s.full_name as name','f.father_name','c.name as c','ffd.*'])
           ->Join('students as s', 's.family_id', '=', 'f.id')
           ->Join('family_fees_detail as ffd', 'ffd.family_id', '=', 's.family_id')
           ->Join('class as c', 'c.id', '=', 's.class_id')
           // ->where([['s.id',$studentId],['status',1],['ffd.session',config('vps.currentSession')]])->toSql();
           ->where(['s.id' => $studentId,'status' => 1,'ffd.session' => config('vps.currentSession')])->first();
   }

}