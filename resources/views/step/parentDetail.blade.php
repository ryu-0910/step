@extends('layouts.app')

@section('title','STEP内容')

@section('content')
<parent-detail
  :parent-step="{{ $parentStep }}"
  :child-steps="{{ $childSteps }}"
  :user-prof="{{ $userProf }}"
  :auth-flg="{{ $authFlg }}"
  :challenge-flg="{{ $challengeFlg }}"
><Parent-detail>
@endsection
@section('content')
