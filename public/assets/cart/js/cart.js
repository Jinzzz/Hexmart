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
                window.location.href = "/customer/customer-login";

              }
              else if(response.status=="Success")
              {
               window.location.href = "/Buynowproduct-view";
              }

         }
 });
});