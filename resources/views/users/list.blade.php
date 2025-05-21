  @extends('layouts.master')

  @section('title', 'Users')

  @section('content')
  <div class="row mt-2">
      <div class="col col-10">
          <h1>Users</h1>
      </div>
  </div>

  <form>
      <div class="row">
          <div class="col col-sm-2">
              <input name="keywords" type="text" class="form-control" placeholder="Search Keywords" value="{{ request()->keywords }}" />
          </div>
          <div class="col col-sm-1">
              <button type="submit" class="btn btn-primary">Submit</button>
          </div>
          <div class="col col-sm-1">
              <button type="reset" class="btn btn-danger">Reset</button>
          </div>
          <div class="col col-sm-2">
              @if(auth()->check() && auth()->user()->hasRole('Admin'))
                  <a href="{{ route('register') }}" class="btn btn-success">+ Add User</a>
              @endif
          </div>  
      </div>
  </form>

  <div class="card mt-2">
      <div class="card-body">
          <table class="table">
              <thead>
                  <tr>
                      <th scope="col">#</th>
                      <th scope="col">Name</th>
                      <th scope="col">Email</th>
                      <th scope="col">Roles</th>
                      <th scope="col">Credit</th>
                      <th scope="col"></th>
                  </tr>
              </thead>
              @foreach($users as $user)
              <tr>
                  <td scope="col">{{$user->id}}</td>
                  <td scope="col">{{$user->name}}</td>
                  <td scope="col">{{$user->email}}</td>
                  <td scope="col">{{$user->role}}</td>
                  <td scope="col">{{$user->credit}}</td>
                  <td scope="col">
                      @foreach($user->roles as $role)
                          <span class="badge bg-primary">{{$role->name}}</span>
                      @endforeach
                  </td>
                  <td scope="col">
                      @can('edit_users')
                      <a class="btn btn-primary" href='{{route('users_edit', [$user->id])}}'>Edit</a>
                      @endcan
                      
                      @can('admin_users')
                      <a class="btn btn-primary" href='{{route('edit_password', [$user->id])}}'>Change Password</a>
                      @endcan
                      
                      @can('delete_users')
                      <form action="{{ route('users_delete', [$user->id]) }}" method="POST" style="display:inline;">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
                      </form>
                      @endcan

                     
                      <form action="{{ route('charge_credit', ['user' => $user->id]) }}" method="POST" style="display:inline;">
                        @csrf
                        <input type="number" name="amount" class="form-control" placeholder="Enter amount" required style="width: 150px; display: inline-block;">
                        <button type="submit" class="btn btn-warning">Charge Credit</button>
                    </form>

                    @can('Reset_Credit')
                    <td scope="col">

                    <form action="{{ route('resetCredit') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger" >Reset Credit</button>
                    </form>
                    @endcan
                      
                  </td>
              </tr>
              @endforeach
          </table>
      </div>
  </div>

  @endsection
