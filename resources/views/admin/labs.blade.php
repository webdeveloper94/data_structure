@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Labs for Lesson: {{ $lesson->title }}</h3>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLabModal">
                        <i class="bi bi-plus-lg"></i> Add Lab
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
                                    <th>Video</th>
                                    <th>Animation</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($labs as $lab)
                                <tr>
                                    <td>{{ $lab->id }}</td>
                                    <td>{{ $lab->title }}</td>
                                    <td>{{ $lab->topic->name }}</td>
                                    <td>
                                        @if($lab->video_url)
                                            <a href="{{ $lab->video_url }}" target="_blank" class="btn btn-sm btn-info">
                                                <i class="bi bi-play-circle"></i>
                                            </a>
                                        @else
                                            <span class="text-muted">No video</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($lab->animation_url)
                                            <a href="{{ $lab->animation_url }}" target="_blank" class="btn btn-sm btn-info">
                                                <i class="bi bi-play-circle"></i>
                                            </a>
                                        @else
                                            <span class="text-muted">No animation</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $lab->status === 'published' ? 'success' : ($lab->status === 'draft' ? 'secondary' : 'warning') }}">
                                            {{ $lab->status }}
                                        </span>
                                    </td>
                                    <td>{{ $lab->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-primary edit-lab" data-lab-id="{{ $lab->id }}" title="Edit Lab">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger delete-lab" data-lab-id="{{ $lab->id }}" title="Delete Lab">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $labs->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Lab Modal -->
<div class="modal fade" id="addLabModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Lab</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.labs.store', $lesson) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="topic_id" class="form-label">Topic</label>
                        <select class="form-select" id="topic_id" name="topic_id" required>
                            @foreach($topics as $topic)
                            <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="video_url" class="form-label">Video URL</label>
                        <input type="url" class="form-control" id="video_url" name="video_url">
                    </div>
                    <div class="mb-3">
                        <label for="animation_url" class="form-label">Animation URL</label>
                        <input type="url" class="form-control" id="animation_url" name="animation_url">
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                            <option value="archived">Archived</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Lab</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Lab Modal -->
<div class="modal fade" id="editLabModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Lab</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editLabForm" method="POST">
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
                        <label for="edit_video_url" class="form-label">Video URL</label>
                        <input type="url" class="form-control" id="edit_video_url" name="video_url">
                    </div>
                    <div class="mb-3">
                        <label for="edit_animation_url" class="form-label">Animation URL</label>
                        <input type="url" class="form-control" id="edit_animation_url" name="animation_url">
                    </div>
                    <div class="mb-3">
                        <label for="edit_status" class="form-label">Status</label>
                        <select class="form-select" id="edit_status" name="status" required>
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
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

<!-- Delete Lab Modal -->
<div class="modal fade" id="deleteLabModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Lab</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this lab? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteLabForm" method="POST" class="d-inline">
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
    // Edit Lab
    const editButtons = document.querySelectorAll('.edit-lab');
    const editForm = document.getElementById('editLabForm');
    const editModal = new bootstrap.Modal(document.getElementById('editLabModal'));

    editButtons.forEach(button => {
        button.addEventListener('click', async function() {
            const labId = this.dataset.labId;
            try {
                const response = await fetch(`/admin/lessons/{{ $lesson->id }}/labs/${labId}/edit`);
                const lab = await response.json();
                
                editForm.action = `/admin/lessons/{{ $lesson->id }}/labs/${labId}`;
                document.getElementById('edit_title').value = lab.title;
                document.getElementById('edit_topic_id').value = lab.topic_id;
                document.getElementById('edit_description').value = lab.description;
                document.getElementById('edit_video_url').value = lab.video_url;
                document.getElementById('edit_animation_url').value = lab.animation_url;
                document.getElementById('edit_status').value = lab.status;
                
                editModal.show();
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred while fetching lab data');
            }
        });
    });

    // Delete Lab
    const deleteButtons = document.querySelectorAll('.delete-lab');
    const deleteForm = document.getElementById('deleteLabForm');
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteLabModal'));

    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const labId = this.dataset.labId;
            deleteForm.action = `/admin/lessons/{{ $lesson->id }}/labs/${labId}`;
            deleteModal.show();
        });
    });
});
</script>
@endpush
