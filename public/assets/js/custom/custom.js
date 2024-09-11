	$(document).ready(function() {
        function updateDivState() {
            if ($('.batch-checkbox:checked').length) {
                $('#disabled-links').removeClass('disabled-links');
            } else {
                $('#disabled-links').addClass('disabled-links');
            }
        }

        // Check all checkboxes when 'select-all' is checked
        $('#select-all').change(function() {
            $('.batch-checkbox').prop('checked', this.checked);
            updateDivState();
        });

        // Check/uncheck 'select-all' checkbox based on other checkboxes
        $('.batch-checkbox').change(function() {               
            updateDivState();
        });

        // Initial state check
        updateDivState();
    });


 // Function to format a number as INR currency without the rupee symbol
function formatCurrency(value) {
    const amount = parseFloat(value.replace(/[^\d.-]/g, '')); // Remove non-numeric characters
    if (isNaN(amount)) {
      return ''; // If invalid number, return empty string
    }
    // Format to INR (Indian Rupee) without currency symbol
    return new Intl.NumberFormat('en-IN', { 
        style: 'decimal', // Use decimal style instead of currency
        minimumFractionDigits: 2, // Ensure two decimal places
        maximumFractionDigits: 2 // Ensure two decimal places
    }).format(amount);
}
      function setCurrencyFormatting(inputElement) {
       
          const value = $(inputElement).val(); // Get the input value
          const formattedValue = formatCurrency(value); // Format as currency
          $(inputElement).val(formattedValue); // Set the formatted value to the target input
       
      }

      function setCurrencyFormattingHTML(inputElement) {
       
        const totalCostSpan = $(inputElement); // Get the span element
        const rawValue = totalCostSpan.text(); // Get the current text content
        const formattedValue = formatCurrency(rawValue); // Format the value
        totalCostSpan.text(formattedValue); // Set the formatted value back to the span
     
    }