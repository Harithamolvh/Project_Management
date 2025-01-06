@extends('components.layout')
@section('content')
@php
use App\Models\Project;

    $projects = Project::with(['tasks.timeEntries'])
    ->withSum('timeEntries as total_hours', 'hours') 
    ->has('timeEntries')
    ->get()
    ->map(function ($project) {
        return [
            'project_name' => $project->project_name,
            'total_hours' => $project->total_hours,
            'tasks' => $project->tasks->map(function ($task) {
                return [
                    'task_name' => $task->task_name,
                    'total_task_hours' => $task->timeEntries->sum('hours'),
                ];
            }),
        ];
    });
$count = 1;

@endphp
    <div class="text-center">
        <h3>Project Reports</h3>
    </div>
   <div class="row">
    <div class="col-md-3 me-left mb-2">
        <div class="input-group">
            <input class="form-control border-end-0 border rounded-pill" type="search" placeholder="Search" id="example-search-input">
            <button class="btn btn-outline-secondary bg-white border-bottom-0 border rounded-pill" id="button-click" type="submit">
                <i class="fa fa-search"></i>
            </button>
        </div>
    </div>


     <div class="row">
        <div class="col-md-12">
            <table class="table bg-light table-striped">
                <tr class="table-header table-dark">
                    <th class="cell">S.no</th>
                    <th class="cell">Project Name</th>
                    <th class="cell">Total Hours</th>
                </tr>
                <tbody id="result">
                @if($projects->isNotEmpty())
                @foreach ($projects as $data)
                <tr  class="active bg-yellow">
                    <td>{{ $count }}</td>
                    <td>{{ $data['project_name'] }}</td>
                    <td>{{ $data['total_hours'] }}</td>
                </tr>
                @foreach ($data['tasks'] as $task)
                 <tr  class="active">
                    <td></td>
                    <td>{{ $task['task_name'] }}</td>
                    <td>{{ $task['total_task_hours'] }}</td>
                </tr>
                @endforeach
                @php
                $count++;
                @endphp
                @endforeach
                @else
                <tr  class="active text-center">
                    <td colspan="3" >Data Not Found</td>
                </tr>
               @endif
                </tbody>
            </table>
        </div>
    </div>
    <script>
        document.getElementById('button-click').addEventListener('click', function (event) {
        event.preventDefault();

        const searchInput = document.getElementById('example-search-input').value;
        fetch('/search-projects', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ project_name: searchInput }),
        })
        .then((response) => response.json())
        .then((data) => {
            let resultTbody = document.getElementById('result');
            resultTbody.innerHTML = ''; 

            if (data.length > 0) {
                let count = 1;
                data.forEach((project) => {
                    let projectRow = document.createElement('tr');
                    projectRow.classList.add('active');
                    projectRow.innerHTML = `
                        <td>${count}</td>
                        <td>${project.project_name}</td>
                        <td>${project.total_hours}</td>
                    `;
                    resultTbody.appendChild(projectRow);

                    project.tasks.forEach((task) => {
                        let taskRow = document.createElement('tr');
                        taskRow.classList.add('active');
                        taskRow.innerHTML = `
                            <td></td>
                            <td>${task.task_name}</td>
                            <td>${task.total_task_hours}</td>
                        `;
                        resultTbody.appendChild(taskRow);
                    });

                    count++;
                });
            } else {
                let noDataRow = document.createElement('tr');
                noDataRow.classList.add('active');
                noDataRow.innerHTML = '<td colspan="3">No projects found.</td>';
                resultTbody.appendChild(noDataRow);
            }
        })
        .catch((error) => console.error('Error:', error));
    });
 </script>
@endsection
