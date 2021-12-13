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
                        <div class="card-body">
                                <a href="{{ route('admin.add_tax') }}"  class="btn btn-block btn-info">
                                    <i class="fa fa-plus"></i> Add Tax 
                                </a>
                            
                                <br>
                            <div class="table-responsive">
                            <table id="example" class="table table-striped table-bdataed text-nowrap w-100">
                                <thead>
                                    <tr>
                                        <th class="wd-15p">SL.No</th>
                                        <th class="wd-15p">{{__('Tax Name')}}</th>
                                        <th class="wd-15p">{{__('Tax Value')}}</th>
                                        <th class="wd-20p">{{__('Status')}}</th>

                                        <th class="wd-15p">{{__('Action')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $i = 0;
                                    @endphp
                                    @foreach ($taxes as $tax)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $tax->tax_name}}</td>
                                        <td>{{ $tax->tax_value}}</td>

                                        <td>
                                            <a style="color:white;" id="statusBtn{{$tax->tax_id}}" 
                                                onclick="changeStatus({{$tax->tax_id}})"  
                                                class="btn btn-sm @if($tax->is_active == 0) btn-danger @else btn-success @endif"
                                            > 
                                                @if($tax->is_active == 0)
                                                    Inactive
                                                @else
                                                    Active
                                                @endif
                                            </a>
                                        </td>

                                        <td>
                                            <form action="{{route('admin.destroy_tax',$tax->tax_id)}}" method="POST">
                                                @csrf
                                                    <a class="btn btn-sm btn-cyan text-white"  data-toggle="modal" data-target="#StockModal{{$tax->tax_id}}" >View</a>
                                                        <a href="{{ url('admin/tax/edit/'.$tax->tax_id )}} " class="btn btn-sm btn-cyan" >Edit</a>
                                                        @method('POST')
                                                <button type="submit" onclick="return confirm('Do you want to delete this item?');"  class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>

                            </table>

                            {{-- table responsive end --}}
                            </div>
                        {{-- Card body end --}}
                        </div>
                    {{-- col 12 end --}}
                    </div>
                {{-- row end --}}
                </div>
            {{-- card --}}
            </div>
        {{-- row justify end --}}
        </div>
    {{-- container end --}}
    </div>




@foreach ($taxes as $tax)

    <div class="modal fade" id="StockModal{{$tax->tax_id}}" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="example-Modal3">Tax Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>

                <form action=" {{ route('admin.update_tax',$tax->tax_id) }}" method="POST" enctype="multipart/form-data" >
                @csrf
                <div class="modal-body">
                <table class="table ">
                    <tbody>
                        <tr>
                            <td>Tax Name: {{ @$tax->tax_name}}</td>
                            
                        </tr>
                        <tr>
                            <td>Tax Value: {{ @$tax->tax_value}}</td>
                        
                        </tr>
                        <tr>
                            <td> Status : 
                                @if (@$tax->is_active == 1)
                                    Active
                                @else
                                    Inactive
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            <h4 class="ml-4">Tax Split Ups</h4>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tax name</th>
                                <th>Tax value</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tax_splits as $tax_split)
                            @if($tax_split->tax_id == $tax->tax_id)
                            <tr>
                                <td>{{ $tax_split->tax_split_name }}</td> <td>{{ $tax_split->tax_split_value }}</td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
            </div>
        </div>
    </div>
@endforeach

</div>

<script>
function clearTax()
{
      $('#tax_value').val('');
      $('#tax_name').val('');

}
</script>



<script>
    function changeStatus(item_row_id)
    {
       // $('#loaderCard').show();
      //  $('#example_tbody').hide();
      var stat = 0;
        var _token= $('input[name="_token"]').val();
        $.ajax({
            type:"GET",
            url:"{{ url('admin/ajax/change-status/tax') }}?tax_id="+item_row_id ,
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
