@extends('layouts.layout')
@section('title', 'News')
@section('content')
    <div class="container">
        @auth
        <a class="btn btn-primary" href="{{route('news.create')}}" role="button">Create news</a>
        <a class="btn btn-primary" href="{{route('admin')}}" role="button">Go to Admin Panel</a>
        @endauth
            @if(!$news->isEmpty())
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3 mt-4">
            @foreach($news as $new)
                <div class="col">
                    <div class="card shadow-sm">
                        @if($new->image_path !== NULL)
                        <img class="bd-placeholder-img card-img-top" width="350" height="280" src="{{$new->image_path}}">
                        @endif
                        <div class="card-body">
                            <p>@foreach($new->tags as $tag)
                                    <a href="">#{{$tag->name}}</a>
                                @endforeach
                            </p>
                            <a href="{{route('news.show', $new)}}"><h5 class="mt-0 sep"> {{$new->name}}</h5></a>
                            <p class="card-text">{!! $new->text !!}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <a href="{{route('news.show', $new)}}" class="btn btn-sm btn-primary">View</a>
                                   @auth
                                    <a href="{{route('news.edit', $new)}}" class="btn btn-sm btn-warning">Edit</a>
                                    <form method="POST" action="{{route('news.destroy', $new)}}"
                                          onSubmit="if(!confirm('Are you really want to delete this new?')){return false;}">
                                    @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                    @endauth
                                </div>
                                <small class="text-muted">{{$new->created_at->format('d-m-y H:i:s')}}</small>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    {{ $news->links() }}
    @else
        <h4 align="center">List news empty</h4>
    @endif
@endsection
