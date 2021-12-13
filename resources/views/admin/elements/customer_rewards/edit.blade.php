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
               <form action="{{ url('admin/configure-points/'.@$configure_points->configure_point_id)}}" method="POST"
                  enctype="multipart/form-data">
                  @csrf
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label class="form-label">Registration Points</label>
                           <input type="number" class="form-control"  name="registraion_points" value="{{old('registraion_points',@$configure_points->registraion_points)}}" placeholder="Registration Points">
                        </div>
                        </div>

                         <div class="col-md-6">
                        <div class="form-group">
                           <label class="form-label">First Order Points</label>
                           <input type="number" class="form-control" name="first_order_points" value="{{old('first_order_points',@$configure_points->first_order_points)}}" placeholder="First Order Points">
                        </div>
                        </div>


                        <div class="col-md-6">
                          <div class="form-group">
                              <label class="form-label">Referal Points</label>
                              <input type="number" required=""  name="referal_points" class="form-control"  value="{{old('referal_points',@$configure_points->referal_points)}}" placeholder="Referal Points ">
                           </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                           <label class="form-label">Refered Joiner Points</label>
                            <input type="number" required=""  name="joiner_points" class="form-control"  value="{{old('joiner_points',$configure_points->joiner_points)}}" placeholder="Joiner Points ">
                           </div>
                        </div>


                        <div class="col-md-6">
                           <div class="form-group">
                              <label class="form-label">Maximum redeem amount per order</label>
                              <input type="number" class="form-control" name="max_redeem_amount" value="{{old('max_redeem_amount',$configure_points->max_redeem_amount)}}" placeholder="Maximum redeem amount per order">
                           </div>
                           </div>

                  <div class="col-md-3">

                         <div class="form-group">
                           <label class="form-label">Rupees </label>
                            <input type="number" required=""  name="rupee" class="form-control"  value="{{old('rupee_points',@$configure_points->rupee)}}" placeholder="Rupee">
                           </div>
                        </div>
                          <div class="col-md-1">
                           <div class="form-group ">
                                                          <label class="form-label">&nbsp;&nbsp;&nbsp; </label>

=
                            </div>
                            </div> 

                        <div class="col-md-2">

                         <div class="form-group">
                           <label class="form-label">Points</label>
                            <input type="number" required=""  name="rupee_points" class="form-control"  value="{{old('rupee_points',@$configure_points->rupee_points)}}" placeholder="Points">
                           </div>
                        </div>


                          <div class="col-md-3">

                         <div class="form-group">
                           <label class="form-label">Order Amount</label>
                            <input type="number" required=""  name="order_amount" class="form-control"  value="{{old('order_amount',@$configure_points->order_amount)}}" placeholder="Order Amount ">
                           </div>
                        </div>

                      <div class="col-md-1">
                           <div class="form-group ">
                                                          <label class="form-label">&nbsp;&nbsp;&nbsp; </label>
=
                            </div>
                            </div> 
                            
                            <div class="col-md-2">

                         <div class="form-group">
                           <label class="form-label">Points</label>
                            <input type="number" required=""  name="order_points" class="form-control"  value="{{old('points',@$configure_points->order_points)}}" placeholder="Order points ">
                           </div>
                        </div>
                        
                        <div class="col-md-6">
                        <div class="form-group">
                           <label class="form-label">Percentage of wallet points can be redeemed per order</label>
                           <input type="number" class="form-control" name="redeem_percentage" value="{{old('redeem_percentage',@$configure_points->redeem_percentage)}}" placeholder="Percentage of wallet points can be redeemed per order">
                        </div>
                        </div>


                    </div>

                    <div class="form-group">
                           <center>
                           <button type="submit" id="submit" class="btn btn-raised btn-primary">
                           <i class="fa fa-check-square-o"></i> Update</button>
                           {{-- <button type="reset" class="btn btn-raised btn-success">
                           Reset</button> --}}
                           {{-- <a class="btn btn-danger" href="{{ route('admin.list_configure_points') }}">Cancel</a> --}}
                           </center>
                        </div>
               </form>

      </div>
      </div>
   </div>
</div>
@endsection


