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
                                        <h2 id='itemName'><a class='detail-product' value='{{$item['item']['slug']}}'><strong>{{$item['item']['title']}}</strong></a></h2>
                                        <div style="inline">
                                            <span class="quantity">X {{$item['qty']}}</span>
                                            <!-- <span class='quantity'><a href="/reduce/{{$item['item']['id']}}" title="Reduce this item"><i class="fas fa-minus-square"></i></a></span>
                                            <span class='quantity'><a href="/increase/{{$item['item']['id']}}" title="Increase this item"><i class="fas fa-plus-square"></i></a></span> -->
                                        </div>
                                        
                                        <span class="shp__price">Rs. {{$item['item']->price()}}</span>                                     
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
        <!-- Breadcrumb sectio  -->
        <div class="ht__bradcaump__area">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                    <div class="bradcaump__inner text-center">
                        <h2 class="bradcaump-title">Blogs</h2>
                        <nav class="bradcaump-inner">              
                            <nav class="" role="navigation" aria-label="breadcrumbs">
                                <ul class="breadcrumb-list">
                                    <li>
                                    <a href="/" title="Back to the home page">Home</a>
                                    </li>
                                    <li> 
                                        <span>Our Blogs</span>
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
        <section class="htc__product__area shop__page ptb--130 bg__white site_blogs blogs-page">
            <div class="container">
            <div class="row">
            
            <div class="col-md-9 col-sm-12">
            
                    <div class="row">
                    <ul>
                @foreach($blogs as $blogs)
                        <div class="col-sm-12 col-md-4">
                            <div class="blog">
                                <a href="/blog/{{$blogs->slug}}">
                                @if(!($blogs->url()))
                                    <img src="https://cdn.pixabay.com/photo/2017/08/02/01/29/lifestyle-2569543__340.jpg" alt="blog-title">
                                @else
                                    <img src="{{$blogs->url()}}" alt="blog-title">
                                @endif
                                    <span>Created date : {{$blogs->created_at}}</span>
                                    <h4>{{$blogs->title}}</h4>
                                    <p>{{$blogs->description}} </p>
                                </a>
                            </div>
                        </div>   
                        @endforeach
            </ul>  
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
                 <!-- Most popular blogs top 5 -->
                 <div class="col-md-3">  
                            <!-- Start popular blogs -->                            
                            <div class="htc__shop__cat">    
                                <h4 class="section-title-4">Most Popular Blogs</h4>    
                                <ul class="sidebar__list">  
                                @foreach($popular as $popular)    
                                <li class="most_pop">
                                    <div class="row">
                                        <div class="col-sm-4">
                                        @if(!($popular->url()))
                                            <img src="https://cdn.pixabay.com/photo/2017/08/02/01/29/lifestyle-2569543__340.jpg" alt="blog-title">
                                        @else
                                            <img src="{{$popular->url()}}" alt="blog-title">
                                        @endif
                                        </div>
                                        <div class="col-sm-8">
                                            <h3><a href="blog/{{$popular->slug}}">{{$popular->title}}</a></h3>
                                        </div>
                                    </div>
                                </li>
                               @endforeach       
                                </ul>
                            </div> 
                </div> 
                <!-- end sidebar populars -->
            </div>
            
        </section><!-- end blogs section -->
                    
                    
                
@endsection