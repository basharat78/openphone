{{-- @extends('admin.layouts.master')

@section('contents')
  <section class="section">
    <div class="section-header">
      <h1>QC Dashboard</h1>
    </div>
    <div class="row">
   <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-primary">
            <i class="fas fa-list"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Total Calls</h4>
            </div>
            <div class="card-body">
              <h2 class="font-weight-bold">{{ $stats['total_calls'] ?? 0 }}</h2>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-warning">
            <i class="fas fa-list"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Scored Calls</h4>
            </div>
            <div class="card-body">
              <h2 class="font-weight-bold">{{ $stats['scored_calls'] ?? 0 }}</h2>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-success">
            <i class="fas fa-cart-arrow-down"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Pending Reviews</h4>
            </div>
            <div class="card-body">
              <h2 class="font-weight-bold">{{ $stats['pending_reviews'] ?? 0 }}</h2>
            </div>
          </div>
        </div>
      </div>
    </div>

      <div class="row mt-4">
      <div class="col-12">
        <div class="section-header">
          <h4>Agent Overview - Today's Performance</h4>
        </div>
      </div>
    </div>


     <div class="row">
      @foreach($card as $agent)
      <div class="col-lg-4 col-md-6 col-12 mb-4">
        <div class="card agent-card" style="border-left: 5px solid 
          @if($agent['status'] == 'green') #28a745
          @elseif($agent['status'] == 'yellow') #ffc107
          @else #dc3545
          @endif;">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">{{ $agent['name'] }}</h4>
            <span class="badge badge-pill 
              @if($agent['status'] == 'green') badge-success
              @elseif($agent['status'] == 'yellow') badge-warning
              @else badge-danger
              @endif">
              @if($agent['status'] == 'green') ✓ Good
              @elseif($agent['status'] == 'yellow') ⚠ Attention
              @else ✗ Alert
              @endif
            </span>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-6 mb-3">
                <div class="metric-box">
                  <small class="text-muted">Total Calls</small>
                  <h5 class="mb-0 font-weight-bold">{{ $agent['total_calls_today'] }}</h5>
                </div>
              </div>
              <div class="col-6 mb-3">
                <div class="metric-box">
                  <small class="text-muted">Answered</small>
                  <h5 class="mb-0 font-weight-bold text-success">{{ $agent['answered'] }}</h5>
                </div>
              </div>
              <div class="col-6 mb-3">
                <div class="metric-box">
                  <small class="text-muted">Missed</small>
                  <h5 class="mb-0 font-weight-bold text-danger">{{ $agent['missed'] }}</h5>
                </div>
              </div>
              <div class="col-6 mb-3">
                <div class="metric-box">
                  <small class="text-muted">Avg Duration</small>
                  <h5 class="mb-0 font-weight-bold">{{ gmdate("i:s", $agent['avg_duration']) }}</h5>
                </div>
              </div>
              <div class="col-6 mb-3">
                <div class="metric-box">
                  <small class="text-muted">Messages Sent</small>
                  <h5 class="mb-0 font-weight-bold text-primary">{{ $agent['messages_sent'] }}</h5>
                </div>
              </div>
              <div class="col-6 mb-3">
                <div class="metric-box">
                  <small class="text-muted">QC Score</small>
                  <h5 class="mb-0 font-weight-bold 
                    @if($agent['qc_score'] >= 4.0) text-success
                    @elseif($agent['qc_score'] >= 3.0) text-warning
                    @else text-danger
                    @endif">
                    {{ number_format($agent['qc_score'], 1) }}/5.0
                  </h5>
                </div>
              </div>
            </div>
            <a href="#" class="btn btn-sm btn-primary btn-block mt-2">
              <i class="fas fa-eye"></i> View Calls
            </a>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </section>
@endsection --}}
@extends('admin.layouts.master')

