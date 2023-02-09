@extends('rapidez::layouts.app')

@section('title', __('Register'))

@section('robots', 'NOINDEX,NOFOLLOW')

@section('content')
    <x-rapidez::recaptcha location="customer_create" />
    <graphql-mutation
        v-cloak
        query="mutation customer ($firstname: String!, $lastname: String!, $email: String!, $password: String) { createCustomerV2 ( input: { firstname: $firstname, lastname: $lastname, email: $email, password: $password } ) { customer { email } } }"
        redirect="/account"
        :callback="registerCallback"
        :recaptcha="{{ Rapidez::config('recaptcha_frontend/type_for/customer_create') == 'recaptcha_v3' ? 'true' : 'false' }}"
    >
        <div
            class="flex flex-col items-center bg-highlight"
            v-if="!$root.user"
            slot-scope="{ mutate, variables }"
        >
            <h1 class="my-5 text-3xl font-bold text-gray-700">@lang('Register your account')</h1>

            <form
                class="grid grid-cols-12 w-full sm:w-[600px] gap-3 p-8"
                v-on:submit.prevent="mutate"
            >
                <div class="col-span-12 sm:col-span-6">
                    <x-rapidez::input
                        name="firstname"
                        type="text"
                        v-model="variables.firstname"
                        required
                    />
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <x-rapidez::input
                        name="lastname"
                        type="text"
                        v-model="variables.lastname"
                        required
                    />
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <x-rapidez::input
                        name="email"
                        type="email"
                        v-model="variables.email"
                        required
                    />
                </div>
                <div class="col-span-12 sm:col-span-6">
                    <x-rapidez::input
                        name="password"
                        type="password"
                        v-model="variables.password"
                        required
                    />
                </div>

                <x-rapidez::button
                    class="col-span-12"
                    type="submit"
                >
                    @lang('Register')
                </x-rapidez::button>
            </form>
        </div>
        <div v-else>
            <div class="mb-5">@lang('You\'re already logged in.')</div>
            <x-rapidez::button href="/account">
                @lang('Go to your account')
            </x-rapidez::button>
        </div>
    </graphql-mutation>
@endsection
