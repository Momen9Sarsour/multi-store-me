@if($errors->any())
<div class="alert alert-danger">
  <h3>Error Occured</h3>
  <ul>
    @foreach($errors->all() as $error)
    <li>{{$error}}</li>
    @endforeach
  </ul>
</div>
@endif
                               <div class="form-group py-4">
                               <x-form.input label="Delivery Name" class="form-control-lg" role="input" name="name" :value="$delivery->name"/>
                               </div>
							   <div class="form-group">
                               <x-form.label id="image">Image</x-form.label>
                               <x-form.input type="file" name="image" class="form-control" accept="image/*"/>
                                @if($delivery->image)
                                <img src="{{asset('storage/'.$delivery->image)}}" alt="" height="60">
                                @endif
                              </div>
                              <div class="form-group py-4">
                               <x-form.input label="Delivery Email" type="email" class="form-control-lg" role="input" name="email" :value="$delivery->email"/>
                               </div>
                              <div class="form-group py-4">
                               <x-form.input label="Password Delivery" type="password" class="form-control-lg" role="input" name="password" :value="$delivery->password"/>
                               </div>
                               <div class="form-group py-4">
                               <x-form.input label="Phone Number" type="number" class="form-control-lg" role="input" name="phone" :value="$delivery->phone"/>

                               </div>
                               <div class="form-group py-4">
                               <x-form.input label="Address" class="form-control-lg" role="input" name="address" :value="$delivery->address"/>
                               </div>
                               <div class="form-group py-4">
                                <x-form.input label="Ipan" type="number" class="form-control-lg" role="input" name="ipan" :value="$delivery->ipan"/>
                               </div>
							  <div class="form-group">
                               <button type="submit" class="btn btn-primary">Save</button>
                               </div>
