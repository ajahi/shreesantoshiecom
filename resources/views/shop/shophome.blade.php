
@extends('layouts.shop')
@section('title')
    Shree Santoshi Mata Hastakala
@endsection
      
@section('sidemenu')



<script src='https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script>

$(document).ready(function(){
    $('.button').click(function(){
        var pro_Id = $(this).attr('value');
            $.ajax({
            type:'get',
            cache:false,
            url:'<?php echo url('/add-to-cart');?>/'+ pro_Id,
            success:function(response){
               var resp=response;
                
                location.reload(true);
               loaditems(resp);
              }
        });
        
    }); 
    $('.removebtn').click(function(){
        
        $.ajax({
            type:'get',
            url:'<?php echo url('/newcart');?>',
            success:function(response){
              
                location.reload(true);
            }
        });
    });
   
   
    function loaditems(data){
        var name=document.getElementById('itemName');
        var duta=data.items[3].item.title;
        console.log(duta);
    }
});

</script>



<div class="container">
    @include('flash') 
</div>


      <!-- Start Offset Wrapper -->
        <div class="offset__wrapper">
            <!-- Start Search Popap -->
            <div class="search__area">
                <div class="container" >
                    <div class="row" >
                        <div class="col-md-12" >
                            <div class="search__inner">
                                <form action="#" method="get">
                                    <input placeholder="Search here... " type="text">
                                    <button type="submit"></button>
                                </form>
                                <div class="search__close__btn">
                                    <span class="search__close__btn_icon"><i class="fas fa-times"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Search Popap -->
            <!-- Start Offset MEnu -->
            <div class="offsetmenu">
                <div class="offsetmenu__inner">
                    <div class="offsetmenu__close__btn">
                        <a href="#"><i class="fas fa-times"></i></a>
                    </div>
                    <div class="off__contact">
                        <div class="logo">
                            <a href="index.html">
                                <img src="/images1/logo/logo1.png" alt="logo">
                            </a>
                        </div>
                        <p>Lorem ipsum dolor sit amet consectetu adipisicing elit sed do eiusmod tempor incididunt ut labore.</p>
                    </div>
                    <ul class="sidebar__thumd">
                        <li><a href="#"><img src="images1/sidebar-img/1.jpg" alt="sidebar images"></a></li>
                        <li><a href="#"><img src="images1/sidebar-img/2.jpg" alt="sidebar images"></a></li>
                        <li><a href="#"><img src="images1/sidebar-img/3.jpg" alt="sidebar images"></a></li>
                        <li><a href="#"><img src="images1/sidebar-img/4.jpg" alt="sidebar images"></a></li>
                        <li><a href="#"><img src="images1/sidebar-img/5.jpg" alt="sidebar images"></a></li>
                        <li><a href="#"><img src="images1/sidebar-img/6.jpg" alt="sidebar images"></a></li>
                        <li><a href="#"><img src="images1/sidebar-img/7.jpg" alt="sidebar images"></a></li>
                        <li><a href="#"><img src="images1/sidebar-img/8.jpg" alt="sidebar images"></a></li>
                    </ul>
                   
                </div>
            </div>
            <!-- End Offset MEnu -->
            <!-- Start Cart Panel -->

            <div class="shopping__cart"> 
                <div class="shopping__cart__inner">          
                    <div class="offsetmenu__close__btn">
                    <h2 class="offset-title">Cart</h2>
                        <a href="#"><i class="fas fa-angle-left right"></i></a>
                    </div>                   
                    @if(Session::has('cart'))
                    <div class="shp__cart__wrap">        
                        <div class="shp__single__product">                     
                         <ul>
                            @foreach($items as $item)
                                <li>
                                    <div class="shp__pro__thumb">
                                    <a href="#">
                                        <img src="{{$item['item']->url()}}" alt="product images">
                                    </a>
                                    </div>  
                                    <div class="shp__pro__details">
                                        <h2 id='itemName'><a href="product-details.html"><strong>{{$item['item']['title']}}</strong></a></h2>
                                        <div style="inline">
                                            <span class="quantity">X {{$item['qty']}}</span>
                                            <!-- <span class='quantity'><a href="/reduce/{{$item['item']['id']}}" title="Reduce this item"><i class="fas fa-minus-square"></i></a></span>
                                            <span class='quantity'><a href="/increase/{{$item['item']['id']}}" title="Increase this item"><i class="fas fa-plus-square"></i></a></span> -->
                                        </div>
                                        
                                        <span class="shp__price">Rs. {{$item['item']['purchase_price']}}</span>                                     
                                    </div>
                                    <div class="remove__btn">
                                        <form 
                                        method="get"
                                        action="/remove/{{$item['item']['id']}}" 
                                        title="Remove this item" >
                                        <button class='btn btn-outline-light btn-lg'><i class="ti-trash right"></i></button>
                                        
                                        </form>
                                        <!-- <a href="/remove/{{$item['item']['id']}}" title="Remove this item"><i class="ti-trash right"></i></a> -->
                                    </div>
                                </li>
                            @endforeach
                            </ul>                      
                        </div>
                       
                        <ul class="shoping__total">
                            <li class="subtotal">Subtotal:</li>
                            <li class="total__price">Rs. {{$totalPrice}}</li>
                        </ul>
                    </div>
                    
                    @else
                    <div class="shp__cart__wrap">
                        <p>No Items in the cart.</p>
                    </div>
                    @endif

                   @if(Session::has('cart'))
                    <ul class="shopping__btn">
                    
                        <li><a class='removebtn'>Empty Cart</a></li>
                        <li class="shp__checkout"><a href="/checkout">Checkout</a></li>
                    
                    </ul>
                   @endif
                </div>
            </div>
            <!-- End Cart Panel -->
        </div>
        <!-- End Offset Wrapper -->
        <!-- Start Feature Product -->
        <section class="categories-slider-area bg__white">
            <div class="container">
                <div class="row">
                    <!-- Start Left Feature -->
                    <div class="col-md-9 col-lg-9 col-sm-8 col-xs-12 float-left-style">
                        <!-- Start Slider Area -->
                        <div class="slider__container slider--one">
                            <div class="slider__activation__wrap owl-carousel owl-theme">
                                <!-- Start Single Slide -->
                                @foreach($slider as $slider)
                                <div class="slide slider__full--screen slider-height-inherit slider-text-right" style="background: rgba(0, 0, 0, 0) url({{$slider->url()}}) no-repeat scroll center center / cover ;">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-10 col-lg-8 col-md-offset-2 col-lg-offset-4 col-sm-12 col-xs-12">
                                                <div class="slider__inner">
                                                    <h1>New Product <span class="text--theme">{{$slider->title}}</span></h1>
                                                    <div class="slider__btn">
                                                        <a class="htc__btn" href="#">shop now</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                <!-- End Single Slide -->
                                <!-- Start Single Slide -->
                                
                               
                                <!-- End Single Slide -->
                            </div>
                        </div>
                        <!-- Start Slider Area -->
                    </div> 

                    <div class="col-md-3 col-lg-3 col-sm-4 col-xs-12 float-right-style">
                        <div class="categories-menu mrg-xs">
                            <div class="category-heading">
                           
                               <h3> Browse Categories</h3>
                            </div>
                            <div class="category-menu-list">
                                <ul>   
                                @foreach($sidemenu as $sidemenu)                             
                                   <li><a href="/shopcategory/{{$sidemenu->id}}"><img alt="" src="images1/icons/thum2.png">{{$sidemenu->title}}   
                                   @if(count($sidemenu->children) > 0)
                                   <i class="fas fa-angle-right right"></i></a>
                                        <div class="category-menu-dropdown">
                                            <div class="category-part-1 category-common mb--30">
                                                <h4 class="categories-subtitle"> {{$sidemenu->title}}</h4>
                                                <ul>
                                                    @foreach($sidemenu->children as $children)
                                                    <li><a href="/shopcategory/{{$sidemenu->id}}"> {{$children->title}}</a></li>
                                                    @endforeach
                                                </ul>
                                            </div>                                                                                    
                                        </div>                                 
                                    @endif
                                    </li>
                                @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- End Left Feature -->

                    <!--  shopheader ma xa agade ko tag -->
                </div>   
            </div>
        </section>
        <!-- End Feature Product -->
        <!-- Focus ad -->
        <div class="only-banner ptb--100 bg__white">
            <div class="container">
                <div class="only-banner-img">
                    <a href="shop-sidebar.html"><img src="/images1/new-product/Tmart-banner-03.png" alt="new product"></a>
                </div>
            </div>
        </div><!-- end focus ad -->
        
        <section class="featured_products">
            <div class="container">
                <div class="row">
                <h2>Featured Products</h2>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="ftproduct">
                        <img src="https://web.archive.org/web/20181120080429im_/http://shantoshihandicraft.com/wp-content/uploads/2018/07/136A6020-300x300.jpg" alt="">
                        <h3>Product Title</h3>                            
                        </div>                        
                    </div>
                    <div class="col-md-3">
                        <div class="ftproduct">
                        <img src="https://web.archive.org/web/20180902213942im_/http://shantoshihandicraft.com/wp-content/uploads/2018/06/DSC_2955-300x300.jpg" alt="">
                        <h3>Product Title</h3>                            
                        </div>                        
                    </div>
                    <div class="col-md-3">
                        <div class="ftproduct">
                        <img src="https://web.archive.org/web/20180902214332im_/http://shantoshihandicraft.com/wp-content/uploads/2018/06/DSC_26201-300x300.jpg" alt="">
                        <h3>Product Title</h3>                            
                        </div>                        
                    </div>
                    <div class="col-md-3">
                        <div class="ftproduct">
                        <img src="https://web.archive.org/web/20180902222801im_/http://shantoshihandicraft.com/wp-content/uploads/2018/06/brownieIMG_0114-01-300x300.jpg" alt="">
                        <h3>Product Title</h3>                            
                        </div>                        
                    </div>
                    <div class="col-md-3">
                        <div class="ftproduct">
                        <img src="https://web.archive.org/web/20181120080429im_/http://shantoshihandicraft.com/wp-content/uploads/2018/07/136A6020-300x300.jpg" alt="">
                        <h3>Product Title</h3>                            
                        </div>                        
                    </div>
                    <div class="col-md-3">
                        <div class="ftproduct">
                        <img src="https://web.archive.org/web/20181120080429im_/http://shantoshihandicraft.com/wp-content/uploads/2018/07/136A6020-300x300.jpg" alt="">
                        <h3>Product Title</h3>                            
                        </div>                        
                    </div>
                    <var><div class="col-md-3">
                        <div class="ftproduct">
                        <img src="https://web.archive.org/web/20181120080429im_/http://shantoshihandicraft.com/wp-content/uploads/2018/07/136A6020-300x300.jpg" alt="">
                        <h3>Product Title</h3>                            
                        </div>                        
                    </div></var>
                    
                </div>
            </div>            
        </section><!-- end featured products-->
        <!-- Start Our Product Area -->
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
                                                <h4>Top Rated</h4>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content another-product-style jump">
                                <div class="tab-pane active" id="home1">
                                    <div class="row">
                                        <div class="product-slider-active owl-carousel">
                                        @forelse($latest as $product)
                                            <div class="col-md-3 single__pro col-lg-4 cat--1 col-sm-4 col-xs-12">
                                                <div class="product">
                                                    <div class="product__inner">
                                                        <div class="pro__thumb">
                                                            <a href="/product-detail/{{$product->id}}">
                                                               
                                                                <p></p>
                                                                <img src="{{$product->url()}}" alt="product images">
                                                            </a>
                                                        </div>
                                                        <div class="product__hover__info">
                                                            <ul class="product__action">
                                                                <li><a title="Quick View" class="quick-view modal-view detail-link" href="/product-detail/{{$product->id}}"><span class="ti-eye"></span></a></li>
                                                                @if($product->quantity < 0)

                                                                @else
                                                                <li><a title="Add To Cart" value='{{$product->id}}' class='button' ><span class="ti-shopping-cart"></span></a></li>
                                                                @endif
                                                                
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="product__details">
                                                        <h2><a href="/product-detail/{{$product->id}}">{{ucwords($product->title)}}</a></h2>
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
                                                                <p>No item .</p>
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
                                        @forelse($bestsale as $products)
                                            <div class="col-md-3 single__pro col-lg-4 cat--1 col-sm-4 col-xs-12">
                                                <div class="product">
                                                    <div class="product__inner">
                                                        <div class="pro__thumb">
                                                            <a href="#">
                                                                <img src='{{$products->url()}}' alt="product images">
                                                            </a>
                                                        </div>
                                                        <div class="product__hover__info">
                                                            <ul class="product__action">
                                                                <li><a data-toggle="modal" data-target="#productModal" title="Quick View" class="quick-view modal-view detail-link" href="product-details/{{$products->id}}"><span class="ti-eye"></span></a></li>
                                                                <li><a title="Add TO Cart" href="/add-to-cart/{{$products->id}}"><span class="ti-shopping-cart"></span></a></li>
                                                               
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="product__details">
                                                        <h2><a href="/product-detail/{{$products->id}}">{{ucwords($products->title)}}</a></h2>
                                                        <ul class="product__price">
                                                            @if($products->discount)
                                                                <li class="old__price">Rs.{{$products->sell_price}}</li>
                                                                <li class="new__price">Rs.{{$products->sell_price*(1-$products->discount/100)}}</li>
                                                            @else
                                                            <li class="new__price">Rs.{{$products->sell_price}}</li>
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
                                                            <p>No item on best sale.</p>
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
                                        @forelse($onsale as $products)
                                            <div class="col-md-3 single__pro col-lg-4 cat--1 col-sm-4 col-xs-12">
                                                <div class="product">
                                                    <div class="product__inner">
                                                        <div class="pro__thumb">
                                                            <a href="#">
                                                                <img src='{{$products->url()}}' alt="product images">
                                                            </a>
                                                        </div>
                                                        <div class="product__hover__info">
                                                            <ul class="product__action">
                                                                <li><a data-toggle="modal" data-target="#productModal" title="Quick View" class="quick-view modal-view detail-link" href="product-details/{{$products->id}}"><span class="ti-eye"></span></a></li>
                                                                <li><a title="Add TO Cart" href="/add-to-cart/{{$products->id}}"><span class="ti-shopping-cart"></span></a></li>
                                            
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="product__details">
                                                        <h2><a href="/product-detail/{{$products->id}}">{{ucwords($products->title)}}</a></h2>
                                                        <ul class="product__price">
                                                            @if($products->discount)
                                                                <li class="old__price">Rs.{{$products->sell_price}}</li>
                                                                <li class="new__price">Rs.{{$products->sell_price*(1-$products->discount/100)}}</li>
                                                            @else
                                                            <li class="new__price">Rs.{{$products->sell_price}}</li>
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
                                                        <p>No item on sale</p>
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
        <!-- End Our Product Area -->
        <!-- Testimonials section -->
        <section class="testimonials">
            <div class="container">
            <div>
                <div class="col-md-12">
                <h2>OurHappy Clients</h2>
                </div>
            </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="testimonial">
                            
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end testimonials section -->
        <!-- Start Blog Area -->
        <section class="blogs">
            <div class="container">
            <div class="row">
                <div class="col-md-12">
                <h2>Our Blogs</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-3">
                    <div class="blog">
                        <img src="" alt="blog-title">
                        <span>Created date</span>
                        <h4>Blog Title</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor </p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-3">
                    <div class="blog">
                        <img src="" alt="blog-title">
                        <span>Created date</span>
                        <h4>Blog Title</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor </p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-3">
                    <div class="blog">
                        <img src="" alt="blog-title">
                        <span>Created date</span>
                        <h4>Blog Title</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor </p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-3">
                    <div class="blog">
                        <img src="" alt="blog-title">
                        <span>Created date</span>
                        <h4>Blog Title</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor </p>
                    </div>
                </div>
            </div>
        </section><!-- end blogs section -->
@endsection

