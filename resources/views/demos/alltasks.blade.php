@extends('demos.main')

@section('content')

  
  <div class="well" id="app">
    <task-draggable :tasks-completed="{{ $columns }}"></task-draggable>
  </div> <!-- end app -->
  

   <script src="{{ asset('js/app.js') }}"></script> 
    
@endsection