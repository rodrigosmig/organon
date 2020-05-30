@extends('layouts.front')

@section('content')
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Active Projects</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ auth()->user()->countActiveProjects() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-toggle-on fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Number of delayed projects</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $delayedProjects }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total cost of projects</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">${{ number_format($totalProjectsCost, 2, ',', '.') }}</div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total charged for projects</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">${{ number_format($totalProjectValue, 2, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Projects</h6>
                </div>
                <div class="card-body">
                    @foreach ($projects as $project)
                        <h4 class="small font-weight-bold">{{ $project->name }} <span class="float-right">{{ $project->getProjectsProgress() == 100 ? 'Complete!' : $project->getProjectsProgress() . "%" }}</span></h4>
                        <div class="progress mb-4">
                            @if ($project->tasks()->count() > 0)
                                @if ($project->getProjectsProgress() <= 20)
                                    <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $project->getProjectsProgress() }}%" aria-valuenow="{{ $project->getProjectsProgress() }}" aria-valuemin="0" aria-valuemax="100"></div>
                                @elseif ($project->getProjectsProgress() <= 40)
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $project->getProjectsProgress() }}%" aria-valuenow="{{ $project->getProjectsProgress() }}" aria-valuemin="0" aria-valuemax="100"></div>
                                @elseif ($project->getProjectsProgress() <= 60)
                                    <div class="progress-bar" role="progressbar" style="width: {{ $project->getProjectsProgress() }}%" aria-valuenow="{{ $project->getProjectsProgress() }}" aria-valuemin="0" aria-valuemax="100"></div>
                                @elseif ($project->getProjectsProgress() <= 80)
                                    <div class="progress-bar bg-info" role="progressbar" style="width: {{ $project->getProjectsProgress() }}%" aria-valuenow="{{ $project->getProjectsProgress() }}" aria-valuemin="0" aria-valuemax="100"></div>
                                @else
                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $project->getProjectsProgress() }}%" aria-valuenow="{{ $project->getProjectsProgress() }}" aria-valuemin="0" aria-valuemax="100"></div>
                                @endif
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection