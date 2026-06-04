@extends('layouts.dashboard')
@section('content')
  <!-- Replace the Blade form with this: -->
  <div id="property-wizard"
       data-token="{{ auth()->user()->createToken('spa')->plainTextToken }}">
  </div>
@endsection
@vite('resources/js/app.jsx')

@section('title', 'Create Property')
@section('page-title', 'Create New Property')

