
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
    <form method='POST'action="/product/{{$product->id}}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
        <div class="form-floating my-3">
            <input type="text" required class="form-control col-lg-7" name="title" placeholder="Product title" value={{$product->title}} >
         </div>
        <div class="form-floating my-3">
            <textarea class="form-control col-lg-7" placeholder="Product description" name="description" style="height: 100px" required>{{$product->description}}</textarea>
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
        <label for="Category_id">Product Category</label>
            <div class="form-check" >
            @if(count($productcategory)>0)
                @foreach($productcategory as $parent)
                    <input class="form-check-input" type="checkbox" name="categories_id[]" value={{$parent->id}} 
                    @foreach($product->categories as $procat)
                        @if($procat->id==$parent->id)
                            checked 
                        @endif
                     @endforeach
                     
                    >
                    <!-- checks input which was checked when creating product -->
                    <label class="form-check-label">{{$parent->title}}</label>   
                    <br>
                @endforeach
            @else
                <i>no product categories avaiable right now.</i>    
            @endif
            </div>
        </div>

        <div class="form-floating my-3">
        <label for="Category_id">Product Tag</label>
            <div class="form-check" >
            @foreach($tag as $tag)
                <input  class="form-check-input" type="checkbox" name="tags_id[]" value={{$tag->id}} 
                @foreach($product->tags as $protag)
                @if($protag->id==$tag->id)
                checked
                @endif
                @endforeach
                >
                <label class="form-check-label" for="defaultCheck1" >{{$tag->title}}</label>   
                <br>
            @endforeach
            </div>
        </div>
        <div class="form-floating my-3">
        <label for="purchase_price">Purchase price <span class="font-normal text-danger">*</span></label>
            <input required type="number" class="form-control col-lg-7" name="purchase_price" placeholder="Purchase price" value={{$product->purchase_price}} >
         </div>
         <div class="form-floating my-3">
         <label for="sell_price">Selling price <span class="font-normal text-danger">*</span></label>
            <input  required type="number" class="form-control col-lg-7" name="sell_price" placeholder="Sell price" value={{$product->sell_price}}>
         </div>
         <div class="form-floating my-3">
         <label for="quantity">Stock quantity <span class="font-normal text-danger">*</span></label>
            <input required type="number" class="form-control col-lg-7" name="quantity" placeholder="quantity" value={{$product->quantity}}>
         </div>
         <div class="form-floating">
            <label for="discount">Discount</label>
            <input type="number" class="form-control col-lg-7" name="discount" placeholder="discount(optional)" value={{$product->discount}}>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1"  name='featured'
            @if($product->featured==1)
            checked
            @endif
            >
            <label class="form-check-label" for="flexCheckIndeterminate">
                <strong>Featured</strong> 
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" name="offer"
            @if($product->offer==1)
            checked
            @endif
            >
            <label class="form-check-label" for="Offer">
                <Strong>Offer</Strong>
            </label>
        </div>

        <div class="form-floating">
            <label for="status">Status</label>
            <select class="form-select" name="status" aria-label="Floating label select example">          
            <option value=0>Draft</option>
            <option value=1>Published</option>             
            </select>
        </div>
        <div class="form-floating my-3">
            <img src="{{$product->getFirstMediaUrl('')}}" width="50%" height="130px" alt="">
            <p>Note: Old image will be replace by new one</p>
        </div>
        <div class="form-floating my-3">
            <label for="images">Product Image</label>
            <input type="file" class="form-control col-lg-7" name="image" placeholder="Image">
        </div>
        
        <div class="form-floating my-3">
            <label for="images">Additional Image</label>
            <input type="file" class="form-control col-lg-7" name="addition-image" placeholder="Image" >
        </div>
        
        
        <button type='Submit' class="btn btn-info"> Submit</button>
    </form>
    </section>
    
</div>
@endsection
