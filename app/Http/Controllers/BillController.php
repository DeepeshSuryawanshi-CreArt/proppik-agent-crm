<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillController extends Controller
{
    /**
     * Show the OTP verification form
     */
    public function showOtpForm()
    {
        return view('bills.send-otp');
    }

    /**
     * Verify OTP (mock implementation)
     */
    public function verifyOtp(Request $request)
    {
        $validated = $request->validate([
            'person_name' => ['required', 'string', 'max:255'],
            'mobile_no' => ['required', 'regex:/^[6-9]\d{9}$/'],
            'otp' => ['required', 'numeric', 'digits:6'],
        ]);

        // Mock OTP verification - in production, verify against sent OTP
        // For demo, any 6-digit OTP is accepted
        if (strlen($validated['otp']) == 6) {
            session([
                'otp_verified' => true,
                'verified_person' => $validated['person_name'],
                'verified_mobile' => $validated['mobile_no'],
            ]);

            return redirect()->route('bills.create')->with('success', 'OTP verified successfully!');
        }

        return back()->withErrors(['otp' => 'Invalid OTP'])->withInput();
    }

    /**
     * Show the bill generation form
     */
    public function createBill()
    {
        // Check if OTP was verified
        if (!session('otp_verified')) {
            return redirect()->route('bills.otp-form')->with('error', 'Please verify OTP first');
        }

        $users = User::where('is_active', true)
            ->select('id', 'email', 'firstname', 'lastname', 'mobile', 'company_name')
            ->get();

        $packages = ['Basic', 'Professional', 'Enterprise', 'Premium'];

        return view('bills.create', [
            'users' => $users,
            'packages' => $packages,
            'verified_person' => session('verified_person'),
            'verified_mobile' => session('verified_mobile'),
        ]);
    }

    /**
     * Store the generated bill
     */
    public function storeBill(Request $request)
    {
        // Check if OTP was verified
        if (!session('otp_verified')) {
            return redirect()->route('bills.otp-form')->with('error', 'Please verify OTP first');
        }

        $validated = $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'person_name' => ['required', 'string', 'max:255'],
            'user_id' => ['required', 'exists:users,id'],
            'mobile' => ['required', 'regex:/^[6-9]\d{9}$/'],
            'package' => ['required', 'string', 'in:Basic,Professional,Enterprise,Premium'],
            'amount' => ['required', 'numeric', 'min:0'],
            'payment_type' => ['required', 'in:cash,upi,net_banking,card'],
        ]);

        try {
            // Get the selected user
            $user = User::findOrFail($validated['user_id']);

            // Create report/bill
            $report = Report::create([
                'user_id' => $user->id,
                'bill' => 'BILL-' . uniqid(),
                'amount' => $validated['amount'],
                'package' => $validated['package'],
                'payment_type' => $validated['payment_type'],
                'gst_no' => $user->gst_no ?? 'N/A',
                'address' => $user->address ?? $validated['company_name'],
            ]);

            // Clear OTP session
            session()->forget(['otp_verified', 'verified_person', 'verified_mobile']);

            return redirect()->route('bills.receipt', $report->id)
                ->with('success', 'Bill generated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error generating bill: ' . $e->getMessage());
        }
    }

    /**
     * Show bill receipt
     */
    public function receipt(Report $report)
    {
        $user = $report->user;

        return view('bills.receipt', [
            'report' => $report,
            'user' => $user,
        ]);
    }

    /**
     * Download bill receipt as PDF
     */
    public function downloadPdf(Report $report)
    {
        // Placeholder for PDF generation
        // In production, use libraries like DomPDF or TCPDF
        return response()->download(storage_path('bills/' . $report->id . '.pdf'));
    }
}
