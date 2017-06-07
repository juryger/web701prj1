<?php
// Check if not POST - show wool parameters form
if ($_SERVER['REQUEST_METHOD'] === 'GET') { ?>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>

	<div class="w701igwpc-form-style">
		<form id="w701igwpcForm"
			  action="javascript:sendFormAjax($('#w701igwpcForm'), 'WoolPriceCalculator.php', $('#calculatedPriceResult'));"
			  method="post"
			  onsubmit="return validateFormFieldsBeforeSubmit();">
			<input type="number" name="fiberDiameter" placeholder="Fiber diameter *" required />
			<input type="number" name="fiberLength" placeholder="Fiber length *" required />
			<input type="number" name="fiberStrength" placeholder="Fiber strength *" required />
			<select name="fiberColor" class="field-select" required>
				<option selected disabled>Choose here...</option>
				<option value="0">M (scourable)</option>
				<option value="1">H1 (light/odd)</option>
				<option value="2">H1 (medium)</option>
				<option value="3">H2 (heavy colour)</option>
			</select>
			<input type="submit" value="Calculate" />
		</form>
		<br/>
		<label name="validationSummary" style="color: red;"></label>
		<br/>
		<!-- Will contain result of price calculation -->
		<div id="calculatedPriceResult"></div>
	</div>

	<script>
		$(function () {
			assignFormValidationListeners();
		});
	</script>
<?php
}
// Otherwise process input parameters from POST request and show price
else if ($_SERVER['REQUEST_METHOD'] === 'POST') { ?>

<?php
}?>