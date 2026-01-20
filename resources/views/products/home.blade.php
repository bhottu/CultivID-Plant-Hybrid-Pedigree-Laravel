@extends('layouts.app')

@section('content')
    @include('partials.home-content', ['products' => $products])
@endsection
