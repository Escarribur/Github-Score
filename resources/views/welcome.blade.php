@extends('layout')

@section('content')
    <h1>   GitHub Score</h1>
    <h3>Ingrese usuario de Github</h3>
    
<form action="{{ url('puntaje') }}" method="POST">
 {{ csrf_field() }}
		<label for="usuario">usuario</label>
			<input type="text" class="form-control" id="usuario" name='usuario' autofocus="true">
	

	<div class="form-group">
        
			<button type="submit" class="btn btn-default">Calcular puntaje</button>
		
	</div>
</form>
	


@stop