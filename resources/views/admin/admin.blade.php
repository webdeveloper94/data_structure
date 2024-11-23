@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="display-5 fw-bold">Adminstrator sahifasi</h1>
            <p class="text-muted">Ma'lumotlar tuzilmangizni o'rganish platformasini boshqarish</p>
        </div>
        <div class="d-flex gap-3">
            <button type="button" class="btn btn-light d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addTopicModal">
                <i class="bi bi-folder-plus me-2"></i>
                Yangi dars
            </button>
            <button type="button" class="btn btn-light d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addLessonModal">
                <i class="bi bi-plus-lg me-2"></i>
                Yangi mavzu
            </button>
            <button type="button" class="btn btn-light d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#createTestModal">
                <i class="bi bi-plus-lg me-2"></i>
                Yangi test
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
                            <a href="{{ route('admin.users.index') }}" class="text-decoration-none">
                                <h6 class="card-subtitle mb-1 text-muted">Foydalanuvchilar</h6>
                                <h2 class="card-title mb-0">{{ $totalUsers }}</h2>
                            </a>
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
                            <h6 class="card-subtitle mb-1 text-muted">Darslar</h6>
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
                            <h6 class="card-subtitle mb-1 text-muted">Mavzular</h6>
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
                            <h6 class="card-subtitle mb-1 text-muted">Testlar</h6>
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
            <h3 class="card-title mb-4">Oxirgi amallar</h3>
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
                    <h3 class="card-title mb-4">Boshqaruv paneli</h3>
                    <div class="list-group">
                        <a href="{{ route('admin.users.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="bi bi-people me-3"></i>
                            Foydalanuvchilarni boshqarish
                        </a>
                        <a href="{{ route('admin.topics.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="bi bi-folder me-3"></i>
                            Darslarni ko'rish
                        </a>
                        <a href="{{ route('admin.lessons.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="bi bi-book me-3"></i>
                            Mavzularni ko'rish
                        </a>
                        <a href="{{ route('admin.tests.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="bi bi-check2-square me-3"></i>
                            Testlarni ko'rish
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
            <form action="{{ route('admin.topics.store') }}" method="POST" id="addTopicForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-4">
                        <label for="name" class="form-label">Topic Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
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
            <form action="{{ route('admin.lessons.store') }}" method="POST" enctype="multipart/form-data" id="addLessonForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-4">
                        <label for="title" class="form-label">Lesson Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>

                    <div class="mb-4">
                        <label for="topic_id" class="form-label">Topic <span class="text-danger">*</span></label>
                        <select class="form-select" id="topic_id" name="topic_id" required>
                            <option value="">Select a topic</option>
                            @foreach($topics as $topic)
                                <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="content" class="form-label">Lesson Content <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="content" name="content" rows="6" required></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="order" class="form-label">Order <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="order" name="order" min="1" value="1" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="">Select status</option>
                                    <option value="draft">Draft</option>
                                    <option value="published">Published</option>
                                    <option value="archived">Archived</option>
                                </select>
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Lesson</button>
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
                <h5 class="modal-title" id="createTestModalLabel">Yangi test qo'shish</h5>
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
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="time_limit" class="form-label">Time Limit (minutes)</label>
                                <input type="number" class="form-control" id="time_limit" name="time_limit" value="30" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="passing_score" class="form-label">Passing Score (%)</label>
                                <input type="number" class="form-control" id="passing_score" name="passing_score" value="70" required>
                            </div>
                        </div>
                    </div>

                    <!-- Questions Section -->
                    <div id="questions-container">
                        <h4 class="mt-4 mb-3">Questions</h4>
                        <div class="question-block border rounded p-3 mb-3">
                            <div class="mb-3">
                                <label class="form-label">Question 1</label>
                                <input type="text" class="form-control" name="questions[0][text]" required placeholder="Enter question">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Options</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-text">
                                        <input type="radio" name="questions[0][correct_option]" value="a" required>
                                    </div>
                                    <input type="text" class="form-control" name="questions[0][options][a]" placeholder="Option A" required>
                                </div>
                                <div class="input-group mb-2">
                                    <div class="input-group-text">
                                        <input type="radio" name="questions[0][correct_option]" value="b" required>
                                    </div>
                                    <input type="text" class="form-control" name="questions[0][options][b]" placeholder="Option B" required>
                                </div>
                                <div class="input-group mb-2">
                                    <div class="input-group-text">
                                        <input type="radio" name="questions[0][correct_option]" value="c" required>
                                    </div>
                                    <input type="text" class="form-control" name="questions[0][options][c]" placeholder="Option C" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-outline-primary mb-3" onclick="addNewQuestion()">
                        <i class="bi bi-plus-circle me-2"></i>Add Question
                    </button>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create Test</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let questionCount = 0;

