@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="col-md-6">
                    <form method="POST" action="{{route('saveUserSatus')}}">
                        {{ csrf_field() }}
                    <div class="form-group row"> 
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                        @foreach($status as $value)
                          <option class="" value="{{$value->slug}}">{{$value->name}}</option>
                        @endforeach
                        </select>
                    </div>
                        <div class="form-group row">
                            <label for="expire"> {{ __('Expire Time') }}</label><br>
                            <input id="expire_time" type="datetime-local"
                                   class="form-control date {{ $errors->has('expire_time') || $errors->has('expire_time') ? ' is-invalid' : '' }}"
                                   name="expire_time" value="{{ old('expire_time') ?: old('expire_time') }}"  autofocus>
                            @if ($errors->has('expire_time') || $errors->has('expire_time'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('expire_time') ?: $errors->first('expire_time') }}</strong>
                                </span>
                            @endif
                        </div>
                        <input type="submit" class="btn btn-primary">
                    </form>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/build/jquery.datetimepicker.full.min.js"></script>

<script type="text/javascript">
            $(function () {
                $('#expire_time').datetimepicker({
                      format:'d.m.Y H:i',
                });
            });
        </script>
@endsection
