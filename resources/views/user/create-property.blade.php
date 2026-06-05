@extends('layouts.dashboard')

@section('title', 'Create Property')
@section('page-title', 'Create New Property')

@section('content')
  <div id="property-wizard"
       data-token="{{ auth()->user()->createToken('spa')->plainTextToken }}">
  </div>
@endsection

@push('scripts')
  @vite('resources/js/app.jsx')
@endpush