$(document).ready(function () {
    $('#customers').on('click', function () {
        $('li').removeClass('active');
        $('.customers').addClass('active');
        customerAll();
    });

    $('#reports').on('click', function () {
        $('li').removeClass('active');
        $('.reports').addClass('active');
        showGraphic();
    });
});

function showGraphic() {
    $.ajax({
        type: "GET",
        url: "/visit/graphic",
        success: function (data, textStatus) {
            var myChart = new FusionCharts({
                "type": "column2d",
                "renderAt": "main-panel",
                "dataSource": data,
                "width": "500",
                "height": "400"
            });
            myChart.render();
        }, error: function (error) {
            alertify.alert("Ha ocurrido un error: " + error.responseText + "<br> Ofrecemos nuestras disculpas, envianos un pantallazo del error al siguiente correo: desarrollo@infocliente.com.co, muchas gracias !!");
        }
    });
}

function customerAll() {
    $.ajax({
        type: "GET",
        url: "/customers",
        success: function (data, textStatus) {
            if (textStatus === 'success') {
                $('#main-panel').html(data);

                $('#customers_table').DataTable({
                    "order": [[0, "asc"]],
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                    }
                });

                $('.modaal-panel-visits').modaal({
                    type: 'ajax',
                    after_open: function () {
                        $('#customers_visits_table').DataTable({
                            "order": [[0, "asc"]],
                            "language": {
                                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                            }
                        });
                    }
                });

            }
        }, error: function (error) {
            alertify.alert("Ha ocurrido un error: " + error.responseText + "<br> Ofrecemos nuestras disculpas, envianos un pantallazo del error al siguiente correo: desarrollo@infocliente.com.co, muchas gracias !!");
        }
    });
}

function loadCountries(idCustomerCountry, idCustomerState, idCustomerCity) {

    var parameterCountryCustomerId = '';
    if (idCustomerCountry) {
        parameterCountryCustomerId = "/customer_country/" + idCustomerCountry;
    }

    $.ajax({
        type: "GET",
        url: "/countries" + parameterCountryCustomerId,
        success: function (data, textStatus) {
            if (textStatus === 'success') {
                $('#countries_select').html(data);

                if (idCustomerState) {
                    loadStates(idCustomerState, idCustomerCountry, '#states_select', '#cities_select');
                    if (idCustomerCity) {
                        loadCities(idCustomerCity, idCustomerState, '#cities_select');
                    }
                }

            }
        }, error: function (error) {
            alertify.alert("Ha ocurrido un error: " + error.responseText + "<br> Ofrecemos nuestras disculpas, envianos un pantallazo del error al siguiente correo: desarrollo@infocliente.com.co, muchas gracias !!");
        }
    });
}

function customerAdd(element) {

    var url = "/customer/add";
    var customerCountryId = "";
    var customerStateId = "";
    var customerCityId = "";


    if (element) {
        var id = element.dataset.id;
        customerCountryId = element.dataset.countryid;
        customerStateId = element.dataset.stateid;
        customerCityId = element.dataset.cityid;

        url += "/" + id;

    }

    $.ajax({
        type: "GET",
        url: url,
        success: function (data, textStatus) {
            if (textStatus === 'success') {
                $('#main-panel-modal').html(data);

                loadCountries(customerCountryId, customerStateId, customerCityId);

                $('#countries_select').on('change', function (e) {
                    var id = $('#countries_select').val();
                    loadStates('', id, '#states_select', '#cities_select');
                });

            }
        }, error: function (error) {
            alertify.alert("Ha ocurrido un error: " + error.responseText + "<br> Ofrecemos nuestras disculpas, envianos un pantallazo del error al siguiente correo: desarrollo@infocliente.com.co, muchas gracias !!");
        }
    });

}

function customerSave() {

    if ($('#customer-form').parsley().validate()) {

        var id = $('#id').val();
        var dni = $('#dni').val();
        var full_name = $('#full_name').val();
        var address = $('#address').val();
        var phone = $('#phone').val();
        var city = $('#cities_select').val();
        var quote = $('#quota').val().replace(" ", "").replace(".", "");
        var balance_quote = $('#balance_quota').val().replace(" ", "").replace(".", "");
        var percentage_visit = $('#percentage_visit').val().replace(" ", "").replace(",", ".");

        $.ajax({
            type: "POST",
            url: "/customer/save",
            data: {id: id, dni: dni, full_name: full_name, address: address, phone: phone, city: city, quota: quote, balance_quota: balance_quote, percentage_visit: percentage_visit},
            success: function (data, textStatus) {
                if (data === '') {
                    customerAll();
                    $('#myCustomerModal').modal('hide');
                    $('.modal-backdrop').remove();

                } else {
                    alertify.error("Ha ocurrido un error: <br>" + data, 1000000);
                    alertify.alert("Ha ocurrido un error: " + data + "<br> Ofrecemos nuestras disculpas, envianos un pantallazo del error al siguiente correo: desarrollo@infocliente.com.co, muchas gracias !!");
                }
            }, error: function (error) {
                alertify.alert("Ha ocurrido un error: " + error.responseText + "<br> Ofrecemos nuestras disculpas, envianos un pantallazo del error al siguiente correo: desarrollo@infocliente.com.co, muchas gracias !!");
            }
        });
    }
}

