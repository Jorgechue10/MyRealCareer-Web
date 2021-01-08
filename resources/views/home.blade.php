@extends("../layouts.plantilla")

@section("head")
<script>window.location = "{{ route('users.show', Auth::user()->id) }}";</script>
@endsection