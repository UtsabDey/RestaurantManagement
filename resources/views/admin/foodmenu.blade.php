<x-app-layout>

</x-app-layout>
@extends('admin.adminmaster')
@section('title','Food')
@section('content')
    <div style="position: relative; top:60px; right:-150px">
        <form action="{{ url('/uploadfood') }}" method="post" enctype="multipart/form-data">
            @csrf 
            <div>
                <label>Title</label>
                <input style="color: black" type="text" name="title" placeholder="Write a Title" required>
            </div>
            <div>
                <label>Price</label>
                <input style="color: black" type="num" name="price" placeholder="Price" required>
            </div>
            <div>
                <label>Image</label>
                <input style="color: rgb(255, 255, 255)" type="file" name="image" required>
            </div>
            <div>
                <label>Description</label>
                <input style="color: black" type="text" name="description" placeholder="Write a Description" required>
            </div>
            <button class="btn btn-primary" type="submit">Save</button>
        </form><br><br>

        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Food Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form action="{{ url('/updatefood') }}" method="POST">
                @csrf
                <div class="row modal-body">
                  <div class="form-group mb-3 col-6">
                    <label class="form-label">Food Name</label>
                    <input type="hidden" name="id" id="data_id" class="form-control">
                    <input style="color: white" type="text" name="title" id="data_title" placeholder="Name" class="form-control" value="" required> @error('title')<small class="text-danger">{{ $message }}</small>@enderror
                  </div>
                  <div class="form-group mb-3 col-6">
                    <label class="form-label">Price</label>
                    <input style="color: white" type="text" name="price" id="data_price" placeholder="Price" class="form-control" value="" required> @error('price')<small class="text-danger">{{ $message }}</small>@enderror
                  </div>
                  <div class="form-group mb-3">
                    <label class="form-label">Description</label>
                    <input style="color: white" class="form-control" type="text" name="description" id="data_description" placeholder="Description" value="" required>@error('description')<small class="text-danger">{{ $message }}</small>@enderror
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
        </div>
        <!-- Edit Modal -->
        
        <div>
          <table class="table table-secondary table-striped table-hover" style="text-align: center">
            <tr style="padding: 30px">
                <th>ID</th>
                <th>Food name</th>
                <th>Price</th>
                <th>Description</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
            @foreach ($lists as $list)
            <tr>
              <input type="hidden" class="serdlt" value="{{ $list->id }}">
                <td>{{ $list->id }}</td>
                <td>{{ $list->title }}</td>
                <td>{{ $list->price }}</td>
                <td>{{ $list->description }}</td>
                <td><img  src="/foodimage/{{ $list->image }}" alt=""></td>
                <td>
                    <a type="button" data-bs-toggle="modal" data-bs-target="#editModal" data-id="{{$list->id}}" data-title="{{$list->title}}" data-price="{{$list->price}}" data-description="{{$list->description}}" data-image="{{$list->image}}" class="btn btn-sm btn-primary">Edit</a>
                    <a type="button" href="{{ url('deletefood/'.$list->id) }}" class="btn btn-sm btn-danger" id="deletebtn" onclick="return confirm('Are you want to delete?')" >Delete</a>
                </td>
            </tr>
            @endforeach
          </table>
          @include('partials.paginate', ['data' => $lists])
        </div>
    </div>
@endsection
@section('scripts')
    <script>
      $("#editModal").on('shown.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var data_id = button.data('id');
        var data_title = button.data('title');
        var data_price = button.data('price');
        var data_description = button.data('description');
        var data_image = button.data('image');
        var modal = $(this);
        modal.find('.modal-body #data_id').val(data_id);
        modal.find('.modal-body #data_title').val(data_title);
        modal.find('.modal-body #data_price').val(data_price);
        modal.find('.modal-body #data_description').val(data_description);
        modal.find('.modal-body #data_image').val(data_image);
      });
    </script>
    {{-- <script>
      $(document).ready(function () {
        $('#deletebtn').click(function (e) { 
          e.preventDefault();
          var dlt_id = $(this).closest('tr').find('.serdlt').val();

          
          swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this information!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              swal("Poof! Data has been deleted!", {
                icon: "success",
              });
            } else {
              swal("Your Data is safe!");
            }
          });

        });
      });
    </script> --}}
@endsection