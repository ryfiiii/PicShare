@extends('layouts.layouts')

@section('content')
<div class="container-xl">
    <div class="row g-5 d-flex justify-content-between">
        <div class="col-md-12">
            <div class="row d-flex justify-content-center">
                <div class="col-10 col-md-6" id="delete">
                    <div class="card">
                        <form action="/editt/{{ $image->id }}" method="POST">
                            @csrf                        
                            <a href={{ asset("storage/{$image['src']}") }} data-lightbox=" ">
                                <img src={{ asset("storage/{$image['src']}") }} class="card-img-top">
                            </a>
                            <div class="card-body">
                                @error("content")
                                    <div class="text-danger errorMessage text-center">
                                        <span>{{ $message }}</span>
                                    </div>
                                @enderror
                                <textarea name="content" rows="5" id="post" class="form-control my-4">{{ $image->content }}</textarea>

                                <div class="row d-flex justify-content-center">
                                    @if ($errors->has('tag1') || $errors->has('tag2'))
                                        <div class="text-danger text-center">
                                            @if($errors->has('tag1'))
                                                <span>※{{ $errors->first('tag1') }}</span>
                                            @else
                                                <span>※{{ $errors->first('tag2') }}</span>
                                            @endif
                                        </div>
                                    @endif
                                    <div class="col-5">
                                        @isset($image->tag->tag1)
                                            <input type="text" name="tag1" class="form-control" value="{{ $image->tag->tag1 }}">
                                        @else
                                            <input type="text" name="tag1" class="form-control">
                                        @endisset
                                    </div>
                                    <div class="col-5">
                                        @isset($image->tag->tag2)
                                            <input type="text" name="tag2" class="form-control" value="{{ $image->tag->tag2 }}">
                                        @else
                                            <input type="text" name="tag2" class="form-control">
                                        @endisset
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center mt-3">
                                    <input type="submit" value="確定" class="btn btn-warning px-3 py-2">
                                    <a href="{{ route('history') }}" class="btn btn-primary px-3 py-2 ms-4">戻る</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
