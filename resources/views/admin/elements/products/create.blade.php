@extends('admin.layouts.app')
@section('content')

<style>
input[type="file"] {
  display: block;
}
.imageThumb {
  max-height: 75px;
  border: 2px solid;
  padding: 1px;
  cursor: pointer;
}
.pip {
  display: inline-block;
  margin: 10px 10px 0 0;
}
.remove {
  display: block;
  background: #444;
  border: 1px solid black;
  color: white;
  text-align: center;
  cursor: pointer;
}
.remove:hover {
  background: white;
  color: black;
}
</style>

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

               <form action="{{route('admin.store_product')}}" method="POST"
                  enctype="multipart/form-data">
                  @csrf
                  <div class="row">
                     <div class="col-md-12">
                        <div class="form-group">
                           <label class="form-label">Product Name *</label>
                           <input type="text" class="form-control" required
                              name="product_name" id="product_name" value="{{old('product_name')}}" placeholder="Product Name">
                        </div>
                     </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label" >Product Description *</label>
                            <!--<textarea class="form-control" id="product_description" required name="product_description" rows="2" cols="3" placeholder="Product Description">{{old('product_description')}}</textarea>-->
                            <textarea class="form-control" required name="product_description" rows="4"  placeholder="Product Description">{{old('product_description')}}</textarea>
                        </div>
                     </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Regular Price *</label>
                            <input step="0.01" type="number" class="form-control" required 
                             name="regular_price"   id="regular_price" value="{{old('regular_price')}}" placeholder="Regular Price"  oninput="regularPriceChange()" >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Sale Price *</label>
                            <input step="0.01" type="number" class="form-control" required  name="sale_price"  id="sale_price" value="{{old('sale_price')}}" oninput="salePriceChange()"  placeholder="Sale Price">
                          <span style="color:red" id="sale_priceMsg"> </span>
                        </div>
                    </div> 

                    <div class="card">
                      <div class="card-body " id="cg_sp_div">
                        <section class="row" >

                          <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Customer Group</label>
                                <select   name="customer_group_id[]" id="customer_group_id0" class="form-control"  >
                                     <option value="">Customer Group</option>
                                    @foreach($customerGroups as $key)
                                      <option {{old('customer_group_id') == $key->customer_group_id ? 'selected':''}} value="{{$key->customer_group_id }}">
                                       {{$key->customer_group_name }} 
                                      </option>
                                    @endforeach
                                </select>
                            </div>
                          </div>

                            <div class="col-md-6">
                              <div class="form-group">
                                  <label class="form-label">Special Price </label>
                                  <input step="0.01" type="number" class="form-control"   name="special_price[]"  id="special_price0" oninput="specialPriceChange(0)"  placeholder="Spectial Price">
                                <span style="color:red" id="special_price_Msg0"> </span>
                              </div>
                            </div> 
                        </section>

                       
                      </div>

                      <div class="card-footer">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <buttom class="btn btn-sm btn-secondary" id="addMoreCG">Add More</buttom>
                            </div>
                          </div>
                        </div>
                      </div>
                      
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-label">Tax *</label>
                           <select required  name="tax_id" id="tax_id" class="form-control"  >
                                 <option value="">Tax</option>
                                @foreach($tax as $key)
                                <option {{old('tax_id') == $key->tax_id ? 'selected':''}} value="{{$key->tax_id }}"> {{$key->tax_name }} ( {{$key->tax_value}} ) </option>
                                @endforeach
                              </select>
                        </div>
                    </div>
                     <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-label">Min Stock *</label>
                          <input type="number" required class="form-control" name="min_stock" id="min_stock" value="{{old('min_stock' )}}" placeholder="Min Stock">               
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Product Code *</label>
                            <input type="text" required class="form-control" name="product_code" id="product_code" value="{{old('product_code')}}" placeholder="Product Code">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-label">Product Type *</label>
                           <select onchange="proTypeChanged(this.value)" name="product_type" required id="product_type" class="form-control"  >
                                 <option value="1"> Product</option>
                                 <option value="2"> Service</option>
                              </select>
                        </div>
                     </div>
                    
                     
                     <div id="service_type_id" class="col-md-12">
                      <div class="form-group">
                        <label class="form-label">Service Type*</label>
                         <select id="service_type_input"  onchange="servTypeChanged(this.value)"  name="service_type"  class="form-control"  >
                          <option value=""> Service Type </option>
                          <option value="1"> Booking Only</option>
                          <option value="2"> Purchase</option>
                          </select>
                      </div>
                   </div>  
                     <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label" >Product Category * </label>
                            <select name="product_cat_id" required id="category" class="form-control"  >
                                 <option value="">Product Category</option>
                                 @foreach($category as $key)
                                 <option {{old('product_cat_id') == $key->item_category_id ? 'selected':''}} value="{{ @$key->item_category_id }}">{{ @$key->category_name }}</option>
                                 @endforeach
                                     

                            </select>
                        </div>
                     </div>

                     <div class="col-md-4">
                      <div class="form-group">
                          <label class="form-label" >Sub Category Level One</label>
                          <select name="sub_category_id" id="sub_category_id" class="form-control"  >
                               <option value="">Sub Category</option>
                          </select>
                      </div>
                   </div>

                   <div class="col-md-4">
                      <div class="form-group">
                          <label class="form-label" >Sub Category Level Two</label>
                          <select name="iltsc_id" id="iltsc_id" class="form-control"  >
                               <option value="">Sub Category</option>
                          </select>
                      </div>
                   </div>


                     <div class="col-md-6">
                        <div class="form-group">
                          <label class="form-label">Brand *</label>
                           <select required name="brand_id" id="brand_id" class="form-control"  >
                                 <option value="">Brand</option>
                                @foreach($brands as $key)
                                <option {{old('brand_id') == $key->brand_id ? 'selected':''}} value="{{$key->brand_id }}"> {{$key->brand_name }} </option>
                                @endforeach
                              </select>
                        </div>
                     </div>


                    <div class="col-md-6">
                        <div class="form-group">
                          <div class="BaseFeatureArea"> 
                              <label class="form-label">Upload Images *</label>
                              <input type="file" accept="image/*" required class="form-control" name="product_image[]" multiple="" value="{{old('product_image')}}" placeholder="Product Feature Image">
                          </div>
                        </div>
                    </div>

                  </div>
                  
                    <section style="display:none;" id="varClass"> 
                  <div id="attSec" class="container variantFulClass"> 
                    <p class="h4 ml-2">Add Product Variants </p>
                    <div  id="attRow" class="section">
                      <div style="border: 1px solid #0008ff42;"  class="mt-2 row">
                        <div class="col-md-12">
                          <div class="form-group">
                              <label class="form-label">Variant Name* </label>
                              <input  type="text" class="form-control proVariant"  name="variant_name[]"   id="variant_name0" placeholder="Variant Name">
                          </div>
                      </div>
                        <div id="attHalfRow0a" class="container"> 
                          <div  id="attHalfSec0a" class="section">
                            <div  class=" row">
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label class="form-label">Attribute* </label>
                                    <select name="attr_group_id[0][]" onchange="findValue('0a0')"  id="attr_group0a0" class="attr_group form-control proVariant" >
                                      <option value="">Attribute</option>
                                      @foreach($attr_groups as $key)
                                      <option value="{{$key->attribute_group_id}}"> {{$key->attribute_group}} </option>
                                            @endforeach
                                    </select>
                                  </div> 
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Value* </label>
                                        <select name="attr_value_id[0][]"   id="attr_value0a0" class="attr_value form-control proVariant" >
                                          <option value="">Value</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                          </div>

                          <div class="col-md-2">
                            <div class="form-group">
                                <a  id="addVariantAttr0" onclick="addAttributes('0a')" class="text-white mt-2 btn btn-sm btn-secondary">Add More</a>
                            </div>
                          </div>
                        </div>

                      


                        <div class="col-md-6">
                          <div class="form-group">
                              <label class="form-label">Regular Price* </label>
                              <input step="0.01" type="number" class="form-control proVariant "   oninput="regularPriceChangeVar(0)"  
                              name="var_regular_price[]"   id="var_regular_price0" value="" placeholder="Regular Price">
                          </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Sale Price* </label>
                                <input step="0.01" type="number" class="form-control proVariant"  oninput="salePriceChangeVar(0)"
                                name="var_sale_price[]"  id="var_sale_price0" value="" placeholder="Sale Price">
                                <span style="color:red" id="sale_priceMsg0"> </span>
                            </div>
                        </div>


                        <div id="speHalfRow0a" class="container"> 
                          <div  id="speHalfSec0a" class="section">
                            <div  class=" row">
                                
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label class="form-label">Customer Group </label>
                                    <select   name="var_customer_group_id[0][]" id="var_customer_group_id0a0" class="form-control proVariant"  >
                                        <option value="">Customer Group</option>
                                        @foreach($customerGroups as $key)
                                          <option value="{{$key->customer_group_id }}">
                                          {{$key->customer_group_name }} 
                                          </option>
                                        @endforeach
                                    </select>
                                  </div> 
                                </div>

                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label class="form-label">Special Price </label>
                                    <input step="0.01" type="number" class="form-control proVariant"   name="var_special_price[0][]"  id="var_special_price0a0" oninput="specialPriceChangeVar('0a0',0)"  placeholder="Spectial Price">
                                    <span style="color:red" id="var_special_price_Msg0a0"> </span>
                                  </div>
                                </div> 

                              

                            </div>
                            
                          </div>

                          <div class="col-md-2">
                            <div class="form-group">
                                <a  id="addVariantSp0" onclick="addCgSpRow('0a',0)" class="text-white mt-2 btn btn-sm btn-secondary">Add More</a>
                            </div>
                          </div>
                        </div>


                        <input type="hidden" id="cval0" value="0">
                        
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="form-label">Unit </label>
                            <select name="unit[]"   id="unit0" class="unit form-control proVariant" >
                              <option value="">Unit</option>
                              @foreach($units as $key)
                              <option value="{{$key->unit_id}}"> {{$key->unit_name}} </option>
                                    @endforeach
                            </select>
                          </div> 
                        </div>


                        <div class="col-md-6">
                          <div class="form-group">
                              <label class="form-label">Images* </label>
                              <input type="file" multiple class="form-control proVariant" name="var_images[0][]" >
                          </div>
                      </div>
                   </div>

                   
                 </div>
                 <div class="col-md-2">
                  <div class="form-group">
                      <a  id="addVariant" class="text-white mt-2 btn btn-raised btn-success">Add More</a>
                  </div>
                  </div>
                </div>

                 </section>

                  <a class="btn btn-primary btn-raised text-white mt-2" id="btnAddVar" onclick="showVariant()"> Add Variant </a>


                  </div>
                <br>
              <div class="row">
                      <div class="col-md-12">
                     <div class="form-group">
                     <center>
                            <button type="submit" id="submit" class="btn btn-raised btn-info">
                           Submit</button>
                           <button type="reset" class="btn btn-raised btn-success">
                           Reset</button>
                           <a class="btn btn-danger" href="{{ route('admin.products') }}">Cancel</a>
                       </center>
                     </div>
                  </div>
                </div>
       </form>
           
       
       
  


      </div>
   </div>
