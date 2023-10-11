@extends('layout.app')
@section('content')
<div class="container">
    <h4 class="mb-4">Login to You Account!</h4>
    <form action="{{route('submit.login')}}" autocomplete="off" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Email address</label>
            <input type="email" name="email" class="form-control" placeholder="example@gmail.com">
            @error('email')
            <p class="text-danger my-1">{{$message}}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="******">

            @error('password')
            <p class="text-danger my-1">{{$message}}</p>
            @enderror

        </div>
        <div class="mb-3">
            <p>Dont have an Account? <a href="{{route('rigester')}}">Rigester</a></p>
        </div>

        <button type="submit" class="btn btn-dark mt-3">Login</button>
    </form>

</div>



@endsection
