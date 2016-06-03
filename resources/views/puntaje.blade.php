@extends('layout')

@section('content')


	<h2>Puntaje </h2>
	<h3>Usuario: {{$usuario}}</h3>
	<h3>Puntaje Eventos: {{$evento}}</h3>
	<h3>Puntaje Seguidores: {{$follower}}</h3>
	<h3>Puntaje Estrellas: {{$star}}</h3>
	<h3>GitHub Total Score: {{$score}}</h3>
	
	<a href="{{ URL::previous() }}">Volver</a>


@stop