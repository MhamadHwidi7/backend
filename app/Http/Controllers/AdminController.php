<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Branch_Manager;
use App\Models\Warehouse_Manager;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    public function AddBranch (Request $request)
    {
        $validator =  $request->validate([
          //'desk'=>'required|min:3',
            'address'=>'required',
            'phone'=>'required|min:4|max:15',
             'manager_name'=>'required',
             'email'=>'required',
             'password'=>'required',
             'phone_number'=>'required ',
             'gender'=>'required',   
             'mother_name'=>'required',
             'date_of_birth'=>'required',
             'manager_address'=>'required',
            'vacations'=>'required',
            'salary'=>'required',
            'rank'=>'required',
            'employment_date'=>'required',
          
        ]);
      

        $branch = new Branch();
       //$branch->desk = $validator['desk'];
        $branch->address = $validator['address'];
        $branch->phone = $validator['phone'];
        $branch->save();
      

        $branchmanager = new Branch_Manager();
                $branchmanager->name = $validator['manager_name'];
                $branchmanager->email = $validator['email'];
                $branchmanager->password = Hash::make($validator['password']); 
                $branchmanager->phone_number = $validator['phone_number'];
               $branchmanager->branch_id = $branch->id;
                $branchmanager->gender = $validator['gender'];
                $branchmanager->mother_name = $validator['mother_name']; 
                $branchmanager->date_of_birth = $validator['date_of_birth'];
                 $branchmanager->address = $validator['manager_address'];
                 $branchmanager->vacations = $validator['vacations'];
                 $branchmanager->salary = $validator['salary'];
                 $branchmanager->rank = $validator['rank'];
                  $branchmanager->employment_date = $validator['employment_date'];
                $branchmanager->save();


                return response()->json([
                    'message'=>'branch added successfully',  
                ],201);
   
    }


    
    public function addwarehouse(Request $request)
    {

      $validator =  $request->validate([                  
                      'warehouse_address'=>'required',
                      'branch'=>'required ',
                      'area'=>'required ',
                      'notes'=>'required ',
                      'manager_name'=>'required',
                      'email'=>'required',
                      'password'=>'required',
                      'phone_number'=>'required ',
                      'gender'=>'required',
                      'mother_name'=>'required',
                      'date_of_birth'=>'required',
                      'manager_address'=>'required',
                     'vacations'=>'required',
                     'salary'=>'required',
                     'rank'=>'required',
                     'employment_date'=>'required',
                ]);
              
                $warehouse = new Warehouse();
                $warehouse->branch = $validator['branch']; 
                $warehouse->address = $validator['warehouse_address']; 
                $warehouse->area = $validator['area']; 
                $warehouse->notes = $validator['notes']; 
                $warehouse->save();

                $warehousemanager = new Warehouse_Manager();
                $warehousemanager->name = $validator['manager_name'];
                $warehousemanager->email = $validator['email'];
                $warehousemanager->password =  Hash::make($validator['password']);
                $warehousemanager->phone_number = $validator['phone_number'];
               $warehousemanager->warehouse_id = $warehouse->id;
                $warehousemanager->gender = $validator['gender'];
                $warehousemanager->mother_name = $validator['mother_name']; 
                $warehousemanager->date_of_birth = $validator['date_of_birth'];
                 $warehousemanager->address = $validator['manager_address'];
                 $warehousemanager->vacations = $validator['vacations'];
                 $warehousemanager->salary = $validator['salary'];
                 $warehousemanager->rank = $validator['rank'];
                  $warehousemanager->employment_date = $validator['employment_date'];
                $warehousemanager->save();
        
               

      return response()->json([
        'message'=>'warehouse added successfully',  
    ],201);

    }


    public function UpdateBranch(Request $request)
    {

      

      $branch = Branch::find($request->branch_id);
      $updatedbranch= $branch->update($request->all());


      $branchManager = Branch_Manager::where('branch_id', $request->branch_id)->first();
      $updatedmanager= $branchManager->update($request->all());

      return response()->json(['message' => 'Branch updated successfully']);


    }
    public function UpdateWarehouse(Request $request)
    {

      

      $warehouse = Warehouse::find($request->warehouse_id);
      $updatedbranch= $warehouse->update($request->all());


      $w_Manager = Warehouse_Manager::where('warehouse_id', $request->warehouse_id)->first();
      $updatedmanager= $w_Manager->update($request->all());

      return response()->json(['message' => 'warehouse updated successfully']);


    }

    public function deleteBranch(Request $request)
    {
        $branch = Branch::find($request->branch_id)->delete();
        $branchManager = Branch_Manager::where('branch_id', $request->branch_id)->delete();

        return response()->json(['msg'=>'Branch has been deleted'], 200) ;
    }


    public function deleteWarehouse(Request $request)
    {
        $Warehouse = Warehouse::find($request->warehouse_id)->delete();
      $WarehouseManager = Warehouse_Manager::where('warehouse_id', $request->warehouse_id)->delete();

        return response()->json(['msg'=>'Warehouse has been deleted'], 200) ;
    }
   
}
