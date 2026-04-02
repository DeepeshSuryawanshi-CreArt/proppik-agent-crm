<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of reports.
     */
    public function index(Request $request)
    {
        $query = Report::with(['user', 'creator'])->orderBy('created_at', 'desc');

        // Search by person name or company
        if ($request->search) {
            $search = $request->search;
            $query->where('person_name', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($q) use ($search) {
                      $q->where('company_name', 'like', "%{$search}%");
                  });
        }

        // Filter by user
        if ($request->user_filter) {
            $query->where('user_id', $request->user_filter);
        }

        // Filter by payment type
        if ($request->payment_type) {
            $query->where('payment_type', $request->payment_type);
        }

        // Filter by date range
        if ($request->from_date && $request->to_date) {
            $query->whereBetween('created_at', [
                date('Y-m-d 00:00:00', strtotime($request->from_date)),
                date('Y-m-d 23:59:59', strtotime($request->to_date))
            ]);
        }

        $reports = $query->paginate(20);
        $users = User::select('id', 'email', 'company_name')->where('is_active', true)->get();
        $statistics = $this->getStatistics();

        return view('reports.index', compact('reports', 'users', 'statistics'));
    }

    /**
     * Display a specific report.
     */
    public function show(Report $report)
    {
        $report->load(['user', 'creator']);
        return view('reports.show', compact('report'));
    }

    /**
     * Export reports to CSV.
     */
    public function export(Request $request)
    {
        $query = Report::with(['user', 'creator'])->orderBy('created_at', 'desc');

        // Apply same filters as index
        if ($request->search) {
            $search = $request->search;
            $query->where('person_name', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($q) use ($search) {
                      $q->where('company_name', 'like', "%{$search}%");
                  });
        }

        if ($request->user_filter) {
            $query->where('user_id', $request->user_filter);
        }

        if ($request->payment_type) {
            $query->where('payment_type', $request->payment_type);
        }

        if ($request->from_date && $request->to_date) {
            $query->whereBetween('created_at', [
                date('Y-m-d 00:00:00', strtotime($request->from_date)),
                date('Y-m-d 23:59:59', strtotime($request->to_date))
            ]);
        }

        $reports = $query->get();

        // Generate CSV
        $filename = 'reports_' . date('Y-m-d_H-i-s') . '.csv';
        $handle = fopen('php://memory', 'r+');

        // CSV Headers
        fputcsv($handle, [
            'ID', 'Person Name', 'User Email', 'Company', 'Bill Number', 
            'Amount', 'Package', 'Payment Type', 'GST No', 'Address', 
            'Created By', 'Created At', 'Updated At'
        ]);

        // Data rows
        foreach ($reports as $report) {
            fputcsv($handle, [
                $report->id,
                $report->person_name,
                $report->user->email,
                $report->user->company_name,
                $report->bill,
                $report->amount,
                $report->package,
                $report->payment_type,
                $report->gst_no,
                $report->address,
                $report->creator?->email ?? 'N/A',
                $report->created_at,
                $report->updated_at,
            ]);
        }

        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\""
        ]);
    }

    /**
     * Delete a report.
     */
    public function destroy(Report $report)
    {
        try {
            $report->delete();
            return redirect()->route('reports.index')->with('success', 'Report deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('reports.index')->with('error', 'Failed to delete report: ' . $e->getMessage());
        }
    }

    /**
     * Get report statistics.
     */
    public function getStatistics()
    {
        $totalReports = Report::count();
        $totalAmount = Report::sum('amount');
        $pendingPayments = Report::where('payment_type', 'net_banking')->count();
        $thisMonthReports = Report::whereMonth('created_at', now()->month)
                                  ->whereYear('created_at', now()->year)
                                  ->count();

        return compact('totalReports', 'totalAmount', 'pendingPayments', 'thisMonthReports');
    }
}
