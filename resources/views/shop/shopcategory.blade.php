@extends('layouts.shop')
@section('title')
    Shree Santoshi Mata Hastakala
@endsection
      
@section('sidemenu')
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
                                        <a href="/remove/{{$item['item']['id']}}" title="Remove this item"><i class="fas fa-trash right"></i></i></a>
                                    </div>
                                </li>
                            @endforeach
                            </ul>                      
                        </div>
                       
                        <ul class="shoping__total">
                            <li class="subtotal">Subtotal:</li>
                            <li class="total__price">RS. {{$totalPrice}}</li>
                        </ul>
                    </div>
                    
                    @else
                    <div class="shp__cart__wrap">
                        <p>No Items in the cart.</p>
                    </div>
                    @endif

                   @if(Session::has('cart'))
                    <ul class="shopping__btn">
                    <li><a href="/newcart">Empty Cart</a></li>
                        <li class="shp__checkout"><a href="/checkout">Checkout</a></li>
                    </ul>
                   @endif
                </div>
            </div>
            <!-- End Cart Panel -->
        </div>
        <div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(/images1/bg/2.jpg) no-repeat scroll center center / cover ;">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="bradcaump__inner text-center">
                                <h2 class="bradcaump-title">{{$procat->title}}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         <!-- End Bradcaump area -->
         @if($count > 0)
         <div class="portfolio-grid-area bg__white pt--130 pb--100">
		    <div class="container">
		        
                <div class="portfolio-style">
                    <div class="row grid">
                    @foreach($pro as $pro)
                    <a href="/product-detail/{{$pro->id}}">
                        <div class="col-md-4 col-sm-4 col-xs-12 grid-item cat2 cat3">  
                            <div class="single-portfolio-card mb--30">
                                <div class="portfolio-img">
                                    <a href="/product-detail/{{$pro->id}}">
                                        <img src="{{$pro->url()}}" alt="" />
                                    </a>
                                </div>
                                <div class="portfolio-title portfolio-card-title text-center">
                                    <h3><a href="/product-detail/{{$pro->id}}"><strong>{{ucwords($pro->title)}}</strong></a></h3>
                                    <span>{{ucwords($procat->title)}}</span>
                                </div>				
                            </div>			
                        </div> 
                    </a> 
                        @endforeach	                       
                    </div>		
                </div>
		    </div>
		</div>
        @else
        <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="bradcaump__inner text-center">
                                <h2 class="bradcaump-title">Sorry no items available for this category.</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
@endsection