function addNewQuestion() {
    questionCount++;
    const questionHtml = `
        <div class="question-block border rounded p-3 mb-3">
            <div class="mb-3">
                <label class="form-label">Question ${questionCount + 1}</label>
                <input type="text" class="form-control" name="questions[${questionCount}][text]" required placeholder="Enter question">
            </div>
            <div class="mb-2">
                <label class="form-label">Options</label>
                <div class="input-group mb-2">
                    <div class="input-group-text">
                        <input type="radio" name="questions[${questionCount}][correct_option]" value="a" required>
                    </div>
                    <input type="text" class="form-control" name="questions[${questionCount}][options][a]" placeholder="Option A" required>
                </div>
                <div class="input-group mb-2">
                    <div class="input-group-text">
                        <input type="radio" name="questions[${questionCount}][correct_option]" value="b" required>
                    </div>
                    <input type="text" class="form-control" name="questions[${questionCount}][options][b]" placeholder="Option B" required>
                </div>
                <div class="input-group mb-2">
                    <div class="input-group-text">
                        <input type="radio" name="questions[${questionCount}][correct_option]" value="c" required>
                    </div>
                    <input type="text" class="form-control" name="questions[${questionCount}][options][c]" placeholder="Option C" required>
                </div>
            </div>
            <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeQuestion(this)">
                <i class="bi bi-trash me-2"></i>Remove Question
            </button>
        </div>
    `;
    document.getElementById('questions-container').insertAdjacentHTML('beforeend', questionHtml);
}

function removeQuestion(button) {
    const questionBlock = button.closest('.question-block');
    questionBlock.remove();
    updateQuestionNumbers();
}

function updateQuestionNumbers() {
    const questions = document.querySelectorAll('.question-block');
    questions.forEach((question, index) => {
        const label = question.querySelector('.form-label');
        label.textContent = `Question ${index + 1}`;
        
        // Update input names
        const questionInput = question.querySelector('input[name^="questions"][name$="[text]"]');
        const optionInputs = question.querySelectorAll('input[name^="questions"][name*="options"]');
        const radioInputs = question.querySelectorAll('input[type="radio"]');
        
        questionInput.name = `questions[${index}][text]`;
        optionInputs.forEach(input => {
            const option = input.name.match(/\[options\]\[([abc])\]/)[1];
            input.name = `questions[${index}][options][${option}]`;
        });
        radioInputs.forEach(radio => {
            radio.name = `questions[${index}][correct_option]`;
        });
    });
}

