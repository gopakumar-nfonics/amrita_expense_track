"use strict";

var KTAppTravelExpense = (function () {
  var formElement;

  var calculateTotals = function () {
    var itemElements = [].slice.call(formElement.querySelectorAll('[data-kt-element="items"] [data-kt-element="item"]'));
    var subTotal = 0;

    itemElements.forEach(function (itemElement) {
      var fareInput = itemElement.querySelector('input[name="fare[]"]');
      var fare = parseFloat(fareInput.value) || 0;
      fare = fare < 0 ? 0 : fare;

      subTotal += fare;
    });

    var subTotalElement = formElement.querySelector('[data-kt-element="sub-total"]');
    subTotalElement.innerText = subTotal.toFixed(2);
  };

  
  var updateDirectionOptions = function (row) {
    var directionSelect = row.querySelector('select[name="direction[]"]');
    var sourceCity = formElement.querySelector('select[name="source_city"]');
    var destCity = formElement.querySelector('select[name="destination_city"]');
    var travelModeSelect = row.querySelector('select[name="travel_modes[]"]');
  
    // If the additional expense input doesn't exist, create it (hidden by default)
    var additionalInput = row.querySelector('input[name="additional_expense_desc[]"]');
    if (!additionalInput) {
      additionalInput = document.createElement('input');
      additionalInput.type = 'text';
      additionalInput.name = 'additional_expense_desc[]';
      additionalInput.className = 'form-control form-control-solid ';
      additionalInput.placeholder = 'Enter Expense';
      additionalInput.style.display = 'none'; // hidden initially
      travelModeSelect.parentNode.appendChild(additionalInput);
    }
  
    directionSelect.innerHTML = `<option value="">--Select--</option>`;
  
    const sourceText = sourceCity.options[sourceCity.selectedIndex]?.text || '';
    const destText = destCity.options[destCity.selectedIndex]?.text || '';
  
    if (sourceCity.value && destCity.value) {
      const directions = [
        { value: `${sourceText} - ${destText}`, label: `${sourceText} - ${destText}` },
        { value: `${destText} - ${sourceText}`, label: `${destText} - ${sourceText}` }
      ];
  
      const selectedDirections = Array.from(formElement.querySelectorAll('select[name="direction[]"]'))
        .filter(sel => sel !== directionSelect)
        .map(sel => sel.value);
  
      directions.forEach(dir => {
        if (!selectedDirections.includes(dir.value)) {
          directionSelect.innerHTML += `<option value="${dir.value}">${dir.label}</option>`;
        }
      });
    }
  
    // Always add Additional Expense as an option
    directionSelect.innerHTML += `<option value="Additional Expense">Additional Expense</option>`;
  
    // Bind change event to toggle travel mode & additional expense input
    directionSelect.addEventListener('change', function () {
      if (directionSelect.value === 'Additional Expense') {
        travelModeSelect.style.display = 'none';
        travelModeSelect.disabled = true;
  
        additionalInput.style.display = '';
        additionalInput.required = true;
      } else {
        travelModeSelect.style.display = '';
        travelModeSelect.disabled = false;
  
        additionalInput.style.display = 'none';
        additionalInput.required = false;
      }
      
    });
  
  };

  var bindFileInputChange = function (row) {
    const fileInput = row.querySelector('.file-input');
    const fileNameDisplay = row.querySelector('.file-name');
    const uploadLabel = row.querySelector('.upload-label');
  
    if (fileInput && fileNameDisplay && uploadLabel) {
      
      fileInput.addEventListener('change', function () {
        const fileName = this.files[0]?.name || 'Document';
        fileNameDisplay.textContent = fileName;
      });
  
      uploadLabel.addEventListener('click', function () {
        fileInput.click();
      });
    }
  };
  
  return {
    init: function () {
      formElement = document.querySelector("#kt_invoice_form");

      // Update direction options when source or destination changes
      ['source_city', 'destination_city'].forEach(function (name) {
        var select = formElement.querySelector(`select[name="${name}"]`);
        select.addEventListener('change', function () {
          formElement.querySelectorAll('[data-kt-element="item"]').forEach(function (row) {
            updateDirectionOptions(row);
          });
        });
      });

      // Add item
      formElement.querySelector('[data-kt-element="add-item"]').addEventListener('click', function (event) {
        event.preventDefault();
        var newRow = formElement.querySelector('[data-kt-element="item-template"] tr').cloneNode(true);

        // Reset direction
        newRow.querySelector('select[name="direction[]"]').innerHTML = `<option value="">--Select--</option>`;
        
        // Reset travel mode
        newRow.querySelector('select[name="travel_modes[]"]').selectedIndex = 0;
        
        // Reset fare input
        newRow.querySelector('input[name="fare[]"]').value = '';

        // Reset additional expense input if it exists
        const additionalInput = newRow.querySelector('input[name="additional_expense_desc[]"]');
        if (additionalInput) {
          additionalInput.value = '';              // Clear old value
          additionalInput.style.display = 'none';  // Ensure it's hidden by default
          additionalInput.required = false;        // Reset required state
        }

        // Reset file input
        const fileInput = newRow.querySelector('.file-input');
        if (fileInput) {
          fileInput.value = ''; // Clear file
        }

        // Reset file name display
        const fileNameDisplay = newRow.querySelector('.file-name');
        if (fileNameDisplay) {
          fileNameDisplay.textContent = 'Document'; // Set to default
        }

        formElement.querySelector('[data-kt-element="items"] tbody').appendChild(newRow);

        updateDirectionOptions(newRow);

        newRow.querySelector('select[name="direction[]"]').dispatchEvent(new Event('change'));

        // Bind events
        newRow.querySelector('[data-kt-element="remove-item"]').addEventListener('click', function () {
          newRow.remove();
          calculateTotals();
        });

        newRow.querySelector('input[name="fare[]"]').addEventListener('input', function () {
          calculateTotals();
        });

        bindFileInputChange(newRow);
      });

      // Initial row handlers
      var firstRow = formElement.querySelector('[data-kt-element="item"]');
      updateDirectionOptions(firstRow);

      firstRow.querySelector('[data-kt-element="remove-item"]').addEventListener('click', function () {
        firstRow.remove();
        calculateTotals();
      });

      firstRow.querySelector('input[name="fare[]"]').addEventListener('input', function () {
        calculateTotals();
      });

      bindFileInputChange(firstRow);
      calculateTotals();
    }
  };
})();

KTUtil.onDOMContentLoaded(function () {
  KTAppTravelExpense.init();
});
