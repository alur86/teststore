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

<div class="raw">

<h1>Store</h1>

@if (count($products) > 0)

    <table class="table">
        <thead>
        <tr>
            <th width="*">Product</th>
            <th width="10%">Price</th>
            <th width="10%">Qty</th>
            <th width="20%">Action</th>
        </tr>
        </thead>
@foreach ($products as $product)
        <tr>
<form role="form"  name="order" method="POST" action="{{ url('/order/checkout') }}">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<input type="hidden" name="product_id" value="{{ $product->id }}"/>

            <td>{{$product->name }}</td>
            <td>${{$product->price }}</td>
<td>
<div class="form-group">
<input name="qty" value="{{count($product->qty) }}" class="form-control"/>
</div>
</td>
<td>
<button class="btn btn-success">Make Order</button>
</form>
</td>
</tr>

@endforeach
        </tr>


         {!! $products->links() !!}
</div>
@else
<p>No goods in our store now, sorry. Try to visit later</p>
@endif

    </table>

@endsection