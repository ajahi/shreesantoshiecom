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
                <th scope='col'>Message</th>
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
                    <td scope="col">{{$posts->message}}</td>
                    <td scope="col">
                        @if(!($posts->address))
                        <form action="/orderadd/{{$posts->id}}" method="post">
                        @csrf
                        @method('PUT')
                            <input type="text" name='address'>
                            <button type='Submit'>Submit</button>
                        </form>
                        @else
                            {{$posts->address}}
                        @endif
                    </td>
                    <td scope="col">{{$posts->status}}</td>
                    <td scope="col">
                    <a href="/orderedit/{{$posts->id}}"><i class="nav-icon fas fa-pen pr-5"></i></a>
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
