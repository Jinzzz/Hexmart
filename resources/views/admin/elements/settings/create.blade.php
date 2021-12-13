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

               <form  id="myForm" action="{{route('admin.update_sas')}}" method="POST"  enctype="multipart/form-data">
                  @csrf
              <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                           <label class="form-label">Service Area(km)</label>
                           <input type="number" step="0.01"  class="form-control" required  onchange="findKM(this.value)"
                              id="service_area" name="service_area"  value="{{old('service_area',@$settings->service_area)}}" placeholder="Service Area(km)">
                        </div>
                     </div>

                     <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-label">Order Number Prefix</label>
                          <input type="text"  class="form-control"  name="order_number_prefix"  value="{{old('order_number_prefix',@$settings->order_number_prefix)}}" placeholder="Order Number Prefix">
                        </div>
                      </div>

                        <div class="col-md-8">
                            <label class="custom-switch">
                                <input type="hidden" name="is_tax_included" value=0 />
                                <input type="checkbox" name="is_tax_included"  @if (@$settings->is_tax_included == 1)
                                checked
                                @endif  value=1 class="custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">Include Tax with each order</span>
                            </label>
                        </div>
                   
                   
                     <br>

                     <table id="first" class="mt-4 table">
                       <thead>
                         <tr>
                           <th>Starting(km)</th>
                           <th></th>
                           <th>Ending(km)</th>
                           <th>Delivery Charges</th>
                           <th>Packing Charges</th>
                         </tr>
                       </thead>
                       <tbody id="table_body">
                       @if ($settingcount > 0)
                        @php
                        $c = 0;
                        @endphp
                          @foreach ($admin_settings as $data)
                              <tr >
                              <td>
                                <input step="0.1" required type="number" id="start{{$c}}" onchange="endKMChanged(this.id)" value="{{ $data->service_start }}" class="form-control endingKm" name="start[]">
                              </td>
                                <td class="text-center"> -
                                
                                <input type="hidden" class="count"  value="{{ $c }}">

                                </td>
                              <td class="endcls" >
                                <input step="0.1" required type="number" id="end{{$c}}" onchange="startKMChanged(this.id)" value="{{ $data->service_end }}" class="endkm form-control startingKm"   name="end[]">
                              </td>
                              <td>
                                <input type="number" step="0.01" required value="{{ $data->delivery_charge }}" id="delivery_charge0" class="form-control"  name="delivery_charge[]">
                              </td>
                              <td>
                                <input type="number" step="0.01" required value="{{ $data->packing_charge }}"  id="packing_charge0" class="form-control"  name="packing_charge[]">
                              </td>
                               <td>
                                 <a id="r" class="remove_field btn btn-warning"><i style="color:red;" class="fa fa-trash"></i></a>
                              </td>
                            </tr>
                            @if ($c == count($admin_settings))
                             @php
                              echo '<script type="text/javascript">makeValue('.$loop->iterator.')</script>';
                             @endphp
                            @endif
                            @php
                              $c++;
                            @endphp
                          @endforeach

                        @else
                          <tr >
                              <td>
                                <input step="0.1" required  type="number"  onchange="endKMChanged(this.id)" id="start0"  class="form-control endingKm" name="start[]">
                              </td>
                                <td class="text-center"> 
                                - 
                                </td>
                              <td class="endcls"> 
                                <input step="0.1" required  type="number"  onchange="startKMChanged(this.id)" id="end0" class="endkm form-control startingKm"   name="end[]">
                              </td>
                              <td>
                                <input type="number" step="0.01" required  id="delivery_charge0" class="form-control"  name="delivery_charge[]">
                              </td>
                              <td>
                                <input type="number" step="0.01" required   id="packing_charge0" class="form-control"  name="packing_charge[]">
                              </td>
                             <td>
                                 <a id="r" class="remove_field btn btn-warning"><i style="color:red;" class="fa fa-trash"></i></a>
                              </td>
                            </tr>
                         @endif
                       </tbody>
                     </table>

                   
                    <div class="col-md-12">
                      <div class="form-group">
                        <center>
                        <a id="addDoc" class="text-white mb-2 btn btn-block btn-gray">Add Row</a>
                        <button type="submit" id="updateBtn" class="mb-2 btn btn-block btn-raised btn-info">Update</button>
                        </center>
                      </div>
                    </div>
                  </div>
                <br>
             
       </form>
           
      </div>
   </div>
