<?php

namespace App\Http\Controllers;

use App\Models\attendance;
use App\Models\employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule as ValidationRule;

class Attendancecontroller extends Controller
{
        public function __construct()
        {
            date_default_timezone_set('Africa/Cairo');
            
        }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $employee  = employee::find($request->employee);

        if($employee){

            $request->validate([
                'employee'=>'required',
                'status'=>'required|string'
            ]);
            $cdate = date('Y-m-d');

            if($request->status == 'Present'){
                $ctime = date("h:i:s");
            }else{
                $ctime =NULL;
            }
            // echo $request->status;die;
            return attendance::create([
                'day'=> $cdate,
                'start_time'=> $ctime,
                'employee'=>$request->employee,
                'status'=>$request->status,
    
    
            ]);

        }else{
            return json_encode("This Employee Not found") ;
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $employee  = employee::find($request->employee);

        if($employee){
            $attendance = attendance::where('employee','=',$request->employee)
                                      ->where('day','>=',$request->start)
                                      ->where('day','<=',$request->end)
                                      ->where('status','=',"Present")
                                      ->count();

            return  $attendance;
        }else{
            return json_encode("This Id Not found") ;
        }
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function attendanceLeave($id)
    {

          
       //  $id  of atendance
       
        $attendance  = attendance::find($id);

        if($attendance){  
            $ctime = date("h:i:s");
            $attendance->update([
                'end_time' => $ctime,
            ]);
            return $attendance;
        }else{
            return json_encode("This Attendace Id Not found") ;
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $attendance  = attendance::find($id);

        if($attendance){

            $request->validate([
                'day'=>'required|date',
                'start_time'=>'time',
                'end_time'=>'time',
                'employee'=>'required|integer',
                'status'=>'required|string'
            ]);
            if(!isset($request->start_time)){
                $start_time = NULL;
            }
            if(!isset($request->end_time)){
                $end_time = NULL;
            }
            
           
            return $attendance->update([
    
                'day'=> $request->day,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'employee'=>$$request->employee,
                'status'=>$request->status,
    
    
            ]);

        }else{
            return json_encode("This Id Not found") ;
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product  = attendance::find($id);
        if($product){
            attendance::destroy($id);
             return json_encode("Success attendance Is deleted") ;
        }else{
            return json_encode("This Id Not found") ;
        }
       

    }

    public function Best_employee(Request $request)
    {

    $query = "SELECT MAX(a.Total_Qty) as best ,  employee  From ( SELECT s.employee  , SUM(s.end_time - s.start_time) AS Total_Qty FROM attendances s WHERE day <= '$request->to_date' AND day >= '$request->from_date'  GROUP BY s.employee ) as a GROUP BY a.employee ORDER BY best DESC LIMIT 1";

    $posts = DB::select($query);
    if($posts){
        $employee = employee::find($posts['0']->employee);
        return [
            'best'=> $posts,
            'employee'=> $employee
        ] ;
    }else{
       return ['message'=> 'Not Found Attendance In this Date'] ;
    };
   
          
           
    }
}
