<x-app-layout>

</x-app-layout>
@extends('admin.adminmaster')
@section('content')
<div style="position: relative; top:70px; right:-80px">
    <table class="table table-secondary table-striped table-hover" style="text-align: center">
      <tr style="padding: 30px">
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Date</th>
          <th>Time</th>
          <th>Message</th>
          <th>Action</th>
      </tr>
      @foreach ($lists as $list)
      <tr>
          <td>{{ $list->id }}</td>
          <td>{{ $list->name }}</td>
          <td>{{ $list->email }}</td>
          <td>{{ $list->phone }}</td>
          <td>{{ $list->date }}</td>
          <td>{{ $list->time }}</td>
          <td>{{ $list->message }}</td>
          <td>
              <a type="button" href="{{ url('deletefood/'.$list->id) }}" class="btn btn-sm btn-danger" id="deletebtn">Delete</a>
          </td>
      </tr>
      @endforeach
    </table>
    @include('partials.paginate', ['data' => $lists])
</div>
@endsection