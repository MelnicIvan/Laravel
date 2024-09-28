@extends('layouts.app')

@section('title', 'Просмотр задачи')

@section('content')
    <x-task :task="$task" />
@endsection
