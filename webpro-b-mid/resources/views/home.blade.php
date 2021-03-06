@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div style="text-align:center; font-size:30px;">
                <div>Welcome to events.co!</div>
                <span style="white-space: pre-line"></span>
                <div>What event do you want to attend?</div>
            </div>

            <div>
                <div class="card-header text-center" style="margin-top:20px; font-size:20px;">{{ __('Actions') }}</div>
                <div class="card-body text-center d-flex flex-row justify-content-between w-75 mx-auto">
                    <a class="btn btn-success px-4" href="{{route('profile')}}">My Profile</a>
                    <a class="btn btn-success px-4" href="{{route('my-tickets')}}">My Tickets</a>
                    <a class="btn btn-success px-4" href="{{route('my-events.index')}}">My Events</a>
                    <a class="btn btn-success px-4" href="{{route('my-events.create')}}">Create new event</a>
                </div>
            </div>
            
            <div class="card my-2">
                <div class="card-header" style="text-align:center;  font-size:20px;">{{ __('All Events') }}</div>
                <div class="card-body">
                    <table class="table table-bordered table-responsive-lg" style="text-align:center;">
                        <thead class="table-info">
                            <tr>
                                <th>Event Name</th>
                                <th>Event Place</th>
                                <th>Event Start</th>
                                <th>Event End</th>
                                <th>Price</th>
                                <th colspan=3>Action</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                        @foreach ($events as $event)
                        <tr>
                            <td>
                                <a href="{{ route('event-detail', $event->event_id) }}">
                                    {{$event->event_name}}
                                </a>
                            </td>
                            <td>{{$event->event_place}}</td>
                            <td>{{$event->event_start}}</td>
                            <td>{{$event->event_end}}</td>
                            <td>{{$event->event_price}}</td>
                            <?php
                            $user = Auth::user()->id;
                            $organizer = $event->event_organizer;
                            if ($user == $organizer) { ?>
                                <td>
                                    <form action="{{ route('my-events.edit', $event->event_id) }}" method="GET">
                                        @csrf
                                        <button type="submit" class="btn btn-primary w-100">Edit</button>
                                    </form>
                                </td>
                                <td>
                                    <form action="{{ route('my-events.destroy', $event->event_id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger w-100">Delete</button>
                                    </form>
                                </td>
                            <?php
                            } else {
                            ?>
                                <td colspan=2>
                                    <form action="{{ route('buy-tickets', ['id' => $event->event_id]) }}" method="GET">
                                        @csrf
                                        <button type="submit" class="btn btn-success w-100">Buy Ticket</button>
                                    </form>
                                </td>
                            <?php
                            }
                            ?>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endsection