
<div class="form-group py-4">
                              <label for="">Store Name</label>
							  <input type="text" name="name" class="form-control" value="{{$store->name }}">
                            </div>

                            <div class="form-group">
                              <label for="image">Image</label>
                               <input type="file" name="image" class="form-control" />
                               @if($store->image)
                               <img src="{{asset('storage/'.$store->image)}}" alt="" height="60">
                               @endif
                             </div>

							<div class="form-group py-4">
                              <label for="">Description</label>
                               <textarea class="form-control" name="description">{{$store->description}}</textarea>
							</div>

                            <div class="mb-3">
                                <label class="form-label">Store email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Store email" value="{{$store->email }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Store password" value="{{$store->password }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Store Phone</label>
                                <input type="phone" class="form-control" id="phone" name="phone" placeholder="Store phone" value="{{$store->phone }}">
                            </div>

							  <div class="form-group py-4">
                                <label for="">Status</label>
                                   <div>
                                     <div class="form-check py-2">
                                       <input class="form-check-input" type="radio" name="status" value="active" checked @checked($store->status =='active')>
									   <label class="form-check-label">Active</label>
									 </div>
									 <div class="form-check py-3">
                                       <input class="form-check-input" type="radio" name="status" value="archived" @checked($store->status =='archived')>
									   <label class="form-check-label">Archived</label>
									 </div>
                                   </div>
                              </div>

							  <div class="form-group">
                               <button type="submit" class="btn btn-primary">{{$button_label ?? 'Save'}}</button>
                               </div>
