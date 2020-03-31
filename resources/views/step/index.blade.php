@extends('layouts.app')

@section('title','HOME')

@section('content')
<index
:parent-step-data="{{ $parentSteps }}" 
:categories="{{ $categories }}"
></index>
    
@endsection