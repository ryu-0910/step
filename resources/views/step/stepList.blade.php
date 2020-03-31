@extends('layouts.app')

@section('title','STEP一覧')

@section('content')
<step-list
  :parent-step-data="{{ $parentSteps }}"
  :categories="{{ $categories }}"
></step-list>
@endsection