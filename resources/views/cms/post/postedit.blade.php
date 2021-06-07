
@extends('layouts.mastercms')

@section('content')
<div class="content-wrapper container">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                 <div class="col-sm-6">
                     <h1>Edit a Post.</h1>
                 </div>
            </div>
        </div>
    </section>
    <section class='mx-'>
    <form method='POST'action="/post/{{$post->id}}">
    @csrf
    @method('PUT')
        <div class="form-floating my-3">
            <input type="text" class="form-control col-lg-7" name="title" placeholder="Ttile of the post" value='{{$post->title}}' required>
         </div>
        <div class="form-floating my-3">
            <textarea required class="form-control col-lg-7" placeholder="Description" name="description" style="height: 100px">{{$post->description}}</textarea>
        </div>
        <div class="form-floating my-3">
        <label for="Category_id">Category</label>
            <div class="form-check" >
            @foreach($category as $categories)
                <input required class="form-check-input" type="radio" name="category_id" value={{$categories->id}} 
              @foreach($categories->posts as $catpost)
                    @if($catpost->id==$post->id)
                        checked
                    @endif
              @endforeach
                >
                <label class="form-check-label" for="defaultCheck1" >{{$categories->title}}</label>   
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
        <button type='Submit' class="btn btn-info"> Submit</button>
    </form>
    </section>
    
</div>
@endsection