@extends('layouts.mastercms')

@section('content')
<div class="content-wrapper container">
    <div class="section">
        <table class='table'>
            <thead>
                <tr>
                <th scope='col'>id</th>
                <th scope='col'>Product_name/Price/Quantity</th>
                <th scope='col'>Order_number</th>
                <th scope='col'>Quantity</th> 
                <th scope='col'>Action</th>
                </tr>
            </thead>
            
            @foreach($product as $posts)
            <tbody>
                <tr>
                <td scope="col">{{$posts->id}}</td>
                <td scope="col">{{$posts->product->title}}/{{$posts->product->sell_price}}/{{$posts->product->quantity}}</td>
                
                <td scope="col">{{$posts->order_id}}</td>
                <td scope="col">{{$posts->quantity}}</td>
                <td scope="col">
                
                <form action="/orderdel/{{$posts->id}}" method='POST'>
                    @csrf
                    @method('DELETE')
                    <button><i class="nav-icon fas fa-trash"></i></button>
                </form>
               
                </td>
                </tr>
            </tbody>
            @endforeach
        </table>
    </div>
</div>
@endsection
