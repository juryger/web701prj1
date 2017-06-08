<?php
require_once('WoolTypes.php');

// Check if not POST - show wool parameters form
if ($_SERVER['REQUEST_METHOD'] === 'GET') { ?>
	<div class="w701igwpc-form-style">
		<form id="w701igwpcForm" name="w701igwpcForm"
			  action="javascript:var $ = jQuery.noConflict();sendFormAjax($('#w701igwpcForm'),'<?php echo plugins_url('WoolPriceCalculator.php', __FILE__)?>', $('#calculatedPriceResult'));"
			  method="post"
			  onsubmit="return validateFormFieldsBeforeSubmit();">
			<input type="hidden" id="action" name="action" value="w701igwpc_calculate_price_action" />
			<input type="number" step="0.1" min="1" max="38" id="fiberDiameter" name="fiberDiameter" placeholder="Fiber diameter *" required />
			<input type="number" min="1" max="120" id="fiberLength" name="fiberLength" placeholder="Fiber length *" required />
			<input type="number" min="1" max="40" id="fiberStrength" name="fiberStrength" placeholder="Fiber strength *" required />
			<select id="woolColour" name="woolColour" class="field-select" required>
				<option selected disabled value="0">Choose colour...</option>
				<option value="1">M (scourable)</option>
				<option value="2">H1 (light/odd)</option>
				<option value="3"">H2 (medium)</option>
				<option value="4">H3 (heavy colour)</option>
			</select>
			<input type="submit" value="Calculate" />
		</form>
		<br/>
		<label name="validationSummary" style="color: red;"></label>
		<br/>
		<!-- Will contain result of price calculation -->
		<div id="calculatedPriceResult"></div>
	</div>
<?php
}
// Otherwise process input parameters from POST request and show price
else if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	// Wool price calculation is based on this source (see https://www.wool.com/market-intelligence/woolcheque/wool-characteristics)

	$fiberDiameter = $_POST['fiberDiameter'];
	$fiberLength = $_POST['fiberLength'];
	$fiberStrength = $_POST['fiberStrength'];
	$woolColour = $_POST['woolColour'];

	echo 'Request parameters: ' . $fiberDiameter . ', ' . $fiberLength . ', ' . $fiberStrength . ',' . $woolColour .'\n';

	$woolType = GetWoolType($fiberDiameter);
	echo 'Defined wool type: ' . $woolType . '\n';

	$price = GetWoolBasePrice($fiberDiameter);
	echo 'Base price: ' . $price . '\n';

	$price += CalculateFiberLengthDiscount($fiberLength, $woolType);
	echo 'Base price after calc FiberLength discount: ' . $price . ' $/kg';

	$price += CalculateFiberStrengthDiscount($fiberStrength, $woolType);
	echo 'Base price after calc FiberStrength discount: ' . $price . ' $/kg';

	$price += CalculateWooolColourDiscount($woolColour, $woolType);
	echo 'Base price after calc FiberStrength discount: ' . $price . ' $/kg';

	echo 'Wool price: ' . $price . ' $/kg';
}

function GetWoolType($fiberDiameter)
{
	if ($fiberDiameter > 1 && $fiberDiameter <= 22)
		return WoolTypes::FINE;
	if ($fiberDiameter > 22 && $fiberDiameter <= 30.5)
		return WoolTypes::MEDIUM;
	if ($fiberDiameter > 30.5)
		return WoolTypes::COARSE;
}

function GetWoolBasePrice($fiberDiameter)
{
	if ($fiberDiameter <= 17.4)
		return 13;
	if ($fiberDiameter > 17.4 && $fiberDiameter <= 19)
		return 12.1;
	if ($fiberDiameter > 19 && $fiberDiameter <= 22)
		return 10.4;
	if ($fiberDiameter > 22 && $fiberDiameter <= 25)
		return 9.3;
	if ($fiberDiameter > 25 && $fiberDiameter <= 29)
		return 7;
	if ($fiberDiameter > 29)
		return 3.5;
}

function CalculateFiberLengthDiscount($length, $woolType)
{
	if ($woolType == WoolTypes::FINE)
	{
		if ($length <= 60)
			return -1.2;
		if ($length > 60 && $length <= 75)
			return -0.2;
		if ($length > 75 && $length <= 85)
			return 0;
		if ($length > 85 && $length <= 90)
			return 0.1;
		if ($length > 90 && $length <= 105)
			return -0.05;
		if ($length > 105)
			return -0.3;
	}
	else
	{
		if ($length <= 60)
			return -5.5;
		if ($length > 60 && $length <= 70)
			return -0.1;
		if ($length > 70 && $length <= 95)
			return 0;
		if ($length > 95)
			return -0.2;
	}
}

function CalculateFiberStrengthDiscount($strength, $woolType)
{
	if ($woolType == WoolTypes::FINE)
	{
		if ($strength <= 15)
			return -1.2;
		if ($strength > 15 && $strength <= 24)
			return -0.06;
		if ($strength > 24 && $strength < 35)
			return -0.04;
		if ($strength == 35)
			return 0;
		if ($strength > 35)
			return 0.1;
	}
	else
	{
		if ($strength <= 14)
			return -0.9;
		if ($strength > 14 && $strength <= 24)
			return -0.42;
		if ($strength > 24 && $strength <= 30)
			return -0.15;
		if ($strength > 30)
			return 0;
	}
}

function CalculateWooolColourDiscount($colour, $woolType)
{
	// M (scourable)
	if ($colour == 1)
		return 0;

	if ($woolType == WoolTypes::FINE)
	{
		// H1 (light/odd)
		if ($colour == 2)
			return -0.3;
		// H2 (Medium)
		if ($colour == 3)
			return -0.6;
	}
	else
	{
		// H1 (light/odd)
		if ($colour == 2)
			return -0.15;
		// H2 (Medium)
		if ($colour == 3)
			return -0.38;
	}
}
?>