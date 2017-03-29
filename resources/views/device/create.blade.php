@extends('master')
@section('title', 'Device')

@section('content')
    <div class="container col-md-8 col-md-offset-2">
        <div class="well well bs-component">
            <form class="form-horizontal" method="post">
                @foreach ($errors->all() as $error)
                    <p class="alert alert-danger">{{ $error }}</p>
                @endforeach

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <fieldset>
                    <legend>Submit a new device</legend>
                    <div class="form-group">
                        <label for="code" class="col-lg-2 control-label">Code</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="code" placeholder="Code" name="code">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bat" class="col-lg-2 control-label">Bat</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="bat" placeholder="Bat" name="bat">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                            <button class="btn btn-default">Cancel</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
@endsection