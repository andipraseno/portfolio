@extends('layouts.main')

@section('container')
    <h1>SELAMAT DATANG, {{ request()->session()->get('user_nama') }}</h1>

    @include('partials.main_footer')

    <script></script>
@endsection
