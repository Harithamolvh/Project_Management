@extends('components.layout')
@section('content')
@php
use App\Models\Task;
$task_data = Task::with('project')->paginate(10);
@endphp
    <div class="text-center">
        <h3>Manage Tasks</h3>
    </div>
     <div class="row">
        <div class="col-md-12">
            <table class="table bg-light table-striped">
                <tr class="table-header table-dark">
                    <th class="cell">S.no</th>
                    <th class="cell">Project Name</th>
                    <th class="cell">Task Name</th>
                    <th class="cell">Status</th>
                </tr>
                @if($task_data->isNotEmpty())
                @foreach ($task_data as $data)
                <tr  class="active">
                    <td>{{ $data->id }}</td>
                    <td>{{ $data->project->project_name }}</td>
                    <td>{{ $data->task_name }}</td>
                    <td>{{ $data->status }}</td>
                </tr>
                @endforeach
                @else
                <tr class="active text-center">
                    <td colspan="4" >Data Not Found</td>
                </tr>
               @endif
            </table>
            <div class="d-flex justify-content-center">
            {{ $task_data->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
