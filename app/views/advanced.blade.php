@extends('template')

{{-- Page title --}}
@section('title')
Advanced Pagination
@stop

{{-- Inline styles --}}
@section('styles')
<link rel="stylesheet" href="{{ URL::asset('assets/css/table.css') }}" >
@stop

{{-- Inline scripts --}}
@section('scripts')
<script>
$(function() {

	// Setup DataGrid
	var grid = $.datagrid('advanced', '.table', '.pagination', '.applied-filters', {
		dividend: 10,
		threshold: 20,
		throttle: 500,
		loader: '.loading',
		defaultSort: {
			column: 'city',
			direction: 'asc'
		},
		//scroll: '.table', // Auto Scroll feature.
		callback: function(obj){

			// Leverage the Callback to show total counts or filtered count
			$('#total').val(obj.pagi.totalCount);
			$('#filtered').val(obj.pagi.filteredCount);
			$('#dividend').val(obj.opt.dividend);
			$('#threshold').val(obj.opt.threshold);
			$('#throttle').val(obj.opt.throttle);

		}
	});

	// Text Binding
	$('.hidden-select').change(function() {

		$('.options').find('li').text($('.hidden-select option:selected').text());

	});


	/**
	 * DEMO ONLY EVENTS
	 */
	$('[data-opt]').on('change', function() {

		var opt = $(this).data('opt'),
			val = $(this).val();

		switch(opt)
		{
			case 'dividend':
				grid.setDividend(val);
			break;

			case 'throttle':
				grid.setThrottle(val);
			break;

			case 'threshold':
				grid.setThreshold(val);
			break;
		}

		grid.reset();
		grid.refresh();

	});

	$('#auto-scroll').on('change', function()
	{
		var isChecked = $(this).prop('checked');

		grid.setScroll(isChecked ? '.table' : null);
	});

});
</script>
@stop

{{-- Page content --}}
@section('content')

<h1>Advanced Pagination</h1>

<hr>

<label>
	<input type="checkbox" name="auto-scroll" id="auto-scroll" value="1">
	Enable / Disable the Auto Scroll feature
</label>

<hr>

<div class="row placeholders">

	<div class="col-xs-12 col-sm-2 placeholder">
		<p class="entice">Go on, play with the throttle.</p>
	</div>

	<div class="col-xs-12 col-sm-2 placeholder">
		<input type="text" name="total" value="" disabled class="disabled" id="total">
		<h4>Total</h4>
		<span class="text-muted">Results returned from query</span>
	</div>

	<div class="col-xs-12 col-sm-2 placeholder">
		<input type="text" name="filtered" value="" disabled class="disabled" id="filtered">
		<h4>Filtered</h4>
		<span class="text-muted">Results after filters applied.</span>
	</div>

	<div class="col-xs-12 col-sm-2 placeholder">
		<input type="text" name="throttle" value="" data-grid="single" data-opt="throttle" id="throttle">
		<h4>Throttle</h4>
		<span class="text-muted">Maximum results on a single page.</span>
	</div>

	<div class="col-xs-12 col-sm-2 placeholder">
		<input type="text" name="threshold" value="" data-grid="single" data-opt="threshold" id="threshold" class="disabled" disabled>
		<h4>Threshold</h4>
		<span class="text-muted">Minimum results before paginating.</span>
	</div>

	<div class="col-xs-12 col-sm-2 placeholder">
		<input type="text" name="dividend" value="" data-grid="single" data-opt="dividend" id="dividend" class="disabled" disabled>
		<h4>Dividend</h4>
		<span class="text-muted">Maximum "pages" to divide results by.</span>
	</div>

</div>

<hr>

<div class="row">

	<div class="col-md-12">

		<form data-search data-grid="advanced" class="search">

			<div class="select">

				<select name="column" class="hidden-select">
					<option value="all">All</option>
					<option value="subdivision">Subdivision</option>
					<option value="city">City</option>
				</select>

				<ul class="options">
					<li>All</li>
				</ul>

			</div>

			<input type="text" name="filter" placeholder="Filter All" class="search-input">

			<div class="loading">Loading &hellip;</div>

			<button class="search-btn"><i class="fa fa-search"></i></button>

		</form>

	</div>

</div>

<div class="row">

	<div class="col-md-12">

		<div class="applied-filters" data-grid="advanced"></div>

	</div>

</div>

<section class="content cf">

	<div class="grid">

		<table class="table" data-source="{{ URL::to('source') }}" data-grid="advanced">
			<thead>
				<tr>
					<th data-sort="country" data-grid="advanced" class="sortable">Country</th>
					<th data-sort="subdivision" data-grid="advanced" class="sortable">Subdivision</th>
					<th data-sort="city" data-grid="advanced" class="sortable">City</th>
					<th data-sort="population" data-grid="advanced" class="sortable">Population</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>

	</div>

	<div class="pagination" data-grid="advanced"></div>

</section>

@include('templates/advanced/results-tmpl')
@include('templates/advanced/pagination-tmpl')
@include('templates/advanced/filters-tmpl')
@include('templates/advanced/no-results-tmpl')

@stop
