@extends('layouts.mastercms')

@section('content')
<div class="content-wrapper container">
@include('flash')
<script src='https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script>

$(document).ready(function(){
    $('.catfilter').change(function(){
        var selectedcategory = $('.catfilter').val(); 
        console.log(selectedcategory);
            $.ajax({
            url:'<?php echo url('/product');?>',
            data:{request:selectedcategory},
            cache:false,
            success:function(response){
              
              alert(selectedcategory);
              location.reload(true);
              }
        });
        
    }); 
  });
  
</script>


    <div class="section">
   <div class="row">
   <div class="col-md-12">
   <a href="productcreate" class="btn btn-primary my-2"><i class="fas fa-plus mr-1"></i>Create</a>
   <span class=" d-inline-block my-2">
     <select class="form-select custom-select catfilter" name="category" aria-label="filter by category" placeholder="Filter by category">          
        @foreach($procat as $procat)
        <option value='{{$procat->id}}'>{{$procat->title}}</option>             
        @endforeach
     </select>
   </span>
   <span class=" d-inline-block my-2">
     <select class="form-select custom-select" name="category" aria-label="filter by category" placeholder="Filter by status">          
        <option value=0>Draft</option>
        <option value=1>Published</option>             
     </select>
   </span>
   <span class=" d-inline-block my-2">
     <select class="form-select custom-select" name="category" aria-label="filter by category" placeholder="Filter by status">          
        <option value=1>In Stock</option>
        <option value=0>Out Of Stock</option>             
     </select>
   </span>
   </div>
   </div>

        <table class='table'>
            <thead>
                <tr>
                <th scope='col'>ID</th>
                <th scope='col'>Title</th>
                <th scope='col'>Purchase Price</th>
                <th scope='col'>Stock Quantity</th> 
                <th scope='col'>Action</th>
                </tr>
            </thead>
            
            @foreach($product as $posts)
            <tbody>
                <tr>
                <td scope="col">{{$posts->id}}</td>
                <td scope="col">
                  <img src="{{$posts->url()}}" height="60" width="60"><br/>
                  <a href="/product-detail/{{$posts->slug}}" target="_blank">{{$posts->title}}</a>
                  <p class="text-secondary">Categories:<span class="text-dark mr-2"></p> 
                </td>
                
                <td scope="col"><span class="text-secondary mr-2">Purchase Price:</span>Rs. {{$posts->purchase_price}}
                <div class="py-1">
                <p class="mb-0"><span class="text-secondary mr-2">Selling Price:</span>Rs. {{$posts->sell_price}}</p>
                @if($posts->discount && $posts->discount !='')
                <p class="mb-0"><span class="text-secondary mr-2">Discout: {{$posts->discount}}%</span>
                </p>@endif
                <p><span class="text-secondary mr-2">Status:</span>
                @if($posts->status==1)<span class="text-success">Published</span>@endif
                @if($posts->status==0)<span class="text-danger">Draft</span>@endif
                </p>
                </div>
                </td>
                <td scope="col">{{$posts->quantity}}
                <p><span class="text-secondary mr-2">Status:</span>
                @if($posts->InStock==1)<span class="text-success">In Stock</span>@endif
                @if($posts->InStock==0)<span class="text-danger">Out Of Stock</span>@endif
                </p>
                </td>
                <td scope="col">
                <a href="/product/{{$posts->id}}"><i class="nav-icon fas fa-pen pr-5"></i></a>
                <form action="/productdel/{{$posts->id}}" class="d-inline" method='POST'>
                    @csrf
                    @method('DELETE')
                    <button class="btn"><i class="fas fa-trash text-danger"></i></button>
                </form>
               
                </td>
                </tr>
            </tbody>
            @endforeach
        </table>
       
    </div>
</div>
@endsection
