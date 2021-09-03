@extends('layouts.layout')

@section('title', 'News')

@section('content')
    <div class="container">
            <div class="row no-gutters mt-4">
                @foreach($news as $new)
                <div class="col-xl-6 col-12">
                <div class="media media-news">
                    <div class="media-img">
                        <img src="https://via.placeholder.com/350x280/20B2AA/000000" alt="Generic placeholder image">
                    </div>
                    <div class="media-body">
                        <span class="media-date">{{$new->created_at}}</span>
                        <h5 class="mt-0 sep"> {{$new->name}}</h5>
                        <p>{{$new->text}}</p>
                        <a href="#" class="btn btn-transparent">View More</a>
                    </div>
                </div>
            </div>
                @endforeach
            </div>
    </div>
@endsection
