<meta charset="UTF-8">
<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- FAVICON -->
<link rel="shortcut icon" type="image/x-icon" href="{{URL::to('/assets/frontAssets/image/logo.png')}}" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- TITLE -->
<title>{{ __('Hex Mart | Administration') }}</title>
<!-- BOOTSTRAP CSS -->
<link href="{{URL::to('/assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" />
<!-- STYLE CSS -->
<link href="{{URL::to('/assets/css/style.css')}}" rel="stylesheet"/>
<link href="{{URL::to('/assets/css/skin-modes.css')}}" rel="stylesheet"/>
<!-- SIDE-MENU CSS -->
<link href="{{URL::to('/assets/plugins/sidemenu/closed-sidemenu.css')}}" rel="stylesheet">
<!--C3 CHARTS CSS -->
<link href="{{URL::to('/assets/plugins/charts-c3/c3-chart.css')}}" rel="stylesheet"/>
<!-- CUSTOM SCROLL BAR CSS-->
<link href="{{URL::to('/assets/plugins/scroll-bar/jquery.mCustomScrollbar.css')}}" rel="stylesheet"/>
<!--- FONT-ICONS CSS -->
<link href="{{URL::to('/assets/css/icons.css')}}" rel="stylesheet"/>
<!-- DATA TABLE CSS -->
<link href="{{URL::to('/assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet"/>
<!-- SIDEBAR CSS -->
<link href="{{URL::to('/assets/plugins/sidebar/sidebar.css')}}" rel="stylesheet">
<!-- MULTI SELECT CSS -->
<link rel="stylesheet" href="{{URL::to('/assets/plugins/multipleselect/multiple-select.css')}}">
<!-- COLOR SKIN CSS -->
<link id="theme" rel="stylesheet" type="text/css" media="all" href="{{URL::to('/assets/colors/color1.css')}}" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link data-require="sweet-alert@*" data-semver="0.4.2" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<script type="text/javascript" src="{{URL::to('/assets/js/lan.js')}}"></script>
<style type="text/css">
	.breadcrumb-item+.breadcrumb-item::before
	 {
		content: ">" !important;
	}
</style>

	<!-- NOTIFICATION CSS -->
	<link href="{{URL::to('/assets/plugins/notify/css/jquery.growl.css')}}" rel="stylesheet"/>

@section('headSection')
@show