@extends('layouts.layout')

@section('title', isset($news) ? 'Update '.$news->name : 'Create news')

@section('content')
    <form method="POST"
          @if(isset($news))
                action="{{route("news.update", $news)}}" enctype="multipart/form-data">
            @else
                action="{{route("news.store")}}" enctype="multipart/form-data">
          @endif
            @csrf
                @isset($news)
                    @method('PUT')
                @endisset
        <div class="form-group row">
            <label for="name" class="col-sm-2 ms-3 col-form-label">Name of new</label>
                <div class="col-sm-5">
                    <input type="text" name="name" class="form-control"
                           value="{{isset($news) ? $news->name : null}}"
                           id="name" placeholder="Name">
                </div>
        </div>
        <div class="form-group row">
            <label for="text" class="col-sm-2 ms-3 col-form-label">Text</label>
                 <div class="col-sm-7">
                     <textarea class="form-control" name="text" id="text" rows="7"
                               placeholder="Type your new">{{isset($news) ? $news->text : null}}</textarea>
                 </div>
        </div>
        <div class="form-group">
            <label for="image">Image {{isset($news) ? $news->image_path : null}}</label>
            <input type="file" name="image" class="form-control-file" id="image">
        </div>
        <div class="form-group row">
            <label for="tag" class="col-sm-2 ms-3 col-form-label">Tags</label>
            <div class="col-sm-5">
                <input type="text" name="tag" class="form-control" id="tag" placeholder="Type your tags">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sx-10">
                <button type="submit" class="btn btn-success form-control pull-right">Create</button>
            </div>
        </div>
    </form>
@endsection
