@extends('layout')

@section('content')
<h1>Checkout</h1>


<form role="form" name="complete-form" method="POST" action="{{ url('/order/complete') }}">
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<input id="user_id" type="hidden" class="form-control" name="user_id" value="{{ Auth::user()->id }}">
<input id="product_quantity"  type="hidden" class="form-control" name="product_quantity" value="{{count($cart) }}">

@foreach ($cart as $item)
<input type="hidden" class="form-control" id="product_name" name="product_name" value="{{ $item->product->name }}">
<input type="hidden" class="form-control" id="product_id" name="product_id" value="{{ $item->product->id }}">
<input  type="hidden" class="form-control" id="product_price" name="product_price" value="{{$item->product->price }}">
@endforeach


        <div class="form-group">
            <input class="form-control" placeholder="Name" name="name" id="name" value="{{ Auth::user()->name }}"/>
        </div>

        <div class="form-group">
            <input class="form-control" placeholder="Email" name="email" id="email" value="{{ Auth::user()->email }}"/>
        </div>

        <div class="form-group">
            <input class="form-control" name ="address" id="address" placeholder="Address"/>
        </div>

        <div class="form-group">
            <input class="form-control" name="card-number" id="card-number" placeholder="Credit card #"/>
        </div>

        <div class="form-group">
            <input class="form-control" name ="card-month" id="card-month" placeholder="Month"/>
        </div>

        <div class="form-group">
            <input class="form-control" name="card-year" id="card-year" placeholder="Year"/>
        </div>

        <div class="form-group">
            <input class="form-control" name="card-cvc" id="card-cvc" placeholder="CVV"/>
        </div>



    <div class="panel panel-default">
        <div class="panel-body">
            <button class="btn btn-success pull-right">Checkout</button>
        </div>
    </div>

    </form>

    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script>
        Stripe.setPublishableKey('{{ env('STRIPE_API_PUBLIC') }}');

        /Stripe.setPublishableKey('{{ 'pk_test_RTYYfd343545dcdf' }}');
        jQuery(function($) {
            $("#card-number").focusout(function() {
                var el = $(this);
                if ( ! Stripe.validateCardNumber(el.val())) {
                    el.closest(".form-group").addClass("has-error");
                } else {
                    el.closest(".form-group").removeClass("has-error");
                }
            });
            $("#card-cvc").focusout(function() {
                var el = $(this);
                if ( ! Stripe.validateCVC(el.val())) {
                    el.closest("div").addClass("has-error");
                } else {
                    el.closest("div").removeClass("has-error");
                }
            });
            $('#complete-form').submit(function(e) {
                $('.submit-button').prop('disabled', true);
                var $form = $(this);
                $form.find('.payment-errors').hide()
                Stripe.card.createToken({
                    number: $form.find('#card-number').val(),
                    cvc: $form.find('#card-cvc').val(),
                    exp_month: $form.find('#card-month').val(),
                    exp_year: $form.find('#card-year').val()
                }, stripeResponseHandler);

                return false;
            });
        });

        var stripeResponseHandler = function(status, response) {
            var $form = $('#complete-form');
            var $errors = $('.payment-errors');
            // Reset any errors
            $errors.text("");

            if (response.error) {
                $errors.text(response.error.message).show();
                $form.find('button').prop('disabled', false);
            } else {
                var token = response.id;
                $form.append($('<input type="hidden" name="stripe_token" />').val(token));
                $form.get(0).submit();
                $form.find('button').html('Processing...');
            }
        };
    </script>
@endsection