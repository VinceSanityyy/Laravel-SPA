@extends('beautymail::templates.widgets')

@section('content')

	@include('beautymail::templates.widgets.newfeatureStart')
	   @foreach($username as $data)
	  
		<h4 class="secondary"><strong>Hello there! {{$data->name}}</strong></h4>
		@endforeach
		<p><h3>{{$text}}</h3></p>
		<br><br>
		<p>
			Below is your Registration Code
			</p> 
			<p>
			<h1>{{ $code }}</h1>
		</p> 

	@include('beautymail::templates.widgets.newfeatureEnd')

@stop