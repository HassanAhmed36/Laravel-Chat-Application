@extends('layout.app')
@section('content')
<div class="container">

    <div class="search my-4">
        <h4 class="mb-5">Search User</h4>
        <form action="{{route('search.user')}}" method="get">
            <div class="row align-items-center">
                <div class="col-sm-9 col-md-9 col-lg-9 col-7">
                    <input type="text" value="{{request()->search}}" class="form-control p-2" name="search" placeholder="Search...">
                </div>
                <div class="col-sm-3 col-md-3 col-lg-3 col-5">
                    <div class="d-flex">
                        <button class="btn btn-dark mx-sm-2 mx-lg-2 mx-md-2 mx-1" type="submit">Search</button>
                        <a href="{{route('search.user')}}" class="btn btn-dark" type="submit">clear</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @if ($users !== null)
    <div class="result my-5">
        @forelse ($users as $user)
        <div class="card mb-3">
            <div class="card-body">
                <a href="{{route('chat' , ['id' => $user->id ])}}" class="text-black text-decoration-none">
                    {{$user->name}}
                </a>
            </div>
        </div>

        @empty
        <p class="text-center fs-5">No User Found..</p>
        @endforelse
    </div>
    @else
    <p class="text-center fs-5 fw-lighter">Search User..</p>
    @endif


</div>
@endsection
