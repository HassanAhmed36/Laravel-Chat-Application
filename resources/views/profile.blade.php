@extends('layout.app')
@section('content')
<div class="container">
    <h4 class="mb-4">Update Profile!</h4>
    <form method="POST" action="{{route('update.Profile' , ['id' =>$User->id ])}}" autocomplete="">
        @csrf
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="username" class="form-control" value="{{$User->name}}">
        </div>
        <div class="mb-3">
            <label class="form-label">Email address</label>
            <input type="email" name="email" class="form-control" value="{{$User->email}}">
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" autocomplete="">
            @error('password')
             <p class="text-danger my-1">{{$message}}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>
        <button type="submit" class="btn btn-dark mt-3">Update</button>
    </form>
</div>
@endsection
