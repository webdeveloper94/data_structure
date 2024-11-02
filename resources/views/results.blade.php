<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Dasturi</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="container mt-5">
            <h2 class="text-center">Test Natijalari</h2>
            <div class="card shadow-lg p-4 mb-4">
                <h4>To'g'ri javoblar: <span class="text-success">{{ $result->correct_answers }}</span></h4>
                <h4>Xato javoblar: <span class="text-danger">{{ $result->wrong_answers }}</span></h4>
        
                <h4 class="mt-4">Sizning javoblaringiz:</h4>
                <ul class="list-group">
                    @foreach (json_decode($result->user_answers) as $questionId => $userAnswer)
                        @php
                            $question = \App\Models\Question::find($questionId);
                        @endphp
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $question->question }}
                            <span class="badge {{ $userAnswer === $question->correct_option ? 'bg-success' : 'bg-danger' }}">
                                {{ $userAnswer }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>
        
            <div class="text-center">
                <a href="{{ route('test.index') }}" class="btn btn-primary">Bosh sahifaga qaytish</a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>