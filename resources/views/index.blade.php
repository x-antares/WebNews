@extends('layouts.layout')

@section('title', 'News')

@section('content')
    <div class="container">
        <a class="btn btn-primary" href="{{route('news.create')}}" role="button">Create news</a>
            <div class="row no-gutters mt-4">
                @foreach($news as $new)
                <div class="col-xl-6 col-12">
                <div class="media media-news">
                    <div class="media-img">
                        <img src="https://via.placeholder.com/350x280/20B2AA/000000" alt="Generic placeholder image">
                    </div>
                    <div class="media-body">
                        <span class="media-date">{{$new->created_at->format('d-m-y H:i:s')}}</span>
                            <a href="{{route('news.show', $new)}}"><h5 class="mt-0 sep"> {{$new->name}}</h5></a>
                        <p>{{$new->text}}</p>
                        <form method="POST" action="{{route('news.destroy', $new)}}"
                              onSubmit="if(!confirm('Are you really want to delete this new?')){return false;}">
                        <a href="{{route('news.show', $new)}}" class="btn btn-transparent">View More</a>
                        <a type="button" class="btn btn-warning" href="{{route('news.edit', $new)}}">Edit</a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
                @endforeach
            </div>
    </div>
        {{ $news->links() }}
@endsection
