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
        //dd($title);
        $data = ['title'=>$title];
        return view('pages/supplier_new')->with($data);
    }

}
