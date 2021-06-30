<!-- Layout -->
@extends('layouts.contentLayout')
<!-- End Layout -->
@section('title','CREATE NEW SUPPLIER')

<!-- Custom Action  -->
@section('action_menu')
    <a class="btn btn-success panel-refresh" id="savfm" target="_self"><span class="fa fa-floppy-o">&nbsp;</span>Save</a>
    <a class="btn btn-info rdrct" href="{{ url('supplier_new') }}" target="_self"><span class="fa fa-clipboard">&nbsp;</span>Clear</a>
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
        <div class="col-md-12 pb-2">
            <div class="col-md-6" >
                <div class="form-group col-md-12" >
                    <label class="col-md-3 control-label text-left">Supplier Name </label>
                    <div class="col-md-2 col-sm-2">
                            <select class="form-control select" name="tid" id="tid">
                                    @foreach ($title as $row)
                                        <option value="{{ $row['tid'] }} " @if(old('tid')==$row['tid']) selected @endif > {{ $row['title'] }}</option>
                                    @endforeach
                            </select>
                        </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control"  id="sname" name="sname" autocomplete="off" value="{{ old('sname')}}">
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <label class="col-md-3 control-label text-left">Supplier Address</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="saddr" name="saddr" autocomplete="off" value="">
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <label class="col-md-3 control-label text-left">Contact No</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="contacts" name="contacts" autocomplete="off" value="" >
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <label class="col-md-3 control-label text-left">Email Address</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="email" name="email" autocomplete="off" value="">
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group col-md-12">
                    <label class="col-md-3 control-label text-left">Remark</label>
                    <div class="col-md-6">
                        <textarea class="form-control" style="resize:none" autocomplete="off" id="remark" name="remark" ></textarea>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

<!-- END PAGE CONTENT -->

<!-- START SCRIPT -->
@section('myscript')
<script type="text/javascript" src="{{ asset('/theme/js/plugins/bootstrap/bootstrap-select.js') }}"></script>
<script type="text/javascript">
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
            if(sname!=''){
                function valdt(){
                    var sid = 0;
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
