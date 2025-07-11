"use strict";

var KTAppTravelExpense = (function () {
  var formElement;

  var calculateTotals = function () {
    var itemElements = [].slice.call(formElement.querySelectorAll('[data-kt-element="item"]'));
    var subTotal = 0;

    itemElements.forEach(function (itemElement) {
      var fareInput = itemElement.querySelector('input[name="fare[]"]');
      var fare = parseFloat(fareInput.value) || 0;
      subTotal += fare > 0 ? fare : 0;
    });

    var subTotalElement = formElement.querySelector('[data-kt-element="sub-total"]');
    subTotalElement.innerText = subTotal.toFixed(2);
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

      // Handle Add Item
      formElement.querySelector('[data-kt-element="add-item"]').addEventListener('click', function (event) {
        event.preventDefault();

        var newRow = formElement.querySelector('[data-kt-element="item-template"] tr').cloneNode(true);

        // Reset all inputs in new row
        newRow.querySelector('select[name="direction[]"]').selectedIndex = 0;
        newRow.querySelector('input[name="notes[]"]').value = '';
        newRow.querySelector('input[name="fare[]"]').value = '';
        
        const fileInput = newRow.querySelector('.file-input');
        if (fileInput) fileInput.value = '';

        const fileNameDisplay = newRow.querySelector('.file-name');
        if (fileNameDisplay) fileNameDisplay.textContent = 'Document..';

        const viewExistingLink = newRow.querySelector('a[href*="storage"]');
        if (viewExistingLink) {
          viewExistingLink.closest('div').remove(); // clean up old uploaded file display
        }

        // Append and bind
        formElement.querySelector('[data-kt-element="items"] tbody').appendChild(newRow);

        newRow.querySelector('[data-kt-element="remove-item"]').addEventListener('click', function () {
          newRow.remove();
          calculateTotals();
        });

        newRow.querySelector('input[name="fare[]"]').addEventListener('input', function () {
          calculateTotals();
        });

        bindFileInputChange(newRow);
      });

      // Bind for all initial rows
      formElement.querySelectorAll('[data-kt-element="item"]').forEach(function (row) {
        row.querySelector('[data-kt-element="remove-item"]').addEventListener('click', function () {
          row.remove();
          calculateTotals();
        });

        row.querySelector('input[name="fare[]"]').addEventListener('input', function () {
          calculateTotals();
        });

        bindFileInputChange(row);
      });
    }
  };
})();

KTUtil.onDOMContentLoaded(function () {
  KTAppTravelExpense.init();
});
