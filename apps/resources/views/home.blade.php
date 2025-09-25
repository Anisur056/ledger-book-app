@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="jumbotron bg-light p-5 rounded">
                <h1 class="display-4"><i class="fas fa-book text-primary"></i> Welcome to Ledger Book App</h1>
                <p class="lead">A comprehensive ledger management system for your businesses.</p>
                <hr class="my-4">
                <p>Manage multiple businesses, create ledger books, record transactions, and generate financial reports.</p>
                
                @auth
                    @php
                        $userBusinesses = Auth::user()->businesses;
                        $totalTransactions = 0;
                        foreach ($userBusinesses as $business) {
                            foreach ($business->ledgerBooks as $ledgerBook) {
                                $totalTransactions += $ledgerBook->voucherTransections->count();
                            }
                        }
                    @endphp
                    
                    <div class="row mt-4">
                        <div class="col-md-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h3>{{ $userBusinesses->count() }}</h3>
                                    <p class="text-muted">Businesses</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h3>{{ $userBusinesses->sum(function($business) { return $business->ledgerBooks->count(); }) }}</h3>
                                    <p class="text-muted">Ledger Books</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h3>{{ $totalTransactions }}</h3>
                                    <p class="text-muted">Transactions</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h3>{{ $userBusinesses->sum(function($business) { return $business->accountsHeads->count(); }) }}</h3>
                                    <p class="text-muted">Accounts Heads</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <a class="btn btn-primary btn-lg" href="{{ route('businesses.index') }}" role="button">
                            <i class="fas fa-building"></i> Manage Businesses
                        </a>
                    </div>
                @else
                    <div class="mt-4">
                        <a class="btn btn-primary btn-lg" href="{{ route('login') }}" role="button">
                            <i class="fas fa-sign-in-alt"></i> Login to Get Started
                        </a>
                        <a class="btn btn-outline-secondary btn-lg" href="{{ route('register') }}" role="button">
                            <i class="fas fa-user-plus"></i> Register
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection