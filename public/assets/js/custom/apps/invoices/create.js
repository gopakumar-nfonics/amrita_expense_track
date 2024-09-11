"use strict";

var KTAppInvoicesCreate = (function () {
  var invoiceFormElement;

  // Function to calculate totals and GST
  var calculateTotals = function () {
    var itemElements = [].slice.call(invoiceFormElement.querySelectorAll('[data-kt-element="items"] [data-kt-element="item"]'));
    var subTotal = 0;
    var numberFormat = wNumb({ decimals: 2, thousand: "," });

    itemElements.map(function (itemElement) {
      var amountElement = itemElement.querySelector('[data-kt-element="price"]');
      var gstElement = itemElement.querySelector('[data-kt-element="quantity"]');
      var totalElement = itemElement.querySelector('[data-kt-element="total"]');

      // Get the amount and handle invalid or negative values
      var amount = parseFloat(amountElement.value) || 0;
      amount = amount < 0 ? 0 : amount;

      // Get the GST rate and handle invalid or negative values
      var gstRate = parseFloat(gstElement.value) || 0;
      gstRate = gstRate < 0 ? 0 : gstRate;

      // Calculate GST amount
      var gstAmount = (amount * gstRate) / 100;
      var totalAmount = amount + gstAmount;

      // Update formatted values back to the fields
      amountElement.value = amount.toFixed(2);
      gstElement.value = gstRate.toFixed(2);

      // Calculate and display the total for this item
      totalElement.innerText = numberFormat.to(totalAmount);

      // Update subtotal
      subTotal += totalAmount;
    });

    // Update subtotal and grand total
    var subTotalElement = invoiceFormElement.querySelector('[data-kt-element="sub-total"]');
    subTotalElement.innerText = numberFormat.to(subTotal);

    // Check if subTotal exceeds total_cost
    var totalCostElement = invoiceFormElement.querySelector('#total_cost');
    if (totalCostElement) {
      var totalCost = parseFloat(totalCostElement.value.replace(/,/g, '')) || 0;
      console.log('Total cost:', totalCost); // Debugging line
      if (subTotal > totalCost) {
        displayErrorMessage("Subtotal cannot exceed the total cost.");
      } else {
        clearErrorMessage();
      }
    } else {
      console.log('Total cost element not found.'); // Debugging line
    }
  };

  // Function to display error message
  var displayErrorMessage = function (message) {
    var errorMessageElement = invoiceFormElement.querySelector('#error-message');
    if (errorMessageElement) {
      errorMessageElement.innerText = message;
      errorMessageElement.style.display = 'block';
    }
  };

  // Function to clear error message
  var clearErrorMessage = function () {
    var errorMessageElement = invoiceFormElement.querySelector('#error-message');
    if (errorMessageElement) {
      errorMessageElement.innerText = '';
      errorMessageElement.style.display = 'none';
    }
  };

  // Function to check and handle empty item template
  var checkEmptyTemplate = function () {
    if (invoiceFormElement.querySelectorAll('[data-kt-element="items"] [data-kt-element="item"]').length === 0) {
      var emptyTemplate = invoiceFormElement.querySelector('[data-kt-element="empty-template"] tr').cloneNode(true);
      invoiceFormElement.querySelector('[data-kt-element="items"] tbody').appendChild(emptyTemplate);
    } else {
      KTUtil.remove(invoiceFormElement.querySelector('[data-kt-element="items"] [data-kt-element="empty"]'));
    }
  };

  // Function to initialize date pickers for all date inputs
  var initializeDatePickers = function (element) {
    var mdateElements = (element || invoiceFormElement).querySelectorAll('.mdate');

    mdateElements.forEach(function (el) {
      if (el._flatpickr) {
        el._flatpickr.destroy(); // Destroy existing flatpickr instance if it exists
      }
      flatpickr(el, {
        defaultDate: new Date(),
        enableTime: false,
        dateFormat: "Y-m-d",
      });
    });
  };

  // Function to initialize single date picker for invoice_due_date
  var initializeInvoiceDueDatePicker = function () {
    var dueDateElement = invoiceFormElement.querySelector('#invoice_due_date');
    if (dueDateElement) {
      if (dueDateElement._flatpickr) {
        dueDateElement._flatpickr.destroy(); // Destroy existing flatpickr instance if it exists
      }
      flatpickr(dueDateElement, {
        defaultDate: new Date(),
        enableTime: false,
        dateFormat: "Y-m-d",
      });
    }
  };

  // Function to clear fields of the cloned item
  var clearFields = function (itemElement) {
    itemElement.querySelectorAll("input").forEach(function (input) {
      input.value = ""; // Clear input values
    });

    // Clear total
    itemElement.querySelector('[data-kt-element="total"]').innerText = "0.00";
  };

  // Function to handle input events and clear default values
  var handleInput = function (event) {
    var input = event.target;
    if (input.value === "0.00") {
      input.value = ""; // Clear the input value if it's "0.00"
    }
  };

  return {
    init: function () {
      invoiceFormElement = document.querySelector("#kt_invoice_form");

      // Add item event listener
      invoiceFormElement
        .querySelector('[data-kt-element="items"] [data-kt-element="add-item"]')
        .addEventListener("click", function (event) {
          event.preventDefault();
          var newItemRow = invoiceFormElement.querySelector('[data-kt-element="item-template"] tr').cloneNode(true);
          
          clearFields(newItemRow); // Clear the fields of the cloned row
          invoiceFormElement.querySelector('[data-kt-element="items"] tbody').appendChild(newItemRow);

          checkEmptyTemplate();
          initializeDatePickers(newItemRow); // Initialize date picker for the newly added row
          calculateTotals(); // Recalculate totals after adding the item
        });

      // Remove item event listener
      KTUtil.on(invoiceFormElement, '[data-kt-element="items"] [data-kt-element="remove-item"]', "click", function (event) {
        event.preventDefault();
        KTUtil.remove(this.closest('[data-kt-element="item"]'));
        checkEmptyTemplate();
        calculateTotals();
      });

      // Quantity and Price input event listener
      KTUtil.on(
        invoiceFormElement,
        '[data-kt-element="items"] [data-kt-element="quantity"], [data-kt-element="items"] [data-kt-element="price"]',
        "input",
        function (event) {
          handleInput(event); // Clear default "0.00" values
          calculateTotals(); // Recalculate totals on input change
        }
      );

      // Initialize date pickers on page load for all rows and invoice_due_date
      initializeDatePickers(); // Initialize mdate fields
      initializeInvoiceDueDatePicker(); // Initialize invoice_due_date field

      // Initial calculation
      calculateTotals();
    },
  };
})();

// Initialize on DOMContentLoaded
KTUtil.onDOMContentLoaded(function () {
  KTAppInvoicesCreate.init();
});
