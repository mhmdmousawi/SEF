@extends('layouts.main_header')

@section('content')

{{-- <h3>Incomes</h3> --}}

{{-- Monthly presentation --}}

</br></br></br> 

{{-- {{$user->incomes}} --}}
@foreach(json_decode($user->incomes) as $income)

    Income Title: {{$income->title}}</br>
    Category: {{$income->category->title}}</br>
    Logo: {{$income->category->logo->class_name}}</br>
    repeat type:{{$income->repeat->type}}</br>
    Start Date: {{$income->start_date}}</br>
    @if($income->repeat->type == 'fixed')
        Amount: ${{$income->amount}}</br> 
    @elseif($income->repeat->type == 'daily')
        Amount: ${{($income->amount)*30}}</br> 
    @endif 
    <h5>transaction here</h5>
    
    </br></br> 

@endforeach
{{-- {{$user->profile->incomes}} --}}

@endsection
