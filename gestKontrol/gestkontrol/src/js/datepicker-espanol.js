/*
 * jQuery Mobile Framework : plugin to provide a date and time picker.
 * Copyright (c) JTSage
 * CC 3.0 Attribution.  May be relicensed without permission/notifcation.
 * https://github.com/jtsage/jquery-mobile-datebox
 *
 * Translation by: J.T.Sage <jtsage@gmail.com>
 *
 */

jQuery.extend(jQuery.mobile.datebox.prototype.options.lang, {
	'en': {
		setDateButtonLabel: "Guardar Hora",
		setTimeButtonLabel: "Guardar Fecha",
		setDurationButtonLabel: "Set Duration",
		calTodayButtonLabel: "Ir a Hoy",
		titleDateDialogLabel: "Elegir Fecha",
		titleTimeDialogLabel: "Elegir Hora",
		daysOfWeek: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
		daysOfWeekShort: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
		monthsOfYear: ["Enero", "Febrero", "Marzo", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
		monthsOfYearShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
		durationLabel: ["Days", "Hours", "Minutes", "Seconds"],
		durationDays: ["Día", "Días"],
		tooltip: "Open Date Picker",
		nextMonth: "Next Month",
		prevMonth: "Previous Month",
		timeFormat: 12,
		headerFormat: '%A %-d, %B, %Y',
		dateFieldOrder: ['d', 'm', 'y'],
		timeFieldOrder: ['h', 'i', 'a'],
		slideFieldOrder: ['d', 'm', 'y'],
		dateFormat: "%-d/%-m/%Y",
		useArabicIndic: false,
		isRTL: false,
		calStartDay: 0,
		clearButton: "Clear",
		durationOrder: ['d', 'h', 'i', 's'],
		meridiem: ["AM", "PM"],
		timeOutput: "%l:%M %p",
		durationFormat: "%Dd %DA, %Dl:%DM:%DS"
	}
});
jQuery.extend(jQuery.mobile.datebox.prototype.options, {
	useLang: 'en'
});
