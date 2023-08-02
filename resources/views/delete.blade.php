@extends('layouts.layouts')

@section('content')
<div class="container-xl">
    <div class="row g-5 d-flex justify-content-between">

        <div class="col-md-12">
            <div class="row d-flex justify-content-center">
                <div class="col-10 col-md-6">
                    <div class="card bg-light pb-3 pb-md-0">
                        <div class="card-body">
                            <form action="/deletee/{{ $image['id'] }}" method="post">
                                @csrf
                                <p class="card-text text-center text-bold fs-5">本当に削除してもよろしいですか?</p>
                                <div class="d-flex justify-content-center">
                                    <input type="submit" value="はい" class="btn btn-danger px-3 py-2">
                                    <a href="{{ route('history') }}" class="btn btn-primary px-2 py-2 ms-4">いいえ</a>
                                </div>
                            </form>
                        </div>
                    </div>
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
                            <p class="card-created-name">作成者: {{ $image->user->name }}</p>
                            <p class="card-created">作成日: {{ $image["created_at"] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
