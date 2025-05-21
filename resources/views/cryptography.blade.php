@extends('layouts.master')
@section('title', 'Cryptography')
@section('content')
<div class="container">
    <div class="card m-4">
        <div class="card-header">
            <h4>Cryptography Operations</h4>
        </div>
        <div class="card-body">
            <form action="{{route('cryptography')}}" method="get">
                <div class="row mb-3">
                    <div class="col">
                        <label for="data" class="form-label">Input Data:</label>
                        <textarea class="form-control" id="data" name="data" rows="3" required>{{$data}}</textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <label for="action" class="form-label">Operation:</label>
                        <select class="form-control" id="action" name="action" required>
                            <option value="Encrypt" {{($action=="Encrypt")?"selected":""}}>Encrypt</option>
                            <option value="Decrypt" {{($action=="Decrypt")?"selected":""}}>Decrypt</option>
                            <option value="Hash" {{($action=="Hash")?"selected":""}}>Hash</option>
                            <option value="Sign" {{($action=="Sign")?"selected":""}}>Sign</option>
                            <option value="Verify" {{($action=="Verify")?"selected":""}}>Verify</option>
                            <option value="KeySend" {{($action=="KeySend")?"selected":""}}>KeySend</option>
                            <option value="KeyRecive" {{($action=="KeyRecive")?"selected":""}}>KeyRecive</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <button type="submit" class="btn btn-primary">Process</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if($status)
    <div class="card m-4">
        <div class="card-header">
            <h5>Result</h5>
        </div>
        <div class="card-body">
            <div class="alert {{$status == 'Encrypted Successfully' || $status == 'Decrypted Successfully' || $status == 'Hashed Successfully' || $status == 'Signed Successfully' || $status == 'Key Encrypted Successfully' || $status == 'Key Decrypted Successfully' ? 'alert-success' : 'alert-info'}}">
                <strong>Status:</strong> {{$status}}
            </div>
            @if($result)
            <div class="mt-3">
                <label class="form-label">Output:</label>
                <textarea class="form-control" rows="3" readonly>{{$result}}</textarea>
            </div>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection
