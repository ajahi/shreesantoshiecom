@extends('layouts.mastercms')

@section('content')
<div class="content-wrapper container">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                 <div class="col-sm-6">
                     <h1>Edit a Product.</h1>
                 </div>
            </div>
        </div>
    </section>
    <section class='mx-'>
    <form method='POST'action="/product/{{$product->id}}">
    @csrf
    @method('PUT')
        <div class="form-floating my-3">
            <input type="text" class="form-control col-lg-7" name="title" placeholder="Ttile of the product" value={{$product->title}}>
         </div>
        <div class="form-floating my-3">
            <textarea class="form-control col-lg-7" placeholder="Description" name="description" style="height: 100px">{{$product->description}}</textarea>
        </div>
        <!-- <div class="form-floating my-3">
        <label for="Category_id">ProductCategory</label>
            <select class="form-select" name="categories_id" aria-label="Floating label select example">         
                @foreach($productcategory as $parent)
                <option value={{$parent->id}}>{{$parent->title}}</option>
                @endforeach
            </select>
        </div> -->

        <div class="form-floating my-3">
        <label for="Category_id">ProductCategory</label>
            <div class="form-check" >
            @foreach($productcategory as $parent)
                <input class="form-check-input" type="checkbox" name="categories_id[]" value={{$parent->id}} >
                <label class="form-check-label" for="defaultCheck1" >{{$parent->title}}</label>   
                <br>
            @endforeach
            </div>
        </div>

        <div class="form-floating my-3">
        <label for="Category_id">ProductTag</label>
            <div class="form-check" >
            @foreach($tag as $protag)
                <input class="form-check-input" type="checkbox" name="tags_id[]" value={{$protag->id}} >
                <label class="form-check-label" for="defaultCheck1" >{{$protag->title}}</label>   
                <br>
            @endforeach
            </div>
        </div>
        <div class="form-floating my-3">
            <input type="number" class="form-control col-lg-7" name="purchase_price" placeholder="Purchase price" value={{$product->purchase_price}}>
         </div>
         <div class="form-floating my-3">
            <input type="number" class="form-control col-lg-7" name="quantity" placeholder="quantity" value={{$product->quantity}}>
         </div>

        <div class="form-floating">
            <label for="status">Status</label>
            <select class="form-select" name="status" aria-label="Floating label select example">          
            <option value=0>Draft</option>
            <option value=1>Published</option>             
            </select>
        </div>
        <div class="form-floating my-3">
            <label for="images">Image</label>
            <input type="file" class="form-control col-lg-7" name="image" placeholder="Image">
        </div>
        <div class="form-floating">
            <label for="discount">Discount</label>
            <input type="number" class="form-control col-lg-7" name="discount" placeholder="discount(optional)" value={{$product->discount}}>
        </div>
        <div class="form-floating my-3">
            <label for="status">Featured</label>
            <select class="form-select" name="featured" aria-label="Floating label select example">          
            <option value=0>False</option>
            <option value=1>True</option>             
            </select>
        </div>
        <div class="form-floating my-2">
            <label for="offer">Offer</label>
            <input type="text" class="form-control col-lg-7" placeholder="Offer(optional)" name="offer" value={{$product->offer}}>
        </div>
        <button type='Submit' class="btn btn-info"> Submit</button>
    </form>
    </section>
    
</div>
@endsection
