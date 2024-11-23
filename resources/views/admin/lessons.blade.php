@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Manage Lessons</span>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLessonModal">
                        <i class="bi bi-plus-lg"></i> Add Lesson
                    </button>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Topic</th>
                                    <th>Order</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lessons as $lesson)
                                    <tr>
                                        <td>{{ $lesson->title }}</td>
                                        <td>{{ $lesson->topic->name }}</td>
                                        <td>{{ $lesson->order }}</td>
                                        <td>
                                            <span class="badge bg-{{ $lesson->status === 'published' ? 'success' : 'warning' }}">
                                                {{ ucfirst($lesson->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $lesson->created_at->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.labs.index', $lesson) }}" class="btn btn-sm btn-info" title="Manage Labs">
                                                    <i class="bi bi-journal-code"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-primary edit-btn" 
                                                    data-lesson-id="{{ $lesson->id }}"
                                                    data-lesson-title="{{ $lesson->title }}"
                                                    data-lesson-content="{!! htmlspecialchars($lesson->content, ENT_QUOTES, 'UTF-8') !!}"
                                                    data-lesson-topic-id="{{ $lesson->topic_id }}"
                                                    data-lesson-order="{{ $lesson->order }}"
                                                    data-lesson-status="{{ $lesson->status }}">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger delete-btn" 
                                                    data-lesson-id="{{ $lesson->id }}"
                                                    data-lesson-title="{{ $lesson->title }}">
                                                    <i class="bi bi-trash"></i> Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{ $lessons->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Lesson Modal -->
<div class="modal fade" id="addLessonModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Lesson</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addLessonForm" novalidate>
                    @csrf
                    <div class="alert alert-danger" id="formErrors" style="display: none;"></div>
                    
                    <div class="mb-3">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" required>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Topic <span class="text-danger">*</span></label>
                        <select name="topic_id" class="form-select" required>
                            <option value="">Select Topic</option>
                            @foreach($topics as $topic)
                                <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Content <span class="text-danger">*</span></label>
                        <textarea name="content" id="addLessonContent" class="form-control" required></textarea>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Order <span class="text-danger">*</span></label>
                                <input type="number" name="order" class="form-control" min="1" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-select" required>
                                    <option value="">Select Status</option>
                                    <option value="draft">Draft</option>
                                    <option value="published">Published</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="submitAddLesson">Add Lesson</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Lesson Modal -->
<div class="modal fade" id="editLessonModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editLessonForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Lesson</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" id="editLessonTitle" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Topic</label>
                        <select name="topic_id" id="editLessonTopic" class="form-select" required>
                            <option value="">Select Topic</option>
                            @foreach($topics as $topic)
                                <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Content</label>
                        <textarea name="content" id="editLessonContent" class="form-control" rows="10" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Order</label>
                                <input type="number" name="order" id="editLessonOrder" class="form-control" min="1" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" id="editLessonStatus" class="form-select" required>
                                    <option value="draft">Draft</option>
                                    <option value="published">Published</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Lesson Modal -->
<div class="modal fade" id="deleteLessonModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="deleteLessonForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title">Delete Lesson</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete the lesson "<span id="deleteLessonTitle"></span>"?</p>
                    <p class="text-danger">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete Lesson</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let addLessonEditor;

    // Initialize TinyMCE for content editors
    if (typeof tinymce !== 'undefined') {
        tinymce.init({
            selector: '#addLessonContent',
            height: 300,
            plugins: 'advlist autolink lists link image charmap preview anchor',
            toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | link image',
            setup: function (editor) {
                addLessonEditor = editor;
                editor.on('change', function () {
                    editor.save();
                    validateField(document.getElementById('addLessonContent'));
                });
            }
        });
    }

    // Function to validate a single field
    function validateField(field) {
        const value = field.tagName.toLowerCase() === 'textarea' && addLessonEditor ? 
            addLessonEditor.getContent().replace(/<[^>]*>/g, '').trim() : 
            field.value.trim();
        
        let isValid = true;
        let errorMessage = '';

        if (field.hasAttribute('required') && !value) {
            isValid = false;
            errorMessage = `${field.previousElementSibling.textContent.replace('*', '').trim()} is required.`;
        }

        if (field.name === 'order' && value) {
            const orderNum = parseInt(value);
            if (isNaN(orderNum) || orderNum < 1) {
                isValid = false;
                errorMessage = 'Order must be a number greater than 0.';
            }
        }

        if (field.name === 'status' && value && !['draft', 'published'].includes(value)) {
            isValid = false;
            errorMessage = 'Please select a valid status.';
        }

        if (!isValid) {
            showFieldError(field, errorMessage);
        } else {
            clearFieldError(field);
        }

        return { isValid, errorMessage };
    }

    // Function to show field error
    function showFieldError(field, message) {
        field.classList.add('is-invalid');
        const feedbackElement = field.nextElementSibling;
        if (feedbackElement && feedbackElement.classList.contains('invalid-feedback')) {
            feedbackElement.textContent = message;
            feedbackElement.style.display = 'block';
        }
    }

    // Function to clear field error
    function clearFieldError(field) {
        field.classList.remove('is-invalid');
        const feedbackElement = field.nextElementSibling;
        if (feedbackElement && feedbackElement.classList.contains('invalid-feedback')) {
            feedbackElement.textContent = '';
            feedbackElement.style.display = 'none';
        }
    }

    // Function to show form errors
    function showFormErrors(errors, message = null) {
        const errorDiv = document.getElementById('formErrors');
        if (!errors) {
            errorDiv.style.display = 'none';
            errorDiv.innerHTML = '';
            return;
        }

        let errorHtml = message ? `<p>${message}</p>` : '';
        if (typeof errors === 'string') {
            errorHtml += `<p>${errors}</p>`;
        } else if (Array.isArray(errors)) {
            errorHtml += '<ul class="mb-0">';
            errors.forEach(error => errorHtml += `<li>${error}</li>`);
            errorHtml += '</ul>';
        } else if (typeof errors === 'object') {
            errorHtml += '<ul class="mb-0">';
            Object.values(errors).flat().forEach(error => errorHtml += `<li>${error}</li>`);
            errorHtml += '</ul>';
        }
        
        errorDiv.innerHTML = errorHtml;
        errorDiv.style.display = 'block';
        
        // Scroll to error messages
        errorDiv.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    // Add event listeners for real-time validation
    const form = document.getElementById('addLessonForm');
    form.querySelectorAll('input[required], select[required]').forEach(field => {
        field.addEventListener('blur', () => validateField(field));
        field.addEventListener('change', () => validateField(field));
    });

    // Get CSRF token from meta tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    // Add Lesson submission
    document.getElementById('submitAddLesson').addEventListener('click', async function(e) {
        e.preventDefault();
        
        showFormErrors(null); // Clear previous errors
        
        // Validate all fields
        let isValid = true;
        const errorMessages = [];
        
        // Validate regular form fields
        form.querySelectorAll('input[required], select[required]').forEach(field => {
            const result = validateField(field);
            if (!result.isValid) {
                isValid = false;
                errorMessages.push(result.errorMessage);
            }
        });
        
        // Validate TinyMCE content
        if (addLessonEditor) {
            const content = addLessonEditor.getContent().replace(/<[^>]*>/g, '').trim();
            if (!content) {
                isValid = false;
                errorMessages.push('Content is required');
                showFieldError(document.getElementById('addLessonContent'), 'Content is required');
            }
        }

        // Check status field
        const statusField = form.querySelector('select[name="status"]');
        if (!statusField.value) {
            isValid = false;
            errorMessages.push('Status is required');
            showFieldError(statusField, 'Status is required');
        }

        if (!isValid) {
            showFormErrors(errorMessages, 'Please fill in all required fields.');
            return;
        }

        // Show loading state
        const submitButton = this;
        submitButton.disabled = true;
        submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Adding...';

        try {
            // Prepare form data
            const formData = new FormData(form);
            
            // Add TinyMCE content
            if (addLessonEditor) {
                formData.set('content', addLessonEditor.getContent());
            }
            
            // Add CSRF token
            formData.set('_token', csrfToken);

            // Submit form
            const response = await fetch('{{ route("admin.lessons.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin',
                body: formData
            });

            const data = await response.json();

            if (!response.ok) {
                if (response.status === 422 && data.errors) {
                    // Handle validation errors
                    Object.entries(data.errors).forEach(([field, messages]) => {
                        const input = form.querySelector(`[name="${field}"]`);
                        if (input) {
                            showFieldError(input, messages[0]);
                        }
                    });
                    showFormErrors(data.errors, data.message || 'Please correct the errors below.');
                    return;
                }
                throw new Error(data.message || 'An error occurred');
            }

            // Success - reload the page
            window.location.reload();
        } catch (error) {
            showFormErrors(error.message || 'An error occurred while saving the lesson.');
        } finally {
            // Reset button state
            submitButton.disabled = false;
            submitButton.innerHTML = 'Add Lesson';
        }
    });

    // Reset form and errors when modal is hidden
    const addLessonModal = document.getElementById('addLessonModal');
    addLessonModal.addEventListener('hidden.bs.modal', function () {
        form.reset();
        showFormErrors(null);
        form.querySelectorAll('.is-invalid').forEach(field => clearFieldError(field));
        if (addLessonEditor) {
            addLessonEditor.setContent('');
        }
    });
});
</script>
@endpush
