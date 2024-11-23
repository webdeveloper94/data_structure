@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Tests Management</h3>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTestModal">
                        <i class="bi bi-plus-lg"></i> Add Test
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Topic</th>
                                    <th>Questions</th>
                                    <th>Time Limit</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tests as $test)
                                <tr>
                                    <td>{{ $test->id }}</td>
                                    <td>{{ $test->title }}</td>
                                    <td>{{ $test->topic->name }}</td>
                                    <td>{{ $test->questions_count }}</td>
                                    <td>{{ $test->time_limit }} minutes</td>
                                    <td>
                                        <span class="badge bg-{{ $test->status === 'active' ? 'success' : 'secondary' }}">
                                            {{ $test->status }}
                                        </span>
                                    </td>
                                    <td>{{ $test->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-info view-results" data-test-id="{{ $test->id }}" title="View Results">
                                                <i class="bi bi-bar-chart"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-primary edit-test" data-test-id="{{ $test->id }}" title="Edit Test">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger delete-test" data-test-id="{{ $test->id }}" title="Delete Test">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $tests->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Test Modal -->
<div class="modal fade" id="editTestModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Test</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editTestForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="edit_title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_topic_id" class="form-label">Topic</label>
                        <select class="form-select" id="edit_topic_id" name="topic_id" required>
                            @foreach($topics as $topic)
                            <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Description</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_time_limit" class="form-label">Time Limit (minutes)</label>
                        <input type="number" class="form-control" id="edit_time_limit" name="time_limit" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_status" class="form-label">Status</label>
                        <select class="form-select" id="edit_status" name="status" required>
                            <option value="draft">Draft</option>
                            <option value="active">Active</option>
                            <option value="archived">Archived</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Test Results Modal -->
<div class="modal fade" id="testResultsModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Test Results</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table" id="resultsTable">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Score</th>
                                <th>Time Taken</th>
                                <th>Status</th>
                                <th>Completed At</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Test Modal -->
<div class="modal fade" id="deleteTestModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Test</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this test? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteTestForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Edit Test
    const editButtons = document.querySelectorAll('.edit-test');
    const editForm = document.getElementById('editTestForm');
    const editModal = new bootstrap.Modal(document.getElementById('editTestModal'));

    editButtons.forEach(button => {
        button.addEventListener('click', async function() {
            const testId = this.dataset.testId;
            try {
                const response = await fetch(`/admin/tests/${testId}/edit`);
                const test = await response.json();
                
                editForm.action = `/admin/tests/${testId}`;
                document.getElementById('edit_title').value = test.title;
                document.getElementById('edit_topic_id').value = test.topic_id;
                document.getElementById('edit_description').value = test.description;
                document.getElementById('edit_time_limit').value = test.time_limit;
                document.getElementById('edit_status').value = test.status;
                
                editModal.show();
            } catch (error) {
                console.error('Error:', error);
                alert('Failed to load test data');
            }
        });
    });

    // View Results
    const viewResultsButtons = document.querySelectorAll('.view-results');
    const resultsModal = new bootstrap.Modal(document.getElementById('testResultsModal'));
    const resultsTable = document.getElementById('resultsTable').querySelector('tbody');

    viewResultsButtons.forEach(button => {
        button.addEventListener('click', async function() {
            const testId = this.dataset.testId;
            try {
                const response = await fetch(`/admin/tests/${testId}/results`);
                const results = await response.json();
                
                resultsTable.innerHTML = results.map(result => `
                    <tr>
                        <td>${result.user.name}</td>
                        <td>${result.score}%</td>
                        <td>${result.time_taken} minutes</td>
                        <td>
                            <span class="badge bg-${result.status === 'completed' ? 'success' : 'warning'}">
                                ${result.status}
                            </span>
                        </td>
                        <td>${new Date(result.completed_at).toLocaleString()}</td>
                    </tr>
                `).join('');
                
                resultsModal.show();
            } catch (error) {
                console.error('Error:', error);
                alert('Failed to load test results');
            }
        });
    });

    // Delete Test
    const deleteButtons = document.querySelectorAll('.delete-test');
    const deleteForm = document.getElementById('deleteTestForm');
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteTestModal'));

    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const testId = this.dataset.testId;
            deleteForm.action = `/admin/tests/${testId}`;
            deleteModal.show();
        });
    });
});
</script>
@endpush
