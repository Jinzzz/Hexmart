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
