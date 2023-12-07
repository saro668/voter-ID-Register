@extends('layouts.app')
  
@section('title', 'Dashboard')
  
@section('contents')
  
 @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
<div class="container">
  <div class="row">
    <div class="col-md-4">
      <div class="dbox dbox--color-1">
        <div class="dbox__icon">
          <i class="glyphicon glyphicon-cloud"></i>
        </div>
        <div class="dbox__body">
          <span class="dbox__count">{{ $totalVotersCount }}</span>
          <span class="dbox__title">Total Voters</span>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="dbox dbox--color-2">
        <div class="dbox__icon">
          <i class="glyphicon glyphicon-download"></i>
        </div>
        <div class="dbox__body">
          <span class="dbox__count">{{ $todayVotersCount }}</span>
          <span class="dbox__title">Today Voters</span>
        </div>
      
      </div>
    </div>
    <div class="col-md-4">
      <div class="dbox dbox--color-3">
        <div class="dbox__icon">
          <i class="glyphicon glyphicon-heart"></i>
        </div>
        <div class="dbox__body">
          <span class="dbox__count">0</span>
          <span class="dbox__title">Attend Count</span>
        </div>
                
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-4">
      <div class="dbox dbox--color-1">
        <div class="dbox__icon">
          <i class="glyphicon glyphicon-cloud"></i>
        </div>
        <div class="dbox__body">
          <span class="dbox__count">{{ $maleCount }}</span>
          <span class="dbox__title">Male Voters</span>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="dbox dbox--color-2">
        <div class="dbox__icon">
          <i class="glyphicon glyphicon-download"></i>
        </div>
        <div class="dbox__body">
          <span class="dbox__count">{{ $femaleCount }}</span>
          <span class="dbox__title">Female Voters</span>
        </div>
      
      </div>
    </div>
    <div class="col-md-4">
      <div class="dbox dbox--color-3">
        <div class="dbox__icon">
          <i class="glyphicon glyphicon-heart"></i>
        </div>
        <div class="dbox__body">
          <span class="dbox__count">{{ $otherCount }}</span>
          <span class="dbox__title">Other Voters</span>
        </div>
                
      </div>
    </div>
  </div>
</div>
@endsection