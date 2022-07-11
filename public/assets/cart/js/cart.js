$(document).ready(function()
{
loadcartcount();
function  loadcartcount()
{
    $.ajax({
         method:"GET",
         url:base_url+"/Dcart_count",
         headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         dataType:"json",
         success:function(response)
         {
             $('.Cart-count').html('');
             $('.Cart-count').html(response.count);

         }
 });
}


$('.addToButton').click(function(e){
 e.preventDefault();
 var product_id=document.getElementById('productvariantid').value;
 $.ajax({
         method:"POST",
         url:base_url+"/add_to_cart",
         headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         data:{
         	'product_id':product_id
         },
         dataType:"json",
         success:function(response)
         {
         	 swal( response.status);
             loadcartcount();

         }
 });
});



$('.wishcheckbox').on('click', function() {
        if(this.checked){
        var product_id=document.getElementById('productvariantid').value;
        $.ajax({
         method:"POST",
         url:base_url+"/add_to_wishlist",
         headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         data:{
                'product_id':product_id
         },
         dataType:"json",
         success:function(response)
         {
                  swal( response.status);

         }
        });
        }
        else{ 

        var product_id=document.getElementById('productvariantid').value;

        $.ajax({
         method:"POST",
         url:base_url+"/remove_whishlist",
         headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         data:{
                'product_id':product_id
         },
         dataType:"json",
         success:function(response)
         {
                  swal( response.status);

         }
        });
       }
});


$('.Buynow').click(function(e){
 e.preventDefault();
 var product_id=document.getElementById('productvariantid').value;
 $.ajax({
         method:"POST",
         url:base_url+"/Buynowproduct",
         headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         data:{
              'product_id':product_id
         },
         dataType:"json",
         success:function(response)
         {
              if(response.status=="Login to Continue")
              {
                var base_url = window.location.origin;
                window.location.href = base_url+"/customer/customer-login";

              }
              else if(response.status=="Success")
              {
               window.location.href = "/Checkout"+"/"+product_id;
              }

         }
 });
});
});