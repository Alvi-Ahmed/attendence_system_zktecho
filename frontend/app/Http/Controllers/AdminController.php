<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use App\Models\Latetime;
use App\Models\Attendance;
use Carbon\Carbon;


class AdminController extends Controller
{

 
    public function index()
    {
        $curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://127.0.0.1:8001/api/user',
    CURLOPT_HTTPHEADER => ['Content-Type: application/json']
]);
$response = curl_exec($curl);
curl_close($curl);
$data = json_decode($response,true);
$countperson = 0;
foreach ($data['User'] as $person){
    $personcount= $person['name'];
    $countperson=$countperson+1;
}


$totalEmp =$countperson;


$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://127.0.0.1:8001/api/record/',
    CURLOPT_HTTPHEADER => ['Content-Type: application/json']
]);
$responseone = curl_exec($curl);
curl_close($curl);
$recorddata = json_decode($responseone,true);
$countdate = 0;
$now = Carbon::today();
$ondate = array();
foreach ($recorddata['Record'] as $person){
    $records= $person['created_at'];
    //echo $records;
    $dateonly = Carbon::parse($records)->toDateString();
    if($dateonly=== $now->toDateString()){
             $ondate[$countdate]=$person; 
             $countdate=$countdate+1;
    }else{
                       
    }
    
    
}
$AllAttendance = $countdate;


$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://127.0.0.1:8001/api/record/',
    CURLOPT_HTTPHEADER => ['Content-Type: application/json']
]);
$responseone = curl_exec($curl);
curl_close($curl);
$recorddata = json_decode($responseone,true);
$countdate = 0;
$onTimeCount= 0;
        $ontimeEmp = 0;
        $latetimeEmp = 0;

$time1 = Carbon::parse('09:00:00')->format('H:i:s');
foreach ($ondate as $person){
    $temp = (string)$person['checkin'];
    //echo gettype(person['checkin']);
    $arrival_time = Carbon::parse($person['checkin']) -> format('H:i:s');
    if($arrival_time > ($time1)){
        
             
    }else{
        $onTimeCount=$onTimeCount+1;
                     
    }
    $ontimeEmp=$onTimeCount;
    $latetimeEmp= $AllAttendance-$onTimeCount;
    
    
}

        //Dashboard statistics 
        //$totalEmp =  count(Employee::all());
        // $AllAttendance = count(Attendance::whereAttendance_date(date("Y-m-d"))->get());
       // $ontimeEmp = count(Attendance::whereAttendance_date(date("Y-m-d"))->whereStatus('1')->get());
      //  $latetimeEmp = count(Attendance::whereAttendance_date(date("Y-m-d"))->whereStatus('0')->get());
            
        if($AllAttendance > 0){
                $percentageOntime = str_split(($ontimeEmp/ $AllAttendance)*100, 4)[0];
            }else {
                $percentageOntime = 0 ;
            }
        
        $data = [$totalEmp, $ontimeEmp, $latetimeEmp, $AllAttendance];
        
        return view('admin.index')->with(['data' => $data]);
    }

}
