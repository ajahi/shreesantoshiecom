@extends('layouts.mastercms')

@section('content')
<div class="content-wrapper container">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                 <div class="col-sm-6">
                     <h1>Edit {{$post->title}} Slider.</h1>
                 </div>
            </div>
        </div>
    </section>
    <section class='mx-'>
    <form method='POST' action="/slider/{{$post->id}}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
        <div class="form-floating my-3">
            <input type="text" class="form-control col-lg-7" name="title" placeholder="Ttile of the post" value='{{$post->title}}'>
         </div>
        <div class="form-floating my-3">
            <textarea class="form-control col-lg-7" placeholder="Description" name="description" style="height: 100px">{{$post->description}}</textarea>
        </div>
        <div class="form-floating my-3">
            <label for="images">Image</label>
            <input type="file" class="form-control col-lg-7" name="image" placeholder="Image" >
        </div>
        <button type='Submit' class="btn btn-info"> Submit</button>
    </form>
    </section>
    
</div>
@endsection