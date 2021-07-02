<!-- Layout -->
@extends('layouts.contentLayout')
<!-- End Layout -->
@section('title','PREVIEW SUPPLIER')
@section('action_menu')
    <a class="btn btn-info" id="edit"><span class="fa fa-floppy-o">&nbsp;</span>Edit</a>
    <a class="btn btn-danger" href="{{ url('supplier_home') }}" target="_self"><span class="fa fa-times">&nbsp;</span>Close</a>
@endsection

<!-- START PAGE CONTENT -->
@section('content')
    <div class="row pt-2" >
        <div class="col-md-12">
            <div class="col-md-6">
                <table class="table table-striped">
                    <tbody>
                        <tr><th>Supplier Name</th>      <td>{{ $supplier->title_name->title}}. {{ $supplier->name }}</td></tr>
                        <tr><th>Supplier Address</th>   <td>{{ $supplier->address }}</td></tr>
                        <tr><th>Contact No</th>           <td>{{ $supplier->contact_no }}</td></tr>
                        <tr><th>Email Address</th>      <td>{{ $supplier->email }}</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-striped">
                    <tbody>
                        <tr><th>Remark</th> <td>{{ $supplier->rmk }}</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('notify_status')
    <!-- Status Details -->
    <div class="col-md-12">
    <div class="col-md-4 col-sm-2"></div>
    <div class="col-md-4 col-sm-3"></div>
    <div class="col-md-4 col-sm-7">
        <div class="panel panel-default" id="acdtlp" style="height:100%">
            <div class="panel-body">
                <h3 class="text-title" style="padding-bottom:10px;"><span class="fa fa-bell">&nbsp;</span>Status</h3>
                <table class="table table-striped ">
                    <tr>
                        <td width="200" class="">Status</td>
                        <td class="text-right text-bold">
                            <span class="label  label-@if ($supplier->sts==1)success @elseif ($supplier->sts==0)danger @elseif ($supplier->sts==2)suspend @endif label-form">@if ($supplier->sts==1) Active @elseif ($supplier->sts==0) Inactive @elseif ($supplier->sts==2) Suspend @endif </span>
                        </td>
                    </tr>
                    <tr><td width="200">Created By</td><td class="text-right">{{ $supplier->create_user_name->name }}</td></tr>
                    <tr><td width="200">Created Date & Time</td><td class="text-right">{{ $supplier->create_date_time }}</td></tr>
                    @if($supplier->update_user!=null)
                    <tr><td width="200">Last Edited By</td><td class="text-right"> {{ $supplier->update_user_name->name  }}</td></tr>
                    <tr><td width="200">Last Edited Date & Time</td><td class="text-right">{{ $supplier->update_date_time }} </td></tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
    <!-- /.end Status Details -->
    </div>
@endsection
<!-- END PAGE CONTENT -->
<!-- START SCRIPT -->
@section('myscript')
<script type='text/javascript' src="{{ asset('/theme/js/my_functions.js') }}"></script>
<script type="text/javascript">
//Edit
$('#edit').click(function(e){
	e.preventDefault();
    var sid = '{{$supplier->sid}}';
    $.redirect("{{ url('supplier_edit') }}", {"sid": sid }, "GET", "_self" );
});
</script>
@endsection
<!-- END SCRIPT -->
