
@extends('layouts.headers.main')


@section('content')

<nav class="navbar navbar-inverse fixed-top navbar-expand-lg" >
    <div class="container">
        <div class="nav navbar-nav navbar-left">
            <a class="navbar-brand" href="{{config('app.url')}}/dashboard/overview">Cancel</a>
        </div>

        <div class="nav navbar-nav navbar-center">
            <li>
                <a class="navbar-brand">Profile Configuration</a>
            </li>
        </div>
        <ul class="nav navbar-nav navbar-right">
            <li>
                <a class="navbar-brand"  data-toggle="modal" data-target="#edit_profile_modal">Edit</a>
            </li>
        </ul>
    </div>
</nav>
<!-- Modal -->
<div class="modal fade" id="edit_profile_modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"> Username: {{ $user->profile->username }}</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form class="form-horizontal" action="{{config('app.url')}}/profile/edit" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p>For Now! You can only change your base currency: </p>
                        <hr>
                        <div class="form-group">
                            <label class="control-label col-xs-6" for="currency"> Set your base currency to:</label>
                            <div class="col-xs-3">
                                <select name="currency_select" id="currency_select" class="custom-select form-control form-control-lg" style="height:35px" >
                                    @foreach($currencies as $currency)
                                        @if($currency->id == $user->profile->defaultCurrency->id )
                                            <option value="{{ $currency->id }}" selected>{{$currency->code}}</option>
                                        @else
                                            <option value="{{ $currency->id }}" >{{$currency->code}}</option>
                                        @endif
                                        
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-default">Save</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<div class="container">
    @yield('content_profile')
</div>

@endsection