</div>
</div>
@endsection



 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
</script>

<script>
function makeValue(val)
{
  alert(val);
}
   var x = 1;

 //$(document).ready(function() { 
    // if($('#first tr:last td:nth-child(2) input').val())
    // {
 //var x = $('#first tr:last td:nth-child(2) input').val();
    //alert(x);
   // }

 //});



$(document).ready(function() {
   var wrapper      = $("#table_body"); //Fields wrapper
  var add_button      = $("#addDoc"); //Add button ID

 // var x = 1; //initlal text box count


  $(add_button).click(function(e){ //on add input button click
    e.preventDefault();
    //max input box allowed
     var x = $('#first tr:last td:nth-child(2) input').val();

x++; //text box increment
//$(wrapper).append(' <tr ><td><input  type="number" id="start'+x -1+'"  class="form-control" name="start[]"></td><td class="text-center"> - </td><td><input  type="number" id="end'+x -1+'" class="endkm form-control"   name="end[]"></td><td><input type="number" required  id="delivery_charge'+x -1+'" class="form-control"  name="delivery_charge[]"></td><td><input type="number" required   id="packing_charge'+x-1+'" class="form-control"  name="packing_charge[]"></td><td><a id="r" class="remove_field btn btn-warning"><i style="color:red;" class="fa fa-trash"></i></a></td></tr>'); //add input box
$(wrapper).append(' <tr ><td><input step="0.1" required onchange="endKMChanged(this.id)"  type="number" id="start'+x+'" value="0"  class="form-control endingKm" name="start[]"></td><td class="text-center"> - </td><td class="endcls" ><input step="0.1" onchange="startKMChanged(this.id)" required type="number" value="0"  id="end'+x+'" class="endkm form-control startingKm"   name="end[]"></td><td><input type="number" step="0.01" required  id="delivery_charge'+x+'" class="form-control"  name="delivery_charge[]"></td><td><input type="number" step="0.01" required   id="packing_charge'+x+'" class="form-control"  name="packing_charge[]"></td><td><a id="r" class="remove_field btn btn-warning"><i style="color:red;" class="fa fa-trash"></i></a></td></tr>'); //add input box
  });

  $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
    e.preventDefault(); $(this).parent().parent().remove(); x--;
  })
});



