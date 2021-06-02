@extends('layouts.mastercms')

@section('content')
<div class="content-wrapper container">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                 <div class="col-sm-6">
                     <h1>Create a Post.</h1>
                 </div>
            </div>
        </div>
    </section>
    <section class='mx-'>
    <form method='POST'action="/posts" enctype="multipart/form-data">
    @csrf
        <div class="form-floating my-3">
            <input type="text" class="form-control col-lg-7" name="title" placeholder="Title of the post">
         </div>
        <div class="form-floating my-3">
            <textarea class="form-control col-lg-7" placeholder="Description" name="description" style="height: 100px"></textarea>
        </div>
        <div class="form-floating my-3">
        <label for="Category_id">Category</label>
            <div class="form-check" >
            @foreach($category as $category)
                <input class="form-check-input" type="radio" name="category_id" value={{$category->id}} >
                <label class="form-check-label" for="defaultCheck1" >{{$category->title}}</label>   
                <br>
            @endforeach
            </div>
        </div>
        <div class="form-floating my-3">
        <label for="Category_id">Status</label>
            <select class="form-select" name="status" aria-label="Floating label select example"> 
                <option value="published">Published</option>
                <option value="draft">Draft</option>
            </select>
        </div>
        <div class="form-floating my-3">
            <label for="images">Image</label>
            <input type="file" class="form-control col-lg-7" name="image" placeholder="Image">
        </div>
        <button type='Submit' class="btn btn-info"> Submit</button>
    </form>
    </section>
    
</div>
@endsection
