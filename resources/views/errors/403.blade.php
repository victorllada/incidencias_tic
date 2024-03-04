@extends('layouts.app')

@section('title', __('Forbidden'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Forbidden'))

<div class="background-radial-gradient overflow-hidden d-flex align-items-center" style="height: 100vh">
    <div class="container px-4 py-5 px-md-5 text-center text-lg-start my-5">
        <div id="radius-shape-1" class="position-absolute shadow-5-strong animate"></div>
        <div class="row d-flex align-items-center mb-5">
            <div class="col mb-5 d-flex flex-column gap-5 position-relative">
                <h1 class="display-5 fw-bold ls-tight titulo">
                    Ups...
                    <span>No tienes permisos para entrar en esta página</span>
                </h1>
                <h3 class=" fw-bold ls-tight volver" onclick="history.back(); return false;">
                    <i class="bi bi-arrow-left"></i>
                    Volver
                </h3>
                <div id="radius-shape-3" class="position-absolute shadow-5-strong animate"></div>
                <div id="radius-shape-4" class="position-absolute shadow-5-strong animate"></div>
            </div>
        </div>
    </div>
</div>
