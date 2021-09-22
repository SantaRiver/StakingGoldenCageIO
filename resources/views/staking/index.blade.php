@extends('layouts.main')

@section('content')
    <div class="container pt-5">
        <div class="row d-flex justify-content-center">
            <div class="col-10 text-center">
                <div class="mb-4 card">
                    <div class="d-flex justify-content-between align-items-center flex-wrap card-header">
                        <div class="text-nowrap">{{ __('Overview') }}</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between flex-wrap">
                                    <div class="medium-text mb-2">
                                        <div class="d-flex justify-content-center mb-2">
                                            <button id="claimBtn" type="submit" onclick="claim()"
                                                    class="mr-3 btn btn-outline-primary"
                                                {{ (isset($user_wallet->balance) && $user_wallet->balance == 0) ? 'disabled' : '' }}>
                                                {{ __('Claim!') }}
                                            </button>
                                            <div>
                                                <div>{{ __('Claimable') }}</div>
                                                <strong class="text-monospace">
                                                    <span id="balance">
                                                        {{ round($user_wallet->balance, 4) }}
                                                    </span>
                                                    {{ __('WAX') }}
                                                </strong>

                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="medium-text">
                                            <div>{{ __('Total claimable') }}</div>
                                            <strong class="text-monospace">
                                                <span id="totalClaimable">
                                                {{ $total_claim }}
                                                </span>
                                                {{ __('WAX') }}
                                            </strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="d-flex justify-content-between align-items-center flex-wrap card-header">
                        <div class="text-nowrap">{{ __('Your Gear') }}</div>
                        <div class="d-flex medium-text">{{ __('Next update in') }}:<strong
                                class="ml-1"><span id="timer">59:59</span></strong></div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div>
                                    <div class="d-flex flex-column text-center mb-2 medium-text text-muted">
                                        <div class="mr-1">{{ __('Your earnings will be') }}</div>
                                        <strong class="text-monospace">
                                            <span id="totalDrip">
                                            {{ round($user_wallet->wax, 4) }}
                                            </span>
                                            {{ __('WAX/h') }}
                                        </strong>
                                    </div>
                                    <div class="row d-flex flex-wrap justify-content-center">
                                        @foreach($inventory as $card)
                                            <div class="col-2 pb-3">
                                                <a href="https://wax.atomichub.io/explorer/template/goldencageio/{{ $card->template_id }}"
                                                   target="_blank" rel="nofollow nooopener noreferrer"
                                                   class="text-decoration-none">
                                                    <div class="d-flex flex-column align-items-center mx-2">
                                                        <div class="small-text">
                                                            <div>
                                                                <strong class="text-monospace">
                                                                    {{ round($card->wax * $card->count, 4) }} {{ __('WAX/h') }}
                                                                </strong>
                                                            </div>
                                                        </div>
                                                        <img class="w-100"
                                                             src="/storage/app/public/cards/{{ $card->preview }}">
                                                        <div
                                                            class="small-text mt-2 text-truncate mw-100">{{ $card->name }}</div>
                                                        <div class="small-text">{{ $card->schema }}</div>
                                                        <div class="font-weight-bold">
                                                            {{ $card->count }}{{ __('qt') }}
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="my-4 card">
                    <div class="d-flex justify-content-between align-items-center flex-wrap card-header">
                        <div class="text-nowrap">{{ __('Your Transactions') }}</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="list-group list-group-flush">
                                    @foreach($user_transaction as $transaction)
                                        <div class="list-group-item">
                                            <div
                                                class="d-flex w-100 justify-content-between flex-wrap align-items-center mb-1 text-monospace medium-text">
                                                <div class="d-flex justify-content-between">
                                                    <div class="mr-3"
                                                         style="width: 186px;">{{ $transaction->created_at->format('Y-m-d H:i:s') }}</div>
                                                    <span class="align-self-stretch badge badge-outline-light"
                                                          style="line-height: inherit;">{{ __($transaction->action) }}</span>
                                                </div>
                                                <div class="text-success">
                                                    <strong class="text-monospace">
                                                        {{ $transaction->value }} {{ __('WAX') }}
                                                    </strong>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        let last_claim_tomorrow = '{{ $claim_date['last_claim_tomorrow'] }}';
        let last_claim = '{{ $claim_date['last_claim'] }}';
        let last_claim_tomorrow_date = new Date(last_claim_tomorrow);
        let last_claim_date = new Date(last_claim);
        if (last_claim_date < last_claim_tomorrow_date) {
            claimTimer(last_claim_tomorrow)
        }
        timer();
    </script>
@endsection
