@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Topics Management</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTopicModal">
                            Add New Topic
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topics as $topic)
                                <tr>
                                    <td>{{ $topic->name }}</td>
                                    <td>{{ $topic->description }}</td>
                                    <td>{{ $topic->status }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info edit-topic" 
                                            data-id="{{ $topic->id }}"
                                            data-name="{{ $topic->name }}"
                                            data-description="{{ $topic->description }}">
                                            Edit
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger delete-topic" 
                                            data-id="{{ $topic->id }}"
                                            data-name="{{ $topic->name }}">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Topic Modal -->
<div class="modal fade" id="addTopicModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Topic</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addTopicForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3" required></textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="submitAddTopic">Add Topic</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Topic Modal -->
<div class="modal fade" id="editTopicModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Topic</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editTopicForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editTopicId">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" id="editTopicName" class="form-control" required>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="editTopicDescription" class="form-control" rows="3" required></textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="submitEditTopic">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Topic Modal -->
<div class="modal fade" id="deleteTopicModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Topic</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete topic: <span id="deleteTopicName"></span>?</p>
                <form id="deleteTopicForm">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" id="deleteTopicId">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="submitDeleteTopic">Delete</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const addTopicModal = document.getElementById('addTopicModal');
    const editTopicModal = document.getElementById('editTopicModal');
    const deleteTopicModal = document.getElementById('deleteTopicModal');

    // Add Topic
    document.getElementById('submitAddTopic').addEventListener('click', function() {
        const form = document.getElementById('addTopicForm');
        const formData = new FormData(form);

        fetch('{{ route("admin.topics.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                throw new Error(data.error);
            }
            window.location.reload();
        })
        .catch(error => {
            alert(error.message || 'An error occurred while creating the topic.');
        });
    });

    // Edit Topic
    document.querySelectorAll('.edit-topic').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const name = this.dataset.name;
            const description = this.dataset.description;
            
            document.getElementById('editTopicId').value = id;
            document.getElementById('editTopicName').value = name;
            document.getElementById('editTopicDescription').value = description;
            
            new bootstrap.Modal(editTopicModal).show();
        });
    });

    // Submit Edit
    document.getElementById('submitEditTopic').addEventListener('click', function() {
        const form = document.getElementById('editTopicForm');
        const formData = new FormData(form);
        const id = document.getElementById('editTopicId').value;

        fetch(`/admin/topics/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                throw new Error(data.error);
            }
            window.location.reload();
        })
        .catch(error => {
            alert(error.message || 'An error occurred while updating the topic.');
        });
    });

    // Delete Topic
    document.querySelectorAll('.delete-topic').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const name = this.dataset.name;
            
            document.getElementById('deleteTopicId').value = id;
            document.getElementById('deleteTopicName').textContent = name;
            
            new bootstrap.Modal(deleteTopicModal).show();
        });
    });

    // Submit Delete
    document.getElementById('submitDeleteTopic').addEventListener('click', function() {
        const id = document.getElementById('deleteTopicId').value;

        fetch(`/admin/topics/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                throw new Error(data.error);
            }
            window.location.reload();
        })
        .catch(error => {
            alert(error.message || 'An error occurred while deleting the topic.');
        });
    });
});
</script>
@endpush
