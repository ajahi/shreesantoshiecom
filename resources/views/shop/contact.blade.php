@extends('layouts.shop')
@section('title')
Shree Santoshi Mata Hastakala
@endsection

@section('sidemenu')
<div class='container'>
@include('flash')
</div>

            <div class="offsetmenu">
                <div class="offsetmenu__inner">
                    <div class="offsetmenu__close__btn">
                        <a href="#"><i class="zmdi zmdi-close"></i></a>
                    </div>
                   
                    
                    
    
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
        <section class="htc__contact__area ptb--120 bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                        <div class="htc__contact__container">
                            <div class="htc__contact__address">
                                <h2 class="contact__title">contact info</h2>
                                <div class="contact__address__inner">
                                    <!-- Start Single Adress -->
                                    <div class="single__contact__address">
                                        <div class="contact__icon">
                                            <span class="ti-location-pin"></span>
                                        </div>
                                        <div class="contact__details">
                                            <p>Location : <br> Sunsan Gali Bhut bangla ke samne</p>
                                        </div>
                                    </div>
                                    <!-- End Single Adress -->
                                </div>
                                <div class="contact__address__inner">
                                    <!-- Start Single Adress -->
                                    <div class="single__contact__address">
                                        <div class="contact__icon">
                                            <span class="ti-mobile"></span>
                                        </div>
                                        <div class="contact__details">
                                            <p> Phone : <br><a href="#">+999 999 999 999 </a></p>
                                        </div>
                                    </div>
                                    <!-- End Single Adress -->
                                    <!-- Start Single Adress -->
                                    <div class="single__contact__address">
                                        <div class="contact__icon">
                                            <span class="ti-email"></span>
                                        </div>
                                        <div class="contact__details">
                                            <p> Mail :<br><a href="#">info@example.com</a></p>
                                        </div>
                                    </div>
                                    <!-- End Single Adress -->
                                </div>
                            </div>
                            <div class="contact-form-wrap">
                            <div class="contact-title">
                                <h2 class="contact__title">Get In Touch</h2>
                            </div>
                            <form method="post"  action="/mails" >
                            @csrf
                                <div class="single-contact-form">
                                    <div class="contact-box name">
                                        <input type="text" name="name" placeholder="Your Name*">
                                        <input type="email" name="email" placeholder="E-Mail*">
                                    </div>
                                </div>
                                <div class="single-contact-form">
                                    <div class="contact-box subject">
                                        <input type="text" name="subject" placeholder="Subject*">
                                    </div>
                                </div>
                                <div class="single-contact-form">
                                    <div class="contact-box message">
                                        <textarea name="message"  placeholder="Message*"></textarea>
                                    </div>
                                </div>
                                <div class="contact-btn">
                                    <button type="submit" class="fv-btn">SEND</button>
                                </div>
                            </form>
                        </div> 
                        <div class="form-output">
                            <p class="form-messege"></p>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 smt-30 xmt-30">
                        <div class="map-contacts">
                            <div id="googleMap">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6263.864895327552!2d83.98594118035787!3d28.22324815547767!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m3!3e1!4m0!4m0!5e0!3m2!1sen!2snp!4v1624723942147!5m2!1sen!2snp" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection