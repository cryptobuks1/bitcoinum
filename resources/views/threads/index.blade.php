@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Forum Threads</div>

                <div class="card-body">
                    @foreach($threads as $thread)
                        <div class="card mb-3">
                            <div class="card-header p-2">
                                <h4 class="m-0"><a href="{{ $thread->path() }}">{{ $thread->title }}</a></h4>
                            </div>
                            <div class="card-body">
                                    {{ $thread->body }}
                            </div>
                            <div class="card-footer d-flex justify-content-between p-0">
                                <div class="p-2">
                                    <a href="#">{{ $thread->creator->name }}</a>: {{ $thread->created_at->diffForHumans() }}
                                </div>
                                <div class="p-2">
                                    <a href="{{ $thread->path() }}">
                                        {{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count) }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
