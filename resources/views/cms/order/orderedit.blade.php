
@extends('layouts.mastercms')

@section('content')
<div class="content-wrapper container">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                 <div class="col-sm-6">
                     <h1>Edit Order.</h1>
                 </div>
            </div>
        </div>
    </section>
    <section class='mx-2'>
    <form method='POST'action="/orderedit/{{$order->id}}">
    @csrf
    @method('PUT')
        <div class="form-floating my-3">
        <label for="">Address</label>
            <input  class="form-control col-lg-7" name="address" placeholder="Adress of the order" value='{{$order->address}}' required>
         </div>
        <div class="form-floating my-3">
        <label for="">Message</label>
            <textarea required class="form-control col-lg-7" placeholder="Message" name="message" style="height: 100px">{{$order->message}}</textarea>
        </div>
        
        <div class="form-floating my-3">
        <label for="Category_id">Status</label>
            <select class="form-select" name="status" aria-label="Floating label select example"> 
                <option value="ordered">Ordered</option>  
                <option value="delivered">Delivered</option>
                <option value="complete">Complete</option>
            </select>
        </div>
        <button type='Submit' class="btn btn-info"> Submit</button>
    </form>
    </section>
    
</div>
@endsection