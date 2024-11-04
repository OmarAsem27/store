(function ($) {
    $(".item-quantity").on("change", function (e) {
        $.ajax({
            url: "/cart/" + $(this).data("id"),
            method: "put",
            data: {
                quantity: $(this).val(),
                _token: csrf_token,
            },
        })
            .done(function (response) {
                console.log("Quantity updated successfully:", response);
            })
            .fail(function (xhr, status, error) {
                console.error(
                    "Failed to update quantity:",
                    xhr.responseText || error
                );
            });
        // $(this).css("border", "5px solid red");
    });
    $(".remove-item").on("click", function (e) {
        let id = $(this).data("id");
        $.ajax({
            url: "/cart/" + id,
            method: "delete",
            data: {
                _token: csrf_token,
            },
        })
            .done(function (response) {
                $("#" + id).remove();
                console.log("Quantity updated successfully:", response);
            })
            .fail(function (xhr, status, error) {
                console.error(
                    "Failed to update quantity:",
                    xhr.responseText || error
                );
            });
        // $(this).css("border", "5px solid red");
    });
})(jQuery);
