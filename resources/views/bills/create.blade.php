<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h2 fw-bold mb-0">Generate Bill</h2>
            <a href="{{ route('bills.otp-form') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Back to OTP
            </a>
        </div>
    </x-slot>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light border-bottom">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-receipt"></i> Bill Details
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('bills.store') }}" method="POST" novalidate>
                        @csrf

                        <div class="row">
                            <!-- Company Name -->
                            <div class="col-md-6 mb-3">
                                <label for="company_name" class="form-label fw-bold">Company Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('company_name') is-invalid @enderror" 
                                       id="company_name" name="company_name" value="{{ old('company_name') }}" 
                                       placeholder="Enter company name" required>
                                @error('company_name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Person Name -->
                            <div class="col-md-6 mb-3">
                                <label for="person_name" class="form-label fw-bold">Person Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('person_name') is-invalid @enderror" 
                                       id="person_name" name="person_name" value="{{ old('person_name', $verified_person) }}" 
                                       placeholder="Enter person name" required>
                                @error('person_name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- User Dropdown (Searchable) -->
                            <div class="col-md-6 mb-3">
                                <label for="user_id" class="form-label fw-bold">Select User <span class="text-danger">*</span></label>
                                <select class="form-select @error('user_id') is-invalid @enderror" 
                                        id="user_id" name="user_id" required>
                                    <option value="">-- Select a User --</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>
                                            {{ $user->firstname }} {{ $user->lastname }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted d-block mt-1">Type to search users</small>
                                @error('user_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Mobile -->
                            <div class="col-md-6 mb-3">
                                <label for="mobile" class="form-label fw-bold">Mobile Number <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control @error('mobile') is-invalid @enderror" 
                                       id="mobile" name="mobile" value="{{ old('mobile', $verified_mobile) }}" 
                                       placeholder="10-digit mobile number" pattern="[6-9][0-9]{9}" required>
                                @error('mobile')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Package -->
                            <div class="col-md-6 mb-3">
                                <label for="package" class="form-label fw-bold">Package <span class="text-danger">*</span></label>
                                <select class="form-select @error('package') is-invalid @enderror" 
                                        id="package" name="package" required>
                                    <option value="">-- Select Package --</option>
                                    @foreach($packages as $pkg)
                                        <option value="{{ $pkg }}" @selected(old('package') == $pkg)>{{ $pkg }}</option>
                                    @endforeach
                                </select>
                                @error('package')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Amount -->
                            <div class="col-md-6 mb-3">
                                <label for="amount" class="form-label fw-bold">Amount <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="number" class="form-control @error('amount') is-invalid @enderror" 
                                           id="amount" name="amount" value="{{ old('amount') }}" 
                                           placeholder="0.00" min="0" step="0.01" required>
                                </div>
                                @error('amount')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Payment Type -->
                        <div class="mb-3">
                            <label for="payment_type" class="form-label fw-bold">Payment Type <span class="text-danger">*</span></label>
                            <select class="form-select @error('payment_type') is-invalid @enderror" 
                                    id="payment_type" name="payment_type" required>
                                <option value="">-- Select Payment Type --</option>
                                <option value="cash" @selected(old('payment_type') == 'cash')>
                                    <i class="bi bi-cash-coin"></i> Cash
                                </option>
                                <option value="upi" @selected(old('payment_type') == 'upi')>
                                    <i class="bi bi-phone"></i> UPI
                                </option>
                                <option value="net_banking" @selected(old('payment_type') == 'net_banking')>
                                    <i class="bi bi-bank"></i> Net Banking
                                </option>
                                <option value="card" @selected(old('payment_type') == 'card')>
                                    <i class="bi bi-credit-card"></i> Card
                                </option>
                            </select>
                            @error('payment_type')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="bi bi-check-circle"></i> Generate Bill
                            </button>
                            <a href="{{ route('bills.otp-form') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Summary Card -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0 fw-bold">Bill Summary</h6>
                </div>
                <div class="card-body">
                    <dl class="mb-0">
                        <dt>Company:</dt>
                        <dd id="summary-company" class="text-muted">-</dd>

                        <dt class="mt-2">Person:</dt>
                        <dd id="summary-person" class="text-muted">-</dd>

                        <dt class="mt-2">Mobile:</dt>
                        <dd id="summary-mobile" class="text-muted">-</dd>

                        <dt class="mt-2">Package:</dt>
                        <dd id="summary-package" class="text-muted">-</dd>

                        <dt class="mt-2">Amount:</dt>
                        <dd id="summary-amount" class="text-muted">-</dd>

                        <dt class="mt-2">Payment:</dt>
                        <dd id="summary-payment" class="text-muted">-</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-update summary
        const companyInput = document.getElementById('company_name');
        const personInput = document.getElementById('person_name');
        const mobileInput = document.getElementById('mobile');
        const packageSelect = document.getElementById('package');
        const amountInput = document.getElementById('amount');
        const paymentSelect = document.getElementById('payment_type');

        function updateSummary() {
            document.getElementById('summary-company').textContent = companyInput.value || '-';
            document.getElementById('summary-person').textContent = personInput.value || '-';
            document.getElementById('summary-mobile').textContent = mobileInput.value || '-';
            document.getElementById('summary-package').textContent = packageSelect.value || '-';
            document.getElementById('summary-amount').textContent = amountInput.value ? '₹' + parseFloat(amountInput.value).toFixed(2) : '-';
            document.getElementById('summary-payment').textContent = paymentSelect.value || '-';
        }

        companyInput?.addEventListener('input', updateSummary);
        personInput?.addEventListener('input', updateSummary);
        mobileInput?.addEventListener('input', updateSummary);
        packageSelect?.addEventListener('change', updateSummary);
        amountInput?.addEventListener('input', updateSummary);
        paymentSelect?.addEventListener('change', updateSummary);

        // Auto-format mobile number
        mobileInput?.addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/[^0-9]/g, '').slice(0, 10);
            updateSummary();
        });

        // Make select searchable
        document.getElementById('user_id').addEventListener('focus', function() {
            this.click();
        });

        // Initial update
        updateSummary();
    </script>
</x-app-layout>
