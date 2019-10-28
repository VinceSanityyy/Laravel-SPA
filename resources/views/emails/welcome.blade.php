@extends('beautymail::templates.widgets')

@section('content')

	@include('beautymail::templates.widgets.newfeatureStart')

		<h4 class="secondary"><strong>Test Email</strong></h4>
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