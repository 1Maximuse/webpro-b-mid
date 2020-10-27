@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{$message}}</p>
                </div>
            @endif
            @if ($message = Session::get('error'))
                <div class="alert alert-danger">
                    <p>{{$message}}</p>
                </div>
            @endif
            <form action="{{ route('mark-ticket', $event->event_id) }}" method="GET">
                @csrf
                @method('PUT')
                <div class="row">
                    <div>
                        <div class="form-group">
                            <strong>Ticket ID:</strong>
                            <input type="text" name="ticket_id" class="form-control" placeholder="Ticket ID">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <a class="btn btn-primary" href="{{ route('my-events.index') }}">Back</a>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
