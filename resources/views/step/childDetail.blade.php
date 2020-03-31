@extends('layouts.app')

@section('title','STEP詳細')

@section('content')
<child-detail
  :parent-step="{{ $parentStep }}"
  :child-steps="{{ $childSteps }}"
  :child-step-detail="{{ $childStepDetail }}"
  :user-prof="{{ $userProf}}"
  :auth-flg="{{ $authFlg }}"
  :challenge-flg="{{ $challengeFlg }}"
  :clear-flg="{{ $clearFlg }}"
><child-detail>
@endsection
@section('content')
