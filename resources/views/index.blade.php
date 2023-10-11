@extends('layout.app')
@section('content')

<div class="container">
    <h4 class="mb-4">Welcome to Chat Application</h4>
    <p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Corrupti ipsum non, ut, recusandae quas deleniti dolorem voluptatem omnis laboriosam eligendi, praesentium obcaecati nam! Beatae cum, animi placeat officia vero quia.</p>
    <a href="{{route('login')}}" class="btn btn-dark">Login</a>
    <a href="{{route('rigester')}}" class="btn btn-dark">Rigester</a>
</div>

@endsection
