@extends('layouts.layouts')

@section('content')
<div class="container-xl">
    <div class="row g-5 d-flex justify-content-between">
        @if (isset($uploadSuccess))
            {{ $uploadSccess }}
        @endif
        <div class="col-md-4">
            <form action="/search" method="GET" class="card py-4 px-3">
                <div class="d-flex justify-content-center">
                    <input type="text" class="form-control me-1" placeholder="#タグを入力" id="search" name="tags">
                    <input type="submit" value="検索" class="btn btn-success px-3">
                </div>
            </form>

            <form action="/post" method="POST" enctype="multipart/form-data" class="mt-5 card py-4 px-3">
                @csrf

                @error("content")
                    <div class="text-danger errorMessage text-center">
                        <span>{{ $message }}</span>
                    </div>
                @enderror
                <textarea name="content" rows="5" id="post" class="form-control my-4" placeholder="いまの気分を画像と共につぶやこう"></textarea>

                @if ($errors->has('tag1') || $errors->has('tag2'))
                    <div class="text-danger text-center">
                        @if($errors->has('tag1'))
                            <span>※{{ $errors->first('tag1') }}</span>
                        @else
                            <span>※{{ $errors->first('tag2') }}</span>
                        @endif
                    </div>
                @endif
                <div class="row d-flex justify-content-center">
                    <div class="col-5">
                        <input type="text" name="tag1" class="form-control" placeholder="タグ1">
                    </div>
                    <div class="col-5">
                        <input type="text" name="tag2" class="form-control" placeholder="タグ2">
                    </div>
                </div>

                @error("image")
                    <div class="text-danger errorMessage text-center">
                        <span>※{{ $message }}</span>
                    </div>
                @enderror
                <input type="file" name="image" class="form-control my-4">
                <div class="d-flex justify-content-center">
                    <input type="submit" value="投稿" class="btn btn-primary px-3">
                </div>
            </form>
        </div>

        <div class="col-md-8">
            <div class="row g-3">
                @isset($images)
                    @foreach ($images as $image)
                        <div class="col-6 col-md-4">
                            <div class="card mt-3">
                                <a href={{ asset("storage/{$image['src']}") }} data-lightbox=" ">
                                    <img src={{ asset("storage/{$image['src']}") }} class="card-img-top">
                                </a>
                                <div class="card-body">
                                    <p class="card-text">{{ $image["content"] }}</p>
                                    {{-- タグの処理 --}}
                                    <div class="d-flex tags">
                                        @isset($image->tag->tag1)
                                            <a href="/search?tags={{ $image->tag->tag1 }}">#{{ $image->tag->tag1}}</a>
                                        @endisset
                                        @isset($image->tag->tag2)
                                            <a href="/search?tags={{ $image->tag->tag2 }}" class="ms-1">#{{ $image->tag->tag2}}</a>
                                        @endisset
                                    </div>
                                    <p class="card-created-name">作成者: {{ $image->user->name }}</p>
                                    <p class="card-created">作成日: {{ $image["created_at"] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endisset
            </div>
            <div class="mt-5">
                {{-- index()からアクセスしてきた時だけ表示 --}}
                @if (Route::currentRouteName() === 'home')
                    {{ $images->links("pagination::bootstrap-5") }}
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