function erase(element) {

    var customerId = "";
    var customerFullName = "";

    if (element) {
        customerId = element.dataset.id;
        customerFullName = element.dataset.fullname;

    }

    alertify
            .okBtn("Aceptar")
            .cancelBtn("Cancelar")
            .confirm("¿Realmente deseas eliminar el cliente <b>" + customerFullName + "</b>?", function () {
                if (element && !isNaN(customerId)) {
                    $.ajax({
                        type: "DELETE",
                        url: "/customer/delete/" + customerId,
                        success: function (data, textStatus) {

                            if (data === "") {
                                alertify.success("El cliente " + customerFullName + " ha sido eliminado de la base de datos de manera exitosa.", 5000);
                                customerAll();
                            } else {
                                alertify.error("Ha ocurrido un error: <br>" + data, 1000000);
                                alertify.alert("Ha ocurrido un error: " + data + "<br> Ofrecemos nuestras disculpas, envianos un pantallazo del error al siguiente correo: desarrollo@infocliente.com.co, muchas gracias !!");
                            }

                        }, error: function (error) {
                            alertify.alert("Ha ocurrido un error: " + error.responseText + "<br> Ofrecemos nuestras disculpas, envianos un pantallazo del error al siguiente correo: desarrollo@infocliente.com.co, muchas gracias !!");
                        }
                    });

                }

            }, function () {
                // user clicked "cancel"
            });
}

function visitAdd(element) {

    var url = "/visit/add";

    if (element) {
        var id = element.dataset.id;
        url += "/customer/" + id;
    }

    $.ajax({
        type: "GET",
        url: url,
        success: function (data, textStatus) {
            $('#main-panel-modal-visit').html(data);
            $("#date").datepicker({minDate: -0, dateFormat: "yy-mm-dd"});

            $("#net_value").change(function () {
                var visit_value = $("#net_value").val() * $("#percentage_visit").val();
                console.log(visit_value);
                $('#visit_value').val(visit_value);
            });

            loadSellers();

        }, error: function (error) {
            alertify.alert("Ha ocurrido un error: " + error.responseText + "<br> Ofrecemos nuestras disculpas, envianos un pantallazo del error al siguiente correo: desarrollo@infocliente.com.co, muchas gracias !!");
        }
    });

}

function visitSave() {

    if ($('#visit-form').parsley().validate()) {

        var customer_id = $('#customer_id').val();
        var date = $('#date').val();
        var seller = $('#sellers_select').val();
        var net_value = $('#net_value').val();
        var visit_value = $('#visit_value').val();
        var comments = $('#comments').val();

        $.ajax({
            type: "POST",
            url: "/visit/save",
            data: {customer: customer_id, date: date, seller: seller, net_value: net_value, visit_value: visit_value, comments: comments},
            success: function (data) {

                if (data === '') {
                    customerAll();
                    $('#myVisitModal').modal('hide');
                    $('.modal-backdrop').remove();
                } else {
                    alertify.alert("Ha ocurrido un error: " + data + "<br> Ofrecemos nuestras disculpas, envianos un pantallazo del error al siguiente correo: desarrollo@infocliente.com.co, muchas gracias !!");
                    alertify.error("Ha ocurrido un error: <br>" + data, 1000000);
                }

            }, error: function (error) {
                alertify.alert("Ha ocurrido un error: " + error.responseText + "<br> Ofrecemos nuestras disculpas, envianos un pantallazo del error al siguiente correo: desarrollo@infocliente.com.co, muchas gracias !!");
            }
        });
    }

}

function loadStates(idCustomerState, idCountry, idSelectState, idSelectCity) {

    var parameterIdCustomerState = '';
    if (idCustomerState) {
        parameterIdCustomerState = "/customer_state/" + idCustomerState;
    }

    $.ajax({
        type: "GET",
        url: "/states/country/" + idCountry + parameterIdCustomerState,
        async: true,
        success: function (text)
        {
            $(idSelectState).html(text);

            $(idSelectState).on('change', function (e) {
                var idState = $(idSelectState).val();
                loadCities('', idState, idSelectCity);
            });

        }
    });
}

function loadCities(idCustomerCity, idState, idSelectCity) {

    var parameterIdCustomerCity = '';

    if (idCustomerCity) {
        parameterIdCustomerCity = "/customer_city/" + idCustomerCity;
    }

    $.ajax({
        type: "GET",
        url: "/cities/state/" + idState + parameterIdCustomerCity,
        async: true,
        success: function (text)
        {
            $(idSelectCity).html(text);
        }, error: function (error) {
            alertify.alert("Ha ocurrido un error: " + error.responseText + "<br> Ofrecemos nuestras disculpas, envianos un pantallazo del error al siguiente correo: desarrollo@infocliente.com.co, muchas gracias !!");
        }
    });
}

function loadSellers() {
    $.ajax({
        type: "GET",
        url: "/sellers",
        async: true,
        success: function (text)
        {
            $('#sellers_select').html(text);
        }, error: function (error) {
            alertify.alert("Ha ocurrido un error: " + error.responseText + "<br> Ofrecemos nuestras disculpas, envianos un pantallazo del error al siguiente correo: desarrollo@infocliente.com.co, muchas gracias !!");
        }
    });
}