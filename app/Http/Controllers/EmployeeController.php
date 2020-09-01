<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Employee;
use Response;
use DB;

class EmployeeController extends Controller
{

	public function createEmployee(){
		return view('employee.create');
	}

	public function saveEmployee(Request $request){

		if(isset($request->step) && $request->step == 1) {
			$this->validate($request, [
		        'first_name' => 'required',
		        'last_name' => 'required',
		        'phone_number' => 'required|numeric',
		        'email' => 'required|email'
		    ]);
			return successResponse('Proceed next');
		}

		if(isset($request->step) && $request->step == 2) {
			$this->validate($request, [
		        'date_of_birth' => 'required',
		        'salary' => 'required|numeric'
		    ]);
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

	public function editEmployee($id){
		return view('employee.create',compact('id'));
	}

	public function viewEmployee($id){
		return view('employee.view',compact('id'));
	}

	public function deleteEmployee($id){
		
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
