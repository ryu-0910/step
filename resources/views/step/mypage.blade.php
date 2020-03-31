@extends('layouts.app')

@section('title','マイページ')

@section('content')
  <mypage
    :challenge-steps="{{ $challengeSteps }}"
    :regist-steps="{{ $registSteps }}"
  ></mypage>
    
@endsection