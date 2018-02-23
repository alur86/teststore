@extends('layout')

@section('content')


<div id="app">
<div class="navbar-header">

                    
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'TestStore') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    
                    <ul class="nav navbar-nav navbar-right">
                        @guest
                            <li><a href="{{ route('login') }}">Login</a></li>    
                        @else
                     <span class="store"><a href="{{ route('home') }}">Home</a></span>
                     <span class="orders"><a href="{{ route('orders') }}">Orders </a></span>
                            <a href="{{ route('logout') }}" class="exit"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                         {{ csrf_field() }}
                       </form>
        
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>



<h1>Orders</h1>

@if (count($orders) > 0)

<table class="table">
<thead>
<tr>
 <th width="*">ID</th>
<th width="10%">Name</th>
<th width="10%">Email</th>
<th width="20%">Address</th>
<th width="10%">Credit Card</th>
<th width="10%">Month</th>
<th width="10%">Year</th>
<th width="10%">CVV</th>
<th width="10%">Status</th>
</tr>
</thead>
@foreach ($orders as $order)
        <tr>
<td>{{$order->id }}</td>
<td>{{$order->user_name }}</td>
<td>{{$order->user_email }}</td>
<td>{{$order->address }}</td>
<td>{{$order->credit_card }}</td>
<td>{{$order->month }}</td>
<td>{{$order->year }}</td>
<td>{{$order->cvv}}</td>
<td>{{$order->payment_status}}</td>
</tr>

@endforeach
</tr>
@else
<p>No any orders available now</p>
@endif
</table>

@endsection



