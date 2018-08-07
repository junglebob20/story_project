@extends('layouts.dashboard_default')
@section('content')
@if($countsInfo)
<div class="content-info">
    <div class="info-block">
        <div class="block-header">Total stored Images</div>
        <div class="block-body">
            <div class="block-body-img">
                <i class="fa fa-picture-o" aria-hidden="true"></i>
            </div>
            <div class="block-body-count">{{$countsInfo['imagesCount']}}</div>
        </div>
    </div>
    <div class="info-block">
        <div class="block-header">Total stored Tags</div>
        <div class="block-body">
            <div class="block-body-img">
                <i class="fa fa-tags" aria-hidden="true"></i>
            </div>
            <div class="block-body-count">{{$countsInfo['tagsCount']}}</div>
        </div>
    </div>
    @if(Auth::user()->role=='admin' || Auth::user()->role=='root')
    <div class="info-block">
        <div class="block-header">Total stored Users</div>
        <div class="block-body">
            <div class="block-body-img">
                <i class="fa fa-users" aria-hidden="true"></i>
            </div>
            <div class="block-body-count">{{$countsInfo['usersCount']}}</div>
        </div>
    </div>
    @endif
</div>
@endif
@stop