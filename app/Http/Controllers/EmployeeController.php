<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Employee;
use Response;
use DB;

class EmployeeController extends Controller
{
	/****** View create employee ********/
	public function createEmployee(){
		return view('employee.create');
	}

	/****** Save employee ********/
	public function saveEmployee(Request $request){
		$step1 = [
	        'first_name' => 'required',
	        'last_name' => 'required',
	        'phone_number' => 'required|numeric',
	        'email' => 'required|email'
	    ];
	    $step2 = [
	        'date_of_birth' => 'required',
	        'salary' => 'required|numeric'
	    ];

	    if(isset($request->id)) {
	    	$this->validate($request, array_merge($step1, $step2));
	    } else {
	    	if(isset($request->step) && $request->step == 1) {
				$this->validate($request, $step1);
				return successResponse('Proceed next');
			}

			if(isset($request->step) && $request->step == 2) {
				$this->validate($request, $step2);
			}
	    }


		DB::beginTransaction();
        try {
            if(!isset($request->id)) {
                Employee::create($request->all());
            } else {
                $data = Employee::findorfail($request->id);
                $data->update($request->all());
            }
        } catch (\Exception $e) {
            DB::rollback();             
            $message = isset($request->id) ? 'Error while updating employee, try again.' : 'Error while creating employee, try again.';
            return errorResponse($message);
        }
        DB::commit();
        $message = isset($request->id) ? 'Employee updated successfully' : 'Employee created successfully';
        return successResponse($message);	    
	}

	/****** Edit employee view********/
	public function editEmployee($id){
		return view('employee.create',compact('id'));
	}

	/****** View employee ********/
	public function viewEmployee($id){
		return view('employee.view',compact('id'));
	}

	/****** Delete employee ********/
	public function deleteEmployee($id){
		$data = Employee::find($id);
        if(empty($data)) {
            return errorResponse('Employee not found.');
        }

        DB::beginTransaction();
        try {
            
            $data->delete();
            
        } catch (\Exception $e) {
            DB::rollback(); 
            return errorResponse('Error while deleting employee, try again');
        }
        DB::commit();
        return successResponse('Employee deleted successfully');
	}

	public function list(){
		return view('employee.list');
	}

	public function getEmployeeData(Request $request){

        if(isset($request->id)){
            return Employee::find($request->id);
        }

        $data = Employee::latest()->paginate(25);

        $response['employee'] = getPaginationInfo($data);
        return Response::json($response);
	}

}
