@extends('layouts.admin')

@section('content')

@include('prizes.partials.prize_details', ['event' => $event])
    
@endsection