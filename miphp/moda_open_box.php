<?php 
    ?>
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nueva Apertura</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label><u>Nota de Apertura</u></label>
            <textarea id="nota_apertura" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label><u>Monto de Apertura</u></label>
            <input id="monto_inicial" type="text" class="form-control" placeholder="Monto Inicial">
        </div>
    <div class="modal-footer">
        <button href="#" id="box_publish" onclick="box_publish()" type="button" class="btn btn-primary"><i class="fa fa-save"> </i> Guardar </button>
    </div>