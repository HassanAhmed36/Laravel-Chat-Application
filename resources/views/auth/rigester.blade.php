@extends('layout.app')
@section('content')
<div class="container">
    <h4 class="mb-4">Register Your Self!</h4>

    <form autocomplete="off" method="POST" action="{{route('submit.register')}}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="username" class="form-control" placeholder="Username">
            @error('username')
            <p class="text-danger my-1">{{$message}}</p>
            @enderror
        </div>
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
            <p>Already have an account? <a href="{{route('login')}}">Login</a></p>
        </div>
        <button type="submit" class="btn btn-dark mt-3">Register</button>
    </form>
</div>
@endsection
