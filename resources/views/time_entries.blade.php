@extends('components.layout')
@section('content')
@php
use App\Models\TimeEntry;
$timeEntries = TimeEntry::with(['project', 'task'])->get();
$projects = DB::table('projects')->get();
$tasks = DB::table('tasks')->get();

@endphp
    <div class="text-center">
        <h3>Manage Time</h3>
    </div>
    @if(isset($message))
    <div class="alert alert-success d-flex align-items-center" role="alert">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
    <div>
        {{ $message }}
    </div>
    </div>
    @endif

    {{-- modal --}}
    <button type="button" class="btn btn-new mb-2" data-bs-toggle="modal" data-bs-target="#createTimeEntryModal">
        Create Time Entry
    </button>

    <div class="modal fade" id="createTimeEntryModal" tabindex="-1" aria-labelledby="createTimeEntryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createTimeEntryModalLabel">Create Time Entry</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form id="timeEntryForm" method="POST" action="{{ route('createTimeEntry') }}"> 
                        @csrf

                        <div class="mb-3">
                            <label for="project_id" class="form-label">Project</label>
                            <select class="form-select" id="project_id" name="project_id" required>
                                <option value="">Select Project</option>
                                @foreach ($projects as $project) 
                                    <option value="{{ $project->id }}">{{ $project->project_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="task_id" class="form-label">Task</label>
                            <select class="form-select" id="task_id" name="task_id" required>
                                <option value="">Select Task</option>
                                {{-- Tasks will be populated dynamically via JavaScript --}}
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="hours" class="form-label">Hours</label>
                            <input type="number" class="form-control" id="hours" name="hours" step="0.5" required>
                        </div>
                        <div class="mb-3">
                            <label for="entry_date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="entry_date" name="entry_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
     {{-- modal --}}
     <div class="row">
        <div class="col-md-12">
            <table class="table bg-light table-striped">
                <tr class="table-header table-dark">
                    <th class="cell">S.no</th>
                    <th class="cell">Project Name</th>
                    <th class="cell">Task Name</th>
                    <th class="cell">Date</th>
                    <th class="cell">Hour</th>
                    <th class="cell">Description</th>
                </tr>
                @if($timeEntries->isNotEmpty())
                @foreach ($timeEntries as $data)
                <tr  class="active">
                    <td>{{ $data->id }}</td>
                    <td>{{ $data->project->project_name }}</td>
                    <td>{{ $data->task->task_name }}</td>
                    <td>{{ $data->entry_date }}</td>
                    <td>{{ $data->hours }}</td>
                    <td>{{ $data->description }}</td>
                </tr>
                @endforeach
                @else
                <tr  class="active text-center">
                    <td colspan="7"> Data Not Found</td>
                </tr>
               @endif
            </table>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
    <script>
        $(document).ready(function() {
            $('#project_id').change(function() {
                var projectId = $(this).val();
                if (projectId) {
                    $.ajax({
                        url: '/getTasks/' + projectId, 
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            if (Array.isArray(data) && data.length === 0) {
                                $('#task_id').empty().append('<option value="">No Task Found</option>');
                            }else{
                                $('#task_id').empty();
                                $('#task_id').append('<option value="">Select Task</option>');
                                $.each(data, function(key, value) {
                                    $('#task_id').append('<option value="' + key + '">' + value + '</option>');
                                });
                            }
                        }
                    });
                } else {
                    $('#task_id').empty().append('<option value="">Select Task</option>');
                }
            });
        });
    </script>
@endsection
