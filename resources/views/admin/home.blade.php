@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">
        <h1 class="text-black-50" align="center">News List</h1>
    </div>
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Name</th>
            <th scope="col">Status</th>
            <th scope="col">Created at</th>
            <th scope="col">Updated at</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($news as $new)
            <tr>
                <th scope="row">{{$new->id}}</th>
                <td>{{$new->name}}</td>
                <td>{{$new->active}}</td>
                <td>{{$new->created_at}}</td>
                <td>{{$new->updated_at}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $news->links() }}
@endsection
