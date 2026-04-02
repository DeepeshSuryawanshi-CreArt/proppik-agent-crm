<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h2 fw-bold mb-0">Edit User</h2>
            <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Back to Users
            </a>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0 fw-bold">User Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.update', $user) }}" method="POST" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="firstname" class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('firstname') is-invalid @enderror" 
                                       id="firstname" name="firstname" value="{{ old('firstname', $user->firstname) }}" required>
                                @error('firstname')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="lastname" class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('lastname') is-invalid @enderror" 
                                       id="lastname" name="lastname" value="{{ old('lastname', $user->lastname) }}" required>
                                @error('lastname')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="mobile" class="form-label">Mobile <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('mobile') is-invalid @enderror" 
                                       id="mobile" name="mobile" value="{{ old('mobile', $user->mobile) }}" required>
                                @error('mobile')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="password" class="form-label">Password <span class="text-muted">(Leave blank to keep current)</span></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password">
                                @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" 
                                       id="password_confirmation" name="password_confirmation">
                            </div>
                        </div>

                        <hr>

                        <h6 class="fw-bold mb-3">Country & Contact</h6>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="country_id" class="form-label">Country</label>
                                <select class="form-select @error('country_id') is-invalid @enderror" 
                                        id="country_id" name="country_id">
                                    <option value="">-- Select Country --</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}" @selected(old('country_id', $user->country_id) == $country->id)>
                                            {{ $country->name }} ({{ $country->dial_code }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('country_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="country_code" class="form-label">Country Code</label>
                                <input type="text" class="form-control @error('country_code') is-invalid @enderror" 
                                       id="country_code" name="country_code" value="{{ old('country_code', $user->country_code) }}" placeholder="IN">
                                @error('country_code')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="dial_code" class="form-label">Dial Code</label>
                                <input type="text" class="form-control @error('dial_code') is-invalid @enderror" 
                                       id="dial_code" name="dial_code" value="{{ old('dial_code', $user->dial_code) }}" placeholder="+91">
                                @error('dial_code')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr>

                        <h6 class="fw-bold mb-3">Business Information</h6>

                        <div class="mb-3">
                            <label for="company_name" class="form-label">Company Name</label>
                            <input type="text" class="form-control @error('company_name') is-invalid @enderror" 
                                   id="company_name" name="company_name" value="{{ old('company_name', $user->company_name) }}">
                            @error('company_name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="package" class="form-label">Package</label>
                                <select class="form-select @error('package') is-invalid @enderror" 
                                        id="package" name="package">
                                    <option value="">-- Select Package --</option>
                                    <option value="Starter" @selected(old('package', $user->package) == 'Starter')>Starter</option>
                                    <option value="Standard" @selected(old('package', $user->package) == 'Standard')>Standard</option>
                                    <option value="Premium" @selected(old('package', $user->package) == 'Premium')>Premium</option>
                                </select>
                                @error('package')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="amount" class="form-label">Amount</label>
                                <input type="number" class="form-control @error('amount') is-invalid @enderror" 
                                       id="amount" name="amount" value="{{ old('amount', $user->amount) }}" step="0.01" min="0">
                                @error('amount')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="payment_type" class="form-label">Payment Type</label>
                                <select class="form-select @error('payment_type') is-invalid @enderror" 
                                        id="payment_type" name="payment_type">
                                    <option value="">-- Select Type --</option>
                                    <option value="credit_card" @selected(old('payment_type', $user->payment_type) == 'credit_card')>Credit Card</option>
                                    <option value="online_transfer" @selected(old('payment_type', $user->payment_type) == 'online_transfer')>Online Transfer</option>
                                    <option value="bank_transfer" @selected(old('payment_type', $user->payment_type) == 'bank_transfer')>Bank Transfer</option>
                                </select>
                                @error('payment_type')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" name="address" rows="3">{{ old('address', $user->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" @checked(old('is_active', $user->is_active))>
                                <label class="form-check-label" for="is_active">
                                    Active
                                </label>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Update User
                            </button>
                            <a href="{{ route('users.show', $user) }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
