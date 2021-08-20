<?php 
    ?>
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nuevo Cliente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label><u>Correo</u></label>
            <input id="user_email" type="text" class="form-control" placeholder="user_email">
        </div>
        <div class="form-group">
            <label><u>Primer Nombre</u></label>
            <input id="first_name" type="text" class="form-control" placeholder="first_name">
        </div>
        <div class="form-group">
            <label><u>Segundo Nombre</u></label>
            <input id="last_name" type="text" class="form-control" placeholder="last_name">
        </div>
        <div class="form-group">
            <label><u>Telefono</u></label>
            <input id="billing_phone" type="text" class="form-control" placeholder="billing_phone">
        </div>
        
        <div class="form-group">
            <label><u>Nit o Carnet</u></label>
            <input id="billing_postcode" type="text" class="form-control" placeholder="billing_postcode">
        </div>
    <div class="modal-footer">
        <button href="#" id="box_publish" onclick="customer_store()" type="button" class="btn btn-primary"><i class="fa fa-save"> </i> Guardar </button>
    </div>