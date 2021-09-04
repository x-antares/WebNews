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
                           value="{{ old('name', isset($news) ? $news->name : null) }}"
                           id="name" placeholder="Name">
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
        </div>
        <div class="form-group row">
            <label for="text" class="col-sm-2 ms-3 col-form-label">Text</label>
                 <div class="col-sm-7">
                     <textarea class="form-control" name="text" id="text" rows="7"
                               placeholder="Type your new">{{ old('text', isset($news) ? $news->text : null) }}</textarea>
                 </div>
                    @error('text')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
        </div>
        <div class="form-group">
            <div class="custom-file">
                <input type="file" name="file" class="custom-file-input" id="chooseFile">
                <label class="custom-file-label" for="chooseFile">{{ isset($news->image_path) ? $news->image_path : "Select file" }}</label>
            </div>
        </div>
                @error('image')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
        <div class="form-group row">
            <label for="tag" class="col-sm-2 ms-3 col-form-label">Tags</label>
            <div class="col-sm-5">
                <input type="text" name="tag" class="form-control" id="tag" placeholder="Type your tags">
            </div>
        </div>
        <div class="form-group row">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="active" value="{{ old('active', isset($news) ? $news->active : null) }}" id="active">
                <label for="checkActive">Publish new</label>
            </div>
        </div>
                @error('active')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
        <div class="form-group row">
            <div class="col-sx-10">
                <button type="submit" class="btn btn-success form-control pull-right">Create</button>
            </div>
        </div>
    </form>
@endsection
