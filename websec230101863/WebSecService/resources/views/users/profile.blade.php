@extends('layouts.master')

@section('title', 'User Profile')

@section('content')
<div class="row">
    <div class="m-4 col-sm-6">
        <table class="table table-striped">
            <tr>
                <th>Name</th><td>{{$user->name}}</td>
            </tr>
            <tr>
                <th>Email</th><td>{{$user->email}}</td>
            </tr>
            <tr>
                <th>Roles</th>
                <td>
                    @foreach($user->roles as $role)
                        <span class="badge bg-primary">{{$role->name}}</span>
                    @endforeach
                </td>
            </tr>
            <tr>
                <th>Permissions</th>
                <td>
                    @foreach($permissions as $permission)
                        <span class="badge bg-success">{{$permission->display_name}}</span>
                    @endforeach
                </td>
            </tr>

            <!-- Only show credit information if the user is a customer -->
            @if($user->hasRole('Customer'))
            <tr>
                <th>Credit</th>
                <td>
                    <span class="badge bg-info">{{$user->credit}} Credits</span>
                    @if($user->credit < 100)
                        <span class="badge bg-warning">Insufficient Credit</span>
                    @endif
                </td>
            </tr>
            @endif
        </table>

        <div class="row">
            <div class="col col-6">
            </div>
            
            @if(auth()->user()->hasPermissionTo('admin_users') || auth()->id() == $user->id)
            <div class="col col-4">
                <a class="btn btn-primary" href='{{route('edit_password', $user->id)}}'>Change Password</a>
            </div>
            @else
            <div class="col col-4">
            </div>
            @endif
            
            @if(auth()->user()->hasPermissionTo('edit_users') || auth()->id() == $user->id)
            <div class="col col-2">
                <a href="{{route('users_edit', $user->id)}}" class="btn btn-success form-control">Edit</a>
            </div>
            @endif
            
            <!-- Only show the Add Credit button for customers -->
            <div class="col col-12">
                @if($user->hasRole('Customer'))
                    @if($user->credit < 100)
                        <p class="text-danger">Your credit is insufficient for certain actions (minimum 100 credits required).</p>
                    @endif
                    <a href="{{ route('add_credit') }}" class="btn btn-warning">Add Credit</a>
                @endif
            </div>  
        </div>
    </div>
</div>
@endsection
