@extends('layouts.layout')
@section('title', 'Show news')
@section('content')

    <h3 class = "text-center"> {{$news->name}} </h3>
    <div class = "row">
        <div class = "col-8 offset-2">
            <div class = "card">
                @if(isset($news->image_path))
                <div class = "card-footer small-muted small">
                    <img src="{{ $news->image_path }}" class="img-fluid rounded" alt="Image">
                </div>
                @endif
                <div class = "card-body">
                    <p class = "card-text">Created at: {{ $news->created_at->format('d-m-y H:i:s') }} </p>
                    <p class = "card-text"> {{$news->text}} </p>
                </div>
            </div>
            <form method="POST" action="{{route('news.destroy', $news)}}">
                <a type="button" class="btn btn-warning mt-3" href="{{route('news.edit', $news)}}">Edit</a>
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger mt-3">Delete</button>
            </form>
        </div>
    </div>
@endsection
