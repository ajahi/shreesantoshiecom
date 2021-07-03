@extends('layouts.mastercms')

@section('content')
<div class="content-wrapper container">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                 <div class="col-sm-6">
                     <h1>Edit {{$post->title}} Tag.</h1>
                 </div>
            </div>
        </div>
    </section>
    <section class='mx-4'>
    <form method='POST' action="/tag/{{$post->id}}">
    @csrf
    @method('PUT')
        <div class="form-floating my-3">
        <label for="name" class="text-secondary">Name <span class="font-normal text-danger">*</span></label>
            <input required type="text" class="form-control col-lg-7" name="title" placeholder="Ttile of the post" value='{{$post->name}}'>
         </div>
        <div class="form-floating my-3">
            <textarea required class="form-control col-lg-7" placeholder="Description" name="description" style="height: 100px">{{$post->email}}</textarea>
        </div>
       
        <div class="pt-4">
        <a href="/user" class="btn btn-danger px-4 mr-4">Cancel</a><button type='Submit' class="btn btn-success px-4">Update</button>
        </div>
    </form>
    </section>
    
</div>
@endsection
