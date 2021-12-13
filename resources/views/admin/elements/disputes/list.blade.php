@extends('admin.layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="row">
                <div class="col-12" >

                    @if ($message = Session::get('status'))
                    <div class="alert alert-success">
                        <p>{{ $message }}<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></p>
                    </div>
                    @endif
                    <div class="col-lg-12">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <h6>Whoops!</h6> There were some problems with your input.<br><br>
                            <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                            </ul>
                        </div>
                        @endif
                        <div class="card-header">
                            <h3 class="mb-0 card-title">{{$pageTitle}}</h3>
                        </div>
                       
                    
                        <div class="card-body">
                            <div id="example_tbody" class="table-responsive">
                                <table id="example" class="table table-striped table-bordered text-nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th class="wd-15p">SL.No</th>
                                            <th class="wd-15p">{{ __('Order Number') }}</th>
                                            <th class="wd-15p">{{__('Issue')}}</th>
                                            <th class="wd-20p">Customer<br>Name</th>
                                            <th class="wd-20p">Customer<br>Phone</th>
                                            <th class="wd-20p">Dispute<br>Status</th>
                                            <th class="wd-15p">{{__('Action')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody >
                                        @php
                                        $i = 0;
                                        @endphp
                                        @foreach ($disputes as $row)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ @$row->orderData->order_number}}</td>
                                            <td>{{ @$row->issueData->issue}}</td>
                                            <td>{{ @$row->customerData->customer_name}}</td>
                                            <td>{{ @$row->customerData->customer_mobile}}</td>
                                            <td>
                                                <button type="button" 
                                                 data-toggle="modal"  onclick="statusFun({{ $row->dispute_id }})"
                                                 id="disputeStatusBtn{{ $row->dispute_id }}"
                                                 data-target="#statusModal"  
                                                 class="btn btn-sm btn-azure ">
                                                 
                                                    @if(isset($row->dispute_status_id))
                                                        {{ @$row->disputeStatusData->dispute_status }}
                                                    @else
                                                        --
                                                    @endif
                                                </button>
                                            </td>
                                            <td>
                                                <button type="button"  
                                                data-toggle="modal"  
                                                data-target="#viewModal"  
                                                onclick="viewFun({{ $row->dispute_id }})" 
                                                class="btn btn-sm btn-gray">
                                                 View
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="statusModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
          
        <div class="modal-header">
             <h5 class="modal-title" id="example-Modal3">Dispute Status</h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
             </button>
          </div>

      {{-- <form action="{{ route('admin.update_order_status',$order->dispute_id) }} " method="POST" enctype="multipart/form-data" >
      @csrf --}}
        {{-- <div class="dimmer active" id="loaderCard" >
            <div class="spinner1">
                <div class="double-bounce1"></div>
                <div class="double-bounce2"></div>
            </div>
        </div> --}}

        <div class="dimmer active" id="loaderCard" >
                    
             {{-- <div class="spinner1">
                <div class="double-bounce1"></div>
                <div class="double-bounce2"></div>
            </div> --}}

            <div class="lds-ring">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>

        <div class="modal-body"  id="modalBody">
            <label class="form-label"> Status</label>
            <select class="form-control" name="dispute_status_id" id="disputeStatusId">
                <option value=""> Status</option>
                @foreach ($disputeStatus as $key)
                <option value="{{$key->dispute_status_id}}"> {{ $key->dispute_status}}</option>
                @endforeach
            </select>
            <input type="hidden" name="dispute_id" id="id" />
            <div class="modal-footer">
                <button type="submit" id="updatedisputeStatusBtn" class="btn btn-raised btn-primary">
                <i class="fa fa-check-square-o"></i> Update</button>
                <button type="button" id="closeModal" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
       </div>

       
    

          
           {{-- </form> --}}
       </div>
    </div>
 </div>
</div>
</div>

    

<div class="modal fade" id="viewModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
       <div class="modal-content">
          
            <div class="modal-header">
                <h5 class="modal-title" id="example-Modal3">Dispute Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <div style="display: none;" class="dimmer active" id="loaderCard2" >
                <div class="lds-ring">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>

            <div class="modal-body" id="viewModalBody" >
                <div class="table-responsive ">
                    <table class="table row table-borderless ">
                        <tbody class="col-lg-12 col-xl-6 p-0">
                            
                            <tr>
                                <td >Order number:</td>
                                <td id="disputeOrderNumber"></td>
                            </tr>
                            <tr>
                                <td>Order total: </td>
                                <td id="disputeOrderTotal"></td>
                            </tr>
                            
                            <tr>
                                <td>Issue Type: </td>
                                <td id="disputeIssueType"></td>
                            </tr>
                            
                            <tr>
                            <td>Issue: </td>
                            <td id="disputeIssue"></td>
                            </tr>
                        
                        
                        </tbody>

                    
                        <tbody class="col-lg-12 col-xl-6 p-0">

                        
                        <tr>
                            <td>Dispute Status: </td>
                            <td id="disputeStatus"></td>
                            </tr>

                            <tr>
                            <td>Customer name: </td>
                            <td id="disputeCustomerName"></td>
                            </tr>


                            <tr>
                            <td>Customer phone: </td>
                            <td id="disputeCustomerPhone"></td>
                            </tr>


                            <tr>
                                <td>Discription: </td>
                                <td id="disputeDiscription"></td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>
          
       </div>
    </div>
 </div>


 
<script>

$(document).ready(function() {
  $("#updatedisputeStatusBtn").click(function () {
    let id = $('#id').val();
    let disputeStatusId = $('#disputeStatusId').val();
    var _token= $('input[name="_token"]').val();
    $("#closeModal").click();

    $.ajax({
        type:"GET",
        url:"{{ url('admin/ajax/update-status/dispute') }}?dispute_id="+id+'&dispute_status_id='+disputeStatusId,
        success:function(res){
            const myObj2 = JSON.parse(res);
            console.log(myObj2);
            $('#disputeStatusBtn'+id).text(myObj2.dispute_status);
        },
        complete: function(){
            $("#closeModal").click();
            return $.growl.notice({
                title: "",
                message: "Order status updated"
            });

        },
        fail: function(){
          console.log('Woops! errOr');
          $('#modalBody').show();  
        },
    });

  });
});

function statusFun(id)
{
    var _token= $('input[name="_token"]').val();
    $('#modalBody').hide();
    $('#loaderCard').show();
    $.ajax({
        type:"GET",
        url:"{{ url('admin/ajax/find-status/dispute') }}?dispute_id="+id ,
        success:function(res){
            const myObj = JSON.parse(res);
            $('#disputeStatusId option[value="'+myObj.dispute_status_id+'"]').attr("selected", true);
            $('#id').val(myObj.dispute_id);
            $('#disputeStatusBtn'+id).text(myObj.dispute_status);
        },
        complete: function(){
            $('#loaderCard').hide();
            $('#modalBody').show();  
        },
        fail: function(){
          console.log('Woops! errOr');
          $('#modalBody').show();  
        },
    });
}


function viewFun(id)
{
    var _token= $('input[name="_token"]').val();
    $('#viewModalBody').hide();
    $('#loaderCard2').show();
    $.ajax({
        type:"GET",
        url:"{{ url('admin/ajax/view-dispute') }}?dispute_id="+id ,
        success:function(res){
            const myObj = JSON.parse(res);
          console.log(myObj);
            $('#disputeStatus').text(myObj.dispute_status);
            $('#disputeIssueType').text(myObj.issue_type);
            $('#disputeIssue').text(myObj.issue);
            $('#disputeCustomerName').text(myObj.customer_name);
            $('#disputeCustomerPhone').text(myObj.customer_mobile);
            $('#disputeOrderNumber').text(myObj.order_number);
            $('#disputeOrderTotal').text(myObj.order_total_amount);
            $('#disputeDiscription').text(myObj.dispute_discription);
        },
        complete: function(){
            $('#loaderCard2').hide();
            $('#viewModalBody').show();  
        },
        fail: function(){
          console.log('Woops! errOr');
          $('#loaderCard2').hide();
          $('#viewModalBody').show();  
        },
    });
}

function changeStatus(item_row_id)
{
   // $('#loaderCard').show();
  //  $('#example_tbody').hide();
  var stat = 0;
    var _token= $('input[name="_token"]').val();
    $.ajax({
        type:"GET",
        url:"{{ url('admin/ajax/change-status/brand') }}?brand_id="+item_row_id ,
        success:function(res){
            if(res == "active"){
                stat = 0;
                $("#statusBtn"+item_row_id).removeClass("btn-danger");
                $("#statusBtn"+item_row_id).addClass("btn-success");
                $( "#statusBtn"+item_row_id ).empty();
                $( "#statusBtn"+item_row_id ).text('Active');
            }
            else
            {
                stat = 1;
                $("#statusBtn"+item_row_id).removeClass("btn-success");
                $("#statusBtn"+item_row_id).addClass("btn-danger");
                $( "#statusBtn"+item_row_id ).empty();
                $( "#statusBtn"+item_row_id ).text('Inactive');
            }
        },
        complete: function(){
            $('#loaderCard').hide();
            $('#example_tbody').show();
            if(stat == 0)
            {
                return $.growl.notice({
                message: "Status updated"
                });
            }
            else
            {
                return $.growl.warning({
                title: "Notice!",
                message: "Status updated"
                });
            }
        },
        fail: function(){

            return $.growl.error({
                title: "Oops!",
                message: "Something wen't wrong"
            }); 

            $('#loaderCard').hide();
            $('#example_tbody').show();
            $('#example_tbody').html('<tr>No data found.</tr>');
        },
    });
}
</script>
@endsection
