<x-guest-layout>
    @section('title', 'Register')
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full bg-white" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full bg-white" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full bg-white" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full bg-white" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone')" />
            <x-text-input id="phone" class="block mt-1 w-full bg-white" type="text" name="phone" :value="old('phone')" required />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Class Roll -->
        <div class="mt-4">
            <x-input-label for="class_roll" :value="__('Class Roll')" />
            <x-text-input id="class_roll" class="block mt-1 w-full bg-white" type="text" name="class_roll" :value="old('class_roll')" required />
            <x-input-error :messages="$errors->get('class_roll')" class="mt-2" />
        </div>

        <!-- Father's Name -->
        <div class="mt-4">
            <x-input-label for="father_name" :value="__('Father\'s Name')" />
            <x-text-input id="father_name" class="block mt-1 w-full bg-white" type="text" name="father_name" :value="old('father_name')" required />
            <x-input-error :messages="$errors->get('father_name')" class="mt-2" />
        </div>

        <!-- Mother's Name -->
        <div class="mt-4">
            <x-input-label for="mother_name" :value="__('Mother\'s Name')" />
            <x-text-input id="mother_name" class="block mt-1 w-full bg-white" type="text" name="mother_name" :value="old('mother_name')" required />
            <x-input-error :messages="$errors->get('mother_name')" class="mt-2" />
        </div>

        <!-- Permanent Address -->
        <div class="mt-4">
            <x-input-label for="permanent_address" :value="__('Permanent Address')" />
            <x-text-input id="permanent_address" class="block mt-1 w-full bg-white" type="text" name="permanent_address" :value="old('permanent_address')" required />
            <x-input-error :messages="$errors->get('permanent_address')" class="mt-2" />
        </div>

        <!-- Current Address -->
        <div class="mt-4">
            <x-input-label for="current_address" :value="__('Current Address')" />
            <x-text-input id="current_address" class="block mt-1 w-full bg-white" type="text" name="current_address" :value="old('current_address')" required />
            <x-input-error :messages="$errors->get('current_address')" class="mt-2" />
        </div>

        <!-- Department -->
        <div class="mt-4">
            <x-input-label for="department" :value="__('Department')" />
            <select id="department" name="department" class="block mt-1 w-full bg-white" required>
                @foreach ($departments as $department)
                <option value="{{ $department }}">{{ $department }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('department')" class="mt-2" />
        </div>

        <!-- Session -->
        <div class="mt-4">
            <x-input-label for="session" :value="__('Session')" />
            <select id="session" name="session" class="block mt-1 w-full bg-white" required>
                @php
                $currentYear = date('Y');
                $startYear = 2015; // Starting from 2015-2016
                @endphp
                @for ($year = $startYear; $year <= $currentYear; $year++)
                    <option value="{{ $year }}-{{ $year + 1 }}">{{ $year }}-{{ $year + 1 }}</option>
                    @endfor
            </select>
            <x-input-error :messages="$errors->get('session')" class="mt-2" />
        </div>

        <!-- Gender -->
        <div class="mt-4">
            <x-input-label for="gender" :value="__('Gender')" />
            <select id="gender" name="gender" class="block mt-1 w-full bg-white" required>
                <option value="male">{{ __('Male') }}</option>
                <option value="female">{{ __('Female') }}</option>
                <option value="other">{{ __('Other') }}</option>
            </select>
            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
        </div>


        <div class="mt-4">
            <x-input-label for="to_account" :value="__('Select Payment Method')" />

            <label class="radio-container m-r-55">
                <input type="radio" name="to_account" value="01939378080" checked>
                <span class="checkmark"></span>
                01939378080 (Bkash)
            </label>

            <label class="radio-container m-r-55">
                <input type="radio" name="to_account" value="018483166543">
                <span class="checkmark"></span>
                018483166543 (Rocket)
            </label>

            <label class="radio-container">
                <input type="radio" name="to_account" value="01848316654">
                <span class="checkmark"></span>
                01848316654 (Nagad)
            </label>

            <x-input-error :messages="$errors->get('to_account')" class="mt-2" />
        </div>


        <!-- Transaction ID -->
        <div class="mt-4">
            <x-input-label for="transaction_id" :value="__('Transaction ID')" />
            <x-text-input id="transaction_id" class="block mt-1 w-full bg-white" type="text" name="transaction_id" :value="old('transaction_id')" required />
            <x-input-error :messages="$errors->get('transaction_id')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-black rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered huh?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

<script src="{{ URL::asset('assets/js/jquery-3.7.1.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
<script src="{{ URL::asset('assets/form-builder/form-render.min.js') }}"></script>