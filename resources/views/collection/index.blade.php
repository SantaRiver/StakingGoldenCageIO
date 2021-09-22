@extends('layouts.main')
@section('content')
    <div class="container pt-5">
        <div class="row d-flex flex-wrap justify-content-center">
            <div class="col-10 bg-light rounded">
                <h1 class="text-center pt-3">{{ __('Collection') }}</h1>
                <div class="row pt-3">
                    @foreach($cards as $card)
                        <div class="col-2 pb-4">
                            <a href="https://wax.atomichub.io/explorer/template/goldencageio/{{ $card->template_id }}"
                               target="_blank" rel="nofollow nooopener noreferrer"
                               class="text-decoration-none bg-light">
                                <div class="d-flex flex-column align-items-center mx-2">
                                    <div class="small-text">
                                        <div class="text-center">
                                            <strong class="text-monospace">
                                                {{ round($card->wax, 4) }} {{ __('WAX/h') }}
                                            </strong>
                                        </div>
                                    </div>
                                    <img class="w-100"
                                         src="/storage/app/public/cards/{{ $card->preview }}">
                                    <div
                                        class="small-text mt-2 text-truncate mw-100">{{ $card->name }}</div>
                                    <div class="small-text">{{ $card->schema }}</div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

