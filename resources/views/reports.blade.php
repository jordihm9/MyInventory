@extends('layouts.master')

@push('scripts')
	
@endpush

@section('content')
	@if (sizeof($reports) >= 1)
		<div id="reports-list">
			<form id="new-report-btn" action="{{ route('reports.generate') }}" method="POST">
				@csrf
				<input type="submit" value="New report" class="btn primary">
			</form>
			<div class="header">
				<div class="name">Name</div>
				<div class="date">
					<div class="from">From</div>
					<div class="to">To</div>
				</div>
				<div class="actions"></div>
			</div>
			<div class="list">
				@foreach ($reports as $report)
					<div class="report">
						<div class="name">
							{{ $report->name }}
						</div>
						<div class="date">
							<div class="from">
								{{ $report->from_date }}
							</div>
							<div class="to">
								{{ $report->to_date }}
							</div>
						</div>
						<div class="actions">
							<form action="{{ route('reports.delete') }}" method="POST">
								@csrf
								<input type="hidden" name="report" value="{{ $report->id }}">
								<label for="delete{{ $report->id }}" class="del-btn"></label>
								<input type="submit" id="delete{{ $report->id }}" hidden>
							</form>
						</div>
					</div>
				@endforeach
			</div>
		</div>
	@else
		{{-- NO REPORTS --}}
		<div class="text-center no-content-msg">
			<h1>You don't have any reports</h1>
			<form action="{{ route('reports.generate') }}" method="POST">
				@csrf
				<input type="submit" value="Generate" class="btn primary">
			</form>
		</div>
	@endif
	@error('no_enough_products')
		<div class="outer show">
			<div class="container text-center centered show">
				<div class="warning-sign"></div>
				<h3>
					{!! $message !!}
				</h3>
				<div class="submit-container">
					<div class="btn primary" onclick="$('.outer').removeClass('show');">Accept</div>
				</div>
			</div>
		</div>
	@enderror
@endsection