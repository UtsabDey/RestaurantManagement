<x-app-layout>

</x-app-layout>
@extends('admin.adminmaster')
@section('title','Dashboard')
@section('content')

<div class="container">
    <h1 style="text-align: center">Customer Orders</h1><br>
    <form action="{{ url('/search') }}" method="get">
        <input type="text" name="search" style="color: black;">
        <input type="submit" value="Search" class="btn btn-success">
    </form>
    <div style="position: relative; top:80px; ">
        <table class="table table-secondary table-striped" style="text-align: center">
            <tr style="padding: 30px">
                <th>Name</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Foodname</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
            @foreach ($lists as $list)
            <tr align="center">
                <td>{{ $list->name }}</td>
                <td>{{ $list->phone }}</td>
                <td>{{ $list->address }}</td>
                <td>{{ $list->foodname }}</td>
                <td>{{ $list->price }}</td>
                <td>{{ $list->quantity }}</td>
                <td>{{ $list->price * $list->quantity }}</td>
                @if ($list->usertype==0)
                <td><a href="{{ url('delete/'.$list->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you want to delete?')">Delete</a></td>
                @else
                <td><a href="" class="btn btn-sm btn-warning" onclick="return confirm('You can not remove an Admin')">Not Allowed</a></td>
                @endif
            </tr>            
            @endforeach
        </table>
        @include('partials.paginate', ['data' => $lists])
    </div>
</div>
@endsection