@extends('layouts.mastercms')

@section('content')
<div class="content-wrapper container">
    <div class="section">
        <table class='table'>
            <thead>
                <tr>
                <th scope='col'>id</th>
                <th scope='col'>title</th>
                <th scope='col'>desc</th>
                <th scope='col'>Action</th>
                </tr>
            </thead>
            
            @foreach($Tag as $posts)
            <tbody>
                <tr>
                <td scope="col">{{$posts->id}}</td>
                <td scope="col">{{$posts->title}}</td>
                <td scope="col">{{$posts->description}}</td>
                <td scope="col">
                <a href="/tag/{{$posts->id}}"><i class="nav-icon fas fa-pen pr-5"></i></a>
                <form action="/tagdel/{{$posts->id}}" method='POST'>
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
