@extends('layouts.user')

@section('content')
    <div class="col-lg-3">
        @include('user.fragments.friendship')

        <div class="hidden-md-down">
            @include('fragments.footer')
        </div>
    </div>

    <div class="col-lg-9">
        @each('user.fragments.users',$following,'following')

        <div class="hidden-lg-up">
            @include('fragments.footer')
        </div>
    </div>
@endsection