function endKMChanged(id)
{
  if(id != 'start0'){ 
    var fullKm = $('#service_area').val();

    let ending = [];
    let starting = [];

    $($(".startingKm").get().reverse()).each(function() {
      let end = $(this).val();
      ending.push(end);  
    });

    $($(".endingKm").get().reverse()).each(function() {
      let start = $(this).val();
      starting.push(start);   
    });

  //  console.log(starting);
  //  console.log(ending);

    $.each(ending, function(index, value){
      
             //  console.log(parseFloat(starting[0])+" - "+parseFloat(ending[1]));

      if(parseFloat(starting[0]) < parseFloat(ending[1]))
      {
       //  console.log(parseFloat(starting[0])+" < "+parseFloat(ending[1]));
      //   console.log(id);
          $('#'+id).val(0);
           $('#'+id).append('<p>dfdf</p>');
         //  $('#'+id)
         if(index == 0)
         {
          alert('starting KM should be greater than '+parseFloat(ending[1]));
         }

      }

      if(parseFloat(starting[0]) > parseFloat(fullKm))
      {
         
          $('#'+id).val(0);
          
          if(index == 0)
         {
          alert('starting KM should be less than '+parseFloat(fullKm));
         }
      }



      var endingKMS = [];
      $($(".startingKm").get().reverse()).each(function() {
        let end = $(this).val();
        endingKMS.push(end);  
      });

      if((jQuery.inArray("0.0", endingKMS) != -1) || (jQuery.inArray("0", endingKMS) != -1))
      {
       // $('#updateBtn').attr('disabled', 'disabled');
      }
      else
      {
       // $("#updateBtn").attr('disabled', false);
      }


    });


   
  
  }else
  {
    var fullKm = $('#service_area').val();
    var startKm = $('#start0').val();
    if(startKm > 0 ){
      alert("Starting km should be 0");
      $('#start0').val(0.0);
    }
  }

}
function startKMChanged(id)
{
   var fullKm = $('#service_area').val();
    var endKm = $('#'+id).val();
  
    let ending = [];
    let starting = [];

    $($(".startingKm").get().reverse()).each(function() {
      let end = $(this).val();
      ending.push(end);  
    
    });
    $($(".endingKm").get().reverse()).each(function() {
      let start = $(this).val();
      starting.push(start);   
    });


    // console.log(starting);
    // console.log(ending);

    $.each(ending, function(index, value){
      if(parseFloat(ending[0]) < parseFloat(starting[0]))
      {
       //  console.log(parseFloat(ending[0])+" < "+parseFloat(starting[0]));
          $('#'+id).val(0);
           if(index == 0)
         {
          alert('ending KM should be greater than '+parseFloat(starting[0]));
         }
      }

      if(parseFloat(ending[0]) > parseFloat(fullKm))
      {
     //   console.log(parseFloat(ending[0])+" > "+parseFloat(fullKm));
        $('#'+id).val(0);
        if(index == 0)
         {
          alert('starting KM should be less than '+parseFloat(fullKm));
         }
      }

      
      var endingKMS = [];
      $($(".startingKm").get().reverse()).each(function() {
        let end = $(this).val();
        endingKMS.push(end);  
      });

      if((jQuery.inArray("0.0", endingKMS) != -1) || (jQuery.inArray("0", endingKMS) != -1))
      {
       // $('#updateBtn').attr('disabled', 'disabled');
      }
      else
      {
       // $("#updateBtn").attr('disabled', false);
      }


    });


  


}



$(document).ready(function(){
    $('#myForm').on('submit', function(e){
        e.preventDefault();

        var endingKMS = [];
        $($(".startingKm").get().reverse()).each(function() {
          let end = $(this).val();
          endingKMS.push(end);  
        });

        if((jQuery.inArray("0.0", endingKMS) != -1) || (jQuery.inArray("0", endingKMS) != -1))
        {
          alert("wrong input");
          return false;
        }
        else
        {         
        this.submit();
        }

    });
});



</script>



<script>

function findKM_(km)
{
  //if((km % 5) != 0)
 // { 
  //  $('#service_area').val(0);
  //}
 // {
    var km_count =  km / 5;
     $('#table_body').empty();
    var v1 = 0.1;

    var i = 1;
    for(i = 1; i <= km_count; i++)
    {
     // var html = "";
     var v2 = i * 5;
     var v1 = (v2 - 4.9);
    
      $('#table_body').append('<tr><td><input type="number" readonly step="0.1" id="start'+i+'" value="'+v1.toFixed(1)+'" class="form-control" name="start[]"></td><td class="text-center"> - </td><td><input readonly type="number" id="end'+i+'" step="0.1"  value="'+v2+'"  class="form-control"   name="end[]"></td><td><input type="number" step="0.01" id="delivery_charge'+i+'" class="form-control" required name="delivery_charge[]"></td><td><input type="number" step="0.01" id="packing_charge'+i+'" required class="form-control"  name="packing_charge[]"></td></tr>');
    }

    if((km % 5) > 0)
    {
      var v4 = km % 5;
      if(km > 5)
      {
        v1 = v1 + 5;
        v4 = v4 + v2;

      }

      $('#table_body').append('<tr><td><input readonly type="number" step="0.1" id="start'+i+'" value="'+v1.toFixed(1)+'" class="form-control" name="start[]"></td><td class="text-center"> - </td><td><input readonly type="number" id="end'+i+'" step="0.1"  value="'+v4+'"  class="form-control"   name="end[]"></td><td><input type="number" step="0.01" id="delivery_charge'+i+'" class="form-control" required  name="delivery_charge[]"></td><td><input type="number" step="0.01" required id="packing_charge'+i+'" class="form-control"  name="packing_charge[]"></td></tr>');
    }
  //}
}



