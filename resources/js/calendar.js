import flatpickr from "flatpickr";
import { Indonesian } from "flatpickr/dist/l10n/id.js";
import "flatpickr/dist/flatpickr.min.css";

window.initCalendar = function (elementId, disabledDates, defaultDate) {
    const calendar = flatpickr(`#${elementId}`, {
        inline: true,
        dateFormat: "Y-m-d",
        minDate: new Date().fp_incr(1),
        locale: Indonesian,
        disable: disabledDates || [],
        defaultDate: defaultDate || null,
    });
    document.getElementById(elementId).calendar = calendar;
};
