@extends('admin.layouts.app')
@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12 col-lg-12">
      <div class="card">
        <div class="row">
          <div class="col-12">


            @if ($message = Session::get('status'))
            <div class="alert alert-success">
              <p>{{ $message }}<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></p>
            </div>
            @endif
            <div class="col-lg-12">
              @if ($errors->any())
              <div class="alert alert-danger">
                <strong>Whoops!</strong> 
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
                <a href=" {{route('admin.assign_customer_to_cg')}}" class="btn btn-block btn-info">
                    <i class="fa fa-plus"></i> Assign Customer to Customer Group
                </a>   <br> 
                <div class="table-responsive">
                  <table id="example" class="table table-striped table-bordered text-nowrap w-100">
                    <thead>
                      <tr>
                        <th class="wd-15p">S.No</th>
                        <th class="wd-15p">Customer Name</th>
                        <th class="wd-15p">Group Name</th>
                      
                       <th class="wd-15p">{{__('Action')}}</th>

                      </tr>
                    </thead>
                    <tbody>
                      @php
                      $i = 0;
                      @endphp
                      @foreach ($customers as $row)
                      <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{$row->customerData->customer_name}} </td>
                        <td>{{$row->customerGroupData->customer_group_name}} </td>


                        <td>
                            <form action="{{route('admin.destroy_cgc')}}" method="POST">
                                @csrf
                                @method('POST')
                                <input type="hidden" name="cgc_id" value="{{ $row->cgc_id }}">
                                <button type="submit" onclick="return confirm('Do you want to delete this item?');"  class="btn btn-sm btn-danger">Remove</button>
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
    </div>
  </div>
  </div>



 

  @endsection
