@extends('emails.template')

@section('emails.main')
    <div class="container mt-5 w-75 mx-auto" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; line-height: 1.6;">
        <p class="lead">Agreement for Customer:</p>
        <div class="mb-4">
            <strong>Name:</strong> {{$user->first_name}} {{$user->last_name}}<br>
            <strong>Email:</strong> {{$user->email}}<br>
            <strong>Telephone:</strong> {{$user->phone}}<br>
            <strong>Country:</strong> {{$user->country}}
        </div>
        <h3 class="border-bottom pb-2 mb-4">Agreement Summary</h3>
        <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, 
            sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
             Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
            nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
            reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
            deserunt mollit anim id est laborum.
        </p>
    </div>
@endsection

