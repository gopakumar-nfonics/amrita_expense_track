<?php

function number_format_indian(float $num, int $decimals = 2, string $decimal_separator = ".", string $thousands_separator = ","): string
{
    // Split the integer and decimal parts
    $parts = explode('.', number_format($num, $decimals, $decimal_separator, ''));

    // Format the integer part for Indian numbering system
    $integer_part = $parts[0];

    // Check if the number is negative
    $negative = ($num < 0) ? "-" : "";

    // Remove negative sign from the integer part for formatting
    $integer_part = ltrim($integer_part, '-');

    // Reverse the integer part to process it
    $last_three = substr($integer_part, -3); // Extract the last three digits
    $remaining = substr($integer_part, 0, -3); // Extract the remaining part

    // Add thousands separator in Indian format
    if (strlen($remaining) > 0) {
        $remaining = preg_replace("/\B(?=(\d{2})+(?!\d))/", $thousands_separator, $remaining);
        $formatted_integer = $remaining . $thousands_separator . $last_three;
    } else {
        $formatted_integer = $last_three;
    }

    // Combine integer part and decimal part
    $result = $negative . $formatted_integer;
    if (isset($parts[1])) {
        $result .= $decimal_separator . $parts[1];
    }

    return $result;
}

