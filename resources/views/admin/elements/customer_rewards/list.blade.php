@extends('admin.layouts.app')
@section('content')
@php
$date = Carbon\Carbon::now();
@endphp
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



        <div class="card-body border">
                <form action="" method="GET"
                         enctype="multipart/form-data">
                   @csrf
            <div class="row">

              <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-label">Customer Name</label>
                       <input type="text" class="form-control" name="customer_name" id="customer_name"  value="{{request()->input('customer_name')}}"  placeholder="Customer Name">
                  </div>
               </div>

                {{-- @php
                   if(!@$datefrom)
                   {
                        $datefrom = $date->toDateString();
                   }

                    if(!@$dateto)
                   {
                        $dateto = $date->toDateString();
                   }
               @endphp --}}

               <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-label">From Date</label>
                    <div id="date_froml"></div>
                     <input type="date" class="form-control" name="date_from" id="date_from"  value="{{ request()->input('date_from') }}" placeholder="From Date">

                  </div>
                 </div>



         <div class="col-md-4">
                 <div class="form-group">
                    <label class="form-label">To Date</label>
                    <div id="date_tol"></div>
                     <input type="date" class="form-control"  name="date_to"  id="date_to" value="{{ request()->input('date_to') }}" placeholder="To Date">

                  </div>
                 </div>



                     <div class="col-md-12">
                     <div class="form-group">
                           <center>
                           <button type="submit" class="btn btn-raised btn-primary">
                           <i class="fa fa-check-square-o"></i> Filter</button>
                           <button type="reset" id="reset" class="btn btn-raised btn-success">Reset</button>
                          <a href="{{route('admin.configure_points')}}"  class="btn btn-info">Cancel</a>
                           </center>
                        </div>
                  </div>
            </div>
                   </form>
                </div>

                    <div class="card-body">
      @if($_GET)

                        <div class="table-responsive">
                           <table id="exampletable" class="table table-striped table-bordered text-nowrap w-100">
                              <thead>
                                 <tr>
                                    <th class="wd-15p">SL.No</th>
                                    <th class="wd-15p">{{ __('Points Earned') }}</th>
                                    <th class="wd-15p">{{ __('Customer') }}</th>
                                    <th class="wd-15p">{{ __('Customer Mobile') }}</th>
                                    <th class="wd-15p">{{__('Discription')}}</th>
                                    <th class="wd-15p">{{__('Status')}}</th>
                                    <th class="wd-15p">{{__('Action')}}</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 @php
                                 $i = 0;
                                 @endphp
                                 @foreach ($customer_rewards as $customer_reward)
                                 <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $customer_reward->reward_points_earned}}</td>
                                    <td>{{@$customer_reward->customerData->customer_name}} </td>
                                    <td>{{@$customer_reward->customerData->customer_mobile}} </td>

                                    <td>{{@$customer_reward->orderData->order_number}} </td>

                                    <td><button type="button" class="btn btn-sm
                                          @if($customer_reward->is_active == 0) btn-danger @else btn-success @endif"> @if($customer_reward->is_active == 0)
                                          Inactive
                                          @else
                                          Active
                                          @endif</button> </td>

                                    <td>
                                     <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#viewModal{{$customer_reward->customer_reward_id}}" > View</button>


                                    </td>
                                 </tr>
                                 @endforeach
                              </tbody>
                           </table>
                        </div>
             @endif
                     </div>
                  </div>
               </div>
            </div>
 @foreach($customer_rewards as $customer_reward)
            <div class="modal fade" id="viewModal{{$customer_reward->customer_reward_id}}" tabindex="-1" role="dialog"  aria-hidden="true">
               <div class="modal-dialog" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title" id="example-Modal3">{{$pageTitle}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                     <div class="modal-body">

                        <div class="table-responsive ">
                           <table class="table row table-borderless">
                              <tbody class="col-lg-12 col-xl-12 p-0">
                                 <tr>
                                    <input type="hidden" class="form-control" name="customer_reward_id" value="{{$customer_reward->customer_reward_id}}" >
                                    <td><h6 class="">Reward Points Earned : {{ $customer_reward->reward_points_earned}}</h6> </td>
                                 </tr>
                                

                              </tbody>
                           </table>
                        </div>

                     </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                     </div>
                  </div>
               </div>
            </div>
            @endforeach
            <!-- MESSAGE MODAL CLOSED -->



                                    <script>

$(function(e) {
	 $('#exampletable').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'pdf',
                title: 'Customer Rewards',
                footer: true,
                exportOptions: {
                     columns: [0,1,2,3,4,5,6]
                 }
            },
            {
                extend: 'excel',
                title: 'Customer Rewards',
                footer: true,
                exportOptions: {
                     columns: [0,1,2,3,4,5,6]
                 }
            }
         ]
    } );

} );


$(document).ready(function() {
 $('#reset').click(function(){
     $('#customer_name').val('');

  $('#date_from').remove();
    $('#date_to').remove();
    $('#date_froml').append('<input type="date" class="form-control" name="date_from" id="date_from"  placeholder="From Date">');
    $('#date_tol').append('<input type="date" class="form-control" name="date_to"   id="date_to" placeholder="To Date">');



   });
});
            </script>


            @endsection

