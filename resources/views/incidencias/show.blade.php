@extends('layouts.plantilla')
@section('titulo', 'Incidencias - show')
@section('contenido')

    <h1>Incidencias show</h1>
    <div>
        <ul>
            <li>Id:{{ $incidencia->id }}</li>
            <li>Tipo:{{ $incidencia->tipo }}</li>
            <li>Subtipo:{{ $incidencia->subtipo_id }}</li>
            <li>Descripción:{{ $incidencia->descripcion }}</li>
            <li>Estado:{{ $incidencia->estado }}</li>
            <li>Estado:{{ $incidencia->estado }}</li>
        </ul>
    </div>
@endsection
