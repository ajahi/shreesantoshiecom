
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
                                <h2 class="section-title-3">Details</h2>
                                <div class="table-content table-responsive">
                                <table>
                                    <thead>
                                        <tr>                                        
                                            <th class="product-name">Product</th>
                                            <th class="product-price">Price</th>
                                            <th class="product-quantity">Quantity</th>
                                            <th class="product-subtotal">Sub-total</th>
                                            <th class="product-remove">Remove</th>
                                        </tr>
                                    </thead>
                                    
                                    @foreach($cart->items as $cart)
                                    <tbody>                                       
                                        <tr>
                                            <td class="product-name"><span class='amount'>{{$cart['item']['title']}}</span></td>
                                            <td class="product-price"><span class="amount">{{$cart['item']['sell_price']}}</span></td>
                                            <td class="product-quantity"><span class="amount" >
                                            {{$cart['qty']}}
                                            <a href="/reduce/{{$cart['item']['id']}}" title="Reduce this item"><i class="fas fa-minus-square"></i></a>
                                            <a href="/increase/{{$cart['item']['id']}}" title="Increase this item"><i class="fas fa-plus-square"></i></a>
                                            </span></td>
                                            <td class="product-subtotal">{{$cart['price']}}</td>
                                            <td class="product-remove"><a href="remove/{{$cart['item']['id']}}">X</a></td>
                                        </tr>
                                    </tbody>
                                    @endforeach
                                    
                                </table>
                               
                            </div>
                            <div class="section">
                                <h2 class="section-title-3 ">Subtotal : </h2> <h2 class="section">RS {{Session::get('cart')->totalPrice}}</h2>
                            </div>
                            
                                <div class="checkout-form-inner">
                                    <form action="/order" method="POST">
                                    @csrf
                                        <div class="single-checkout-box">
                                            <input type="text" placeholder="First Name*" name='firstname'>
                                            <input type="text" placeholder="Last Name*" name='lastname'>
                                        </div>
                                        <div class="single-checkout-box">
                                            <input type="email" placeholder="Email*" name='email'>
                                            <input type="number" placeholder="Phone*" name='phone'>
                                        </div>
                                        <div class="single-checkout-box">
                                            <input type="text" placeholder="Address" name='address'>
                                            
                                        </div>
                                        <div class="our-payment-sestem">
                                            <button class="ts-btn  btn-large hover-theme" type='submit'> CONFIRM </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- End Checkbox Area -->
                            <!-- Start Payment Box -->
                          
                            <!-- End Payment Box -->
                            <!-- Start Payment Way -->
                            
                            <!-- End Payment Way -->
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="checkout-right-sidebar">
                            <div class="our-important-note">
                                <h2 class="section-title-3">Note:</h2>
                                <p>Direct payment is not available as of right now we will confirm your order with a phone call.Happy shopping.</p>                
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