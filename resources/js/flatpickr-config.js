// Flatpickr Configuration untuk EduPay
export function initializeFlatpickr() {
    // Initialize Flatpickr untuk tanggal mulai
    const startDatePicker = flatpickr("#start_date", {
        locale: "id",
        dateFormat: "Y-m-d",
        allowInput: false,
        clickOpens: true,
        placeholder: "Pilih tanggal mulai",
        static: true,
        maxDate: "today", // Tidak bisa pilih tanggal masa depan
        showMonths: 1,
        animate: true,
        closeOnSelect: true,
        onChange: function (selectedDates, dateStr, instance) {
            // Update end date minimum to start date
            if (selectedDates.length > 0) {
                endDatePicker.set("minDate", selectedDates[0]);
            }
        },
        onOpen: function (selectedDates, dateStr, instance) {
            // Add smooth animation when opening
            instance.calendarContainer.style.opacity = "0";
            instance.calendarContainer.style.transform =
                "scale(0.95) translateY(-10px)";
            setTimeout(() => {
                instance.calendarContainer.style.transition =
                    "all 0.2s ease-out";
                instance.calendarContainer.style.opacity = "1";
                instance.calendarContainer.style.transform =
                    "scale(1) translateY(0)";
            }, 10);
        },
    });

    // Initialize Flatpickr untuk tanggal akhir
    const endDatePicker = flatpickr("#end_date", {
        locale: "id",
        dateFormat: "Y-m-d",
        allowInput: false,
        clickOpens: true,
        placeholder: "Pilih tanggal akhir",
        static: true,
        maxDate: "today", // Tidak bisa pilih tanggal masa depan
        showMonths: 1,
        animate: true,
        closeOnSelect: true,
        onChange: function (selectedDates, dateStr, instance) {
            // Update start date maximum to end date
            if (selectedDates.length > 0) {
                startDatePicker.set("maxDate", selectedDates[0]);
            }
        },
        onOpen: function (selectedDates, dateStr, instance) {
            // Add smooth animation when opening
            instance.calendarContainer.style.opacity = "0";
            instance.calendarContainer.style.transform =
                "scale(0.95) translateY(-10px)";
            setTimeout(() => {
                instance.calendarContainer.style.transition =
                    "all 0.2s ease-out";
                instance.calendarContainer.style.opacity = "1";
                instance.calendarContainer.style.transform =
                    "scale(1) translateY(0)";
            }, 10);
        },
    });

    // Set initial min date untuk end date jika start date sudah ada
    const startDateValue = document.getElementById("start_date")?.value;
    if (startDateValue) {
        endDatePicker.set("minDate", startDateValue);
    }

    // Set initial max date untuk start date jika end date sudah ada
    const endDateValue = document.getElementById("end_date")?.value;
    if (endDateValue) {
        startDatePicker.set("maxDate", endDateValue);
    }

    return { startDatePicker, endDatePicker };
}
