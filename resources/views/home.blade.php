@extends('layouts.app')

@section('content')
    <search route="{{ route('carros.store') }}"></search>
    @if(isset($founds))
    <counter list="{{ route('carros.index') }}" home="{{ route('home') }}" founds="{{ $founds }}"></counter>
    @endif

    @if(!isset($founds))
    <div class="text-center py-5">
        <i class="d-block las la-car"></i>
        <a class="btn btn-default" href="{{ route('carros.index') }}">Ver todos os carros salvos</a>
    </div>
    @endif
@endsection
