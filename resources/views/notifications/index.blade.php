@extends('layouts.front')

@section('title')
	<h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
@endsection
  
@section('content')
    <div class="card">
        <div class="card-body">
			@if ($notifications->isNotEmpty())
                <table class="table table-hover" style="border-collapse:collapse;">
                    <thead>
                        <tr>
                            <th>{{__("notifications.date")}}</th>
                            <th>{{ __('notifications.message') }}</th>
                            <th>{{__("notifications.project")}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($notifications as $notification)
                            <tr style="font-weight: {{ $notification->read_at ? 'none' : 'bolder' }}">
                                <td>{{ $notification->created_at }}</td>
                                <td>
                                    @if (isset($notification->data['project']))
                                        {{ $notification->data['message'] }}.
                                    @else
                                        {{ $notification->data['task']['name'] }}: {{ $notification->data['message'] }} {{ $notification->data['user']['name'] }}.
                                    @endif
                                </td>
                                <td>
                                    @if (isset($notification->data['project']))
                                        {{ $notification->data['project']['name'] }}
                                    @else
                                        {{ $notification->data['task']['project']['name'] }}
                                    @endif   
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <h5 style="margin-top:20px">{{__("notifications.empty")}}</h5>
            @endif
        </div>
    </div>

@endsection

