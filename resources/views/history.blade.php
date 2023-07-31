@extends('layouts.layouts')

@section('content')
<div class="container-xl">
    <div class="row g-5 d-flex justify-content-between">

        <div class="col-md-12">
            <div class="row g-3">
                @if(session("alert"))
                    @if (session("alert.status") === "success")
                        <div class="alert alert-success text-center">
                            <p>{{ session("alert.message") }}</p>
                        </div>
                    @elseif(session("alert.status") === "danger")
                        <div class="alert alert-danger text-center">
                            <p>{{ session("alert.message") }}</p>
                        </div>
                    @endif
                @endif
                @isset($images)
                    @foreach ($images as $image)
                        <div class="col-6 col-md-3">
                            <div class="card mt-3">
                                <a href={{ asset("storage/{$image['src']}") }} data-lightbox=" ">
                                    <img src={{ asset("storage/{$image['src']}") }} class="card-img-top">
                                </a>
                                <div class="card-body">
                                    <p class="card-text">{{ $image["content"] }}</p>
                                    {{-- タグの処理 --}}
                                    <div class="d-flex tags">
                                        @isset($image->tag->tag1)
                                            <p>#{{ $image->tag->tag1}}</p>
                                        @endisset
                                        @isset($image->tag->tag2)
                                            <p class="ms-1">#{{ $image->tag->tag2}}</p>
                                        @endisset
                                    </div>
                                    <div class="icon d-flex justify-content-center pt-4">
                                        <a href="/edit/{{ $image->id }}"><i class="fa-solid fa-pen-to-square edit-icon text-warning"></i></a>
                                        <a href="/delete/{{ $image->id }}"><i class="fa-solid fa-trash trash-icon text-danger ms-3"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-center fs-3 font-bold">まだ投稿がありません</p>
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
