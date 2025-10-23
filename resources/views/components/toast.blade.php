<!-- Toast Container -->
<div id="toast-container" class="fixed right-4 top-4 z-100 space-y-2"></div>

<script>
  // Toast function
  function showToast(message, type = 'error') {
    const toastContainer = document.getElementById('toast-container');
    const toastId = 'toast-' + Date.now();

    const bgColor = type === 'error' ? 'bg-red-500' : 'bg-green-500';
    const iconColor = type === 'error' ? 'text-red-100' : 'text-green-100';
    const icon = type === 'error' ?
      '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>' :
      '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';

    const toast = document.createElement('div');
    toast.id = toastId;
    toast.className =
      `${bgColor} text-white px-6 py-4 rounded-lg shadow-lg flex items-center space-x-3 transform transition-all duration-300 ease-in-out translate-x-full opacity-0 ms-4`;

    toast.innerHTML = `
      <div class="flex-shrink-0">${icon}</div>
      <span class="flex-1">${message}</span>
      <button onclick="hideToast('${toastId}')" class="flex-shrink-0 text-white hover:text-gray-200 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>
    `;

    toastContainer.appendChild(toast);

    // Trigger animation
    setTimeout(() => {
      toast.classList.remove('translate-x-full', 'opacity-0');
      toast.classList.add('translate-x-0', 'opacity-100');
    }, 100);

    // Auto hide after 5 seconds
    setTimeout(() => {
      hideToast(toastId);
    }, 5000);
  }

  function hideToast(toastId) {
    const toast = document.getElementById(toastId);
    if (toast) {
      toast.classList.add('translate-x-full', 'opacity-0');
      setTimeout(() => {
        toast.remove();
      }, 300);
    }
  }
</script>
