
@extends('layouts.shop')
@section('title')
Shree Santoshi Mata Hastakala
@endsection

@section('sidemenu')
<body> 
<div class="body__overlay"></div>
        <!-- Start Offset Wrapper -->
        <div class="offset__wrapper">
            <!-- Start Search Popap -->
            <!-- End Search Popap -->
            <!-- Start Offset MEnu -->
            <div class="offsetmenu">
                <div class="offsetmenu__inner">
                    <div class="offsetmenu__close__btn">
                        <a href="#"><i class="zmdi zmdi-close"></i></a>
                    </div>
                    <div class="off__contact">
                        <div class="logo">
                            <a href="index.html">
                                <img src="images1/logo/logo1.png" alt="logo">
                            </a>
                        </div>
                        <p>Lorem ipsum dolor sit amet consectetu adipisicing elit sed do eiusmod tempor incididunt ut labore.</p>
                    </div>
                  
                    
                    <div class="offset__sosial__share">
                        <h4 class="offset__title">Follow Us On Social</h4>
                        <ul class="off__soaial__link">
                            <li><a class="bg--twitter" href="#"  title="Twitter"><i class="zmdi zmdi-twitter"></i></a></li>
                            
                            <li><a class="bg--instagram" href="#" title="Instagram"><i class="zmdi zmdi-instagram"></i></a></li>

                            <li><a class="bg--facebook" href="#" title="Facebook"><i class="zmdi zmdi-facebook"></i></a></li>

                            <li><a class="bg--googleplus" href="#" title="Google Plus"><i class="zmdi zmdi-google-plus"></i></a></li>

                            <li><a class="bg--google" href="#" title="Google"><i class="zmdi zmdi-google"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
        <!-- End Offset Wrapper -->
        <!-- Start Bradcaump area -->
        <div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(images/bg/2.jpg) no-repeat scroll center center / cover ;">
            <div class="ht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="bradcaump__inner text-center">
                                <h2 class="bradcaump-title">Checkout</h2>
                                <nav class="bradcaump-inner">
                                  <a class="breadcrumb-item" href="index.html">Home</a>
                                  <span class="brd-separetor">/</span>
                                  <span class="breadcrumb-item active">Checkout</span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Bradcaump area -->
        <!-- Start Checkout Area -->
        <section class="our-checkout-area ptb--120 bg__white">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-lg-8">
                        <div class="ckeckout-left-sidebar">
                            <!-- Start Checkbox Area -->
                            <div class="checkout-form">
                                <h2 class="section-title-3">Billing details</h2>
                                <div class="checkout-form-inner">
                                    <div class="single-checkout-box">
                                        <input type="text" placeholder="First Name*">
                                        <input type="text" placeholder="Last Name*">
                                    </div>
                                    <div class="single-checkout-box">
                                        <input type="email" placeholder="Emil*">
                                        <input type="text" placeholder="Phone*">
                                    </div>
                                    <div class="single-checkout-box">
                                        <textarea name="message" placeholder="Message*"></textarea>
                                    </div>
                                    
                                    
                                    
                                </div>
                            </div>
                            <!-- End Checkbox Area -->
                            <!-- Start Payment Box -->
                          
                            <!-- End Payment Box -->
                            <!-- Start Payment Way -->
                            <div class="our-payment-sestem">
                                <h2 class="section-title-3">We  Accept :</h2>
                                <ul class="payment-menu">
                                    <li><a href="#"><img src="images1/payment/1.jpg" alt="payment-img"></a></li>
                                    <li><a href="#"><img src="images1/payment/2.jpg" alt="payment-img"></a></li>
                                    <li><a href="#"><img src="images1/payment/3.jpg" alt="payment-img"></a></li>
                                    <li><a href="#"><img src="images1/payment/4.jpg" alt="payment-img"></a></li>
                                    <li><a href="#"><img src="images1/payment/5.jpg" alt="payment-img"></a></li>
                                </ul>
                                <div class="checkout-btn">
                                    <a class="ts-btn btn-light btn-large hover-theme" href="#">CONFIRM & BUY NOW</a>
                                </div>    
                            </div>
                            <!-- End Payment Way -->
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="checkout-right-sidebar">
                            <div class="our-important-note">
                                <h2 class="section-title-3">Cart:</h2>
                               
                                

                                <div class="table-content table-responsive">
                                <table>
                                    <thead>
                                        <tr>                                        
                                            <th class="product-name">Product</th>
                                            <th class="product-price">Price</th>
                                            <th class="product-quantity">Quantity</th>
                                            <th class="product-subtotal">Total</th>
                                            <th class="product-remove">Remove</th>
                                        </tr>
                                    </thead>
                                    
                                    @foreach($cart->items as $cart)
                                    <tbody>                                       
                                        <tr>
                                            <td class="product-name"><span class='amount'>$cart['item']['title']</span></td>
                                            <td class="product-price"><span class="amount">{{$cart['item']['purchase_price']}}</span></td>
                                            <td class="product-quantity"><input type="number" value={{$cart['quantity']}} /></td>
                                            <td class="product-subtotal"></td>
                                            <td class="product-remove"><a href="#">X</a></td>
                                        </tr>
                                    </tbody>
                                    @endforeach
                                   
                                </table>
                            </div>
                                
                            </div>
                            <div class="puick-contact-area mt--60">
                                <h2 class="section-title-3">Quick Contract</h2>
                                <a href="phone:+8801722889963">+012 345 678 102 </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection