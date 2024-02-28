@extends('layouts.app')

@section('title', 'Home')

@section('content')

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body p-0">
                        <table class="table">
                            <tbody>
                            <tr>
                                <td colspan="2"><h3 class="mb-0">Welcome, {{ $user->name }}</h3></td>
                            </tr>
                            <tr>
                                <td>Your ID</td>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <td>Your Balance</td>
                                <td>20,000.00 INR</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
@endsection
