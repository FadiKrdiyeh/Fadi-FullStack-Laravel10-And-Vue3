@extends('layouts.layout')

@section('title', 'Fadi Krdiyeh')

@section('headerScripts')
    @if (Auth::check())
        <script>
            (function() {
                window.Laravel = {
                    authUser: @json(Auth::user())
                };
            })();
        </script>
    @endif
@endsection

@section('content')
    <div id="fadiApp"></div>
@endsection
