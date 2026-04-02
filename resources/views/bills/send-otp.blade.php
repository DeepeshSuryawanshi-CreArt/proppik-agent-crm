<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h2 fw-bold mb-0">Generate Bill</h2>
        </div>
    </x-slot>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-shield-lock"></i> OTP Verification
                    </h5>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted mb-4">
                        Please verify your identity with OTP before proceeding to generate a bill.
                    </p>

                    <form action="{{ route('bills.verify-otp') }}" method="POST" novalidate>
                        @csrf

                        <!-- Person Name -->
                        <div class="mb-3">
                            <label for="person_name" class="form-label fw-bold">Person Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('person_name') is-invalid @enderror" 
                                   id="person_name" name="person_name" value="{{ old('person_name') }}" 
                                   placeholder="Enter full name" required>
                            @error('person_name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Mobile Number -->
                        <div class="mb-3">
                            <label for="mobile_no" class="form-label fw-bold">Mobile Number <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control @error('mobile_no') is-invalid @enderror" 
                                   id="mobile_no" name="mobile_no" value="{{ old('mobile_no') }}" 
                                   placeholder="10-digit mobile number" pattern="[6-9][0-9]{9}" required>
                            <small class="text-muted d-block mt-1">Format: 10-digit number starting with 6-9</small>
                            @error('mobile_no')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>

                        <!-- OTP -->
                        <div class="mb-3">
                            <label for="otp" class="form-label fw-bold">Enter OTP <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('otp') is-invalid @enderror" 
                                       id="otp" name="otp" value="{{ old('otp') }}" 
                                       placeholder="6-digit OTP" pattern="[0-9]{6}" maxlength="6" required>
                                <button class="btn btn-outline-secondary" type="button" id="resendBtn">
                                    <i class="bi bi-arrow-repeat"></i> Resend OTP
                                </button>
                            </div>
                            <small class="text-muted d-block mt-1">OTP sent to provided mobile number</small>
                            @error('otp')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-check-circle"></i> Verify OTP & Continue
                            </button>
                        </div>

                        <div class="text-center mt-3">
                            <a href="{{ route('dashboard') }}" class="btn btn-link text-decoration-none">
                                <i class="bi bi-arrow-left"></i> Back to Dashboard
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Info Box -->
                <div class="card-footer bg-light">
                    <small class="text-muted">
                        <i class="bi bi-info-circle"></i>
                        <strong>Demo Mode:</strong> Enter any 6-digit number as OTP for testing.
                    </small>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('resendBtn')?.addEventListener('click', function() {
            alert('OTP has been resent to your mobile number.');
            // In production, make an AJAX call to resend OTP
        });

        // Auto-format mobile number
        document.getElementById('mobile_no')?.addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/[^0-9]/g, '').slice(0, 10);
        });

        // Auto-format OTP
        document.getElementById('otp')?.addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/[^0-9]/g, '').slice(0, 6);
        });
    </script>
</x-app-layout>
