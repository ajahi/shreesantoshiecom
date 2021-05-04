@include('header')
<div class="content-wrapper container">
    <div class="section">
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
                <td scope="col"><a href="/productshow/{{$posts->id}}">{{$posts->title}}</a></td>
                
                <td scope="col">{{$posts->description}}</td>
                <td scope="col">{{$posts->quantity}}</td>
                <td scope="col">
                <a href="/product/{{$posts->id}}"><i class="nav-icon fas fa-pen pr-5"></i></a>
                <form action="/productdel/{{$posts->id}}" method='POST'>
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
@include('footer')