</div>
</div>








     <script src="{{ asset('assets\vendor\unisharp\laravel-ckeditor/ckeditor.js')}}"></script>
     <script>  CKEDITOR.replace('product_description');  </script>
      
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

<script>

$(document).ready(function() {
      var wrapper      = $("#cg_sp_div"); //Fields wrapper
      var add_button      = $("#addMoreCG"); //Add button ID
      var cg = 0; //initlal text box count
      $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        cg++; //text box increment
          $(wrapper).append('<div class="row mt-2"><div class="col-md-6"><div class="form-group"><label class="form-label">Customer Group </label><select   name="customer_group_id[]" id="customer_group_id'+cg+'" class="form-control"  ><option value="">Customer Group</option>@foreach($customerGroups as $key)<option  value="{{$key->customer_group_id }}">{{$key->customer_group_name }} </option>@endforeach</select></div></div><div class="col-md-6"><div class="form-group"><label class="form-label">Special Price </label><input step="0.01" type="number" class="form-control"   name="special_price[]"  id="special_price'+cg+'" oninput="specialPriceChange('+cg+')"  placeholder="Spectial Price"><span style="color:red" id="special_price_Msg'+cg+'"> </span></div></div> <a href="#" class="remove_cg_sp_row ml-4 mb-2 btn btn-warning btn btn-sm">Remove</a></div>'); 
      });
      
      $(wrapper).on("click",".remove_cg_sp_row", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); cg--;
      })
  });


  function specialPriceChange(cgc)
  {
   // console.log(cgc);
      let specialPrice = $('#special_price'+cgc).val();
      let regularPrice = $('#regular_price').val();
      
      if(parseFloat(specialPrice) < 0)
      {
              $('#special_price'+cgc).val(0);
      }
    
      
      if(specialPrice !== "")
      {
          if(regularPrice !== "")
          {
              if( parseFloat(specialPrice) <= parseFloat(regularPrice))
              {
                  $('#special_price_Msg'+cgc).html('');
                  $("#submit").attr("disabled", false);
                // $("#addMoreCG").attr("disabled", false);
                $("#addMoreCG").show();

              }
              else
              {
                  $('#special_price_Msg'+cgc).html('Special price should be less than or equal to regular price');
                  $("#submit").attr("disabled", true);
                  $("#addMoreCG").hide();
              }
          }
          else
          {
              $('#special_price_Msg'+cgc).html('Regular price is empty');
              $("#submit").attr("disabled", true);
              $("#addMoreCG").hide();

          }
      }
      else
      {
          $('#special_price_Msg'+cgc).html('');
          $("#submit").attr("disabled", false);
          $("#addMoreCG").show();

      }
  }

  
  function specialPriceChangeVar(cgc,mc)
  {
      let specialPrice = $('#var_special_price'+cgc).val();
      let regularPrice = $('#var_regular_price'+mc).val();
      
     // console.log(cgc,mc,specialPrice,regularPrice);

      if(parseFloat(specialPrice) < 0)
      {
          $('#var_special_price'+cgc).val(0);
      }

      if(specialPrice !== "")
      {
          if(regularPrice !== "")
          {
              if( parseFloat(specialPrice) <= parseFloat(regularPrice))
              {
                  $('#var_special_price_Msg'+cgc).html('');
                  $("#submit").attr("disabled", false);
                  // $("#addMoreCG").attr("disabled", false);
                  $("#addVariantSp"+mc).show();

              }
              else
              {
                  $('#var_special_price_Msg'+cgc).html('Special price should be less than or equal to regular price');
                  $("#submit").attr("disabled", true);
                  $("#addVariantSp"+mc).hide();
              }
          }
          else
          {
              $('#var_special_price_Msg'+cgc).html('Regular price is empty');
              $("#submit").attr("disabled", true);
              $("#addVariantSp"+mc).hide();

          }
      }
      else
      {
          $('#var_special_price_Msg'+cgc).html('');
          $("#submit").attr("disabled", false);
          $("#addVariantSp"+mc).show();

      }
      
  }



