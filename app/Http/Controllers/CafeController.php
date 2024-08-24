<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Cafe;

class CafeController extends Controller
{
    public function allCafe(Request $request)
    {
        if ($request->id == null) {
            $data = Cafe::where('is_deleted', 0)->latest()->paginate(10);
        } else {
            $data = Cafe::where('is_deleted', 0)->where('id', $request->id)->get();
        }
        return [
            "status" => 1,
            "msg" => "Get Data Successfuly",
            "data" => $data
        ];
    }

    public function addCafe(Request $request)
    {
        // echo "<pre>";
        // print_r(auth()->id());
        // echo "</pre>";
        // die();
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:150',
            'address' => 'required|string|max:255',
            'manager_id' => 'required|numeric',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $data = Cafe::create([
            'name' => $request->name,
            'address' => $request->address,
            'manager_id' => $request->manager_id,
            'created_by' => auth()->id(),
         ]);
 
        return [
            "status" => 1,
            "msg" => "Add Data Successfuly",
            "data" => $data,
        ];
    }

    public function editCafe(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id' => 'required',
            'name' => 'required|string|max:150',
            'address' => 'required|string|max:255',
            'manager_id' => 'required|numeric',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $data = Cafe::where('id', $request->id)->update([
            'name' => $request->name,
            'address' => $request->address,
            'manager_id' => $request->manager_id,
            'updated_by' => auth()->id(),
         ]);
 
        return [
            "status" => 1,
            "msg" => "Update Data Successfuly",
            "data" => $data,
        ];
    }
 
    public function destroyCafe(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $data = Cafe::where('id', $request->id)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => auth()->id(),
            'is_deleted' => 1,
         ]);
 
        return [
            "status" => 1,
            "msg" => "Deleted Data Successfuly",
            "data" => $data,
        ];
    }
}
