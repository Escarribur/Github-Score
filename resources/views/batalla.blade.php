@extends('layout')

@section('content')


	<h2>Batalla </h2>
	<h3> {{$usuarioA}} vs {{$usuarioB}} </h3>
	<h3>Eventos: {{$eventoA}} vs {{$eventoB}}</h3>
	<h3>Seguidores: {{$followerA}} vs {{$followerB}}</h3>
	<h3>Estrellas: {{$starA}} vs {{$starB}}</h3>
	<h3>GitHub Total Score: {{$scoreA}} vs {{$scoreB}}</h3>
	
	<h2>{{$ganador}} es el Ganador!!!</h2>
	<a href="{{ URL::previous() }}">Volver</a>


@stop