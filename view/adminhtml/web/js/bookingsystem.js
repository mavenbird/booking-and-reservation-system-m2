/**
 * Mavenbird Technologies Private Limited
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://mavenbird.com/Mavenbird-Module-License.txt
 *
 * =================================================================
 *
 * @category   Mavenbird
 * @package    Mavenbird_OrderInformation
 * @author     Mavenbird Team
 * @copyright  Copyright (c) 2018-2024 Mavenbird Technologies Private Limited ( http://mavenbird.com )
 * @license    http://mavenbird.com/Mavenbird-Module-License.txt
 */
define([
    "jquery",
    "jquery/validate", // Jquery Validation Library
    "jquery/ui",
    "mage/calendar",
], function ($) {
    "use strict";

    $.validator.addMethod(
        "validate-date-today",
        function (value) {
            var currentYear = new Date().getFullYear() + "";
            var v = value;
            var formattedDate = $.datepicker.formatDate("yy-mm-dd", new Date());
            var normalizedTime = function (v) {
                v = v.split(/[.\-]/);
                for (var i = 0, len = v.length; i < len; i++) {
                    v[i] = parseInt(v[i]);
                }
                if (v[2] && v[2].length < 4) {
                    v[2] = currentYear.substr(0, v[2].length) + v[2];
                }
                return new Date(v.join("/")).getTime();
            };
            if (normalizedTime(v) < normalizedTime(formattedDate)) {
                return false;
            } else {
                return true;
            }
        },
        $.mage.__("Please enter today's date or future date.")
    );

    $.widget("bookingsystem.bookingsystem", {
        options: {},
        _create: function () {
            $("#start_date").calendar({
                showsTime: false,
                hideIfNoPrevNext: true,
                buttonText: "Select Date",
                minDate: new Date(),
                dateFormat: "yy-mm-dd",
                onSelect: function (selectedDate) {
                    $("#end_date").datepicker(
                        "option",
                        "minDate",
                        selectedDate
                    );
                },
            });
            $("#end_date").calendar({
                showsTime: false,
                hideIfNoPrevNext: true,
                buttonText: "",
                minDate: new Date(),
                dateFormat: "yy-mm-dd",
            });
            var self = this;
            $(document).ready(function () {
                var startSelectHtml = self.options.startSelectHtml;
                var endSelectHtml = self.options.endSelectHtml;
                var selectCounts = self.options.selectCounts;
                manageSlotsQtyFields($("#mb-slot-has-quantity"));
                showBookingPanel();
                manageRequiredFields();
                $(document).on("change", "#booking_type", function () {
                    showBookingPanel();
                    manageRequiredFields();
                });

                $(document).on("click", ".mb-obmd-m-inc", function () {
                    var val = $(this).parent().find("input").val();
                    if ($.isNumeric(val)) {
                        val++;
                    } else {
                        val = 0;
                    }
                    if (val >= 60) {
                        val = 0;
                    }
                    $(this).parent().find("input").val(val);
                });
                $(document).on("click", ".mb-obmd-m-dec", function () {
                    var val = $(this).parent().find("input").val();
                    if ($.isNumeric(val)) {
                        val--;
                    } else {
                        val = 0;
                    }
                    if (val < 0) {
                        val = 59;
                    }
                    $(this).parent().find("input").val(val);
                });
                $(document).on("click", ".mb-obmd-h-inc", function () {
                    var val = $(this).parent().find("input").val();
                    if ($.isNumeric(val)) {
                        val++;
                    } else {
                        val = 0;
                    }
                    if (val > 24) {
                        val = 0;
                    }
                    $(this).parent().find("input").val(val);
                });
                $(document).on("click", ".mb-obmd-h-dec", function () {
                    var val = $(this).parent().find("input").val();
                    if ($.isNumeric(val)) {
                        val--;
                    } else {
                        val = 0;
                    }
                    if (val < 0) {
                        val = 24;
                    }
                    $(this).parent().find("input").val(val);
                });
                $(document).on("change", "#mb-slot-has-quantity", function () {
                    manageSlotsQtyFields($("#mb-slot-has-quantity"));
                });
                $(document).on("click", ".mb-btn", function () {
                    selectCounts++;
                    var startHtml = $(startSelectHtml).attr(
                        "name",
                        "info[start][day][" + selectCounts + "]"
                    );
                    var endHtml = $(endSelectHtml).attr(
                        "name",
                        "info[end][day][" + selectCounts + "]"
                    );
                    manageSlotsQtyFields($("#mb-slot-has-quantity"));
                    var html = $("<div>", {
                        class: "mb-row mb-primary-row mb-text-center",
                    });
                    html.append(
                        $("<div>", { class: "mb-one-booking-col" }).append(
                            $("<div>", { class: "mb-col-wrapper" })
                                .append(
                                    $("<div>", {
                                        class: "mb-input-col",
                                    }).append(startHtml)
                                )
                                .append(
                                    $("<div>", { class: "mb-input-col" })
                                        .append(
                                            '<input data-form-part="product_form" class="mb-obmd-time admin__control-text" type="number" min="0" max="24" name="info[start][hour][' +
                                                selectCounts +
                                                ']" value="1">'
                                        )
                                        .append(
                                            $("<div>", {
                                                class: "mb-dec mb-obmd-h-dec",
                                                text: "-",
                                            })
                                        )
                                        .append(
                                            $("<div>", {
                                                class: "mb-inc mb-obmd-h-inc",
                                                text: "+",
                                            })
                                        )
                                )
                                .append(
                                    $("<div>", { class: "mb-input-col" })
                                        .append(
                                            '<input data-form-part="product_form" class="mb-obmd-time admin__control-text" type="number" min="0" max="59" name="info[start][minute][' +
                                                selectCounts +
                                                ']" value="0">'
                                        )
                                        .append(
                                            $("<div>", {
                                                class: "mb-dec mb-obmd-m-dec",
                                                text: "-",
                                            })
                                        )
                                        .append(
                                            $("<div>", {
                                                class: "mb-inc mb-obmd-m-inc",
                                                text: "+",
                                            })
                                        )
                                )
                        )
                    );
                    html.append(
                        $("<div>", {
                            class: "mb-one-booking-remove-col mb-text-center",
                        }).append('<div class="mb-remove">x</div>')
                    );
                    html.append(
                        $("<div>", { class: "mb-one-booking-col" }).append(
                            $("<div>", { class: "mb-col-wrapper" })
                                .append(
                                    $("<div>", {
                                        class: "mb-input-col",
                                    }).append(endHtml)
                                )
                                .append(
                                    $("<div>", { class: "mb-input-col" })
                                        .append(
                                            '<input data-form-part="product_form" class="mb-obmd-time admin__control-text" type="number" min="0" max="24" name="info[end][hour][' +
                                                selectCounts +
                                                ']" value="1">'
                                        )
                                        .append(
                                            $("<div>", {
                                                class: "mb-dec mb-obmd-h-dec",
                                                text: "-",
                                            })
                                        )
                                        .append(
                                            $("<div>", {
                                                class: "mb-inc mb-obmd-h-inc",
                                                text: "+",
                                            })
                                        )
                                )
                                .append(
                                    $("<div>", { class: "mb-input-col" })
                                        .append(
                                            '<input data-form-part="product_form" class="mb-obmd-time admin__control-text" type="number" min="0" max="59" name="info[end][minute][' +
                                                selectCounts +
                                                ']" value="0">'
                                        )
                                        .append(
                                            $("<div>", {
                                                class: "mb-dec mb-obmd-m-dec",
                                                text: "-",
                                            })
                                        )
                                        .append(
                                            $("<div>", {
                                                class: "mb-inc mb-obmd-m-inc",
                                                text: "+",
                                            })
                                        )
                                )
                                .append(
                                    $("<div>", {
                                        class: "mb-input-col",
                                    }).append(
                                        '<input data-form-part="product_form" class="mb-slot-qty admin__control-text" type="number" min="0" name="info[slot_qty][' +
                                            selectCounts +
                                            ']" value="0">'
                                    )
                                )
                        )
                    );

                    $(".mb-one-booking-panel").append(html);
                    manageSlotsQtyFields($("#mb-slot-has-quantity"));
                });
                $(document).on("click", ".mb-remove", function () {
                    $(this).parent().parent().remove();
                });

                $(document).on(
                    "keyup change",
                    ".mb-mbod-time,.mb-obmd-time",
                    function () {
                        if (
                            parseInt($(this).val()) >
                                parseInt($(this).attr("max")) ||
                            parseInt($(this).val()) <
                                parseInt($(this).attr("min")) ||
                            isNaN(parseInt($(this).val()))
                        ) {
                            $(this).val(0);
                        }
                        var selectDay , minVal, dayField;
                        var timeField = $(this).attr('name');
                        var date = new Date();
                        var currentDay = date.toLocaleString('en-us', {weekday:'long'}).toLowerCase();
                        if (timeField.includes('info[start][minute]')) {
                            dayField = timeField.replace("minute", "day");
                            minVal = date.getMinutes();
                        } else {
                            dayField = timeField.replace("hour", "day");
                            minVal = date.getHours();
                        }
                        selectDay = $('select[name='+'"'+dayField+'"'+']').val();

                        if (selectDay == currentDay) {
                            $("input").attr({"min" :  minVal});
                        }
                    }
                );
            });

            $(document).on("mouseenter", "#start_date,#end_date", function () {
                $(this).removeClass("validate-date-today");
                $(this).addClass("validate-date-today");
            });
            $(document).on("change", "#prevent_booking_before", function () {
                $(this).removeClass("not-negative-amount");
                $(this).addClass("not-negative-amount");
            });
            function isInt(value) {
                return (
                    !isNaN(value) &&
                    (function (x) {
                        return (x | 0) === x;
                    })(parseFloat(value))
                );
            }
            function showBookingPanel() {
                var val = $("#booking_type").val();
                if (val == 0) {
                    $(".mb-secondary-container").hide();
                } else if (val == 1) {
                    $(".mb-secondary-container").show();
                    $(".mb-one-booking-container").hide();
                } else {
                    $(".mb-secondary-container").show();
                    $(".mb-many-booking-container").hide();
                }
            }
            function manageRequiredFields() {
                var val = $("#booking_type").val();
                manageSlotsQtyFields($("#mb-slot-has-quantity"));
                $(".mb-bs").removeClass("required-entry");
                if (val == 1) {
                    $(".mb-bs").addClass("required-entry");
                } else if (val == 2) {
                    $(".mb-bs").addClass("required-entry");
                    $(".mb-is").removeClass("required-entry");
                }
            }
            $(document).on('change', '.mb-status select', function(){
                manageSlotsQtyFields($("#mb-slot-has-quantity"));
            })
            function manageSlotsQtyFields(el) {
                var bookingType = $("#booking_type").val();
                var val = el.val();
                var validateNum = 'validate-greater-than-zero required-entry';
                if (val != 0) {
                    $(".mb-slot-qty").css("display", "block");
                    $(".mb-slot-qty").find("input").show();
                    if (bookingType == 1) {
                        $('.mb-many-booing-table .mb-body .mb-row').each(function(){
                            if ($(this).find('.mb-status select').val() == 1) {
                                $(this).find("input.mb-slot-input").addClass(validateNum);
                            } else {
                                $(this).find("input.mb-slot-input").removeClass(validateNum);
                            }
                        });
                        $("input.mb-slot-qty").removeClass(validateNum);
                    } else if (bookingType == 2) {
                        $("input.mb-slot-input").removeClass(validateNum);
                        $("input.mb-slot-qty").addClass(validateNum);
                    }
                } else {
                    $(".mb-slot-qty").css("display", "none");
                    $(".mb-slot-qty").find("input").hide();
                    $("input.mb-slot-input").removeClass(validateNum);
                    $("input.mb-slot-qty").removeClass(validateNum);
                }
            }
        },
    });
    return $.bookingsystem.bookingsystem;
});