document.addEventListener('DOMContentLoaded', function() {
    // Initialize any rich text editors if needed
    let contentEditor;
    if (typeof tinymce !== 'undefined') {
        tinymce.init({
            selector: '#content',
            height: 300,
            plugins: 'lists link image code table',
            toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | link image | code',
            setup: function(editor) {
                contentEditor = editor;
                editor.on('change', function() {
                    editor.save(); // Save content to textarea
                });
            }
        });
    }

    function showAlert(message, type, container) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        container.insertBefore(alertDiv, container.firstChild);
        
        // Auto dismiss after 5 seconds
        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    }

    // Form validation and submission
    const form = document.querySelector('#addLessonModal form');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Clear previous alerts
        form.querySelectorAll('.alert').forEach(alert => alert.remove());
        
        // Get form values
        const title = document.getElementById('title').value.trim();
        const topic = document.getElementById('topic_id').value.trim();
        const order = document.getElementById('order').value.trim();
        const status = document.getElementById('status').value.trim();
        let content = '';
        
        console.log('Form Values:', {
            title,
            topic,
            order,
            status,
        });
        
        // Get content from TinyMCE if it's initialized
        if (contentEditor) {
            content = contentEditor.getContent().trim();
            // Update the textarea with the current content
            document.getElementById('content').value = content;
        } else {
            content = document.getElementById('content').value.trim();
        }
        
        // Validate all required fields
        const errors = [];
        if (!title) errors.push('Title is required');
        if (!topic) errors.push('Topic is required');
        if (!content) errors.push('Content is required');
        if (!order) errors.push('Order is required');
        if (order && (isNaN(order) || parseInt(order) < 1)) errors.push('Order must be a number greater than 0');
        if (!status) errors.push('Status is required');
        // if (status && !['draft', 'published', 'archived'].includes(status)) {
        //     console.error('Invalid status:', status);
        //     console.error('Expected: draft, published, or archived');
        //     errors.push('Invalid status value');
        // }
        
        if (errors.length > 0) {
            showAlert(errors.join('<br>'), 'danger', form);
            return;
        }
        
        // Show loading state
        const submitButton = form.querySelector('[type="submit"]');
        const originalButtonText = submitButton.innerHTML;
        submitButton.disabled = true;
        submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...';
        
        // If validation passes, submit the form
        const formData = new FormData(this);
        
        // Log form data for debugging
        console.log('Form Data:');
        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }
        
        // Ensure content is included in form data
        if (contentEditor) {
            formData.set('content', content);
        }
        
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            credentials: 'same-origin'
        })
        .then(response => response.json().then(data => {
            console.log('Server Response:', data);
            if (!response.ok) {
                if (data.error) {
                    console.error('Server Error:', data.error);
                    console.error('Stack Trace:', data.trace);
                }
                throw new Error(data.message || 'An error occurred while saving the lesson');
            }
            return data;
        }))
        .then(data => {
            showAlert(data.message || 'Lesson created successfully!', 'success', form);
            const modal = bootstrap.Modal.getInstance(document.getElementById('addLessonModal'));
            modal.hide();
            // Reload the page after a short delay
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        })
        .catch(error => {
            showAlert(error.message || 'An error occurred while saving the lesson', 'danger', form);
        })
        .finally(() => {
            // Reset button state
            submitButton.disabled = false;
            submitButton.innerHTML = originalButtonText;
        });
    });

    // Reset form when modal is hidden
    const addLessonModal = document.getElementById('addLessonModal');
    addLessonModal.addEventListener('hidden.bs.modal', function() {
        form.reset();
        form.querySelectorAll('.alert').forEach(alert => alert.remove());
        if (contentEditor) {
            contentEditor.setContent('');
        }
    });

    // Add Topic Form Handling
    const topicForm = document.querySelector('#addTopicForm');
    if (topicForm) {
        topicForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Perform validation
            const name = document.getElementById('name').value.trim();
            const description = document.getElementById('description').value.trim();
            
            if (!name) {
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
            topicForm.querySelectorAll('.alert').forEach(alert => alert.remove());
        });
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
                    document.getElementById('questions-container').innerHTML = '';
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
    function showAlert(message, type, container) {
        clearAlerts(container);
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        container.insertBefore(alertDiv, container.firstChild);
        
        // Auto dismiss after 5 seconds
        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    }

    function clearAlerts(container) {
        const alerts = container.querySelectorAll('.alert');
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