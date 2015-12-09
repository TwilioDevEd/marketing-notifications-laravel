@extends('layouts.master')

@section('content')
    {!! Form::open(['url' => route('notifications.create')]) !!}
        <div class="form-group">
            {!! Form::label('message') !!}
            {!! Form::text('message', '',
                ['class' => 'form-control', 'placeholder' => 'New things are happening!']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('Image URL') !!}
            {!! Form::text('imageUrl', '',
                ['class' => 'form-control', 'placeholder' => 'http://fake.twilio.com/some_image.png']) !!}
        </div>
        <button type="submit" class="btn btn-primary">Send Message</button>
    {!! Form::close() !!}
@endsection
