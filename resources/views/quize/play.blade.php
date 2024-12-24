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
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .question-block ul li:hover {
            background-color: #e0e0e0;
        }

        .question-block ul li.selected {
            background-color: #4caf50;
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

        .btn-success {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: green;
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
            <h1>{{ json_decode($quizeData->question)->quizTitle }}</h1>
        </div>
        <div class="sub-heading">
            <h2>
                Lets start the quize
            </h2>
        </div>
        @csrf
        <div class="question">
            @php $questions = json_decode($quizeData->question)->questions; @endphp
            @foreach ($questions as $index => $question)
                <div class="question-block" id="question-{{ $index }}"
                    style="{{ $index === 0 ? '' : 'display: none;' }}">
                    <h3>Question {{ $index + 1 }}: {{ $question->question }}</h3>
                    <ul>
                        @foreach ($question->options as $option)
                            <li onclick="selectOption(this)" data-index="{{ $index }}"
                                data-answer="{{ $option }}">
                                {{ $option }}
                            </li>
                        @endforeach
                    </ul>
                    <p id="correctAnswer" style="display:none">
                          {{$question->answer}}
                    </p>
                </div>
            @endforeach
        </div>
        <button type="button" class="btn-primary" id="nextButton" onclick="showNextQuestion()">Next</button>
        <button type="button" class="btn btn-success" id="submitButton" style="display: none"
            onclick="submitForm()">Submit</button>
    </div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js">
</script>
<script>
    let answers = Array({{ count($questions) }}).fill(null);
    let correctAnswers = @json(array_map(fn($q) => $q->answer, $questions));

    function selectOption(selectedOption) {
        const options = selectedOption.parentNode.querySelectorAll('li');
        const questionIndex = selectedOption.dataset.index;
        const selectedAnswer = selectedOption.dataset.answer;
        options.forEach(option => option.classList.remove('selected'));
        selectedOption.classList.add('selected');
        answers[questionIndex] = selectedAnswer;
    }

    function showNextQuestion() {
        const currentQuestion = document.querySelector('.question-block:not([style*="display: none"])');
        const nextQuestion = currentQuestion.nextElementSibling;

        if (nextQuestion && nextQuestion.classList.contains('question-block')) {
            currentQuestion.style.display = 'none';
            nextQuestion.style.display = 'block';
        }
        if (!nextQuestion || !nextQuestion.classList.contains('question-block')) {
            document.getElementById('nextButton').style.display = 'none';
            document.getElementById('submitButton').style.display = 'block';
        }
    }

    function submitForm() {
        const totalQuestions = {{ count($questions) }};
        if (answers.filter(a => a !== null).length === totalQuestions) {
            let score = 0;
            answers.forEach((answer, index) => {
                if (answer === correctAnswers[index]) {
                    score++;
                }
            });

            const data = {
                _token: '{{ csrf_token() }}',
                score: score,
                answers: answers,
            };
            axios.post('{{ route('play', ['quize' => $quize]) }}', data)
                .then(response => {
                    console.log(response.data);
                })
                .catch(error => {
                    console.error(error);
                    alert('An error occurred while submitting the quiz.');
                });
        } else {
            alert('Please answer all questions before submitting.');
        }
    }
</script>

