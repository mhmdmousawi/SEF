@extends('layouts.headers.saving.add')

<script src="{{ asset('js/saving/verification.js') }}" defer></script>
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js" defer></script> --}}
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

@section('content_add')

@include('saving.verification_modal')

<h3>Add Saving</h3>

<form id="add_saving_form" action="{{config('app.url')}}/add/saving/validate" method="POST">
    @csrf
    <input id="request_url" type="hidden" value="{{config('app.url')}}/api/add/saving/validate">
    <input id="user_id" name="user_id" type='hidden' value="{{ $user->id }}">

    Goal Amount: <input id='goal_amount' name='goal_amount' placeholder="Goal Amount"/>
    Amount per fequency: <input class="test" id='amount' name='amount' placeholder="Amount"/>

    <div class="basic_info">
        Currency: <input type='text' id="currency_id" name='currency_id' placeholder="currency_id"/>
        Category: <input type='text' id='category_id' name='category_id' placeholder="category_id"/>
    </div>
    <div class="detailed_info">
        Title <input type='text' id='title' name='title' placeholder="title"/><br>
        Description:<input type='text' id='description' name='description' placeholder="description"/><br>
        Start Date:<input type='date' id='start_date' name='start_date'/><br>
        Saving Fequency:<input type='text' id='repeat_id' name='repeat_id' placeholder="repeat_id"/><br>
    </div>

    {{-- On Clicking 'Next' we submit form   --}}
    <input id="verify_bnt" type="button" value="Verify">
    <input id="submit_btn" type="hidden">
    <input id="show_verification_modal" type="hidden" data-toggle="modal" data-target="#saving_varification_modal" value="Verify">
</form>


@endsection