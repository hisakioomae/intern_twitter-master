@extends('layouts.app')

@section('content')
    <div class="col-lg-3">
        <div class="card card-profile mb-4">
            <div class="card-header bg-danger"></div>
            <div class="card-block text-center">
                <a href="{{ route('profile') }}">
                    <img class="avatar card-profile-img" src="{{asset($users->avatar)}}">
                </a>

                <div class="card-title my-2">
                    <a href="{{ route('profile') }}" class="font-weight-bold text-inherit d-block">
                        {{$users['display_name']}}
                    </a>
                    <a href="{{ route('profile') }}" class="text-inherit">
                        &#64;{{$users['url_name']}}
                    </a>
                </div>

                <p class="mb-4">{{$users['description']}}</p>

                <ul class="card-profile-stats">
                    <li class="card-profile-stat">
                        <a href="{{ route('following.user', [$users]) }}" class="text-inherit">
                            フォロー
                            <strong class="d-block">{{$following_num}}</strong>
                        </a>
                    </li>
                    <li class="card-profile-stat">
                        <a href="{{ route('followers') }}" class="text-inherit">
                            フォロワー
                            <strong class="d-block">{{$follower_num}}</strong>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <ul class="list-group media-list-stream mb-4">
            <li class="media list-group-item p-4 {{ $errors->has('body') ? 'has-danger' : '' }}">
                <form method="POST" action="{{ route('home.tweet') }}" class="input-group">
                    {{ csrf_field() }}

                    <input name="body" type="text" class="form-control" placeholder="いまどうしてる？">
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-secondary">
                            <span class="icon icon-new-message"></span>
                        </button>
                    </div>
                </form>

                @if($errors->has('body'))
                    <div class="form-control-feedback">
                        <strong>{{ $errors->first('body') }}</strong>
                    </div>
                @endif
            </li>
            @each('fragments.tweet',$tweets,'tweet')

        </ul>
    </div>

    <div class="col-lg-3">
        @include('fragments.footer')
    </div>
@endsection
