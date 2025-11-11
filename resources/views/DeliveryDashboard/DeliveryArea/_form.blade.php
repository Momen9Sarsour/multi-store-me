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
  <x-form.input label="City" class="form-control-lg" role="input" name="city" :value="$deliveryarea->city" />
</div>


<div class="form-group py-4">
  <x-form.input label="Delivery Price" type="number" class="form-control-lg" role="input" name="DeliverPrice" :value="$deliveryarea->DeliverPrice" />

</div>


<div class="form-group">
  <button type="submit" class="btn btn-primary">Save</button>
</div>