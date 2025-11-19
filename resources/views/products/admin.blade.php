@extends('layouts.app')

@section('content')
    <style>
        @php
            // this view has been removed; redirect to the new admin list
            header('Location: ' . url('/admin/product'));
            exit;
        @endphp
