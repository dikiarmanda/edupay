// Flatpickr Configuration untuk EduPay
export function initializeFlatpickr() {
    let startDatePicker = null;
    let endDatePicker = null;

    try {
        // Check if elements exist
        const startDateElement = document.getElementById("start_date");
        const endDateElement = document.getElementById("end_date");

        if (!startDateElement && !endDateElement) {
            console.warn("Flatpickr: No date picker elements found");
            return { startDatePicker: null, endDatePicker: null };
        }

        // Common flatpickr options
        const commonOptions = {
            locale: "id",
            dateFormat: "Y-m-d",
            allowInput: false,
            clickOpens: true,
            static: true,
            maxDate: "today",
            showMonths: 1,
            animate: true,
            closeOnSelect: true,
            onOpen: function (selectedDates, dateStr, instance) {
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
        };

        // Initialize start date picker
        if (startDateElement) {
            startDatePicker = flatpickr("#start_date", {
                ...commonOptions,
                placeholder: "Pilih tanggal mulai",
                onChange: function (selectedDates) {
                    if (selectedDates.length > 0 && endDatePicker) {
                        endDatePicker.set("minDate", selectedDates[0]);
                    }
                },
            });
        }

        // Initialize end date picker
        if (endDateElement) {
            endDatePicker = flatpickr("#end_date", {
                ...commonOptions,
                placeholder: "Pilih tanggal akhir",
                onChange: function (selectedDates) {
                    if (selectedDates.length > 0 && startDatePicker) {
                        startDatePicker.set("maxDate", selectedDates[0]);
                    }
                },
            });
        }

        // Set initial constraints
        if (startDatePicker && endDatePicker) {
            const startDateValue = startDateElement?.value;
            const endDateValue = endDateElement?.value;

            if (startDateValue) {
                endDatePicker.set("minDate", startDateValue);
            }

            if (endDateValue) {
                startDatePicker.set("maxDate", endDateValue);
            }
        }
    } catch (error) {
        console.error("Error initializing Flatpickr:", error);
    }

    return { startDatePicker, endDatePicker };
}