function showVariant(){

      if($("#varClass").is(":visible"))
      {
            $("#varClass").hide();
            $("#btnAddVar").text('Add Variant');
      }
      else
      {
            $("#varClass").show();
            $("#btnAddVar").text('Hide Variant');
      }

}


function regularPriceChange(){
    salePriceChange();
}

function salePriceChange()
{
    let salePrice = $('#sale_price').val();
    let regularPrice = $('#regular_price').val();
    
    if(parseFloat(salePrice) < 0)
    {
            $('#sale_price').val(0);
    }
    
    if(parseFloat(regularPrice) < 0)
    {
            $('#regular_price').val(0);
    }
    
    
    if(salePrice !== "")
    {
        if(regularPrice !== "")
        {
           // console.log(regularPrice + " " + salePrice);
            if( parseFloat(salePrice) <= parseFloat(regularPrice))
            {
                $('#sale_priceMsg').html('');
                $("#submit").attr("disabled", false);

            }
            else
            {
                $('#sale_priceMsg').html('Sale price should be less than or equal to regular price');
                $("#submit").attr("disabled", true);
            }
        }
        else
        {
             $('#sale_priceMsg').html('Regular price is empty');
             $("#submit").attr("disabled", true);

        }
    }
    else
    {
        $('#sale_priceMsg').html('');
        $("#submit").attr("disabled", false);

    }
}


