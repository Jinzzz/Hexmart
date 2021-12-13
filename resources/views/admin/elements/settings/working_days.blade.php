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

               <form action="{{route('admin.update_working_day')}}" method="POST" enctype="multipart/form-data">
                  @csrf
              <div class="row">
                     <table class="table">
                       <thead>
                         <tr>
                           <th>Working Days</th>
                           <th>Opening Time</th>
                           <th>Closing Time</th>
                         </tr>
                       </thead>
                       <tbody id="table_body">
                      
                       @if ($time_slots_count > 0)
                       @php
                         @$i = 0;
                       @endphp
                           
                          @foreach ($time_slots as $data)
                            <tr id="{{@$i}}">
                              <td>
                                <input readonly type="text"  value="{{ $data->day }}" class="form-control" name="day[]">
                              </td>
                              <td>
                                <span id="ss{{@$i}}"></span>
                                <input type="time" id="s{{@$i}}"   value="{{ $data->time_start }}"  class="form-control"   name="start[]">
                              </td>
                              <td>
                                <span id="se{{@$i}}"></span>
                                <input type="time" id="e{{@$i}}"   value="{{ $data->time_end }}"   class="form-control"  name="end[]">
                              </td>
                              <td>
                                <a id="r" onclick="clearfields({{@$i}})" class="btn btn-warning">Clear</a>
                              </td>
                            </tr>
                            @php
                                $i++;
                            @endphp
                          @endforeach

                        @else

                        @php
                          $days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
                        @endphp
                         @php
                         $i = 0;
                       @endphp
                           

                        @foreach ($days as $data)
                           <tr id="{{@$i}}">
                              <td >
                                <input readonly type="text"  value="{{ $data }}" class="form-control" name="day[]">
                              </td>
                              <td>
                                <span id="ss{{@$i}}"></span>
                                <input type="time" id="s{{@$i}}"   class="form-control"   name="start[]">
                              </td>
                              <td>
                                <span id="se{{@$i}}"></span>
                                <input type="time" id="e{{@$i}}"    class="form-control"  name="end[]">
                              </td>
                                <td>
                                <a id="r" onclick="clearfields({{@$i}})" class="btn btn-warning">Clear</a>
                              </td>
                            </tr>
                              @php
                                $i++;
                            @endphp
                        @endforeach

                        @endif

                           

                         
                       </tbody>
                     </table>

                   
                    <div class="col-md-12">
                      <div class="form-group">
                        <center>
                              <button type="submit" class="btn btn-block btn-raised btn-info">Update</button>
                        </center>
                      </div>
                    </div>

                     

                  </div>
                <br>
             
       </form>
           
      </div>
   </div>
</div>
</div>


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
</script>

<script>
function clearfields(id)
{
 // var id = this.id;
  //$('#'+id).remove();
  $('#s'+id).remove();
  $('#ss'+id).append('<input type="time" id="s'+id+'"   class="form-control"   name="start[]">');
  $('#e'+id).remove();
  $('#se'+id).append('<input type="time" id="e'+id+'"   class="form-control"   name="end[]">');
 // alert(id);
}
</script>




@endsection




