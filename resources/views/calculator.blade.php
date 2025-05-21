@extends('layouts.master')
@section('title', 'calculater')
@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header text-center bg-primary text-white">
                <h3>Simple Calculator</h3>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="num1" class="form-label">Enter First Number:</label>
                    <input type="number" id="num1" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="num2" class="form-label">Enter Second Number:</label>
                    <input type="number" id="num2" class="form-control">
                </div>
                <div class="text-center">
                    <button class="btn btn-success m-1" onclick="calculate('+')">+</button>
                    <button class="btn btn-danger m-1" onclick="calculate('-')">-</button>
                    <button class="btn btn-warning m-1" onclick="calculate('*')">×</button>
                    <button class="btn btn-info m-1" onclick="calculate('/')">÷</button>
                </div>
                <div class="mt-3 text-center">
                    <h4>Result: <span id="result">0</span></h4>
                </div>
            </div>
        </div>
    </div>

    <script>
        function calculate(operator) {
            let num1 = parseFloat(document.getElementById("num1").value);
            let num2 = parseFloat(document.getElementById("num2").value);
            let result = 0;

            if (isNaN(num1) || isNaN(num2)) {
                alert("Please enter valid numbers!");
                return;
            }

            switch(operator) {
                case '+': result = num1 + num2; break;
                case '-': result = num1 - num2; break;
                case '*': result = num1 * num2; break;
                case '/': 
                    if (num2 === 0) {
                        alert("Cannot divide by zero!");
                        return;
                    }
                    result = num1 / num2; 
                    break;
            }

            document.getElementById("result").innerText = result;
        }
    </script>
@endsection
