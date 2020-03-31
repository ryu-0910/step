@extends('layouts.app')

@section('title','プロフィール編集')

@section('content')
  <prof-edit :user="{{ $user }}" ></prof-edit>
    
@endsection