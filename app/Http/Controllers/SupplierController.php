<?php

namespace App\Http\Controllers;

use App\Models\Cnfg_person_title;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Exception;
use DateTime;
use Yajra\Datatables\Datatables;

class SupplierController extends Controller
{
    /* Supplier Home Page */
    public function HomePage()
    {
        return view('pages/supplier_home');
    }

    public function New()
    {
        $title = Cnfg_person_title::where('sts','1')->get();

        //$cnfg = new Cnfg_person_title();
        //$title1 = $cnfg->result1();
        //$title2 = $cnfg->result2();


        $data = ['title'=>$title];
        return view('pages/supplier_new')->with($data);
    }

    public function name_validate(Request $request)
    {
        $data = Supplier::where('name',$request->sname)->exists();
        return response()->json($data);
    }

    public function save(Request $request){
        try{

            $rules =[
                'sname' => 'required|unique:suppliers,name',
                'saddr' => 'required',
                'email' => 'nullable|email|unique:suppliers,email',
            ];
            $customMessages =[
                'sname.required' => 'Supplier Name is required',
                'sname.unique'=> 'Already Existing Supplier Name',
                'saddr.required' => 'Supplier Address is required',
                'saddr.required' => 'Supplier Address is required',
                'email.email' => 'Invalid email address',
                'email.unique' => 'Already Existing Supplier email address',
            ];

            $validatedData = Validator::make($request->all(), $rules, $customMessages);

            if($validatedData->fails()){
                return redirect()->back()->withErrors($validatedData)->withInput();
            }else{

                $supplier = new Supplier();
                $supplier->name = $request->sname;
                $supplier->address = $request->saddr;
                $supplier->email = $request->email;
                $supplier->contcat_no = $request->contacts;
                $supplier->rmk = $request->remark;
                $supplier->sts = 1;
                $supplier->create_user_id = 1;

                $date = new DateTime();
                $dtdate1 = $date->format('Y-m-d');

                $supplier->create_date_time = $dtdate1;
                $supplier->save();

                return redirect('/supplier_home');
            }

        }catch(Exception $e){
            dd($e->getMessage());
        }

    }
}