@push('styles')
<style>
    @media print {
        /* Hide non-essential UI elements */
        .main-sidebar, 
        .main-navbar, 
        .navbar, 
        .main-footer, 
        .section-header, 
        .btn, 
        .card-icon {
            display: none !important;
        }

        /* Reset layout for printing */
        .main-content {
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
        }

        body, .main-wrapper {
            background-color: white !important;
            color: black !important;
        }

        .section {
            padding: 0 !important;
        }

        /* Card adjustments for print */
        .card {
            border: 1px solid #eee !important;
            box-shadow: none !important;
            break-inside: avoid;
            margin-bottom: 20px !important;
        }

        .card-statistic-1 {
            border: 1px solid #ddd !important;
        }

        .agent-card {
            border: 1px solid #ddd !important;
            page-break-inside: avoid;
        }

        /* Table adjustments */
        table {
            width: 100% !important;
            border-collapse: collapse !important;
        }
        
        th, td {
            border: 1px solid #ddd !important;
            padding: 8px !important;
        }

        /* Show the print-only header */
        .print-header {
            display: block !important;
            margin-bottom: 30px;
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        
        .print-date {
            font-size: 0.9rem;
            color: #666;
        }
    }

    /* Hide print header on screen */
    .print-header {
        display: none;
    }
</style>
@endpush

@section('contents')
  <section class="section">
    <!-- Print Only Header (Enhanced) -->
    <div class="print-header">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <div style="text-align: left;">
                <h1 style="margin: 0; color: #1a1a1a; font-size: 28px; font-weight: 800; letter-spacing: -1px;">TRUCKZAP</h1>
                <p style="margin: 0; color: #666; font-size: 14px; font-weight: 600;">Quality Control & Performance Analytics</p>
            </div>
            <div style="text-align: right;">
                <h2 style="margin: 0; color: #333; font-size: 20px;">Monthly Performance Report</h2>
                <p class="print-date" style="margin: 0;">Period: {{ now()->format('F Y') }}</p>
            </div>
        </div>
        <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; border: 1px solid #eee; margin-bottom: 30px; text-align: left;">
            <p style="margin: 0; font-size: 12px; color: #555;">This document contains sensitive performance data for internal review. Generated by <strong>{{ Auth::user()->name }}</strong> on {{ now()->format('m/d/Y h:i A') }}</p>
        </div>
    </div>

    <div class="section-header">
      <h1>QC Dashboard</h1>
      <div class="section-header-breadcrumb print:hidden">
        <button onclick="window.print()" class="btn btn-outline-primary mr-2">
            <i class="fas fa-file-pdf"></i> Export PDF / Print
        </button>
      </div>
    </div>
    
    <!-- Stats Row -->
    <div class="row">
      <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-primary">
            <i class="fas fa-phone"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Total Calls</h4>
            </div>
            <div class="card-body">
              {{ $totalCalls }}
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-success">
            <i class="fas fa-check-circle"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Scored Calls</h4>
            </div>
            <div class="card-body">
              {{ $scoredCalls }}
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-warning">
            <i class="fas fa-hourglass-half"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Pending Review</h4>
            </div>
            <div class="card-body">
              {{ $pendingCalls }}
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Agent Overview Cards -->
    <div class="row mt-4">
      <div class="col-12">
        <div class="section-header">
          <h4>Agent Overview - Today's Performance</h4>
        </div>
      </div>
    </div>

    <div class="row">
      @foreach($agentCards as $agent)
      <div class="col-lg-4 col-md-6 col-12 mb-4">
        <div class="card agent-card" style="border-left: 5px solid 
          @if($agent['status'] == 'green') #28a745
          @elseif($agent['status'] == 'yellow') #ffc107
          @else #dc3545
          @endif;">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">{{ $agent['name'] }}</h4>
            <span class="badge badge-pill 
              @if($agent['status'] == 'green') badge-success
              @elseif($agent['status'] == 'yellow') badge-warning
              @else badge-danger
              @endif">
              @if($agent['status'] == 'green') ✓ Good
              @elseif($agent['status'] == 'yellow') ⚠ Attention
              @else ✗ Alert
              @endif
            </span>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-6 mb-3">
                <div class="metric-box">
                  <small class="text-muted">Total Calls</small>
                  <h5 class="mb-0 font-weight-bold">{{ $agent['total_calls_today'] }}</h5>
                </div>
              </div>
              <div class="col-6 mb-3">
                <div class="metric-box">
                  <small class="text-muted">Answered</small>
                  <h5 class="mb-0 font-weight-bold text-success">{{ $agent['answered'] }}</h5>
                </div>
              </div>
              <div class="col-6 mb-3">
                <div class="metric-box">
                  <small class="text-muted">Missed</small>
                  <h5 class="mb-0 font-weight-bold text-danger">{{ $agent['missed'] }}</h5>
                </div>
              </div>
              <div class="col-6 mb-3">
                <div class="metric-box">
                  <small class="text-muted">Avg Duration</small>
                  <h5 class="mb-0 font-weight-bold">{{ gmdate("i:s", $agent['avg_duration']) }}</h5>
                </div>
              </div>
              <div class="col-6 mb-3">
                <div class="metric-box">
                  <small class="text-muted">Messages Sent</small>
                  <h5 class="mb-0 font-weight-bold text-primary">{{ $agent['messages_sent'] }}</h5>
                </div>
              </div>
              <div class="col-6 mb-3">
                <div class="metric-box">
                  <small class="text-muted">QC Score</small>
                  <h5 class="mb-0 font-weight-bold 
                    @if($agent['qc_score'] >= 4.0) text-success
                    @elseif($agent['qc_score'] >= 3.0) text-warning
                    @else text-danger
                    @endif">
                    {{ number_format($agent['qc_score'], 1) }}/5.0
                  </h5>
                </div>
              </div>
            </div>
            <a href="{{ route('qc.calls.index', ['dispatcher_id' => $agent['id']]) }}" class="btn btn-sm btn-primary btn-block mt-2">
              <i class="fas fa-eye"></i> View Calls
            </a>
          </div>
        </div>
      </div>
      @endforeach
    </div>

    <!-- Dispatcher Performance Table -->
    <div class="row mt-4">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Dispatcher Performance</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Dispatcher</th>
                    <th>Total Calls</th>
                    <th>Scored Calls</th>
                    <th>Avg Score (1-5)</th>
                    <th>Progress</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($dispatcherStats as $stat)
                  <tr>
                    <td>
                        <a href="{{ route('qc.calls.index', ['dispatcher_id' => $stat['id']]) }}" class="font-weight-bold text-primary">
                            {{ $stat['name'] }}
                        </a>
                    </td>
                    <td>{{ $stat['total_calls'] }}</td>
                    <td>{{ $stat['scored_calls'] }}</td>
                    <td class="font-weight-bold">{{ $stat['avg_score'] }}</td>
                    <td>
                      <div class="progress" data-height="6">
                        <div class="progress-bar bg-primary" role="progressbar" data-width="{{ ($stat['avg_score'] / 5) * 100 }}%" style="width: {{ ($stat['avg_score'] / 5) * 100 }}%"></div>
                      </div>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Print Button removed from bottom -->

  </section>
@endsection