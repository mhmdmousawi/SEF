@extends('layouts.headers.saving.add')

@section('content_add')

<h3>Add Saving</h3>

<form action="{{config('app.url')}}/add/saving/validate" method="POST">
    @csrf
    Goal Amount: <input name='goal_amount' placeholder="Goal Amount"/>
    Amount per fequency: <input name='amount' placeholder="Amount"/>

    <div class="basic_info">
        Currency: <input type='text' name='currency_id' placeholder="currency_id"/>
        Category: <input type='text' name='category_id' placeholder="category_id"/>
    </div>
    <div class="detailed_info">
        Title <input type='text' name='title' placeholder="title"/><br>
        Description:<input type='text' name='description' placeholder="description"/><br>
        Start Date:<input type='date' name='start_date'/><br>
        Saving Fequency:<input type='text' name='repeat_id' placeholder="repeat_id"/><br>
    </div>

    {{-- On Clicking 'Next' we submit form   --}}
    <input type="submit" value="Verify">
</form>


@endsection