<?php

class Api_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();

        $this->load->database('');
    }
    
    // validate login details
public function loginCheck($username, $password) 
    {

        $login_data = $this->db->query('select   u.*  from  users u  where u.reg_no="'.$username.'" and u.password="'.md5($password).'"')->row();
        
       if ($login_data) 
        {
            return $login_data;
        } 
       
        else 
        {
            return false;
        }      
          
    }


  public function getRole($param1='')
    {
         
        $result=$this->db->query('select * from roles where reg_no="'.$param1.'"')->row();
        
        if($result)
        {
          return $result;
        }
        else
        {
            return false;
        }
    }

 
  
 public function getIssuesList(){
   
    $result=$result=$this->db->query('select *from domains where domain="ac"')->row();
    if($result)
        {
          return $result;
        }
        else
        {
            return false;
        }
 }

//  public function getActivites(){
//     $sql="select *from data";
//     $result=$this->db->query($sql)->result();
//    //return $result;
//     if($result){
//         return $result;
//     }else{
//          return false;
//     }
// }

public function getCategories(){
    $result=$this->db->query('SELECT domain,domain_title FROM `domains`')->result();
    if($result){
        return $result;
    }else{
        return false;
    }
}

public function getIssuesListbyCategory($domain){
    $result=$this->db->query('SELECT * FROM data where domain="'.$domain.'"')->result();
    if($result){
        return $result;
    }else{
        return false;
    }
}
public function INSERTISSUE($params){
    $result = $this->db->insert('data',$params);
    if($result){
        return $result;
    }else{
        return false;
    }
}
public function GETDETAILS($param1='')
{
    $result = $this->db->query('SELECT  d.domain_admin, data.*
FROM users r
JOIN domain d
    ON r.reg_no = d.domain_admin
JOIN data
    ON data.domain = d.domain
WHERE domain_admin = "'.$param1.'"');
    if($result){
        return $result;
    }else{
        return false;
    }

}


public function getIssuesListBySelection($param){
  if($param['status']=='all'){
 $result = $this->db->query('SELECT * FROM data WHERE domain="'.$param['category'].'"  and insert_dt BETWEEN "'.$param['from_date'].'" and  DATE_ADD("'.$param['to_date'].'", INTERVAL 1 DAY)')->result();
  }else{
  $result = $this->db->query('SELECT * FROM data WHERE domain="'.$param['category'].'" and status="'.$param['status'].'" and insert_dt BETWEEN "'.$param['from_date'].'" and  DATE_ADD("'.$param['to_date'].'", INTERVAL 1 DAY)')->result();
  }
  if($result){
        return $result;
    }else{
        return false;
    }
}



// public function updateDailywork($param='')
//     {
       
//         $this->db->where('id',$param['id']);
//         $result=  $this->db->update('dailywork',$param);
//         if($result)
//         {
//               return $result;
//         } 
//         else     
//         {
//               return false;
//         }
  
//     }
 

// public function getDailywork($param1='')
//     {
//         $result=$this->db->query('select *from dailywork where user_id="'.$param1.'"')->result();
//         if($result)
//         {
//           return $result;
//         }
//         else
//         {
//             return false;
//         }
//     }

// public function getUsers($param='')
//     {   
//         if($param==''){
//              $result=$this->db->query('select firstname as name, reg_no as id from staff where roll!="hod"')->result();
//         }else{
//             $result=$this->db->query('select firstname as name, reg_no as id from staff where reg_no="'.$param.'"')->result();
//         }
//          if($result)
//         {
//           return $result;
//         }
//         else
//         {
//             return false;
//         }
//     }

// public function getUsersData($param1='',$param2='',$param3='')
//     {
//         //echo 'SELECT from_date as start,to_date as "to",location as resource,description as text, id,user_id FROM `dailywork` where from_date >="'.$param1.'" and to_date<="'.$param2.'" and user_id="1"';
//       //echo $param1.$param2.$param3;
//         if($param3==''){
//         $result=$this->db->query('SELECT from_date as start,to_date as "to",location as resource, description  as text, id,user_id,activity,batch FROM `dailywork` where from_date >="'.$param1.'" and to_date<="'.$param2.'" ')->result();
//         }else{
//            $result=$this->db->query('SELECT from_date as start,to_date as "to",location as resource, description  as text, id,user_id,activity,batch FROM `dailywork` where from_date >="'.$param1.'" and to_date<="'.$param2.'" and user_id="'.$param3.'"')->result();
        
//         }
       
//         if($result)
//         {
//             return $result;
//         }
//         else{
//             return false;
//         }
//     }

// public function getAllUsersData($param1='',$param2='',$param3='')
//     {

//         //echo 'SELECT from_date as start,to_date as "to",location as resource,description as text, id,user_id FROM `dailywork` where from_date >="'.$param1.'" and to_date<="'.$param2.'" and user_id="1"';
//         $result=$this->db->query('SELECT from_date as start,to_date as "to",location as resource, description  as text, id,user_id,activity,batch FROM `dailywork` where from_date >="'.$param1.'" and to_date<="'.$param2.'" and user_id="'.$param3.'"')->result();
//         if($result)
//         {
//             return $result;
//         }
//         else{
//             return false;
//         }
//     }
// public function getActivites(){
//     $result=$this->db->query('select *from activities ORDER by activity ASC')->result();
//     if($result){
//         return $result;
//     }else{
//          return false;
//     }
// }

// public function deleteReport($param1=''){
//     $result=$this->db->query('DELETE  FROM `dailywork` where id="'.$param1.'"');
//     if($result){
//         return $result;
//     }else{
//          return false;
//     }
// }

// public function getMyProfile($param1=''){
//     $result= $this->db->query('select *from staff where reg_no="'.$param1.'"')->row();
//     if($result){ 
//         return $result;
//     } else { 
//         return false; 
//     }
// }

// public function getSubjects($param=''){
//      //echo $param['semister'];
//      //echo $param['course'];
//     $result= $this->db->query('select *from courses where semister="'.$param['semister'].'" and course="'. $param['course'].'"')->result();
//     if($result){ 
//         return $result;
//     } else { 
//         return false; 
//     }  
// }

// public function getStaff(){
//     $result=$this->db->query('select id, CONCAT(firstname,lastname) as name,reg_no,department from staff')->result();
//     if($result){ 
//         return $result;
//     } else { 
//         return false; 
//     } 
// }

// public function addStaffSchedule($param=''){

//     // $data['year'] = $param['years'];
//     // $data['semister'] = $param['semisters'];
//     // $data['course'] = $param['courses'];
//     // $data['subject_id'] = $param['subjects'];
//     $staff = $param['staff'];
//      for($i=0; $i<sizeof($staff); $i++) {
//              $data['year'] = $param['years'];
//                 $data['semister'] = $param['semisters'];
//                 $data['course'] = $param['courses'];
//                 $data['subject_id'] = $param['subjects'];
//              $data['staff_id'] =  $staff[$i]; 
//              $result=$this->db->insert('staff_schedule',$data);
//         }

//     // $result=$this->db->insert('staff_schedule',$data);
//      if($result){
//         return $result;
//      }else{
//         return false;
//      }
// }

// public function getYears(){
//     $result= $this->db->query('select * from years')->result();
//     if($result){
//         return $result;
//      }else{
//         return false;
//      }
// }

// public function getBranches($param=''){
//    $college_id=$param['clz'];
//     $course=$param['course'];
//     $dept=$param['dept'];
     

//     $result= $this->db->query('select * from branches where college_id="'.$college_id.'" and course="'.$course.'" and branch="'.$dept.'"')->result();
//     if($result){
//         return $result;
//      }else{
//         return false;
//      }
// }

// public function getColleges(){
//     $result= $this->db->query('select * from colleges')->result();
//     if($result){
//         return $result;
//      }else{
//         return false;
//      }
// }
// public function getSections(){
//     $result= $this->db->query('select * from sections')->result();
//     if($result){
//         return $result;
//      }else{
//         return false;
//      }
// }

// public function getCourses(){
//     $result= $this->db->query('select * from courses')->result();
//     if($result){
//         return $result;
//      }else{
//         return false;
//      }
// }

// public function addBatch($param=''){

//     $result= $this->db->insert('batches',$param);
//     if($result){
//         return $result;
//     }else{
//         return false;
//     }
// }

// public function getBatches(){
//         $result= $this->db->query('SELECT  bt.id,c.full_name,c.college,cr.course,b.branch, bt.year_id, bt.section_id  FROM batches bt INNER JOIN colleges  c, courses cr , branches b    where  c.id=bt.college_id and  b.id=bt.branch_id AND cr.id=bt.course_id ORDER BY bt.id DESC')->result();
//         if($result){
//             return $result;
//         }else{
//             return false;
//         }
//     }

// public function addSection($param=''){

//     $result= $this->db->insert('classes',$param);
//     if($result){
//         return $result;
//     }else{
//         return false;
//     }
// }


// public function getClasses(){
  
//      $result=$this->db->query('SELECT *FROM students')->result();
//    //$result=$this->db->query('SELECT (SELECT  ss.firstname  FROM staff ss  WHERE  c.faculty1=ss.reg_no ) as faculty2name ,(SELECT  ss.firstname  FROM staff ss  WHERE  c.faculty2=ss.reg_no ) as faculty3name, s.reg_no as faculty_id,s.firstname,b.branch,b.id as branch_id,cl.college,cl.id as college_id,cr.id as courseid,cr.course,bt.year_id as year,bt.section_id as section, c.subject_name,c.subject_type,c.faculty FROM classes c INNER JOIN batches bt, colleges cl,courses cr,branches b,staff s WHERE bt.id=c.batch_id and cl.id=bt.college_id and b.id=bt.branch_id AND cr.id=bt.course_id and c.faculty=s.reg_no ORDER BY college,branch,course,year,section')->result();
//         if($result){
//             return $result;
//         }else{
//             return false;
//         }
//     }

// // public function getClasses($param=''){
  
// //     $result=$this->db->query('SELECT branches.college,branches.course,branches.branch,batches.year_id,batches.section_id,classes.subject_name FROM students
// // INNER JOIN branches ON students.department=branches.branch 
// // INNER JOIN batches ON branches.id=batches.branch_id  
// // INNER JOIN classes ON batches.id=classes.batch_id 
// // WHERE students.department="MECH" and branches.college_id=batches.college_id')->result();
// //         if($result){
// //             return $result;
// //         }else{
// //             return false;
// //         }
// //     }
// public function getClassesByID($param=''){
       
//     $result=$this->db->query('SELECT  bt.id,c.full_name,c.college,cr.course,b.branch, bt.year_id, bt.section_id, cl.subject_name,cl.subject_type  FROM batches bt INNER JOIN colleges  c, courses cr , branches b , classes cl   where  c.id=bt.college_id and  b.id=bt.branch_id AND cr.id=bt.course_id and cl.batch_id=bt.id and ( cl.faculty="'.$param.'" or  cl.faculty1="'.$param.'"  or cl.faculty2="'.$param.'")  ORDER BY bt.id DESC')->result();
//         if($result){
//             return $result;
//         }else{
//             return false;
//         }
//     }

// public function getCrs($data='')
//     {   
//        $param = $data['id'];
//        $param1 = $data['role'];
//         if($param =='' && $param1=='adm'){
//              $result=$this->db->query('select firstname as name, reg_no as id from students where department="ECE"')->result();
//         }
//         else if($param1=='hod')
//         {
//             //echo 'hod calling';
          
//             $result=$this->db->query('SELECT  firstname as name,  reg_no as id FROM students   WHERE   department=(SELECT department FROM staff WHERE reg_no="'.$param.'")')->result();
//         }
//         else{
//             $result=$this->db->query('select firstname as name, reg_no as id from students where reg_no="'.$param.'"')->result();
//         }
//          if($result)
//         {
//           return $result;
//         }
//         else
//         {
//             return false;
//         }
//     }

// public function getUsersbyDept($param='')
//     {   
//         $department = $param['department'];
//         $reg_no = $param['id'];

//         if($param==''){
//              $result=$this->db->query('select firstname as name, reg_no as id from staff where roll!="hod"')->result();
//         }else{
//             $result=$this->db->query('select firstname as name, reg_no as id from staff where reg_no !="'.$reg_no.'" and department="'.$department.'"')->result();
//         }
//          if($result)
//         {
//           return $result;
//         }
//         else
//         {
//             return false;
//         }
//     }

// public function getStudentsbyDept($param='')
//     {   
//         $department = $param['department'];
//         $reg_no = $param['id'];
//         $result=$this->db->query('select  reg_no as id,firstname as name from students where department="'.$department.'"')->result();
         
//          if($result)
//         {
//           return $result;
//         }
//         else
//         {
//             return false;
//         }
//     }

//     public function getnames()
// {
//     $result=$this->db->query('select * from staff')->result();
//     if($result){
//         return $result;
//     }else{
//          return false;
//     }
// }


// public function editattendance($test)
// {
//     $this->db->where('date',$test);
//     $result = $this->db->get('dailyattendance')->result();
//     // $result= $this->db->query('select *,SUM(forenoon) as count_fn, SUM(afternoon) as count_an FROM `dailyattendance` WHERE `date`="'.$test.'"')->row();
//     if($result){
//         return $result;
//     }else{
//          return false;
//     }
// }

// public function attendancecount($test)
// {
//     $result= $this->db->query('select SUM(forenoon) as count_fn, SUM(afternoon) as count_an FROM `dailyattendance` WHERE `date`="'.$test.'"')->row();
//     if($result){
//         return $result;
//     }else{
//          return false;
//     }
// }

// public function updateattendance($data)
// {
//     $this->db->where('id',$data['id']);
//     $this->db->where('user_id',$data['user_id']);
//     $this->db->where('date',$data['date']);
//     $result=  $this->db->update('dailyattendance',$data);
//     if($result)
//     {
//         return $result;
//     } 
//     else     
//     {
//         return false;
//     }
// }

// public function dailyattendance($param='')
//     {
//         $result= $this->db->insert('dailyattendance',$param);
//         if($result)
//         {
//             return $result;
//         }
//         else
//         {
//             return false;
//         }
//     }

// public function getrolesstaff()
// {
//     $result=$this->db->query('SELECT r.*,u.name as name,u.utype as utype  FROM roles r,users u WHERE r.reg_no=u.reg_no and r.reg_no!="admin"')->result();
//     if($result){ 
//         return $result;
//     } else { 
//         return false; 
//     } 
// }

// public function addnewrole($param='')
// {
//     $result = $this->db->insert('roles',$param);
//     if($result) { return $result; }
//     else { return false; }
// }

// public function updatenew($param='')
// {
//     $result=$this->db->query('UPDATE `roles` SET `role`="'.$param['role'].'" WHERE `reg_no`="'.$param['reg_no'].'"');
//     if($result) { return $result; }
//     else { return false; }
// }



}
?>
