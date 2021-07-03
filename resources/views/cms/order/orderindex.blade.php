@extends('layouts.mastercms')

@section('content')
<div class="content-wrapper container">
    <div class="section">
        <table class='table'>
            <thead>
                <tr>
                <th scope='col'>Id</th>
                <th scope='col'>Customer Name</th>
                <th scope='col'>Phone number</th>
                <th scope='col'>Address</th>
                <th scope='col'>Status</th>
                <th scope='col'>Action</th>
                </tr>
            </thead>
            
            @foreach($posts as $posts)
            <tbody>
                <tr>
                    <td scope="col">{{$posts->id}}</td>
                    <td scope="col"><a href="/order/{{$posts->id}}">{{$posts->firstname}}</a></td>
                    <td scope="col">{{$posts->phone}}</td>
                    <td scope="col">{{$posts->address}}</td>
                    <td scope="col">{{$posts->status}}</td>
                    <td scope="col">
                    <a href="/orderedit/{{$posts->id}}">Manage Order</a>
                        <form action="/orderdel/{{$posts->id}}" method='POST' class="d-inline">
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
