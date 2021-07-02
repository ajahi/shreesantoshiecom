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
                        <h2 class="bradcaump-title">Products</h2>
                        <nav class="bradcaump-inner">              
                            <nav class="" role="navigation" aria-label="breadcrumbs">
                                <ul class="breadcrumb-list">
                                    <li>
                                    <a href="/" title="Back to the home page">Home</a>
                                    </li>
                                    <li> 
                                        <span>All Products</span>
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
     
        <section class="htc__product__area shop__page ptb--130 bg__white">
            <div class="container">
                <div class="htc__product__container">
                    <div class="row">
                        <!-- Side bar categories -->
                        <div class="col-md-3">  
                            <!-- Start Product Cat -->                            
                            <div class="htc__shop__cat">    
                                <h4 class="section-title-4">Categories</h4>    
                                <ul class="sidebar__list">      
                                
                                <li class=""><a href="/shop-category/cat-slug">Category title<span>11</span></a></li>                                       
                                
                                <li class=""><a href="/shop-category/cat-slug">Category title1<span>12</span></a></li>                                       
                                
                                <li class=""><a href="/shop-category/cat-slug">Category title2<span>11</span></a></li>                                       
                                
                                <li class=""><a href="/shop-category/cat-slug">Category title3<span>12</span></a></li>                                       
                                
                                <li class=""><a href="/shop-category/cat-slug">Category four<span>11</span></a></li>                                       
                                
                                </ul>
                            </div> 
                        </div> 
                        <!-- end sidebar categories -->
                        <div class="col-md-9 col-sm-12">
                        <div class="row">
                        <div class="product__list another-product-style">
                            <!-- Start Single Product -->
                            @foreach($pro as $pro)
                            <div class="col-md-4 single__pro col-lg-4 cat--1 col-sm-4 col-xs-12">
                                <div class="product foo">
                                    <div class="product__inner">
                                        <div class="pro__thumb">
                                            <a href="/product-detail/{{$pro->id}}">
                                                <img src="{{$pro->url()}}" alt="product images">
                                            </a>
                                        </div>
                                        <div class="product__hover__info">
                                                <ul class="product__action">
                                                    <li><a title="Quick View" class="quick-view modal-view detail-link" href="/product-detail/{{$pro->id}}"><span class="ti-eye"></span></a></li>
                                                    @if($pro->quantity < 0)

                                                    @else
                                                    <li><a title="Add To Cart" value='{{$pro->id}}' href='add-to-cart/{{$pro->id}}' ><span class="ti-shopping-cart"></span></a></li>
                                                    @endif
                                                    <li><a title="Wishlist" href="wishlist.html"><span class="ti-heart"></span></a></li>                
                                                </ul>
                                        </div>
                                    </div>
                                    <div class="product__details">
                                        <h2><a href="product-details.html">{{$pro->title}}</a></h2>
                                            <ul class="product__price">
                                                @if($pro->discount)
                                                    <li class="old__price">Rs.{{$pro->sell_price}}</li>
                                                    <li class="new__price">Rs.{{$pro->sell_price*(1-$pro->discount/100)}}</li>
                                                @else
                                                    <li class="new__price">Rs.{{$pro->sell_price}}</li>
                                                @endif
                                            </ul>  
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <!-- End Single Product -->
  
                        </div>
                    </div>
                        </div>
                    </div>                                
                    
                    
                    <!-- Start Load More BTn -->
                    <div class="row mt--60">
                        <div class="col-md-12">            
                            <div class="page-pagination text-center col-xs-12 fix">
                            <nav class="pagination">
                                <ul class="">
                                <li>                                    
                                </li><li class="disabled prev">
                                    <a href="">
                                    <span><i class="zmdi zmdi-chevron-left"></i></span>
                                    </a>
                                </li>                              
                                <li class="active"><a href="">1</a></li>
                                <li>
                                    <a href="/shop/all?page=2" title="">2</a>
                                </li>                             
                                <li class="next"><a href="/shop/all?page=2" title="Next »"><span aria-hidden="true"><i class="zmdi zmdi-chevron-right"></i></span></a></li>
                                </ul>
                            </nav>
                            </div>
                        </div>
                     </div>
                    <!-- End Load More BTn -->
                </div>
            </div>
        </section>
@endsection