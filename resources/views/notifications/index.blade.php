@extends('layouts.app')

@section('content')
<div class="container max-w-lg mx-auto p-4">
    <h2 class="mb-4">Notifications</h2>

    @forelse($notifications as $notification)

    @php
        switch ($notification->type) {

            case 'post_liked':
            case 'post_commented':
                $url = url('/post/' . ($notification->data['post_id'] ?? '#'));
                break;

            case 'plant_approved':
            case 'plant_rejected':
                $url = url('/plant-submissions/' . ($notification->data['submission_id'] ?? '#'));
                break;

            default:
                $url = '#';
                break;
        }
    @endphp

   <a href="{{ $url }}" class="block">
    <div class="card bg-gray-100 hover:bg-red-100 p-2 mb-1 transition 
        {{ $notification->is_read ? '' : 'border border-primary' }}">
        
        <div class="card-body text-xs md:text-sm">
            {{ $notification->data['message'] ?? 'Notification' }}
            
            <br>
            <small class="text-muted">
                {{ $notification->created_at->diffForHumans() }}
            </small>
        </div>
    </div>
</a>


@empty
    <p>No notifications yet.</p>
@endforelse

</div>
@endsection
