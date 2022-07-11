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
                            <a href=" {{route('admin.create_delivery_boy')}}" class="btn btn-block btn-info">
                            <i class="fa fa-plus"></i> Create Delivery Boy </a>
                            </br>
                            {{ (new \App\Helpers\Helper)->ajaxLoader() }}                                <div class="card-body"> 

                            <div id="example_tbody" class="table-responsive">
                                <table id="example" class="table table-striped table-bordered text-nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th class="wd-15p">SL.No</th>
                                            <th class="wd-15p">{{ __('Name') }}</th>
                                            <th class="wd-15p">{{ __('Mobile') }}</th>
                                            <th class="wd-20p">Online<br>Status</th>
                                            <th class="wd-20p">Account<br>Status</th>
                                            <th class="wd-15p">{{__('Action')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody >
                                        @php
                                        $i = 0;
                                        @endphp
                                        @foreach ($delivery_boys as $row)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $row->delivery_boy_name}}</td>
                                            <td>{{ $row->delivery_boy_phone}}</td>
                                           

                                            
                                            <td>
                                                <a style="color:white;"  class="btn btn-sm  btn-success "> 
                                                    @if($row->is_online == 0)
                                                        Offline
                                                    @else
                                                        Online
                                                    @endif
                                                </a>
                                            </td>

                                            <td>
                                                <a style="color:white;" id="statusBtn{{$row->delivery_boy_id}}" 
                                                    onclick="changeStatus({{$row->delivery_boy_id}})"  
                                                    class="btn btn-sm @if($row->is_active == 0) btn-danger @else btn-success @endif"
                                                > 
                                                    @if($row->is_active == 0)
                                                        Inactive
                                                    @else
                                                        Active
                                                    @endif
                                                </a>
                                            </td>


                                            <td>
                                            <form action="{{route('admin.destroy_delivery_boy',$row->delivery_boy_id)}}" method="POST">
                                                <a class="btn btn-sm btn-cyan" href="{{url('admin/delivery-boy/edit/'.$row->delivery_boy_id)}}">Edit</a>
                                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#viewModal{{$row->delivery_boy_id}}" > View</button>
                                                @csrf
                                                @method('POST')
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
            </div>
        </div>
    </div>
</div>

            @foreach($delivery_boys as $row)
            <div class="modal fade" id="viewModal{{$row->delivery_boy_id}}" tabindex="-1" role="dialog"  aria-hidden="true">
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
                                    <td><h6>Name: </td><td> {{ $row->delivery_boy_name }}</h6></td>
                                 </tr>

                                 <tr>
                                    <td><h6>Phone: </td><td> {{ $row->delivery_boy_phone }}</h6></td>
                                 </tr>
                                
                                <tr>
                                    <td><h6>Email: </td><td> {{ $row->delivery_boy_email }}</h6></td>
                                 </tr>
                                 <tr>
                                    <td><h6>Address: </td><td> {{ $row->delivery_boy_address }}</h6></td>
                                 </tr>
                                
                                 
                                  <tr>
                                    <td>
                                    <h6>Acc. Status: 
                                        </td><td>  
                                        @if($row->is_active == 0)
                                            Inactive
                                        @else
                                            Active
                                        @endif
                                    </h6></td>
                                 </tr>

                                 <tr>
                                    <td>
                                    <h6> Online Status: 
                                        </td><td>  
                                        @if($row->is_online == 0)
                                            Offline
                                        @else
                                            Online
                                        @endif
                                    </h6></td>
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


<script>
function changeStatus(item_row_id)
{
   // $('#loaderCard').show();
  //  $('#example_tbody').hide();
  var stat = 0;
    var _token= $('input[name="_token"]').val();
    $.ajax({
        type:"GET",
        url:"{{ url('admin/ajax/change-status/delivery-boy') }}?delivery_boy_id="+item_row_id ,
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
