@extends('layout.app')

@section('css')
<style>
    .main-content {
        font-family: Arial, sans-serif;
        padding: 20px;
        background-color: #f9f9f9;
    }
    .mid-section {
        margin-top: 20px;
    }
    .p-4 {
        padding: 16px;
        background: white;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }
    .text h1 {
        font-size: 32px;
        color: #333;
        margin-bottom: 10px;
    }
    .text p {
        font-size: 16px;
        color: #666;
    }
    .quize-section h3 {
        font-size: 24px;
        color: #555;
        margin-bottom: 10px;
    }
    .quize-section button {
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    .quize-section button:hover {
        background-color: #0056b3;
    }
    #quizeOption select {
        width: 100%;
        padding: 10px;
        margin-top: 20px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    .single-block{
        border: 2px solid black;
        background-color: #121212;
        padding: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        .topic{
            color: white;
        }
    }
</style>
@endsection
@section('content')
    <div class="main-content">

        <div class="mid-section">
            <div class="row">
                <div class="col-md-6">
                    <div class="p-4">
                        <div class="text">
                            <h1>Quize</h1>
                            <p>Expand your knowledge</p>
                        </div>
                        <div class="quize-section">
                            <h3>Let's get started</h3>
                            <button onclick="selectOption();">Start</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-4">
                        <div id="quizeOption">
                            <div class="row">
                                @foreach (\App\Helper::questionQption as $option)
                                <div class="col-md-4 mb-2">
                                    <div class="single-block">
                                        <a href="{{route('singlequize',['option'=>$option])}}">
                                            <div class="topic">
                                                {{ ucfirst($option) }}
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function selectOption() {
            $('#quizeOption').append(`
            `);
            $('.quize-section').hide();
        }
    </script>
@endsection
