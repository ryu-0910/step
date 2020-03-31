@extends('layouts.app')

@section('title','STEP登録')

@section('content')

  <step-register
  :categories="{{ $categories }}"
  :edit-flg="{{ $editFlg }}"
  @if($editFlg)
    :parent-step-data="{{ $parentStep }}"
    :child-steps-data="{{ $childSteps }}"
  @else
    :parent-step-data="null"
    :child-steps-data="null"
  @endif
  ></step-register>
    
@endsection