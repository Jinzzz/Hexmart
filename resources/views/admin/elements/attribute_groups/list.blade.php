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
                            <a href=" {{route('admin.create_attribute_group')}}" class="btn btn-block btn-info">
                            <i class="fa fa-plus"></i> Create Attribute Group </a>
                            </br>
                            {{ (new \App\Helpers\Helper)->ajaxLoader() }}                                <div class="card-body"> 

                            <div id="example_tbody" class="table-responsive">
                                <table id="example" class="table table-striped table-bordered text-nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th class="wd-15p">SL.No</th>
                                            <th class="wd-15p">{{ __('Attribute Group') }}</th>
                                            <th class="wd-20p">{{__('Status')}}</th>
                                            <th class="wd-15p">{{__('Action')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody >
                                        @php
                                        $i = 0;
                                        @endphp
                                        @foreach ($attribute_groups as $row)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $row->attribute_group}}</td>
                                           
                                            <td>
                                                <a style="color:white;" id="statusBtn{{$row->attribute_group_id}}" 
                                                    onclick="changeStatus({{$row->attribute_group_id}})"  
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
                                            <form action="{{route('admin.destroy_attribute_group',$row->attribute_group_id)}}" method="POST">
                                                <a class="btn btn-sm btn-cyan" href="{{url('admin/attribute-group/edit/'.$row->attribute_group_id)}}">Edit</a>
                                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#viewModal{{$row->attribute_group_id}}" > View</button>
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

            @foreach($attribute_groups as $row)
            <div class="modal fade" id="viewModal{{$row->attribute_group_id}}" tabindex="-1" role="dialog"  aria-hidden="true">
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
                                    <td><h6>Attribute Group: </td><td> {{ $row->attribute_group }}</h6></td>
                                 </tr>
                                

                                  <tr>
                                    <td>
                                    <h6>Status: 
                                        </td>
                                        <td id="statusView{{$row->attribute_group_id}}">  
                                        @if($row->is_active == 0)
                                            Inactive
                                        @else
                                            Active
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
function changeStatus(id)
{
   // $('#loaderCard').show();
  //  $('#example_tbody').hide();
  var stat = 0;
    var _token= $('input[name="_token"]').val();
    $.ajax({
        type:"GET",
        url:"{{ url('admin/ajax/change-status/attribute-group') }}?attribute_group_id="+id,
        success:function(res){
            console.log(res);
            if(res == "active"){
                stat = 0;
                $("#statusBtn"+id).removeClass("btn-danger");
                $("#statusBtn"+id).addClass("btn-success");
                $( "#statusBtn"+id ).empty();
                $( "#statusBtn"+id ).text('Active');
                $( "#statusView"+id ).text('Active');
            }
            else
            {
                stat = 1;
                $("#statusBtn"+id).removeClass("btn-success");
                $("#statusBtn"+id).addClass("btn-danger");
                $( "#statusBtn"+id ).empty();
                $( "#statusBtn"+id ).text('Inactive');
                $( "#statusView"+id ).text('Inactive');
            }
        },
        complete: function(){
            $('#loaderCard').hide();
            $('#example_tbody').show();
            console.log(stat);
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
