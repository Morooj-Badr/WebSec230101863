@extends('layouts.master')

@section('title', 'Prime Numbers')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white text-center">
            <h3>Prime Numbers</h3>
        </div>
        <div class="card-body">
            <div class="row row-cols-8 g-2 text-center">
                @foreach (range(1, 100) as $i)
                    <div class="col">
                        <div class="card {{ isPrime($i) ? 'bg-primary text-white' : 'bg-light' }}">
                            <div class="card-body p-2">
                                <h5 class="m-0 fw-bold">{{ $i }}</h5>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
