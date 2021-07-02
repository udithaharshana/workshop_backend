<?php

namespace App\Http\Controllers;

use App\Models\Cnfg_person_title;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
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
                $supplier->tid = $request->tid;
                $supplier->name = $request->sname;
                $supplier->address = $request->saddr;
                $supplier->email = $request->email;
                $supplier->contcat_no = $request->contacts;
                $supplier->rmk = $request->remark;
                $supplier->sts = 1;
                $supplier->create_user_id = 1;

                $supplier->create_date_time = $this->dtdatetime;
                $supplier->save();

                return redirect('/supplier_home');
            }

        }catch(Exception $e){

            return  App::environment('local') ? dd($e->getMessage(),$e->getLine()) : '';
        }

    }

    public function HomeData(Request $request){

        try{
            $data = new Supplier();
            if($request->search){
                $data = $data->Where('name','LIKE', "%{$request->search}%")
                ->orWhere('email','LIKE', "%{$request->search}%")
                ->orWhere('contcat_no','LIKE', "%{$request->search}%");
            }
            $data = $data->where('sid','!=','1')->get();

            return Datatables::of($data)->toJson();

        }catch(Exception $e){
            return response('');
        }
    }

    public function Preview(Request $request){
        try{
            $supplier = Supplier::with(['title_name:tid,title','create_user_name:id,name', 'update_user_name:id,name' ])->find($request->sid);

            /* $data = DB::table('suppliers')
                        //->select('supplier.name','supplier.email')
                        ->selectRaw('suppliers.*, create.name AS create_user, update.name AS update_user')
                        ->leftJoin('users AS create','create.id','=','suppliers.create_user_id')
                        ->leftJoin('users AS update','update.id','=','suppliers.update_user_id')
                        ->where('sid',$request->sid)
                        ->first(); */
            return view('pages/supplier_preview')->with(['supplier'=>$supplier]);

        }catch(Exception $e){
            dd($e->getMessage());
        }
    }

    public function Edit(Request $request){
        try{
            $supplier = Supplier::find($request->sid);
            $title = Cnfg_person_title::where('sts','1')->get();

            return view('pages/supplier_edit')->with(['supplier'=>$supplier, 'title'=>$title]);


        }catch(Exception $e){
            dd($e->getMessage());
        }
    }
}
