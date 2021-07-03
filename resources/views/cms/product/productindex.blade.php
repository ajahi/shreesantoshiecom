@extends('layouts.mastercms')

@section('content')
<div class="content-wrapper container">
@include('flash')
    <div class="section">
    <a href="productcreate" class="btn btn-primary my-2"><i class="fas fa-plus mr-1"></i>Create</a>
        <table class='table'>
            <thead>
                <tr>
                <th scope='col'>id</th>
                <th scope='col'>Title</th>
                <th scope='col'>Description</th>
                <th scope='col'>Quantity</th> 
                <th scope='col'>Action</th>
                </tr>
            </thead>
            
            @foreach($product as $posts)
            <tbody>
                <tr>
                <td scope="col">{{$posts->id}}</td>
                <td scope="col"><a href="/product/{{$posts->id}}">{{$posts->title}}</a></td>
                
                <td scope="col">{{$posts->description}}</td>
                <td scope="col">{{$posts->quantity}}</td>
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
    </div>
</div>
@endsection
