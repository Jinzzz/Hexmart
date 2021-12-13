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
                        <h5>Whoops!</h5> There were some problems with your input.<br><br>
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
                        <form action="{{route('admin.list_coupon')}}" method="GET"  enctype="multipart/form-data">
                           @csrf
  
                           <div class="row">
                              <div class="col-md-12">
                                 <div class="form-group">
                                     <label class="form-label" >Status * </label>
                                     <select name="status" required id="status" class="form-control"  >
                                       <option value=""  >-Select-</option>
                                       <option {{old('status',request()->input('status')) == "0" ? 'selected':''}} value="0">Active</option>
                                      <option {{old('status',request()->input('status')) == "1" ? 'selected':''}} value="1">InActive</option>
                                       </select>
                                 </div>
                              </div>
                           </div>
                           
                           <div class="col-md-12">
                              <div class="form-group">
                                 <center>
                                 <button type="submit" class="btn btn-raised btn-primary">
                                 <i class="fa fa-check-square-o"></i> Filter</button>
                                 <button type="reset" class="btn btn-raised btn-success">Reset</button>
                                 <a href="{{route('admin.list_coupon')}}"  class="btn btn-info">Cancel</a>
                                 </center>
                              </div>
                           </div>
                     </form>
                  </div>

                    <div class="card-body">
                        <a href="  {{route('admin.create_coupon')}} " class="btn btn-block btn-info">
                           <i class="fa fa-plus"></i>
                           Create Coupon
                        </a>
                        </br>
                        <div class="table-responsive">
                           <table id="example" class="table table-striped table-bordered text-nowrap w-100">
                              <thead>
                                 <tr>
                                    <th class="wd-15p">SL.No</th>
                                    <th class="wd-15p">Coupon<br>Code</th>
                                    <th class="wd-15p">Coupon<br>Type</th>
                                    <th class="wd-15p">Minimum<br>Purchase Amount</th>
                                    <th class="wd-15p">Discount<br>Type</th>
                                    <th class="wd-15p">Discount</th>
                                    <th class="wd-15p">Valid<br>From</th>
                                    <th class="wd-15p">Valid<br>To</th>
                                    <th class="wd-15p">Status</th>
                                    <th class="wd-15p">{{__('Action')}}</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 @php
                                 $i = 0;
                                 @endphp
                                 @foreach ($coupons as $value)
                                 <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $value->coupon_code}}</td>
                                    <td>
                                        @if (@$value->coupon_type == 1)
                                            Single use
                                        @elseif (@$value->coupon_type == 2)
                                            Multi use
                                        @else
                                            --
                                        @endif
                                    </td>
                                    <td> 
                                    {{ @$value->min_purchase_amt  }}
                                    </td>
                                    <td>
                                        @if (@$value->discount_type == 1)
                                            Fixed
                                        @elseif (@$value->discount_type == 2)
                                            Percentage
                                        @else
                                            --
                                        @endif
                                    </td>
                                    <td>
                                     @if (@$value->discount_type == 1)
                                     Rs. 
                                     @endif
                                     {{ $value->discount  }}
                                    
                                     @if (@$value->discount_type == 2)
                                     %
                                     @endif
                                    
                                    
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($value->valid_from)->format('d-m-Y')}}</td>
                                    <td>{{ \Carbon\Carbon::parse($value->valid_to)->format('d-m-Y')}}</td>

                                    <td>
                                        @if (@$value->coupon_status == 1)
                                        Active
                                        @else
                                        InActive
                                            
                                            @endif
                                    </td>

                                    <td>
                                       <form action="{{route('admin.destroy_coupon',$value->coupon_id)}}" method="POST">
                                         @csrf
                                          @method('POST')
                                          <a class="btn btn-sm btn-cyan"  href="{{url('admin/coupon/edit/'.Crypt::encryptString($value->coupon_id))}}">Edit</a>
                                          {{-- <a style="color:white;" class="btn btn-sm btn-cyan" data-toggle="modal" data-target="#viewModal{{$value->coupon_id}}">View</a> --}}
                                          <button type="submit" onclick="return confirm('Do you want to delete this item?');"  class="btn btn-sm btn-danger">Delete</button>
                                       </form>
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

  {{-- @foreach($store_admin as $user)
            <div class="modal fade" id="viewModal{{$user->store_admin_id}}" tabindex="-1" role="dialog"  aria-hidden="true">
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
                                    <td><h5 class=""><b>Name</b> : {{$user->admin_name}}</h5> </td>
                                 </tr>
                                 <tr>
                                    <td><h5><b>Username</b> : {{ $user->username }}  </h5></td>
                                 </tr>
                                  <tr>
                                    <td><h5><b>Phone</b> : {{ $user->phone }}  </h5></td>
                                 </tr>
                                  <tr>
                                    <td><h5><b>Email</b> : {{ $user->email }}  </h5></td>
                                 </tr>
                                 <tr>
                                    <td><h5><b>Role</b> :   
                                    @if($user->role_id == '2')
                                          Admin
                                          @elseif($user->role_id == '3')
                                          Manager
                                           @elseif($user->role_id == '4')
                                           Staff
                                           @else
                                           --
                                          @endif
                                    </h5></td>
                                 </tr>
                                  <tr>
                                    <td><h5><b>Status</b> :   
                                    @if($user->status == 0)
                                          InActive
                                          @else
                                          Active
                                          @endif
                                    </h5></td>
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
            @endforeach --}}
            <!-- MESSAGE MODAL CLOSED -->
            @endsection
