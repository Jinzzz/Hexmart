<form method="POST" action="{{ url('/customer/Password-Reset') }}">
	<input type="hidden" name="customer_email" value="{{$email->customer_email}}">
	<input type="hidden" name="customer_id" value="{{$email->customer_id}}"> @csrf @if(session('status'))
	<div class="alert alert-success" id="err_msg">
		<p>{{session('status')}}</p>
	</div> @endif @if (count($errors) > 0) @foreach ($errors->all() as $error)
	<p class="alert alert-danger">{{ $error }}</p> @endforeach @endif @if (session()->has('message'))
	<p class="alert alert-success">{{ session('message') }}</p> @endif
	<div class="row">
		<div class="col-lg-12">
			<input type="email" placeholder="Email (Required)*" name="customer_email" required="" autocomplete="off" value="{{$email->customer_email}}" readonly> @error('customer_email') <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
   </span> @enderror </div>
		<div class="col-lg-12">
			<input type="password" placeholder="Password (Required)*" name="password" required="" autocomplete="off"> @error('password') <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
   </span> @enderror </div>
		<div class="col-lg-12">
			<input type="password" placeholder="Confirm Password (Required)*" name="confirm_password" required="" autocomplete="off"> @error('confirm_password') <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
   </span> @enderror </div>
		<div class="col-lg-12 text-center">
			<div class="btn-signup-div-frm">
				<button type="submit">Submit</button>
			</div>
		</div>
	</div>
</form>