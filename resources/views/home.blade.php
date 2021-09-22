@extends('layouts.main')

@section('content')
    <div class="container pt-5">
        <div class="row d-flex justify-content-center">
            <div class="col-10 bg-light text-dark p-3 rounded h4">
                <h1 class="h1 pb-2 text-center">{{ __('The long-awaited update of our project!') }}</h1>
                <p>{{ __('I’d like to say again, that our project has not been planned to have staking cause we are working on a game, however, we’ve decided to do it to make the wait shorter for those who believe in us, our project, and who are excited about the launching of the game!') }}</p>
                <ul>
                    <p>{{ __('How it will work:') }}</p>
                    <li>{{ __('Every week, an amount of WAX will be added to the general pool') }}</li>
                    <li>{{ __('You enter the website, staking section, log in, you’ll see your collection of cards of our project and the amount of WAX/hour - it is your income') }}
                    </li>
                    <li>{{ __('You get a profit every hour. You can take your income once in 24 hours by clicking on “Claim”') }}
                    </li>
                </ul>
                <p>{{ __('Attention! I hope you understand that the pool isn’t eternal, so the many participants we have, the less income you get. Once again, we are not creating a staking project, we just want to thank our cardholders this way!') }}</p>
                <p>{{ __('The list of cards and what they will give is in the') }}
                    <a href="https://docs.google.com/spreadsheets/d/19NLuOhzlRJs6WjmWvSoxKm7QnuRwN5u-HoG-FxiZkhg/edit?usp=sharing">
                        {{ __('table') }}</a>
                </p>
                <p>{{ __('х is the variable that depends on the number of people and cards participating in staking') }}</p>
            </div>
        </div>
    </div>
@endsection
