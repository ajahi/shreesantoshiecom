@include('header')

<div class="content-wrapper container">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                 <div class="col-sm-6">
                     <h1>Create a Tag.</h1>
                 </div>
            </div>
        </div>
    </section>
    <section class='mx-'>
    <form method='POST'action="/user">
    @csrf
        <div class="form-floating my-3">
            <input type="text" class="form-control col-lg-7" name="name" placeholder="Your Name.">
         </div>
        <div class="form-floating my-3">
            <input type="email" class="form-control col-lg-7" name="email" placeholder="Your email.">
        </div>
        <div class="form-floating my-3">
            <input type="password" class="form-control col-lg-7" name="password" placeholder="Your password.">
        </div>
        
        <div class="form-floating my-3">
        <label for="Category_id">Role</label>
            <select class="form-select" name="role_id" aria-label="Floating label select example">         
                @foreach($role as $role)
                <option value={{$role->id}}>{{$role->name}}</option>
                @endforeach
            </select>
        </div>
        <button type='Submit' class="btn btn-info"> Submit</button>
    </form>
    </section>
    
</div>
@include('footer')
