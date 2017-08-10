<ul class="row list-unstyled">
    <li class="col-xl-4 col-md-6">
        <div class="card card-profile mb-4">
            <div class="card-header bg-danger"></div>
            <div class="card-block">
                <a href="{{ route('following') }}">
                    <img class="avatar card-profile-img" src="{{asset($following->avatar)}}">
                </a>

                <span class="float-right">
                    @include('fragments.friendship.small')
                </span>

                <strong class="card-title d-block">
                    <a class="text-inherit" href="{{ route('following') }}">{{$following->display_name}}</a>
                </strong>

                <p class="mb-4">
                    {{$following->description}}
                </p>
            </div>
        </div>
    </li>
</ul>
