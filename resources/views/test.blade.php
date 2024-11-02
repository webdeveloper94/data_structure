<x-main>


<form action="{{ route('test.store') }}" method="POST">
    @csrf
    @foreach ($questions as $question)
        <div>
            <h4>{{ $question->question }}</h4>
            <input type="radio" name="answers[{{ $question->id }}]" value="a"> {{ $question->option_a }}<br>
            <input type="radio" name="answers[{{ $question->id }}]" value="b"> {{ $question->option_b }}<br>
            <input type="radio" name="answers[{{ $question->id }}]" value="c"> {{ $question->option_c }}<br>
        </div>
    @endforeach
    <button type="submit">Submit</button>
</form>
</x-main>
