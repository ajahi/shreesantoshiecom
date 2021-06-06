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
    <form method='POST' action="/site/{{$post->id}}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
        <div class="form-floating my-3">
        <label for="">Title</label>
            <input type="text" class="form-control col-lg-7" name="title" placeholder="Title of the site" value='{{$post->title}}'>
         </div>
         <div class="form-floating m-3">
            <label for="logos">Image</label>
            <input type="file" class="form-control col-lg-7" name="logo" placeholder="Image">
            
        </div>
        <div class="form-floating">
            <img src="{{$post->logu()}}" alt="">
            <p>Note:old logo will be replaced by old logo.</p>
        </div>
         <div class="form-floating my-3">
         <label for="">Slogan</label>
            <input type="text" class="form-control col-lg-7" name="slogan" placeholder="slogan" value='{{$post->slogan}}'>
         </div>
        <div class="form-floating my-3">
        <label for="">Description</label>
            <textarea class="form-control col-lg-7" placeholder="Description" name="description" style="height: 100px">{{$post->description}}</textarea>
        </div>
        <div class="form-floating my-3">
        <label for="">Website</label>
            <input type="url" class="form-control col-lg-7" name="website" placeholder="url of site" value='{{$post->website}}'>
         </div>
         <div class="form-floating my-3">
         <label for="">Email</label>
            <input type="email" class="form-control col-lg-7" name="email" placeholder="email of the site" value='{{$post->email}}'>
         </div>
         <div class="form-floating my-3">
         <label for="">Location</label>
            <input type="text" class="form-control col-lg-7" name="location" placeholder="location" value='{{$post->location}}'>
         </div>
         <div class="form-floating my-3">
         <label for="">Working days</label>
            <input type="integer" class="form-control col-lg-7" name="working_days" placeholder="working days of the company" value='{{$post->working_days}}'>
         </div>
         <div class="form-floating my-3">
         <label for="">Telephone</label>
            <input type="number" class="form-control col-lg-7" name="telephone" placeholder="Telephone" value='{{$post->telephone}}'>
         </div>
         <div class="form-floating my-3">
         <label for="">Facebook</label>
            <input type="text" class="form-control col-lg-7" name="facebook" placeholder="facebook" value='{{$post->facebook}}'>
         </div>
         <div class="form-floating my-3">
         <label for="">Instagram</label>
            <input type="text" class="form-control col-lg-7" name="twitter" placeholder="twitter" value='{{$post->twitter}}'>
         </div>
         <div class="form-floating my-3">
         <label for="">Instagram</label>
            <input type="text" class="form-control col-lg-7" name="instagram" placeholder="instagram" value='{{$post->instagram}}'>
         </div>
         <div class="form-floating my-3">
         <label for="">Skype</label>
            <input type="text" class="form-control col-lg-7" name="skype" placeholder="skype" value='{{$post->skype}}'>
         </div>
         <div class="form-floating my-3">
         <label for="">LinkedIn</label>
            <input type="text" class="form-control col-lg-7" name="linkedin" placeholder="linkedin" value='{{$post->linkedin}}'>
         </div>
         <div class="form-floating my-3">
         <label for="">Google</label>
            <input type="text" class="form-control col-lg-7" name="google" placeholder="Google" value='{{$post->google}}'>
         </div>
        <button type='Submit' class="btn btn-info"> Submit</button>
    </form>
    </section>
    
</div>
@endsection
