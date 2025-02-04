<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Vacation;
use App\Models\Warehouse;
use App\Models\Warehouse_Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class VacationController extends Controller
{
    // public function AddVacationForEmployee(Request $request){

    //     $validator = Validator::make($request->all(),[
    //         'employee_id'=>'required',
    //         'start'=>'required|date_format:Y-m-d',
    //         'end'=>'required|date_format:Y-m-d',
    //         'reason'=>'required|string'      
    //     ]);

    //     if ($validator->fails())
    //     {
    //         return response()->json($validator->errors()->toJson(),400);
    //     }

    //     $employee = Employee::where('id' , $request->employee_id)->first();
    //     if($employee){
    //         $manager = Auth::guard('branch_manager')->user();
    //         $vacation = Vacation::create([
    //             'user_id'=> $request->employee_id,
    //             'user_type'=> 'employee',
    //             'start'=> $request->start,
    //             'end'=> $request->end,
    //             'reason'=>$request->reason,
    //             'created_by'=> $manager->name
    //         ]);
    //         return response()->json([
    //             'message'=>'Vacation addedd successfully'], 201);
    //     }
    //     return response()->json(['message'=>'Employee not found'], 400);  
    // }
    public function AddVacationForEmployee(Request $request)
    {
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'employee_id' => 'required|numeric',
                'start' => 'required|date_format:Y-m-d',
                'end' => 'required|date_format:Y-m-d',
                'reason' => 'required|string'
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->toJson()
                ], 400);
            }
    
            // Find the employee
            $employee = Employee::where('id', $request->employee_id)->first();
    
            if (!$employee) {
                return response()->json([
                    'success' => false,
                    'message' => 'Employee not found'
                ], 404);
            }
    
            // Get the branch manager
            $manager = Auth::guard('branch_manager')->user();
    
            // Create the vacation record
            Vacation::create([
                'user_id' => $request->employee_id,
                'user_type' => 'employee',
                'start' => $request->start,
                'end' => $request->end,
                'reason' => $request->reason,
                'created_by' => $manager->name
            ]);
    
            return response()->json([
                'success' => true,
                'message' => 'Vacation added successfully'
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding the vacation',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    // public function AddVacationForWhManager(Request $request){

    //     $validator = Validator::make($request->all(),[
    //         'wmanager_id'=>'required',
    //         'start'=>'required|date_format:Y-m-d',
    //         'end'=>'required|date_format:Y-m-d',
    //         'reason'=>'required|string'      
    //     ]);

    //     if ($validator->fails())
    //     {
    //         return response()->json($validator->errors()->toJson(),400);
    //     }

    //     $whmanager = Warehouse_Manager::where('id' , $request->wmanager_id)->first();
    //     if($whmanager){
    //         $manager = Auth::guard('branch_manager')->user();
    //         $vacation = Vacation::create([
    //             'user_id'=> $request->wmanager_id,
    //             'user_type'=> 'warehouse_manager',
    //             'start'=> $request->start,
    //             'end'=> $request->end,
    //             'reason'=>$request->reason,
    //             'created_by'=> $manager->name
    //         ]);
    //         return response()->json([
    //             'message'=>'Vacation addedd successfully'], 201);
    //     }
    //     return response()->json(['message'=>'Warehouse manager not found'], 400);  
    // }
    public function AddVacationForWhManager(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'wmanager_id' => 'required|numeric',
                'start' => 'required|date_format:Y-m-d',
                'end' => 'required|date_format:Y-m-d',
                'reason' => 'required|string'
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->toJson()
                ], 400);
            }
                $whmanager = Warehouse_Manager::where('id', $request->wmanager_id)->first();
    
            if (!$whmanager) {
                return response()->json([
                    'success' => false,
                    'message' => 'Warehouse manager not found'
                ], 404);
            }
                $manager = Auth::guard('branch_manager')->user();
                Vacation::create([
                'user_id' => $request->wmanager_id,
                'user_type' => 'warehouse_manager',
                'start' => $request->start,
                'end' => $request->end,
                'reason' => $request->reason,
                'created_by' => $manager->name
            ]);
    
            return response()->json([
                'success' => true,
                'message' => 'Vacation added successfully'
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding the vacation',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    // public function GetEmployeeVacation( $id){

    //     $employee = Employee::where('id' , $id)->first();

    //     if($employee){
    //         $vacations = Vacation::where('user_type' , 'employee')
    //                             ->where('user_id' , $id)
    //                             ->get();
    //         if(!$vacations){
    //             return response()->json([
    //                 'success' => false ,
    //                 'message'=>'No vacations found'
    //             ], 404);  
    //         }

    //         return response()->json([
    //             'success' => true ,
    //             'data'=> $vacations
    //         ], 200);  
    //     }

    //     return response()->json([
    //         'success' => false ,
    //         'message'=>'Employee not found'
    //     ], 404);  
    // }
    public function GetEmployeeVacation($id)
    {
        try {
            $employee = Employee::where('id', $id)->first();
            if (!$employee) {
                return response()->json([
                    'success' => false,
                    'message' => 'Employee not found'
                ], 404);
            }
                $vacations = Vacation::where('user_type', 'employee')
                                ->where('user_id', $id)
                                ->get();
    
            if ($vacations->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No vacations found'
                ], 404);
            }
    
            return response()->json([
                'success' => true,
                'data' => $vacations
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving vacations',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    // public function GetWhManagerVacation( $id){

    
    //     $wmanager = Warehouse::where('id' , $id)->first();

    //     if($wmanager){
    //         $vacations = Vacation::where('user_type' , 'warehouse_manager')
    //                             ->where('user_id' , $id)
    //                             ->get();
    //         if(!$vacations){
    //             return response()->json([
    //                 'success' => false ,
    //                 'message'=>'No vacations found'
    //             ], 404);  
    //         }

    //         return response()->json([
    //             'success' => true ,
    //             'data' => $vacations
    //         ], 200);  
    //     }

    //     return response()->json([
    //         'success' => false ,
    //         'message'=>'Warehouse manager not found'
    //     ], 404);  
    // }
    public function GetWhManagerVacation($id)
{
    try {
        $wmanager = Warehouse_Manager::where('id', $id)->first();

        if (!$wmanager) {
            return response()->json([
                'success' => false,
                'message' => 'Warehouse manager not found'
            ], 404);
        }
        $vacations = Vacation::where('user_type', 'warehouse_manager')
                            ->where('user_id', $id)
                            ->get();

        if ($vacations->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No vacations found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $vacations
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'An error occurred while retrieving vacations',
            'error' => $e->getMessage()
        ], 500);
    }
}

}
