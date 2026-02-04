@extends('admin.layouts.master')

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
@endsection