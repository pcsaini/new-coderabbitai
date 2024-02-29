@extends('layouts.app')

@section('title', 'Transfer Money')

@section('content')

        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0 text-secondary">Transfer Money</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('transfer.post') }}" data-parsley-validate>
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Email address</label>
                                <input type="email"
                                       name="email"
                                       class="form-control"
                                       placeholder="Enter email"
                                       autocomplete="off"
                                       value="{{ old('email') }}"
                                       data-parsley-trigger="focusout"
                                       data-parsley-required
                                       data-parsley-type-message="Please enter valid email"
                                       data-parsley-required-message="Please enter email">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Amount</label>
                                <input type="text"
                                       name="amount"
                                       class="form-control"
                                       placeholder="Enter amount to transfer"
                                       autocomplete="off"
                                       value="{{ old('amount') }}"
                                       data-parsley-trigger="focusout"
                                       data-parsley-required
                                       data-parsley-pattern="^(\d+)(\.\d{1,2})?$"
                                       data-parsley-pattern-message="Please enter valid amount"
                                       data-parsley-required-message="Please enter amount">
                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary  w-100">Transfer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection
