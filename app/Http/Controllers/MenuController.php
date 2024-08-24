<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Menu;

class MenuController extends Controller
{
    public function allMenu(Request $request)
    {
        if ($request->cafe_id == null) {
            $data = Menu::where('is_deleted', 0)->latest()->paginate(10);
        } else {
            $data = Menu::where('is_deleted', 0)->where('cafe_id', $request->cafe_id)->latest()->paginate(10);
        }
        return [
            "status" => 1,
            "msg" => "Get Data Successfuly",
            "data" => $data
        ];
    }

    public function addMenu(Request $request)
    {
        // echo "<pre>";
        // print_r(auth()->id());
        // echo "</pre>";
        // die();
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:150',
            'price' => 'required|numeric',
            'cafe_id' => 'required|numeric',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $data = Menu::create([
            'name' => $request->name,
            'price' => $request->price,
            'is_recommendation' => $request->is_recommendation,
            'cafe_id' => $request->cafe_id,
            'created_by' => auth()->id(),
         ]);
 
        return [
            "status" => 1,
            "msg" => "Add Data Successfuly",
            "data" => $data,
        ];
    }

    public function editMenu(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id' => 'required',
            'name' => 'required|string|max:150',
            'price' => 'required|numeric',
            'cafe_id' => 'required|numeric',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $data = Menu::where('id', $request->id)->update([
            'name' => $request->name,
            'price' => $request->price,
            'is_recommendation' => $request->is_recommendation,
            'cafe_id' => $request->cafe_id,
            'updated_by' => auth()->id(),
         ]);
 
        return [
            "status" => 1,
            "msg" => "Update Data Successfuly",
            "data" => $data,
        ];
    }
 
    public function destroyMenu(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $data = Menu::where('id', $request->id)->update([
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
