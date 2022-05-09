@extends('layouts.master2')
@section('title','Dashboard')
@section('content')

    <!-- Edit Modal -->
    {{-- <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Food Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ url('/updatechef') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row modal-body">
                      <div class="form-group mb-3 col-6">
                        <label class="form-label">Chef Name</label>
                        <input type="hidden" name="id" id="data_id" class="form-control">
                        <input style="color: white" type="text" name="name" id="data_name" placeholder="Name" class="form-control" value="" required> @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                      </div>
                      <div class="form-group mb-3 col-6">
                        <label class="form-label">Speciality</label>
                        <input style="color: white" class="form-control" type="text" name="speciality" id="data_speciality" placeholder="Speciality" value="" required>@error('speciality')<small class="text-danger">{{ $message }}</small>@enderror
                      </div>
                      <div class="form-group mb-3">
                        <label class="form-label">Image</label>
                        <input style="color: white" type="file" name="image" id="data_image" placeholder="Image" class="form-control" value=""> @error('image')<small class="text-danger">{{ $message }}</small>@enderror
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}
    <!-- Edit Modal -->

    <div id="top">
        <table class="table table-stripped table-hover table-bordered" style="text-align: center">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Food Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
        <form action="{{ url('/orderconfirm') }}" method="post">
            @csrf
                @foreach ($lists as $list)
                <tr>
                    <td>
                        <input type="text" name="foodname[]" value="{{ $list->title }}" style="border:none;text-align:center" hidden>
                        {{ $list->title }}
                    </td>
                    <td>
                        <input type="text" name="price[]" value="{{ $list->price }}" style="border:none;text-align:center" hidden>
                        {{ $list->price }}
                    </td>
                    <td>
                        <input type="text" name="quantity[]" value="{{ $list->quantity }}" style="border:none;text-align:center" hidden>
                        {{ $list->quantity }}
                    </td>
                    <td>
                        <a href="{{ url('/deletecart', $list->id ) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you want to delete?')">Delete</a>
                    </td>
                  </tr> 
                @endforeach
            </tbody>
        </table>
        <div align="center" style="padding: 10px">
            <button class="btn btn-primary" type="button" id="order">Order Now</button>
           {{-- <a class="btn btn-primary" id="order" href="{{ url('/confirmorder') }}" target="blank">Order Now</a>  --}}
        </div>

        <div id="appear" align="center" style="padding: 10px; display:none">
            <div style="padding: 10px">
                <label>Name</label>
                <input type="text" name="name" placeholder="Name" required>
                @error('name')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div style="padding: 10px">
                <label>Phone</label>
                <input type="text" name="phone" placeholder="Phone Number" required>
                @error('phone')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div style="padding: 10px">
                <label>Address</label>
                <input type="text" name="address" placeholder="Address" required>
                @error('address')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div style="padding: 10px">
                <input class="btn btn-success" type="submit" value="Order Confirm">
                <button class="btn btn-danger" type="button" id="close">Close</button>
            </div>
        </div>
        </form>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $('#order').click(function () { 
            $('#appear').show();   
        });

        $('#close').click(function () { 
            $('#appear').hide();   
        });
    </script>
@endsection