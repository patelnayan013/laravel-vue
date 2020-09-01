@extends('layouts.vue')

@section('content')
<employee-create :id='"{{$id ?? 0}}"'></employee-create>
@endsection
