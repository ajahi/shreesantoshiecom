@extends('layouts.mastercms')

@section('content')
<div class="content-wrapper container">
@include('flash')
<script src='https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script>

$(document).ready(function(){
    $('.filter').change(function(){
        var pro_Id = $('.filter').val();
            $.ajax({              
            url:'<?php echo url('/product');?>',
            data:{pro_Id:pro_Id},
            success:function(response){
              
              alert(pro_Id);
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
          <select class="form-select custom-select filter" name="category" aria-label="filter by category" placeholder="Filter by category">          
              @foreach($procat as $procat)
              <option  value="{{$procat->id}}">{{$procat->title}}</option>             
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
        <section class="htc__product__area bg__white mt-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="product-style-tab">
                            <div class="product-tab-list">
                                <!-- Nav tabs -->
                                <ul class="tab-style" role="tablist">
                                    <li class="active">
                                        <a href="#home1" data-toggle="tab">
                                            <div class="tab-menu-text">
                                                <h4>Latest </h4>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#home2" data-toggle="tab">
                                            <div class="tab-menu-text">
                                                <h4>Best sale</h4>
                                            </div>
                                        </a>
                                    </li>
                                 
                                    <li>
                                        <a href="#home3" data-toggle="tab">
                                            <div class="tab-menu-text">
                                                <h4>Discount Sale</h4>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content another-product-style jump">
                                <div class="tab-pane active" id="home1">
                                    <div class="row">
                                        <div class="product-slider-active owl-carousel">
                                        @forelse($published as $product)
                                            <div class="col-md-3 single__pro col-lg-3 cat--1 col-sm-4 col-xs-12">
                                                <div class="product">
                                                    <div class="product__inner">
                                                        <div class="pro__thumb">
                                                            <a class='detail-product' value='{{$product->slug}}'>
                                                               
                                                                <p></p>
                                                                <img src="{{$product->url()}}" alt="product images">
                                                            </a>
                                                        </div>
                                                        <div class="product__hover__info">
                                                            <ul class="product__action">
                                                            <li><a title="Quick View" class="quick-view modal-view detail-link detail-product"   value='{{$product->slug}}'><span class="ti-eye"></span></a></li>
                                                            @if($product->quantity < 0)

                                                             @else
                                                             <li><a title="Add To Cart" value='{{$product->id}}' class='button' ><span class="ti-shopping-cart"></span></a></li>
                                                            @endif 
                                                                
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="product__details">
                                                        <h2><a class='detail-product' value='{{$product->slug}}'>{{ucwords($product->title)}}</a></h2>
                                                        <ul class="product__price">
                                                            @if($product->discount)
                                                                <li class="old__price">Rs.{{$product->sell_price}}</li>
                                                                <li class="new__price">Rs.{{$product->sell_price*(1-$product->discount/100)}}</li>
                                                            @else
                                                            <li class="new__price">Rs.{{$product->sell_price}}</li>
                                                            @endif
                                                        </ul>    
                                                    </div>
                                                </div>
                                            </div>   
                                            @empty
                                                <div class="row">
                                                    <div class="product">
                                                        <div class="col-md-12">
                                                            <div class="product">
                                                                <p>No items .</p>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                        @endforelse                                                                                                                                                             
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="home2">
                                    <div class="row">
                                        <div class="product-slider-active owl-carousel">
                                        @forelse($InStock as $product)
                                            <div class="col-md-3 single__pro col-lg-3 cat--1 col-sm-4 col-xs-12">
                                                <div class="product">
                                                    <div class="product__inner">
                                                        <div class="pro__thumb">
                                                            <a class='detail-product' value='{{$product->slug}}'>
                                                               
                                                                <p></p>
                                                                <img src="{{$product->url()}}" alt="product images">
                                                            </a>
                                                        </div>
                                                        <div class="product__hover__info">
                                                            <ul class="product__action">
                                                            <li><a title="Quick View" class="quick-view modal-view detail-link detail-product"   value='{{$product->slug}}'><span class="ti-eye"></span></a></li>
                                                            @if($product->quantity < 0)

                                                             @else
                                                             <li><a title="Add To Cart" value='{{$product->id}}' class='button' ><span class="ti-shopping-cart"></span></a></li>
                                                            @endif 
                                                                
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="product__details">
                                                        <h2><a class='detail-product' value='{{$product->slug}}'>{{ucwords($product->title)}}</a></h2>
                                                        <ul class="product__price">
                                                            @if($product->discount)
                                                                <li class="old__price">Rs.{{$product->sell_price}}</li>
                                                                <li class="new__price">Rs.{{$product->sell_price*(1-$product->discount/100)}}</li>
                                                            @else
                                                            <li class="new__price">Rs.{{$product->sell_price}}</li>
                                                            @endif
                                                        </ul>    
                                                    </div>
                                                </div>
                                            </div>   
                                            @empty
                                                <div class="row">
                                                    <div class="product">
                                                        <div class="col-md-12">
                                                            <div class="product">
                                                                <p>No items .</p>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                        @endforelse                                                                                                                       
                                        </div>
                                    </div>
                                </div> 
                                <div class="tab-pane" id="home3">
                                    <div class="row">
                                        <div class="product-slider-active owl-carousel">
                                        @forelse($OutStock as $product)
                                            <div class="col-md-3 single__pro col-lg-3 cat--1 col-sm-4 col-xs-12">
                                                <div class="product">
                                                    <div class="product__inner">
                                                        <div class="pro__thumb">
                                                            <a class='detail-product' value='{{$product->slug}}'>
                                                               
                                                                <p></p>
                                                                <img src="{{$product->url()}}" alt="product images">
                                                            </a>
                                                        </div>
                                                        <div class="product__hover__info">
                                                            <ul class="product__action">
                                                            <li><a title="Quick View" class="quick-view modal-view detail-link detail-product"   value='{{$product->slug}}'><span class="ti-eye"></span></a></li>
                                                            @if($product->quantity < 0)

                                                             @else
                                                             <li><a title="Add To Cart" value='{{$product->id}}' class='button' ><span class="ti-shopping-cart"></span></a></li>
                                                            @endif 
                                                                
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="product__details">
                                                        <h2><a class='detail-product' value='{{$product->slug}}'>{{ucwords($product->title)}}</a></h2>
                                                        <ul class="product__price">
                                                            @if($product->discount)
                                                                <li class="old__price">Rs.{{$product->sell_price}}</li>
                                                                <li class="new__price">Rs.{{$product->sell_price*(1-$product->discount/100)}}</li>
                                                            @else
                                                            <li class="new__price">Rs.{{$product->sell_price}}</li>
                                                            @endif
                                                        </ul>    
                                                    </div>
                                                </div>
                                            </div>   
                                            @empty
                                                <div class="row">
                                                    <div class="product">
                                                        <div class="col-md-12">
                                                            <div class="product">
                                                                <p>No items .</p>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                        @endforelse   
                                                                       
                                        </div>
                                    </div>
                                </div>                                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
