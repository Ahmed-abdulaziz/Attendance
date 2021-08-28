<?php

namespace App\Http\Controllers;

use App\Models\employee;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule as ValidationRule;

class Employeecontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(employee::get());
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

         $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'required|min:11|numeric|unique:employees,phone',
            'HireDate'=>'required|date|date_format:Y-m-d'
        ]);

        return employee::create([
            'name'=> $request->name,
            'email' => $request->email,
            'phone'=>$request->phone,
            'HireDate'=>$request->HireDate,


        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee  = employee::find($id);

        if($employee){
            return  $employee;
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
    public function edit($id)
    {
       
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
        
        $employee  = employee::find($id);

        if($employee){

            $request->validate([
                'name' => 'required|string',
                'email' =>  ['required','email',ValidationRule::unique('employees')->ignore($id)],
                'phone' => ['required','min:11|numeric',ValidationRule::unique('employees')->ignore($id)],
                'HireDate'=>'required|date|date_format:Y-m-d'
            ]);
            
           $employee->update([
    
                    'name'=> $request->name,
                    'email' => $request->email,
                    'phone'=>$request->phone,
                    'HireDate'=>$request->HireDate,
    
    
            ]);
    
            return  $employee;

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
        $employee  = employee::find($id);
        if($employee){
             employee::destroy($id);
             return json_encode("Success employee Is deleted") ;
        }else{
            return json_encode("This Id Not found") ;
        }
       

    }

  
}
