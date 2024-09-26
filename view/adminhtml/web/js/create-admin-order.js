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
    "mage/translate",
    'mage/template',
], function ($, $t, mageTemplate) {

    var self = { options: null };
    var slots = null;
    var proId = 0;

    return function (config) {
        $(document).on('click', 'tr._clickable', function (e) {
            e.preventDefault();
            if ($(this).parent().parent().parent().find(".mb-book-now.action-configure").length != 0) {
                proId = $(this).find(".checkbox.admin__control-checkbox").val();
                $.ajax({
                    url: config.getCalenderUrl,
                    type: "POST",
                    dataType: "json",
                    data: { product_id: proId * 1 },
                    success: function (data) {
                        if ($(".mb-box-modal").length != 0) {
                            $(".mb-box-modal").remove();
                        }
                        var progressTmpl = mageTemplate('#calendar-template'), calenderHtml;
                        calenderHtml = progressTmpl({})

                        $(".modal-inner-wrap:first").append(calenderHtml);
                        $(".mb-booking-table.mb-calendar-table").html(data.getCalender);
                        $(".modal-content").hide();
                        $('[data-role="action"]').hide();
                        self.options = JSON.parse(data.data);
                        slots = self.options.slots;
                        var bookingInfoArray = self.options.bookingInfoArray;
                        if (bookingInfoArray !== undefined) {
                            $(
                                ".products .product-items.list > li.product-item, .wishlist ol.product-items > li.product-item, .table-comparison .cell.product"
                            ).each(function () {
                                if ($(this).find(".product-item-link").length) {
                                    var productLink = $(this)
                                        .find(".product-item-link")
                                        .attr("href");
                                } else if ($(this).find("a.product-item-photo").length) {
                                    var productLink = $(this)
                                        .find("a.product-item-photo")
                                        .attr("href");
                                } else {
                                    var productLink = "";
                                }
                                if (
                                    bookingInfoArray[productLink] !== undefined &&
                                    bookingInfoArray[productLink]["booking"] == 1
                                ) {
                                    setBookingLabel($(this));
                                }
                            });
                        }

                        $(".stock.unavailable")
                            .text("Booking Unavailable")
                            .css("color", "red")
                            .css("padding-top", "0px");
                        $(".mb-booking-table-body")
                            .html("No slots are available at the moment.")
                            .css("padding", "5%");
                        var slots = self.options.slots;
                        var parentId = self.options.parentId;
                        setTimeout(function () {
                            if (bookingInfoArray !== undefined) {
                                $(
                                    ".block-wishlist .product-items > li.product-item"
                                ).each(function () {
                                    if ($(this).find("a.product-item-link").length) {
                                        var productLink = $(this)
                                            .find("a.product-item-link")
                                            .attr("href");
                                    } else if (
                                        $(this).find("a.product-item-photo").length
                                    ) {
                                        var productLink = $(this)
                                            .find("a.product-item-photo")
                                            .attr("href");
                                    } else {
                                        var productLink = "";
                                    }
                                    if (
                                        bookingInfoArray[productLink] !== undefined &&
                                        bookingInfoArray[productLink]["booking"] == 1
                                    ) {
                                        setBookingLabel($(this));
                                    }
                                });
                            }
                        }, 1000);

                        var d = new Date();
                        var curr_date = d.getDate();
                        var curr_month = d.getMonth() + 1;
                        if (curr_month < 10) {
                            curr_month = "0" + curr_month;
                        }
                        if (curr_date < 10) {
                            curr_date = "0" + curr_date;
                        }
                        var curr_year = d.getFullYear();
                        var todayDate =
                            curr_year + "-" + curr_month + "-" + curr_date;
                        var todayElemnt = $(".mb-calendar-container")
                            .find(".mb-calendar-col")
                            .find(".mb-calendar-cell[data-date=" + todayDate + "]");
                        if (todayElemnt.length) {
                            if ($(todayElemnt).hasClass("slot-available")) {
                                var date = todayElemnt.attr("data-date");
                                $(
                                    ".mb-calendar-container .mb-calendar-col .mb-available-day.active"
                                ).removeClass("active");
                                todayElemnt.addClass("active");
                                loadSlotsData(date);
                            } else {
                                if (
                                    $(
                                        ".mb-calendar-container .mb-calendar-col .slot-available"
                                    ).first().length
                                ) {
                                    var date = $(
                                        ".mb-calendar-container .mb-calendar-col .slot-available"
                                    )
                                        .first()
                                        .attr("data-date");
                                    $(
                                        ".mb-calendar-container .mb-calendar-col .mb-available-day.active"
                                    ).removeClass("active");
                                    $(
                                        ".mb-calendar-container .mb-calendar-col .slot-available"
                                    )
                                        .first()
                                        .addClass("active");
                                    loadSlotsData(date);
                                }
                            }
                        } else {
                            if (
                                $(
                                    ".mb-calendar-container .mb-calendar-col .slot-available"
                                ).first().length
                            ) {
                                var date = $(
                                    ".mb-calendar-container .mb-calendar-col .slot-available"
                                )
                                    .first()
                                    .attr("data-date");
                                $(
                                    ".mb-calendar-container .mb-calendar-col .mb-available-day.active"
                                ).removeClass("active");
                                $(
                                    ".mb-calendar-container .mb-calendar-col .slot-available"
                                )
                                    .first()
                                    .addClass("active");
                                loadSlotsData(date);
                            }
                        }
                    }
                });
            }
        });

        function loadSlotsData(date) {
            showLoader();
            $.ajax({
                url: self.options.slotsUrl,
                type: "POST",
                dataType: "json",
                data: { product_id: self.options.productId, date: date },
                success: function (data) {
                    hideLoader();
                    if (data.avl == 1) {
                        currentDateData = data.slots;
                        var slotHtml = "";
                        $.each(data.slots, function (key, item) {
                            var day = item.day;
                            var month = item.month;
                            var year = item.year;
                            var id = item.id;
                            var qtyInfo = item.qty;
                            var dateFormatted =
                                item.date_formatted.split(",");
                            var dateFrom = item.booking_from.split(",");
                            var dateTo = item.booking_to.split(",");
                            var reservedQty = 0;
                            if (self.options.booking_type == 2) {
                                var rowClass = "mb-row";
                            } else {
                                var rowClass = "mb-row mb-many-row";
                            }
                            slotHtml += '<div class="' + rowClass + '">';
                            if (self.options.booking_type == 2) {
                                slotHtml +=
                                    '<div class="mb-col first">' +
                                    '<span class="mb-label-days">' +
                                    item.no_of_days +
                                    "</span>" +
                                    '<span class="mb-label-days-text">' +
                                    "<div>" +
                                    $t("Day") +
                                    "</div>" +
                                    "<div>" +
                                    $t("Slot") +
                                    "</div>" +
                                    "</span>" +
                                    "</div>";
                            }
                            if (!$(".booked-slot-summary").is(":empty")) {
                                if (
                                    $(".booked-slot-summary").find(
                                        '.booked-short-history[data-booked-slot-id="' +
                                        id +
                                        '"]'
                                    ).length
                                ) {
                                    reservedQty = $(".booked-slot-summary")
                                        .find(
                                            '.booked-short-history[data-booked-slot-id="' +
                                            id +
                                            '"]'
                                        )
                                        .children("input")
                                        .val();
                                    qtyInfo =
                                        parseInt(qtyInfo) -
                                        parseInt(reservedQty);
                                }
                            }
                            var textQtyBox = $t("Your Need");
                            if (reservedQty > 0) {
                                textQtyBox = $t("Selected");
                            }
                            slotHtml +=
                                '<div class="mb-col middle">' +
                                '<span class="mb-label-dates">' +
                                '<span class="mb-span-from">';
                            if (self.options.booking_type == 2) {
                                slotHtml +=
                                    "<div>" + dateFrom[0] + "</div>";
                            }
                            slotHtml +=
                                "<div>" +
                                dateFrom[1] +
                                "</div>" +
                                "</span>" +
                                "<span>to</span>" +
                                '<span class="mb-span-to">';
                            if (self.options.booking_type == 2) {
                                slotHtml += "<div>" + dateTo[0] + "</div>";
                            }
                            slotHtml +=
                                "<div>" +
                                dateTo[1] +
                                "</div>" +
                                "</span>" +
                                "</span>" +
                                '<span class="mb-label-avl-qty">' +
                                '<span class="mb-avl-text">' +
                                $t("Available :") +
                                "</span>" +
                                "<span>" +
                                qtyInfo +
                                "</span>" +
                                "</span>" +
                                "</div>";
                            slotHtml +=
                                '<div class="mb-col last">' +
                                '<span class="mb-booked-txt">' +
                                textQtyBox +
                                "</span>" +
                                '<input type="number" class="mb-qty" value="' +
                                reservedQty +
                                '" data-current-id=' +
                                key +
                                " data-id=" +
                                id +
                                ">" +
                                '<input type="hidden" name="mb-qty-booked-hide" value="' +
                                reservedQty +
                                '" class="mb-qty-booked-hide">' +
                                "</div>";
                            slotHtml += "</div>";

                            if (dateFormatted[0] < 10) {
                                dateFormatted[0] = "0" + dateFormatted[0];
                            }
                            $(".mb-booking-table-head")
                                .find(".mb-selected-date")
                                .text(dateFormatted[0]);
                            $(".mb-booking-table-head")
                                .find(".mb-month")
                                .text(month + " " + year);
                            $(".mb-booking-table-head")
                                .find(".mb-selected-day")
                                .text(day);
                        });
                        $(".mb-booking-table-body").html(slotHtml);
                    } else {
                        var slotHtml = "";
                        slotHtml =
                            '<div class="mb-no-booking">' +
                            data.msg +
                            "</div>";
                        $(".mb-booking-table-body").html(slotHtml);
                    }
                },
            });
        }
        $(document).on("click", ".mb-available-day", function (event) {
            if ($(this).hasClass("slot-available")) {
                var date = $(this).attr("data-date");
                $(
                    ".mb-calendar-container .mb-calendar-col .mb-available-day.active"
                ).removeClass("active");
                $(this).addClass("active");
                loadSlotsData(date);
            }
        });


        $(document).on("click", ".mb-next-cal", function (event) {
            var currentCalendar = $(this).parent().parent();
            currentCalendar.hide();
            currentCalendar.next().show();
        });

        $(document).on("click", ".mb-previous-cal", function (event) {
            var currentCalendar = $(this).parent().parent();
            currentCalendar.hide();
            currentCalendar.prev().show();
        });

        $(document).on("input", ".mb-qty", function (event) {
            var qtyBox = $(this);
            var regex = /^[0-9]*(?:\.\d{1,2})?$/; // allow only numbers [0-9]
            var qty = qtyBox.val();
            var id = qtyBox.attr("data-id");
            var currentId = qtyBox.attr("data-current-id");
            var slots = self.options.slots;
            var info = slots[id];
            var option = {};
            var cond = true;
            var updatedQty = qtyBox.next(".mb-qty-booked-hide").val();
            if (qty == 0) {
                cond = false;
                removeSelectedSlot(qtyBox, id);
                alert($t("Please enter a value greater than "));
                return false;
            } else if (!regex.test(qty) || qty == "") {
                cond = false;
                alert($t("Please enter a numeric value and is greater than 0"));
            } else if (
                cond &&
                (parseInt(info["qty"]) < qty ||
                    updatedQty >= parseInt(info["qty"]))
            ) {
                cond = false;
                alert($t("Quantity not available for this slot"));
                qtyBox.val(0);
            }

            if (cond && qty > 0) {
                $.each(self.options.options, function (k, v) {
                    if (v.title == "Booking From") {
                        option[v.id] = info["booking_from"];
                    }
                    if (v.title == "Booking Till") {
                        option[v.id] = info["booking_to"];
                    }
                });

                qtyBox.prev(".mb-booked-txt").text($t("Selected"));
                updatedQty = parseInt(qty);
                qtyBox.next(".mb-qty-booked-hide").val(updatedQty);

                var remainingQty = parseInt(info["qty"]);
                if (remainingQty >= parseInt(qty)) {
                    remainingQty -= parseInt(qty);
                    qtyBox
                        .parent()
                        .siblings(".mb-col.middle")
                        .find(".mb-avl-text")
                        .next()
                        .text(remainingQty);
                }

                if (self.options.booking_type == 2) {
                    var bookingFrom = info["booking_from"];
                    var bookingTo = info["booking_to"];
                } else {
                    var bookingFrom =
                        info["booking_from"].split(",")[1];
                    var bookingTo = info["booking_to"].split(",")[1];
                }

                if (
                    $(".mb-modal-foot")
                        .find(".booked-slot-summary")
                        .find("div[data-booked-slot-id=" + id + "]")
                        .length
                ) {
                    $(".mb-modal-foot")
                        .find(".booked-slot-summary")
                        .find("div[data-booked-slot-id=" + id + "]")
                        .children("span")
                        .text(
                            updatedQty +
                            " " +
                            $t(
                                "slot is selected for booking between"
                            ) +
                            " " +
                            bookingFrom +
                            " " +
                            $t("to") +
                            " " +
                            bookingTo
                        );
                    $(".mb-modal-foot")
                        .find(".booked-slot-summary")
                        .find("div[data-booked-slot-id=" + id + "]")
                        .children("input")
                        .val(updatedQty);
                } else {
                    $(".mb-modal-foot").find(".booked-slot-summary").empty();
                    $(".mb-modal-foot")
                        .find(".booked-slot-summary")
                        .prepend(
                            $("<div>")
                                .attr("data-booked-slot-id", id)
                                .addClass("booked-short-history")
                                .append(
                                    $("<input>")
                                        .attr("type", "hidden")
                                        .attr("name", "booked_qty")
                                        .val(updatedQty),
                                    $("<span>").text(
                                        updatedQty +
                                        " " +
                                        $t(
                                            "slot is selected for booking between"
                                        ) +
                                        " " +
                                        bookingFrom +
                                        " " +
                                        $t("to") +
                                        " " +
                                        bookingTo
                                    ),
                                    $("<a>").addClass("remove-slot")
                                )
                        );
                }
                $(".mb-slots-summary-wrapper").show();
            } else if (
                cond &&
                qty == 0 &&
                (event.keyCode == 8 || event.keyCode == 46)
            ) {
                removeSelectedSlot(qtyBox, id);
            }
        });

        function removeSelectedSlot(quantityBox, id) {
            if (
                $("body")
                    .find(".booked-slot-summary")
                    .find(
                        ".booked-short-history[data-booked-slot-id=" +
                        id +
                        "]"
                    ).length
            ) {
                if (quantityBox.length) {
                    var bookedQty = $("body")
                        .find(".booked-slot-summary")
                        .find(
                            ".booked-short-history[data-booked-slot-id=" +
                            id +
                            "]"
                        )
                        .children("input")
                        .val();
                    quantityBox.val(0);
                    quantityBox
                        .siblings(".mb-booked-txt")
                        .text($t("Your Need"));
                    quantityBox.siblings(".mb-qty-booked-hide").val(0);
                    var availableQty = quantityBox
                        .parent()
                        .siblings(".middle")
                        .find(".mb-label-avl-qty .mb-avl-text")
                        .next()
                        .text();
                    availableQty =
                        parseInt(availableQty) + parseInt(bookedQty);
                    if (availableQty >= 0) {
                        var availableQty = quantityBox
                            .parent()
                            .siblings(".middle")
                            .find(".mb-label-avl-qty .mb-avl-text")
                            .next()
                            .text(availableQty);
                    }
                }
                $("body")
                    .find(".booked-slot-summary")
                    .find(
                        ".booked-short-history[data-booked-slot-id=" +
                        id +
                        "]"
                    )
                    .remove();
                if (
                    $("body").find(".booked-slot-summary").is(":empty")
                ) {
                    $("body").find(".mb-slots-summary-wrapper").hide();
                }
            }
        }
        $(document).on("click", ".remove-slot", function (event) {
            var dicisionapp = confirm(
                $t("Are you Sure you Want To remove this slot")
            );
            if (dicisionapp == true) {
                var bookedSlotId = $(this)
                    .parent()
                    .data("booked-slot-id");
                var bookedQty = $(this).siblings("input").val();
                if (
                    $(".mb-day-container").find(
                        '.mb-qty[data-id="' + bookedSlotId + '"]'
                    ).length
                ) {
                    $(".mb-day-container")
                        .find('.mb-qty[data-id="' + bookedSlotId + '"]')
                        .val(0);
                    $(".mb-day-container")
                        .find('.mb-qty[data-id="' + bookedSlotId + '"]')
                        .siblings(".mb-booked-txt")
                        .text($t("Your Need"));
                    $(".mb-day-container")
                        .find('.mb-qty[data-id="' + bookedSlotId + '"]')
                        .siblings(".mb-qty-booked-hide")
                        .val(0);
                    var availableQty = $(".mb-day-container")
                        .find('.mb-qty[data-id="' + bookedSlotId + '"]')
                        .parent()
                        .siblings(".middle")
                        .find(".mb-label-avl-qty .mb-avl-text")
                        .next()
                        .text();
                    availableQty =
                        parseInt(availableQty) + parseInt(bookedQty);
                    if (availableQty >= 0) {
                        var availableQty = $(".mb-day-container")
                            .find(
                                '.mb-qty[data-id="' +
                                bookedSlotId +
                                '"]'
                            )
                            .parent()
                            .siblings(".middle")
                            .find(".mb-label-avl-qty .mb-avl-text")
                            .next()
                            .text(availableQty);
                    }
                }
                $(this).parent().remove();
                if ($(".booked-slot-summary").is(":empty")) {
                    $(".mb-slots-summary-wrapper").hide();
                }
            }
        });


        function setBookingLabel(element) {
            element
                .find(".action.tocart.primary")
                .attr("title", $t("Book Now"));
            element
                .find(".action.tocart.primary")
                .find("span")
                .text($t("Book Now"));
        }

        function showLoader() {
            $(".mb-box-modal-bg").show();
        }

        function hideLoader() {
            $(".mb-box-modal-bg").hide();
        }

        $(document).on("click", ".mb-book", function (event) {
            event.preventDefault();
            if (!$(".booked-slot-summary").is(":empty")) {
                var slots = self.options.slots;
                $.each(
                    $(".booked-slot-summary").find(
                        ".booked-short-history"
                    ),
                    function (k, v) {
                        $(this).data("booked-slot-id");
                        var qty = $(this).children("input").val();
                        var id = $(this).data("booked-slot-id");
                        var info = slots[id];
                        var option = {};
                        let formKey = $("#product_addtocart_form")
                            .find("input[name='form_key']")
                            .val();
                        $.each(self.options.options, function (k, v) {
                            if (v.title == "Booking From") {
                                option[v.id] = info["booking_from"];
                            }
                            if (v.title == "Booking Till") {
                                option[v.id] = info["booking_to"];
                            }
                        });
                        for (const key in option) {
                            $("#options_" + key + "_text").val(option[key]);
                        }
                        $("#product_composite_configure_input_qty").val(qty);
                        $('[data-role="action"]').trigger("click");
                    }
                );
            }
        });
    }

});