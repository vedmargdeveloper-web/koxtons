$(document).ready(function () {
    // Initialize arrays to store product IDs
    var mobileProductsOrder = [];
    var desktopProductsOrder = [];

    // Function to remove duplicates from an array
    function removeDuplicates(array) {
        return array.filter((item, index) => array.indexOf(item) === index);
    }

    // Remove duplicates from previously stored mobile products
    var storedMobileProducts = $(".input-mobile-products_id").val().split(",");
    mobileProductsOrder = removeDuplicates(storedMobileProducts).filter(
        (id) => id !== ""
    );

    // Remove duplicates from previously stored desktop products
    var storedDesktopProducts = $(".input-desktop-products_id")
        .val()
        .split(",");
    desktopProductsOrder = removeDuplicates(storedDesktopProducts).filter(
        (id) => id !== ""
    );

    // Enable drag-and-drop functionality for box-items
    $(".box-item").draggable({
        cursor: "move",
        helper: "clone",
    });

    // Droppable for mobile products
    $("#container2").droppable({
        drop: function (event, ui) {
            var itemid = $(ui.draggable).attr("itemid");
            if (!mobileProductsOrder.includes(itemid)) {
                $(ui.draggable).appendTo("#container2");
                mobileProductsOrder.push(itemid);
            }
        },
    });

    // Droppable for desktop products
    $("#container22").droppable({
        drop: function (event, ui) {
            var itemid = $(ui.draggable).attr("itemid1");
            if (!desktopProductsOrder.includes(itemid)) {
                $(ui.draggable).appendTo("#container22");
                desktopProductsOrder.push(itemid);
            }
        },
    });

    // Update hidden input fields with ordered product IDs
    $(".btn-done-order-mobile").on("click", function (e) {
        e.preventDefault();
        $(".input-mobile-products_id").val(mobileProductsOrder.join(","));
    });

    $(".btn-done-order-desktop").on("click", function (e) {
        e.preventDefault();
        $(".input-desktop-products_id").val(desktopProductsOrder.join(","));
    });

    // Ensure only one item is dropped at a time
    $("#container1, #container11").droppable({
        tolerance: "pointer",
        drop: function (event, ui) {
            $(ui.draggable).appendTo($(this));
        },
    });
});
