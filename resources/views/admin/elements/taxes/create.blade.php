@extends('admin.layouts.app')
@section('content')
<div class="container">
   <div class="row">
      <div class="col-md-12">
         <div class="card">
            <div class="card-header">
               <h3 class="mb-0 card-title">{{$pageTitle}}</h3>
            </div>
            <div class="card-body">
               @if ($message = Session::get('status'))
               <div class="alert alert-success">
                  <p>{{ $message }}</p>
               </div>
               @endif
            </div>
            <div class="col-lg-12">
               @if ($errors->any())
               <div class="alert alert-danger">
                  <strong>Whoops!</strong> There were some problems with your input.<br><br>
                  <ul>
                     @foreach ($errors->all() as $error)
                     <li>{{ $error }}</li>
                     @endforeach
                  </ul>
               </div>
               @endif
               <form action="{{route('admin.create_tax')}}" method="POST"
                  enctype="multipart/form-data">
                  @csrf
                  <div class="row">

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Tax Name</label>
                            <input type="text"  required  id="tax_name"  class="form-control" value="" placeholder="Tax Name" name="tax_name"  >
        
                        </div>
                     </div> 

                     <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Tax Value</label>
                            <input step="0.01" oninput="valueChanged(this.id)" type="number" id="tax_value" required class="form-control" onchange="if (this.value < 0) this.value = '';" placeholder="Tax Value" name="tax_value" >
                        </div>
                     </div>

                     <div class="col-md-2">
                        <label class="custom-switch">
                            <input type="hidden" name="is_active" value=0 />
                            <input type="checkbox" name="is_active"  checked value=1 class="custom-switch-input">
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description">Status</span>
                        </label>
                    </div>

                    

                     <div class="card">
                        <div class="card-header">
                            <h5>Tax Splits</h5>
                        </div>
                        <div class="card-body">
                                <table class="table table-bordered  ">
                                    <tbody class="bodyClass">
                                        <tr>
                                            <td>
                                                <input type="text" required name="split_tax_name[]" id="split_tax_name0"  class=".split_name form-control" placeholder="Tax Name" >
                                            </td>
                                            <td>
                                                <input step="0.01" type="number" required oninput="valueChanged(this.id)" name="split_tax_value[]" id="split_tax_name0" class="split_value form-control" placeholder="Tax Value(%)" >
                                            </td>
                                        </tr>
                                       
                                        
                                    </tbody>
                                </table>
                            <a id="add_row" href="#" tabindex="0" class="add_row mt-2 ml-2 btn btn-cyan text-white"><i class="fa fa-plus"></i> Add row</a>

                        </div>
                     </div>
                    

                     <div class="col-md-12">
                        <div class="form-group">
                           <center>
                           <button type="submit" id="submitAdd" class="btn btn-raised btn-primary">
                           <i class="fa fa-check-square-o"></i> Add</button>
                           <button type="reset" class="btn btn-raised btn-success">
                           Reset</button>
                           <a class="btn btn-danger" href="{{ route('admin.list_taxes') }}">Cancel</a>
                           </center>
                        </div>
                     </div>
                     
                  </div>
               </form>

      </div>
   </div>
</div>


<script type="text/javascript">


   $(document).ready(function() {
    var wrapper      = $(".bodyClass"); 
    var add_button      = $(".add_row"); 
   
     var x = 1; 
     $(add_button).click(function(e){ 
       e.preventDefault();
         x++; 
         $(wrapper).append('<tr><td><input required type="text" name="split_tax_name[]" id="split_tax_name'+x+'"  class=".split_name form-control" placeholder="Tax Name" ></td><td><input required type="number" step="0.01" name="split_tax_value[]" oninput="valueChanged(this.id)" id="split_tax_name'+x+'" class="split_value form-control" placeholder="Tax Value(%)"></td><td><a href="#" class="remove_field btn btn-small btn-danger"><i class="fa fa-trash"></i></a></td></tr>'); 
         
     });
   
     $(wrapper).on("click",".remove_field", function(e){ 
       e.preventDefault(); $(this).parent().parent().remove(); x--;
     })
   });

function valueChanged(id){

   var total_tax = 0;
   $('.split_value').each(function(){
      total_tax += parseFloat(this.value);
   });
  
   var tax_value = $('#tax_value').val()
   if(isNaN(total_tax)) {
      var total_tax = 0;
      }
   if(parseFloat(total_tax) != tax_value){
      $('#submitAdd').attr('disabled', true);
   }
   else
   {
      $("#submitAdd").attr("disabled", false);
   }

}

</script>

@endsection
