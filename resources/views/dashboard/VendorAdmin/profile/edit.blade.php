@extends('layouts.dashboard')
@section('title','Edit profile')
@section('menu')
@include('layouts.partials.NavVendorAdmin')
@endsection
@section('content')		
@include('profiles.edit')											
@endsection
