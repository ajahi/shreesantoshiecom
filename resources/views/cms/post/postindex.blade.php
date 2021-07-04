@extends('layouts.mastercms')

@section('content')
<div class="content-wrapper container">
@include('flash')
    <div class="section">
    <a href="postcreate" class="btn btn-primary my-2"><i class="fas fa-plus mr-1"></i>Create</a>
        <table class='table'>
            <thead>
                <tr>
                <th scope='col'>Id</th>
                <th scope='col'>Title</th>
                <!-- <th scope='col'>Description</th> -->
                <th scope='col'>Image</th>
                <th scope='col'>Status</th>
                <th scope='col'>Action</th>
                </tr>
            </thead>
            
            @foreach($posts as $posts)
            <tbody>
                <tr>
                <td scope="col">{{$posts->id}}</td>
                <td scope="col"><a href="/postshow/{{$posts->id}}">{{$posts->title}}</a></td>
                <!-- <td scope="col">{{substr($posts->description,150)}}...</td> -->
                @if($posts->url())
                    <td scope='col'><img src="{{$posts->url()}}" width="80" height="80" alt="">
                @else
                    <td>
                    <p>No-image</p>
                    </td>
                </td>
                @endif
                <td scope="col">{{$posts->status}}</td>
                <td scope="col">
                <a href="/post/{{$posts->id}}"><i class="nav-icon fas fa-pen pr-5"></i></a>
                <form action="/postdel/{{$posts->id}}" method='POST' class="d-inline">
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
