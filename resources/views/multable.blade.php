@extends('layouts.master')

@section('title', 'Multiplication Tables')

@section('content')
<div class="container mt-4">
    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-4">
        @foreach (range(1, 10) as $j)
            <div class="col">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white text-center">
                        <h5 class="m-0">{{ $j }} Multiplication Table</h5>
                    </div>
                    <div class="card-body p-2">
                        <table class="table table-bordered text-center">
                            @foreach (range(1, 10) as $i)
                                <tr>
                                    <td>{{ $i }} × {{ $j }}</td>
                                    <td>=</td>
                                    <td class="fw-bold">{{ $i * $j }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
