@extends('layouts.app')
@section('content')


<a href="{{ route('billboard') }}">Volver</a>
<h2>Página de {{ $user->title }}</h2>

@endsection