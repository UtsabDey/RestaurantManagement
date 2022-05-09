<x-app-layout>

</x-app-layout>
@extends('admin.adminmaster')
@section('content')
<div style="position: relative; top:60px; right:-150px">
    <form action="{{ url('/uploadchef') }}" method="post" enctype="multipart/form-data">
        @csrf 
        <div>
            <label>Name</label>
            <input style="color: black" type="text" name="name" placeholder="Enter Name" required>
        </div>
        <div>
            <label>Speciality</label>
            <input style="color: black" type="num" name="speciality" placeholder="Enter the Speciality" required>
        </div>
        <div>
            <label>Image</label>
            <input style="color: rgb(255, 255, 255)" type="file" name="image" required>
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
    </div>
    <!-- Edit Modal -->

    <div>
        <table class="table table-secondary table-striped table-hover" style="text-align: center">
          <tr style="padding: 30px">
              <th>ID</th>
              <th>Name</th>
              <th>Speciality</th>
              <th>Image</th>
              <th>Action</th>
          </tr>
          @foreach ($lists as $list)
          <tr>
              <input type="hidden" class="serdlt" value="{{ $list->id }}">
              <td>{{ $list->id }}</td>
              <td>{{ $list->name }}</td>
              <td>{{ $list->speciality }}</td>
              <td><img  src="/chefimage/{{ $list->image }}" alt="Chef Image"></td>
              <td>
                  <a type="button" data-bs-toggle="modal" data-bs-target="#editModal" data-id="{{$list->id}}" data-name="{{$list->name}}" data-speciality="{{$list->speciality}}" data-image="{{$list->image}}" class="btn btn-sm btn-primary">Edit</a>
                  <a type="button" href="{{ url('deletechef/'.$list->id) }}" class="btn btn-sm btn-danger" id="deletebtn" onclick="return confirm('Are you want to delete?')" >Delete</a>
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
        var data_name = button.data('name');
        var data_speciality = button.data('speciality');
        var data_image = button.data('image');
        var modal = $(this);
        modal.find('.modal-body #data_id').val(data_id);
        modal.find('.modal-body #data_name').val(data_name);
        modal.find('.modal-body #data_speciality').val(data_speciality);
        modal.find('.modal-body #data_image').val(data_image);
      });
    </script>
    {{-- <script>
      $(document).ready(function () {
        $('#deletebtn').click(function (e) { 
            e.preventDefault();
            var dlt_id = $(this).closest('tr').find('.serdlt').val();
            //alert(dlt_id);

        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this information!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {

                var data = {
                    "_token" : $('input[name=_token]').val(),
                    "id" : dlt_id,
                };
                $.ajax({
                    type: "DELETE",
                    url: "/deletechef/"+dlt_id,
                    data: data,
                    success: function (response) {
                        swal(response.status , {
                            icon: "success",
                        })
                        .then((result) => {
                            location.reload();
                        })
                    }
                });
            }
        });

        });
      });
    </script> --}}
@endsection