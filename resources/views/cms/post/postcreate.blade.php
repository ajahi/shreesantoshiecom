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
    <form method='POST'action="/posts">
    @csrf
        <div class="form-floating my-3">
            <input type="text" class="form-control col-lg-7" name="title" placeholder="Ttile of the post">
         </div>
        <div class="form-floating my-3">
            <textarea class="form-control col-lg-7" placeholder="Description" name="description" style="height: 100px"></textarea>
        </div>
        <div class="form-floating my-3">
        <label for="Category_id">Category</label>
            <select class="form-select" name="category_id" aria-label="Floating label select example">         
                <option value="1">one</option>
                <option value="2">Two</option>
            </select>
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
