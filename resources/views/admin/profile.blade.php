@extends('layouts.app')
@section('title', 'Pengaturan Akun')
@section('heading', 'Pengaturan Akun')
@section('subheading', 'Kelola informasi akun administrator.')

@section('content')
  @include('partials.account-settings', ['me' => config('faslink.admin'), 'idLabel' => 'ID Admin', 'idValue' => config('faslink.admin.id')])
@endsection
