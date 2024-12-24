@extends('layout.app')

@section('css')
    <style>
        .main-content {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .heading {
            text-align: center;
            margin-bottom: 20px;
        }

        .heading h1 {
            font-size: 24px;
            color: #333;
        }

        .question {
            margin-top: 20px;
        }

        .question-block {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 6px;
            margin-bottom: 20px;
            padding: 15px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .question-block h3 {
            font-size: 18px;
            color: #444;
            margin-bottom: 10px;
        }

        .question-block ul {
            list-style: none;
            padding: 0;
        }

        .question-block ul li {
            background-color: #f0f0f0;
            margin: 5px 0;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .question-block ul li:hover {
            background-color: #e0e0e0;
        }

        .question-block p {
            margin-top: 10px;
            font-size: 14px;
            color: #555;
        }

        .question-block p strong {
            color: #000;
        }

        .question-block ul {
            list-style: none;
            padding: 0;
        }

        .question-block ul li {
            background-color: #f0f0f0;
            margin: 5px 0;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .question-block ul li:hover {
            background-color: #e0e0e0;
        }

        .question-block ul li.selected {
            background-color: #4caf50;
            /* Green */
            color: white;
        }

        .btn-primary {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
@endsection

@section('content')
    <div class="main-content" style="margin-top: 20px;">
        <div class="heading">
            <h1>{{ $quize['title'] ?? $topic }}</h1>
        </div>
        <form id="quizForm" method="POST">
            @csrf
            <div class="question">
                @foreach ($quize['questions'] as $index => $question)
                    <div class="question-block">
                        <h3>Question {{ $index + 1 }}: {{ $question['question'] }}</h3>
                        <ul>
                            @foreach ($question['options'] as $option)
                                <li onclick="selectOption(this)">{{ $option }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
            <button type="button" class="btn-primary" onclick="submitForm()">Confirm</button>
        </form>

        <script></script>
    </div>
@endsection
@section('js')
    <script>
        function selectOption(selectedOption) {
            const options = selectedOption.parentNode.querySelectorAll('li');
            options.forEach(option => option.classList.remove('selected'));
            selectedOption.classList.add('selected');
        }
        function submitForm() {
            const selectedOptions = document.querySelectorAll('.question-block .selected');
            if (selectedOptions.length === {{ count($quize['questions']) }}) {
                const formData = new FormData(document.getElementById('quizForm'));

                axios.post('singlequize', formData)
                    .then(response => {
                        alert('Selections confirmed!');
                        console.log(response.data);
                    })
                    .catch(error => {
                        console.error(error);
                        alert('An error occurred while submitting the quiz.');
                    });
            } else {
                alert('Please answer all questions before confirming.');
            }
        }
    </script>
@endsection
