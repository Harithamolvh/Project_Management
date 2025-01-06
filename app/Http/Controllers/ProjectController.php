<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\TimeEntry;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function getTasks(Request $request, $project)
    {
        $tasks = Task::where('project_id', $project)->pluck('task_name', 'id'); 
        return response()->json($tasks);
    }
    public function store(Request $request){
        $request->validate([
            'project_id'=> 'required',
            'task_id'=> 'required',
            'hours'=> 'required|integer',
            'entry_date'=> 'required|date',
            'description'=> 'required',
        ]);
        TimeEntry::create([
            'project_id'=> $request->project_id,
            'task_id'=>  $request->task_id,
            'hours'=>  $request->hours,
            'entry_date'=>  $request->entry_date,
            'description'=>  $request->description,
        ]);
        return redirect()->back()->with('message','saved successfully');

    }
    public function searchProjects(Request $request)
    {
        $projectName = $request->input('project_name');

        $projects = Project::with(['tasks.timeEntries'])
            ->withSum('timeEntries as total_hours', 'hours')
            ->has('timeEntries') 
            ->when($projectName, function ($query, $projectName) {
                $query->where('project_name', 'LIKE', '%' . $projectName . '%');
            })
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

        return response()->json($projects);
    }
}
