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
