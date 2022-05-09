<x-app-layout>

</x-app-layout>
@extends('admin.adminmaster')
@section('title','User')
@section('content')
    <div style="position: relative; top:60px; right:-60px">
        <table class="table table-secondary table-striped" style="text-align: center">
            <tr style="padding: 30px">
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
            @foreach ($lists as $list)
            <tr align="center">
                <td>{{ $list->name }}</td>
                <td>{{ $list->email }}</td>
                @if ($list->usertype==0)
                <td><a href="{{ url('delete/'.$list->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you want to delete?')">Delete</a></td>
                @else
                <td><a href="" class="btn btn-sm btn-warning" onclick="return confirm('You can not remove an Admin')">Not Allowed</a></td>
                @endif
            </tr>            
            @endforeach
        </table>
    </div>
@endsection