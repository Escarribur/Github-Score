@extends('layout')

@section('content')
    <h1>   GitHub Score</h1>
    <h3>Ingrese usuario de Github</h3>
    
<form action="{{ url('puntaje') }}" method="POST">
 {{ csrf_field() }}
		<label for="usuario">Usuario</label>
			<input type="text" class="form-control" id="usuario" name='usuario' autofocus="true">
	

	<div class="form-group">
        
			<button type="submit" class="btn btn-default">Calcular puntaje</button>
		
	</div>
</form>
	

	 <h1>   GitHub Score Battle</h1>
    <h3>Ingrese usuarios de Github</h3>
    <form action="{{ url('batalla') }}" method="POST">
	 {{ csrf_field() }}
		<label for="usuarioA">Usuario A</label>
		<input type="text" class="form-control" id="usuarioA" name='usuarioA' autofocus="true">

		<label for="usuarioA">Usuario B</label>
		<input type="text" class="form-control" id="usuarioB" name='usuarioB' autofocus="true">
	

	<div class="form-group">
        
			<button type="submit" class="btn btn-default">Battle!</button>
		
	</div>
</form>


@stop