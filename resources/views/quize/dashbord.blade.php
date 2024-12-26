@extends('layout.app')

@section('css')
    <style>
        .main-content {
            font-family: 'Poppins', sans-serif;
            padding: 10px 20px;
            background-color: #f4f6f8;
        }

        .mid-section {
            margin-top: 20px;
        }

        .p-3 {
            padding: 20px;
            background: #ffffff;

            border-radius: 12px;
            margin-bottom: 20px;
        }

        .text h1 {
            font-size: 36px;
            color: #2c3e50;
            font-weight: bold;
            margin-bottom: 15px;
            text-align: center;
        }

        .text p {
            font-size: 16px;
            color: #7f8c8d;
            text-align: center;
        }

        .quize-section h3 {
            font-size: 24px;
            color: #34495e;
            margin-bottom: 15px;
            text-align: center;
        }

        .quize-section button {
            padding: 12px 24px;
            background: linear-gradient(to right, #000000, #434343);
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }

        .quize-section button:hover {
            background: linear-gradient(to right, #000000, #434343);
            transform: scale(1.05);
        }

        #quizeOption select {
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }

        .single-block {
            background: black;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            transition: transform 0.3s, background 0.3s;
        }

        .single-block:hover {
            background: #34495e;
            transform: translateY(-5px);
        }

        .single-block .topic {
            font-size: 18px;
            color: #ecf0f1;
            font-weight: bold;
        }

        .quize-score {
            background: #fdfdfd;
            border-radius: 12px;
            /* box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1); */
            padding: 20px;
        }

        .quize-score .heading {
            font-size: 28px;
            color: #2c3e50;
            margin-bottom: 20px;
            font-weight: bold;
            text-align: center;
        }

        .quize-score .score-item {
            font-size: 18px;
            color: #2c3e50;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #ecf0f1;
            padding-bottom: 8px;
        }

        /* Loading animation styles */
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .loading-indicator {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
        }

        .dim-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9998;
        }

        .loading-text {
            position: fixed;
            top: 60%;
            left: 52%;
            transform: translate(-50%, -50%);
            color: #ffffff;
            font-size: 18px;
            z-index: 9999;
            max-width: 300px;
            text-align: center;
            padding: 10px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .text h1 {
                font-size: 28px;
            }

            .quize-section h3 {
                font-size: 20px;
            }

            .quize-section button {
                padding: 10px 20px;
                font-size: 14px;
            }

            .quize-score .heading {
                font-size: 24px;
            }

            .quize-score .score-item {
                font-size: 16px;
            }

            .single-block .topic {
                font-size: 16px;
            }
        }

        @media (max-width: 576px) {
            .text h1 {
                font-size: 24px;
            }

            .quize-section h3 {
                font-size: 18px;
            }

            .quize-section button {
                padding: 8px 16px;
                font-size: 12px;
            }

            .quize-score .heading {
                font-size: 20px;
            }

            .quize-score .score-item {
                font-size: 14px;
            }

            .single-block .topic {
                font-size: 14px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="main-content">
        <div class="mid-section">
            <div class="row">
                <div class="col-md-6">
                    <div class="p-3">
                        <div class="text">
                            <h1>Quiz</h1>
                            <p>Expand your knowledge</p>
                        </div>
                        <div class="quize-section">
                            <h3>Let's get started</h3>
                            <button onclick="selectOption();">Start</button>
                        </div>
                    </div>
                    <div class="p-3" id="option" style="display: none">
                        <div id="quizeOption"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3">
                        <div class="quize-score">
                            <div class="heading">🏆 Your Score</div>
                            @foreach ($userQuizScores as $key=>$score)
                                <div class="score-item">
                                    <strong>{{ ucfirst($score->topic) }}</strong>
                                    <span>
                                        {{ $score->score }}
                                        |
                                        {{ \Carbon\Carbon::parse($score->created_at)->format('Y-m-d') }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        function selectOption() {
            $('#option').show();
            $('#quizeOption').append(`
                <h1>Category</h1>
                <div class="row">
                    @foreach (\App\Helper::questionQption as $option)
                        <div class="col-md-4 mb-2">
                            <div class="single-block">
                                <a style="text-decoration:none" href="{{ route('singlequize', ['option' => $option]) }}" onclick="loadNewQuiz(this.href)">
                                    <div class="topic">{{ ucfirst($option) }}</div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            `);
            $('.quize-section').hide();
        }

        function loadNewQuiz(url) {
            let loadingIndicator = $('<div class="loading-indicator"></div>');
            let dimBackground = $('<div class="dim-background"></div>');
            let loadingText = $('<div class="loading-text">Generating Quiz using AI...</div>');

            $('body').append(dimBackground).append(loadingIndicator).append(loadingText);

            event.preventDefault();
            axios.post(url, {})
                .then(function(res) {
                    window.location.href = res.data;
                })
                .catch(function(err) {
                    if(err){
                        let errorImage = $('<img src="/path/to/bowing-head-image.png" alt="Error" style="width: 100px; height: 100px;">');
                        let errorMessage = $('<div class="loading-text">Failed to load the quiz</div>');
                        $('body').append(errorImage).append(errorMessage);
                    }
                })
                .finally(() => {
                    loadingIndicator.remove();
                    dimBackground.remove();
                    loadingText.remove();
                });
        }
    </script>
@endsection
