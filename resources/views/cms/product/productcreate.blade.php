
@extends('layouts.mastercms')

@section('content')
<div class="content-wrapper container">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                 <div class="col-sm-6">
                     <h1>Create a Product.</h1>
                 </div>
            </div>
        </div>
    </section>
    <section class='mx-'>
    <form method='POST' action="/product" enctype="multipart/form-data">
    @csrf
        <div class="form-floating my-3">
            <input type="text" class="col-lg-7 form-control" name="title" placeholder="Title of the post" required>
           
         </div>
        <div class="form-floating my-3">
            <textarea class="form-control col-lg-7" placeholder="Description" name="description" style="height: 100px" required></textarea>
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
            @if($count>0)
                @foreach($productcategory as $parent)
                    <input required class="form-check-input" type="checkbox" name="categories_id[]" value={{$parent->id}}>
                    <label class="form-check-label" for="defaultCheck1" >{{$parent->title}}</label>   
                    <br>
                @endforeach
            @else
                <i>no product categories available.</i>
            @endif
            
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
            <input type="number" class="form-control col-lg-7" name="purchase_price" placeholder="Purchase price" required>
         </div>
         <div class="form-floating my-3">
            <input type="number" class="form-control col-lg-7" name="sell_price" placeholder="Sell price" required>
         </div>
         <div class="form-floating my-3">
            <input type="number" class="form-control col-lg-7" name="quantity" placeholder="Stock" required>
         </div>

        <div class="form-floating my-3">
            <label for="status">Status</label>
            <select class="form-select" name="status" aria-label="Floating label select example">          
            <option value=0>Draft</option>
            <option value=1>Published</option>             
            </select>
        </div>
        <div class="form-floating my-3">
            <label for="images">Image</label>
            <input type="file" class="form-control col-lg-7" name="image" placeholder="Image" required>
        </div>
        <div class="form-floating">
            <label for="discount">Discount</label>
            <input type="number" class="form-control col-lg-7" name="discount" placeholder="discount(optional)">
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" id="flexCheckIndeterminate" name='featured'>
            <label class="form-check-label" for="flexCheckIndeterminate">
                <strong>Featured</strong> 
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" id="flexCheckIndeterminate" name="offer">
            <label class="form-check-label" for="Offer">
                <Strong>Offer</Strong>
            </label>
        </div>
        <!-- <div class="form-floating">
            <label for="InStock">Stock</label>
            <div class="form-check">
            <input class="form-check-input" type="radio" id="flexRadioDefault1" checked name="InStock" value=1>
                <label class="form-check-label" for="InStock">
                    InStock
                </label>
                <br>
                <input class="form-check-input" type="radio" id="flexRadioDefault2" name="InStock" value=0>
                <label class="form-check-label" for="flexRadioDefault2">
                    Out of Stock
                </label>
            </div>  
        </div>
         -->
        <button type='Submit' class="btn btn-info"> Submit</button>
    </form>
    </section>
    
</div>
@endsection
