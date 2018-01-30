@extends('layouts.app')
@section('title', 'whoops！ 404错误')
@section('content')
    <div class="error-message" style="text-align: center;margin-top: 10%">
        <h2><?php echo $exception->getMessage() ?></h2>
    </div>
@endsection
