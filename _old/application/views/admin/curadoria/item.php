<script type="text/javascript">
$(document).ready(function($) {
    $('#status').val('<?php echo $item->status?>');
});
</script>
<div class="row-fluid">
    <div class="box span12">
        <div class="box-header well" data-original-tile >
            <h2><i class="icon-edit"></i> Editar projeto</h2>
        </div>

        <!-- status -->
        <div class="span12">
            <legend>Status</legend>
            <table class="table table-bordered table-striped ">
                <thead>
                    <tr >
                        <th>Data</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($item_statuses as $item_status) { ?>
                    <tr>
                        <td><?php echo  $item_status->create_date ?></td>
                        <td><?php echo  disponibility_status_to_literal($item_status->status) ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div> <!-- /status -->

        <div class="box-content">

            <form action="" class="form-horizontal" method="post">
                <div class="span6">
                    <fieldset>

                        <legend>
                            <?php echo  "{$item->name} - {$item->user->name}" ?>
                        </legend>

                        <!-- name -->
                        <div class="control-group">
                            <label class="control-label" for="name">Nome</label>
                            <div class="controls">
                                <input type="text" id="name" name="name" value="<?php echo  $item->name ?>"/>
                            </div>
                        </div>

                        <!-- description -->
                        <div class="control-group">
                            <label class="control-label" for="description">Descrição</label>
                            <div class="controls">
                                <textarea id="description" name="description" ><?php echo  $item->description ?></textarea>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="category">Categoria:</label>
                            <div class="controls">
                                <?php echo  form_dropdown('category', $categories, set_value('category', @$item->category_id)) ?>
                            </div>
                        </div>

                        <!-- variations -->
                        <div id="variations">
                            <legend>Medidas</legend>
                            <div id="measurements_template">
                                <?php foreach ($item->item_variation_measurement->get() as $key => $measurement): ?>
                                    <fieldset>
                                            <div class="control-group">
                                                <label class="control-label" for="width">Largura</label>
                                                <div class="controls">
                                                    <input type="text" name="measurements[width][]"  value="<?php echo  $measurement->width ?>">
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label" for="height">Altura</label>
                                                <div class="controls">
                                                    <input type="text" name="measurements[height][]"  value="<?php echo  $measurement->height ?>">
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label" for="depth">Profundidade</label>
                                                <div class="controls">
                                                    <input type="text" name="measurements[depth][]"  value="<?php echo  $measurement->depth ?>">
                                                </div>
                                                <div class="controls">
                                                    <a class="btn btn-mini variations_remove_current"><ico class="icon-minus-sign"></ico>&nbsp;Medida</a>
                                                </div>
                                            </div>
                                    </fieldset>
                                <?php endforeach ?>
                                <fieldset class="measurements_default">
                                            <div class="control-group">
                                                <label class="control-label" for="width">Largura</label>
                                                <div class="controls">
                                                    <input type="text" name="measurements[width][]" >
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label" for="height">Altura</label>
                                                <div class="controls">
                                                    <input type="text" name="measurements[height][]" >
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label" for="depth">Profundidade</label>
                                                <div class="controls">
                                                    <input type="text" name="measurements[depth][]" >
                                                </div>
                                                <div class="controls">
                                                    <a class="btn btn-mini variations_remove_current"><ico class="icon-minus-sign"></ico>&nbsp;Medida</a>
                                                </div>
                                            </div>
                                    </fieldset>
                            </div>
                            <div class="controls variations_controls">
                                <div class="control-group">
                                    <div id="variations_add" ><a id="measurements_add" class="btn btn-mini"><ico class="icon-plus-sign"></ico>&nbsp;Medida</a></div>
                                </div>
                            </div>

                            <legend>Materiais</legend>
                            <div id="materials_template">
                                <?
                                foreach ($item->item_variation_material->get() as $key => $material) {
                                    ?>
                                    <fieldset>
                                            <div class="control-group">
                                                <label class="control-label" for="material">Material</label>
                                                <div class="controls">
                                                    <input type="text" name="materials[]"  value="<?php echo  $material->material ?>">
                                                </div>
                                                <div class="controls">
                                                    <a class="btn btn-mini variations_remove_current"><ico class="icon-minus-sign"></ico>&nbsp;Material</a>
                                                </div>
                                            </div>
                                    </fieldset>
                                    <?
                                }
                                ?>
                                <fieldset class="materials_default">
                                        <div class="control-group">
                                            <label class="control-label" for="material">Material</label>
                                            <div class="controls">
                                                <input type="text" name="materials[]" >
                                            </div>
                                            <div class="controls">
                                                <a class="btn btn-mini variations_remove_current"><ico class="icon-minus-sign"></ico>&nbsp;Material</a>
                                            </div>
                                        </div>
                                </fieldset>
                            </div>
                            <div class="controls variations_controls">
                                <div class="control-group">
                                    <div id="variations_add" ><a id="materials_add" class="btn btn-mini"><ico class="icon-plus-sign"></ico>&nbsp;Material</a></div>
                                </div>
                            </div>
                        </div>

                        <!-- rating -->
                        <fieldset>
                            <legend>Avaliação</legend>
                            <div class="control-group">
                                <label class="control-label" for="status">Status</label>
                                <div class="controls">
                                    <select name="status" id="status">
                                        <option value="0" ?> Novo</option>
                                        <option value="1" ?> Aprovado</option>
                                        <option value="2" ?> Rejeitado</option>
                                    </select>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="status">Atualizar o Status:</label>
                                <div class="controls">
                                    <input type="hidden" name="is_status" value="0">
                                    <input type="checkbox" name="is_status" value="1">
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="status">Enviar E-Mail:</label>
                                <div class="controls">
                                    <input type="hidden" name="sendmail" value="0">
                                    <input type="checkbox" name="sendmail" value="1">
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="avaliation">Motivo</label>
                                <div class="controls">
                                    <select name="avaliation_id" id="avaliation_id">
                                        <option value=""></option>
                                        <?php foreach ($avaliation_texts as $key => $avaliation): ?>
                                            <option value="<?php echo $avaliation->id?>" data-text="<?php echo  $avaliation->text ?>">
                                                <?php echo  $avaliation->avaliation ?>
                                            </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="message">Mensagem</label>
                                <div class="controls">
                                    <textarea name="message" id="avaliation-message"></textarea>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Salvar</button>
                            </div>
                        </fieldset> <!-- /rating -->

                    </fieldset>
                </div>

                <div class="span6">
                    <fieldset>
                        <legend>Imagens</legend>
                        <div data-target="#modal-gallery" data-toggle="modal-gallery" id="gallery">
                            <div class="control-group">

                                <figure class="upload-frame" style="margin: 0; padding: 0;">
                                  <span id="dropbox" class="frame" style="display: block; width: 400px; height: 100px; margin-left: 0; border: solid 1px #ccc;" ></span>
                                </figure>

                                <div id="message"></div>

                                <ul id="thumbnails" class="thumbnails"></ul>

                            </div>
                        </div>
                    </fieldset>
                </div>
            </form>
        </div>

    </div>
</div>
