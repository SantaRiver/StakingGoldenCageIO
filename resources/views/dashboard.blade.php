@extends('layouts.main')
@section('content')
    <div class="btn bg-light fixSaveBtn shadow px-5" onclick="saveAllCards()">{{ __('Save') }}</div>
    <div class="row d-flex justify-content-center pt-5">
        <div class="col-12 col-md-6">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="cards-tab" data-toggle="tab" href="#cards" role="tab"
                       aria-controls="cards" aria-selected="true">
                        {{ __('Cards') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pool-tab" data-toggle="tab" href="#pool" role="tab"
                       aria-controls="pool" aria-selected="false">
                        {{ __('Pool') }}
                    </a>
                </li>
                {{--<li class="nav-item">
                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                       aria-controls="contact" aria-selected="false">Contact</a>
                </li>--}}
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="cards" role="tabpanel" aria-labelledby="cards-tab">
                    <div class="row pt-4">
                        <div class="col-12 text-right">
                            <a href="/parse/collection" class="btn btn-dark mb-3">{{ __('Update') }}</a>
                        </div>
                    </div>
                    @foreach($cards as $card)
                        <form method="POST" class="cardGC" action="{{ route('update.card') }}">
                            @csrf
                            <input type="hidden" name="id" value="{{ $card->id }}">
                            <div
                                class="row d-flex justify-content-center py-3 gc-bg rounded text-white border-white">
                                <div class="col-3 p-4">
                                    <img class="w-100" src="/storage/app/public/cards/{{ $card->preview }}">
                                </div>
                                <div class="col-7 p-4">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group text-start">
                                                <label for="inputName{{ $card->id }}">{{ __('Name') }}</label>
                                                <input type="text" class="form-control rounded"
                                                       id="inputName{{ $card->id }}"
                                                       value="{{ $card->name }}" name="name" readonly>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group text-start">
                                                <label for="inputSchema{{ $card->id }}">{{ __('Schema') }}</label>
                                                <input type="text" class="form-control rounded"
                                                       id="inputSchema{{ $card->id }}"
                                                       value="{{ $card->schema }}" name="schema" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-5">
                                            <div class="form-group text-start">
                                                <label for="inputRarity{{ $card->id }}">{{ __('Rarity') }}</label>
                                                <input type="text" class="form-control rounded"
                                                       id="inputRarity{{ $card->id }}"
                                                       value="{{ $card->rarity }}" name="rarity" readonly>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group text-start">
                                                <label
                                                    for="inputStakingRate{{ $card->id }}">{{ __('Staking Rate') }}</label>
                                                <input type="number" class="form-control rounded"
                                                       id="inputStakingRate{{ $card->id }}"
                                                       value="{{ $card->staking_rate }}" name="staking_rate">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group text-start">
                                                <label
                                                    for="inputStakingRateWAX{{ $card->id }}">{{ __('WAX/h') }}</label>
                                                <input type="number" class="form-control rounded"
                                                       id="inputStakingRateWAX{{ $card->id }}"
                                                       value="{{ round($card->wax, 4) }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group text-start">
                                                <p>{{ __('Image') }}</p>
                                                <a class="btn btn-light w-100" target="_blank"
                                                   href="/storage/app/public/cards/{{ $card->img }}">
                                                    {{ __('View') }}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group text-start">
                                                <p>{{ __('Preview Image') }}</p>
                                                <a class="btn btn-light w-100" target="_blank"
                                                   href="/storage/app/public/cards/{{ $card->preview }}">
                                                    {{ __('View') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-between mt-2">
                                        <div class="col-6 text-left pt-2">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" name="active"
                                                       id="activeCheck{{ $card->id }}" {{ $card->active ? 'checked' : '' }}>
                                                <label class="form-check-label" for="activeCheck{{ $card->id }}">
                                                    {{ __('Active Card') }}
                                                </label>
                                            </div>
                                        </div>
                                        {{--<div class="col-6 text-right">
                                            <button type="submit" class="btn btn-light px-5">{{ __('Save') }}</button>
                                        </div>--}}
                                    </div>
                                </div>
                            </div>
                        </form>
                        <hr>
                    @endforeach

                </div>
                <div class="tab-pane fade" id="pool" role="tabpanel" aria-labelledby="pool-tab">
                    <div class="container">
                        <div class="row pt-5">
                            <div class="col-12 bg-light p-4 rounded" style="min-height: 50vh">
                                <p class="h3 text-center pb-3">{{ __('Wallet') }}: gcmoneystake</p>
                                <hr>
                                <p class="h4">{{ __('Available') }}: {{ $resources['balance'] }} WAX</p>
                                <p class="h4">{{ __('RAM') }}: {{ $resources['ram'] }} bytes</p>
                                <p class="h4">{{ __('CPU') }}: {{ $resources['cpu'] }} WAX</p>
                                <p class="h4 pb-5">{{ __('NET') }}: {{ $resources['net'] }} WAX</p>
                                <hr>
                                <a href="/dashboard/update/staking_rate"
                                   class="btn btn-outline-primary">{{ __('Update staking rate') }}</a>
                                <a href="/dashboard/update/users_inventory"
                                   class="btn btn-outline-primary">{{ __('Update users inventory') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

