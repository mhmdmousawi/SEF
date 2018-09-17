@extends('layouts.main_header')

@section('content')

<h3>Incomes</h3>

{{-- Monthly presentation --}}

</br></br></br> 
Number of Transactions: {{count($user->expanded_incomes)}}

{{-- {{$user->incomes}} --}}
@foreach(($user->expanded_incomes) as $income)

    <h5>transaction here</h5>
    Income Title: {{$income->title}}</br>
    Category: {{$income->category->title}}</br>
    Logo: {{$income->category->logo->class_name}}</br>
    repeat type:{{$income->repeat->type}}</br>
    Start Date: {{$income->start_date}}</br>
    Transaction type: {{$income->type}} </br>
    {{-- @if($income->repeat->type == 'fixed') --}}
        Amount: ${{$income->amount}}</br> 
    {{-- @elseif($income->repeat->type == 'daily') --}}
        {{-- Amount: ${{($income->amount)*30}}</br>  --}}
    {{-- @endif  --}}
    
    
    </br></br> 

@endforeach
{{-- {{$user->profile->incomes}} --}}

@endsection
