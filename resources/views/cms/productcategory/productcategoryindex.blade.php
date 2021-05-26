@extends('layouts.mastercms')

@section('content')
<div class="content-wrapper container">
    <div class="section">
        <table class='table'>
            <thead>
                <tr>
                <th scope='col'>id</th>
                <th scope='col'>title</th>
                <th scope='col'>description</th>
                <th scope='col'>parent_id</th> 
                <th scope='col'>Action</th>
                </tr>
            </thead>
            
            @foreach($productcategory as $posts)
            <tbody>
                <tr>
                <td scope="col">{{$posts->id}}</td>
                <td scope="col">{{$posts->title}}</td>
                <td scope="col">{{$posts->description}}</td>
                <td scope="col">{{$posts->parent_id}}</td>
                <td scope="col">
                <a href="/productcategory/{{$posts->id}}"><i class="nav-icon fas fa-pen pr-5"></i></a>
                <form action="/productcategorydel/{{$posts->id}}" method='POST'>
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