function regularPriceChangeVar(p){
    salePriceChangeVar(p);
}

function salePriceChangeVar(p)
{
    let salePrice = $('#var_sale_price'+p).val();
    let regularPrice = $('#var_regular_price'+p).val();
    
    if(parseFloat(salePrice) < 0)
    {
            $('#var_sale_price'+p).val(0);
    }
    
    if(parseFloat(regularPrice) < 0)
    {
            $('#var_regular_price'+p).val(0);
    }
    
    
    if(salePrice !== "")
    {
        if(regularPrice !== "")
        {
            if( parseFloat(salePrice) <= parseFloat(regularPrice))
            {
                $('#sale_priceMsg'+p).html('');
                $("#submit").attr("disabled", false);

            }
            else
            {
                $('#sale_priceMsg'+p).html('Sale price should be less than or equal to regular price');
                $("#submit").attr("disabled", true);
            }
        }
        else
        {
             $('#sale_priceMsg'+p).html('Regular price is empty');
             $("#submit").attr("disabled", true);

        }
    }
    else
    {
        $('#sale_priceMsg'+p).html('');
        $("#submit").attr("disabled", false);

    }
}


let cgx = 0;

  function addCgSpRow(id_val,cd){
      
      var wrapper      = $("#speHalfSec"+id_val); 
      var add_button      = $("#addVariantAttr"+id_val); 

      ++cgx;

      var spCgid = id_val + cgx;
      
      var id_number = parseInt(id_val. replace(/[^0-9. ]/g, ""));
      
      $(wrapper).append('<div  class="row"><div class="col-md-6"><div class="form-group"><label class="form-label">Customer Group </label><select   name="var_customer_group_id['+id_number+'][]" id="var_customer_group_id'+spCgid+'" class="form-control"><option value="">Customer Group</option>@foreach($customerGroups as $key)<option value="{{$key->customer_group_id }}">{{$key->customer_group_name }} </option>@endforeach</select></div> </div><div class="col-md-6"><div class="form-group"><label class="form-label">Special Price </label><input step="0.01" type="number" class="form-control"   name="var_special_price['+id_number+'][]"  id="var_special_price'+spCgid+'" oninput="specialPriceChangeVar(\''+spCgid+'\','+id_number+')"  placeholder="Spectial Price"><span style="color:red" id="var_special_price_Msg'+spCgid+'"> </span></div></div> <a href="#" class="remove_field ml-5 btn btn-info btn btn-sm">Remove</a></div>'); //add input box
      
      $(wrapper).on("click",".remove_field", function(e){ // remove 
        e.preventDefault(); $(this).parent('div').remove(); 
        $("#addVariantSp"+cd).show();
        // alert(id_val);
        // alert(cgx);
      });

  }


      var xx = 0; 

  function addAttributes(att_id_val){
      
  //  alert(att_id_val);
      var wrapper      = $("#attHalfSec"+att_id_val); 
      var add_button      = $("#addVariantAttr"+att_id_val); 
     // alert(wrapper);
      ++xx;
      var attid = att_id_val + xx;
      
            var id_number = parseInt(att_id_val. replace(/[^0-9. ]/g, ""));
          

          $(wrapper).append('<div  class="row"><div class="col-md-6"><div class="form-group"><label class="form-label">Attribute </label><select name="attr_group_id['+id_number+'][]" onchange="findValue(\''+attid+'\')"id="attr_group'+attid+'" class="attr_group form-control" ><option value="">Attribute</option>@foreach($attr_groups as $key)<option  value="{{$key->attribute_group_id}}"> {{$key->attribute_group}} </option>@endforeach</select></div></div><div class="col-md-6"><div class="form-group"><label class="form-label">Value </label><select name="attr_value_id['+id_number+'][]"   id="attr_value'+attid+'" class="attr_value form-control" ><option value="">Value</option></select></div></div><a href="#" class="remove_field ml-5 btn btn-info btn btn-sm">Remove</a></div>'); //add input box
      
      $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); 
      });

  }

  


  $(document).ready(function() {
      var wrapper      = $("#attRow"); //Fields wrapper
      var add_button      = $("#addVariant"); //Add button ID
      var x = 0; //initlal text box count
      $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        //max input box allowed
          x++; //text box increment
          var attr_id_div = x+'a0';
          $(wrapper).append('<div style="border: 1px solid #0008ff42;" class="mt-2 row"><div class="col-md-12"><div class="form-group"><label class="form-label">Variant Name </label><input  type="text" class="form-control"  name="variant_name[]"   id="variant_name'+x+'" placeholder="Variant Name"></div></div><div id="attHalfRow'+x+'a" class="container"><div  id="attHalfSec'+x+'a" class="section"><div class=" row">  <div class="col-md-6"><div class="form-group"><label class="form-label">Attribute </label><select name="attr_group_id['+x+'][]" onchange="findValue(\''+attr_id_div+'\')"  id="attr_group'+attr_id_div+'" class="attr_group form-control" ><option value="">Attribute</option>@foreach($attr_groups as $key)<option value="{{$key->attribute_group_id}}"> {{$key->attribute_group}} </option>@endforeach</select></div></div>  <div class="col-md-6"><div class="form-group"><label class="form-label">Value </label><select name="attr_value_id['+x+'][]"   id="attr_value'+attr_id_div+'" class="attr_value form-control" ><option value="">Value</option></select></div></div>  </div></div>  <div class="col-md-2"><div class="form-group"><a  id="addVariantAttr'+x+'" onclick="addAttributes(\''+x+'a\')" class="text-white mt-2 btn btn-sm btn-secondary">Add More</a></div></div>  </div>     <div class="col-md-6"><div class="form-group"><label class="form-label">Regular Price </label><input step="0.01" type="number" class="form-control"  oninput="regularPriceChangeVar('+x+')"  name="var_regular_price[]"   id="var_regular_price'+x+'"   placeholder="Regular Price"></div></div><div class="col-md-6"><div class="form-group"><label class="form-label">Sale Price </label><input step="0.01" type="number" class="form-control"  name="var_sale_price[]"  id="var_sale_price'+x+'" oninput="salePriceChangeVar('+x+')" placeholder="Sale Price"><span style="color:red" id="sale_priceMsg'+x+'"></span></div></div><div id="speHalfRow'+x+'a" class="container"> <div  id="speHalfSec'+x+'a" class="section"><div  class=" row"><div class="col-md-6"><div class="form-group"><label class="form-label">Customer Group </label><select   name="var_customer_group_id['+x+'][]" id="var_customer_group_id'+attr_id_div+'" class="form-control "  ><option value="">Customer Group</option>@foreach($customerGroups as $key)<option value="{{$key->customer_group_id }}">{{$key->customer_group_name }} </option>@endforeach</select></div> </div><div class="col-md-6"><div class="form-group"><label class="form-label">Special Price </label><input step="0.01" type="number" class="form-control "   name="var_special_price['+x+'][]"  id="var_special_price'+attr_id_div+'" oninput="specialPriceChangeVar(\''+attr_id_div+'\','+x+')"  placeholder="Spectial Price"><span style="color:red" id="var_special_price_Msg'+attr_id_div+'"> </span></div></div> </div>  </div><div class="col-md-2"><div class="form-group"><a  id="addVariantSp'+x+'" onclick="addCgSpRow(\''+x+'a\','+x+')" class="text-white mt-2 btn btn-sm btn-secondary">Add More</a></div></div></div><input type="hidden" id="cval'+x+'" value="'+x+'"><div class="col-md-6"><div class="form-group"> <label class="form-label">Unit </label> <select name="unit[]"   id="unit'+x+'" class="unit form-control proVariant" > <option value="">Unit</option> @foreach($units as $key) <option value="{{$key->unit_id}}"> {{$key->unit_name}} </option> @endforeach </select></div> </div><div class="col-md-6"><div class="form-group"><label class="form-label">Images </label><input multiple type="file" class="form-control" name="var_images['+x+'][]" ></div></div><a href="#" class="remove_field ml-4 mb-2 btn btn-warning btn btn-sm">Remove</a></div>'); //add input box
      });
      
      $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
      })
  });