$(document).ready(function() {
  if (window.File && window.FileList && window.FileReader) {
    $("#files").on("change", function(e) {
      var files = e.target.files,
        filesLength = files.length;
      for (var i = 0; i < filesLength; i++) {
        var f = files[i]
        var fileReader = new FileReader();
        fileReader.onload = (function(e) {
          var file = e.target;
          $("<span class=\"pip\">" +
            "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
            "<br/><span class=\"remove\">Remove image</span>" +
            "</span>").insertAfter("#files");
          $(".remove").click(function(){
            $(this).parent(".pip").remove();
          });

          // Old code here
          /*$("<img></img>", {
            class: "imageThumb",
            src: e.target.result,
            title: file.name + " | Click to remove"
          }).insertAfter("#files").click(function(){$(this).remove();});*/

        });
        fileReader.readAsDataURL(f);
      }
      console.log(files);
    });
  } else {
    alert("Your browser doesn't support to File API")
  }
});
</script>


<script type="text/javascript">


$(document).ready(function() {
   var wrapper      = $(".BaseFeatureArea"); //Fields wrapper
  var add_button      = $(".addBaseFeatureImage"); //Add button ID

  var x = 1; //initlal text box count
  $(add_button).click(function(e){ //on add input button click
    e.preventDefault();
    //max input box allowed
      x++; //text box increment
      $(wrapper).append('<div>  <input type="file" class="form-control" name="product_image[]"  value="{{old('product_image')}}" placeholder="Base Product Feature Image" /> <a href="#" class="remove_field btn btn-small btn-danger">Remove</a></div>'); //add input box

  });

  $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
    e.preventDefault(); $(this).parent('div').remove(); x--;
  })
});




 $(document).ready(function() {

var agc = 0;

       $('.attr_group').change(function(){
       // alert("hi");
       if(agc != 0)
       { 
       // alert("dd");
        var attr_group_id = $(this).val();

        var _token= $('input[name="_token"]').val();
        //alert(_token);
        $.ajax({
          type:"GET",
          url:"{{ url('settings/product/ajax/get_attr_value') }}?attr_group_id="+attr_group_id,


          success:function(res){
            //alert(data);
            if(res){
            $('.attr_value').prop("diabled",false);
            $('.attr_value').empty();
            $('.attr_value').append('<option value="">Value</option>');
            $.each(res,function(attr_value_id,group_value)
            {
              $('.attr_value').append('<option value="'+attr_value_id+'">'+group_value+'</option>');
            });

            }else
            {
              $('.attr_value').empty();

            }
            }

        });
       }
       else
       {
         agc++;
       }
      });

    });
  $(document).ready(function() {
    var pcc = 0;
      //  alert("dd");
       $('#business_type').change(function(){
         if(pcc != 0)
         { 
        var business_type_id = $(this).val();
       //alert(business_type_id);
        var _token= $('input[name="_token"]').val();
        //alert(_token);
        $.ajax({
          type:"GET",
          url:"{{ url('settings/product/ajax/get_category') }}?business_type_id="+business_type_id,


          success:function(res){
           // alert(data);
            if(res){
            $('#category').prop("diabled",false);
            $('#category').empty();
            $('#category').append('<option value="">Product Category</option>');
            $.each(res,function(category_id,category_name)
            {
              $('#category').append('<option value="'+category_id+'">'+category_name+'</option>');
            });

            }else
            {
              $('#category').empty();

            }
            }

        });
         }else{
           pcc++;
         }
      });

    });


    $(document).ready(function() {
    var cc = 0;


       $('#city').change(function(){
          if(cc != 0)
         { 

        var city_id = $(this).val();
       // alert(city_id);
        var _token= $('input[name="_token"]').val();

        $.ajax({
          type:"GET",
          url:"{{ url('settings/ajax/get_town') }}?city_id="+city_id ,

          success:function(res){

           if(res){
              console.log(res);
            $('#town').prop("diabled",false);
            $('#town').empty();

            $('#town').append('<option value="">Select Town</option>');
            $.each(res,function(town_id,town_name)
            {
              $('#town').append('<option value="'+town_id+'">'+town_name+'</option>');
            });

            }else
            {
              $('#town').empty();

             }
            }

        });
         }
         else
         {
           cc++;
         }
      });

    });

</script>
