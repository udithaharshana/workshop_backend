<!-- Layout -->
@extends('layouts.contentLayout')
<!-- End Layout -->
@section('title','EDIT SUPPLIER')

<!-- Custom Action  -->
@section('action_menu')
    <a class="btn btn-success panel-refresh" id="savfm" target="_self"><span class="fa fa-floppy-o">&nbsp;</span>Save</a>
    <a class="btn btn-danger rdrct" href="{{ url('supplier_home') }}" target="_self"><span class="fa fa-times">&nbsp;</span>Close</a>
@endsection

<!-- START PAGE CONTENT -->
@section('content')
<div class="row">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <form action="{{ url('supplier_save') }}" method="POST" id="frmdt" class="pt-2">
        @csrf
        <input type="hidden" name="sid" id="sid" value="{{$supplier->sid }}">
        <input type="hidden" name="stss" id="stss" value="{{$supplier->sts }}">
        <div class="col-md-12 pb-2">
            <div class="col-md-6" >
                <div class="form-group col-md-12" >
                    <label class="col-md-3 control-label text-left">Supplier Name </label>
                    <div class="col-md-2 col-sm-2">
                            <select class="form-control select" name="tid" id="tid">
                                    @foreach ($title as $row)
                                        <option value="{{ $row['tid'] }} " @if(old('tid')==$row['tid']) selected @elseif($supplier->tid==$row['tid']) @endif > {{ $row['title'] }}</option>
                                    @endforeach
                            </select>
                        </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control"  id="sname" name="sname" autocomplete="off" value="@if(old('sname')){{ old('sname')}}@else{{$supplier->name}}@endif">
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <label class="col-md-3 control-label text-left">Supplier Address</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="saddr" name="saddr" autocomplete="off" value="{{ $supplier->address}}">
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <label class="col-md-3 control-label text-left">Contact No</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="contacts" name="contacts" autocomplete="off" value="{{$supplier->contcat_no}}" >
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <label class="col-md-3 control-label text-left">Email Address</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="email" name="email" autocomplete="off" value="{{ $supplier->email}}">
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group col-md-12">
                    <label class="col-md-3 control-label text-left">Remark</label>
                    <div class="col-md-6">
                        <textarea class="form-control" style="resize:none" autocomplete="off" id="remark" name="remark" > {{$supplier->rmk}}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@section('notify_status')
 <!-- Status Details -->
 <div class="col-md-12">
    <div class="col-md-4"></div>
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <div class="panel panel-default" id="acdtlp" style="height:100%">
            <div class="panel-body">
                <h3 class="text-title" style="padding-bottom:10px;"><span class="fa fa-bell">&nbsp;</span>Status</h3>
                <div class="invoice">
                    <table class="table table-striped ">
                        <tr><td width="150" class="">Status</td>
                        <td class="text-right">
                        <div class="btn-group" role="group">
                            <button type="button" id="opt1" class="btn btn-@if ($supplier->sts==1)success @else light @endif">Active</button>
                            <button type="button" id="opt0" class="btn btn-@if ($supplier->sts==0)danger  @else light @endif">Inactive</button>
                            <button type="button" id="opt2" class="btn btn-@if ($supplier->sts==2)suspend @else light @endif">Suspend</button>
                            </div>
                        </td>
                        </tr>
                        <tr><td width="150">Created By</td><td class="text-right">{{ $supplier->create_user_name->name }}</td></tr>
                        <tr><td width="150">Created Date & Time</td><td class="text-right">{{ $supplier->create_date_time }}</td></tr>
                        @if($supplier->update_user_name!=null)
                        <tr><td width="200">Last Edited By</td><td class="text-right"> {{ $supplier->update_user_name->name  }}</td></tr>
                        <tr><td width="200">Last Edited Date & Time</td><td class="text-right">{{ $supplier->update_date_time }} </td></tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.end Status Details -->
@endsection
<!-- END PAGE CONTENT -->

<!-- START SCRIPT -->
@section('myscript')
<script type="text/javascript" src="{{ asset('/theme/js/plugins/bootstrap/bootstrap-select.js') }}"></script>
<script type="text/javascript">

//change status button
$(document).ready(function() {
    $("#opt1").click(function() {
        if(!$('#opt1').hasClass('btn btn-success')){
            $(this).removeClass('btn btn-light').addClass('btn btn-success');
                if ($('#opt0').hasClass('btn btn-danger')) {
                    $('#opt0').removeClass('btn btn-danger').addClass('btn btn-light');
                }else{
                    $('#opt2').removeClass('btn btn-suspend').addClass('btn btn-light');//
                }
            }
            $('#stss').val("1");
    });
    $("#opt0").click(function() {
        if(!$('#opt0').hasClass('btn btn-danger')){
            $(this).removeClass('btn btn-light').addClass('btn btn-danger');
                if ($('#opt1').hasClass('btn btn-success')) {
                    $('#opt1').removeClass('btn btn-success').addClass('btn btn-light');
                }else{
                    $('#opt2').removeClass('btn btn-suspend').addClass('btn btn-light');//
                }
        }
            $('#stss').val("0");
    });
    $("#opt2").click(function() {
        if(!$('#opt2').hasClass('btn btn-suspend')){
        $(this).removeClass('btn btn-light').addClass('btn btn-suspend');
            if ($('#opt1').hasClass('btn btn-success')) {
                $('#opt1').removeClass('btn btn-success').addClass('btn btn-light');
            }else{
                $('#opt0').removeClass('btn btn-danger').addClass('btn btn-light');
            }
        }
            $('#stss').val("2");
    });
});

    //Form Validation
    $(document).ready(function(){
        $("#frmdt").validate({
            onsubmit : false, //Disables form submit validation
            onkeyup :false,  //Disables onkeyup validation
            onclick : false, //Disables onclick validation of checkboxes and radio buttons
            ignore:[],
            errorPlacement: function(error, element) {
                if (element.hasClass('select')){
                        error.insertAfter(element);
                }else{
                error.insertAfter(element);
                }
            },
            rules:{
                sname:{required:true,chk_sname:true}, //supplier name
                saddr:{required:true}, // supplier address
            }
        });

        //Check Existing supplier name
        jQuery.validator.addMethod("chk_sname",function(value,element){
            var sname= $('#sname').val();
            var sid = $('#sid').val();

            if(sname!=''){
                function valdt(){
                    var temp = 0;
                    $.ajax({
                        type        : "POST",
                        url         : "{{ url('/supplier_name_validate') }}",
                        async       : false,
                        data        : {"sname":sname,"sid":sid},
                        headers     : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        beforeSend  : function(){$("body").css("cursor","wait"); $('#sname').addClass('data_loading');},
                        success     : function(msg){ temp=msg; $("body").css("cursor","default"); $('#sname').removeClass('data_loading');},
                        error       : function(){ $("body").css("cursor","default"); $('#sname').removeClass('data_loading'); console.log("Error");  }
                    });
                    return temp;
                }
                var vlrs = valdt();

                if(vlrs){
                    return false;
                }else {
                    return true;
                }
                }
        },"Already Existing Supplier Name");

    });

    //Form Save
    $(document).ready(function(){
        $('#savfm').click(function(e){
            var frmdt= true;//$('#frmdt').valid();
            if(frmdt==true){
                $("body").css("cursor","wait");
                $(".loader").fadeIn('slow');
                document.forms["frmdt"].submit();
            }else{
                console.error('Validation Error');
            }
        });
    });
</script>
@endsection
<!-- END SCRIPT -->
