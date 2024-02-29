@extends('layouts.app')

@section('title', 'Home')

@section('content')

        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body p-0">
                        <table class="table">
                            <tbody>
                            <tr>
                                <td colspan="2"><h3 class="mb-0 text-secondary">Welcome, {{ $user->name }}</h3></td>
                            </tr>
                            <tr>
                                <td class="text-secondary text-uppercase">Your ID</td>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <td class="text-secondary text-uppercase">Your Balance</td>
                                <td>{{ Number::format($user->balance, locale: 'hi', precision: 2) }} INR</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
@endsection
