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
                                    <span class="search__close__btn_icon"><i class="zmdi zmdi-close"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Search Popap -->
            <!-- Start Offset MEnu -->
            
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
        <!-- Breadcrumb sectio  -->
        <div class="ht__bradcaump__area">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                    <div class="bradcaump__inner text-center">
                        <h2 class="bradcaump-title">About Us</h2>
                        <nav class="bradcaump-inner">              
                            <nav class="" role="navigation" aria-label="breadcrumbs">
                                <ul class="breadcrumb-list">
                                    <li>
                                    <a href="/" title="Back to the home page">Home</a>
                                    </li>
                                    <li> 
                                        <span>About Us</span>
                                    </li>
                                </ul>
                            </nav>
                        </nav>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
        <!-- end breadcrumb section -->
     
       
                    
                    <!-- Start Blog Area -->
        <section class="htc__product__area shop__page ptb--130 bg__white site_blogs single-page">
            <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section__title section__title--2 text-center">                    
                    <h2 class="title__line">Welcome To Shantosi Store</h2>                   
                    
                    <p>{{$about}}
           </p>
                    
                    </div>       
      
                </div>
            </div>
            </div>
            
        </section><!-- end welcome section -->

        <!-- why us section -->
        <section data-section="AboutInfo" class="htc__choose__us__ares bg__white pb--120 ">
            <div class="container-fluid">
                <div class="row">
                
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="video__wrap bg--3" data--black__overlay="5">
                    <div class="video__inner">
                        <a class="video__trigger video-popup" href="https://www.youtube.com/watch?v=T1W6CiAeW7Q">
                        <i class="zmdi zmdi-play"></i>
                        </a>
                    </div>
                    </div>
                </div>
                
                
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="htc__choose__wrap bg__cat--4">
                    
                    <h2 class="choose__title">Why Choose Us?</h2>
                    
                    <div class="choose__container">
                        <div class="single__chooose">
                        
                        <div class="choose__us">
                            <div class="choose__icon">
                            <span class="ti-heart"></span>
                            </div>
                            <div class="choose__details">
                            <h4>Free Gift Box</h4>
                            <p>Lorem ipsum dolor sit amet consect adipisic elit sed do. </p>
                            </div>
                        </div>
                        
                        
                        <div class="choose__us">
                            <div class="choose__icon">
                            <span class="ti-truck"></span>
                            </div>
                            <div class="choose__details">
                            <h4>Free Delevery</h4>
                            <p>Lorem ipsum dolor sit amet consect adipisic elit sed do. </p>
                            </div>
                        </div>
                        
                        </div>
                        <div class="single__chooose">
                        
                        <div class="choose__us">
                            <div class="choose__icon">
                            <span class="ti-reload"></span>
                            </div>
                            <div class="choose__details">
                            <h4>Money Back</h4>
                            <p>Lorem ipsum dolor sit amet consect adipisic elit sed do. </p>
                            </div>
                        </div>
                        
                        
                        <div class="choose__us">
                            <div class="choose__icon">
                            <span class="ti-time"></span>
                            </div>
                            <div class="choose__details">
                            <h4>Support 24/7</h4>
                            <p>Lorem ipsum dolor sit amet consect adipisic elit sed do. </p>
                            </div>
                        </div>
                        
                        </div>
                    </div>
                    </div>
                </div>
                
                </div>
            </div>
            </section>
        <!-- end why us section -->
                    
                    
                
@endsection