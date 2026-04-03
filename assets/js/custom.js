$(document).ready(function () {

    // kolicina +
    $(document).on('click', '.increment-btn', function (e) {
        e.preventDefault();
        var qtyInput = $(this).closest('.product_data').find('.input-qty');
        var value = parseInt(qtyInput.val(), 10);
        value = isNaN(value) ? 0 : value;

        if (value < 10) {
            value++;
            qtyInput.val(value);
            
            var prod_id_element = $(this).closest('.product_data').find('.prodId');
            if(prod_id_element.length > 0) {
                updateCartQuantity($(this));
            }
        }
    });

    // kolicina -
    $(document).on('click', '.decrement-btn', function (e) {
        e.preventDefault();
        var qtyInput = $(this).closest('.product_data').find('.input-qty');
        var value = parseInt(qtyInput.val(), 10);
        value = isNaN(value) ? 0 : value;

        if (value > 1) {
            value--;
            qtyInput.val(value);
            
            var prod_id_element = $(this).closest('.product_data').find('.prodId');
            if(prod_id_element.length > 0) {
                updateCartQuantity($(this));
            }
        }
    });

    // azuriranje korpe
    function updateCartQuantity(element) {
        var qty = element.closest('.product_data').find('.input-qty').val();
        var prod_id = element.closest('.product_data').find('.prodId').val();

        $.ajax({
            method: "POST",
            url: "functions/handleCart.php",
            data: {
                "prod_id": prod_id,
                "prod_qty": qty,
                "scope": "update"
            },
            success: function (response) {
                var res = $.trim(response);
                if(res == "200") {
                    // Ovo osvežava samo korpu, NE dira slike u listi želja
                    $('#mycart').load(location.href + " #mycart");
                }
            }
        });
    }

    // dodavanje u korpu
    $(document).on('click', '.addToCartBtn', function (e) {
        e.preventDefault();
        var qty = $(this).closest('.product_data').find('.input-qty').val();
        var prod_id = $(this).val();

        $.ajax({
            method: "POST",
            url: "functions/handleCart.php",
            data: {
                "prod_id": prod_id,
                "prod_qty": qty,
                "scope": "add"
            },
            success: function (response) {
                var res = $.trim(response); // OVO JE BITNO DA BI IF RADIO
                if (res == "200") {
                    alertify.success("Proizvod dodat u korpu.");
                } else if (res == "existing") {
                    alertify.warning("Proizvod je već u korpi.");
                } else if (res == "401") {
                    alertify.error("Ulogujte se da biste nastavili.");
                } else {
                    alertify.error("Nešto nije u redu.");
                }
            }
        });
    });

    // brisanje iz korpe
    $(document).on('click', '.deleteItem', function (e) {
        e.preventDefault();
        var cart_id = $(this).val();
        
        $.ajax({
            method: "POST",
            url: "functions/handleCart.php",
            data: {
                "cart_id": cart_id,
                "scope": "delete"
            },
            success: function (response) {
                var res = $.trim(response);
                if (res == "200") {
                    alertify.success("Proizvod uklonjen.");
                    // OVO OSVEŽAVA SADRŽAJ KORPE BEZ REFRESHA STRANICE
                    $('#mycart').load(location.href + " #mycart");
                } else {
                    alertify.error("Greška: " + res);
                }
            }
        });
    });

    // dodavanje u listu zelja
    $(document).on('click', '.addToWishList', function (e) {
        e.preventDefault();
        var prod_id = $(this).val();

        $.ajax({
            method: "POST",
            url: "functions/handleWishList.php",
            data: {
                "prodId": prod_id,
                "scope2": "add"
            },
            success: function (response) {
                var res = $.trim(response);
                if (res == "200") {
                    alertify.success("Proizvod dodat u listu želja.");
                } else if (res == "existing") {
                    alertify.warning("Proizvod je već u listi želja.");
                } else if (res == "401") {
                    alertify.error("Ulogujte se da biste nastavili.");
                }
            }
        });
    });

    // brisanje iz liste zelja
    $(document).on('click', '.delItem', function (e) {
        e.preventDefault();
        var id = $(this).val();

        $.ajax({
            method: "POST",
            url: "functions/handleWishList.php",
            data: {
                "id": id,
                "scope2": "delete"
            },
            success: function (response) {
                if ($.trim(response) == "200") {
                    alertify.success("Proizvod uklonjen.");
                    $('#mywishlist').load(location.href + " #mywishlist");
                }
            }
        });
    });

    // potvrda narudzbine
    $(document).on('click', '.placeOrderBtn', function (e) {
        var form = $(this).closest('form')[0];
        
        if (form.checkValidity()) {
            $(this).attr('disabled', true);
            $(this).html('<i class="fa fa-spinner fa-spin"></i> Obrađujem...');
            form.submit();
        }
    });

});
