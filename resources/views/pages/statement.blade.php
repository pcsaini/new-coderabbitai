@extends('layouts.app')

@section('title', 'Statement')

@section('content')

        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header p-3">
                        <h3 class="mb-0 text-secondary">Statement of amount</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>DATETIME</th>
                                <th class="text-end">AMOUNT</th>
                                <th>TYPE</th>
                                <th>DETAILS</th>
                                <th class="text-end">BALANCE</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($transactions as $transaction)
                                <tr>
                                    <td>{{ $transactions->firstItem() + $loop->index }}</td>
                                    <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('d-m-Y h:i A') }}</td>
                                    <td class="text-end">{{ Number::format($transaction->amount, locale: 'hi', precision: 2) }}</td>
                                    <td>{{ ucfirst($transaction->type) }}</td>
                                    <td>{{ $transaction->description }}</td>
                                    <td class="text-end">{{ Number::format($transaction->balance, locale: 'hi', precision: 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">There are no transactions</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        <div class="px-3">
                            {{ $transactions->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
