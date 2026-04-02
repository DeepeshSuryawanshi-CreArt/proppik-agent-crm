<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h2 fw-bold mb-0">
                <i class="bi bi-receipt"></i> Bill Receipt
            </h2>
            <div class="d-flex gap-2">
                <a href="{{ route('bills.otp-form') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle"></i> Generate New Bill
                </a>
                <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-house"></i> Dashboard
                </a>
            </div>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg" id="receipt">
                <!-- Header -->
                <div class="card-header bg-dark text-white">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="mb-0 fw-bold">{{ config('app.name') }}</h5>
                            <small class="text-light">Professional Billing System</small>
                        </div>
                        <div class="col-6 text-end">
                            <h6 class="mb-1">INVOICE</h6>
                            <small class="text-light">#{{ $report->bill }}</small>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <!-- Bill Info -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="fw-bold">Bill From:</h6>
                            <p class="mb-1">{{ config('app.name') }}</p>
                            <small class="text-muted">Professional Services</small>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <h6 class="fw-bold">Bill To:</h6>
                            <p class="mb-1">{{ $user->firstname }} {{ $user->lastname }}</p>
                            <small class="text-muted">{{ $user->email }}</small>
                            <br>
                            <small class="text-muted">{{ $user->mobile }}</small>
                        </div>
                    </div>

                    <hr>

                    <!-- Date & ID Info -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <dl class="row small mb-0">
                                <dt class="col-6">Invoice Date:</dt>
                                <dd class="col-6">{{ $report->created_at->format('d M Y') }}</dd>

                                <dt class="col-6">Due Date:</dt>
                                <dd class="col-6">{{ $report->created_at->addDays(30)->format('d M Y') }}</dd>

                                <dt class="col-6">Invoice Number:</dt>
                                <dd class="col-6"><strong>{{ $report->bill }}</strong></dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl class="row small mb-0 text-end">
                                <dt class="col-6">Company:</dt>
                                <dd class="col-6">{{ $user->company_name ?? 'N/A' }}</dd>

                                <dt class="col-6">GST Number:</dt>
                                <dd class="col-6">{{ $user->gst_no ?? 'N/A' }}</dd>

                                <dt class="col-6">Address:</dt>
                                <dd class="col-6">{{ $user->address ?? 'N/A' }}</dd>
                            </dl>
                        </div>
                    </div>

                    <hr>

                    <!-- Items Table -->
                    <div class="table-responsive mb-4">
                        <table class="table table-sm mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Description</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-end">Unit Price</th>
                                    <th class="text-end">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <strong>{{ $report->package }} Package</strong>
                                        <br>
                                        <small class="text-muted">Professional service delivery</small>
                                    </td>
                                    <td class="text-center">1</td>
                                    <td class="text-end">₹ {{ number_format($report->amount, 2) }}</td>
                                    <td class="text-end"><strong>₹ {{ number_format($report->amount, 2) }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Summary -->
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tbody>
                                    <tr>
                                        <td><strong>Subtotal:</strong></td>
                                        <td class="text-end">₹ {{ number_format($report->amount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tax (18% GST):</strong></td>
                                        <td class="text-end">₹ {{ number_format($report->amount * 0.18, 2) }}</td>
                                    </tr>
                                    <tr class="table-dark text-white">
                                        <td><strong>Total Amount:</strong></td>
                                        <td class="text-end"><strong>₹ {{ number_format($report->amount * 1.18, 2) }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Payment Method:</strong></td>
                                        <td class="text-end text-capitalize">{{ $report->payment_type }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <hr>

                    <!-- Notes -->
                    <div class="alert alert-info mb-0">
                        <h6 class="fw-bold mb-2">Terms & Conditions:</h6>
                        <small>
                            <ul class="mb-0 ps-3">
                                <li>Payment is due within 30 days of invoice date</li>
                                <li>Please include the invoice number in your payment</li>
                                <li>Late payments may incur additional charges</li>
                                <li>Thank you for your business!</li>
                            </ul>
                        </small>
                    </div>
                </div>

                <!-- Footer -->
                <div class="card-footer bg-light text-center">
                    <small class="text-muted">
                        Generated on {{ $report->created_at->format('d M Y H:i:s') }} | Invoice #{{ $report->bill }}
                    </small>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-4 d-flex gap-2 justify-content-center">
                <button class="btn btn-primary" onclick="printReceipt()">
                    <i class="bi bi-printer"></i> Print Receipt
                </button>
                <a href="{{ route('bills.otp-form') }}" class="btn btn-success">
                    <i class="bi bi-plus-circle"></i> New Bill
                </a>
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                    <i class="bi bi-house"></i> Dashboard
                </a>
            </div>
        </div>
    </div>

    <script>
        function printReceipt() {
            window.print();
        }

        // Print styles
        const style = document.createElement('style');
        style.innerHTML = `
            @media print {
                body { font-size: 11pt; }
                .btn, .d-flex.gap-2 { display: none !important; }
                .card { box-shadow: none !important; border: 1px solid #000 !important; }
            }
        `;
        document.head.appendChild(style);
    </script>
</x-app-layout>
