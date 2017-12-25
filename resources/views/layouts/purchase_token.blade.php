{!! Form::open(['route' => ['token.purchase'], 'id' => 'token-purchase-form', 'method' => 'POST', 'data-parsley-validate' => ' ', 'novalidate' => ' ', 'class' => '']) !!}
<div class="form-group">
    <label class="control-label">BTC Amount</label>
    {!! Form::number('btc', false, ['id' => 'input-btc','class' => 'form-control', 'placeholder' => 'BTC Amount', 'step' => 'any', 'disabled' => !$enabled]) !!}
    <span class="help-block m-b-none">For which you'll buy the tokens.</span>
</div>
<div class="form-group">
    <label class="control-label">GRM You want to buy</label>
    {!! Form::number('gc', '', ['id' => 'input-gc','class' => 'form-control', 'placeholder' => '', 'step' => 'any', 'disabled' => !$enabled]) !!}
</div>
<div class="form-group">
    <label class="control-label">USD Amount</label>
    {!! Form::number('usd', '', ['id' => 'input-usd','class' => 'form-control', 'placeholder' => '', 'readonly', 'disabled', 'step' => 'any']) !!}
</div>
<button type="submit" class="btn btn-primary" disabled="{{ $enabled ? 'true' : 'false' }}">Buy</button>
{!! Form::close() !!}