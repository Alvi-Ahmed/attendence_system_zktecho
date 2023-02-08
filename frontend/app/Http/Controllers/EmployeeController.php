<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use App\Models\Role;
use App\Models\Schedule;
use App\Http\Requests\EmployeeRec;
use RealRashid\SweetAlert\Facades\Alert;

use function App\Http\Controllers\debug_to_console as ControllersDebug_to_console;
use function Psy\debug;

class EmployeeController extends Controller
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
        $data = json_decode($response);
        $countperson = 0;
        // foreach ($data['User'] as $person){
        //     $personcount= $person['name'];
        //    // $countperson=$countperson+1;
        // }
        //$totalEmp =$countperson;
        // $curl = curl_init();
        // curl_setopt_array($curl, [
        //     CURLOPT_RETURNTRANSFER => 1,
        //     CURLOPT_URL => 'http://127.0.0.1:8001/api/lrecords/',
        //     CURLOPT_HTTPHEADER => ['Content-Type: application/json']
        // ]);
        // $response = curl_exec($curl);
        // curl_close($curl);
        // $attendencedata = json_decode($response);
        // echo $attendencedata->record;
        
        return view('admin.employee')->with(['employees'=> $data->User, 'schedules'=>Schedule::all()]);
    }
    public function helper($id){
        $base_url = 'http://127.0.0.1:8001/api/lrecords/';
        $base_url_v2 = $base_url.$id;
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $base_url_v2,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json']
        ]);
        $response = curl_exec($curl);
        curl_close($curl);
        $attendencedata = json_decode($response);
        echo $attendencedata->record;
    }

    public function store(EmployeeRec $request)
    {
        $request->validated();

        $employee = new Employee;
        $employee->name = $request->name;
        $employee->position = $request->position;
        $employee->email = $request->email;
        $employee->pin_code = bcrypt($request->pin_code);
        $employee->save();

        if($request->schedule){

            $schedule = Schedule::whereSlug($request->schedule)->first();

            $employee->schedules()->attach($schedule);
        }

        // $role = Role::whereSlug('emp')->first();

        // $employee->roles()->attach($role);

        flash()->success('Success','Employee Record has been created successfully !');

        return redirect()->route('employees.index')->with('success');
    }

 
    public function update(Employee $employee)
    {
        function debug_to_console($data) {
            $output = $data;
            if (is_array($output))
                $output = implode(',', $output);
        
            echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
        };
        ControllersDebug_to_console('value');
        echo 'value';
        $id=$employee->id;
        $base_url = 'http://127.0.0.1:8001/api/lrecords/';
        $base_url_v2 = $base_url.$id;
        echo $base_url_v2;

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $base_url_v2,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json']
        ]);
        $response = curl_exec($curl);
        echo $response;
        curl_close($curl);
        $attendencedata = json_decode($response);
        debug_to_console('alvi');
    }


    public function destroy(Employee $employee)
    {
        $employee->delete();
        flash()->success('Success','Employee Record has been Deleted successfully !');
        return redirect()->route('employees.index')->with('success');
    }
}
