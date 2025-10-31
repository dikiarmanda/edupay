<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Buat PIN Keamanan - EduPay</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <style>
    body {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
    }

    .pin-input {
      width: 50px;
      height: 50px;
      text-align: center;
      font-size: 1.5rem;
      font-weight: bold;
      border: 2px solid #e5e7eb;
      border-radius: 12px;
      background-color: #f9fafb;
      transition: all 0.2s ease;
    }

    .pin-input:focus {
      outline: none;
      border-color: #7c3aed;
      background-color: white;
      box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
    }

    .pin-input.filled {
      background-color: white;
      border-color: #7c3aed;
    }

    .pin-input.error {
      border-color: #ef4444;
      background-color: #fef2f2;
    }

    .pin-input.success {
      border-color: #10b981;
      background-color: #f0fdf4;
    }
  </style>
</head>

<body class="flex min-h-screen items-center justify-center px-4">
  <div class="w-full max-w-sm rounded-2xl bg-white p-8 shadow-2xl">
    <!-- Header -->
    <div class="mb-8 text-center">
      <h1 class="mb-4 text-3xl font-bold text-gray-900">Buat PIN Keamanan</h1>
      <p class="text-lg text-gray-600">PIN ini akan digunakan untuk mengotorisasi semua transaksi Anda.</p>
    </div>

    <!-- PIN Form -->
    <form id="pinForm" method="POST" action="{{ route('security.storePin') }}">
      @csrf

      <!-- PIN Input Section -->
      <div class="mb-8">
        <h2 class="mb-4 text-center text-lg font-semibold text-gray-800">Masukkan 6 Digit PIN</h2>
        <div class="mb-2 flex justify-center gap-3">
          <input type="text" class="pin-input" maxlength="1" data-index="0" required>
          <input type="text" class="pin-input" maxlength="1" data-index="1" required>
          <input type="text" class="pin-input" maxlength="1" data-index="2" required>
          <input type="text" class="pin-input" maxlength="1" data-index="3" required>
          <input type="text" class="pin-input" maxlength="1" data-index="4" required>
          <input type="text" class="pin-input" maxlength="1" data-index="5" required>
        </div>
        <input type="hidden" name="pin" id="pinValue">
      </div>

      <!-- Confirm PIN Section -->
      <div class="mb-8">
        <h2 class="mb-4 text-center text-lg font-semibold text-gray-800">Konfirmasi PIN Anda</h2>
        <div class="mb-2 flex justify-center gap-3">
          <input type="text" class="pin-input confirm-pin" maxlength="1" data-index="0" required>
          <input type="text" class="pin-input confirm-pin" maxlength="1" data-index="1" required>
          <input type="text" class="pin-input confirm-pin" maxlength="1" data-index="2" required>
          <input type="text" class="pin-input confirm-pin" maxlength="1" data-index="3" required>
          <input type="text" class="pin-input confirm-pin" maxlength="1" data-index="4" required>
          <input type="text" class="pin-input confirm-pin" maxlength="1" data-index="5" required>
        </div>
        <input type="hidden" name="pin_confirmation" id="pinConfirmValue">
      </div>

      <!-- Error Message -->
      <div id="errorMessage" class="mb-4 hidden text-center text-sm text-red-500">
        PIN tidak cocok. Silakan coba lagi.
      </div>

      <!-- Success Message -->
      <div id="successMessage" class="mb-4 hidden text-center text-sm text-green-500">
        PIN berhasil dibuat!
      </div>

      <!-- Save Button -->
      <x-button type="primary" as="submit" id="saveButton"
        class="w-full py-4 font-bold disabled:cursor-not-allowed disabled:opacity-50">
        Simpan PIN
      </x-button>
    </form>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const pinInputs = document.querySelectorAll('.pin-input:not(.confirm-pin)');
      const confirmPinInputs = document.querySelectorAll('.confirm-pin');
      const pinValueInput = document.getElementById('pinValue');
      const pinConfirmValueInput = document.getElementById('pinConfirmValue');
      const errorMessage = document.getElementById('errorMessage');
      const successMessage = document.getElementById('successMessage');
      const saveButton = document.getElementById('saveButton');
      const form = document.getElementById('pinForm');

      // Function to handle PIN input
      function handlePinInput(inputs, hiddenInput) {
        inputs.forEach((input, index) => {
          input.addEventListener('input', function(e) {
            const value = e.target.value;

            // Only allow numbers
            if (!/^\d$/.test(value)) {
              e.target.value = '';
              return;
            }

            // Move to next input
            if (value && index < inputs.length - 1) {
              inputs[index + 1].focus();
            }

            // Update hidden input
            updateHiddenInput(inputs, hiddenInput);

            // Clear error message when user starts typing
            errorMessage.classList.add('hidden');
            successMessage.classList.add('hidden');
          });

          input.addEventListener('keydown', function(e) {
            // Handle backspace
            if (e.key === 'Backspace' && !e.target.value && index > 0) {
              inputs[index - 1].focus();
            }
          });

          input.addEventListener('paste', function(e) {
            e.preventDefault();
            const pastedData = e.clipboardData.getData('text').replace(/\D/g, '').slice(0, 6);

            for (let i = 0; i < pastedData.length && i < inputs.length; i++) {
              inputs[i].value = pastedData[i];
            }

            updateHiddenInput(inputs, hiddenInput);

            // Focus on the next empty input or the last one
            const nextEmptyIndex = Math.min(pastedData.length, inputs.length - 1);
            inputs[nextEmptyIndex].focus();
          });
        });
      }

      // Function to update hidden input
      function updateHiddenInput(inputs, hiddenInput) {
        const pin = Array.from(inputs).map(input => input.value).join('');
        hiddenInput.value = pin;
      }

      // Function to validate PIN match
      function validatePinMatch() {
        let pin = pinValueInput.value;
        let confirmPin = pinConfirmValueInput.value;
        console.log(pin);
        console.log(confirmPin);

        if (pin.length === 6 && confirmPin.length === 6) {
          if (pin === confirmPin) {
            // PIN matches
            pinInputs.forEach(input => input.classList.remove('error'));
            pinInputs.forEach(input => input.classList.add('success'));
            confirmPinInputs.forEach(input => input.classList.remove('error'));
            confirmPinInputs.forEach(input => input.classList.add('success'));
            errorMessage.classList.add('hidden');
            successMessage.classList.remove('hidden');
            // saveButton.disabled = false;
            return true;
          } else {
            // PIN doesn't match
            pinInputs.forEach(input => input.classList.remove('success'));
            pinInputs.forEach(input => input.classList.add('error'));
            confirmPinInputs.forEach(input => input.classList.remove('success'));
            confirmPinInputs.forEach(input => input.classList.add('error'));
            errorMessage.classList.remove('hidden');
            successMessage.classList.add('hidden');
            // saveButton.disabled = true;
            return false;
          }
        } else {
          // Not enough digits
          pinInputs.forEach(input => input.classList.remove('error', 'success'));
          confirmPinInputs.forEach(input => input.classList.remove('error', 'success'));
          errorMessage.classList.add('hidden');
          successMessage.classList.add('hidden');
          //   saveButton.disabled = true;
          return false;
        }
      }

      // Initialize PIN inputs
      handlePinInput(pinInputs, pinValueInput);
      handlePinInput(confirmPinInputs, pinConfirmValueInput);

      // Add validation on form submit
      form.addEventListener('submit', function(e) {
        if (!validatePinMatch()) {
          e.preventDefault();
          return false;
        }
      });

      // Initial validation
      validatePinMatch();
    });
  </script>
</body>

</html>
