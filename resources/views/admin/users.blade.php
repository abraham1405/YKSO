@extends('layouts.app')

@section('title', 'ykso | usuarios')

@section('content')
    <div class="container mt-4">
        <div class="col-md-10 mx-auto">
            <div class="card card-outline card-primary">

                <div class="card-header text-center">
                    <h3 class="card-title">Usuarios</h3>
                </div>

                <div class="card-body table-responsive">

                    <table class="table table-hover">

                        <thead>
                            <tr>
                                <th class="col-1"></th>
                                <th class="col-3">Nombre</th>
                                <th class="col-4">Email</th>
                                <th class="col-2">Cargo</th>
                                <th class="col-2 text-center">
                                    <a type="button" class="btn btn-primary btn-xs" data-toggle="modal"
                                        data-target="#modal-add-user">
                                        <i class="fa fa-user-plus"></i>
                                    </a>
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td class="image text-center">
                                        <img src="{{ asset('img' . $user->photo) }}"
                                            class="rounded elevation-2  img-size-32" alt="User Image">
                                    </td>

                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role }}</td>

                                    <td class="text-center">
                                        <a type="button" href="{{ route('delete_user', $user->id) }}">
                                            <i class="fa fa-trash text-white"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
@endsection
