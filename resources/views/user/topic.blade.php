<x-main>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-4">{{ $topic->title }}</h1>
                <p class="lead">{{ $topic->description }}</p>
            </div>
        </div>

        <div class="row mt-4">
            @foreach($topic->lessons as $lesson)
                @if($lesson->status === 'published')
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">{{ $lesson->title }}</h5>
                                <p class="card-text">{{ Str::limit($lesson->content, 100) }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{ route('user.lessons.show', $lesson->id) }}" class="btn btn-primary">
                                        <i class="bi bi-book-half"></i> Darsni ko'rish
                                    </a>
                                    @if($lesson->labs->count() > 0)
                                        <a href="{{ route('user.labs.index', ['lesson' => $lesson->id]) }}" class="btn btn-info">
                                            <i class="bi bi-journal-code"></i> Laboratoriya
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</x-main>
