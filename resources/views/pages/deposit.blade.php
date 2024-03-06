@extends('layouts.app')

@section('title', 'Deposit Money')

@section('content')

        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0 text-secondary">Deposit Money</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('deposit.post') }}" data-parsley-validate>
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Amount</label>
                                <input type="number"
                                       name="amount"
                                       class="form-control"
                                       placeholder="Enter amount to deposit"
                                       autocomplete="off"
                                       value="{{ old('amount') }}"
                                       data-parsley-trigger="focusout"
                                       data-parsley-required
                                       data-parsley-type-message="Please enter valid amount"
                                       data-parsley-required-message="Please enter amount">
                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary w-100">Deposit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection
