@extends('components.layout')
@section('content')
@php
$project_data = DB::table('projects')->paginate(10);
@endphp
    <div class="text-center">
        <h3>Manage Projects</h3>
    </div>
     <div class="row">
        <div class="col-md-12">
            <table class="table bg-light table-striped ">
                <tr class="table-header table-dark">
                    <th class="cell">S.no</th>
                    <th class="cell">Project Name</th>
                    <th class="cell">Status</th>
                </tr>
                @if($project_data->isNotEmpty())
                @foreach ($project_data as $data)
                <tr  class="active">
                    <td>{{ $data->id }}</td>
                    <td>{{ $data->project_name }}</td>
                    <td>{{ $data->status }}</td>
                </tr>
                @endforeach
                @else
                <tr class="active text-center">
                    <td colspan="3" >Data Not Found</td>
                </tr>
               @endif
            </table>
            <div class="d-flex justify-content-center">
            {{ $project_data->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
