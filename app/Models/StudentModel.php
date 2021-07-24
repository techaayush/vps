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


    public function getFamilyDetail($name){
       return $query = $this->connection->table('students as s')->select(['s.full_name as name','s.family_id as id','f.father_name'])
                       ->Join('family as f', 'f.id', '=', 's.family_id')
                       ->where([['full_name','LIKE',$name.'%'],['status',1]])->get();
    }

    public function getStudentsData($limit, $offset, $order, $dir, $search, $flag){
      $query = $this->connection->table('students as s')->select(['s.full_name as studentName','s.status','s.id as studentId','f.father_name as fatherName','c.name as class'])
           ->Join('family as f', 's.family_id', '=', 'f.id')
           ->Join('class as c', 'c.id', '=', 's.class_id');
                   
      if(!empty($search)){
        $query->where(function ($query) use($search) {
            $query->where('s.full_name','LIKE',"{$search}%")
                  ->orWhere('f.father_name','LIKE',"{$search}%")
                  ->orWhere('c.name','LIKE',"{$search}%");
        });
      }
      $query->orderBy($order,$dir);
      if($flag==0)
        $query->offset($offset)->limit($limit);
      return $query->get();   

    }


    public function getStudentDetailById($studentId){
       return $query = $this->connection->table('family as f')->select(['s.*','s.id as studentId','f.*','c.name as className'])
           ->Join('students as s', 's.family_id', '=', 'f.id')
           ->Join('class as c', 'c.id', '=', 's.class_id')
           ->where(['s.id' => $studentId])->first();
    } 

    public function getClassStudents($classId){
        $query = $this->connection->table('family as f')->select(['s.*','f.*','c.name as className'])
           ->Join('students as s', 's.family_id', '=', 'f.id')
           ->Join('class as c', 'c.id', '=', 's.class_id')
           ->where([['s.status',1],['class_id',$classId]]);

        return $query->get();
    }
}