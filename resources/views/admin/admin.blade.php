@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="display-5 fw-bold">Admin Dashboard</h1>
            <p class="text-muted">Manage your data structure learning platform</p>
        </div>
        <div class="d-flex gap-3">
            <button type="button" class="btn btn-light d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addTopicModal">
                <i class="bi bi-folder-plus me-2"></i>
                New Topic
            </button>
            <button type="button" class="btn btn-light d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addLessonModal">
                <i class="bi bi-plus-lg me-2"></i>
                New Lesson
            </button>
            <button type="button" class="btn btn-light d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#createTestModal">
                <i class="bi bi-plus-lg me-2"></i>
                New Test
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <!-- Total Users Card -->
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary p-3 rounded-3 me-3">
                            <i class="bi bi-people-fill text-white fs-4"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle mb-1 text-muted">Total Users</h6>
                            <h2 class="card-title mb-0">{{ $totalUsers }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Topics Card -->
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-success p-3 rounded-3 me-3">
                            <i class="bi bi-folder-fill text-white fs-4"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle mb-1 text-muted">Total Topics</h6>
                            <h2 class="card-title mb-0">{{ $totalTopics }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Lessons Card -->
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-info p-3 rounded-3 me-3">
                            <i class="bi bi-book-fill text-white fs-4"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle mb-1 text-muted">Active Lessons</h6>
                            <h2 class="card-title mb-0">{{ $activeLessons }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Completed Tests Card -->
        <div class="col-md-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning p-3 rounded-3 me-3">
                            <i class="bi bi-check2-square text-white fs-4"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle mb-1 text-muted">Completed Tests</h6>
                            <h2 class="card-title mb-0">{{ $completedTests }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h3 class="card-title mb-4">Recent Activities</h3>
            <div class="position-relative activity-timeline">
                @foreach($recentActivities as $activity)
                    <div class="d-flex mb-4">
                        <div class="timeline-icon">
                            <div class="bg-{{ $activity['type'] === 'lesson' ? 'info' : 'warning' }} rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="bi bi-{{ $activity['type'] === 'lesson' ? 'book' : 'check2-square' }} text-white"></i>
                            </div>
                        </div>
                        <div class="ms-3 flex-grow-1">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">{{ $activity['description'] }}</h6>
                                <small class="text-muted">{{ $activity['created_at']->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h3 class="card-title mb-4">Quick Actions</h3>
                    <div class="list-group">
                        <a href="{{ route('users.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="bi bi-people me-3"></i>
                            Manage Users
                        </a>
                        <a href="{{ route('topics.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="bi bi-folder me-3"></i>
                            Manage Topics
                        </a>
                        <a href="{{ route('lessons.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="bi bi-book me-3"></i>
                            Manage Lessons
                        </a>
                        <a href="{{ route('tests.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="bi bi-check2-square me-3"></i>
                            Manage Tests
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h3 class="card-title mb-4">System Status</h3>
                    <div class="list-group">
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="bi bi-hdd-stack me-2 text-success"></i>
                                System Status
                            </div>
                            <span class="badge bg-success rounded-pill">Active</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="bi bi-clock-history me-2 text-info"></i>
                                Last Backup
                            </div>
                            <span class="text-muted">{{ now()->subHours(2)->diffForHumans() }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="bi bi-speedometer2 me-2 text-primary"></i>
                                Server Load
                            </div>
                            <div class="progress" style="width: 100px;">
                                <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Add Topic Modal -->
<div class="modal fade" id="addTopicModal" tabindex="-1" aria-labelledby="addTopicModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTopicModalLabel">Add New Topic</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('topics.store') }}" method="POST" id="addTopicForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-4">
                        <label for="name" class="form-label">Topic Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="order" class="form-label">Display Order</label>
                        <input type="number" class="form-control" id="order" name="order" min="1" value="1">
                        <div class="form-text">Order in which the topic will be displayed (1 being first)</div>
                    </div>

                    <div class="mb-4">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="active">Active</option>
                            <option value="draft">Draft</option>
                            <option value="archived">Archived</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Topic</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Lesson Modal -->
<div class="modal fade" id="addLessonModal" tabindex="-1" aria-labelledby="addLessonModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLessonModalLabel">Add New Lesson</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('lessons.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-4">
                        <label for="title" class="form-label">Lesson Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>

                    <div class="mb-4">
                        <label for="topic_id" class="form-label">Topic</label>
                        <select class="form-select" id="topic_id" name="topic_id" required>
                            <option value="">Select a topic</option>
                            @foreach($topics as $topic)
                                <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="content" class="form-label">Lesson Content</label>
                        <textarea class="form-control" id="content" name="content" rows="6" required></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="difficulty_level" class="form-label">Difficulty Level</label>
                                <select class="form-select" id="difficulty_level" name="difficulty_level" required>
                                    <option value="beginner">Beginner</option>
                                    <option value="intermediate">Intermediate</option>
                                    <option value="advanced">Advanced</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="estimated_time" class="form-label">Estimated Time (minutes)</label>
                                <input type="number" class="form-control" id="estimated_time" name="estimated_time" required min="1">
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="attachment" class="form-label">Attachments (optional)</label>
                        <input type="file" class="form-control" id="attachment" name="attachment">
                        <div class="form-text">Upload any supplementary materials (PDF, images, etc.)</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Lesson</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Test Creation Modal -->
<div class="modal fade" id="createTestModal" tabindex="-1" aria-labelledby="createTestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createTestModalLabel">Create New Test</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="testForm" action="{{ route('admin.tests.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="topic_id" class="form-label">Topic</label>
                        <select class="form-select" id="topic_id" name="topic_id" required>
                            @foreach($topics as $topic)
                                <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-label">Test Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="time_limit" class="form-label">Time Limit (minutes)</label>
                                <input type="number" class="form-control" id="time_limit" name="time_limit" value="30" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="passing_score" class="form-label">Passing Score (%)</label>
                                <input type="number" class="form-control" id="passing_score" name="passing_score" value="70" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="difficulty" class="form-label">Difficulty</label>
                                <select class="form-select" id="difficulty" name="difficulty" required>
                                    <option value="beginner">Beginner</option>
                                    <option value="intermediate">Intermediate</option>
                                    <option value="advanced">Advanced</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="questionsContainer">
                        <!-- Questions will be added here dynamically -->
                    </div>
                    <button type="button" class="btn btn-secondary" onclick="addQuestion()">Add Question</button>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Create Test</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize any rich text editors if needed
    if (typeof tinymce !== 'undefined') {
        tinymce.init({
            selector: '#content',
            height: 300,
            plugins: 'lists link image code table',
            toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | link image | code'
        });
    }

    // Form validation and submission
    const form = document.querySelector('#addLessonModal form');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Perform validation
        const title = document.getElementById('title').value.trim();
        const topic = document.getElementById('topic_id').value;
        const description = document.getElementById('description').value.trim();
        const content = document.getElementById('content').value.trim();
        
        if (!title || !topic || !description || !content) {
            showAlert('Please fill in all required fields', 'danger', form);
            return;
        }
        
        // If validation passes, submit the form
        const formData = new FormData(this);
        
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert(data.message, 'success', form);
                const modal = bootstrap.Modal.getInstance(document.getElementById('addLessonModal'));
                modal.hide();
                form.reset();
                // Optionally reload the page or update the lessons list
                setTimeout(() => window.location.reload(), 1500);
            } else {
                showAlert(data.message || 'Error creating lesson', 'danger', form);
            }
        })
        .catch(error => {
            showAlert('Error creating lesson: ' + error.message, 'danger', form);
        });
    });

    // Reset form when modal is closed
    const modal = document.getElementById('addLessonModal');
    modal.addEventListener('hidden.bs.modal', function() {
        form.reset();
        clearAlerts(form);
    });

    // Add Topic Form Handling
    const topicForm = document.querySelector('#addTopicForm');
    if (topicForm) {
        topicForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Perform validation
            const name = document.getElementById('name').value.trim();
            const description = document.getElementById('description').value.trim();
            
            if (!name || !description) {
                showAlert('Please fill in all required fields', 'danger', topicForm);
                return;
            }
            
            // If validation passes, submit the form
            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert(data.message, 'success', topicForm);
                    const modal = bootstrap.Modal.getInstance(document.getElementById('addTopicModal'));
                    modal.hide();
                    topicForm.reset();
                    // Reload the page to update the topics list
                    setTimeout(() => window.location.reload(), 1500);
                } else {
                    showAlert(data.message || 'Error creating topic', 'danger', topicForm);
                }
            })
            .catch(error => {
                showAlert('Error creating topic: ' + error.message, 'danger', topicForm);
            });
        });

        // Reset form when modal is closed
        const topicModal = document.getElementById('addTopicModal');
        topicModal.addEventListener('hidden.bs.modal', function() {
            topicForm.reset();
            clearAlerts(topicForm);
        });
    }

    let questionCount = 0;

    function addQuestion() {
        questionCount++;
        const questionHtml = `
            <div class="question-block border rounded p-3 mb-3">
                <h5>Question ${questionCount}</h5>
                <div class="mb-3">
                    <label class="form-label">Question Text</label>
                    <textarea class="form-control" name="questions[${questionCount}][question]" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Option A</label>
                    <input type="text" class="form-control" name="questions[${questionCount}][options][]" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Option B</label>
                    <input type="text" class="form-control" name="questions[${questionCount}][options][]" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Option C</label>
                    <input type="text" class="form-control" name="questions[${questionCount}][options][]" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Correct Answer</label>
                    <select class="form-select" name="questions[${questionCount}][correct_answer]" required>
                        <option value="0">Option A</option>
                        <option value="1">Option B</option>
                        <option value="2">Option C</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Points</label>
                    <input type="number" class="form-control" name="questions[${questionCount}][points]" value="1" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Explanation</label>
                    <textarea class="form-control" name="questions[${questionCount}][explanation]"></textarea>
                </div>
                <button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.remove()">Remove Question</button>
            </div>
        `;
        document.getElementById('questionsContainer').insertAdjacentHTML('beforeend', questionHtml);
    }

    // Test form submission handling
    const testForm = document.getElementById('testForm');
    if (testForm) {
        testForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: new FormData(this),
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const result = await response.json();

                if (response.ok) {
                    showAlert('Test created successfully!', 'success', this);
                    this.reset();
                    document.getElementById('questionsContainer').innerHTML = '';
                    questionCount = 0;
                    
                    // Close the modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('createTestModal'));
                    modal.hide();
                    
                    // Optionally refresh the page or update the tests list
                    // window.location.reload();
                } else {
                    throw new Error(result.message || 'Error creating test');
                }
            } catch (error) {
                showAlert(error.message, 'danger', this);
            }
        });
    }

    // Alert functions
    function showAlert(message, type, form) {
        clearAlerts(form);
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        form.insertBefore(alertDiv, form.firstChild);
    }

    function clearAlerts(form) {
        const alerts = form.querySelectorAll('.alert');
        alerts.forEach(alert => alert.remove());
    }
});
</script>
@endpush

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show position-fixed top-0 end-0 m-3" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif