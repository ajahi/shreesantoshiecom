@extends('layouts.mastercms')

@section('content')
<div class="content-wrapper container">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                 <div class="col-sm-6">
                     <h1>Edit {{$post->title}} Site.</h1>
                 </div>
            </div>
        </div>
    </section>
    <section class='mx-'>
    <form method='POST' action="/site/{{$post->id}}">
    @csrf
    @method('PUT')
        <div class="form-floating my-3">
            <input type="text" class="form-control col-lg-7" name="title" placeholder="Title of the site" value='{{$post->title}}'>
         </div>
         <div class="form-floating my-3">
            <input type="text" class="form-control col-lg-7" name="slogan" placeholder="slogan" value='{{$post->slogan}}'>
         </div>
        <div class="form-floating my-3">
            <textarea class="form-control col-lg-7" placeholder="Description" name="description" style="height: 100px">{{$post->description}}</textarea>
        </div>
        <div class="form-floating my-3">
            <input type="url" class="form-control col-lg-7" name="website" placeholder="url of site" value='{{$post->website}}'>
         </div>
         <div class="form-floating my-3">
            <input type="email" class="form-control col-lg-7" name="email" placeholder="email of the site" value='{{$post->email}}'>
         </div>
         <div class="form-floating my-3">
            <input type="text" class="form-control col-lg-7" name="location" placeholder="location" value='{{$post->location}}'>
         </div>
         <div class="form-floating my-3">
            <input type="integer" class="form-control col-lg-7" name="working_days" placeholder="working days of the company" value='{{$post->working_days}}'>
         </div>
       
        <button type='Submit' class="btn btn-info"> Submit</button>
    </form>
    </section>
    
</div>
@endsection
