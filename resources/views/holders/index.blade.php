@extends('layouts.main')

@section('content')
    <div class="container pt-5">
        <div class="row d-flex justify-content-center">
            <div class="col-10 text-center bg-light">
                <table class="table text-dark">
                    <thead>
                    <tr>
                        <th scope="col">{{ __('Rank') }}</th>
                        <th scope="col">{{ __('WAX Wallet') }}</th>
                        <th scope="col">{{ __('Earning') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $user->wallet }}</td>
                            <td>{{ $user->wax }} {{ __('WAX/h') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection
