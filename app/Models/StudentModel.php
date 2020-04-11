<?php
namespace App\Models;
use DB;
class StudentModel
{
    protected $connection;
    //it's for data base connection
    function __construct() {
        $this->connection = DB::connection();
    }


   public function getFamilyDetail($name)
   {
       return $query = $this->connection->table('students as s')->select(['s.full_name as name','s.family_id as id','f.father_name'])
                       ->Join('family as f', 'f.id', '=', 's.family_id')
                       ->where([['full_name','LIKE',$name.'%'],['status',1]])->get();
   }

   public function getStudentDetail($name){
      return $query = $this->connection->table('students as s')->select(['s.full_name as name','s.id as id','f.father_name'])
                       ->Join('family as f', 'f.id', '=', 's.family_id')
                       ->where([['full_name','LIKE',$name.'%'],['status',1]])->get();
   }
}