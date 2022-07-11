@extends('admin.layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-12">
            <div class="card">
               

                <div class="row" id="user-profile">
                    <div class="col-lg-12">

                        @if ($message = Session::get('status'))
                        <div class="alert alert-success">
                            <p>{{ $message }}<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></p>
                        </div>
                        @endif

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

                        <div class="card">
                            <div class="card-body">
                                <div class="wideget-user">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12">
                                            <div class="wideget-user-desc d-sm-flex">
                                                <div class="wideget-user-img">
                                                    <img class="" src="../assets/images/users/admin.png" alt="img" width="90">
                                                </div>
                                                <div class="user-wrap">
                                                    <h4>{{ @$admin->name }}</h4>
                                                    <h6 class="text-muted mb-3">{{ @$admin->email }}</h6>
                                                    {{-- <a href="#" class="btn btn-primary mt-1 mb-1"><i class="fa fa-rss"></i> Follow</a> --}}
                                                    {{-- <a href="#" class="btn btn-secondary mt-1 mb-1"><i class="fa fa-envelope"></i> E-mail</a> --}}
                                                    {{-- <a href="{{ route('admin.edit_profile') }}" class="btn btn-secondary mt-1 mb-1"><i class="fa fa-pen"></i>Edit</a> --}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12">
                                            <div class="wideget-user-info">
                                                {{-- <div class="wideget-user-warap">
                                                    <div class="wideget-user-warap-l">
                                                        <h4 class="text-danger">7253</h4>
                                                        <p>Total Items</p>
                                                    </div>
                                                    <div class="wideget-user-warap-r">
                                                        <h4 class="text-danger">8432</h4>
                                                        <p>Total Sales</p>
                                                    </div>
                                                </div>
                                                <div class="wideget-user-rating">
                                                    <a href="#"><i class="fa fa-star text-warning"></i></a>
                                                    <a href="#"><i class="fa fa-star text-warning"></i></a>
                                                    <a href="#"><i class="fa fa-star text-warning"></i></a>
                                                    <a href="#"><i class="fa fa-star text-warning"></i></a>
                                                    <a href="#"><i class="fa fa-star-o text-warning mr-1"></i></a> <span>5 (3876 Reviews)</span>
                                                </div>
                                                <div class="wideget-user-icons">
                                                    <a href="#" class="bg-facebook text-white mt-0"><i class="fa fa-facebook"></i></a>
                                                    <a href="#" class="bg-info text-white"><i class="fa fa-twitter"></i></a>
                                                    <a href="#" class="bg-google text-white"><i class="fa fa-google"></i></a>
                                                    <a href="#" class="bg-dribbble text-white"><i class="fa fa-dribbble"></i></a>
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="border-top">
                                <div class="wideget-user-tab">
                                    <div class="tab-menu-heading">
                                        <div class="tabs-menu1">
                                            <ul class="nav">
                                                <li class=""><a href="#tab-51" class="active show" data-toggle="tab">Profile</a></li>
                                                <li><a href="#tab-61" data-toggle="tab" class="">Edit Profile</a></li>
                                                {{-- <li><a href="#tab-71" data-toggle="tab" class="">Gallery</a></li> --}}
                                                {{-- <li><a href="#tab-81" data-toggle="tab" class="">Followers</a></li> --}}
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="border-0">
                                    <div class="tab-content">
                                        <div class="tab-pane active show" id="tab-51">
                                            <div id="profile-log-switch">
                                                <div class="media-heading">
                                                    <h5><strong>Profile Information</strong></h5>
                                                </div>
                                                <div class="table-responsive ">
                                                    <table class="table row table-borderless">
                                                        <tbody class="col-lg-12 col-xl-6 p-0">
                                                            <tr>
                                                                <td><strong>Name :</strong> {{ @$admin->name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Email :</strong> {{ @$admin->email }}</td>
                                                            </tr>
                                                           
                                                        </tbody>
                                                        <tbody class="col-lg-12 col-xl-6 p-0">
                                                            <tr>
                                                                <td><strong>Website :</strong> hexmart.com</td>
                                                            </tr>
                                                            
                                                            <tr>
                                                                <td><strong>Phone :</strong> +00 000 000 00 </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                {{-- <div class="row profie-img">
                                                    <div class="col-md-12">
                                                        <div class="media-heading">
                                                            <h5><strong>Biography</strong></h5>
                                                        </div>
                                                        <p>
                                                            Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus</p>
                                                        <p class="mb-0">because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter but because those who do not know how to pursue consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure.</p>
                                                    </div>
                                                </div> --}}
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab-61">
                                                <div class="media-heading">
                                                    <h5><strong>Edit Profile</strong></h5>
                                                </div>

                                            <form action="{{route('admin.update_profile',$admin->id)}}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                        <label class="form-label">Name</label>
                                                        <input type="text" required class="form-control" name="name" value="{{old('name',$admin->name)}}" placeholder="Name">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                        <label class="form-label">Email</label>
                                                        <input type="email" required class="form-control" name="email" value="{{old('email',$admin->email)}}" placeholder="Email">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                        <label class="form-label">Password </label>
                                                        <input type="password" class="form-control" name="password" value="{{old('password')}}" placeholder="Password" >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                        <label class="form-label">Confirm Password </label>
                                                        <input type="password" class="form-control" name="password_confirmation" value="{{old('password_confirmation')}}" placeholder="Confirm Password" >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 align-center">
                                                        <button class="btn btn-primary" type="submit" >Update</button>
                                                    </div>

                                                </div>
                                            </form>
                                        </div>


                                        <div class="tab-pane" id="tab-71">
                                            <div class="row">
                                                <div class="col-lg-3 col-md-6">
                                                    <img class="img-fluid rounded mb-5" src="../assets/images/media/8.jpg " alt="banner image">
                                                </div>
                                                <div class="col-lg-3 col-md-6">
                                                    <img class="img-fluid rounded mb-5" src="../assets/images/media/10.jpg" alt="banner image ">
                                                </div>
                                                <div class="col-lg-3 col-md-6">
                                                    <img class="img-fluid rounded mb-5" src="../assets/images/media/11.jpg" alt="banner image ">
                                                </div>
                                                <div class="col-lg-3 col-md-6">
                                                    <img class="img-fluid rounded mb-5 " src="../assets/images/media/12.jpg" alt="banner image ">
                                                </div>
                                                <div class="col-lg-3 col-md-6">
                                                    <img class="img-fluid rounded mb-5" src="../assets/images/media/13.jpg " alt="banner image">
                                                </div>
                                                <div class="col-lg-3 col-md-6">
                                                    <img class="img-fluid rounded mb-5" src="../assets/images/media/14.jpg " alt="banner image">
                                                </div>
                                                <div class="col-lg-3 col-md-6">
                                                    <img class="img-fluid rounded mb-5" src="../assets/images/media/15.jpg " alt="banner image">
                                                </div>
                                                <div class="col-lg-3 col-md-6">
                                                    <img class="img-fluid rounded mb-0" src="../assets/images/media/16.jpg " alt="banner image">
                                                </div>
                                                <div class="col-lg-3 col-md-6">
                                                    <img class="img-fluid rounded mb-0" src="../assets/images/media/17.jpg " alt="banner image">
                                                </div><div class="col-lg-3 col-md-6">
                                                    <img class="img-fluid rounded mb-0" src="../assets/images/media/18.jpg " alt="banner image">
                                                </div>
                                                <div class="col-lg-3 col-md-6">
                                                    <img class="img-fluid rounded mb-0" src="../assets/images/media/19.jpg " alt="banner image">
                                                </div>
                                                <div class="col-lg-3 col-md-6">
                                                    <img class="img-fluid rounded" src="../assets/images/media/20.jpg " alt="banner image">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="tab-pane" id="tab-81">
                                            <div class="row">
                                                <div class=" col-lg-6 col-md-12">
                                                    <div class="card borderover-flow-hidden">
                                                        <div class="media card-body media-xs overflow-visible ">
                                                            <img class="avatar brround avatar-md mr-3" src="../assets/images/users/18.jpg" alt="avatar-img">
                                                            <div class="media-body valign-middle mt-2">
                                                                <a href="" class=" font-weight-semibold text-dark">John Paige</a>
                                                                <p class="text-muted ">johan@gmail.com</p>
                                                            </div>
                                                            <div class="media-body valign-middle text-right overflow-visible mt-2">
                                                                <button class="btn btn-primary" type="button">Follow</button> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class=" col-lg-6 col-md-12">
                                                    <div class="card borderover-flow-hidden">
                                                        <div class="media card-body media-xs overflow-visible ">
                                                            <span class="avatar cover-image avatar-md brround bg-pink mr-3">LQ</span>
                                                            <div class="media-body valign-middle mt-2">
                                                                <a href="" class="font-weight-semibold text-dark">Lillian Quinn</a>
                                                                <p class="text-muted">lilliangore</p>
                                                            </div>
                                                            <div class="media-body valign-middle text-right overflow-visible mt-2">
                                                                <button class="btn btn-secondary" type="button">Follow</button> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class=" col-lg-6 col-md-12">
                                                    <div class="card borderover-flow-hidden mb-lg-0">
                                                        <div class="media card-body media-xs overflow-visible ">
                                                            <span class="avatar cover-image avatar-md brround mr-3">IH</span>
                                                            <div class="media-body valign-middle mt-2">
                                                                <a href="" class="font-weight-semibold text-dark">Irene Harris</a>
                                                                <p class="text-muted">ireneharris@gmail.com</p>
                                                            </div>
                                                            <div class="media-body valign-middle text-right overflow-visible mt-2">
                                                                <button class="btn btn-success" type="button">Follow</button> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class=" col-lg-6 col-md-12">
                                                    <div class="card borderover-flow-hidden mb-lg-0">
                                                        <div class="media card-body media-xs overflow-visible ">
                                                            <img class="avatar brround avatar-md mr-3" src="../assets/images/users/2.jpg" alt="avatar-img">
                                                            <div class="media-body valign-middle mt-2">
                                                                <a href="" class="text-dark font-weight-semibold">Harry Fisher</a>
                                                                <p class="text-muted mb-0">harryuqt</p>
                                                            </div>
                                                            <div class="media-body valign-middle text-right overflow-visible mt-2">
                                                                <button class="btn btn-danger" type="button">Follow</button> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- COL-END -->
                </div>


            </div>
        </div>
    </div>
</div>

          



@endsection
