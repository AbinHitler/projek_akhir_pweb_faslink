@extends('layouts.app')
@section('title', 'Pengaturan Akun')
@section('heading', 'Pengaturan Akun')
@section('subheading', 'Kelola informasi akunmu di sini.')

@section('content')
  @include('partials.account-settings', ['me' => config('faslink.user'), 'idLabel' => 'NIM', 'idValue' => config('faslink.user.nim')])
@endsection