$(document).ready(function () {
    $("div#service_type_id").hide();
   
});

    $(document).ready(function () {
        $('#variant_name0').on('input', function() {
            let attVal = $("#variant_name0").val();
            if(attVal == '')
            {
                $(".proVariant").prop('required',false); 
            }
            else
            {
                $(".proVariant").prop('required',true); 
            }
        });
    });


function proTypeChanged(val)
{
  if(val == 2){
    $("div#service_type_id").show();
    $(".proVariant").prop('required',false); 
    $("#service_type_input").prop('required',true);
    $("div#attSec").hide();
    $('#service_type_input').prop('selectedIndex',0);


  }
  else{
    $(".proVariant").prop('required',false); // edited after call
    $("#service_type_input").prop('required',false);
    $("div#service_type_id").hide();
    $("div#attSec").show();
 }
}
var vc = 1;
function servTypeChanged(v){
  if(vc != 1){
    if(v == 1){
      $("div#attSec").hide();

      $(".proVariant").prop('required',false);
   

    }
    else{
      $("div#attSec").show();
      $(".proVariant").prop('required',false);  // edited after call

    }
  }
  vc++;
}



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
      $(wrapper).append('<div>  <input type="file" class="form-control" name="product_image[]"  placeholder="Base Product Feature Image" /> <a href="#" class="remove_field btn btn-small btn-danger">Remove</a></div>'); //add input box

  });

  $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
    e.preventDefault(); $(this).parent('div').remove(); x--;
  })
});



 //$(document).ready(function() {

   function findValue(c){

    //$('#attr_group'+c).change(function(){
      // alert(c);
       var attr_group_id = $('#attr_group'+c).val();

       var _token= $('input[name="_token"]').val();

       $.ajax({
         type:"GET",
         url:"{{ url('admin/ajax/get-attribute-value') }}?attribute_group_id="+attr_group_id,

         success:function(res){
           //alert(data);
           if(res){
            $('#attr_value'+c).prop("diabled",false);
            $('#attr_value'+c).empty();
            $('#attr_value'+c).append('<option value="">Value</option>');
            $.each(res,function(attribute_value_id,attribute_value)
            {
              $('#attr_value'+c).append('<option value="'+attribute_value_id+'">'+attribute_value+'</option>');
            });

            }else
            {
              $('#attr_value'+c).empty();

            }
           }

       });
      
    // });


   }


    
    //});


  $(document).ready(function() {
    var pcc = 0;
      //  alert("dd");
       $('#category').change(function(){
         if(pcc != 0)
         { 
        var category_id = $(this).val();
       //alert(business_type_id);
        var _token= $('input[name="_token"]').val();
        //alert(_token);
        $.ajax({
          type:"GET",
          url:"{{ url('admin/ajax/get-sub-category') }}?item_category_id="+category_id,


          success:function(res){
           // alert(data);
            if(res){
            $('#sub_category_id').prop("diabled",false);
            $('#sub_category_id').empty();
            $('#sub_category_id').append('<option value="">Sub Category</option>');
            $.each(res,function(item_sub_category_id,sub_category_name)
            {
              $('#sub_category_id').append('<option value="'+item_sub_category_id+'">'+sub_category_name+'</option>');
            });

            }else
            {
              $('#sub_category_id').empty();

            }
            }

        });
         }else{
           pcc++;
         }
      });

    });


    $(document).ready(function() {
    var pcc = 0;
      //  alert("dd");
       $('#sub_category_id').change(function(){
         if(pcc != 0)
         { 
        var category_id = $(this).val();
        var _token= $('input[name="_token"]').val();
        $.ajax({
          type:"GET",
          url:"{{ url('admin/ajax/get-sub-category-level-two') }}?sub_category_id="+category_id,
          success:function(res){
            if(res){
            $('#iltsc_id').prop("diabled",false);
            $('#iltsc_id').empty();
            $('#iltsc_id').append('<option value="">Sub Category</option>');
            $.each(res,function(iltsc_id,iltsc_name)
            {
              $('#iltsc_id').append('<option value="'+iltsc_id+'">'+iltsc_name+'</option>');
            });

            }else
            {
              $('#iltsc_id').empty();

            }
            }

        });
         }else{
           pcc++;
         }
      });

    });

</script>




@endsection
