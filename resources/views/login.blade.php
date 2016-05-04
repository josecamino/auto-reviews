@extends('layouts.master')

@section('title', 'Admin Panel')

@section('navbar')
    @parent
    <!-- Append content to navbar here if needed -->
@stop

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-4 col-xs-8 col-xs-offset-2">
                <h2>Log in</h2>
                <br>
                @if($errors)
                    {!! Html::ul($errors->all(), array('class'=>'alert alert-danger errors')) !!}
                @endif

                {{ Form::open(array('url' => 'auth/login','class'=>'form')) }}

                <br>{{ Form::label('email', 'E-Mail Address') }}
                {{ Form::text('email', null, array('class' => 'form-control','placeholder' => 'example@gmail.com')) }}
                <br>{{ Form::label('password', 'Password') }}
                {{ Form::password('password', array('class' => 'form-control')) }}
                <br>
                {{ Form::submit('Sign In' , array('class' => 'btn btn-primary')) }}
                
                {{ Form::close() }}
                <br>
            </div>
        </div>
    </div>
    
@stop