function open_modal_galery() {
    window.open('upload.php', '_blank', 'location=yes,height=600,width=400,scrollbars=yes,status=yes');
}

//Linea -----------------------------------------------------
function linea(){
    $.ajax({
        url: "miphp/micart.php",
        dataType: "json",
        data: {"linea": true },
        success: function (response) {
            $.notify(response.message, "info");
            build_cart();
        }
    });
}